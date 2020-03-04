<template>
  <div>
    <h1>Create A Post</h1>
    <form @submit.prevent="addPost">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Post Title:</label>
            <input v-model="post.title" type="text" class="form-control">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Post Body:</label>
            <textarea v-model="post.body" class="form-control" rows="5">&nbsp;</textarea>
          </div>
        </div>
      </div><br>
      <div class="form-group">
        <button class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data(){
    return {
      post: {},
    };
  },
  methods: {
    addPost(){
      const uri = '/api/post/create';
      this.axios.post(uri, this.$http.post).then((response) => {
        this.$router.push({ name: 'posts' });
      });
    },
  },
};
</script>
