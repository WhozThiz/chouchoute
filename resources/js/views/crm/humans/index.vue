<template>
  <div style="padding:30px;">
    <h2>Humans</h2>
    <form class="mb-3" @submit.prevent="addHuman">
      <div class="form-group">
        <input v-model="human.name" type="text" class="form-control" placeholder="Name">
      </div>
      <div class="form-group">
        <textarea v-model="human.email" class="form-control" placeholder="Email">&nbsp;</textarea>
      </div>
      <button type="submit" class="btn btn-light btn-block">Save</button>
    </form>
    <button class="btn btn-danger btn-block" @click="clearForm()">Cancel</button>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchHumans(pagination.prev_page_url)">Previous</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

        <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchHumans(pagination.next_page_url)">Next</a></li>
      </ul>
    </nav>
    <div v-for="data in humans" :key="data.id" class="card card-body mb-2">
      <h3>{{ data.name }}</h3>
      <p>{{ data.email }}</p>
      <hr>
      <button class="btn btn-warning mb-2" @click="editHuman(human)">Edit</button>
      <button class="btn btn-danger" @click="deleteHuman(human.id)">Delete</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      humans: [],
      human: {
        id: '',
        name: '',
        email: '',
      },
      human_id: '',
      pagination: {},
      edit: false,
    };
  },

  created() {
    this.fetchHumans();
  },

  methods: {
    fetchHumans(page_url) {
      const vm = this;
      page_url = page_url || '/api/humans';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.humans = res.data;
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
    deleteHuman(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/human/${id}`, {
          method: 'delete',
        })
          .then(res => res.json())
          .then(data => {
            alert('Human Removed');
            this.fetchHumans();
          })
          .catch(err => console.log(err));
      }
    },
    addHuman() {
      if (this.edit === false) {
        // Add
        fetch('api/human', {
          method: 'post',
          body: JSON.stringify(this.human),
          headers: {
            'content-type': 'application/json',
          },
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Human Added');
            this.fetchHumans();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('api/human', {
          method: 'put',
          body: JSON.stringify(this.human),
          headers: {
            'content-type': 'application/json',
          },
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Human Updated');
            this.fetchHumans();
          })
          .catch(err => console.log(err));
      }
    },
    editHuman(human) {
      this.edit = true;
      this.human.id = human.id;
      this.human.human_id = human.id;
      this.human.name = human.name;
      this.human.email = human.email;
    },
    clearForm() {
      this.edit = false;
      this.human.id = null;
      this.human.human_id = null;
      this.human.name = '';
      this.human.email = '';
    },
  },
};
</script>
