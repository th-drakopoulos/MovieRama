import { createWebHistory, createRouter } from 'vue-router'

import Register from '../pages/Register.vue'
import Login from '../pages/Login.vue'

import Movies from '../components/Movies.vue'
import AddMovie from '../components/AddMovie.vue'

export const routes = [
  {
    name: 'home',
    path: '/',
    component: Movies
  },
  {
    name: 'register',
    path: '/register',
    component: Register
  },
  {
    name: 'login',
    path: '/login',
    component: Login
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes: routes
})

export default router
