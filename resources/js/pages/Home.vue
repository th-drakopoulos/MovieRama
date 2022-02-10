<template>
  <div class="row">
    <div class="col-md-8">
      <Movies />
    </div>
    <div class="col-md-4">Some other things</div>
  </div>
</template>

<script>
import Movies from '../components/Movies.vue'
export default {
  name: 'Home',
  components: {
    Movies
  },
  data() {
    return {
      //
    }
  },
  created() {},
  methods: {}
}
</script>
