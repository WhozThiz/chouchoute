<template>
  <div class="app-container">
    <label>{{ calendar.title }}</label>
  </div>
</template>

<script>
export default {
  name: 'Calendar',
  props: {
  },
  data() {
    return {
      calendar: {
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
