<template>
  <div class="app-container">
    <label>{{ transfer.title }}</label>
  </div>
</template>

<script>
export default {
  name: 'Transfer',
  props: {
  },
  data() {
    return {
      transfer: {
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
