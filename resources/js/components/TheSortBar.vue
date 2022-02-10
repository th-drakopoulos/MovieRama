<template>
  <div class="d-flex flex-row">
    <span class="navbar-brand">Sort by: </span>
    <a class="nav-item nav-link" @click="changeSortLikes">Likes</a>
    <a class="nav-item nav-link" @click="changeSortHates">Hates</a>
    <a class="nav-item nav-link" @click="changeSortDates">Dates</a>
  </div>
</template>

<script>
export default {
  methods: {
    changeSortLikes() {
      console.log('Sort likes child')
      this.$emit('change-sort', 'likes')
    },
    changeSortHates() {
      console.log('Sort hates child')
      this.$emit('change-sort', 'hates')
    },
    changeSortDates() {
      console.log('Sort dates child')
      this.$emit('change-sort', 'created_at')
    }
  }
}
</script>

<style lang="scss" scoped>
a {
  cursor: pointer;
}
</style>
