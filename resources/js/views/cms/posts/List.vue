<template>
  <div>
    <h1>Posts</h1>
    <div class="row">
      <div class="col-md-10">&nbsp;</div>
      <div class="col-md-2">
        <router-link :to="{ name: 'Create Post' }" class="btn btn-primary">Create Post</router-link>
      </div>
    </div><br>

    <table class="table table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Body</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in posts" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.body }}</td>
          <td><router-link :to="{name: 'edit', params: { id: item.id }}" class="btn btn-primary">Edit</router-link></td>
          <td><button class="btn btn-danger" @click="deletePost(post.id)">Delete</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: [],
      post: {
        id: '',
        title: '',
        body: '',
      },
      post_id: '',
    };
  },

  created() {
    this.fetchList();
  },

  methods: {
    fetchList(page_url) {
      page_url = page_url || '/api/post';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.posts = res.data;
        })
        .catch(err => console.log(err));
    },
  },
};
</script>
