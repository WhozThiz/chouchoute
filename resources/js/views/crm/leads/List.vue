<template>
  <div class="app-container">

    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('general.add') }}
      </el-button>
    </div>

    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="60">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('lead.name')" width="300">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('lead.homephone')" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.homephone }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('lead.mobile')" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.mobile }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('lead.address')">
        <template slot-scope="scope">
          <span>{{ scope.row.address }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="350">
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
      <div class="form-container">
        <el-form ref="leadForm" :model="currentLead" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item :label="$t('lead.name')" prop="name">
            <el-input v-model="currentLead.name" />
          </el-form-item>
          <el-form-item :label="$t('lead.zipcode')" prop="zipcode">
            <el-input v-model="currentLead.zipcode" placeholder="XXXXX-XXX" @keyup.enter.native="searchZipcode()" />
          </el-form-item>
          <el-form-item :label="$t('lead.address')" prop="address">
            <el-input ref="address" v-model="currentLead.address" />
          </el-form-item>
          <el-form-item :label="$t('lead.neighborhood')" prop="neighborhood">
            <el-input v-model="currentLead.neighborhood" />
          </el-form-item>
          <el-form-item :label="$t('lead.city')" prop="city">
            <el-input v-model="currentLead.city" />
          </el-form-item>
          <el-form-item :label="$t('lead.state')" prop="state">
            <el-input v-model="currentLead.state" />
          </el-form-item>
          <el-form-item :label="$t('lead.homephone')" prop="homephone">
            <el-input v-model="currentLead.homephone" />
          </el-form-item>
          <el-form-item :label="$t('lead.mobile')" prop="mobile">
            <el-input v-model="currentLead.mobile" />
          </el-form-item>
          <el-form-item :label="$t('lead.email')" prop="email">
            <el-input v-model="currentLead.email" />
          </el-form-item>
          <el-form-item :label="$t('lead.registration_id')" prop="registration_id">
            <el-input v-model="currentLead.registration_id" />
          </el-form-item>
          <el-form-item :label="$t('lead.tax_id')" prop="tax_id">
            <el-input v-model="currentLead.tax_id" />
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
      </div>
    </el-dialog>

  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission'; // Import permission directive
import axios from 'axios';
const leadResource = new Resource('leads');

export default {
  name: 'LeadList',
  directives: { permission }, // use permission directive
  data() {
    return {
      list: [],
      loading: true,
      leadFormVisible: false,
      formTitle: '',
      zipcode: '',
      currentLead: {},
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
