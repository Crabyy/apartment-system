<template>
  <div>
    <div class="row flex flex-col select-none">
      <!-- Container 1: TITLE AND PICTURE -->
      <div class="relative">
        <q-toolbar>
          <q-toolbar-title v-if="userType === 'user'"
            >Dashboard</q-toolbar-title
          >
         
        </q-toolbar>
        
        <div
          class="relative rounded-lg mx-auto overflow-hidden shadow-black cursor-pointer title"
          style="height: 250px; width: 100%"
          @click.prevent="openModal"
        >
          <!-- Set your desired height and width -->
          <!-- Set your desired height -->
          <img
            src="src/assets/apartment.jpg"
            alt="Current Picture"
            class="object-cover object-center w-full h-full"
          />
          <!-- TITLE -->
          <div
            class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
          >
            Pang-Kape Apartment
          </div>
        </div>
      </div>

      <div>
        <div class="flex flex-col">
          <div class="flex">
            <!-- Container 1: Studio Unit -->
            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px; margin-right: 20px"
            >
              <img
                src="src/assets/unitStudio.jpg"
                alt="Studio Unit"
                class="object-cover object-center w-full h-full"
                @click="openStudio"
              />
              <!-- studio name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                Studio Unit
              </div>
            </div>

            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px; margin-right: 20px"
            >
              <img
                src="src/assets/onebed.jpg"
                alt="OneBed"
                class="object-cover object-center w-full h-full"
                @click="openOne"
              />
              <!-- studio name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                One Bedroom
              </div>
            </div>
            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px; margin-right: 20px"
            >
              <img
                src="src/assets/onebed.jpg"
                alt="OneBed"
                class="object-cover object-center w-full h-full"
                @click="openOne"
              />
              <!-- studio name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                Bedroom 2
              </div>
            </div>
            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px; margin-right: 20px"
            >
              <img
                src="src/assets/onebed.jpg"
                alt="OneBed"
                class="object-cover object-center w-full h-full"
                @click="openOne"
              />
              <!-- studio name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                Bedroom 3
              </div>
            </div>
            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px; margin-right: 20px"
            >
              <img
                src="src/assets/onebed.jpg"
                alt="OneBed"
                class="object-cover object-center w-full h-full"
                @click="openOne"
              />
              <!-- studio name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                Bedroom 4
              </div>
            </div>
            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px; margin-right: 20px"
            >
              <img
                src="src/assets/onebed.jpg"
                alt="OneBed"
                class="object-cover object-center w-full h-full"
                @click="openOne"
              />
              <!-- studio name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                Bedroom 5
              </div>
            </div>
            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px; margin-right: 20px"
            >
              <img
                src="src/assets/onebed.jpg"
                alt="OneBed"
                class="object-cover object-center w-full h-full"
                @click="openOne"
              />
              <!-- studio name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                Bedroom 6
              </div>
            </div>
            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px; margin-right: 20px"
            >
              <img
                src="src/assets/onebed.jpg"
                alt="OneBed"
                class="object-cover object-center w-full h-full"
                @click="openOne"
              />
              <!-- studio name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                Bedroom 7
              </div>
            </div>
            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px; margin-right: 20px"
            >
              <img
                src="src/assets/onebed.jpg"
                alt="OneBed"
                class="object-cover object-center w-full h-full"
                @click="openOne"
              />
              <!-- studio name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                Bedroom 8
              </div>
            </div>

            <!-- Container 3: Two Bed Unit -->
            <div
              class="rounded-lg mt-10 m-auto ml-0 relative overflow-hidden shadow-md shadow-black cursor-pointer title"
              style="width: 400px; height: 250px"
            >
              <img
                src="src/assets/twobed.jpeg"
                alt="OneBed"
                class="object-cover object-center w-full h-full"
                @click="openTwo"
              />
              <!-- Two bed Name -->
              <div
                class="absolute bottom-4 left-4 rounded-e-sm text-2xl text-white rounded-md custom-caption"
              >
                Bedrooms 9
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ModalPicture ref="modalPicture" />
    <StudioModal ref="studioModal" />
    <OneBedModal ref="oneBedModal" />
    <TwoBedModal ref="twoBedModal" />
  </div>
</template>

<script>
import ModalPicture from "src/pages/DashboardModal/ModalPicture.vue";
import StudioModal from "src/pages/DashboardModal/StudioModal.vue";
import OneBedModal from "src/pages/DashboardModal/OneBedModal.vue";
import TwoBedModal from "src/pages/DashboardModal/TwoModal.vue";

export default {
  name: "AdminDashboard",
  components: {
    ModalPicture,
    StudioModal,
    OneBedModal,
    TwoBedModal,
  },
  methods: {
    openModal() {
      this.$refs.modopenModal();
    },
    openStudio() {
      this.$refs.studioModal.openStudio();
    },
    openOne() {
      this.$refs.oneBedModal.openOne();
    },
    openTwo() {
      this.$refs.twoBedModal.openTwo();
    },
  },

  computed: {
    userType() {
      return sessionStorage.getItem("userType");
    },
  },
};
</script>

<style scoped>
.title {
  box-shadow: 0 0 10px rgba(0, 0, 0, 1);
}

.custom-caption {
  text-align: center;
  padding: 2px;
  color: white;
  background-color: rgba(0, 0, 0, 0.3);
}
</style>
