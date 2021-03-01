<template>
  <div class="app-container">
    <el-calendar v-model="calendar.value" />
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
        value: new Date(),
      },
    };
  },
  methods: {
  },
};
</script>

<style scoped>
</style>
