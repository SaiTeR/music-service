import { createRouter, createWebHistory } from 'vue-router'
import SignUp from '@/components/SignUp.vue'
import Login from '@/components/Login.vue'
import IndexPage from "@/components/IndexPage.vue";
import MainPage from "@/components/HomePage.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'IndexPage',
      component: IndexPage
    },

    {
      path: '/signup',
      name: 'signup',
      component: SignUp
    },

    {
      path: '/login',
      name: 'login',
      component: Login
    },

    {
      path: '/home',
      name: 'HomePage',
      component: MainPage
    },
  ]
})

export default router
