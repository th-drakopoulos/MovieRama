<template>
  <nav class="navbar navbar-blue mb-3">
    <!-- for logged-in user-->
    <div class="container-fluid" v-if="isLoggedIn">
      <router-link to="/" class="navbar-brand h1">MovieRama</router-link>
      <div class="d-flex">
        <router-link to="/movies" class="nav-item nav-link">Movies</router-link>
        <a class="nav-item nav-link" @click="logout">Logout</a>
      </div>
    </div>
    <!-- for non-logged user-->
    <div class="container-fluid" v-else>
      <router-link to="/" class="nav-item nav-link h1">MovieRama</router-link>
      <div class="d-flex align-items-center">
        <router-link to="/login" class="nav-item nav-link">Login</router-link>
        <span>Or</span>
        <router-link to="/register" class="nav-item nav-link"
          >Register
        </router-link>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  props: {
    isLoggedIn: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    logout() {
      this.$emit('logout')
    }
  }
}
</script>

<style lang="scss" scoped>
a {
  cursor: pointer;
}
</style>
