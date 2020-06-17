<template>
  <el-card>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane :label="$t('pet.vaccines')" name="Vaccines">
        <div>
          <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
            {{ $t('table.add') }}
          </el-button>
          <el-table :data="vaccines" style="width: 100%">
            <el-table-column prop="vaccinedate" label="Date" width="180" />
            <el-table-column prop="category.name" label="Vaccine" width="180" />
            <el-table-column prop="vaccinebatch" label="Batch" />
            <el-table-column fixed="right" label="Action">
              <template slot-scope="scope">
                <el-button type="text" @click="handleEditForm(scope.row.id);">Edit</el-button>
                <el-button type="text" @click="handleDelete(scope.row.id, scope.row.vaccine);">{{ $t('general.delete') }}</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Timeline" name="Timeline">
        <div class="block">
          <el-timeline>
            <el-timeline-item timestamp="2019/4/17" placement="top">
              <el-card>
                <h4>Update Github template</h4>
                <p>tuandm committed 2019/4/17 20:46</p>
              </el-card>
            </el-timeline-item>
            <el-timeline-item timestamp="2019/4/18" placement="top">
              <el-card>
                <h4>Update Github template</h4>
                <p>tonynguyen committed 2019/4/18 20:46</p>
              </el-card>
              <el-card>
                <h4>Update Github template</h4>
                <p>tuandm committed 2019/4/19 21:16</p>
              </el-card>
            </el-timeline-item>
            <el-timeline-item timestamp="2019/4/19" placement="top">
              <el-card>
                <h4>
                  Deploy
                  <a href="https://laravue.dev" target="_blank">laravue.dev</a>
                </h4>
                <p>tuandm deployed 2019/4/19 10:23</p>
              </el-card>
            </el-timeline-item>
          </el-timeline>
        </div>
      </el-tab-pane>
      <el-tab-pane v-loading="updating" :label="$t('general.profile')" name="Update">
        <el-form ref="petForm" :model="pet" label-width="100px">
          <el-form-item :label="$t('general.name')" prop="name">
            <el-input v-model="pet.name" />
          </el-form-item>
          <el-form-item :label="$t('pet.breed')" prop="breed">
            <el-select v-model="pet.breed" placeholder="Select Breed">
              <el-option v-for="item in breeds" :key="item.id" :label="item.name" :value="item.name">
                <span style="float: left">{{ item.name }}</span>
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="$t('pet.coat')" prop="coat">
            <el-select v-model="pet.coat" placeholder="Select Coat">
              <el-option v-for="item in coats" :key="item.id" :label="item.name" :value="item.name">
                <span style="float: left">{{ item.name }}</span>
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="$t('pet.color')" prop="color">
            <el-input v-model="pet.color" />
          </el-form-item>
          <el-form-item :label="$t('general.birthdate')" prop="birthdate">
            <el-date-picker v-model="pet.birthdate" type="date" value-format="yyyy-MM-dd" placeholder="Pick a day" />
          </el-form-item>
          <el-form-item>
            <el-col :span="12">
              <el-form-item :label="$t('general.gender')" prop="gender">
                <el-switch v-model="pet.gender" active-color="#409EFF" inactive-color="#F56C6C" active-icon-class="el-icon-male" inactive-icon-class="el-icon-female" :active-value="1" :inactive-value="0" />
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item :label="$t('pet.neutered')" prop="neutered">
                <el-switch v-model="pet.neutered" active-color="#13ce66" inactive-color="#ff4949" active-icon-class="el-icon-circle-check" inactive-icon-class="el-icon-circle-close" :active-value="1" :inactive-value="0" />
              </el-form-item>
            </el-col>
          </el-form-item>
          <el-form-item :label="$t('pet.registration')" prop="registration">
            <el-input v-model="pet.registration" />
          </el-form-item>
        </el-form>
        <el-form-item>
          <el-button type="primary" @click="handleSubmit">
            {{ $t('general.update') }}
          </el-button>
        </el-form-item>
      </el-tab-pane>
    </el-tabs>

    <el-dialog :title="formTitle" :visible.sync="vaccineFormVisible">
      <el-form ref="vaccineForm" :model="currentVaccine" :inline="true" label-width="100px" width="100%">
        <el-form-item :label="$t('general.date')" prop="'vaccinedate'">
          <el-date-picker v-model="currentVaccine.vaccinedate" type="date" value-format="yyyy-MM-dd" placeholder="Pick a day" :picker-options="pickerOptions" />
        </el-form-item>
        <el-form-item :label="$t('pet.vaccine')" prop="vaccine">
          <el-select v-model="currentVaccine.category" placeholder="Select Vaccine">
            <el-option v-for="item in vaccinecategories" :key="item.id" :label="item.name" :value="item.id">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('pet.batch')" prop="batch">
          <el-input v-model="currentVaccine.vaccinebatch" />
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="handleVaccine()">{{ $t('general.confirm') }}</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </el-card>

</template>

<script>
import Resource from '@/api/resource';
import VaccineResource from '@/api/vaccines';
import CategoryResource from '@/api/category';
import { mask } from 'vue-the-mask';

const petResource = new Resource('pets');
const vaccinesResource = new Resource('vaccines');
const vaccineResource = new VaccineResource();
const categoryResource = new CategoryResource();

export default {
  directives: {
    mask,
  },
  props: {
    pet: {
      type: Object,
      default: () => {
        return {
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
    },
  },
  data() {
    return {
      vaccines: [{
        vaccinedate: '',
        vaccine: '',
        vaccinebatch: '',
        category: {
          name: '',
        },
      }],
      breeds: [],
      coats: [],
      vaccinecategories: [],
      formTitle: '',
      vaccineFormVisible: false,
      currentVaccine: {},
      activeActivity: 'Vaccines',
      updating: false,
      pickerOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
        shortcuts: [{
          text: 'Today',
          onClick(picker) {
            picker.$emit('pick', new Date());
          },
        }, {
          text: 'Yesterday',
          onClick(picker) {
            const date = new Date();
            date.setTime(date.getTime() - 3600 * 1000 * 24);
            picker.$emit('pick', date);
          },
        }, {
          text: 'A week ago',
          onClick(picker) {
            const date = new Date();
            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
            picker.$emit('pick', date);
          },
        }],
      },
    };
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    this.getVaccines(id);
    this.getVaccineCategories();
    this.getPetCategories();
  },
  methods: {

    async getVaccines(id) {
      const { data } = await vaccineResource.vaccines({ pet_id: id });
      this.vaccines = data;
    },

    async getVaccineCategories() {
      const { data } = await categoryResource.getVaccineCategories({});
      this.vaccinecategories = data;
    },

    async getPetCategories() {
      const { data } = await categoryResource.getPetCategories({});
      this.coats = data.coats;
      this.breeds = data.breeds;
    },

    handleClick(tab, event) {
      console.log(tab, event);
    },

    handleCreateForm() {
      this.vaccineFormVisible = true;
      this.currentVaccine = {
        vaccinedate: '',
        vaccine: '',
        vaccinebatch: '',
        category: {
          name: '',
        },
      };
    },

    handleEditForm(id) {
      this.vaccineFormVisible = true;
      this.currentVaccine = this.vaccines.find(vaccine => vaccine.id === id);
    },

    handleVaccine() {
      if (this.currentVaccine.id !== undefined) {
        vaccinesResource.update(this.currentVaccine.id, this.currentVaccine).then(response => {
          this.$message({
            type: 'success',
            message: this.$t('pet.petprofile') + ' ' + this.$t('general.hasbeenupdatedsucessfully'),
            duration: 5 * 1000,
          });
          this.vaccineFormVisible = false;
          this.getVaccines(this.pet.id);
        }).catch(error => {
          console.log(error);
        });
      } else {
        this.currentVaccine.pet_id = this.pet.id;
        vaccinesResource
          .store(this.currentVaccine)
          .then(response => {
            this.$message({
              message: 'Added Successfully',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentVaccine = {
              vaccinedate: '',
              vaccine: '',
              vaccinebatch: '',
            };
            this.vaccineFormVisible = false;
            this.getVaccines(this.pet.id);
          })
          .catch(error => {
            console.log(error);
          });
      }
    },

    handleDelete(id, vaccine) {
      this.$confirm('This will permanently delete pet ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        vaccinesResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: this.$t('general.deletecompleted'),
          });
          this.getVaccines(this.pet.id);
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

    handleSubmit() {
      this.updating = true;
      petResource
        .update(this.pet.id, this.pet)
        .then(response => {
          this.updating = false;
          this.$message({
            message: 'Added Successfully',
            type: 'success',
            duration: 5 * 1000,
          });
        })
        .catch(error => {
          console.log(error);
          this.updating = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.pet-activity {
  .user-block {
    .username, .description {
      display: block;
      margin-left: 50px;
      padding: 2px 0;
    }
    img {
      width: 40px;
      height: 40px;
      float: left;
    }
    :after {
      clear: both;
    }
    .img-circle {
      border-radius: 50%;
      border: 2px solid #d2d6de;
      padding: 2px;
    }
    span {
      font-weight: 500;
      font-size: 12px;
    }
  }
  .post {
    font-size: 14px;
    border-bottom: 1px solid #d2d6de;
    margin-bottom: 15px;
    padding-bottom: 15px;
    color: #666;
    .image {
      width: 100%;
    }
    .user-images {
      padding-top: 20px;
    }
  }
  .list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
    li {
      display: inline-block;
      padding-right: 5px;
      padding-left: 5px;
      font-size: 13px;
    }
    .link-black {
      &:hover, &:focus {
        color: #999;
      }
    }
  }
  .el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }
}
</style>
