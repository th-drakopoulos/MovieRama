<template>
    <div class="container mt-2 bg-white">
        <nav class="navbar navbar-blue border-bottom">
            <!-- for logged-in user-->
            <div class="container-fluid" v-if="isLoggedIn">
                <router-link to="/" class="navbar-brand h1"
                    >MovieRama</router-link
                >
                <div class="d-flex">
                    <router-link to="/movies" class="nav-item nav-link"
                        >Movies</router-link
                    >
                    <a
                        class="nav-item nav-link"
                        style="cursor: pointer"
                        @click="logout"
                        >Logout</a
                    >
                </div>
            </div>
            <!-- for non-logged user-->
            <div class="container-fluid" v-else>
                <router-link to="/" class="nav-item nav-link h1"
                    >MovieRama</router-link
                >
                <div class="d-flex">
                    <router-link to="/login" class="nav-item nav-link"
                        >Login</router-link
                    >
                    <router-link to="/register" class="nav-item nav-link"
                        >Register
                    </router-link>
                </div>
            </div>
        </nav>
        <br />
        <router-view />
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,
        };
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
        }
    },
    methods: {
        logout(e) {
            console.log("ss");
            e.preventDefault();
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .post("/api/logout")
                    .then((response) => {
                        if (response.data.success) {
                            window.location.href = "/";
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        },
    },
};
</script>
