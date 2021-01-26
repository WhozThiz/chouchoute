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
          <span v-if="pet.gender === 1">{{ $t('pet.male') }}</span>
          <span v-else>{{ $t('pet.female') }}</span>
        </div>
        <div class="text-muted">
          <span>{{ $t('pet.neutered') }}: </span>
          <span v-if="pet.neutered === 1">{{ $t('general.yes') }}</span>
          <span v-else>{{ $t('general.no') }}</span>
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
          {{ pet.lead.name }}
        </div>
        <div v-show="pet.lead.homephone !== ''" class="progress-item">
          <span>Home Phone: </span>
          {{ pet.lead.homephone }}
        </div>
        <div class="progress-item">
          <span>Mobile: </span>
          {{ pet.lead.mobile }}
        </div>
        <div class="progress-item">
          <span>Email:</span>
          {{ pet.lead.email }}
        </div>
        <div v-show="pet.lead.tax_id !== null" class="progress-item">
          <span>Tax Id:</span>
          {{ pet.lead.tax_id }}
        </div>
        <div v-show="pet.lead.registration_id !== null" class="progress-item">
          <span>Registration:</span>
          {{ pet.lead.registration_id }}
        </div>
        <div class="text-muted">
          <span>Address:<br></span>
          <span>{{ pet.lead.address }}<br></span>
          <span>{{ pet.lead.neighborhood }}<br></span>
          <span>{{ pet.lead.zipcode }}, {{ pet.lead.city }} {{ pet.lead.state }}</span>
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
          lead: {
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
          },
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
