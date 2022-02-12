<template>
  <div>
    <SortBar class="mb-4" @change-sort="changeSort" />
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div
        class="card mb-3"
        v-for="(movie, index) in movies"
        :key="'movie-' + index"
      >
        <Movie :movie="movie" @movie-by-user="movieByUser" />
      </div>
    </div>
  </div>
</template>

<script>
import SortBar from './TheSortBar'
import axios from 'axios'
import Movie from './Movie'
export default {
  components: {
    SortBar,
    Movie
  },
  data() {
    return {
      loading: false,
      movies: null,
      sortBy: ''
    }
  },
  async created() {
    try {
      this.loading = true
      const response = (await axios.get(`/api/movies`)).data
      if (response) {
        this.movies = response.data
      }
    } catch (error) {
      console.warn(error)
    } finally {
      this.loading = false
    }
  },
  methods: {
    // deleteBook(id) {
    //   this.$axios.get('/sanctum/csrf-cookie').then((response) => {
    //     this.$axios
    //       .delete(`/api/books/delete/${id}`)
    //       .then((response) => {
    //         let i = this.books.map((item) => item.id).indexOf(id) // find index of your object
    //         this.books.splice(i, 1)
    //       })
    //       .catch(function (error) {
    //         console.error(error)
    //       })
    //   })
    // },
    async changeSort(value) {
      try {
        this.loading = true
        const response = (await axios.get(`/api/movies/${value}`)).data
        if (response) {
          this.movies = response.data
        }
      } catch (error) {
        console.warn(error)
      } finally {
        this.loading = false
      }
    },
    async movieByUser(id) {
      try {
        this.loading = true
        const response = (await axios.get(`/api/movie-by-user/${id}`)).data
        if (response) {
          this.movies = response.data
        }
      } catch (error) {
        console.warn(error)
      } finally {
        this.loading = false
      }
    }
  }
  // beforeRouteEnter(to, from, next) {
  //   if (!window.Laravel.isLoggedin) {
  //     window.location.href = '/'
  //   }
  //   next()
  // }
}
</script>
<style lang="scss" scoped>
a {
  cursor: pointer;
}
</style>
