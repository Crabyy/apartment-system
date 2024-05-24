<template>
  <div class="q-pa-md">
    <q-table class="monggos" flat bordered ref="tableRef" :rows="rows" :columns="columns" row-key="id"
      v-model:selected="selected" @selection="handleSelection">
      <template v-slot:header-selection="scope">
        <q-checkbox v-model="scope.selected" />
      </template>

      <template v-slot:top-left>
        <div class="q-mb-md"> <!-- Adjust the margin-bottom as needed -->
          <h2 class="text-h6 inline">Admins' Account Management</h2>
          <div class="q-mt-md"> <!-- Adjust the margin-top as needed -->
            <q-btn label="Create" color="primary" @click.prevent="openAdminRegister" />
          </div>
        </div>
      </template>

      <template v-slot:body-selection="scope">
        <q-checkbox :model-value="scope.selected"
          @update:model-value="(val, evt) => { Object.getOwnPropertyDescriptor(scope, 'selected').set(val, evt) }" />
      </template>

      <!-- remove button -->
      <template v-slot:body-cell-action="props">
        <q-td :props="props">
          <q-btn label="Remove" color="negative" @click="removeRow(props.row)" />
        </q-td>
      </template>

      <!-- search bar -->
      <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

    </q-table>

    <!-- Custom Modal for Removing a User -->
    <div v-if="removeDialogVisible" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <div
            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div
                  class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <!-- Replace with your custom icon or content -->
                  <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                  </svg>
                </div>
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                  <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Are you sure you want to
                    remove this user?</h3>
                  <div class="text-body2">
                    <br>
                    Admin: {{ selectedUser.surname }}, {{ selectedUser.givenname }} {{ selectedUser.middlename }}
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
              <button type="button" @click="confirmRemove"
                class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto">Yes,
                Proceed</button>
              <button type="button" @click="cancelRemove"
                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <AdminRegister ref="adminRegisterModal" />

  </div>
</template>

<script>
import { ref, watch, onMounted } from 'vue';
import AdminRegister from '../../pages/AdminRegister.vue';


export default {

  components: {
    AdminRegister,
  },

  data() {
    return {
      showAdminRegister: false,
    };
  },

  methods: {
    openAdminRegister() {
      this.$refs.adminRegisterModal.openModal();
    },

    closeAdminRegister() {
      this.showAdminRegister = false;
    },
  },

  setup() {
    const tableRef = ref();
    const selected = ref([]);
    const originalRows = ref([]); // Store the original data separately
    const rows = ref([]);
    const filter = ref('');
    const removeDialogVisible = ref(false);
    const selectedUser = ref(null);

    const fetchData = async () => {
      try {
        const response = await fetch('http://localhost/system/database/include/admin/adminTable.php');
        const data = await response.json();
        originalRows.value = data;
        rows.value = data; // Initialize both original and current rows
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    };

    onMounted(fetchData);

    const columns = [
      {
        name: 'surname',
        required: true,
        label: 'Surname',
        align: 'left',
        field: 'surname',
        format: val => `${val}`,
        sortable: true,
      },
      {
        name: 'givenname',
        required: true,
        label: 'Given Name',
        align: 'left',
        field: 'givenname',
        format: val => `${val}`,
        sortable: true,
      },
      {
        name: 'middlename',
        required: true,
        label: 'Middle Name',
        align: 'left',
        field: 'middlename',
        format: val => `${val}`,
        sortable: true,
      },
      {
        name: 'email',
        required: true,
        label: 'Email',
        align: 'left',
        field: 'email',
        format: val => `${val}`,
        sortable: true,
      },
      {
        name: 'username',
        required: true,
        label: 'Username',
        align: 'left',
        field: 'username',
        format: val => `${val}`,
        sortable: true,
      },
      {
        name: 'birthdate',
        required: true,
        label: 'Birthdate',
        align: 'left',
        field: 'birthdate',
        format: val => {
          const date = new Date(val);
          const options = { month: 'long', day: 'numeric', year: 'numeric' };
          return date.toLocaleDateString('en-US', options);
        },
        sortable: true,
      },
      {
        name: 'gender',
        required: true,
        label: 'Gender',
        align: 'left',
        field: 'gender',
        format: val => `${val}`,
        sortable: true,
      },
      {
        name: 'action',
        required: true,
        label: 'Action',
        align: 'left',
        field: 'id', // Assuming 'id' is a unique identifier for your rows
        format: val => `${val}`,
        sortable: false,
      },
    ];

    const removeRow = async (row) => {
      selectedUser.value = row;
      removeDialogVisible.value = true;
    };

    const showRemoveDialog = (row) => {
      selectedUser.value = row;
      removeDialogVisible.value = true;
    };

    const cancelRemove = () => {
      removeDialogVisible.value = false;
      selectedUser.value = null;
    };

    const confirmRemove = async () => {
      try {
        const response = await fetch('http://localhost/system/database/include/adminTable.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            action: 'remove',
            id: selectedUser.value.id,
          }),
        });

        const result = await response.json();

        if (response.ok) {
          console.log(result.message);
          fetchData(); // Refresh the data after removal
        } else {
          console.error(result.error);
        }
      } catch (error) {
        console.error('Error removing account:', error);
      } finally {
        removeDialogVisible.value = false;
        selectedUser.value = null;
      }
    };

    const handleSelection = ({ rows }) => {
      if (rows.length === 1) {
        const [newSelectedRow] = rows;
        selected.value = [newSelectedRow];
      }
    };

    const applyFilter = () => {
      const keywords = filter.value.toLowerCase().trim().split(/\s+/); // Split search string into words
      rows.value = keywords.length > 0
        ? originalRows.value.filter(row => {
          return columns.some(column => {
            if (['surname', 'givenname', 'middlename'].includes(column.field)) {
              const fullName = `${row['surname']}, ${row['givenname']} ${row['middlename']}`.toLowerCase();
              // Check if all keywords are present in the full name
              return keywords.every(keyword => fullName.includes(keyword));
            } else if (column.field === 'birthdate') {
              const date = new Date(row[column.field]);
              const formattedDate = date.toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric',
              });
              return formattedDate.toLowerCase().includes(keywords.join(' ')); // Join keywords for date search
            } else {
              const fieldValue = String(row[column.field]).toLowerCase();
              return keywords.every(keyword => fieldValue.includes(keyword));
            }
          });
        })
        : [...originalRows.value];
    };
    watch(filter, applyFilter);

    return {
      tableRef,
      selected,
      columns,
      rows,
      handleSelection,
      removeRow,
      removeDialogVisible,
      showRemoveDialog,
      cancelRemove,
      confirmRemove,
      selectedUser,
      filter,
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
