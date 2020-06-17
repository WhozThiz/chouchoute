<template>
  <el-card v-if="pet.name" class="box-card user-bio">
    <div slot="header" class="clearfix">
      <span>{{ $t('user.aboutme') }}</span>
    </div>
    <div class="user-education user-bio-section">
      <div class="user-bio-section-header">
        <svg-icon icon-class="education" />
        <span>{{ $t('general.profile') }}</span>
      </div>
      <div class="user-bio-section-body">
        <div class="text-muted">
          <span>{{ $t('pet.coat') }}: </span>
          {{ pet.coat }}
        </div>
        <div class="text-muted">
          <span>{{ $t('pet.color') }}: </span>
          {{ pet.color }}
        </div>
        <div v-show="pet.birthdate !== null" class="text-muted">
          <span>{{ $t('general.birthdate') }}: </span>
          {{ pet.birthdate }}
        </div>
        <div class="text-muted">
          <span>{{ $t('general.gender') }}: </span>
          {{ pet.gender }}
        </div>
        <div class="text-muted">
          <span>{{ $t('pet.neutered') }}: </span>
          {{ pet.neutered }}
        </div>
        <div v-show="pet.registration_id !== null" class="text-muted">
          <span>{{ $t('pet.registration') }}:</span>
          {{ pet.registration_id }}
        </div>
      </div>
    </div>
    <div class="user-skills user-bio-section">
      <div class="user-bio-section-header">
        <svg-icon icon-class="codeowners" />
        <span>{{ $t('pet.owner') }}</span>
      </div>
      <div class="user-bio-section-body">
        <div class="progress-item">
          <span>Name: </span>
          {{ lead.name }}
        </div>
        <div v-show="lead.homephone !== null" class="progress-item">
          <span>Home Phone: </span>
          {{ lead.homephone }}
        </div>
        <div class="progress-item">
          <span>Mobile: </span>
          {{ lead.mobile }}
        </div>
        <div class="progress-item">
          <span>Email:</span>
          {{ lead.email }}
        </div>
        <div v-show="lead.tax_id !== null" class="progress-item">
          <span>Tax Id:</span>
          {{ lead.tax_id }}
        </div>
        <div v-show="lead.registration_id !== null" class="progress-item">
          <span>Registration:</span>
          {{ lead.registration_id }}
        </div>
        <div class="text-muted">
          <span>Address:<br></span>
          <span>{{ lead.address }}<br></span>
          <span>{{ lead.neighborhood }}<br></span>
          <span>{{ lead.zipcode }}, {{ lead.city }} {{ lead.state }}</span>
        </div>
      </div>
    </div>
  </el-card>
</template>

<script>
export default {
  props: {
    pet: {
      type: Object,
      default: () => {
        return {
          name: '',
          breed: '',
          coat: '',
          birthdate: '',
          gender: '',
          neutered: '',
          registration_id: '',
          lead_id: '',
          avatar: '',
        };
      },
    },
    lead: {
      type: Object,
      default: () => {
        return {
          name: '',
          zipcode: '',
          address: '',
          neighborhood: '',
          city: '',
          state: '',
          homephone: '',
          mobile: '',
          email: '',
          registration_id: '',
          tax_id: '',
        };
      },
    },
  },
};
</script>

<style lang="scss" scoped>
.user-bio {
  margin-top: 20px;
  color: #606266;
  span {
    padding-left: 4px;
  }
  .user-bio-section {
    font-size: 14px;
    padding: 15px 0;
    .user-bio-section-header {
      border-bottom: 1px solid #dfe6ec;
      padding-bottom: 10px;
      margin-bottom: 10px;
      font-weight: bold;
    }
  }
}
</style>
