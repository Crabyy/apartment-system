<template>
  <div class="q-pa-md">
    <q-table
      class="monggos"
      flat
      bordered
      ref="tableRef"
      :rows="rows"
      :columns="columns"
      row-key="id"
      v-model:selected="selected"
      @selection="handleSelection"
    >
      <template v-slot:top-left>
        <div class="q-mb-sm">
          <h2 class="text-h6 inline">Unavailable & Occupied Units</h2>
        </div>
      </template>

      <!-- User who acquired the unit -->
      <template v-slot:body-cell-acquired_by="props">
        <q-td :props="props">
          <span v-if="props.row.username">{{ props.row.username }}</span>
          <span v-else>N/A</span>
        </q-td>
      </template>

      <!-- Recover button -->
      <template v-slot:body-cell-action="props">
        <q-td :props="props">
          <q-btn label="Recover" color="green" @click="removeRow(props.row)" />
        </q-td>
      </template>
    </q-table>

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
                    Are you sure you want to recover this unit?
                  </h3>
                  <div class="text-body2">
                    <div class="m-1">
                      Unit No: <strong>{{ selectedUser.unitno }}</strong>
                    </div>
                    <div class="m-1">
                      Unit Name: <strong>{{ selectedUser.unitname }}</strong>
                    </div>
                    <div class="m-1">
                      Unit Type: <strong>{{ selectedUser.unittype }}</strong>
                    </div>
                    <div class="m-1">
                      Monthly Price:
                      <strong
                        >Php
                        {{ selectedUser.unitprice.toLocaleString() }}</strong
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
            >
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
  </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
  setup() {
    const rows = ref([]);
    const removeDialogVisible = ref(false);
    const selectedUser = ref(null);

    const fetchData = async () => {
      try {
        const response = await fetch(
          "http://localhost/apartment-system/database/include/admin/unitOccupied.php"
        );
        const data = await response.json();
        rows.value = data;
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };

    onMounted(fetchData);

    const removeRow = (row) => {
      selectedUser.value = row;
      removeDialogVisible.value = true;
    };

    const cancelRemove = () => {
      removeDialogVisible.value = false;
      selectedUser.value = null;
    };

    const confirmRemove = async () => {
      try {
        const response = await fetch(
          "http://localhost/apartment-system/database/include/admin/unitOccupied.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              action: "recover",
              id: selectedUser.value.id,
            }),
          }
        );

        const result = await response.json();
        if (response.ok) {
          console.log(result.message);
          fetchData(); // Refresh the data after recovery
        } else {
          console.error(result.error);
        }
      } catch (error) {
        console.error("Error recovering unit:", error);
      } finally {
        removeDialogVisible.value = false;
        selectedUser.value = null;
      }
    };

    const columns = [
      { name: "unitno", label: "Unit No.", field: "unitno", sortable: true },
      {
        name: "unitname",
        label: "Unit Name",
        field: "unitname",
        sortable: true,
      },
      {
        name: "unitposition",
        label: "Unit Position",
        field: "unitposition",
        sortable: true,
      },
      {
        name: "unitprice",
        label: "Unit Price",
        field: "unitprice",
        sortable: true,
        format: (val) => `Php ${val.toLocaleString()}`,
      },
      {
        name: "unittype",
        label: "Unit Type",
        field: "unittype",
        sortable: true,
      },
      {
        name: "acquired_by",
        label: "Acquired By",
        field: "username",
        sortable: true,
      }, // Display who acquired the unit
      { name: "action", label: "Action", field: "id", sortable: false },
    ];

    return {
      rows,
      columns,
      removeDialogVisible,
      selectedUser,
      removeRow,
      cancelRemove,
      confirmRemove,
    };
  },
};
</script>

<style scoped>
.monggos {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}
</style>
