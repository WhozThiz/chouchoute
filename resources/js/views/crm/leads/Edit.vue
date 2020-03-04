<template>
  <lead-detail :is-edit="true" />
</template>

<script>
import LeadDetail from './components/LeadDetail';

export default {
  name: 'EditForm',
  components: { LeadDetail },
};
</script>

