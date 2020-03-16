<template>
  <div class="app-container">

    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('general.add') }}
      </el-button>
    </div>

    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('general.name')">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('pet.breed')" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.breed }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('pet.coat')" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.coat }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('general.gender')" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.gender }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('pet.neutered')" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.neutered }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('general.birthday')" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.birthday }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEditForm(scope.row.id);">
            {{ $t('general.edit') }}
          </el-button>
          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
            {{ $t('general.delete') }}
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog :title="formTitle" :visible.sync="petFormVisible">
      <div class="form-container">
        <el-form ref="petForm" :model="currentPet" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item :label="$t('general.name')" prop="name">
            <el-input v-model="currentPet.name" />
          </el-form-item>
          <el-form-item :label="$t('pet.breed')" prop="breed">
            <el-input v-model="currentPet.breed" />
          </el-form-item>
          <el-form-item :label="$t('pet.coat')" prop="coat">
            <el-input v-model="currentPet.coat" />
          </el-form-item>
          <el-form-item :label="$t('general.gender')" prop="gender">
            <el-input v-model="currentPet.gender" />
          </el-form-item>
          <el-form-item :label="$t('general.birthday')" prop="birthday">
            <el-input v-model="currentPet.birthday" />
          </el-form-item>
          <el-form-item :label="$t('pet.neutered')" prop="neutered">
            <el-input v-model="currentPet.neutered" />
          </el-form-item>
          <el-form-item :label="$t('pet.registration')" prop="registration">
            <el-input v-model="currentPet.registration" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="petFormVisible = false">
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
const petResource = new Resource('pets');

export default {
  name: 'PetList',
  data() {
    return {
      list: [],
      loading: true,
      petFormVisible: false,
      currentPet: {},
      formTitle: '',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await petResource.list({});
      this.list = data;
      this.loading = false;
    },
    handleSubmit() {
      if (this.currentPet.id !== undefined) {
        petResource.update(this.currentPet.id, this.currentPet).then(response => {
          this.$message({
            type: 'success',
            message: this.$t('pet.petprofile') + ' ' + this.$t('general.hasbeenupdatedsucessfully'),
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.petFormVisible = false;
        });
      } else {
        petResource
          .store(this.currentPet)
          .then(response => {
            this.$message({
              message: this.$t('pet.newpet') + ' ' + this.currentPet.name + ' ' + this.$t('general.hasbeenupdatedsucessfully'),
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentPet = {
              name: '',
              breed: '',
              coat: '',
              gender: '',
              birthday: '',
              neutered: '',
              registration: '',
            };
            this.petFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    handleCreateForm() {
      this.petFormVisible = true;
      this.formTitle = this.$t('pet.createpet');
      this.currentPet = {
        name: '',
        breed: '',
        coat: '',
        gender: '',
        birthday: '',
        neutered: '',
        registration: '',
      };
    },
    handleDelete(id, name) {
      this.$confirm('This will permanently delete pet ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        petResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: this.$t('general.deletecompleted'),
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: this.$t('general.deletecanceled'),
        });
      });
    },
    handleEditForm(id) {
      this.petFormVisible = true;
      this.formTitle = this.$t('pet.editpet');
      this.currentPet = this.list.find(pet => pet.id === id);
    },
  },
};
</script>
