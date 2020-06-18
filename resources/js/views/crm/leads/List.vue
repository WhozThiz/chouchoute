<template>
  <div class="app-container">

    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('general.add') }}
      </el-button>
    </div>
    <el-table v-loading="loading" :data="list.filter(data => !filter|| data.name.toLowerCase().includes(filter.toLowerCase()))" stripe fit highlight-current-row max-height="600" style="width: 100%">
      <el-table-column align="center" type="expand" width="60">
        <template slot-scope="scope">
          <p>Address: <span>{{ scope.row.address }} - {{ scope.row.neighborhood }}</span><br><span style="margin-left: 60px;">{{ scope.row.zipcode }}, {{ scope.row.city }} -  {{ scope.row.state }}</span></p>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('general.name')" width="300">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('general.homephone')" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.homephone }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('general.mobile')" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.mobile }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('general.email')">
        <template slot-scope="scope">
          <span>{{ scope.row.email }}</span>
        </template>
      </el-table-column>

      <el-table-column fixed="right" align="center" width="250">
        <template #header><el-input v-model="filter" :placeholder="$t('general.name')" style="width: 200px;" class="filter-item" prefix-icon="el-icon-search" /></template>
        <template slot-scope="scope">
          <el-button v-permission="['manage lead']" type="primary" size="small" icon="el-icon-edit" @click="handleEditForm(scope.row.id);">
            {{ $t('general.edit') }}
          </el-button>
          <el-button v-permission="['manage lead']" type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
            {{ $t('general.delete') }}
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog :title="formTitle" :visible.sync="leadFormVisible">
      <el-form ref="leadForm" :model="currentLead" label-position="left" label-width="150px" style="max-width: 100%;">
        <el-form-item :label="$t('general.name')" prop="name">
          <el-input v-model="currentLead.name" placeholder="John Snow" />
        </el-form-item>
        <el-form-item :label="$t('general.zipcode')" prop="zipcode">
          <el-input v-model="currentLead.zipcode" v-mask="'#####-###'" placeholder="00000-000" @keyup.enter.native="searchZipcode()" />
        </el-form-item>
        <el-form-item :label="$t('general.address')" prop="address">
          <el-input ref="address" v-model="currentLead.address" />
        </el-form-item>
        <el-form-item :label="$t('general.neighborhood')" prop="neighborhood">
          <el-input v-model="currentLead.neighborhood" />
        </el-form-item>
        <el-form-item :label="$t('general.city')" prop="city">
          <el-input v-model="currentLead.city" />
        </el-form-item>
        <el-form-item :label="$t('general.state')" prop="state">
          <el-input v-model="currentLead.state" />
        </el-form-item>
        <el-form-item :label="$t('general.homephone')" prop="homephone">
          <el-input v-model="currentLead.homephone" v-mask="['+## (##) #####.####', '+## (##) ####.####', '+# (###) ###.####']" masked="true" placeholder="+55 (11) 8888.8888" />
        </el-form-item>
        <el-form-item :label="$t('general.mobile')" prop="mobile">
          <el-input v-model="currentLead.mobile" v-mask="['+## (##) #####.####', '+# (###) ###.####']" masked="true" placeholder="+55 (11) 9.9999.9999" />
        </el-form-item>
        <el-form-item :label="$t('general.email')" prop="email">
          <el-input v-model="currentLead.email" type="email" placeholder="email@email.com.br" />
        </el-form-item>
        <el-form-item :label="$t('lead.registration_id')" prop="registration_id">
          <el-input v-model="currentLead.registration_id" />
        </el-form-item>
        <el-form-item :label="$t('lead.tax_id')" prop="tax_id">
          <el-input v-model="currentLead.tax_id" v-mask="['###.###.###-##', '##.###.###/####-##']" placeholder="123.123.123-12" />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="leadFormVisible = false">
          {{ $t('general.cancel') }}
        </el-button>
        <el-button type="primary" @click="handleSubmit()">
          {{ $t('general.confirm') }}
        </el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission'; // Import permission directive
import axios from 'axios';
import { mask } from 'vue-the-mask';
const leadResource = new Resource('leads');

export default {
  name: 'LeadList',
  directives: {
    permission,
    mask,
  }, // use permission directive
  data() {
    return {
      list: [{
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
        pet: [],
      }],
      loading: true,
      leadFormVisible: false,
      formTitle: '',
      zipcode: '',
      filter: '',
      currentLead: {},
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
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await leadResource.list({});
      this.list = data;
      this.loading = false;
    },

    isEmailValid() {
      return (this.email === '') ? '' : (this.reg.test(this.email)) ? 'has-success' : 'has-error';
    },

    handleFilter() {
      this.query.page = 1;
      this.getList();
    },

    handleSubmit() {
      if (this.currentLead.id !== undefined) {
        leadResource.update(this.currentLead.id, this.currentLead).then(response => {
          this.$message({
            type: 'success',
            message: 'Lead info has been updated successfully',
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.leadFormVisible = false;
        });
      } else {
        leadResource
          .store(this.currentLead)
          .then(response => {
            this.$message({
              message: 'New lead ' + this.currentLead.name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentLead = {
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
            this.cep = null;
            this.leadFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },

    handleCreateForm() {
      this.leadFormVisible = true;
      this.formTitle = this.$t('lead.createlead');
      this.currentLead = {
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
    },

    handleDelete(id, name) {
      this.$confirm('This will permanently delete lead ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        leadResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: 'Delete completed',
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },

    handleEditForm(id) {
      this.leadFormVisible = true;
      this.formTitle = this.$t('lead.editlead');
      this.currentLead = this.list.find(lead => lead.id === id);
    },

    searchZipcode() {
      if (/^[0-9]{5}-[0-9]{3}$/.test(this.currentLead.zipcode)) {
        // axios.get(url_cep).then(function (response) {
        axios.get(`https://viacep.com.br/ws/${this.currentLead.zipcode}/json/`)
          // .then(function (response) {
          .then(response => {
            // this.currentLead = response.data
            this.currentLead.address = response.data.logradouro;
            this.currentLead.neighborhood = response.data.bairro;
            this.currentLead.city = response.data.localidade;
            this.currentLead.state = response.data.uf;
          })
          .catch(error => console.log(error));
        this.$refs.address.focus();
      }
    },
  },
};
</script>
