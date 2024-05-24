<template>
  <div>
    <q-layout view="hHh Lpr lff" container style="height: 100vh">
      <q-header elevated :class="$q.dark.isActive ? 'bg-secondary' : 'bg-gray-800'">
        <q-toolbar>
          <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
          <q-toolbar-title>Admin Dashboard</q-toolbar-title>
        </q-toolbar>
      </q-header>

      <q-drawer v-model="drawer" show-if-above :mini="miniState" @mouseover="miniState = false"
        @mouseout="miniState = true" mini-to-overlay :width="200" :breakpoint="500" bordered
        :class="$q.dark.isActive ? 'bg-grey-9' : 'bg-gray-800 text-white'">
        <q-scroll-area class="fit" :horizontal-thumb-style="{ opacity: 0 }">
          <q-list padding>
            <!-- Profile -->
            <router-link to="/admin/Profile">
              <q-item clickable v-ripple @click="selectItem('Profile')"
                :class="{ 'q-item-active': selectedItem === 'Profile' }">
                <q-item-section avatar>
                  <i class="fa-solid fa-user text-lg"></i>
                </q-item-section>
                <q-item-section> Profile </q-item-section>
              </q-item>
            </router-link>

            <!-- Dashboard -->
            <router-link to="/admin/Dashboard">
              <q-item clickable v-ripple @click="selectItem('Dashboard')"
                :class="{ 'q-item-active': selectedItem === 'Dashboard' }">
                <q-item-section avatar>
                  <i class="fa-solid fa-house text-lg"></i>
                </q-item-section>
                <q-item-section> Dashboard </q-item-section>
              </q-item>
            </router-link>

            <router-link to="/admin/UnitSelection">
              <q-item clickable v-ripple @click="selectItem('UnitSelection')"
                :class="{ 'q-item-active': selectedItem === 'UnitSelection' }">
                <q-item-section avatar>
                  <i class="fa-solid fa-building text-lg"></i>
                </q-item-section>
                <q-item-section> Unit Selection </q-item-section>
              </q-item>
            </router-link>

            <router-link to="/admin/AcquireUnit">
              <q-item clickable v-ripple @click="selectItem('AquiringUnit')"
                :class="{ 'q-item-active': selectedItem === 'AquiringUnit' }">
                <q-item-section avatar>
                  <i class="fa-solid fa-cart-shopping text-lg"></i>
                </q-item-section>
                <q-item-section> Acquiring Unit </q-item-section>
              </q-item>
            </router-link>

            <router-link to="/admin/ClientManagement">
              <q-item clickable v-ripple @click="selectItem('ClientAcc')"
                :class="{ 'q-item-active': selectedItem === 'ClientAcc' }">
                <q-item-section avatar>
                  <i class="fa-solid fa-users text-lg"></i>
                </q-item-section>
                <q-item-section> Client Account </q-item-section>
              </q-item>
            </router-link>

            <router-link to="/admin/AdminManagement">
              <q-item clickable v-ripple @click="selectItem('AdminAcc')"
                :class="{ 'q-item-active': selectedItem === 'AdminAcc' }">
                <q-item-section avatar>
                  <i class="fa-solid fa-user-tie text-lg"></i>
                </q-item-section>
                <q-item-section> Admin Account </q-item-section>
              </q-item>
            </router-link>

            <router-link to="/">
              <q-item clickable v-ripple @click="logoutDashboard" :class="{ 'q-item-active': selectedItem === 'Logout' }">
                <q-item-section avatar>
                  <i class="fa-solid fa-right-from-bracket text-lg"></i>
                </q-item-section>
                <q-item-section> Log out </q-item-section>
              </q-item>
            </router-link>
            <!-- Add other router-links for your items -->
          </q-list>
        </q-scroll-area>
      </q-drawer>

      <q-page-container>
        <q-page padding>
          <router-view></router-view>
        </q-page>
      </q-page-container>
    </q-layout>
  </div>
</template>

<script>
import { ref } from "vue";
import { simulateLogout } from '../../router/auth.js'

export default {
  setup() {
    const drawer = ref(false);
    const miniState = ref(true);
    const selectedItem = ref(null);

    function selectItem(item) {
      selectedItem.value = item;
    }

    return {
      drawer,
      miniState,
      selectedItem,
      selectItem,
    };
  },
  methods: {
    logoutDashboard() {
      simulateLogout();
      this.$router.push('/')
    }
  }
};
</script>

<style>
.q-item-active {
  background-color: #4a90e2;
  /* Set the background color for the active state */
  color: #ffffff;
  /* Set the text color for the active state */
}
</style>
