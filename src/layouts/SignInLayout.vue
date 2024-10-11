<template>
  <div
    class="absolute inset-0 bg-gradient-to-b from-[rgba(109,108,108,0.44)] to-[rgba(39,38,38,0.19)] via-transparent"
  ></div>
  <div
    class="w-full h-screen bg-cover bg-fixed bg-no-repeat"
    :style="{ backgroundImage: 'url(' + backgroundImage + ')' }"
  >
    <q-form
      @submit.prevent="signin"
      class="flex justify-center items-center h-full"
    >
      <div class="w-80 p-5 shadow-lg bg-white rounded-lg text-center">
        <img
          src="../assets/system-logo.jpg"
          alt="Logo"
          class="mx-auto w-20 h-20 rounded-full mb-3 border-2 border-solid border-blue-900"
        />
        <h1 class="title">Welcome</h1>
        <hr class="mt-3" />
        <div class="mt-3 relative">
          <input
            type="text"
            v-model="username"
            id="username"
            name="username"
            placeholder="Email/Username"
            class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
          />
          <i class="fa-solid fa-user absolute top-2 left-2 text-gray-500"></i>
        </div>

        <div class="mt-3 relative">
          <input
            :type="showPassword ? 'text' : 'password'"
            v-model="password"
            id="password"
            name="password"
            placeholder="Password"
            class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
          />
          <i class="fa-solid fa-lock absolute top-2 left-2 text-gray-500"></i>
          <i
            v-if="!showPassword"
            @click="togglePasswordVisibility"
            class="fas fa-eye-slash absolute top-3 right-2 text-gray-500 cursor-pointer"
          ></i>
          <i
            v-if="showPassword"
            @click="togglePasswordVisibility"
            class="fas fa-eye absolute top-3 right-2 text-gray-500 cursor-pointer"
          ></i>
          <div class="mt-4">
            <button
              class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 text-base"
            >
              Sign In
            </button>
          </div>
          <small>
            <p class="mt-2 text-xs">
              Don't have an account?
              <a href="#" class="register-here" @click.prevent="openModal"
                ><u>Register Here!</u></a
              >
            </p>
            <Register ref="registerModal" />
          </small>
        </div>
      </div>
    </q-form>
  </div>
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
                  Error Logging In
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">
                    Invalid Username/Email or Password. Please try again!
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
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
</template>

<script>
import { simulateLogin, checkIfUserIsAuthenticated } from "../router/auth.js";
import backgroundImage from "../assets/apartment.jpg";
import Register from "../pages/Register.vue";

export default {
  name: "SigninComponent",
  components: {
    Register,
  },

  data() {
    return {
      errModal: false,
      showPassword: false,
      backgroundImage,
      username: "",
      password: "",
      isAuthenticated: false,
    };
  },

  beforeRouteEnter(to, from, next) {
    if (checkIfUserIsAuthenticated()) {
      const userType = sessionStorage.getItem("userType");
      if (userType === "admin") {
        next({ name: "Dashboard" });
      } else {
        next({ name: "Dashboard" });
      }
    } else {
      next();
    }
  },

  methods: {
    openModal() {
      // Access the RegisterModal component using the ref and call its openModal method
      this.$refs.registerModal.openModal();
    },

    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },

    async signin() {
      try {
        const response = await fetch(
          "http://localhost/apartment-system/database/api/signin.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
              username: this.username,
              password: this.password,
            }),
          }
        );

        const responseData = await response.json();

        if (responseData && responseData.success) {
          // console.log('Login successful')

          simulateLogin();

          sessionStorage.setItem(
            "userData",
            JSON.stringify(responseData.userData)
          );
          if (responseData.userType) {
            sessionStorage.setItem("userType", responseData.userType);

            if (responseData.userType === "admin") {
              this.$router.push({ name: "Dashboard" });
            } else {
              this.$router.push({ name: "Dashboard" });
            }
          }
        } else {
          this.errModal = true;
          // console.error(responseData && responseData.message ? responseData.message : 'Unknown error')
          // this.errorMessage = 'Invalid ID or Password'
          // console.log('User Type:', responseData.userType);
        }
      } catch (error) {
        console.error("Error during login:", error);
      }
    },

    deacModal() {
      this.errModal = false;
    },
  },
};
</script>

<style scoped>
.title {
  font-size: 40px;
  margin-bottom: 20px;
  color: darkblue;
  position: relative;
  font-weight: bold;
}

.title::after {
  content: "";
  width: 50px;
  height: 4px;
  border-radius: 3px;
  background: darkblue;
  position: absolute;
  bottom: 1%;
  left: 50%;
  transform: translateX(-50%);
}

.register-here {
  color: blue;
}

.register-here:hover {
  cursor: pointer;
  color: darkblue;
}
</style>
