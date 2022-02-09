import { createWebHistory, createRouter } from "vue-router";

import Home from "../pages/Home.vue";
import Register from "../pages/Register.vue";
import Login from "../pages/Login.vue";

import Movies from "../components/Movies.vue";
import AddMovie from "../components/AddMovie.vue";

export const routes = [
    {
        name: "home",
        path: "/",
        component: Home,
    },
    {
        name: "register",
        path: "/register",
        component: Register,
    },
    {
        name: "login",
        path: "/login",
        component: Login,
    },
    {
        name: "movies",
        path: "/movies",
        component: Movies,
    },
    {
        name: "addmovie",
        path: "/movies/add",
        component: AddMovie,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
