<template>
  <div class="admin-profile-container bg-gray-800 rounded-lg text-white border-1 text-lg">
    <!-- My Profile Section -->
    <div class="my-profile">
      <h2 class="ml-[10px] text-[40px] pb-7 text-bold">My Profile</h2>
      <!-- Circular Image -->

      <!-- Name, Age -->
      <div class="profile-details text-[20px] pl-[20px] flex-col">
        <p class="pb-[5px]">
          Name: {{ userData.surname }}, {{ userData.givenname }} {{ userData.middlename }}
        </p>
        <p class="pb-[5px]">Age: {{ userAge }}</p>
      </div>

      <div class="flex items-center justify-between mt-6 pb-4" v-if="userType === 'user'">
        <button type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 ml-auto w rounded-lg focus:outline-none focus:shadow-outline"
          @click.prevent="openModal">
          Edit Profile
        </button>
      </div>

      <EditProfile ref="ProfileEditModal" @profile-updated="updateProfileData" />

      <!-- Horizontal Rule -->
      <hr class="my-auto border-[2px] rounded-lg" />
    </div>

    <!-- Two Column Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-2">
      <!-- First Column: Given name, Middle name, Surname, Birthdate, Gender -->
      <div class="p-4">
        <p class="pb-2">Birthdate: {{ birthDate }} </p>
        <p class="pb-2">Gender: {{ userData.gender }}</p>
        <p>Email: {{ userData.email }}</p>
      </div>

      <!-- Second Column: Email, Username, Password, Contact number -->
      <div class="p-2 md:p-2">
        <p class="pb-2">Username: {{ userData.username }}</p>
        <div class="flex items-center">
          <label for="password" class="pr-2 font-medium text-gray-900 dark:text-white">Password:</label>
          <button id="toggleModalBtn" class="text-blue-700 font-mediumunderline focus:outline-none" type="button"
            @click="showModal">
            Change Password
          </button>
        </div>
        <p class="text-lg pt-1" v-if="userType === 'user'">Contact Number: {{ userData.contactnumber }}</p>
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
          <form class="space-y-4" action="#" @submit.prevent="changePassword">

            <div class="relative">
              <input :type="showPassword ? 'text' : 'password'" v-model="currentPassword" name="Current Password"
                id="Current Password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:border-gray-500 dark:placeholder-gray-400"
                placeholder="Current Password" />
              <div v-if="passwordError" class="text-red-500 mt-1">
                {{ passwordError }}
              </div>
              <i v-if="!showPassword" @click="togglePasswordVisibility"
                class="fas fa-eye-slash absolute top-3 right-2 text-gray-500 cursor-pointer"></i>
              <i v-if="showPassword" @click="togglePasswordVisibility"
                class="fas fa-eye absolute top-3 right-2 text-gray-500 cursor-pointer"></i>
            </div>

            <div class="relative">
              <input :type="showNewPassword ? 'text' : 'password'" v-model="newPassword" name="New password"
                id="New password" placeholder="New Password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:border-gray-500 dark:placeholder-gray-400" />
              <div v-if="newPasswordError" class="text-red-500 mt-1">
                {{ newPasswordError }}
              </div>
              <i v-if="!showNewPassword" @click="toggleNewPasswordVis"
                class="fas fa-eye-slash absolute top-3 right-2 text-gray-500 cursor-pointer"></i>
              <i v-if="showNewPassword" @click="toggleNewPasswordVis"
                class="fas fa-eye absolute top-3 right-2 text-gray-500 cursor-pointer"></i>
            </div>

            <div class="relative">
              <input :type="showReNewPassword ? 'text' : 'password'" v-model="confirmNewPassword" name="Confirm password"
                id="Confirm password" placeholder="Confirm Password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:border-gray-500 dark:placeholder-gray-400" />
              <div v-if="confirmNewPasswordError" class="text-red-500 mt-1">
                {{ confirmNewPasswordError }}
              </div>
              <i v-if="!showReNewPassword" @click="toggleReNewPasswordVis"
                class="fas fa-eye-slash absolute top-3 right-2 text-gray-500 cursor-pointer"></i>
              <i v-if="showReNewPassword" @click="toggleReNewPasswordVis"
                class="fas fa-eye absolute top-3 right-2 text-gray-500 cursor-pointer"></i>
            </div>
            <div class="flex justify-end">
              <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Submit
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import EditProfile from "../pages/EditProfile.vue";

export default {
  name: "ProfileComponent",
  components: {
    EditProfile,
  },
  data() {
    return {
      showPassword: false,
      showNewPassword: false,
      showReNewPassword: false,

      passwordError: null,
      newPasswordError: null,
      confirmNewPasswordError: null,

      profileName: "",
      age: "",
      givenName: "",
      middleName: "",
      surname: "",
      birthdate: "",
      gender: "",
      email: "",
      username: "",
      contactNumber: "",

      currentPassword: "",
      newPassword: "",
      confirmNewPassword: "",
    };
  },

  methods: {
    // Function to show the modal
    showModal() {
      document
        .getElementById("authentication-modal")
        .classList.remove("hidden");
    },
    // Function to hide the modal
    hideModal() {
      document.getElementById("authentication-modal").classList.add("hidden");
    },
    // Function to close the modal
    closeModal() {
      this.hideModal();

      this.currentPassword = "";
      this.newPassword = "";
      this.passwordError = null;
    },
    openModal() {
      // Access the RegisterModal component using the ref and call its openModal method
      this.$refs.ProfileEditModal.openModal();
    },

    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },

    toggleNewPasswordVis() {
      this.showNewPassword = !this.showNewPassword;
    },
    toggleReNewPasswordVis() {
      this.showReNewPassword = !this.showReNewPassword;
    },

    validatePassword() {
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.$!%*?&,]).{8,}$/;

      if (!passwordRegex.test(this.newPassword)) {
        if (this.newPassword.length < 8) {
          this.newPasswordError = 'Password must be at least 8 characters long.';
        } else {
          this.newPasswordError = 'Use a strong password with at least one lowercase letter, uppercase letter, number, and special character.';
        }
        return false;
      }
      // Check if the new password and confirm new password match
      if (this.newPassword !== this.confirmNewPassword) {
        this.confirmNewPasswordError = 'Password does not match.';
        return false;
      }

      this.newPasswordError = '';
      this.confirmNewPasswordError = '';
      return true;
    },

    async changePassword() {

      if (!this.validatePassword()) {
        return; // Stop the process if the password is not valid
      }

      try {
        const response = await axios.post("http://localhost/system-main/database/include/pass_inc.php", {
          id: this.userData.id,
          currentPassword: this.currentPassword,
          newPassword: this.newPassword,
          userType: this.userType,
        });

        if (response.data.success) {
          // Password changed successfully, you can handle this as needed
          console.log("Password changed successfully");
          this.hideModal();

          this.currentPassword = "";
          this.newPassword = "";
          this.passwordError = null;
        } else {
          // Handle the case where password change was not successful
          console.error(response.data.message);
          this.passwordError = "Current Password is not correct.";
          return false;
        }
      } catch (error) {
        console.error("An error occurred", error);
        this.passwordError = "An error occurred while changing the password.";
      }
    },

    updateProfileData() {
      const updatedUserData = sessionStorage.getItem("userData");
      if (updatedUserData) {
        this.userData = JSON.parse(updatedUserData);
        sessionStorage.setItem("userData", updatedUserData);
      }
    },

  },

  computed: {
    userData() {
      const userData = sessionStorage.getItem("userData");
      return userData ? JSON.parse(userData) : null;
    },

    userType() {
      return sessionStorage.getItem("userType");
    },
    userAge() {
      if (this.userData && this.userData.birthdate) {
        const birthYear = new Date(this.userData.birthdate).getFullYear();
        const currentYear = new Date().getFullYear();
        return currentYear - birthYear;
      }
      return "";
    },
    birthDate() {
      if (this.userData && this.userData.birthdate) {
        const options = { month: "long", day: "numeric", year: "numeric" };
        return new Date(this.userData.birthdate).toLocaleDateString(undefined, options);
      }
      return "";
    },
  },

  mounted() {
    // Attach event listener to the button to toggle the modal
    document
      .getElementById("toggleModalBtn")
      .addEventListener("click", this.showModal);

    // Attach event listener to the close button inside the modal
    document
      .querySelector('[data-modal-hide="authentication-modal"]')
      .addEventListener("click", this.closeModal);
  },
};
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
  justify-content: center;
}

.column {
  width: 100%;
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
  width: 43%;
}

/* Center the modal */
#authentication-modal {
  display: flex;
  justify-content: center;
  align-items: center;
}

@media screen and (max-width: 768px) {
  .column {
    width: 100%;
    /* Set the width to 100% for all screen sizes */
  }
}
</style>
