<template>
  <div class="app-container">
    <h2>Articles</h2>
    <form class="mb-3" @submit.prevent="addArticle">
      <div class="form-group">
        <input v-model="article.title" type="text" class="form-control" placeholder="Title">
      </div>
      <div class="form-group">
        <textarea v-model="article.content" class="form-control" placeholder="Content">&nbsp;
		</textarea>
      </div>
      <button class="btn btn-light btn-block" type="submit">Save</button>
    </form>
    <button class="btn btn-danger btn-block" @click="clearForm()">Cancel</button>
    <div v-for="item in articles" :key="item.id" class="card card-body mb-2">
      <h3>{{ item.title }}</h3>
      <p>{{ item.content }}</p>
      <hr>
      <button class="btn btn-warning mb-2" @click="editArticle(article)">Edit</button>
      <button class="btn btn-danger" @click="deleteArticle(article.id)">Delete</button>
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

        <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a></li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      articles: [],
      article: {
        id: '',
        title: '',
        content: '',
      },
      article_id: '',
      pagination: {},
      edit: false,
    };
  },

  created() {
    this.fetchArticles();
  },

  methods: {
    fetchArticles(page_url) {
      const vm = this;
      page_url = page_url || '/api/articles';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.articles = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      const pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev,
      };

      this.pagination = pagination;
    },
    deleteArticle(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/article/${id}`, {
          method: 'delete',
        })
          .then(res => res.json())
          .then(data => {
            alert('Article Removed');
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      }
    },
    addArticle() {
      if (this.edit === false) {
        // Add
        fetch('api/article', {
          method: 'post',
          body: JSON.stringify(this.article),
          headers: {
            'content-type': 'application/json',
          },
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Added');
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('api/article', {
          method: 'put',
          body: JSON.stringify(this.article),
          headers: {
            'content-type': 'application/json',
          },
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Article Updated');
            this.fetchArticles();
          })
          .catch(err => console.log(err));
      }
    },
    editArticle(article) {
      this.edit = true;
      this.article.id = article.id;
      this.article.article_id = article.id;
      this.article.title = article.title;
      this.article.content = article.content;
    },
    clearForm() {
      this.edit = false;
      this.article.id = null;
      this.article.article_id = null;
      this.article.title = '';
      this.article.content = '';
    },
  },
};
</script>
