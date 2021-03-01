<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('table.add') }}
      </el-button>
    </div>

    <el-table v-loading="loading" :data="list" stripe style="width: 100%">

      <el-table-column align="left" :label="$t('general.name')" prop="name" />
      <el-table-column align="left" label="Number" prop="number" />
      <el-table-column align="left" label="Opening Balance" prop="opening_balance" />
      <el-table-column align="left" label="Enabled" prop="enabled" />
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

    <el-dialog :title="formTitle" :visible.sync="accountFormVisible" :before-close="handleClose">
      <el-form ref="accountForm" :model="currentAccount" label-position="left" label-width="150px" style="max-width: 100%">
        <el-form-item :label="$t('general.name')" prop="name">
          <el-input v-model="currentAccount.name" :placeholder="$t('general.name')"><template slot="prepend"><svg-icon icon-class="rename" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('general.number')" prop="number">
          <el-input v-model="currentAccount.number" :placeholder="$t('general.number')"><template slot="prepend"><svg-icon icon-class="number" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.currency')" prop="currency">
          <el-select v-model="currentAccount.currency" :placeholder="'Select ' + $t('accounting.currency')">
            <el-option v-for="item in currencies" :key="item.id" :label="item.name" :value="item.name">
              <span style="float: left">{{ item.name }}</span>
              <span style="float: right">{{ item.description }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('accounting.openbalance')" prop="opening_balance">
          <el-input v-model.lazy="currentAccount.opening_balance" v-money="money" placeholder="Enter Amount"><template slot="prepend"><svg-icon icon-class="moneyncoin" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.bank') + ' ' + $t('general.name')" prop="bank_name">
          <el-input v-model="currentAccount.bank_name" :placeholder="$t('accounting.bank') + ' ' + $t('general.name')"><template slot="prepend"><svg-icon icon-class="reference" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.bank') + ' ' + $t('general.phone')" prop="bank_phone">
          <el-input v-model="currentAccount.bank_phone" :placeholder="$t('general.phone')"><template slot="prepend"><svg-icon icon-class="phone" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.bank') + ' ' + $t('general.address')" prop="bank_address">
          <el-input v-model="currentAccount.bank_address" type="textarea" :placeholder="$t('general.address')" />
        </el-form-item>
        <el-form-item :label="$t('general.default') + ' ' + $t('accounting.account')" prop="default">
          <el-switch v-model="currentAccount.default" active-color="#13ce66" inactive-color="#ff4949" active-icon-class="el-icon-circle-check" inactive-icon-class="el-icon-circle-close" :active-value="1" :inactive-value="0" />
        </el-form-item>
        <el-form-item :label="$t('general.enabled')" prop="enabled">
          <el-switch v-model="currentAccount.enabled" active-color="#13ce66" inactive-color="#ff4949" active-icon-class="el-icon-circle-check" inactive-icon-class="el-icon-circle-close" :active-value="1" :inactive-value="0" />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="accountFormVisible = false">
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
import { VMoney } from 'v-money';

const accountResource = new Resource('accounts');
const categoryResource = new CategoryResource();

export default {
  name: 'Account',
  directives: {
    money: VMoney,
  },
  props: {
  },
  data() {
    return {
      accountFormVisible: false,
      formTitle: '',
      list: [],
      currentAccount: {},
      currencies: [],
      money: {
        decimal: '.',
        thousands: '.',
        prefix: '',
        suffix: '',
        precision: 2,
        masked: false,
      },
    };
  },

  created() {
    this.getList();
    this.getCurrencyCategories();
  },

  methods: {

    async getList() {
      this.loading = true;
      const { data } = await accountResource.list();
      this.list = data;
      this.loading = false;
    },

    async getCurrencyCategories() {
      const { data } = await categoryResource.getCurrencyCategories({});
      this.currencies = data;
    },

    handleCreateForm() {
      this.accountFormVisible = true;
      this.formTitle = this.$t('general.new') + ' ' + this.$t('accounting.account');
      this.currentAccount = {
        name: '',
        number: '',
        currency: '',
        opening_balance: '',
        bank_name: '',
        bank_phone: '',
        bank_address: '',
        default: 0,
        enabled: 1,
      };
    },

    handleEditForm(id) {
      this.accountFormVisible = true;
      this.formTitle = this.$t('general.edit') + ' ' + this.$t('accounting.account');
      this.currentAccount = this.list.find(account => account.id === id);
    },

    handleSubmit() {
      if (this.currentAccount.id !== undefined) {
        accountResource.update(this.currentAccount.id, this.currentAccount).then(response => {
          this.$message({
            type: 'success',
            message: this.$t('general.hasbeenupdatedsucessfully'),
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.accountFormVisible = false;
        });
      } else {
        accountResource
          .store(this.currentAccount)
          .then(response => {
            this.$message({
              message: this.currentAccount.name + ' ' + this.$t('general.hasbeenupdatedsucessfully'),
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentAccount = {
              name: '',
              number: '',
              currency: '',
              opening_balance: '',
              bank_name: '',
              bank_phone: '',
              bank_address: '',
              default: 0,
              enabled: 0,
            };
            this.accountFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },

    handleDelete(id, name) {
      this.$confirm('This will permanently delete account ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        accountResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: this.$t('general.deletecompleted'),
          });
          this.getList();
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
</style>
