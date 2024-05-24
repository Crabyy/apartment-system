<template>
  <div class="admin-profile-container bg-gray-800 rounded-lg text-white border-1 text-lg">
    <!-- My Profile Section -->
    <div class="my-profile">
      <h2 class="ml-[10px] text-[40px] pb-7 text-bold">My Profile</h2>
      <!-- Circular Image -->

      <!-- Name, Age, Position -->
      <div class="profile-details text-[20px] pl-[20px] pb-[10px]">
        <p class="pb-[5px]">Name: {{ profileName }}</p>
        <p class="pb-[5px]">Age: {{ age }}</p>
      </div>
      <!-- Horizontal Rule -->
      <hr class="my-auto border-[2px] rounded-lg" />
    </div>

    <!-- Two Column Information -->
    <div class="two-column-info">
      <!-- First Column: Given name, Middle name, Surname, Birthdate, Gender -->
      <div class="column">
        <p class="pb-[5px]">Email: {{ email }}</p>
        <p class="pb-[5px]">Username: {{ username }}</p>
        <p class="pb-[5px]">Birthdate: {{ birthdate }}</p>
        <p class="pb-[5px]">Gender: {{ gender }}</p>
      </div>

      <!-- Second Column: Email, Username, Password, Contact number -->
      <div class="column">
        <div class="flex items-center pb-5">
          <label for="password" class="pr-2 font-medium text-gray-900 dark:text-white">Password:</label>
          <button id="toggleModalBtn" class="text-blue-700 font-medium text-sm underline focus:outline-none" type="button"
            @click="showModal">
            Change Password
          </button>
        </div>
        <p class="pb-[5px]">Contact Number: {{ contactNumber }}</p>
      </div>
    </div>
  </div>

  <!-- Main modal -->
  <div id="authentication-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="modal-content relative p-4 w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4">
          <h3 class="text-2xl font-semibold text-gray-900 dark:text-black">
            Change Password
          </h3>
          <button type="button"
            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="authentication-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          <form class="space-y-4" @submit.prevent="changePassword">
            <div>
              <input v-model="currentPassword" type="password" name="currentPassword" id="currentPassword"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black"
                placeholder="Current Password" required />
            </div>
            <div>
              <input v-model="newPassword" type="password" name="newPassword" id="newPassword" placeholder="New Password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black"
                required />
            </div>
            <div>
              <input v-model="confirmPassword" type="password" name="confirmPassword" id="confirmPassword"
                placeholder="Confirm Password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black"
                required />
            </div>

            <button type="submit"
              class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch, onMounted } from 'vue';
import { simulateLogin } from '../../router/auth'; // Adjust the path accordingly


export default {
  name: "AdminProfile",
  data() {
    return {
      profileName: "", // Add this line
      age: null, // Add other properties with default values
      email: "",
      username: "",
      birthdate: "",
      gender: "",
      contactNumber: "",
      // Other profile properties...
      currentPassword: "",
      newPassword: "",
      confirmPassword: "",
      profileData: {},
    };
  },
  methods: {

    showModal() {
      document.getElementById("authentication-modal").classList.remove("hidden");
    },

    hideModal() {
      document.getElementById("authentication-modal").classList.add("hidden");
    },

    closeModal() {
      this.hideModal();
    },

    changePassword() {
      console.log("Changing password...");
      this.currentPassword = "";
      this.newPassword = "";
      this.confirmPassword = "";
      this.hideModal();
    },

    async fetchUserData() {
      try {
        // Fetch user data from your API endpoint
        const response = await fetch('http://localhost/system/database/include/user/profile_inc.php', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          },
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const userData = await response.json();

        // Update the component's data properties with the fetched data
        this.profileName = `${userData.surname}, ${userData.givenname} ${userData.middlename}`;
        this.age = calculateAge(userData.birthdate);
        this.email = userData.email;
        this.username = userData.username;
        this.birthdate = userData.birthdate;
        this.gender = userData.gender;
        this.contactNumber = userData.contactnumber;
      } catch (error) {
        console.error('Error fetching user data:', error);
        // Handle the error as needed
      }
    },
  },

  mounted() {
    // Simulate login for a user (replace 'user' with the actual user role)
    simulateLogin('user');

    // Attach event listener to the button to toggle the modal
    document.getElementById("toggleModalBtn").addEventListener("click", this.showModal);

    // Attach event listener to the close button inside the modal
    document.querySelector('[data-modal-hide="authentication-modal"]').addEventListener("click", this.closeModal);

    // Fetch user data when the component is mounted
    this.fetchUserData();
  },
};

function calculateAge(birthdate) {
  // Add your logic to calculate age based on birthdate
  return 30; // Replace with actual calculation
}
</script>

<style scoped>
/* Add your styling for the component here */
.admin-profile-container {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  padding: 50px;
  height: 85vh;
}

.my-profile {
  align-items: center;
  margin-top: 10px;
}

.two-column-info {
  display: flex;
  padding: 10px 0 0 20px;
}

.column {
  width: 40%;
}

.admin-profile-container {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  padding: 50px;
  height: 85vh;
}

.my-profile {
  align-items: center;
  margin-top: 10px;
}

.two-column-info {
  display: flex;
  padding: 10px 0 0 20px;
}

.column {
  width: 40%;
}

/* Center the modal */
#authentication-modal {
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  width: 100%;
  /* Adjust the width as needed */
}
</style>
