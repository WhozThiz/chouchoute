<template>
  <div class="app-container">
    <label>{{ todo.title }}</label>
  </div>
</template>

<script>
export default {
  name: 'Todo',
  props: {
  },
  data() {
    return {
      todo: {
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
