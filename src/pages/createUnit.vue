<template>
  <div v-if="showModal" class="fixed inset-0 z-50 overflow-auto bg-smoke-dark flex">
    <div class="relative p-8 bg-white w-full max-w-2xl m-auto flex-col flex rounded-lg shadow-lg">
      <button @click="closeModal" class="absolute top-0 right-0 p-4">
        <svg class="fill-current text-grey" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
          width="24">
          <path d="M0 0h24v24H0z" fill="none" />
          <path
            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
        </svg>
      </button>
      <div class="text-center">
        <h2 class="text-3xl text-blue-700 font-bold">Create Unit</h2>
        <br>
      </div>

      <q-form @submit.prevent="createUnit" class="flex flex-wrap">
        <div class="w-full sm:w-1/2">
          <!-- Fields for the first column -->
          <div class="mt-3 relative">
            <input type="text" v-model="unitno" id="unitno" name="unitno" placeholder="Unit No."
              @change="validateUnitNo"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg">
            <div v-if="unitnoError && unitno !== ''" class="text-red-500 text-sm mt-1 text-left ml-3">
              {{ unitnoError }}
            </div>
            <div v-if="unitnoExistError" class="text-red-500 text-sm mt-1 text-left ml-3">
              {{ unitnoExistError }}
            </div>
          </div>

          <div class="mt-3 relative">
            <input type="text" v-model="unitname" id="unitname" name="unitname" placeholder="Unit Name"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg">
          </div>

          <div class="mt-3 relative">
            <label for="unitposition"
              class="block text-base text-left font-medium text-gray-700 mb-2 ml-3">Position</label>
            <div class="flex items-center">
              <div class="flex items-center">
                <label class="inline-flex items-center">
                  <input type="radio" v-model="unitposition" id="unitposition" name="unitposition" value="High-Way Side"
                    class="form-radio h-5 w-5 text-blue-500">
                  <span class="ml-2 text-sm">High-Way</span>
                </label>
                <label class="inline-flex items-center ml-6">
                  <input type="radio" v-model="unitposition" id="unitposition" name="unitposition" value="Bay Side"
                    class="form-radio h-5 w-5 text-pink-500">
                  <span class="ml-2 text-sm">Bay</span>
                </label>
                <label class="inline-flex items-center ml-6">
                  <input type="radio" v-model="unitposition" id="unitposition" name="unitposition" value="Lobby Side"
                    class="form-radio h-5 w-5 text-pink-500">
                  <span class="ml-2 text-sm">Lobby</span>
                </label>
              </div>
            </div>
          </div>

        </div>

        <!-- second column -->
        <div class="w-full sm:w-1/2 pl-4">

          <div class="mt-3 relative">
            <input type="text" v-model="unitprice" id="unitprice" name="unitprice" placeholder="Monthly Price" readonly
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg">
          </div>

          <div class="mt-3 relative">
            <label for="unittype" class="block text-base text-left font-medium text-gray-700 mb-2 ml-3">Unit
              Type</label>
            <div class="flex items-center">
              <div class="flex items-center">
                <label class="inline-flex items-center">
                  <input type="radio" v-model="unittype" id="unittype" name="unittype" value="Studio Unit"
                    class="form-radio h-5 w-5 text-blue-500">
                  <span class="ml-2 text-sm">Studio</span>
                </label>
                <label class="inline-flex items-center ml-6">
                  <input type="radio" v-model="unittype" id="unittype" name="unittype" value="One Bed Room"
                    class="form-radio h-5 w-5 text-pink-500">
                  <span class="ml-2 text-sm">1 Bed</span>
                </label>
                <label class="inline-flex items-center ml-6">
                  <input type="radio" v-model="unittype" id="unittype" name="unittype" value="Two Bed Room"
                    class="form-radio h-5 w-5 text-pink-500">
                  <span class="ml-2 text-sm">2 Bed</span>
                </label>
              </div>
            </div>
          </div>

        </div>

        <div class="flex items-center justify-end mt-6 w-full">
          <button type="button" name="createUnit" id="createUnit" @click="createUnit" class=" bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg focus:outline-none
              focus:shadow-outline text-sm">Create</button>
        </div>
      </q-form>
      <!-- Modal for Error Handling -->
      <div v-if="errModal" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
              class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
              <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                  <div
                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                  </div>
                  <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Error Creating Unit
                    </h3>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">Please fill out all fields.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button" @click="deacModal"
                  class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Close</button>
              </div>
            </div>
          </div>
        </div>
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
                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Successfully
                      Created
                    </h3>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">You can now go back. Thank you for
                        registering.
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
  </div>
</template>

<script>
export default {
  name: 'CreateUnit',
  data() {
    return {
      errModal: false,
      sucModal: false,
      showModal: false,
      creationSuccess: false,

      unitname: '',
      unitno: '',
      unitposition: '',
      unitprice: '',
      unittype: '',

      unitnoError: '',
      unitnoExistError: '',
    }
  },
  watch: {
    // Watch for changes in unittype and update unitprice accordingly
    unittype: function (newVal, oldVal) {
      if (newVal === 'Studio Unit') {
        this.unitprice = '10000';
      } else if (newVal === 'One Bed Room') {
        this.unitprice = '20000';
      } else if (newVal === 'Two Bed Room') {
        this.unitprice = '30000';
      }
    }
  },
  methods: {
    openModal() {
      this.showModal = true
    },

    closeModal() {
      this.showModal = false

      this.unitname = '',
        this.unitno = '',
        // this.unitstatus = '',
        this.unitposition = '',
        this.unitprice = '',
        this.unittype = ''
    },

    deacModal() {
      this.errModal = false
    },

    backTo() {
      this.showModal = false
      this.sucModal = false
      window.location.reload();

      this.unitname = '',
        this.unitno = '',
        // this.unitstatus = '',
        this.unitposition = '',
        this.unitprice = '',
        this.unittype = ''
    },

    validateFields() {
      // Check if any field is empty
      if (
        !this.unitname ||
        !this.unitno ||
        !this.unitposition ||
        !this.unitprice ||
        !this.unittype
      ) {
        this.errModal = true;
        return false;
      }

      // Reset the empty field error if all fields are filled
      this.errModal = false;
      return true;
    },

    async validateUnitNo() {
      const unitNoRegex = /^[0-9]+$/; // Only numeric values allowed

      if (!unitNoRegex.test(this.unitno)) {
        this.unitnoError = 'Invalid Unit Number';
        return false;
      }

      // Reset the error messages
      this.unitnoError = '';
      this.unitnoExistError = '';

      // Check if the unit number already exists
      try {
        const response = await fetch('http://localhost/apartment-system/database/include/admin/checkUnitNo.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            unitno: this.unitno,
          }),
        });

        if (response.ok) {
          const responseData = await response.json();

          if (responseData.exists) {
            this.unitnoExistError = 'Unit No. already exists.';
          }
        } else {
          console.error('Server returned an error:', response.status, response.statusText);
        }
      } catch (error) {
        console.error('Error checking unit number:', error);
      }

      return true;
    },

    async createUnit() {

      if (!this.validateFields()) {
        return false;
      }

      if (!this.validateUnitNo()) {
        return false
      }

      try {
        const response = await fetch('http://localhost/apartment-system/database/include/admin/createUnit.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            unitname: this.unitname,
            unitno: this.unitno,
            // unitstatus: this.unitstatus,
            unitposition: this.unitposition,
            unitprice: this.unitprice,
            unittype: this.unittype,
          })
        });

        if (response.ok) {
          const responseData = await response.json();

          if (responseData.success) {
            this.sucModal = true;

            console.log('success');
          } else {
            // Check for the specific error message related to unitno existence
            if (responseData.message === 'Unit with the same unitno already exists.') {
              this.creationError = responseData.message;
            } else {
              this.creationError = responseData.message || 'An error occurred during registration.';
              console.error('Error during registration:', responseData.message);
            }
          }
        } else {
          this.creationError = 'An error occurred during registration.';
          console.error('Server returned an error:', response.status, response.statusText);
        }
      } catch (error) {
        console.error('Error during registration:', error);
        this.creationError = 'An error occurred during registration.';
      }
    },
  },
}
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
