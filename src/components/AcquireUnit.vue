<template>
  <div class="bg-gray-800 text-white w-[auto] min-h-fit rounded-lg select-none">
    <div class="">
      <div class="px-4 py-5 flex">
        <img src="src/assets/apartment.jpg" alt="Current Picture" class="object-cover object-center w-96 h-40" />
        <div class="grid ml-2">
          <div>Unit no: {{ selectedUnit.unitno }}</div>
          <div>Unit Type: {{ selectedUnit.unittype }}</div>
          <div>Monthly Price: {{ selectedUnit.unitprice.toLocaleString() }}</div>
        </div>
      </div>
    </div>
    <div class="bg-gray-700 text-lg rounded-lg ml-3 mx-2 flex justify-between items-center">
      <div class="ml-4 flex">
        Confirmation:
      </div>
    </div>
    <!-- Confirmation-->

    <!-- Payment Method -->
    <div class="flex justify-center">
      <h1 class="text-xl text-bold mt-2">PAYMENT METHOD: {{}}</h1>
    </div>
    <hr class="h-1 my-5 w- bg-gray-100 border-0 dark:bg-gray-300 rounded-lg" />
    <div class="w-[98%] flex justify-center">
      <div class="q-pa-md q-gutter-sm flex text-black">
        <q-btn align="left" class="btn-fixed-width" color="primary" label="Credit Card"
          icon="fa-solid fa-credit-card text-lg" @click.prevent="openCredit" />
        <q-btn align="right" class="btn-fixed-width" color="primary" label="E-Wallet"
          icon="fa-solid fa-money-bills text-lg" @click.prevent="openWallet" />
        <q-btn align="between" class="btn-fixed-width border border-white" color="primary" label="Cash"
          icon="fa-solid fa-credit-card text-lg" @click.prevent="openCash" />
      </div>
    </div>
    <CreditModal ref="creditModal" />
    <WalletModal ref="walletModal" />
    <CashModal ref="cashModal" />
  </div>
</template>

<script>
import CreditModal from "src/pages/PaymentModal/CreditModal.vue";
import WalletModal from "src/pages/PaymentModal/WalletModal.vue";
import CashModal from "src/pages/PaymentModal/CashModal.vue";
export default {
  components: {
    CreditModal,
    WalletModal,
    CashModal,
  },
  data() {
    return {
      modeOfStay: "", // Add a data property to track the selected mode of stay
    };
  },
  methods: {
    openCredit() {
      this.$refs.creditModal.openCredit();
    },
    openWallet() {
      this.$refs.walletModal.openWallet();
    },
    openCash() {
      this.$refs.cashModal.openCash();
    },
    onItemClick(mode) {
      this.modeOfStay = mode; // Update the selected mode of stay
    },
  },
};
</script>

<style>
body {
  background-color: whitesmoke;
}
</style>
