<template>
  <div class="app-container">
    <el-steps :active="active" align-cente finish-status="success" simple>
      <el-step :title="$t('lead.newlead')" icon="el-icon-s-custom" />
      <el-step :title="$t('pet.petdetails')" icon-class="el-icon-s-custom" />
      <el-step :title="$t('pet.vaccinationinfo')" icon="el-icon-upload" />
    </el-steps>

    <h2 slot="title">{{ $t('pet.petwizardform') }}</h2>

    <el-form v-if="active===1">
      <el-form ref="dynamicLeadForm" :model="newLead" :rules="rules" label-width="150px">
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
        <el-button type="primary" @click="resetForm('dynamicLeadForm')">Reset</el-button>
      </el-form>
    </el-form>

    <el-form v-if="active===2" ref="dynamicPetForm" :model="newPet" style="max-width: 100%" label-width="150px">
      <el-form-item :label="$t('general.name')" prop="name">
        <el-input v-model="newPet.name" type="text" />
      </el-form-item>
      <el-form-item :label="$t('pet.breed')" prop="breed">
        <el-select v-model="newPet.breed" placeholder="Select Breed">
          <el-option v-for="item in breeds" :key="item.id" :label="item.name" :value="item.name">
            <span style="float: left">{{ item.name }}</span>
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item :label="$t('pet.coat')" prop="coat">
        <el-select v-model="newPet.coat" placeholder="Select Coat">
          <el-option v-for="item in coats" :key="item.id" :label="item.name" :value="item.name">
            <span style="float: left">{{ item.name }}</span>
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item :label="$t('pet.color')" prop="color">
        <el-input v-model="newPet.color" type="text" />
      </el-form-item>
      <el-form-item :label="$t('general.gender')" prop="gender">
        <el-switch v-model="newPet.gender" active-color="#409EFF" inactive-color="#F56C6C" active-icon-class="el-icon-male" inactive-icon-class="el-icon-female" :active-value="1" :inactive-value="0" />
      </el-form-item>
      <el-form-item :label="$t('general.birthdate')" prop="birthdate">
        <el-date-picker v-model="newPet.birthdate" type="date" value-format="yyyy-MM-dd" placeholder="Pick a day" />
      </el-form-item>
      <el-form-item :label="$t('pet.neutered')" prop="neutered">
        <el-switch v-model="newPet.neutered" active-color="#13ce66" inactive-color="#ff4949" active-icon-class="el-icon-circle-check" inactive-icon-class="el-icon-circle-close" :active-value="1" :inactive-value="0" />
      </el-form-item>
      <el-form-item :label="$t('pet.registration')" prop="registration">
        <el-input v-model="newPet.registration" type="text" />
      </el-form-item>
      <el-button type="primary" @click="resetForm('dynamicPetForm')">Reset</el-button>
    </el-form>

    <el-form v-if="active===3">
      <div>
        <el-button type="primary" @click="addVaccine">Add Vaccine</el-button>
        <el-button type="primary" @click="resetForm('dynamicVaccineForm')">Reset</el-button>
      </div>
      <br>
      <el-form v-for="(vaccine, index) in dynamicVaccineForm.vaccines" :key="index" ref="dynamicVaccineForm" :model="dynamicVaccineForm" :inline="true" style="max-width: 100%">
        <el-form-item label="temp"><span slot="label">{{ index + 1 }}</span></el-form-item>
        <el-form-item :label="$t('general.date')" :prop="'vaccines.' + index + '.vaccinedate'">
          <el-date-picker v-model="vaccine.vaccinedate" type="date" value-format="yyyy-MM-dd" placeholder="Pick a day" :picker-options="pickerOptions" />
        </el-form-item>
        <el-form-item :label="$t('pet.vaccine')" :prop="'vaccines.' + index + '.vaccine'">
          <el-select v-model="vaccine.vaccine" placeholder="Select Vaccine">
            <el-option v-for="item in vaccinecategories" :key="item.id" :label="item.name" :value="item.id">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('pet.batch')" :prop="'vaccines.' + index + '.vaccinebatch'">
          <el-input v-model="vaccine.vaccinebatch" />
        </el-form-item>
        <el-form-item>
          <el-button type="danger" icon="el-icon-delete" @click.prevent="removeVaccine(vaccine)" />
        </el-form-item>
      </el-form>
    </el-form>

    <br>
    <el-button :disabled="active === 1" @click="navigatePrev">{{ prevBtnTxt() }}</el-button>
    <el-button @click="navigateNext(dynamicForm)">{{ nextBtnTxt() }}</el-button>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import axios from 'axios';
import { mask } from 'vue-the-mask';
import CategoryResource from '@/api/category';

const categoryResource = new CategoryResource();
const leadResource = new Resource('leads');
const petResource = new Resource('pets');
const vaccineResource = new Resource('vaccines');

export default {
  directives: {
    mask,
  },
  data() {
    return {
      active: 1,
      dynamicForm: 'dynamicLeadForm',
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
        registration_id: '',
        tax_id: '',
      },
      newPet: {
        lead_id: '',
        pet: '',
        breed: '',
        coat: '',
        color: '',
        gender: '',
        birthdate: '',
        neutered: '',
        registration: '',
      },
      dynamicVaccineForm: {
        pet_id: '',
        vaccines: [{
          vaccinedate: '',
          vaccine: '',
          vaccinebatch: '',
        }],
      },
      breeds: [],
      coats: [],
      vaccinecategories: [],
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

  created() {
    this.getPetCategories();
    this.getVaccineCategories();
  },

  methods: {

    async getVaccineCategories() {
      const { data } = await categoryResource.getVaccineCategories({});
      this.vaccinecategories = data;
    },

    async getPetCategories() {
      const { data } = await categoryResource.getPetCategories({});
      this.coats = data.coats;
      this.breeds = data.breeds;
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

    navigateNext(dynamicForm) {
      this.$refs[dynamicForm].validate((valid) => {
        if (valid) {
          if (this.active === 1) {
            this.active = 2;
            this.dynamicForm = 'dynamicPetForm';
          } else if (this.active === 2) {
            this.active = 3;
            this.dynamicForm = 'dynamicVaccineForm';
          } else {
            this.nextBtnTxt = 'Finish';
            this.handleSubmit();
          }
        }
      });
    },

    navigatePrev() {
      if (this.active === 2) {
        this.active = 1;
        this.dynamicForm = 'dynamicLeadForm';
      } else if (this.active === 3) {
        this.active = 2;
        this.dynamicForm = 'dynamicPetForm';
      }
    },

    resetForm(dynamicForm) {
      this.$refs[dynamicForm].resetFields();
    },

    removeVaccine(item) {
      var index = this.dynamicVaccineForm.vaccines.indexOf(item);
      if (index !== -1) {
        this.dynamicVaccineForm.vaccines.splice(index, 1);
      }
    },

    addVaccine() {
      this.dynamicVaccineForm.vaccines.push({
        vaccinedate: '',
        vaccine: '',
        vaccinebatch: '',
      });
    },

    handleSubmit() {
      leadResource
        .store(this.newLead)
        .then(response => {
          this.newPet.lead_id = response.data.id;
          petResource
            .store(this.newPet)
            .then(response => {
              this.dynamicVaccineForm.pet_id = response.data.id;
              vaccineResource
                .store(this.dynamicVaccineForm)
                .then(response => {
                  this.$message({
                    message: 'New Lead ' + this.newLead.name + 'and New Pet' + this.newPet.name + ' have been Created Successfully.',
                    type: 'success',
                    duration: 5 * 1000,
                  });
                  this.dynamicVaccineForm = {
                    pet_id: '',
                    vaccines: [{
                      vaccinedate: '',
                      vaccine: '',
                      vaccinebatch: '',
                    }],
                  };
                })
                .catch(error => {
                  console.log(error);
                });
              this.newPet = {
                lead_id: '',
                pet: '',
                breed: '',
                coat: '',
                color: '',
                gender: '',
                birthdate: '',
                neutered: '',
                registration: '',
              };
            })
            .catch(error => {
              console.log(error);
            });
          this.cep = null;
          this.newLead = {
            id: '',
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
          };
        })
        .catch(error => {
          console.log(error);
        });
    },

  },
};
</script>

<style scoped>
h2 {
  text-align: center;
}
</style>
