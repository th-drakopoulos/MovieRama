<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Register</div>
          <div class="card-body">
            <form>
              <div class="form-group row mb-3">
                <label for="name" class="col-sm-4 col-form-label text-md-right"
                  >Name</label
                >
                <div class="col-md-6">
                  <input
                    id="name"
                    type="text"
                    class="form-control"
                    v-model="name"
                    required
                    autofocus
                    autocomplete="off"
                    @keydown="errors = null"
                    :class="[{ 'is-invalid': errorFor('name') }]"
                  />
                  <div
                    class="text-danger"
                    v-for="(error, index) in errorFor('name')"
                    :key="'name' + index"
                  >
                    {{ error }}
                  </div>
                </div>
              </div>

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

              <div class="form-group row mb-3">
                <label
                  for="password_confirm"
                  class="col-md-4 col-form-label text-md-right"
                  >Confirm</label
                >
                <div class="col-md-6">
                  <input
                    id="password_confirm"
                    type="password"
                    class="form-control"
                    v-model="password_confirm"
                    required
                    autocomplete="off"
                  />
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    @click.prevent="tryToRegister"
                    :disabled="!canRegister || tryingToRegister || hasErrors"
                  >
                    Register
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
      name: '',
      email: '',
      password: '',
      password_confirm: '',
      errors: null,
      tryingToRegister: false,
      status: ''
    }
  },
  computed: {
    canRegister() {
      return this.name !== '' && this.email !== '' && this.password !== ''
    },
    hasErrors() {
      return this.status === 422 && this.errors !== null
    }
  },
  methods: {
    async tryToRegister() {
      this.tryingToRegister = true
      this.errors = null
      if (this.password.length > 0) {
        const cookie = await axios.get('/sanctum/csrf-cookie')
        if (cookie) {
          try {
            const response = await axios.post('api/register', {
              name: this.name,
              email: this.email,
              password: this.password,
              password_confirmation: this.password_confirm
            })

            if (response) {
              this.status = response.status
              if (response.data.success) {
                window.location.href = '/login'
              }
            } else {
              this.errors = response.data.message
            }
          } catch (error) {
            if (error.response.status === 422) {
              this.errors = error.response.data.errors
            }
            this.status = error.response.status
          } finally {
            this.tryingToRegister = false
          }
        }
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
