<template>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">
          <span class="login100-form-title-1">
            {{ $t('login.title') }}
          </span>
          <span class="login100-form-title-2">{{ $t('login.description') }}</span>
          <lang-select class="set-language" />
        </div>
        <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login100-form validate-form" auto-complete="on" label-position="left">
          <el-form-item prop="email" class="wrap-input100 validate-input m-b-26">
            <span class="label-input100">{{ $t('login.email') }}</span>
            <el-input
              v-model="loginForm.email"
              name="email"
              type="text"
              auto-complete="on"
              :placeholder="$t('login.email')"
            />
          </el-form-item>
          <el-form-item prop="password" class="wrap-input100 validate-input m-b-18">
            <span class="label-input100">{{ $t('login.password') }}</span>
            <el-input
              v-model="loginForm.password"
              name="password"
              :type="pwdType"
              auto-complete="on"
              :placeholder="$t('login.enteruserpassword')"
              prefix-icon="el-icon-key"
              @keyup.enter.native="handleLogin"
            >
              <el-button slot="append" icon="el-icon-view" @click="showPwd" />
            </el-input>
          </el-form-item>
          <el-form-item>
            <el-button :loading="loading" type="primary" style="width:100%;" @click.native.prevent="handleLogin">
              {{ $t('login.logIn') }}
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
import LangSelect from '@/components/LangSelect';
import { validEmail } from '@/utils/validate';
import { csrf } from '@/api/auth';

export default {
  name: 'Login',
  components: { LangSelect },
  data() {
    const validateEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error('Please enter the correct email'));
      } else {
        callback();
      }
    };
    const validatePass = (rule, value, callback) => {
      if (value.length < 4) {
        callback(new Error('Password cannot be less than 4 digits'));
      } else {
        callback();
      }
    };
    return {
      loginForm: {
        email: '',
        password: '',
      },
      loginRules: {
        email: [{ required: true, trigger: 'blur', validator: validateEmail }],
        password: [{ required: true, trigger: 'blur', validator: validatePass }],
      },
      loading: false,
      pwdType: 'password',
      redirect: undefined,
      otherQuery: {},
    };
  },
  watch: {
    $route: {
      handler: function(route) {
        const query = route.query;
        if (query) {
          this.redirect = query.redirect;
          this.otherQuery = this.getOtherQuery(query);
        }
      },
      immediate: true,
    },
  },
  methods: {
    showPwd() {
      if (this.pwdType === 'password') {
        this.pwdType = '';
      } else {
        this.pwdType = 'password';
      }
    },
    handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true;
          csrf().then(() => {
            this.$store.dispatch('user/login', this.loginForm)
              .then(() => {
                this.$router.push({ path: this.redirect || '/', query: this.otherQuery }, onAbort => {});
                this.loading = false;
              })
              .catch(() => {
                this.loading = false;
              });
          });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== 'redirect') {
          acc[cur] = query[cur];
        }
        return acc;
      }, {});
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss">
@import 'css/main.css';
@import 'css/util.css';
</style>
