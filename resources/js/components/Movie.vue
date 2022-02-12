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
        <div class="d-inline-flex flex-grow-1">
          <span v-if="like">{{ totalLikes }} likes</span>
          <a
            v-else
            class="nav-item nav-link px-0 py-0"
            @click="likeMovie(movie.id)"
            >{{ totalLikes }} likes</a
          >
          <span class="mx-1">|</span>
          <span v-if="hate">{{ totalHates }} hates</span>
          <a
            v-else
            class="nav-item nav-link px-0 py-0"
            @click="hateMovie(movie.id)"
            >{{ totalHates }} hates</a
          >
        </div>
        <div v-if="hasRating" class="d-flex align-items-center">
          <span>You {{ like ? 'like' : 'hate' }} this movie</span>
          <a
            v-if="like"
            class="nav-item nav-link"
            @click="unlikeMovie(movie.id)"
            >Unlike</a
          >
          <a v-else class="nav-item nav-link" @click="unhateMovie">Unhate</a>
        </div>
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
    },
    movieHasRating: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      hasRating: this.movieHasRating ? true : false,
      rating: this.movieHasRating ? this.movieHasRating.rating : 0,
      like:
        this.movieHasRating && this.movieHasRating.rating === 1 ? true : false,
      hate:
        this.movieHasRating && this.movieHasRating.rating === -1 ? true : false,
      totalLikes: this.movie?.likes,
      totalHates: this.movie?.hates
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
          // check if already has rating
          const hasRatingResponse = await axios.get(`/api/ratings/${id}`)
          if (hasRatingResponse && !hasRatingResponse.data.success) {
            const rating = await axios.post(`/api/ratings/${id}`, {
              rating: 1
            })
            if (rating) {
              this.totalLikes++
              this.like = true
              this.hasRating = true
            }
          }
        }
      } catch (error) {
        console.warn(error)
      }
    },
    async hateMovie(id) {
      try {
        const response = await axios.post(`/api/movies/${id}/hates`)
        if (response) {
          // check if already has rating
          const hasRatingResponse = await axios.get(`/api/ratings/${id}`)
          if (hasRatingResponse && !hasRatingResponse.data.success) {
            const rating = await axios.post(`/api/ratings/${id}`, {
              rating: -1
            })
            if (rating) {
              this.totalHates++
              this.hate = true
              this.hasRating = true
            }
          }
        }
      } catch (error) {
        console.warn(error)
      }
    },
    async unlikeMovie() {},
    async unhateMovie() {},
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
