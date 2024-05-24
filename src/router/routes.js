import { checkIfUserIsAuthenticated } from "./auth";

const routes = [
  {
    path: "/",
    name: "Home",
    component: () => import("../components/Dashboard.vue"),
  },

  {
    path: "/",
    name: "SignIn",
    component: () => import("../layouts/SignInLayout.vue"),
  },

  {
    path: "/",
    component: () => import("../layouts/SideBar.vue"),
    children: [
      {
        path: "/Profile",
        name: "Profile",
        component: () => import("../components/ProfileComponent.vue"),
      },
      {
        path: "/Dashboard",
        name: "Dashboard",
        component: () => import("../components/Dashboard.vue"),
      },
      // {
      //   path: "/AcquireUnit",
      //   name: "AcquireUnit",
      //   component: () => import("../components/AcquireUnit.vue"),
      //   props: (route) => ({ unitData: route.params.unitData }),
      // },

      {
        path: "/ClientAccount",
        name: "ClientAccountManagement",
        component: () => import("../components/ClientAccountManagement.vue"),
      },
      {
        path: "/AdminAccount",
        name: "AdminAccountManagement",
        component: () => import("../components/AdminAccountManagement.vue"),
      },
      {
        path: "/UnitSelection",
        name: "UnitSelection",
        component: () => import("../components/UnitSelection.vue"),
      },
      {
        path: "/UnitOccupied",
        name: "UnitOccupied",
        component: () => import("../components/UnitOccupied.vue"),
      },
      // {
      //   path: "/StudioUnit",
      //   name: "StudioUnit",
      //   component: () => import("../components/StudioUnit.vue"),
      // },
      // {
      //   path: "/OneBedUnit",
      //   name: "OneBedUnit",
      //   component: () => import("../components/OneBedUnit.vue"),
      // },
      // {
      //   path: "/TwoBedUnit",
      //   name: "TwoBedUnit",
      //   component: () => import("../components/TwoBedUnit.vue"),
      // },
    ],
    beforeEnter: (to, from, next) => {
      if (checkIfUserIsAuthenticated()) {
        next();
      } else {
        // Redirect to the root path for unauthorized access
        next("/");
      }
    },
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
