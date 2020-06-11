<template>
  <el-card>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane :label="$t('pet.vaccines')" name="first">
        <div>
          <el-form :inline="true">
            <el-form-item :label="$t('general.date')" prop="'date'">
              <el-date-picker type="date" placeholder="Pick a day" :picker-options="pickerOptions" />
            </el-form-item>
            <el-form-item
              :label="$t('pet.vaccine')"
              :prop="vaccine"
              :rules="{
                required: true, message: 'vaccine can not be null', trigger: 'blur'
              }"
            >
              <el-input v-model="vaccine" />
            </el-form-item>
            <el-form-item :label="$t('pet.validation')" prop="validation">
              <el-date-picker v-model="validation" type="date" placeholder="Pick a day" />
            </el-form-item>
            <el-form-item>
              <el-button type="primary" icon="el-icon-add" @click="addVaccine">Add Vaccine</el-button>
            </el-form-item>
          </el-form>
          <p v-for="(vaccine, index) in vaccines" :key="index">{{ vaccine.vaccinedate }} - {{ vaccine.vaccine }} - {{ vaccine.batch }}</p>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Timeline" name="second">
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
      <el-tab-pane v-loading="updating" :label="$t('general.profile')" name="third">
        <el-form ref="updatePet" :model="updatePet">
          <el-form-item :label="$t('general.name')" prop="name">
            <el-input v-model="pet.name" />
          </el-form-item>
          <el-form-item :label="$t('pet.breed')" prop="breed">
            <el-input v-model="pet.breed" />
          </el-form-item>
          <el-form-item :label="$t('pet.coat')" prop="coat">
            <el-input v-model="pet.coat" />
          </el-form-item>
          <el-form-item>
            <el-col :span="8">
              <el-form-item :label="$t('general.birthday')" prop="birthdate">
                <el-date-picker v-model="pet.birthdate" type="date" placeholder="Pick a day" />
              </el-form-item>
            </el-col>
            <el-col class="line" :span="1">-</el-col>
            <el-col :span="7">
              <el-form-item :label="$t('general.gender')" prop="gender">
                <el-switch v-model="pet.gender" active-color="#409EFF" inactive-color="#F56C6C" :active-text="$t('pet.male')" :inactive-text="$t('pet.female')" />
              </el-form-item>
            </el-col>
            <el-col class="line" :span="1">-</el-col>
            <el-col :span="7">
              <el-form-item :label="$t('pet.neutered')" prop="neutered">
                <el-switch v-model="pet.neutered" active-color="#13ce66" inactive-color="#ff4949" :active-text="$t('general.yes')" :inactive-text="$t('general.no')" />
              </el-form-item>
            </el-col>
          </el-form-item>
          <el-form-item :label="$t('pet.registration')" prop="registration_id">
            <el-input v-model="pet.registration_id" />
          </el-form-item>
        </el-form>
        <el-form-item>
          <el-button type="primary" @click="onSubmit">
            Update
          </el-button>
        </el-form-item>
      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
import Resource from '@/api/resource';
import VaccineResource from '@/api/vaccines';
import { mask } from 'vue-the-mask';

const petResource = new Resource('pets');
const vaccineResource = new VaccineResource();

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
          avatar: '',
        };
      },
    },
  },
  data() {
    return {
      vaccines: [],
      activeActivity: 'first',
      carouselImages: [
        'https://cdn.laravue.dev/photo1.png',
        'https://cdn.laravue.dev/photo2.png',
        'https://cdn.laravue.dev/photo3.jpg',
        'https://cdn.laravue.dev/photo4.jpg',
      ],
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
  },
  methods: {
    async getVaccines(id) {
      const { data } = await vaccineResource.vaccines({ pet_id: id });
      this.vaccines = data;
    },
    handleClick(tab, event) {
      console.log('Switching tab ', tab, event);
    },
    onSubmit() {
      this.updating = true;
      petResource
        .update(this.pet.id, this.pet)
        .then(response => {
          this.updating = false;
          this.$message({
            message: 'Pet information has been updated successfully',
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
