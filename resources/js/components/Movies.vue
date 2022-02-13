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
        <Movie
          :movie="movie"
          @movie-by-user="movieByUser"
          :movie-has-rating="movieHasRatingByUser(movie.id)"
        />
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
      sortBy: '',
      ratings: null
    }
  },
  async created() {
    try {
      this.loading = true
      const response = (await axios.get(`/api/movies`)).data
      if (response) {
        this.movies = response.data
      }
      const ratingsResponse = (await axios.get(`/api/ratings-by-user`)).data
      if (ratingsResponse) {
        this.ratings = ratingsResponse.data
      }
    } catch (error) {
      console.warn(error)
    } finally {
      this.loading = false
    }
  },
  methods: {
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
    },
    movieHasRatingByUser(id) {
      let found = null
      if (this.ratings) {
        this.ratings.forEach((element) => {
          if (element.movie_id === id) {
            found = element
            return true
          }
        })
      }

      return found
    }
  }
}
</script>
<style lang="scss" scoped>
a {
  cursor: pointer;
}
</style>
