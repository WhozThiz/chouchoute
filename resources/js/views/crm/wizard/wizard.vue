<template>
  <div class="app-container">
    <form-wizard shape="square" color="#20a0ff" error-color="#ff4949" @on-complete="onComplete">
      <h2 slot="title">This will replace my whole title</h2>
      <tab-content title="Lead Details" icon="el-icon-s-custom" :before-change="validateFirstStep">
        <el-form ref="ruleForm" :inline="true" :model="formInline" class="demo-form-inline" :rules="rules">
          <el-form-item label="Approved by" prop="user">
            <el-input v-model="formInline.user" placeholder="Approved by" />
          </el-form-item>
          <el-form-item label="Activity zone" prop="region">
            <el-select v-model="formInline.region" placeholder="Activity zone">
              <el-option label="Zone one" value="shanghai" />
              <el-option label="Zone two" value="beijing" />
            </el-select>
          </el-form-item>
        </el-form>
      </tab-content>
      <tab-content title="Pet Details" icon="el-icon-document"><svg-icon icon-class="create-user" />
        Second tab
      </tab-content>
      <tab-content title="Vaccination Infos" icon="el-icon-more-outline">
        Yuhuuu! This seems pretty damn simple
      </tab-content>
      <el-button slot="prev" type="primary">Back</el-button>
      <el-button slot="next" type="primary">Next</el-button>
      <el-button slot="finish" type="primary">Finish</el-button>
    </form-wizard>
  </div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';

export default {
  // name: 'FormWizardDemo',
  components: {
    FormWizard,
    TabContent,
  },
  data() {
    return {
      formInline: {
        user: '',
        region: '',
      },
      rules: {
        user: [{
          required: true,
          message: 'Please input Activity name',
          trigger: 'blur',
        }, {
          min: 3,
          max: 5,
          message: 'Length should be 3 to 5',
          trigger: 'blur',
        }],
        region: [{
          required: true,
          message: 'Please select Activity zone',
          trigger: 'change',
        }],
      },
    };
  },
  methods: {
    onComplete: function() {
      alert('Yay. Done!');
    },
    validateFirstStep() {
      return new Promise((resolve, reject) => {
        this.$refs.ruleForm.validate((valid) => {
          resolve(valid);
        });
      });
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>
