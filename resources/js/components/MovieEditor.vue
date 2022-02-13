<template>
  <div class="px-4">
    <div class="row">
      <h3 class="text-primary">Add new movie</h3>
    </div>
    <form>
      <div class="row mb-3">
        <input
          id="title"
          type="text"
          class="form-control"
          v-model="title"
          required
          autofocus
          placeholder="Add movie title"
          autocomplete="off"
          @keydown="errors = null"
          :class="[{ 'is-invalid': errorFor('title') }]"
        />
        <div
          class="text-danger"
          v-for="(error, index) in errorFor('title')"
          :key="'email' + index"
        >
          {{ error }}
        </div>
      </div>
      <div class="row mb-3">
        <textarea
          name="description"
          id="description"
          cols="30"
          rows="10"
          class="form-control"
          v-model="description"
          required
          autofocus
          autocomplete="off"
          placeholder="Add movie description"
          @keydown="errors = null"
          :class="[{ 'is-invalid': errorFor('description') }]"
        ></textarea>
        <div
          class="text-danger"
          v-for="(error, index) in errorFor('description')"
          :key="'email' + index"
        >
          {{ error }}
        </div>
      </div>
      <div class="row">
        <button
          type="submit"
          class="btn btn-primary"
          @click.prevent="tryToAddMovie"
          :disabled="!canAddMovie || tryingToAddMovie || errors !== null"
        >
          Save Movie
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  props: {
    showEditor: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      title: '',
      description: '',
      tryingToAddMovie: false,
      errors: null
    }
  },
  computed: {
    canAddMovie() {
      return this.title !== '' && this.description !== ''
    }
  },
  methods: {
    closeEditor() {
      this.$emit('close-editor', false)
    },
    async tryToAddMovie() {
      try {
        this.tryingToAddMovie = true
        this.errors = null
        const response = await axios.post('/api/movies', {
          title: this.title,
          description: this.description
        })
        if (response) {
          this.closeEditor()
        }
      } catch (error) {
        this.errors = error.response.data.errors
      } finally {
        this.tryingToAddMovie = false
      }
    },
    errorFor(field) {
      return this.errors !== null && this.errors[field]
        ? this.errors[field]
        : null
    }
  }
}
</script>

<style lang="scss" module></style>
