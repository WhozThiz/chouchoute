<template>
  <div>
    <h1>Edit Post</h1>
    <form @submit.prevent="updatePost">
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
            <textarea v-model="post.body" class="form-control" rows="5" />
          </div>
        </div>
      </div><br>
      <div class="form-group">
        <button class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      post: {},
    };
  },
  created() {
    const uri = `http://vuelaravelcrud.test/api/post/edit/${this.$route.params.id}`;
    this.axios.get(uri).then((response) => {
      this.post = response.data;
    });
  },
  methods: {
    updatePost() {
      const uri = `http://vuelaravelcrud.test/api/post/update/${this.$route.params.id}`;
      this.axios.post(uri, this.post).then((response) => {
        this.$router.push({ name: 'posts' });
      });
    },
  },
};
</script>
