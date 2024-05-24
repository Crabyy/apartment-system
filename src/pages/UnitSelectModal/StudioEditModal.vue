<template>
  <div
    v-if="showModal"
    class="fixed inset-0 z-50 overflow-auto bg-smoke-dark flex"
  >
    <div
      class="relative p-8 bg-white w-full max-w-sm m-auto flex-col flex rounded-lg shadow-lg shadow-black border border-black"
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
      <div class="text-center"></div>
      <form @submit.prevent="register">
        <div>
          <div class="mt-3 relative">
            <input
              type="text"
              id="title"
              placeholder="Apartment Name"
              class="block mb-2 border w-full text-base px-2 py-1 pl-8 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg"
            />
          </div>
          <q-uploader
            label="Select Background Picture"
            url="http://localhost:4444/upload"
            style="max-width: 300px"
          />
        </div>
      </form>
      <div class="flex items-center justify-between mt-6">
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 ml-auto w rounded-lg focus:outline-none focus:shadow-outline"
        >
          Submit
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "StudioEditModal",

  data() {
    return {
      showModal: false,
    };
  },

  methods: {
    MoEdit() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
  },
};
</script>

<style scoped></style>
