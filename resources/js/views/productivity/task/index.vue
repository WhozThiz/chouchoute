<template>
  <div class="app-container">
    <label>{{ task.title }}</label>
  </div>
</template>

<script>
export default {
  name: 'Task',
  props: {
  },
  data() {
    return {
      task: {
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
