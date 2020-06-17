<template>
  <div class="app-container">

    <div class="filter-container">
      <el-input v-model="query.keyword" :placeholder="$t('table.keyword')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('table.add') }}
      </el-button>
    </div>

    <el-table v-loading="loading" :data="list.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))" stripe highlight-current-row max-height="400" style="width: 100%">

      <el-table-column fixed align="left" :label="$t('general.name')" prop="name" width="150">
        <template slot-scope="scope">
          <router-link v-show="scope.row.id !== null" :to="`/crm/pets/show/${scope.row.id}`">{{ scope.row.name }}</router-link>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('pet.breed')" prop="breed" min-width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.breed }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('pet.coat')">
        <template slot-scope="scope">
          <span>{{ scope.row.coat }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('pet.color')">
        <template slot-scope="scope">
          <span>{{ scope.row.color }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" :label="$t('general.birthdate')">
        <template slot-scope="scope">
          <span>{{ scope.row.birthdate }}</span>
        </template>
      </el-table-column>

      <el-table-column fixed="right" align="center" width="200">
        <template slot="header" :slot-scope="scope">
          <el-input v-model="search" placeholder="Type to Search" />
        </template>
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

    <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit" @pagination="getList" />

    <el-dialog :title="formTitle" :visible.sync="petFormVisible">
      <el-form ref="petForm" :model="currentPet" label-position="left" label-width="150px" style="max-width: 100%">
        <el-form-item :label="$t('general.name')" prop="name">
          <el-input v-model="currentPet.name" />
        </el-form-item>
        <el-form-item :label="$t('pet.breed')" prop="breed">
          <el-select v-model="currentPet.breed" placeholder="Select Breed">
            <el-option v-for="item in breeds" :key="item.id" :label="item.name" :value="item.name">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('pet.coat')" prop="coat">
          <el-select v-model="currentPet.coat" placeholder="Select Coat">
            <el-option v-for="item in coats" :key="item.id" :label="item.name" :value="item.name">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('pet.color')" prop="color">
          <el-input v-model="currentPet.color" />
        </el-form-item>
        <el-form-item :label="$t('general.gender')" prop="gender">
          <el-switch v-model="currentPet.gender" active-color="#409EFF" inactive-color="#F56C6C" active-text="Male" inactive-text="Female" :active-value="1" :inactive-value="0" />
        </el-form-item>
        <el-form-item :label="$t('general.birthdate')" prop="birthdate">
          <el-date-picker v-model="currentPet.birthdate" type="date" value-format="yyyy-MM-dd" placeholder="Pick a day" />
        </el-form-item>
        <el-form-item :label="$t('pet.neutered')" prop="neutered">
          <el-switch v-model="currentPet.neutered" active-color="#409EFF" inactive-color="#F56C6C" :active-text="$t('general.yes')" :inactive-text="$t('general.no')" :active-value="1" :inactive-value="0" />
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
    </el-dialog>
  </div>
</template>

<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import Resource from '@/api/resource';
import waves from '@/directive/waves'; // Waves directive
import CategoryResource from '@/api/category';

const categoryResource = new CategoryResource();
const petResource = new Resource('pets');

export default {
  name: 'PetList',
  components: { Pagination },
  directives: { waves },
  data() {
    return {
      list: [],
      breeds: [],
      coats: [],
      loading: true,
      petFormVisible: false,
      currentPet: {},
      formTitle: '',
      disabled: false,
      total: 0,
      query: {
        page: 1,
        limit: 20,
        keyword: '',
      },
      search: '',
    };
  },
  created() {
    this.getList();
    this.getCategories();
  },
  methods: {

    async getList() {
      const { limit, page } = this.query;
      this.loading = true;
      const { data, meta } = await petResource.list(this.query);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = meta.total;
      this.loading = false;
    },

    async getCategories() {
      const { data } = await categoryResource.getPetCategories({});
      this.coats = data.coats;
      this.breeds = data.breeds;
    },

    handleFilter() {
      this.query.page = 1;
      this.getList();
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
              color: '',
              birthdate: '',
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
        color: '',
        birthdate: '',
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
