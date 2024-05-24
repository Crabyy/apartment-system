<template>
  <div
    v-if="showModal"
    class="fixed inset-0 z-50 overflow-auto bg-smoke-dark flex"
  >
    <div
      class="relative p-8 bg-white w-full max-w-2xl m-auto flex-col flex rounded-lg shadow-lg"
    >
      <button @click="closeModal" class="absolute top-0 right-0 p-4">
        <svg
          class="fill-current text-grey"
          xmlns="http://www.w3.org/2000/svg"
          height="24"
          viewBox="0 0 24 24"
          width="24"
        >
          <path d="M0 0h24v24H0z" fill="none" />
          <path
            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"
          />
        </svg>
      </button>
      <div class="text-center">
        <h2 class="text-3xl text-blue-700 font-bold">Register</h2>
        <br />
      </div>

      <q-form @submit.prevent="register" class="flex flex-wrap">
        <div class="w-full sm:w-1/2">
          <!-- Fields for the first column -->
          <div class="mt-3 relative">
            <input
              type="text"
              v-model="givenname"
              id="givenname"
              name="givenname"
              placeholder="Given Name"
              @change="validateName(givenname, 'GivenName')"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
            />
            <i class="fa-solid fa-user absolute top-3 left-2 text-gray-500"></i>
            <div
              v-if="errors.givenname && givenname !== ''"
              class="text-red-500 text-sm mt-1 text-left ml-3"
            >
              {{ errors.givenname }}
            </div>
          </div>

          <div class="mt-3 relative">
            <input
              type="text"
              v-model="middlename"
              id="middlename"
              name="middlename"
              placeholder="Middle Name"
              @change="validateName(middlename, 'MiddleName')"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
            />
            <i class="fa-solid fa-user absolute top-3 left-2 text-gray-500"></i>
            <div
              v-if="errors.middlename && middlename !== ''"
              class="text-red-500 text-sm mt-1 text-left ml-3"
            >
              {{ errors.middlename }}
            </div>
          </div>

          <div class="mt-3 relative">
            <input
              type="text"
              v-model="surname"
              id="surname"
              name="surname"
              placeholder="Surname"
              @change="validateName(surname, 'Surname')"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
            />
            <i class="fa-solid fa-user absolute top-3 left-2 text-gray-500"></i>
            <div
              v-if="errors.surname && surname !== ''"
              class="text-red-500 text-sm mt-1 text-left ml-3"
            >
              {{ errors.surname }}
            </div>
          </div>

          <div class="mt-3 relative">
            <input
              type="text"
              v-model="email"
              id="email"
              name="email"
              placeholder="Email"
              @change="validateEmail"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
            />
            <i
              class="fa-solid fa-envelope absolute top-3 left-2 text-gray-500"
            ></i>
            <div
              v-if="errors.emailError && email !== ''"
              class="text-red-500 text-sm mt-1 text-left ml-3"
            >
              {{ errors.emailError }}
            </div>
          </div>

          <div class="mt-3 relative">
            <input
              type="text"
              v-model="username"
              id="username"
              name="username"
              placeholder="Username"
              @change="validateUsername"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
            />
            <i class="fa-solid fa-user absolute top-3 left-2 text-gray-500"></i>
            <div
              v-if="errors.username && username !== ''"
              class="text-red-500 text-sm mt-1 text-left ml-3"
            >
              {{ errors.username }}
            </div>
          </div>

          <div class="mt-3 relative">
            <input
              :type="showPassword ? 'text' : 'password'"
              v-model="password"
              id="password"
              name="password"
              placeholder="Password"
              @change="validatePassword"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
            />
            <i class="fa-solid fa-lock absolute top-3 left-2 text-gray-500"></i>
            <i
              v-if="!showPassword"
              @click="togglePasswordVisibility"
              class="fa-solid fa-eye-slash absolute top-3 right-2 text-gray-500 cursor-pointer"
            ></i>
            <i
              v-if="showPassword"
              @click="togglePasswordVisibility"
              class="fa-solid fa-eye absolute top-3 right-2 text-gray-500 cursor-pointer"
            ></i>
            <div
              v-if="errors.password && password !== ''"
              class="text-red-500 text-sm mt-1 text-left ml-3"
            >
              {{ errors.password }}
            </div>
          </div>

          <div class="mt-3 relative">
            <input
              :type="showConfirmPassword ? 'text' : 'password'"
              v-model="confirmpassword"
              id="confirmpassword"
              name="confirmpassword"
              @change="checkPasswordMatch"
              placeholder="Confirm Password"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
            />
            <i class="fa-solid fa-lock absolute top-3 left-2 text-gray-500"></i>
            <i
              v-if="!showConfirmPassword"
              @click="toggleConfirmPasswordVisibility"
              class="fa-solid fa-eye-slash absolute top-3 right-2 text-gray-500 cursor-pointer"
            ></i>
            <i
              v-if="showConfirmPassword"
              @click="toggleConfirmPasswordVisibility"
              class="fa-solid fa-eye absolute top-3 right-2 text-gray-500 cursor-pointer"
            ></i>
            <div
              v-if="errors.passwordMatch && confirmpassword !== ''"
              class="text-red-500 text-sm mt-1 text-left ml-3"
            >
              {{ errors.passwordMatch }}
            </div>
          </div>
        </div>
        <div class="w-full sm:w-1/2 pl-4">
          <!-- Fields for the second column -->
          <div class="mt-3 relative">
            <input
              type="text"
              v-model="contactnumber"
              id="contactnumber"
              name="contactnumber"
              placeholder="Contact Number"
              @change="validateContactNumber"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
            />
            <i
              class="fa-solid fa-mobile-screen absolute top-3 left-2 text-gray-500"
            ></i>
            <div
              v-if="errors.contactnumber && contactnumber !== ''"
              class="text-red-500 text-sm mt-1 text-left ml-3"
            >
              {{ errors.contactnumber }}
            </div>
          </div>

          <div class="mt-3 relative">
            <label
              for="birthdate"
              class="block text-base text-left font-medium text-gray-700 mb-2 ml-3"
              >Birth Date</label
            >
            <div class="relative">
              <input
                type="date"
                v-model="birthdate"
                id="birthdate"
                name="birthdate"
                @change="validateBirthdate"
                class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
              />
              <i
                class="fa-solid fa-calendar absolute top-3 left-2 text-gray-500"
              ></i>
            </div>
            <div
              v-if="errors.birthdateError && birthdate !== ''"
              class="text-red-500 text-sm mt-1 text-left ml-3"
            >
              {{ errors.birthdateError }}
            </div>
            <!-- Display error message -->
          </div>

          <div class="mt-3 relative">
            <label
              for="gender"
              class="block text-base text-left font-medium text-gray-700 mb-2 ml-3"
              >Choose Gender</label
            >
            <div class="flex items-center">
              <div class="flex items-center">
                <label class="inline-flex items-center">
                  <i
                    class="fa-solid fa-mars text-gray-500 mr-4 mt-1 text-sm"
                  ></i>
                  <input
                    type="radio"
                    v-model="gender"
                    id="male"
                    name="gender"
                    value="Male"
                    class="form-radio h-5 w-5 text-blue-500"
                  />
                  <span class="ml-2 text-sm">Male</span>
                </label>
                <label class="inline-flex items-center ml-6">
                  <i
                    class="fa-solid fa-venus text-gray-500 mr-4 mt-1 text-sm"
                  ></i>
                  <input
                    type="radio"
                    v-model="gender"
                    id="female"
                    name="gender"
                    value="Female"
                    class="form-radio h-5 w-5 text-pink-500"
                  />
                  <span class="ml-2 text-sm">Female</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-end mt-6 w-full">
          <button
            type="submit"
            id="register"
            name="register"
            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline text-sm"
          >
            Register
          </button>
        </div>
      </q-form>
      <!-- Modal for Error Handling -->
      <div
        v-if="errModal"
        class="relative z-10"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
      >
        <div
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        ></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div
            class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
          >
            <div
              class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
            >
              <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                  <div
                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                  >
                    <svg
                      class="h-6 w-6 text-red-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                      />
                    </svg>
                  </div>
                  <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <h3
                      class="text-base font-semibold leading-6 text-gray-900"
                      id="modal-title"
                    >
                      Error Registering
                    </h3>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">
                        Please fill out all fields.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
              >
                <button
                  type="button"
                  @click="deacModal"
                  class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                >
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal for Success Handling -->
      <div
        v-if="sucModal"
        class="relative z-10"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
      >
        <div
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        ></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div
            class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
          >
            <div
              class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
            >
              <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                  <div
                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10"
                  >
                    <svg
                      class="h-6 w-6 text-green-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                      ></path>
                    </svg>
                  </div>
                  <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <h3
                      class="text-base font-semibold leading-6 text-gray-900"
                      id="modal-title"
                    >
                      Registered Succesfully
                    </h3>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">
                        You can now go back to the Sign In page to sign in.
                        Thank you for registering.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
              >
                <button
                  type="button"
                  @click="backtoSignin"
                  class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto"
                >
                  Back to Sign In
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import axios from 'axios'

export default {
  name: "RegisterPages",
  data() {
    return {
      errModal: false,
      sucModal: false,
      showModal: false,
      showPassword: false,
      showConfirmPassword: false,
      givenname: "",
      middlename: "",
      surname: "",
      email: "",
      username: "",
      password: "",
      confirmpassword: "",
      contactnumber: "",
      birthdate: "",
      gender: "",

      registrationSuccess: false,

      errors: {
        givenname: "",
        middlename: "",
        surname: "",
        username: "",
        emailError: "",
        contactnumber: "",
        password: "",
        passwordMatch: "",
        birthdateError: "",
        registrationError: "",
      },
    };
  },

  methods: {
    openModal() {
      this.showModal = true;
    },

    closeModal() {
      this.showModal = false;

      // Reset all data fields to their initial values
      this.givenname = "";
      this.middlename = "";
      this.surname = "";
      this.email = "";
      this.emailError = "";
      this.username = "";
      this.password = "";
      this.confirmpassword = "";
      this.contactnumber = "";
      this.birthdate = "";
      this.birthdateError = "";
      this.gender = "";
      this.registrationSuccess = false;
      this.registrationError = "";

      // Reset the validation errors
      this.errors = {
        givenname: "",
        middlename: "",
        surname: "",
        username: "",
        contactnumber: "",
        password: "",
        passwordMatch: "",
      };
    },

    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },

    toggleConfirmPasswordVisibility() {
      this.showConfirmPassword = !this.showConfirmPassword;
    },

    validateUsername() {
      const usernameRegex = /^[a-zA-Z0-9_]+$/;
      if (!usernameRegex.test(this.username.trim())) {
        // console.log('Invalid username format')
        this.errors.username = "Invalid Username";
        return false;
      }
      this.errors.username = "";
      return true;
    },

    validateEmail() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(this.email.trim())) {
        // console.log('Invalid email format')
        this.errors.emailError = "Please enter a valid Email";
        return false;
      }
      this.errors.emailError = "";
      return true;
    },

    validateContactNumber() {
      const contactNumberRegex = /^[0-9]+$/; // Only numeric values allowed
      const trimmedContactNumber = this.contactnumber.trim();

      if (!contactNumberRegex.test(trimmedContactNumber)) {
        this.errors.contactnumber = "Invalid Contact Number";
        return false;
      }

      if (trimmedContactNumber.length < 11) {
        this.errors.contactnumber = "Contact number must be at least 11 digits";
        return false;
      }

      if (trimmedContactNumber.length > 11) {
        this.errors.contactnumber = "Contact number must not exceed 11 digits";
        return false;
      }
      this.errors.contactnumber = "";
      return true;
    },

    validateName(name, fieldName) {
      const nameRegex = /^[a-zA-Z\sñÑ]+$/; // Allow letters, spaces, and "ñ" characters
      if (!nameRegex.test(name.trim())) {
        this.errors[fieldName.toLowerCase()] = `Invalid ${fieldName}`;
        return false;
      }
      this.errors[fieldName.toLowerCase()] = "";
      return true;
    },

    validatePassword() {
      const passwordRegex =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.$!%*?&,]).{8,}$/;
      // Explanation of the regex:
      // ^               Start of string
      // (?=.*[a-z])     At least one lowercase letter
      // (?=.*[A-Z])     At least one uppercase letter
      // (?=.*\d)        At least one digit
      // (?=.*[@$!%*?&]) At least one special character
      // .{8,}           Match any combination of characters with a minimum length of 8
      // $               End of string

      if (!passwordRegex.test(this.password)) {
        if (this.password.length < 8) {
          this.errors.password = "Password must be at least 8 characters long.";
        } else {
          this.errors.password =
            "Use a strong password with at least one lowercase letter, uppercase letter, number, and special character.";
        }
        return false;
      }
      this.errors.password = "";
      return true;
    },

    validateBirthdate() {
      const currentDate = new Date();
      const enteredDate = new Date(this.birthdate);

      if (enteredDate > currentDate) {
        this.errors.birthdateError = "Please enter a valid Birth Date";
      } else {
        this.errors.birthdateError = "";
      }
    },

    async checkAllFieldsFilled() {
      const requiredFields = [
        "givenname",
        "middlename",
        "surname",
        "email",
        "username",
        "password",
        "confirmpassword",
        "contactnumber",
        "birthdate",
        "gender",
      ];

      for (const field of requiredFields) {
        if (!this[field].trim()) {
          console.log(`All fields are required`);
          this.errModal = true;
          return false;
        }
      }

      if (!this.validateName(this.givenname, "Given Name")) {
        return false;
      }

      if (!this.validateName(this.middlename, "Middle Name")) {
        return false;
      }

      if (!this.validateName(this.surname, "Surname")) {
        return false;
      }
      if (!this.validateUsername()) {
        return false;
      }

      if (!this.validateEmail()) {
        return false;
      }

      if (!this.validateContactNumber()) {
        return false;
      }

      if (!this.validatePassword()) {
        return false;
      }

      return true;
    },

    async checkPasswordMatch() {
      if (this.password !== this.confirmpassword) {
        this.errors.passwordMatch = "Password does not match.";
        return false;
      }
      this.errors.passwordMatch = "";
      return true;
    },

    async register() {
      try {
        const allFieldsFilled = await this.checkAllFieldsFilled();
        if (!allFieldsFilled) {
          return;
        }

        const passwordMatch = await this.checkPasswordMatch();
        if (!passwordMatch) {
          return;
        }

        const response = await fetch(
          "http://localhost/system-main/database/api/user/register.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              givenname: this.givenname,
              middlename: this.middlename,
              surname: this.surname,
              email: this.email,
              username: this.username,
              password: this.password,
              confirmpassword: this.confirmpassword,
              contactnumber: this.contactnumber,
              birthdate: this.birthdate,
              gender: this.gender,
            }),
          }
        );

        console.log("Response:", response);

        if (response.ok) {
          const responseData = await response.json();
          this.sucModal = true;
          if (responseData.success) {
            this.registrationSuccess = true;
          } else {
            this.errors.registrationError = responseData.message;
          }
        } else {
          this.errors.registrationError =
            "An error occurred during registration.";
        }
      } catch (error) {
        console.error("Error during registration:", error);
        this.errors.registrationError =
          "An error occurred during registration.";
      }
    },

    deacModal() {
      this.errModal = false;
    },

    backtoSignin() {
      this.showModal = false;
      this.sucModal = false;

      // Reset all data fields to their initial values
      this.givenname = "";
      this.middlename = "";
      this.surname = "";
      this.email = "";
      this.emailError = "";
      this.username = "";
      this.password = "";
      this.confirmpassword = "";
      this.contactnumber = "";
      this.birthdate = "";
      this.birthdateError = "";
      this.gender = "";
      this.registrationSuccess = false;
      this.registrationError = "";

      // Reset the validation errors
      this.errors = {
        givenname: "",
        middlename: "",
        surname: "",
        username: "",
        contactnumber: "",
        password: "",
        passwordMatch: "",
      };
    },
  },
};
</script>

<style scoped>
.bg-smoke-dark {
  background-color: rgba(0, 0, 0, 0.75);
}

#birthdate {
  cursor: pointer;
}

#gender {
  cursor: pointer;
}
</style>
