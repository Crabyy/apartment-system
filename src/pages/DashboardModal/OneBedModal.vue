<template>
  <div v-if="showModal" class="fixed inset-0 z-50 overflow-auto bg-smoke-dark flex select-none backdrop-blur-sm">
    <div
      class="relative p-8 bg-white w-full max-w-2xl m-auto flex-col flex rounded-lg shadow-lg shadow-black border border-black">
      <button @click="closeModal" class="absolute top-0 right-0 p-4">
        <svg class="fill-current text-grey" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
          <path d="M0 0h24v24H0z" fill="none" />
          <path
            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
        </svg>
      </button>
      <div class="text-center"></div>
      <form @submit.prevent="submit">
        <div>
          <!-- Rectangular Picture with Edit Icon -->
          <div class="q-pa-md">
            <q-carousel arrows animated v-model="slide" height="200px" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.9); border-radius: 10px;">
              <q-carousel-slide name="first" img-src="src/assets/1bedlb.jpg">
                <div class="absolute-bottom custom-caption">
                  <div class="text-h2">Living Room</div>
                  <div class="text-subtitle1">Pang-Kape Apartment</div>
                </div>
              </q-carousel-slide>

              <q-carousel-slide name="second" img-src="src/assets/1bedkitchen.jpg">
                <div class="absolute-bottom custom-caption">
                  <div class="text-h2">Kitchen</div>
                  <div class="text-subtitle1">Pang-Kape Apartment</div>
                </div>
              </q-carousel-slide>

              <q-carousel-slide name="third" img-src="src/assets/1bedcr.jpg">
                <div class="absolute-bottom custom-caption">
                  <div class="text-h2">Comfort Room</div>
                  <div class="text-subtitle1">Pang-Kape Apartment</div>
                </div>
              </q-carousel-slide>
            </q-carousel>
          </div>

          <!-- Big Square for Text -->
          <div class="bg-white p-8 rounded-lg mt-6 shadow-md shadow-black text-justify mongo">
            <p>Our one-bedroom units blend contemporary design with spacious comfort. Featuring a private bedroom, modern
              living area, and a fully equipped kitchen, each unit is a tranquil haven. Elevate your lifestyle in the
              heart of the city with the perfect blend of luxury and practicality in our one-bedroom units.</p>
          </div>
        </div>
      </form>

      <!-- <div class="flex items-center mt-6">
        <button type="submit" v-if="userType === 'admin'"
          class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 ml-auto w rounded-lg focus:outline-none focus:shadow-outline">
          Save
        </button>
      </div> -->
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
export default {
  name: "OneBedModal",
  setup() {
    return {
      slide: ref("first"),
    };
  },

  data() {
    return {
      showModal: false,
    };
  },

  methods: {
    openOne() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
  },

  computed: {
    userType() {
      return sessionStorage.getItem("userType");
    },
  },
};
</script>

<style lang="sass" scoped>
.custom-caption
  text-align: center
  padding: 2px
  color: white
  background-color: rgba(0, 0, 0, .3)

  .mongo
  background-color: rgba(0, 0, 0, .2)
</style>
