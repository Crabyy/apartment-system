export default store(function (/* { ssrContext } */) {
  const Store = createStore({
    state: {
      isAuthenticated: false,
      userRole: "",
      userId: "",
      profileData: {},
    },
    mutations: {
      setAuth(state, { isAuthenticated, userRole, userId }) {
        state.isAuthenticated = isAuthenticated;
        state.userRole = userRole;
        state.userId = userId;
      },
      setProfileData(state, profileData) {
        state.profileData = profileData;
      },
      clearAuth(state) {
        state.isAuthenticated = false;
        state.userRole = "";
        state.userId = "";
        state.profileData = {};
      },
    },
    actions: {
      login({ commit }, { isAuthenticated, userRole, userId }) {
        commit("setAuth", { isAuthenticated, userRole, userId });
      },
      logout({ commit }) {
        commit("clearAuth");
      },
      setProfile({ commit }, profileData) {
        commit("setProfileData", profileData);
      },
    },
    getters: {
      isAuthenticated: (state) => state.isAuthenticated,
      userRole: (state) => state.userRole,
      userId: (state) => state.userId,
      profileData: (state) => state.profileData,
    },
  });

  return Store;
});
