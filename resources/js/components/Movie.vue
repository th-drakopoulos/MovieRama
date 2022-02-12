<template>
  <div class="card-body">
    <h3 class="card-title">
      {{ movie.title }}
    </h3>
    <div class="card-text mb-2">
      <div class="d-flex flex-row align-items-center">
        <span>Posted by</span>
        <a class="nav-item nav-link" @click="movieByUser(movie.user_id)">{{
          showMovieAuthorName(movie.user_id) ? movie.user_name : 'You'
        }}</a>
        <span>{{ fromNow(movie.created_at) }}</span>
      </div>
    </div>
    <div class="card-text mb-3">{{ movie.description }}</div>
    <div v-if="user && canVoteForMovie(movie.user_id)">
      <div class="card-text d-flex align-items-center">
        <a class="nav-item nav-link px-0 py-0" @click="likeMovie(movie.id)"
          >{{ movie.likes }} likes</a
        >
        <span class="mx-1">|</span>
        <a class="nav-item nav-link px-0 py-0" @click="hateMovie(movie.id)"
          >{{ movie.hates }} hates</a
        >
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
</template>

<script>
import moment from 'moment'
export default {
  props: {
    movie: {
      type: Object,
      default: null
    }
  },
  computed: {
    user() {
      return window.Laravel.user ? window.Laravel.user : ''
    }
  },
  methods: {
    async likeMovie(id) {
      try {
        const response = await axios.post(`/api/movies/${id}/likes`)
        if (response) {
          // TODO: update the ratings table
          return
        }
      } catch (error) {
        console.warn(error)
      }
    },
    async hateMovie(id) {
      try {
        const response = await axios.post(`/api/movies/${id}/hates`)
        if (response) {
          // TODO: update the ratings table
          return
        }
      } catch (error) {
        console.warn(error)
      }
    },
    fromNow(value) {
      return moment(value).fromNow()
    },
    movieByUser(id) {
      this.$emit('movie-by-user', id)
    },
    canVoteForMovie(authorId) {
      return authorId !== this.user.id
    },
    showMovieAuthorName(authorId) {
      if (!this.user) {
        return true
      }

      return authorId !== this.user.id
    }
  }
}
</script>

<style lang="scss" scoped>
a {
  cursor: pointer;
}
</style>
