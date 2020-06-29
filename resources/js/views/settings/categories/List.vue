<template>
  <div class="app-container">

    <div class="filter-container">
      <el-button v-permission="['manage category']" class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('table.add') }}
      </el-button>
    </div>

    <el-table v-loading="loading" :data="children" row-key="name" stripe style="width: 100%">

      <el-table-column align="left" :label="$t('general.name')" prop="name" />
      <el-table-column align="left" label="Description" prop="description" />
      <el-table-column align="center" label="Actions">
        <template slot-scope="scope">
          <el-button v-permission="['manage category']" type="primary" size="small" icon="el-icon-plus" disabled @click="handleCreateForm(scope.row.id)">
            {{ $t('general.child') }}
          </el-button>
          <el-button v-permission="['manage category']" type="primary" size="small" icon="el-icon-edit" @click="handleEditForm(scope.row.id);">
            {{ $t('table.edit') }}
          </el-button>
          <el-button v-permission="['manage category']" type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
            {{ $t('table.delete') }}
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog :title="formTitle" :visible.sync="categoryFormVisible">
      <div class="form-container">
        <el-form ref="categoryForm" :model="currentCategory" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentCategory.name" />
          </el-form-item>
          <el-form-item label="Parent" prop="parent_id">
            <el-select v-model="currentCategory.parent_id" placeholder="Select Parent">
              <el-option v-for="item in parent" :key="item.id" :label="item.name" :value="item.id">
                <span style="float: left">{{ item.name }}</span>
                <span v-if="item.parent !== null" style="float: right">{{ item.parent.name }}</span>
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentCategory.description" type="textarea" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="categoryFormVisible = false">
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

const categoryResource = new Resource('categories');

export default {
  name: 'CategoryList',
  directives: { permission }, // use permission directive
  data() {
    return {
      children: [{
        id: '',
        name: '',
        description: '',
        children: [{}],
      }],
      parent: [],
      loading: true,
      categoryFormVisible: false,
      currentCategory: {},
      formTitle: '',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await categoryResource.list({});
      this.children = data.children;
      this.parent = data.parent;
      this.loading = false;
    },
    handleSubmit() {
      if (this.currentCategory.parent_id === undefined) {
        this.currentCategory.parent_id = null;
      }
      if (this.currentCategory.id !== undefined) {
        categoryResource.update(this.currentCategory.id, this.currentCategory).then(response => {
          this.$message({
            type: 'success',
            message: 'Category info has been updated successfully',
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.categoryFormVisible = false;
        });
      } else {
        categoryResource
          .store(this.currentCategory)
          .then(response => {
            this.$message({
              message: 'New category ' + this.currentCategory.name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentCategory = {
              name: '',
              description: '',
            };
            this.categoryFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    handleCreateForm() {
      this.categoryFormVisible = true;
      this.formTitle = this.$t('general.create') + ' ' + this.$t('general.category');
      this.currentCategory = {
        name: '',
        description: '',
      };
    },
    handleDelete(id, name) {
      this.$confirm('This will permanently delete category ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        categoryResource.destroy(id).then(response => {
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
      this.formTitle = 'Edit category';
      this.currentCategory = this.children.find(category => category.id === id);
      this.categoryFormVisible = true;
    },
  },
};
</script>

<style scoped>
</style>
