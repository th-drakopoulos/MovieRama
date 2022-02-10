<template>
  <div>
    <div
      class="card mb-3"
      v-for="(movie, index) in movies"
      :key="'movie-' + index"
    >
      <div class="card-body">
          <h3 class="card-title">
            {{ movie.title }}
          </h3>
          <div class="card-text mb-2">{{ movie.user_name }}</div>
          <div class="card-text mb-2">{{ movie.description }}</div>
          <div class="card-text">{{ movie.likes }} likes | {{ movie.hates }} hates</div>
        </div>
      </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      loading: false,
      movies: null,
    };
  },
  async created() {
    try {
      this.loading = true;
      const response = (await axios.get("/api/movies")).data;
      if (response) {
        this.movies = response.data;
      }
    } catch (error) {
      console.warn(error);
    } finally {
      this.loading = false;
    }
  },
  methods: {
    deleteBook(id) {
      this.$axios.get("/sanctum/csrf-cookie").then((response) => {
        this.$axios
          .delete(`/api/books/delete/${id}`)
          .then((response) => {
            let i = this.books.map((item) => item.id).indexOf(id); // find index of your object
            this.books.splice(i, 1);
          })
          .catch(function (error) {
            console.error(error);
          });
      });
    },
  },
  beforeRouteEnter(to, from, next) {
    if (!window.Laravel.isLoggedin) {
      window.location.href = "/";
    }
    next();
  },
};
</script>
