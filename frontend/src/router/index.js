// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import HomePage from "@/components/views/HomePage.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),

  routes: [
    {
      path: "/",
      name: "home",
      component: HomePage,
    },
    {
      path: "/register",
      name: "Register",
      component: () => import("@/components/views/Register.vue"),
    },

  ],

});

export default router;
