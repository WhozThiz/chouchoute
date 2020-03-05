<template>
  <div class="app-container">

    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('table.add') }}
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
            Edit
          </el-button>
          <el-button v-permission="['manage lead']" type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
            Delete
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
          <el-form-item :label="$t('lead.address')" prop="address">
            <el-input v-model="currentLead.address" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="leadFormVisible = false">
            Cancel
          </el-button>
          <el-button type="primary" @click="handleSubmit()">
            Confirm
          </el-button>
        </div>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission'; // Import permission directive
const leadResource = new Resource('leads');

export default {
  name: 'LeadList',
  directives: { permission }, // use permission directive
  data() {
    return {
      list: [],
      loading: true,
      leadFormVisible: false,
      currentLead: {},
      formTitle: '',
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
              description: '',
            };
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
      this.formTitle = 'Create new lead';
      this.currentLead = {
        name: '',
        description: '',
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
      this.formTitle = 'Edit lead';
      this.currentLead = this.list.find(lead => lead.id === id);
      this.leadFormVisible = true;
    },
  },
};
</script>
