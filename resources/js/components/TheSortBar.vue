<template>
  <div class="d-flex flex-row">
    <span class="navbar-brand">Sort by: </span>
    <a class="nav-item nav-link" @click="testFunction">Likes</a>
    <a class="nav-item nav-link" @click="testFunction">Hates</a>
    <a class="nav-item nav-link" @click="testFunction">Dates</a>
    <!-- <router-link to="/login" class="nav-item nav-link"
                >Likes</router-link
            > -->
    <router-link to="/register" class="nav-item nav-link">Hates </router-link>
    <router-link to="/register" class="nav-item nav-link">Dates </router-link>
  </div>
</template>

<script>
export default {
  methods: {
    testFunction() {
      console.log('I was clicked!')
    }
  }
}
</script>

<style lang="scss" scoped>
a {
  cursor: pointer;
}
</style>
