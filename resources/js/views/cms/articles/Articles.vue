<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">{{ $t('general.add') }}</el-button>
    </div>
    <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column min-width="300px" label="Title">
        <template slot-scope="{row}">
          <router-link :to="'/articles/edit/'+row.id" class="link-type">
            <span>{{ row.title }}</span>
          </router-link>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="120">
        <template slot-scope="scope">
          <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEditForm(scope.row.id);">
            Edit
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog :title="formTitle" :visible.sync="articleFormVisible">
      <div class="form-container">
        <el-form ref="ArticleForm" :model="currentArticle">
          <el-form-item :label="$t('articles.title')" prop="title">
            <el-input id="title" v-model="currentArticle.title" type="text" class="form-control" placeholder="Article Title" required />
          </el-form-item>
          <el-form-item :label="$t('articles.authors')" prop="authors">
            <el-input id="authors" v-model="currentArticle.authors" type="text" class="form-control" placeholder="Article Authors" />
          </el-form-item>
          <el-form-item :label="$t('articles.keywords')" prop="keywords">
            <el-input id="keywords" v-model="currentArticle.keywords" type="text" class="form-control" placeholder="Article Keywords" />
          </el-form-item>
          <el-form-item :label="$t('articles.abstract')" prop="abstract">
            <el-input id="abstract" v-model="currentArticle.abstract" type="text" class="form-control" placeholder="Article Abstract" />
          </el-form-item>
          <el-form-item :label="$t('articles.introduction')" prop="introduction">
            <el-input id="introduction" v-model="currentArticle.introduction" type="text" class="form-control" placeholder="Article Introduction" />
          </el-form-item>
          <el-form-item :label="$t('articles.body')" prop="body">
            <tinymce v-model="currentArticle.body" />
          </el-form-item>
          <el-form-item :label="$t('articles.references')" prop="references">
            <el-input id="references" v-model="currentArticle.references" type="text" class="form-control" placeholder="Article References" />
          </el-form-item>
          <el-form-item :label="$t('articles.publish_time')" prop="publish_time">
            <el-date-picker v-model="currentArticle.publish_time" type="datetime" value-format="yyyy-MM-dd HH:mm:ss" placeholder="Pick a Day and Time" />
          </el-form-item>
          <el-form-item :label="$t('articles.publish_status')" prop="publish_status">
            <el-switch id="publish_status" v-model="currentArticle.publish_status" :active-text="$t('general.yes')" :inactive-text="$t('general.no')" active-value="1" inactive-value="0" />
          </el-form-item>
          <el-form-item :label="$t('articles.comment_status')" prop="comment_status">
            <el-switch id="comment_status" v-model="currentArticle.comment_status" :active-text="$t('general.yes')" :inactive-text="$t('general.no')" active-value="1" inactive-value="0" />
          </el-form-item>
          <!--
          <el-upload action="https://jsonplaceholder.typicode.com/posts/" list-type="picture-card" :on-preview="handlePictureCardPreview" :on-change="updateImageList" :auto-upload="false">
            <i class="el-icon-plus" />
          </el-upload>
          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt>
          </el-dialog>
          -->
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="articleFormVisible = false">{{ $t('general.cancel') }}</el-button>
          <el-button type="primary" @click="handleSubmit()">{{ $t('general.confirm') }}</el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import Tinymce from '@/components/Tinymce';

const articleResource = new Resource('articles');

export default {
  name: 'ArticleList',
  components: { Tinymce },

  data() {
    return {
      currentArticle: {},
      list: [],
      listLoading: true,
      articleFormVisible: false,
      formTitle: '',
    };
  },

  created() {
    this.getList();
  },

  methods: {

    async getList() {
      this.listLoading = true;
      const { data } = await articleResource.list({});
      this.list = data.items.data;
      this.listLoading = false;
    },

    handleCreateForm() {
      this.articleFormVisible = true;
      this.formTitle = this.$t('articles.createarticle');
      this.currentArticle = {
        title: '',
        authors: '',
        keywords: '',
        abstract: '',
        introduction: '',
        body: '',
        references: '',
        publish_status: false,
        publish_time: '',
        comment_status: false,
      };
    },

    handleEditForm(id) {
      this.articleFormVisible = true;
      this.formTitle = this.$t('articles.editarticle');
      this.currentArticle = this.list.find(article => article.id === id);
    },

    handleSubmit() {
      if (this.currentArticle.id !== undefined) {
        articleResource.update(this.currentArticle.id, this.currentArticle).then(response => {
          this.$message({
            type: 'success',
            message: 'Article Info has been Updated Successfully.',
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.articleFormVisible = false;
        });
      } else {
        articleResource
          .store(this.currentArticle)
          .then(response => {
            this.$message({
              message: 'New Article ' + this.currentArticle.title + ' has been Created Sucefully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentArticle = {
              title: '',
              authors: '',
              keywords: '',
              abstract: '',
              introduction: '',
              body: '',
              references: '',
              publish_status: false,
              publish_time: '',
              comment_status: false,
            };
            this.articleFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },

    handleDelete(id, name) {
      this.$confirm('This will permanently delete article ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        articleResource.destroy(id).then(response => {
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

  },

};
</script>

<style  scoped>
</style>
