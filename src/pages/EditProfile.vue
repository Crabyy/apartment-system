<template>
  <div v-if="showModal" class="fixed inset-0 z-50 overflow-auto bg-smoke-dark flex">
    <div class="relative p-8 bg-white w-full max-w-2xl m-auto flex-col flex rounded-lg shadow-lg" style="color: black;">
      <button @click="closeModal" class="absolute top-0 right-0 p-4">
        <svg class="fill-current text-grey" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
          <path d="M0 0h24v24H0z" fill="none" />
          <path
            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
        </svg>
      </button>
      <div class="text-center">
        <h2 class="text-3xl text-blue-700 font-bold">EDIT PROFILE</h2>
      </div>
      <form @submit.prevent="editProfile" class="flex flex-wrap">
        <div class="w-full sm:w-1/2">
          <!-- Fields for the first column -->

          <div class="mt-3 relative">
            <input type="text" v-model="givenname" id="givenname" name="givenname" placeholder="Given Name"
              @change="validateName(givenname, 'GivenName')"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg">
            <i class="fa-solid fa-user absolute top-3 left-2 text-gray-500"></i>
            <div v-if="errors.givenname" class="text-red-500 text-sm mt-1 text-left ml-3">{{
              errors.givenname }}</div>
          </div>

          <div class="mt-3 relative">
            <input type="text" v-model="middlename" id="middlename" name="middlename" placeholder="Middle Name"
              @change="validateName(middlename, 'MiddleName')"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg">
            <i class="fa-solid fa-user absolute top-3 left-2 text-gray-500"></i>
            <div v-if="errors.middlename" class="text-red-500 text-sm mt-1 text-left ml-3">{{
              errors.middlename }}</div>
          </div>

          <div class="mt-3 relative">
            <input type="text" v-model="surname" id="surname" name="surname" placeholder="Surname"
              @change="validateName(surname, 'Surname')"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg">
            <i class="fa-solid fa-user absolute top-3 left-2 text-gray-500"></i>
            <div v-if="errors.surname" class="text-red-500 text-sm mt-1 text-left ml-3">{{
              errors.surname }}</div>
          </div>

          <div class="mt-3 relative">
            <input type="text" v-model="email" id="Email" placeholder="Email" @change="validateEmail"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" />
            <i class="fa-solid fa-envelope absolute top-3 left-2 text-gray-500"></i>
            <div v-if="errors.emailError" class="text-red-500 text-sm mt-1 text-left ml-3">{{
              errors.emailError }}</div>
          </div>

          <div class="mt-3 relative">
            <input type="text" v-model="username" id="username" placeholder="Username" @change="validateUsername"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" />
            <i class="fa-solid fa-user absolute top-3 left-2 text-gray-500"></i>
            <div v-if="errors.username" class="text-red-500 text-sm mt-1 text-left ml-3">
              {{ errors.username }}</div>
          </div>

        </div>
        <div class="w-full sm:w-1/2 pl-4">
          <!-- Fields for the second column -->

          <div class="mt-3 relative">
            <input type="text" v-model="contactnumber" id="contactnumber" @change="validateContactNumber"
              placeholder="Contact Number"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" />
            <i class="fa-solid fa-mobile-screen absolute top-3 left-2 text-gray-500"></i>
            <div v-if="errors.contactnumber" class="text-red-500 text-sm mt-1 text-left ml-3">{{
              errors.contactnumber }}</div>
          </div>

          <div class="mt-3 relative">
            <input type="date" v-model="birthdate" id="birthdate" @change="validateBirthdate"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg text-gray-400" />
            <i class="fa-solid fa-calendar absolute top-3 left-2 text-gray-500"></i>
            <div v-if="errors.birthdateError" class="text-red-500 text-sm mt-1 text-left ml-3">{{
              errors.birthdateError }}</div>
          </div>

          <div class="mt-3 relative">
            <label for="gender" class="block text-base text-left font-medium text-gray-700 mb-2 ml-3">Choose
              Gender</label>
            <div class="flex items-center">
              <div class="flex items-center">
                <label class="inline-flex items-center">
                  <i class="fa-solid fa-mars text-gray-500 mr-4 mt-1 text-sm"></i>
                  <input type="radio" v-model="gender" id="male" name="gender" value="Male"
                    class="form-radio h-5 w-5 text-blue-500">
                  <span class="ml-2 text-sm">Male</span>
                </label>
                <label class="inline-flex items-center ml-6">
                  <i class="fa-solid fa-venus text-gray-500 mr-4 mt-1 text-sm"></i>
                  <input type="radio" v-model="gender" id="female" name="gender" value="Female"
                    class="form-radio h-5 w-5 text-pink-500">
                  <span class="ml-2 text-sm">Female</span>
                </label>
              </div>
            </div>
          </div>

        </div>

        <div class="flex items-center justify-between mt-6">
          <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 ml-auto w rounded-lg focus:outline-none focus:shadow-outline">
            Submit
          </button>
        </div>
      </form>

    </div>

    <!-- Modal for Success Handling -->
    <div v-if="sucModal" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div
            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div
                  class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                  <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                  </svg>
                </div>
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                  <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Succesfully Edited
                  </h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500">You can now go back.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
              <button type="button" @click="backTo"
                class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto">Go
                Back</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "EditProfile",

  data() {
    return {
      showModal: false,
      sucModal: false,

      givenname: '',
      middlename: '',
      surname: '',
      email: "",
      username: "",
      contactnumber: "",
      birthdate: "",
      gender: "",

      errors: {
        givenname: '',
        middlename: '',
        surname: '',
        username: '',
        emailError: '',
        contactnumber: '',
        birthdateError: '',
      },

    };
  },

  methods: {
    openModal() {
      this.showModal = true;
    },

    closeModal() {
      this.showModal = false;
    },

    validateName(name, fieldName) {
      const nameRegex = /^[a-zA-Z\sñÑ]+$/; // Allow letters, spaces, and "ñ" characters
      if (!nameRegex.test(name.trim())) {
        this.errors[fieldName.toLowerCase()] = `Invalid ${fieldName}`;
        return false;
      }
      this.errors[fieldName.toLowerCase()] = '';
      return true;
    },

    validateEmail() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!emailRegex.test(this.email.trim())) {
        // console.log('Invalid email format')
        this.errors.emailError = 'Please enter a valid Email'
        return false
      }
      this.errors.emailError = ''
      return true
    },

    validateUsername() {
      const usernameRegex = /^[a-zA-Z0-9_]+$/
      if (!usernameRegex.test(this.username.trim())) {
        // console.log('Invalid username format')
        this.errors.username = 'Invalid Username'
        return false
      }
      this.errors.username = ''
      return true
    },

    validateContactNumber() {
      const contactNumberRegex = /^[0-9]+$/; // Only numeric values allowed
      const trimmedContactNumber = this.contactnumber.trim();

      if (!contactNumberRegex.test(trimmedContactNumber)) {
        this.errors.contactnumber = 'Invalid Contact Number';
        return false;
      }

      if (trimmedContactNumber.length < 11) {
        this.errors.contactnumber = 'Contact number must be at least 11 digits';
        return false;
      }

      if (trimmedContactNumber.length > 11) {
        this.errors.contactnumber = 'Contact number must not exceed 11 digits';
        return false;
      }
      this.errors.contactnumber = '';
      return true;
    },

    validateBirthdate() {
      const currentDate = new Date()
      const enteredDate = new Date(this.birthdate)

      if (enteredDate > currentDate) {
        this.errors.birthdateError = 'Please enter a valid Birth Date'
      } else {
        this.errors.birthdateError = ''
      }
    },

    async checkAllFieldsFilled() {
      const requiredFields = [
        'givenname',
        'middlename',
        'surname',
        'email',
        'username',
        'contactnumber',
        'birthdate',
        'gender'
      ]

      for (const field of requiredFields) {
        if (!this[field].trim()) {
          console.log(`All fields are required`)
          this.errModal = true
          return false
        }
      }

      if (!this.validateName(this.givenname, 'Given Name')) {
        return false
      }

      if (!this.validateName(this.middlename, 'Middle Name')) {
        return false
      }

      if (!this.validateName(this.surname, 'Surname')) {
        return false
      }
      if (!this.validateUsername()) {
        return false
      }

      if (!this.validateEmail()) {
        return false
      }

      if (!this.validateContactNumber()) {
        return false
      }

      return true
    },

    async editProfile() {
      try {

        if (!this.checkAllFieldsFilled()) {
          return;
        }

        // Ensure this.userData and this.userData.id are defined
        if (this.userData && this.userData.id) {
          const response = await axios.post("http://localhost/system-main/database/include/user/editProfile.php", {
            givenname: this.givenname,
            middlename: this.middlename,
            surname: this.surname,
            email: this.email,
            username: this.username,
            contactnumber: this.contactnumber,
            birthdate: this.birthdate,
            gender: this.gender,
            id: this.userData.id,
          });

          if (response.data.success) {
            this.sucModal = true
            console.log("Profile updated successfully");

            const updatedUserData = {
              givenname: this.givenname,
              middlename: this.middlename,
              surname: this.surname,
              email: this.email,
              username: this.username,
              contactnumber: this.contactnumber,
              birthdate: this.birthdate,
              gender: this.gender,
            };

            const storedUserData = sessionStorage.getItem("userData");
            this.$emit("profile-updated");

            if (storedUserData) {
              const existingUserData = JSON.parse(storedUserData);
              sessionStorage.setItem("userData", JSON.stringify({ ...existingUserData, ...updatedUserData }));
            }
          } else {
            console.error(response.data.message);
          }
        } else {
          console.error("User data or user ID is missing");
        }
      } catch (error) {
        console.error("An error occurred", error);
      }
    },

    backTo() {
      this.showModal = false
      this.sucModal = false

      window.location.reload();
    }
  },

  computed: {
    userData() {
      const userData = sessionStorage.getItem("userData")
      return userData ? JSON.parse(userData) : null
    },
  },

  mounted() {
    const userData = sessionStorage.getItem("userData");
    if (userData) {
      const parsedUserData = JSON.parse(userData);
      this.givenname = parsedUserData.givenname;
      this.middlename = parsedUserData.middlename;
      this.surname = parsedUserData.surname;
      this.email = parsedUserData.email;
      this.username = parsedUserData.username;
      this.contactnumber = parsedUserData.contactnumber;
      this.birthdate = parsedUserData.birthdate;
      this.gender = parsedUserData.gender;
    }
  }
};
</script>
