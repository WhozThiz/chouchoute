<template>
  <div class="app-container">
    <label>{{ bill.title }}</label>
  </div>
</template>

<script>
export default {
  name: 'Bill',
  props: {
  },
  data() {
    return {
      bill: {
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
