<template>
  <div
    v-if="filteredUnits && filteredUnits.length > 0"
    class="carousel-container"
  >
    <div
      v-for="(room, index) in filteredUnits"
      :key="room.room_id"
      class="carousel-slide"
      :class="{ active: index === currentIndex }"
    >
      <img
        :src="
          'http://localhost/apartment-system/database/include/admin/' +
          room.imagePath
        "
        :alt="room.room_name"
      />
      <div class="caption">
        <h2>{{ room.room_name }}</h2>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="q-md">
    <q-btn
      class="q-ml-md mb-3 mt-5"
      color="primary"
      label="Create"
      @click.prevent="openCreateUnit"
      v-if="userType === 'admin'"
    />
    <q-table
      class="my-sticky-virtscroll-table"
      :virtual-scroll="false"
      :rows-per-page-options="[5]"
      :virtual-scroll-sticky-size-start="48"
      row-key="id"
      :rows="rows"
      :columns="columns"
    >
      <template v-slot:body-cell-action="props">
        <q-td :props="props">
          <q-btn
            v-if="userType === 'admin'"
            label="Remove"
            color="negative"
            @click="removeRow(props.row)"
            class="m-0.5"
          />
          <q-btn
            v-if="userType === 'user'"
            label="Rent"
            color="blue"
            class="m-0.5"
            @click="showSelectDialog(props.row)"
          ></q-btn>
        </q-td>
      </template>
    </q-table>
  </div>

  <createUnit ref="createUnit" />

  <!-- Custom Modal for Removing a Unit -->
  <div
    v-if="removeDialogVisible"
    class="relative z-10"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div
      class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
    ></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div
        class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
      >
        <div
          class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
        >
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div
                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
              >
                <svg
                  class="h-6 w-6 text-red-600"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                  />
                </svg>
              </div>
              <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3
                  class="text-base font-semibold leading-6 text-gray-900"
                  id="modal-title"
                >
                  Are you sure you want to remove this unit?
                </h3>
                <div class="text-body2">
                  <br />
                  Unit No: {{ selectedUnit.unitno }} Unit Name:
                  {{ selectedUnit.unitname }}
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <button
              type="button"
              @click="confirmRemove"
              class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto"
            >
              Yes, Proceed
            </button>
            <button
              type="button"
              @click="cancelRemove"
              class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Custom Modal for Selecting a Unit -->
  <div
    v-if="selectDialogVisible"
    class="relative z-10"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div
      class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
    ></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div
        class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
      >
        <div
          class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
        >
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div
                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10"
              >
                <svg
                  class="h-6 w-6 text-green-600"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                  />
                </svg>
              </div>
              <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3
                  class="text-base font-semibold leading-6 text-gray-900 mb-3"
                  id="modal-title"
                >
                  Unit Selected
                </h3>
                <div class="text-body">
                  <div class="m-1">
                    Unit No: <strong>{{ selectedUnit.unitno }}</strong>
                  </div>
                  <div class="m-1">
                    Unit Name: <strong>{{ selectedUnit.unitname }}</strong>
                  </div>
                  <div class="m-1">
                    Unit Type: <strong>{{ selectedUnit.unittype }}</strong>
                  </div>
                  <div class="m-1">
                    Monthly Price:
                    <strong
                      >Php {{ selectedUnit.unitprice.toLocaleString() }}</strong
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <button
              type="button"
              @click="confirmSelect"
              class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto"
            >
              Yes, Proceed to Payment
            </button>
            <button
              type="button"
              @click="showContractDialog"
              class="inline-flex justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:w-auto"
            >
              View Contract
            </button>
            <button
              type="button"
              @click="cancelSelect"
              class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Contract -->
  <!-- Modal for Contract -->
<div
  v-if="contractDialogVisible"
  class="fixed inset-0 z-10 w-screen overflow-y-auto"
  role="dialog"
  aria-modal="true"
>
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
  <div
    class="flex min-h-full items-center justify-center p-4 text-center sm:p-0"
  >
    <div
      class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
    >
      <div
        class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 contract-modal-content"
      >
        <h3 class="text-lg font-bold mb-3">Rental Contract</h3>
        <div class="text-left">
          <p><strong>Name:</strong> {{ userName }}</p>
          <p><strong>Unit No:</strong> {{ selectedUnit.unitno }}</p>
          <p><strong>Unit Name:</strong> {{ selectedUnit.unitname }}</p>
          <p><strong>Content:</strong></p>
          <p>
            This contract outlines the agreement between the renter and the
            property owner for renting the selected unit. The renter agrees to
            pay the monthly rent and adhere to the property guidelines,
            maintaining the unit in good condition throughout the lease.
          </p>
        </div>
        <!-- Signature Section -->
        <div class="signature-section mt-5">
          <div class="flex justify-between mt-5">
            <div class="w-1/2 text-center">
              <p>_________________________</p>
              <p class="mt-1">Renter Signature</p>
            </div>
            <div class="w-1/2 text-center">
              <p>_________________________</p>
              <p class="mt-1">Owner Signature</p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse">
        <button
          type="button"
          @click="printContract"
          class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:w-auto"
        >
          Print
        </button>
        <button
          type="button"
          @click="closeContractDialog"
          class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto"
        >
          Close
        </button>
      </div>
    </div>
  </div>
</div>


  <PaymentMethodModal ref="paymentMethodModalRef" />
</template>

<script>
import PaymentMethodModal from "src/pages/paymentModeModal.vue";
import { ref, onMounted, nextTick } from "vue";
import createUnit from "src/pages/createUnit.vue";

export default {
  components: {
    createUnit,
    PaymentMethodModal,
  },

  computed: {
    userType() {
      return sessionStorage.getItem("userType");
    },
  },

  methods: {
    openCreateUnit() {
      this.$refs.createUnit.openModal();
    },

    closeCreateUnit() {
      this.showCreateUnit = false;
    },
  },

  setup() {
    const paymentMethodModalRef = ref(null);
    const removeDialogVisible = ref(false);
    const selectDialogVisible = ref(false);
    const contractDialogVisible = ref(false);
    const userName = ref("");
    const selectedUnit = ref(null);
    const filteredUnits = ref([]);
    const slide = ref("first");
    const currentIndex = ref(0);

    const fetchCarouselData = async () => {
      try {
        const response = await fetch(
          "http://localhost/apartment-system/database/include/admin/allrooms.php"
        );
        const data = await response.json();
        if (data.success) {
          filteredUnits.value = data.rooms.filter((room) =>
            ["Studio Unit", "One Bed", "Two Bed"].includes(room.room_name)
          );
          console.log(filteredUnits.value);
        } else {
          console.error("Error fetching rooms:", data.message);
        }
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };

    onMounted(() => {
      fetchCarouselData();
      fetchData();
      startAutoScroll();
      const userData = JSON.parse(sessionStorage.getItem("userData"));
      console.log("User Data:", userData); // Check if 'name' is present
      userName.value = `${userData.givenname} ${userData.surname}` || "N/A";
    });

    const startAutoScroll = () => {
      setInterval(() => {
        currentIndex.value =
          (currentIndex.value + 1) % filteredUnits.value.length;
      }, 3000); // Change every 3 seconds
    };

    const columns = [
      {
        name: "unitno",
        required: true,
        label: "Unit no.",
        field: "unitno",
        format: (val) => `${val}`,
        align: "left",
        sortable: true,
      },
      {
        name: "unitname",
        required: true,
        label: "Unit Name",
        field: "unitname",
        format: (val) => `${val}`,
        align: "left",
        sortable: true,
      },
      // {
      //   name: "unitstatus",
      //   required: true,
      //   label: "Status",
      //   field: "unitstatus",
      //   format: (val) => `${val}`,
      //   align: "left",
      //   sortable: true,
      // },
      {
        name: "unitposition",
        required: true,
        label: "Position",
        field: "unitposition",
        format: (val) => `${val}`,
        align: "left",
        sortable: true,
      },
      {
        name: "unitprice",
        required: true,
        label: "Monthly Price",
        field: "unitprice",
        format: (val) => `Php ${val.toLocaleString()}`,
        align: "left",
        sortable: true,
      },
      {
        name: "unittype",
        required: true,
        label: "Unit Type",
        field: "unittype",
        format: (val) => `${val}`,
        align: "left",
        sortable: true,
      },
      {
        name: "action",
        required: true,
        label: "",
        align: "left",
        field: "id",
        sortable: false,
        "body-cell-action": true, // This indicates that this column contains custom action cells
        format: (val, row) => ({ row, val }), // Include row data in the format function
      },
    ];

    const showSelectDialog = (row) => {
      selectedUnit.value = row;
      selectDialogVisible.value = true;
    };

    const cancelSelect = () => {
      selectDialogVisible.value = false;
      selectedUnit.value = null;
    };

    const removeRow = async (row) => {
      selectedUnit.value = row;
      removeDialogVisible.value = true;
    };

    const showRemoveDialog = (row) => {
      selectedUnit.value = row;
      removeDialogVisible.value = true;
    };

    const cancelRemove = () => {
      removeDialogVisible.value = false;
      selectedUnit.value = null;
    };

    const rows = ref([]);
    const pagination = ref({
      rowsPerPage: 5,
    }); // Fetch user's name

    const showContractDialog = () => {
      contractDialogVisible.value = true;
    };

    const closeContractDialog = () => {
      contractDialogVisible.value = false;
    };

    const printContract = () => {
      const printArea = document
        .querySelector(".contract-modal-content")
        .cloneNode(true);
      const printWindow = window.open("", "_blank", "width=800,height=600");

      if (printWindow) {
        printWindow.document.open();
        printWindow.document.write(`
      <html>
        <head>
          <title>Print Contract</title>
        </head>
        <style>
           @media print {
    @page {
      margin: 0; /* Removes default margin */
    }
    body {
      margin: 1cm; /* Custom margin to ensure content fits well */
    }
    /* Hide browser's default header and footer */
    html, body {
      display: block;
      width: 100%;
      overflow: visible;
    }
  }
        </style>
        <body>
          ${printArea.outerHTML}
        </body>
      </html>
    `);
        printWindow.document.close();

        // Ensure the printWindow prints and closes properly
        printWindow.onload = () => {
          printWindow.print();
          printWindow.onafterprint = () => {
            printWindow.close();
            console.log("Restored Unit Selected modal state");
            // Restore modal states
            contractDialogVisible.value = false;
            selectDialogVisible.value = true;
          };
        };
      } else {
        console.error("Failed to open print window.");
      }
    };

    const fetchData = async () => {
      try {
        const response = await fetch(
          "http://localhost/apartment-system/database/include/admin/unitSelection.php"
        );
        const data = await response.json();
        rows.value = data.map((row) => ({ ...row }));
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };

    const confirmRemove = async () => {
      try {
        console.log("Before fetch request");
        const response = await fetch(
          "http://localhost/apartment-system/database/include/admin/unitSelection.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              action: "remove",
              id: selectedUnit.value.id,
            }),
          }
        );
        console.log("After fetch request");

        const result = await response.json();

        if (response.ok) {
          console.log(result.message);
          window.location.reload();
        } else {
          console.error(result.error);
        }
      } catch (error) {
        console.error("Error removing unit:", error);
      } finally {
        removeDialogVisible.value = false;
        selectedUnit.value = null;
      }
    };

    const confirmSelect = async () => {
      try {
        const response = await fetch(
          "http://localhost/apartment-system/database/include/admin/unitSelection.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              action: "acquire",
              userId: JSON.parse(sessionStorage.getItem("userData")).id, // Fetch the user ID
              unitId: selectedUnit.value.id, // The selected unit's ID
            }),
          }
        );

        // Check if the response is OK
        if (!response.ok) {
          throw new Error(`Error: ${response.status}`);
        }

        const result = await response.json();

        if (result.message) {
          console.log("Unit acquired successfully:", result.message);

          // Get current userData from sessionStorage
          const userData = JSON.parse(sessionStorage.getItem("userData"));

          // If the user already has acquired units, append the new one, else create the array
          if (userData.acquiredUnits) {
            userData.acquiredUnits.push(selectedUnit.value);
          } else {
            userData.acquiredUnits = [selectedUnit.value];
          }

          // Update sessionStorage with the newly acquired units
          sessionStorage.setItem("userData", JSON.stringify(userData));

          // Show the payment modal
          paymentMethodModalRef.value.showModal();
        } else {
          console.error(result.error);
        }
      } catch (error) {
        console.error("Error acquiring unit:", error.message || error);
      } finally {
        selectDialogVisible.value = false;
        selectedUnit.value = null;
      }
    };

    return {
      columns,
      rows,
      pagination,
      removeRow,
      removeDialogVisible,
      showRemoveDialog,
      cancelRemove,
      selectedUnit,
      confirmRemove,

      selectDialogVisible,
      showSelectDialog,
      cancelSelect,

      confirmSelect,
      paymentMethodModalRef,

      filteredUnits,
      slide,
      currentIndex,

      contractDialogVisible,
      userName,
      showContractDialog,
      closeContractDialog,
      printContract,
    };
  },
};
</script>

<style lang="sass" scoped>

.carousel-container
  display: flex
  overflow: hidden
  width: 100%
  height: 300px
  position: relative
  box-shadow: 0 0 50px #ccc
  border-radius: 20px

.carousel-slide
  flex: 0 0 100%
  opacity: 0
  transition: opacity 0.5s ease
  position: absolute
  width: 100%
  height: 100%

  &.active
    opacity: 1
    position: relative

  img
    width: 100%
    height: 100%
    object-fit: cover

.caption
  position: absolute
  bottom: 20px
  left: 20px
  color: white
  background-color: rgba(0, 0, 0, 0.5)
  padding: 10px
  border-radius: 4px
  h2
    margin: 0
    font-size: 1.5em

.custom-caption
  text-align: center
  padding: 12px
  color: white
  background-color: rgba(0, 0, 0, .3)

.my-sticky-virtscroll-table
  /* height or max-height is important */
  height: 380px
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
