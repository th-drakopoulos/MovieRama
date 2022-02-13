<template>
  <div class="container h-100">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="alert alert-danger" role="alert" v-if="error !== null">
          {{ error }}
        </div>

        <div class="card card-default">
          <div class="card-header">Login</div>
          <div class="card-body">
            <form>
              <div class="form-group row mb-3">
                <label for="email" class="col-sm-4 col-form-label text-md-right"
                  >E-Mail Address</label
                >
                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="email"
                    required
                    autofocus
                    autocomplete="off"
                    @keydown="errors = null"
                    :class="[{ 'is-invalid': errorFor('email') }]"
                  />
                  <div
                    class="text-danger"
                    v-for="(error, index) in errorFor('email')"
                    :key="'email' + index"
                  >
                    {{ error }}
                  </div>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >Password</label
                >
                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="password"
                    required
                    autocomplete="off"
                    @keydown="errors = null"
                    :class="[{ 'is-invalid': errorFor('password') }]"
                  />
                  <div
                    class="text-danger"
                    v-for="(error, index) in errorFor('password')"
                    :key="'password' + index"
                  >
                    {{ error }}
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    @click.prevent="tryToLogin"
                    :disabled="!canLogin || tryingToLogin || hasErrors"
                  >
                    Login
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      email: '',
      password: '',
      error: null,
      errors: null,
      tryingToLogin: false,
      status: ''
    }
  },
  computed: {
    canLogin() {
      return this.email !== '' && this.password !== ''
    },
    hasErrors() {
      return this.status === 422 && this.errors !== null
    }
  },
  methods: {
    async tryToLogin() {
      this.tryingToLogin = true
      this.errors = null
      try {
        const cookie = await axios.get('/sanctum/csrf-cookie')
        if (cookie) {
          const response = await axios.post('api/login', {
            email: this.email,
            password: this.password
          })
          if (response) {
            this.status = response.status
            if (response.data.success) {
              this.$router.go('/')
            } else {
              this.error = response.data.message
            }
          }
        }
      } catch (error) {
        if (error.response.status === 422) {
          this.errors = error.response.data.errors
        }
        this.status = error.response.status
      } finally {
        this.tryingToLogin = false
      }
    },
    errorFor(field) {
      return this.hasErrors && this.errors[field] ? this.errors[field] : null
    }
  },
  beforeRouteEnter(to, from, next) {
    if (window.Laravel.isLoggedin) {
      return next('/')
    }
    next()
  }
}
</script>
