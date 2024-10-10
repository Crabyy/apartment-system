<template>
  <div v-if="showModal" class="fixed inset-0 z-50 overflow-auto bg-smoke-dark flex select-none backdrop-blur-sm">
    <div class="relative p-8 bg-white w-full max-w-2xl m-auto flex-col flex rounded-lg shadow-black border mongos">
      <button @click="closeModal" class="absolute top-0 right-0 p-4">
        <svg class="fill-current text-grey" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
          <path d="M0 0h24v24H0z" fill="none" />
          <path
            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
        </svg>
      </button>

      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <div>
          <!-- Editable Picture with Edit Icon -->
          <div class="relative rounded-lg mx-auto mt-4 shadow-black img1">
            <img v-if="previewImage" :src="previewImage" alt="Preview" class="object-cover object-center w-full h-48 rounded-lg" />
            <div class="absolute bottom-0 right-0 p-2 bg-white rounded-full">
              <button v-if="userType === 'admin'" type="button" @click="triggerFileUpload">
                <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                  <path d="M0 0h24v24H0z" fill="none" />
                  <path d="M5 8.5l1.41-1.41L10.91 11l4.59-4.59L17 8.5 10.91 14.59z" />
                </svg>
              </button>
            </div>
            <input ref="image" type="file" style="display: none" accept=".jpg, .jpeg, .png" @change="handleFileChange" />
          </div>

          <!-- Editable Title -->
          <h3>
            <input  v-if="userType === 'admin'" v-model="room_name" class="bg-gray-200 w-full p-2 mt-2 text-lg font-bold text-center rounded-lg">
          </h3>

          <!-- Editable Description -->
          <div class="bg-white p-8 rounded-lg shadow-md shadow-black text-justify mongo1">
            <textarea  v-if="userType === 'admin'" v-model="description" class="w-full bg-gray-100 p-4 rounded-lg" rows="6"></textarea>
          </div>

          <!-- Editable Price -->
          <div class="bg-white p-8 rounded-lg shadow-md shadow-black text-justify mongo1">
            <input  v-if="userType === 'admin'" v-model="price" class="w-full bg-gray-100 p-2 rounded-lg" type="number" placeholder="Price">
          </div>
        </div>

        <!-- Save Button for Admin Users -->
        <div class="flex items-center justify-between mt-6">
          <button type="submit" v-if="userType === 'admin'"
            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 ml-auto rounded-lg focus:outline-none focus:shadow-outline">
            Save
          </button>
        </div>
      </form>

    </div>
  </div>
</template>

<script>
export default {
  name: "ModalRoomEditor",

  data() {
    return {
      showModal: false,
      room_name: "",
      description: "",
      price: "",
      previewImage: null,
    };
  },

  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    triggerFileUpload() {
      this.$refs.image.click(); // Corrected ref to 'image'
    },
    handleFileChange(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.previewImage = e.target.result;
        };
        reader.readAsDataURL(input.files[0]); // Preview the selected image
      }
    },
    async submitForm() {
      // Prepare the FormData object to send the file and other data
  const formData = new FormData();
  formData.append('room_name', this.room_name);
  formData.append('description', this.description);
  formData.append('price', this.price);
  formData.append('image', this.$refs.image.files[0]); // Append the file

  try {
    // Send POST request using fetch
    const response = await fetch('http://localhost/system-main/database/include/admin/upload.php', {
      method: 'POST',
      body: formData, // Send form data (not JSON)
    });

    const text = await response.text(); // Get raw text response
    console.log('Raw Response:', text); // Log the raw response

    try {
      const result = JSON.parse(text); // Parse it as JSON
      if (result.success) {
        alert('Room saved successfully');
      } else {
        alert('Error: ' + result.message);
      }
    } catch (error) {
      console.error('Error parsing JSON:', error);
      console.error('Raw Response:', text); // Log the raw response if parsing fails
    }
  } catch (error) {
    console.error('Error saving room:', error);
  }
}
    },
  computed: {
    userType() {
      return sessionStorage.getItem("userType");
    },
  },
};
</script>

<style scoped>
.mongos {
  box-shadow: 0 0 10px rgba(0, 0, 0, 1);
}

.mongo1 {
  box-shadow: 0 0 10px rgba(0, 0, 0, 1);
}

.img1 {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);
}

input, textarea {
  border: none;
  outline: none;
  width: 100%;
}
</style>
