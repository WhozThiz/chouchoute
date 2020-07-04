<template>
  <div class="app-container">

    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('table.add') }}
      </el-button>
    </div>

    <el-dialog :title="formTitle" :visible.sync="contractFormVisible" :before-close="handleClose">
      <el-form ref="revenueForm" :model="currentContract" label-position="left" label-width="150px" style="max-width: 100%">
        <el-form-item :label="$t('general.date')" prop="date">
          <el-date-picker v-model="currentContract.date" type="date" value-format="yyyy-MM-dd" clear-icon="el-icon-circle-close" placeholder="Pick a day" />
        </el-form-item>
        <el-form-item :label="$t('accounting.account')" prop="account_id">
          <el-select v-model="currentContract.account" :placeholder="'Select ' + $t('accounting.account')">
            <el-option v-for="item in accounts" :key="item.id" :label="item.name" :value="item.name">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('accounting.customer')" prop="lead_id">
          <el-select v-model="currentContract.lead_id" :placeholder="'Select ' + $t('accounting.customer')">
            <el-option v-for="item in leads" :key="item.id" :label="item.name" :value="item.id">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('general.category')" prop="category_id">
          <el-select v-model="currentContract.category" :placeholder="'Select ' + $t('general.category')">
            <el-option v-for="item in operatings" :key="item.id" :label="item.name" :value="item.name">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
            <el-option v-for="item in non_operatings" :key="item.id" :label="item.name" :value="item.name">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('table.description')" prop="description">
          <el-input v-model="currentContract.desc" type="textarea" :placeholder="$t('table.description')" />
        </el-form-item>
        <el-form-item :label="$t('general.reference')" prop="reference">
          <el-input v-model="currentContract.reference" :placeholder="$t('general.reference')"><template slot="prepend"><svg-icon icon-class="reference" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('general.value')" prop="value">
          <el-input v-model.lazy="currentContract.value" v-money="money" placeholder="Enter Amount"><template slot="prepend"><svg-icon icon-class="moneyncoin" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.paymentmethod')" prop="payment_method">
          <el-select v-model="currentContract.account" :placeholder="'Select ' + $t('accounting.paymentmethod')">
            <el-option v-for="item in payment_methods" :key="item.id" :label="item.name" :value="item.name">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('accounting.recurring')" prop="recurring">
          <el-select v-model="currentContract.recurring" :placeholder="'Select ' + $t('accounting.recurring')">
            <el-option v-for="item in recurring" :key="item.id" :label="item.name" :value="item.id">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="contractFormVisible = false">
          {{ $t('general.cancel') }}
        </el-button>
        <el-button type="primary" @click="handleSubmit()">
          {{ $t('general.confirm') }}
        </el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import CategoryResource from '@/api/category';
import { mask } from 'vue-the-mask';
import { VMoney } from 'v-money';

const accountResource = new Resource('accounts');
const categoryResource = new CategoryResource();
const leadResource = new Resource('leads');

export default {
  name: 'Income',
  directives: {
    mask,
    money: VMoney,
  },
  props: {
  },
  data() {
    return {
      income: {
        title: 'Hello World',
      },
      contractFormVisible: false,
      formTitle: '',
      category: [],
      currentContract: {},
      accounts: [],
      leads: [],
      non_operatings: [],
      operatings: [],
      payment_methods: [],
      recurring: [],
      money: {
        decimal: ',',
        thousands: '.',
        prefix: 'R$ ',
        suffix: '',
        precision: 2,
        masked: false,
      },
    };
  },
  created() {
    this.getAccounts();
    this.getCategories();
    this.getLeads();
  },
  methods: {

    async getAccounts() {
      const { data } = await accountResource.list({});
      this.accounts = data;
    },

    async getCategories() {
      const { data } = await categoryResource.getRevenueCategories({});
      this.operatings = data.operatings;
      this.non_operatings = data.non_operatings;
      this.payment_methods = data.payment_methods;
    },

    async getLeads() {
      const { data } = await leadResource.list({});
      this.leads = data;
    },

    handleCreateForm() {
      this.contractFormVisible = true;
      this.formTitle = this.$t('general.new') + ' ' + this.$t('route.contract');
      this.currentContract = {
      };
    },

    handleSubmit() {
      this.contractFormVisible = false;
      this.currentContract = {
      };
    },

    handleClose(done) {
      this.$confirm('Are You Want to Leave?')
        .then(_ => {
          done();
        })
        .catch(_ => {});
    },
  },
};
</script>

<style scoped>
.el-row {
  margin-bottom: 20px;
  &:last-child {
    margin-bottom: 0;
  }
}
.el-col {
  border-radius: 4px;
}
</style>
