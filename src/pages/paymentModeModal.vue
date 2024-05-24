<template>
  <div v-if="modalVisible" class="fixed inset-0 z-10 flex items-center justify-center">
    <div class="bg-gray-500 bg-opacity-75 fixed inset-0" @click="closeModal"></div>

    <div class="bg-gray-800 text-white w-[auto] min-h-fit rounded-lg select-none">
      <!-- Payment Method -->
      <div class="flex justify-center">
        <h1 class="text-xl text-bold mt-2">PAYMENT METHOD: </h1>
      </div>
      <hr class="h-1 my-5 w- bg-gray-100 border-0 dark:bg-gray-300 rounded-lg" />
      <div class="w-[100%] flex justify-center">
        <div class="q-pa-md q-gutter-sm flex text-black">
          <q-btn align="left" class="btn-fixed-width" color="primary" label="Credit Card"
            icon="fa-solid fa-credit-card text-lg" @click.prevent="openCredit" />

          <q-btn align="left" class="btn-fixed-width" color="primary" label="E-Wallet"
            icon="fa-solid fa-money-bills text-lg" @click.prevent="openWallet" />

          <q-btn align="left" class="btn-fixed-width border border-white" color="primary" label="Cash"
            icon="fa-solid fa-credit-card text-lg" @click.prevent="openCash" />
        </div>
      </div>
      <CreditModal ref="creditModal" />
      <WalletModal ref="walletModal" />
      <CashModal ref="cashModal" />
    </div>
  </div>
</template>

<script>
import CreditModal from "src/pages/PaymentModal/CreditModal.vue";
import WalletModal from "src/pages/PaymentModal/WalletModal.vue";
import CashModal from "src/pages/PaymentModal/CashModal.vue";
export default {
  data() {
    return {
      modalVisible: false,
    };
  },
  components: {
    CreditModal,
    WalletModal,
    CashModal,
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
    showModal() {
      this.modalVisible = true;
    },
    closeModal() {
      this.modalVisible = false;
    },

  },
};
</script>
