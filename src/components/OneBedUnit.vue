<template>
  <div class="q-pa-md relative">
    <q-carousel arrows animated v-model="slide" height="350px">
      <q-carousel-slide
        name="first"
        img-src="https://cdn.quasar.dev/img/mountains.jpg"
      >
        <div class="absolute-bottom custom-caption">
          <div class="text-h2">One BedRoom</div>
          <div class="text-subtitle1">Mountains</div>
        </div>
      </q-carousel-slide>
      <q-carousel-slide
        name="second"
        img-src="https://cdn.quasar.dev/img/parallax1.jpg"
      >
        <div class="absolute-bottom custom-caption">
          <div class="text-h2">One BedRoom</div>
          <div class="text-subtitle1">Famous City</div>
        </div>
      </q-carousel-slide>
      <q-carousel-slide
        name="third"
        img-src="https://cdn.quasar.dev/img/parallax2.jpg"
      >
        <div class="absolute-bottom custom-caption">
          <div class="text-h2">One BedRoom</div>
          <div class="text-subtitle1">Famous Bridge</div>
        </div>
      </q-carousel-slide>
    </q-carousel>
    <a
      href="#"
      class="absolute bottom-6 right-6 text-gray-300 hover:text-white"
      id="changePicture"
      style="font-size: 1.5rem"
      @click.prevent="openOneUnit"
    >
      <i class="fas fa-edit"></i>
    </a>
  </div>
  <OneUnitModal ref="oneUnitModal" />

  <!-- table -->
  <div class="q-pa-md">
    <q-table
      class="my-sticky-virtscroll-table"
      virtual-scroll
      flat
      bordered
      v-model:pagination="pagination"
      :rows-per-page-options="[0]"
      :virtual-scroll-sticky-size-start="48"
      row-key="index"
      :rows="rows"
      :columns="columns"
    />
  </div>
</template>

<script>
import OneUnitModal from "src/pages/UnitSelectModal/OneUnitModal.vue";
import { ref } from "vue";
const columns = [
  {
    name: "index",
    label: "Unit no.",
    field: "index",
    align: "center",
    sortable: true,
  },
  {
    name: "status",
    required: true,
    label: "Status",
    align: "left",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "Position",
    required: true,
    label: "Position",
    align: "left",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "MonthlyPrice",
    required: true,
    label: "Monthlay Price",
    align: "left",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "Action",
    required: true,
    label: "Action",
    align: "left",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
];

const seed = [
  {
    name: "",
  },
];

// we generate lots of rows here
let rows = [];
for (let i = 0; i < 10; i++) {
  rows = rows.concat(seed.slice(0).map((r) => ({ ...r })));
}
rows.forEach((row, index) => {
  row.index = index;
});

export default {
  components: {
    OneUnitModal,
  },
  setup() {
    return {
      columns,
      rows,
      slide: ref("first"),

      pagination: ref({
        rowsPerPage: 0,
      }),
    };
  },
  methods: {
    openOneUnit() {
      this.$refs.oneUnitModal.openOneUnit();
    },
  },
};
</script>

<style lang="sass" scoped>
.custom-caption
  text-align: center
  padding: 12px
  color: white
  background-color: rgba(0, 0, 0, .3)

.my-sticky-virtscroll-table
  /* height or max-height is important */
  height: 220px
  border: solid black 2px

  .q-table__top,
  .q-table__bottom,
  thead tr:first-child th /* bg color is important for th; just specify one */
    background-color: whitesmoke
    font-size: 15px
    border-bottom: solid 2px

  thead tr th
    position: sticky
    z-index: 1
  /* this will be the loading indicator */
  thead tr:last-child th
    /* height of all previous header rows */
    top: 48px
  thead tr:first-child th
    top: 0

  /* prevent scrolling behind sticky top row on focus */
  tbody
    /* height of all previous header rows */
    scroll-margin-top: 48px
</style>
