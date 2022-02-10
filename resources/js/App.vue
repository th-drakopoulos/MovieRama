<template>
  <div class="container mt-2 bg-white">
    <Navbar @logout="logout" />
    <SortBar />
    <router-view />
  </div>
</template>

<script>
import Navbar from './components/TheNavBar'
import SortBar from './components/TheSortBar'
export default {
  name: 'App',
  components: {
    Navbar,
    SortBar
  },
  data() {
    return {
      isLoggedIn: false
    }
  },
  created() {
    if (window.Laravel.isLoggedin) {
      this.isLoggedIn = true
    }
  },
  methods: {
    logout(e) {
      console.log('ss')
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
