<template>
  <div class="container mt-2 bg-white">
    <Navbar @logout="logout" :isLoggedIn="isLoggedIn" />

    <!-- <div class="row">
      <div class="col-md-8">
        <Movies />
      </div>
      <div class="col-md-4"></div>
    </div> -->
    <router-view />
  </div>
</template>

<script>
import Navbar from './components/TheNavBar'

export default {
  name: 'App',
  components: {
    Navbar,
    SortBar
  },
  data() {
    return {
      isLoggedIn: false,
      movies: null
    }
  },
  created() {
    if (window.Laravel.isLoggedin) {
      this.isLoggedIn = true
    }
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
