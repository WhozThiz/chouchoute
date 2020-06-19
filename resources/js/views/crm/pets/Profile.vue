<template>
  <div class="app-container">
    <el-form v-if="pet" :model="pet">
      <el-row :gutter="20">
        <el-col :span="6">
          <pet-card :pet="pet" />
          <pet-bio :pet="pet" />
        </el-col>
        <el-col :span="18">
          <pet-activity :pet="pet" />
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import PetBio from './components/PetBio';
import PetCard from './components/PetCard';
import PetActivity from './components/PetActivity';

const petResource = new Resource('pets');

export default {
  name: 'ShowPet',
  components: { PetBio, PetCard, PetActivity },
  data() {
    return {
      pet: {},
    };
  },
  watch: {
    '$route': 'getPet',
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    this.getPet(id);
  },
  methods: {
    async getPet(id) {
      const { data } = await petResource.get(id);
      this.pet = data;
    },
  },
};
</script>
