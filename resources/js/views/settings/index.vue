<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>{{ $t('route.settings') }}</span>
        </div>
        <div style="margin-bottom:50px;">
          <el-table :data="settings" style="width: 100%">
            <el-table-column fixed prop="key" label="Key" width="150" />
            <el-table-column prop="value" label="Value" />
            <el-table-column fixed="right" label="Operations" width="120">
              <template slot-scope="">
                <el-button type="text" size="small">{{ $t('general.edit') }}</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </el-card>
    </el-row>
  </div>
</template>

<script>
import Resource from '@/api/resource';

const settingResource = new Resource('settings');
export default {
  name: 'Settings',
  props: {
  },
  data() {
    return {
      listLoading: true,
      settings: [],
    };
  },
  created() {
    this.getSettings();
  },
  methods: {
    async getSettings() {
      this.listLoading = true;
      const { data } = await settingResource.list({});
      this.settings = data;
      this.listLoading = false;
    },
  },
};
</script>

<style scoped>
.mixin-components-container {
  background-color: #f0f2f5;
  padding: 30px;
  min-height: calc(100vh - 84px);
}
</style>
