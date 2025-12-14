// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import Register from "@/components/views/Register.vue";
import App from "@/App.vue";

const routes = [
  {
    path: '/',
    name: 'App',
    component: App
  },
  {
    path: '/register',  // URL путь
    name: 'Register',   // имя маршрута
    component: Register // компонент для отображения
  },
]

const router = createRouter({
  history: createWebHistory(),  // чистые URL
  routes
})

export default router
