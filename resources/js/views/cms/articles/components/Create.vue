<template>
  <div :key="componentKey">
    <div class="card-header">{{ $t('articles.createarticle') }}</div>
    <div class="card-body">
      <div v-if="status_msg" :class="{ 'alert-success': status, 'alert-danger': !status }" class="alert" role="alert">{{ status_msg }}</div>
      <el-form>
        <div class="form-group">
          <el-form-item :label="$t('articles.title')" prop="title">
            <el-input id="title" v-model="title" type="text" class="form-control" placeholder="Post Title" required />
          </el-form-item>
        </div>
        <div class="form-group">
          <el-form-item :label="$t('articles.body')" prop="title">
            <tinymce v-model="body" :height="300" />
          </el-form-item>
        </div>
        <div class>
          <el-upload action="https://jsonplaceholder.typicode.com/posts/" list-type="picture-card" :on-preview="handlePictureCardPreview" :on-change="updateImageList" :auto-upload="false">
            <i class="el-icon-plus" />
          </el-upload>
          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt>
          </el-dialog>
        </div>
      </el-form>
    </div>
    <div class="card-footer">
      <el-button type="button" class="btn btn-success" @click="createPost">{{ isCreatingPost ? "Posting..." : "Create Post" }}</el-button>
    </div>
  </div>
</template>

<script>
import Tinymce from '@/components/Tinymce';

export default {
  name: 'TinymceDemo',
  components: { Tinymce },
  data() {
    return {
      body: '',
    };
  },
};
</script>

<style scoped>
</style>
