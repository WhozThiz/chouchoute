<template>
  <div class="app-container">
    <label>{{ contract.title }}</label>
  </div>
</template>

<script>
export default {
  name: 'Contract',
  props: {
  },
  data() {
    return {
      contract: {
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
