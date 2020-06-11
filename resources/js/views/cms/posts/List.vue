<template>
  <div class="app-container">
    <el-steps :active="active" align-cente finish-status="success" simple>
      <el-step :title="$t('lead.newlead')" icon="el-icon-s-custom" />
      <el-step :title="$t('pet.petdetails')" icon-class="el-icon-s-custom" />
      <el-step :title="$t('pet.vaccinationinfo')" icon="el-icon-upload" />
    </el-steps>

    <h2 slot="title">{{ $t('pet.petwizardform') }}</h2>

    <el-form v-if="active===1">
      <el-form ref="leadForm" :model="newLead" class="demo-form-inline" :rules="rules">
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
    </el-form>

    <el-form v-if="active===2">
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
          <el-button v-model="newPet.neutered" @click="disabled = !disabled">{{ disabled ? 'YES' : 'NO' }}</el-button>
        </el-form-item>
        <el-form-item :label="$t('pet.registration')" prop="registration">
          <el-input v-model="newPet.registration" />
        </el-form-item>
      </el-form>
    </el-form>

    <el-form v-if="active===3">
      <el-form v-for="(vaccine, index) in dynamicVaccineForm.vaccines" :key="index" ref="dynamicVaccineForm" :model="dynamicVaccineForm" :inline="true">
        <el-form-item label="temp"><span slot="label">{{ index + 1 }}</span></el-form-item>
        <el-form-item :label="$t('general.date')" :prop="'vaccines.' + index + '.date'">
          <el-date-picker v-model="vaccine.date" type="date" placeholder="Pick a day" :picker-options="pickerOptions" />
        </el-form-item>
        <el-form-item :label="$t('pet.vaccine')" :prop="'vaccines.' + index + '.vaccine'" :rules="{required: true, message: 'vaccine can not be null', trigger: 'blur'}">
          <el-input v-model="vaccine.vaccine" />
        </el-form-item>
        <el-form-item :label="$t('pet.validation')" :prop="'vaccines.' + index + '.validation'">
          <el-date-picker v-model="vaccine.validation" type="date" placeholder="Pick a day" />
        </el-form-item>
        <el-form-item>
          <el-button type="danger" icon="el-icon-delete" @click.prevent="removeVaccine(vaccine)" />
        </el-form-item>
      </el-form>
      <el-button type="primary" @click="addVaccine">Add Vaccine</el-button>
      <el-button type="primary" @click="resetForm('dynamicVaccineForm')">Reset</el-button>
    </el-form>

    <br>
    <el-button :disabled="active === 1" @click="navigatePrev">{{ prevBtnTxt() }}</el-button>
    <el-button @click="navigateNext(formName)">{{ nextBtnTxt() }}</el-button>
    <br>
    {{ formName }}
    <br>
    {{ newLead }}
    <br>
    {{ newPet }}
    <br>
    {{ dynamicVaccineForm }}
  </div>
</template>

<script>
import axios from 'axios';
import { mask } from 'vue-the-mask';

export default {
  directives: {
    mask,
  },
  data() {
    return {
      active: 1,
      formName: 'leadForm',
      disabled: false,
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
        email: [{
          required: false,
          pattern: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
          message: 'Email should be something like email@email.com.br',
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
      newPet: {
        pet: '',
        breed: '',
        coat: '',
        gender: '',
        birthday: '',
        neutered: '',
        registration: '',
      },
      dynamicVaccineForm: {
        vaccines: [{
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
    prevBtnTxt() {
      if (this.active === 1) {
        return 'Beginning';
      }
      return 'Previous';
    },
    nextBtnTxt() {
      if (this.active === 3) {
        return 'Finish';
      }
      return 'Next';
    },
    togglePrevious() {
      if (this.active === 1) {
        return true;
      }
      return false;
    },
    navigateNext(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          if (this.active === 1) {
            this.active = 2;
            this.formName = 'petForm';
          } else if (this.active === 2) {
            this.active = 3;
            this.formName = 'dynamicVaccineForm';
          } else {
            this.nextBtnTxt = 'Finish';
            // handle saving of the form
          }
        }
      });
    },
    navigatePrev() {
      if (this.active === 2) {
        this.active = 1;
        this.formName = 'leadForm';
      } else if (this.active === 3) {
        this.active = 2;
        this.formName = 'petForm';
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
        date: '',
        vaccine: '',
        validation: '',
      });
    },
  },
};
</script>

<style scoped>
</style>
