<template>
  <li class="task" :class="{ completed: task.completed }">
    <div class="view">
      <input v-model="task.completed" type="checkbox" class="toggle">
      <label>{{ task.title }}</label>
      <button class="destroy" @click="removeTask(task)">&nbsp;</button>
    </div>
  </li>
</template>

<script>
export default {
  name: 'Task',
  props: {
    task: {
      type: Object,
      default: null,
    },
  },
  methods: {
    removeTask(task) {
      this.$store.commit('CACHE_REMOVED', task);
      this.$store.dispatch('DELETE_TASK', task);
    },
  },
};
</script>
