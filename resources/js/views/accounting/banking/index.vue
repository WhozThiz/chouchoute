<template>
  <div class="app-container">
    <label>{{ account.title }}</label>
  </div>
</template>

<script>
export default {
  name: 'Account',
  props: {
  },
  data() {
    return {
      account: {
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
