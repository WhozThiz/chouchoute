<template>
  <div class="app-container">
    <form-wizard shape="square" color="#20a0ff" error-color="#ff4949" @on-complete="onComplete">
      <h2 slot="title">{{ $t('pet.petwizardform') }}</h2>
      <tab-content title="Lead Details" icon="el-icon-s-custom" :before-change="validateFirstStep">
        {{ newLead }}
        <el-form ref="ruleForm" :model="newLead" class="demo-form-inline" :rules="rules">
          <el-form-item :label="$t('general.name')" prop="name">
            <el-input v-model="newLead.name" placeholder="Full Name" />
          </el-form-item>
          <el-form-item :label="$t('general.zipcode')" prop="zipcode">
            <el-input v-model="newLead.zipcode" v-mask="'#####-###'" placeholder="00000-000" @keyup.enter.native="searchZipcode()" />
          </el-form-item>
          <el-form-item :label="$t('general.address')" prop="address">
            <el-input ref="address" v-model="newLead.address" />
          </el-form-item>
          <el-form-item :label="$t('general.neighborhood')" prop="neighborhood">
            <el-input v-model="newLead.neighborhood" />
          </el-form-item>
          <el-form-item :label="$t('general.city')" prop="city">
            <el-input v-model="newLead.city" />
          </el-form-item>
          <el-form-item :label="$t('general.state')" prop="state">
            <el-input v-model="newLead.state" />
          </el-form-item>
          <el-form-item :label="$t('general.homephone')" prop="homephone">
            <el-input v-model="newLead.homephone" v-mask="['+## (##) #####.####', '+## (##) ####.####', '+# (###) ###.####']" masked="true" placeholder="+55 (11) 8888.8888" />
          </el-form-item>
          <el-form-item :label="$t('general.mobile')" prop="mobile">
            <el-input v-model="newLead.mobile" v-mask="['+## (##) #####.####', '+# (###) ###.####']" masked="true" placeholder="+55 (11) 9.9999.9999" />
          </el-form-item>
          <el-form-item :label="$t('general.email')" prop="email">
            <el-input v-model="newLead.email" placeholder="email@email.com.br" />
          </el-form-item>
          <el-form-item :label="$t('lead.registration_id')" prop="registration_id">
            <el-input v-model="newLead.registration_id" />
          </el-form-item>
          <el-form-item :label="$t('lead.tax_id')" prop="tax_id">
            <el-input v-model="newLead.tax_id" v-mask="['###.###.###-##', '##.###.###/####-##']" placeholder="123.123.123-12" />
          </el-form-item>
        </el-form>
      </tab-content>
      <tab-content title="Pet Details" icon="el-icon-document">
        <el-form ref="petForm" :model="newPet">
          <el-form-item :label="$t('general.name')" prop="name">
            <el-input v-model="newPet.name" />
          </el-form-item>
          <el-form-item :label="$t('pet.breed')" prop="breed">
            <el-input v-model="newPet.breed" />
          </el-form-item>
          <el-form-item :label="$t('pet.coat')" prop="coat">
            <el-input v-model="newPet.coat" />
          </el-form-item>
          <el-form-item :label="$t('general.gender')" prop="gender">
            <el-switch v-model="newPet.gender" active-color="#409EFF" inactive-color="#F56C6C" active-text="Male" inactive-text="Female" />
          </el-form-item>
          <el-form-item :label="$t('general.birthday')" prop="birthday">
            <el-date-picker v-model="newPet.birthday" type="date" placeholder="Pick a day" />
          </el-form-item>
          <el-form-item :label="$t('pet.neutered')" prop="neutered">
            <el-tooltip :content="'Switch value: ' + value" placement="top" />
            <el-switch v-model="newPet.neutered" active-color="#13ce66" inactive-color="#ff4949" active-value="100" inactive-value="0" />
          </el-form-item>
          <el-form-item :label="$t('pet.registration')" prop="registration">
            <el-input v-model="newPet.registration" />
          </el-form-item>
        </el-form>
      </tab-content>
      <tab-content title="Vaccination Infos" icon="el-icon-more-outline">
        {{ dynamicVaccineForm }}
        <el-form v-for="(vaccine, index) in dynamicVaccineForm.vaccines" :key="vaccine.key" ref="dynamicVaccineForm" :model="dynamicVaccineForm" :inline="true">
          <el-form-item :label="index+1" />
          <el-form-item :label="$t('general.date')" prop="'vaccines.' + index + '.date'">
            <el-date-picker v-model="vaccine.date" type="date" placeholder="Pick a day" :picker-options="pickerOptions" />
          </el-form-item>
          <el-form-item
            :label="$t('pet.vaccine')"
            :prop="'vaccines.' + index + '.vaccine'"
            :rules="{
              required: true, message: 'vaccine can not be null', trigger: 'blur'
            }"
          >
            <el-input v-model="vaccine.vaccine" />
          </el-form-item>
          <el-form-item :label="$t('pet.validation')" prop="'vaccines.' + index + '.validation'">
            <el-date-picker v-model="vaccine.validation" type="date" placeholder="Pick a day" />
          </el-form-item>
          <el-form-item>
            <el-button type="danger" icon="el-icon-delete" @click.prevent="removeVaccine(vaccine)" />
          </el-form-item>
        </el-form>
        <el-button type="primary" @click="addVaccine">Add Vaccine</el-button>
        <el-button type="primary" @click="resetForm('dynamicVaccineForm')">Reset</el-button>
      </tab-content>
      <el-button slot="prev" type="primary" icon="el-icon-arrow-left">{{ $t('general.back') }}</el-button>
      <el-button slot="next" type="primary">{{ $t('general.next') }} <i class="el-icon-arrow-right" /></el-button>
      <el-button slot="finish" type="primary">{{ $t('general.finish') }}</el-button>
    </form-wizard>
  </div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard';
import axios from 'axios';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';
import { mask } from 'vue-the-mask';

export default {
  components: {
    FormWizard,
    TabContent,
  },
  directives: {
    mask,
  },
  data() {
    return {
      newLead: {
        name: '',
        zipcode: '',
        address: '',
        neighborhood: '',
        city: '',
        state: '',
        homephone: '',
        mobile: '',
        email: '',
        registratio_id: '',
        tax_id: '',
      },
      rules: {
        name: [{
          required: true,
          min: 10,
          max: 254,
          message: 'Length should be 10 to 254',
          trigger: 'blur',
        }],
        zipcode: [{
          required: true,
          min: 9,
          max: 9,
          message: 'Length should be 00000-000',
          trigger: 'blur',
        }],
        mobile: [{
          required: true,
          min: 17,
          max: 19,
          message: 'Length should be +55 (11) 9.9999.9999',
          trigger: 'blur',
        }],
      },
      newPet: {},
      dynamicVaccineForm: {
        vaccines: [{
          key: 1,
          date: '',
          vaccine: '',
          validation: '',
        }],
      },
      pickerOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
        shortcuts: [{
          text: 'Today',
          onClick(picker) {
            picker.$emit('pick', new Date());
          },
        }, {
          text: 'Yesterday',
          onClick(picker) {
            const date = new Date();
            date.setTime(date.getTime() - 3600 * 1000 * 24);
            picker.$emit('pick', date);
          },
        }, {
          text: 'A week ago',
          onClick(picker) {
            const date = new Date();
            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
            picker.$emit('pick', date);
          },
        }],
      },
    };
  },
  methods: {
    onComplete: function() {
      alert('Yay. Done!');
    },
    validateFirstStep() {
      return new Promise((resolve, reject) => {
        this.$refs.ruleForm.validate((valid) => {
          resolve(valid);
        });
      });
    },
    searchZipcode() {
      if (/^[0-9]{5}-[0-9]{3}$/.test(this.newLead.zipcode)) {
        // axios.get(url_cep).then(function (response) {
        axios.get(`https://viacep.com.br/ws/${this.newLead.zipcode}/json/`)
          // .then(function (response) {
          .then(response => {
            // this.currentLead = response.data
            this.newLead.address = response.data.logradouro;
            this.newLead.neighborhood = response.data.bairro;
            this.newLead.city = response.data.localidade;
            this.newLead.state = response.data.uf;
          })
          .catch(error => console.log(error));
        this.$refs.address.focus();
      }
    },
    resetForm(dynamicVaccineForm) {
      this.$refs[dynamicVaccineForm].resetFields();
    },
    removeVaccine(item) {
      var index = this.dynamicVaccineForm.vaccines.indexOf(item);
      if (index !== -1) {
        this.dynamicVaccineForm.vaccines.splice(index, 1);
      }
    },
    addVaccine() {
      this.dynamicVaccineForm.vaccines.push({
        key: Date.now(),
        date: '',
        vaccine: '',
        validation: '',
      });
    },
  },
};

</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>
