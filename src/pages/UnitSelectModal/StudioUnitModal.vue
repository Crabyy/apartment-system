<template>
  <div
    v-if="showModal"
    class="fixed inset-0 z-50 overflow-auto bg-smoke-dark flex"
  >
    <div
      class="relative p-8 bg-white w-full max-w-2xl m-auto flex-col flex rounded-lg shadow-lg shadow-black border border-black"
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
      <form @submit.prevent="submit">
        <div>
          <!-- Rectangular Picture with Edit Icon -->
          <div class="q-pa-md">
            <q-carousel arrows animated v-model="slide" height="200px">
              <q-carousel-slide
                name="first"
                img-src="https://cdn.quasar.dev/img/mountains.jpg"
              >
                <div class="absolute-bottom custom-caption">
                  <div class="text-h2">First stop</div>
                  <div class="text-subtitle1">Mountains</div>
                </div>
                <a
                  href="#"
                  class="absolute bottom-4 right-4 text-gray-300 hover:text-white"
                  id="changePicture"
                  style="font-size: 1.5rem"
                  @click.prevent="MoEdit"
                >
                  <i class="fas fa-edit"></i>
                </a>
              </q-carousel-slide>
              <q-carousel-slide
                name="second"
                img-src="https://cdn.quasar.dev/img/parallax1.jpg"
              >
                <div class="absolute-bottom custom-caption">
                  <div class="text-h2">Second stop</div>
                  <div class="text-subtitle1">Famous City</div>
                </div>
                <a
                  href="#"
                  class="absolute bottom-4 right-4 text-gray-300 hover:text-white"
                  id="changePicture"
                  style="font-size: 1.5rem"
                  @click.prevent="MoEdit"
                >
                  <i class="fas fa-edit"></i>
                </a>
              </q-carousel-slide>
              <q-carousel-slide
                name="third"
                img-src="https://cdn.quasar.dev/img/parallax2.jpg"
              >
                <div class="absolute-bottom custom-caption">
                  <div class="text-h2">Third stop</div>
                  <div class="text-subtitle1">Famous Bridge</div>
                </div>
                <a
                  href="#"
                  class="absolute bottom-4 right-4 text-gray-300 hover:text-white"
                  id="changePicture"
                  style="font-size: 1.5rem"
                  @click.prevent="MoEdit"
                >
                  <i class="fas fa-edit"></i>
                </a>
              </q-carousel-slide>
            </q-carousel>
          </div>
        </div>
      </form>
      <div class="flex items-center mt-6">
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 ml-auto w rounded-lg focus:outline-none focus:shadow-outline"
        >
          Save
        </button>
      </div>
    </div>
    <StudioEditModal ref="editModal" />
  </div>
</template>

<script>
import StudioEditModal from "src/pages/UnitSelectModal/StudioEditModal.vue";
import { ref } from "vue";
export default {
  name: "StudioUnitModal",
  components: {
    StudioEditModal,
  },
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
    openStudioUnit() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    MoEdit() {
      this.$refs.editModal.MoEdit();
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
</style>
