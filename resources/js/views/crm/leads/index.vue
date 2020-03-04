<template>
  <div style="padding:30px;">
    <form class="mb-3" @submit.prevent="addLead">
      <div class="form-group">
        <input v-model="lead.name" type="text" class="form-control" placeholder="Name">
      </div>
      <div class="form-group">
        <input v-model="lead.address" type="text" class="form-control" placeholder="Address">
      </div>
      <div class="form-group">
        <input v-model="lead.neighborhood" type="text" class="form-control" placeholder="Neighborhood">
      </div>
      <div class="form-group">
        <input v-model="lead.city" type="text" class="form-control" placeholder="City">
      </div>
      <div class="form-group">
        <input v-model="lead.state" type="text" class="form-control" placeholder="State">
      </div>
      <div class="form-group">
        <input v-model="lead.zip" type="text" class="form-control" placeholder="Zip">
      </div>
      <div class="form-group">
        <input v-model="lead.email" type="text" class="form-control" placeholder="Email">
      </div>
      <div class="form-group">
        <input v-model="lead.phonenumber" type="text" class="form-control" placeholder="Phone Number">
      </div>
      <div class="form-group">
        <input v-model="lead.mobile" type="text" class="form-control" placeholder="Mobile">
      </div>
      <div class="form-group">
        <input v-model="lead.registration" type="text" class="form-control" placeholder="Registration">
      </div>
      <div class="form-group">
        <input v-model="lead.ssn" type="text" class="form-control" placeholder="SSN">
      </div>
      <hr>
      <button type="submit" class="btn btn-light btn-block">Save</button> <button class="btn btn-danger btn-block" @click="clearForm()">Cancel</button>
    </form>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchLeads(pagination.prev_page_url)">Previous</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

        <li :class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchLeads(pagination.next_page_url)">Next</a></li>
      </ul>
    </nav>
    <div v-for="data in leads" :key="data.id" class="card card-body mb-2">
      <h3>{{ data.name }}</h3>
      <p>{{ data.email }} | {{ data.address }}</p>
      <hr>
      <button class="btn btn-warning mb-2" @click="editLead(lead.id)">Edit</button>
      <button class="btn btn-danger" @click="deleteLead(lead.id)">Delete</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      leads: [],
      lead: {
        id: '',
        name: '',
        address: '',
        neighborhood: '',
        city: '',
        state: '',
        zipcode: '',
        homephone: '',
        mobile: '',
        email: '',
        registration: '',
        ssn: '',
      },
      lead_id: '',
      pagination: {},
      edit: false,
    };
  },

  created() {
    this.fetchLeads();
  },

  methods: {
    fetchLeads(page_url) {
      const vm = this;
      page_url = page_url || '/api/leads';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.leads = res.data;
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
    deleteLead(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/lead/${id}`, {
          method: 'delete',
        })
          .then(res => res.json())
          .then(data => {
            alert('Lead Removed');
            this.fetchLeads();
          })
          .catch(err => console.log(err));
      }
    },
    addLead() {
      if (this.edit === false) {
        // Add
        fetch('crm/lead', {
          method: 'post',
          body: JSON.stringify(this.lead),
          headers: {
            'content-type': 'application/json',
          },
        })
          .then(res => res.json())
          .then(data => {
            this.lead.name = '';
            this.lead.email = '';
            this.lead.address = '';
            this.lead.neighborhood = '';
            this.lead.city = '';
            alert('Lead Added');
            this.fetchLeads();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('api/lead', {
          method: 'put',
          body: JSON.stringify(this.lead),
          headers: {
            'content-type': 'application/json',
          },
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Lead Updated');
            this.fetchLeads();
          })
          .catch(err => console.log(err));
      }
    },
    editLead(lead) {
      this.edit = true;
      this.lead.id = lead.id;
      this.lead.lead_id = lead.id;
      this.lead.name = lead.name;
      this.lead.email = lead.email;
      this.lead.address = lead.address;
    },
    clearForm() {
      this.edit = false;
      this.lead.id = null;
      this.lead.lead_id = null;
      this.lead.name = '';
      this.lead.email = '';
      this.lead.address = '';
    },
  },
};
</script>

