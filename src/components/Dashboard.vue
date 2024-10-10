<template>
  <div>
    <div class="row flex flex-col select-none">
      <!-- Toolbar -->
      <div class="relative">
        <q-toolbar>
          <q-toolbar-title v-if="userType === 'user'">Dashboard</q-toolbar-title>
          <q-toolbar-title v-if="userType === 'admin'">Admin Dashboard</q-toolbar-title>
          <q-btn v-if="!userType" class="absolute top-0 right-0 mt-2 mx-2 my-2 bg-blue" flat label="Sign In" @click="goToSignIn" />
        </q-toolbar>
      </div>

      <!-- Add New Room Button for Admins -->
      <div v-if="userType === 'admin'" class="flex justify-center my-4">
        <q-btn flat label="Add New Room" color="primary" @click="showAddRoomModal = true" />
      </div>

      <!-- Display Banners at the Top -->
      <div class="row flex flex-col mb-6">
        <div class="flex justify-center">
          <div v-for="room in filteredBanners" :key="room.room_id" class="banner-card rounded-lg mt-6 shadow-lg overflow-hidden w-full sm:w-2/3" @click="fetchRoomDetails(room.room_id)">
            <img :src="'http://localhost/system-main/database/include/admin/' + room.imagePath" :alt="room.bannerTitle" class="object-cover w-full h-40" />
            <div class="p-4 text-center">
              <div class="text-2xl font-bold text-black mb-2">{{ room.bannerTitle }}</div>
              <p class="text-lg font-semibold text-gray-800 whitespace-pre-wrap">{{ room.description }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Room Cards Display -->
      <div class="row flex flex-col">
        <div class="flex justify-center">
          <div v-for="room in filteredRooms" :key="room.room_id" class="room-card rounded-lg mt-10 m-auto ml-0 relative shadow-lg overflow-hidden" style="width: 400px; height: 350px; margin-right: 20px" @click="fetchRoomDetails(room.room_id)">
            <img :src="'http://localhost/system-main/database/include/admin/' + room.imagePath" :alt="room.room_name" class="object-cover w-full h-1/2" />
            <div class="text-2xl font-bold text-black mb-2 text-center">{{ room.room_name }}</div>
            <div class="p-4">
              <p class="text-lg font-semibold text-gray-800 mb-2 whitespace-pre-wrap">{{ room.description }}</p>
              <!-- Facilities Icons -->
              <div v-if="room.room_name !== 'Banner'" class="flex justify-around text-gray-600 mb-2">
                <div class="text-center">
                  <i class="fas fa-bed"></i>
                  <p class="text-xs">{{ room.room_name }}</p>
                </div>
                <div class="text-center">
                  <i class="fas fa-couch"></i>
                  <p class="text-xs">Living Room</p>
                </div>
                <div class="text-center">
                  <i class="fas fa-utensils"></i>
                  <p class="text-xs">Kitchen</p>
                </div>
                <div class="text-center">
                  <i class="fas fa-shower"></i>
                  <p class="text-xs">Bathroom</p>
                </div>
              </div>
              <div v-if="room.room_name !== 'Banner'" class="text-center text-lg font-bold text-green-600">Price: {{ formatPrice(room.price) }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Add Room Modal -->
      <q-dialog v-model="showAddRoomModal" persistent>
        <q-card style="min-width: 400px">
          <q-card-section>
            <div class="text-h5">Add New Room</div>
            <q-select v-model="newRoomData.room_name" label="Room Type" :options="roomTypeOptions" option-label="label" option-value="value" emit-value map-options />
            <q-input v-if="newRoomData.room_name === 'Banner'" v-model="newRoomData.bannerTitle" label="Banner Title" />
            <q-input v-model="newRoomData.description" label="Description" />
            <q-input v-if="newRoomData.room_name !== 'Banner'" v-model="newRoomData.price" label="Price" type="number" />
            <q-btn flat label="Select Image" color="primary" @click="triggerFileUpload('add')" />
            <input ref="fileInput" type="file" @change="handleFileChange('add')" style="display: none" />
            <img v-if="newRoomData.imagePreview" :src="newRoomData.imagePreview" class="w-full h-auto mt-2" alt="Room Image Preview" />
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat label="Add" color="primary" @click="showSaveConfirm = true" />
            <q-btn flat label="Cancel" color="primary" @click="showAddRoomModal = false" />
          </q-card-actions>
        </q-card>
      </q-dialog>

      <!-- Save Confirmation Dialog -->
      <q-dialog v-model="showSaveConfirm" persistent>
        <q-card>
          <q-card-section class="text-center">
            <div class="text-h5">Are you sure you want to add this room?</div>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat label="Cancel" color="primary" @click="showSaveConfirm = false" />
            <q-btn flat label="Confirm" color="primary" @click="confirmAddRoom" />
          </q-card-actions>
        </q-card>
      </q-dialog>

      <!-- Remove Confirmation Dialog -->
      <q-dialog v-model="showRemoveConfirm" persistent>
        <q-card>
          <q-card-section class="text-center">
            <div class="text-h5">Are you sure you want to remove this room?</div>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat label="Cancel" color="primary" @click="showRemoveConfirm = false" />
            <q-btn flat label="Confirm" color="red" @click="confirmRemoveRoom" />
          </q-card-actions>
        </q-card>
      </q-dialog>

      <!-- Room Details/Edit Modal -->
      <q-dialog v-model="showRoomDetails" persistent>
        <q-card style="min-width: 400px">
          <q-card-section class="text-center">
            <div class="text-h5 font-bold mb-2">{{ roomDetails.room_name }}</div>
            <q-input v-if="roomDetails.room_name === 'Banner'" v-model="roomDetails.bannerTitle" label="Banner Title" :readonly="userType !== 'admin'" />
            <img :src="roomDetails.imagePreview || 'http://localhost/system-main/database/include/admin/' + roomDetails.imagePath" alt="Room Image" class="object-cover w-full h-48 mb-4" />
            <q-btn v-if="userType === 'admin'" flat label="Change Image" color="primary" @click="triggerFileUpload('edit')" />
            <input ref="fileInputEdit" type="file" @change="handleFileChange('edit')" style="display: none" />
            <q-input v-model="roomDetails.description" label="Description" :readonly="userType !== 'admin'" />
            <q-input v-if="roomDetails.room_name !== 'Banner'" v-model="roomDetails.price" label="Price" type="number" :readonly="userType !== 'admin'" class="text-center text-lg font-bold text-green-600 mb-4" />
          </q-card-section>

          <q-card-actions align="right">
            <q-btn flat label="Close" color="primary" @click="showRoomDetails = false" />
            <q-btn v-if="userType === 'admin'" flat label="Save" color="primary" @click="saveRoomChanges" />
            <q-btn v-if="userType === 'admin'" flat label="Remove" color="red" @click.stop="removeRoom(roomDetails.room_id)" />
          </q-card-actions>
        </q-card>
      </q-dialog>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminDashboard",
  data() {
    return {
      banners: [],
      filteredRooms: [],
      roomDetails: {
        room_name: "",
        description: "",
        price: "",
        bannerTitle: "",
        imagePath: "",
        imagePreview: null,
      },
      newRoomData: {
        room_name: "",
        description: "",
        price: "",
        bannerTitle: "",
        image: null,
        imagePreview: null,
      },
      roomTypeOptions: [
        { label: "Banner", value: "Banner" },
        { label: "Studio Unit", value: "Studio Unit" },
        { label: "One Bed", value: "One Bed" },
        { label: "Two Bed", value: "Two Bed" },
      ],
      showRoomDetails: false,
      showAddRoomModal: false,
      showSaveConfirm: false,
      showRemoveConfirm: false,
      roomToRemove: null,
      userType: sessionStorage.getItem("userType"),
    };
  },

  mounted() {
    this.getAllRooms();
  },

  computed: {
    filteredBanners() {
      return this.banners.filter((room) => room.room_name === "Banner");
    },
  },

  methods: {
    goToSignIn() {
      this.$router.push({ name: "SignIn" });
    },

    getAllRooms() {
      fetch("http://localhost/system-main/database/include/admin/allrooms.php", {
        method: "GET",
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            this.banners = data.rooms;
            this.filteredRooms = data.rooms.filter((room) => room.room_name !== "Banner");
          } else {
            console.error("Error fetching rooms:", data.message);
          }
        })
        .catch((error) => {
          console.error("Fetch error:", error);
        });
    },

    fetchRoomDetails(room_id) {
      fetch(`http://localhost/system-main/database/include/admin/getroom.php?room_id=${room_id}`)
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            this.roomDetails = { ...data.room, imagePreview: null };
            this.showRoomDetails = true;
          } else {
            console.error("Error fetching room details:", data.message);
          }
        })
        .catch((error) => {
          console.error("Error fetching room details:", error);
        });
    },

    triggerFileUpload(context) {
      if (context === "add") {
        this.$refs.fileInput.click();
      } else if (context === "edit") {
        this.$refs.fileInputEdit.click();
      }
    },

    handleFileChange(context) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          if (context === "edit") {
            this.roomDetails.imagePreview = e.target.result;
            this.roomDetails.newImageFile = file;
          } else if (context === "add") {
            this.newRoomData.image = file;
            this.newRoomData.imagePreview = e.target.result;
          }
        };
        reader.readAsDataURL(file);
      }
    },

    addNewRoom() {
      const formData = new FormData();
      formData.append("room_name", this.newRoomData.room_name);
      formData.append("description", this.newRoomData.description);
      formData.append("price", this.newRoomData.room_name === "Banner" ? "" : this.newRoomData.price);
      formData.append("bannerTitle", this.newRoomData.bannerTitle || "");
      formData.append("image", this.newRoomData.image);

      fetch("http://localhost/system-main/database/include/admin/upload.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            this.getAllRooms();
            this.showAddRoomModal = false;
          } else {
            console.error("Error adding room:", data.message);
          }
        })
        .catch((error) => {
          console.error("Error adding room:", error);
        });
    },

    confirmAddRoom() {
      this.showSaveConfirm = false;
      this.addNewRoom();
    },

    saveRoomChanges() {
      const formData = new FormData();
      formData.append("room_id", this.roomDetails.room_id);
      formData.append("room_name", this.roomDetails.room_name);
      formData.append("description", this.roomDetails.description);
      formData.append("price", this.roomDetails.room_name === "Banner" ? "" : this.roomDetails.price);
      formData.append("bannerTitle", this.roomDetails.room_name === "Banner" ? this.roomDetails.bannerTitle : "");

      if (this.roomDetails.newImageFile) {
        formData.append("image", this.roomDetails.newImageFile);
      }

      fetch("http://localhost/system-main/database/include/admin/editroom.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            this.getAllRooms();
            this.showRoomDetails = false;
          } else {
            console.error("Error updating room:", data.message);
          }
        })
        .catch((error) => {
          console.error("Error updating room:", error);
        });
    },

    removeRoom(room_id) {
      this.roomToRemove = room_id;
      this.showRemoveConfirm = true;
    },

    confirmRemoveRoom() {
      fetch(`http://localhost/system-main/database/include/admin/removeroom.php?room_id=${this.roomToRemove}`, {
        method: "DELETE",
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            this.getAllRooms();
            this.showRemoveConfirm = false;
            this.roomToRemove = null;
          } else {
            console.error("Error removing room:", data.message);
          }
        })
        .catch((error) => {
          console.error("Error removing room:", error);
        });
    },

    formatPrice(price) {
      return new Intl.NumberFormat("en-PH", {
        style: "currency",
        currency: "PHP",
      }).format(price);
    },
  },
};
</script>

<style scoped>
.room-card {
  border: 1px solid #e0e0e0;
  border-radius: 12px;
  background-color: #ffffff;
  transition: transform 0.3s;
}
.room-card:hover {
  transform: scale(1.03);
}
.banner-card {
  border: 1px solid #e0e0e0;
  border-radius: 12px;
  background-color: #ffffff;
  width: 100%;
  transition: transform 0.3s;
  margin-bottom: 16px;
}
.banner-card:hover {
  transform: scale(1.02);
}
</style>
