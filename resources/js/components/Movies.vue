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
        <div class="card-body">
          <h3 class="card-title">
            {{ movie.title }}
          </h3>
          <div class="card-text mb-2">
            <div class="d-flex flex-row align-items-center">
              <span>Posted by</span>
              <a
                class="nav-item nav-link"
                @click="movieByUser(movie.user_id)"
                >{{ movie.user_name }}</a
              >
              <span>{{ fromNow(movie.created_at) }}</span>
            </div>
          </div>
          <div class="card-text mb-3">{{ movie.description }}</div>
          <div v-if="user">
            <div class="card-text d-flex align-items-center">
              <a class="nav-item nav-link px-0 py-0">{{ movie.likes }} likes</a>
              <span class="mx-1">|</span>
              <a class="nav-item nav-link px-0 py-0">{{ movie.hates }} hates</a>
            </div>
          </div>
          <div v-else>
            <div
              class="card-text card-text d-flex align-items-center"
              v-if="movie.likes > 0 || movie.hates > 0"
            >
              {{ movie.likes }} likes | {{ movie.hates }} hates
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SortBar from './TheSortBar.vue'
import axios from 'axios'
import moment from 'moment'
export default {
  components: {
    SortBar
  },
  data() {
    return {
      loading: false,
      movies: null,
      sortBy: ''
    }
  },
  computed: {
    user() {
      return window.Laravel.user ? window.Laravel.user : ''
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
    deleteBook(id) {
      this.$axios.get('/sanctum/csrf-cookie').then((response) => {
        this.$axios
          .delete(`/api/books/delete/${id}`)
          .then((response) => {
            let i = this.books.map((item) => item.id).indexOf(id) // find index of your object
            this.books.splice(i, 1)
          })
          .catch(function (error) {
            console.error(error)
          })
      })
    },
    fromNow(value) {
      return moment(value).fromNow()
    },
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
