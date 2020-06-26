<template>
  <div class="app-container">
    <label>{{ post.title }}</label>
  </div>
</template>

<script>
export default {
  name: 'Posts',
  props: {
  },
  data() {
    return {
      post: {
        title: 'Hello World',
      },
    };
  },
  methods: {
  },
};
</script>

<style scoped>
</style>
