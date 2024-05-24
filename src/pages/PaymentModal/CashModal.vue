<template>
  <div v-if="showModal" class="fixed inset-0 z-50 overflow-auto bg-smoke-dark flex">
    <div class="relative p-8 bg-white w-full max-w-2xl m-auto flex-col flex rounded-lg shadow-lg">
      <button @click="closeModal" class="absolute top-0 right-0 p-4">
        <svg class="fill-current text-grey" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
          <path d="M0 0h24v24H0z" fill="none" />
          <path
            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
        </svg>
      </button>
      <div class="text-center">
        <h2 class="text-3xl text-blue-700 font-bold mb-2">Payment Details for Cash</h2>
      </div>

      <form class="max-w-md mx-auto">
        <h4 class="text-black"><b>Pending Payment</b></h4>
        <h4 class="text-black"><i>Kindly settle the amount as soon possible.</i></h4>
        <button type="submit" @click="closeModalCash"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Submit
        </button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CashModal',
  data() {
    return {
      showModal: false,
    };
  },
  methods: {
    openCash() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    closeModalCash() {
      this.showModal = false;
      window.location.reload();
    },
  },
};
</script>

<style></style>
