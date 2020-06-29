<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('table.add') }}
      </el-button>
    </div>

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
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="$t('accounting.openbalance')" prop="value">
          <el-input v-model.lazy="currentAccount.openbalance" v-money="money" placeholder="Enter Amount"><template slot="prepend"><svg-icon icon-class="moneyncoin" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.bank') + ' ' + $t('general.name')" prop="bankname">
          <el-input v-model="currentAccount.bankname" :placeholder="$t('accounting.bank') + ' ' + $t('general.name')"><template slot="prepend"><svg-icon icon-class="reference" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.bank') + ' ' + $t('general.phone')" prop="bankphone">
          <el-input v-model="currentAccount.bankphone" :placeholder="$t('general.phone')"><template slot="prepend"><svg-icon icon-class="phone" /></template></el-input>
        </el-form-item>
        <el-form-item :label="$t('accounting.bank') + ' ' + $t('general.address')" prop="bankaddress">
          <el-input v-model="currentAccount.bankaddress" type="textarea" :placeholder="$t('general.address')" />
        </el-form-item>
        <el-form-item :label="$t('general.default') + ' ' + $t('accounting.account')" prop="default">
          <el-switch v-model="currentAccount.default" active-color="#13ce66" inactive-color="#ff4949" active-icon-class="el-icon-circle-check" inactive-icon-class="el-icon-circle-close" :active-value="1" :inactive-value="0" />
        </el-form-item>
        <el-form-item :label="$t('general.enabled')" prop="status">
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
import { VMoney } from 'v-money';

const categoryResource = new Resource('category');

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
      currentAccount: [],
      currencies: [],
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
    this.getCurrencyCategories();
  },

  methods: {

    async getCurrencyCategories() {
      const { data } = await categoryResource.getCurrencyCategories({});
      this.currencies = data.currencies;
    },

    handleCreateForm() {
      this.accountFormVisible = true;
      this.formTitle = this.$t('general.new') + ' ' + this.$t('accounting.account');
      this.currentRevenue = {
      };
    },

  },
};
</script>

<style scoped>
</style>
