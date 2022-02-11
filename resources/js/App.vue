<template>
  <div class="container mt-2 bg-white vh-100 mb-3">
    <Navbar @logout="logout" :isLoggedIn="isLoggedIn" />
    <div class="row mb-3" v-if="twoColumns">
      <div class="col-md-8">
        <router-view />
      </div>
      <div class="col-md-4"></div>
    </div>
    <div class="row mb-3" v-else>
      <router-view :key="path" />
    </div>

    <br />
  </div>
</template>

<script>
import Navbar from './components/TheNavBar'

export default {
  name: 'App',
  components: {
    Navbar
  },
  data() {
    return {
      isLoggedIn: false,
      movies: null,
      staticRoutes: []
    }
  },
  computed: {
    twoColumns() {
      return !(this.$route.name === 'login' || this.$route.name === 'register')
    },
    path() {
      return this.staticRoutes.includes(this.$route.name)
        ? 'static'
        : this.$route.fullPath
    }
  },
  created() {
    if (window.Laravel.isLoggedin) {
      this.isLoggedIn = true
    }
    console.log(this.$route.params)
  },
  methods: {
    logout(e) {
      e.preventDefault()
      this.$axios.get('/sanctum/csrf-cookie').then((response) => {
        this.$axios
          .post('/api/logout')
          .then((response) => {
            if (response.data.success) {
              window.location.href = '/'
            } else {
              console.log(response)
            }
          })
          .catch(function (error) {
            console.error(error)
          })
      })
    }
  }
}
</script>
