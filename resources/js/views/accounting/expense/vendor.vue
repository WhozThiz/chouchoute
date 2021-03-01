<template>
  <div class="app-container">
    <label>{{ vendor.title }}</label>
  </div>
</template>

<script>
export default {
  name: 'Vendor',
  props: {
  },
  data() {
    return {
      vendor: {
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
