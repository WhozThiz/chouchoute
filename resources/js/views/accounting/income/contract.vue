<template>
  <div class="app-container">

    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('table.add') }}
      </el-button>
    </div>
    <el-table v-loading="loading" :data="list" stripe style="width: 100%">
      <el-table-column align="left" :label="$t('general.date')" prop="paid_at" />
      <el-table-column align="left" :label="$t('general.name')" prop="lead.name" />
      <el-table-column align="left" :label="$t('general.value')" prop="amount" />
      <el-table-column align="left" :label="$t('general.category')" prop="category.name" />
      <el-table-column align="center" label="Actions">
        <template slot-scope="scope">
          <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEditForm(scope.row.id);">
            {{ $t('table.edit') }}
          </el-button>
          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
            {{ $t('table.delete') }}
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog :title="formTitle" :visible.sync="contractFormVisible" :before-close="handleClose">
      <el-form ref="revenueForm" :model="currentContract" label-position="left" label-width="150px" style="max-width: 100%">
        <el-form-item :label="$t('general.date')" prop="paid_at">
          <el-date-picker v-model="currentContract.paid_at" type="date" value-format="yyyy-MM-dd" clear-icon="el-icon-circle-close" placeholder="Pick a day" />
        </el-form-item>
        <el-form-item :label="$t('accounting.account')" prop="account_id">
          <el-select v-model="currentContract.account_id" :placeholder="'Select ' + $t('accounting.account')">
            <el-option v-for="item in accounts" :key="item.id" :label="item.name" :value="item.id">
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
          <el-select v-model="currentContract.category_id" :placeholder="'Select ' + $t('general.category')">
            <el-option v-for="item in operatings" :key="item.id" :label="item.name" :value="item.id">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
            <el-option v-for="item in non_operatings" :key="item.id" :label="item.name" :value="item.id">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('table.description')" prop="description">
          <el-input v-model="currentContract.description" type="textarea" :placeholder="$t('table.description')" />
        </el-form-item>
        <el-form-item :label="$t('general.reference')" prop="reference">
          <el-input v-model="currentContract.reference" :placeholder="$t('general.reference')"><template slot="prepend"><svg-icon icon-class="reference" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.currency')" prop="currency_id">
          <el-select v-model="currency" :placeholder="'Select ' + $t('accounting.currency')">
            <el-option v-for="item in currencies" :key="item.id" :label="item.name" :value="{ code: item.id, description: item.description }">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('general.value')" prop="amount">
          <el-input v-model="currentContract.amount" v-money="money" placeholder="Enter Amount">
            <template slot="prepend">{{ currency.description }}</template>
            <template slot="append"><svg-icon icon-class="moneyncoin" /></template>
          </el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.paymentmethod')" prop="payment_method">
          <el-select v-model="currentContract.payment_method" :placeholder="'Select ' + $t('accounting.paymentmethod')">
            <el-option v-for="item in payment_methods" :key="item.id" :label="item.name" :value="item.id">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('accounting.recurring')" prop="recurring">
          <el-select v-model="currentContract.recurrence" :placeholder="'Select ' + $t('accounting.recurring')" @change="getRecurringForm()">
            <el-option v-for="item in recurrence" :key="item.id" :label="item.name" :value="item.name">
              <span style="float: left">{{ item.name }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item v-if="isRecurrence" prop="times">
          <el-input v-model="currentContract.times" :placeholder="$t('accounting.times')" />
        </el-form-item>
        <el-form-item v-else-if="isRecurrenceCustom" prop="custom">
          <el-col :span="5">
            <el-input v-model="currentContract.recurring" :placeholder="$t('accounting.every')" />
          </el-col>
          <el-col class="line" :span="1" />
          <el-col :span="12">
            <el-select v-model="currentContract.period" :placeholder="'Select ' + $t('accounting.period')" @change="getRecurringForm()">
              <el-option v-for="item in period" :key="item.name" :label="item.name" :value="item.name">
                <span style="float: left">{{ item.name }}</span>
              </el-option>
            </el-select>
          </el-col>
          <el-col class="line" :span="1" />
          <el-col :span="5">
            <el-input v-model="currentContract.times" :placeholder="$t('accounting.times')" />
          </el-col>
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
import { CurrencyDirective } from 'vue-currency-input';

const accountResource = new Resource('accounts');
const categoryResource = new CategoryResource();
const contractResource = new Resource('contracts');
const leadResource = new Resource('leads');

export default {
  name: 'Income',
  directives: {
    mask,
    money: VMoney,
    currency: CurrencyDirective,
  },
  props: {
  },
  data() {
    return {
      contractFormVisible: false,
      isRecurrence: false,
      isRecurrenceCustom: false,
      formTitle: '',
      category: [],
      currency: '',
      currentContract: {},
      accounts: [],
      currencies: [],
      leads: [],
      list: [],
      non_operatings: [],
      operatings: [],
      payment_methods: [],
      period: [{ name: 'Days' }, { name: 'Weeks' }, { name: 'Months' }, { name: 'Years' }],
      recurrence: [],
      money: {
        decimal: '.',
        thousands: '',
        prefix: '',
        suffix: '',
        precision: 2,
        masked: false,
      },
    };
  },
  created() {
    this.getList();
    this.getAccounts();
    this.getCategories();
    this.getLeads();
  },
  methods: {

    async getList() {
      this.loading = true;
      const { data } = await contractResource.list();
      this.list = data;
      this.loading = false;
    },

    async getAccounts() {
      const { data } = await accountResource.list({});
      this.accounts = data;
    },

    async getCategories() {
      const { data } = await categoryResource.getRevenueCategories({});
      this.currencies = data.currencies;
      this.operatings = data.operatings;
      this.non_operatings = data.non_operatings;
      this.payment_methods = data.payment_methods;
      this.recurrence = data.recurrence;
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
      if (this.currentContract.id !== undefined) {
        contractResource.update(this.currentContract.id, this.currentContract).then(response => {
          this.$message({
            type: 'success',
            message: this.$t('general.hasbeenupdatedsucessfully'),
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.contractFormVisible = false;
        });
      } else {
        this.currentContract.currency_code = this.currency.code;
        contractResource
          .store(this.currentContract)
          .then(response => {
            this.$message({
              message: this.$t('general.hasbeenupdatedsucessfully'),
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentContract = {
              account_id: '',
              paid_at: '',
              amount: '',
              currency_code: '',
              currency_rate: '',
              lead_id: '',
              description: '',
              category_id: '',
              payment_method: '',
              reference: '',
              attachment: '',
            };
            this.contractFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },

    getRecurringForm() {
      if (this.currentContract.recurrence === 'Recorrência Personalizado') {
        this.isRecurrence = false;
        this.isRecurrenceCustom = true;
      } else if (this.currentContract.recurrence === 'Sem Recorrência') {
        this.isRecurrence = false;
        this.isRecurrenceCustom = false;
      } else {
        this.isRecurrence = true;
        this.isRecurrenceCustom = false;
      }
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
  .el-select .el-input {
    width: 110px;
  }
  .input-with-select .el-input-group__prepend {
    background-color: #fff;
  }
</style>
