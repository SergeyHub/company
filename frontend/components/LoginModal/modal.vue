<template>
  <modal v-model="showModify"
         :title="mode!='register' ? $t('auth.'+mode) : ''"
         :back-button="mode=='register'"
         @backButtonClick="backButtonClick"
         :size="mode=='register' ? 'md' : 'sm'">
      <template v-if="mode=='login'">
        <b-form @submit.prevent="submitLoginForm" v-loading="loading" class="login-form">
          <div v-if="userForConfirmId" class="text-center mb-3">
            {{$t('auth.resend_in_login_text')}}<br/>
            <a href="#" @click.prevent="emailVerifySend" class="resend-email-login-link">{{$t('auth.resend_link_in_login')}}</a>
          </div>
          <b-form-group
            id="input-group-1"
            :label="$t('auth.email')"
            label-for="input-1"
          >
            <b-form-input
              id="input-1"
              v-model="loginForm.email"
              type="email"
              required
              :placeholder="$t('auth.enter_email')"
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="input-group-2"
            :label="$t('auth.your_password')"
            label-for="input-2"
          >
            <b-form-input
              id="input-2"
              v-model="loginForm.password"
              minlength="6"
              type="password"
              required
              :placeholder="$t('auth.enter_password')"
            ></b-form-input>
          </b-form-group>

          <recaptcha
            @error="onError"
            v-if="captchaDisplay"
          />

          <b-button type="submit" variant="primary w-100">
            {{ $t('auth.login_btn_text') }}
          </b-button>
        </b-form>

        <template slot="footer">
          <span>{{ $t('auth.not_a_member') }}</span>
          <a href="#" @click.prevent="mode='register'">
            <span>{{ $t('auth.register_for_free') }}</span>
          </a>
        </template>
      </template>

      <template v-if="mode=='register'">
        <b-form @submit.prevent="submitRegisterForm" v-loading="loading" class="register-form">
            <span class="text-center pl-4 pr-4 register-last-text mb-2">Register</span>
            <b-form-group
              id="input-group-1"
              :label="$t('auth.email')"
              label-for="input-1"
            >
              <b-form-input
                id="input-1"
                v-model="loginForm.email"
                type="email"
                required
                :placeholder="$t('auth.enter_email')"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              id="input-group-3"
              :label="$t('auth.reenter_email')"
              label-for="input-3"
            >
              <b-form-input
                id="input-3"
                v-model="loginForm.email"
                type="email"
                required
                :placeholder="$t('auth.reenter_email_placeholder')"
              ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" :label="$t('auth.your_password')" label-for="input-2">
              <b-form-input
                id="input-2"
                v-model="loginForm.password"
                type="password"
                required
                :state="validateState('password')"
                v-validate="{ required: true, min:6 }"
                aria-describedby="input-1-live-feedback"
                minlength="6"
                :placeholder="$t('auth.enter_password')"
                name="password"
              ></b-form-input>
              <b-form-invalid-feedback id="input-1-live-feedback">
                {{ errors.first('password') }}
              </b-form-invalid-feedback>
            </b-form-group>

            <recaptcha
              @error="onError"
              v-if="captchaDisplay"
            />

            <b-button type="submit" variant="primary w-100">
              {{ $t('auth.register_btn_text') }}
            </b-button>
        </b-form>

        <template slot="footer">
          <span>{{ $t('auth.already_a_member') }}</span>
          <a href="#" @click.prevent="mode='login'">
            <span>{{ $t('auth.login_btn_text') }}</span>
          </a>
          <div class="TermsAndConditions__terms">
            <span>
              {{ $t('auth.by_creating') }}
              <a :href="localePath('terms')" target="_blank">
                <span>{{ $t('auth.terms_of_use') }}</span>
              </a> {{ $t('auth.and') }}
              <a :href="localePath('privacy')" target="_blank">
                <span>{{ $t('auth.privacy_policy') }}</span>
              </a>
            </span>
          </div>
        </template>
      </template>
  </modal>
</template>

<script>
  import { Message } from 'element-ui'
  import Modal from '~/components/Modal'
  import LoginModal from './index.js'
  import {mapGetters} from "vuex";

  export default {
    props: {
      value: {
        type: Boolean,
        default: () => false
      }
    },
    components: {
      Modal
    },
    computed: {
      options() {
        return [
          { text: this.$t('auth.agency'), value: 'agency' },
          { text: this.$t('auth.model'), value: 'girl' },
        ];
      },
      ...mapGetters('auth', ['userForConfirmId']),
    },
    data() {
      return {
        loading: false,
        captchaDisplay: true,
        showModify: this.value,
        mode: 'login',
        typeUser: '',
        typeEscort: '',
        loginForm: {
          email: null,
          email_repeat: null,
          password: null,
          type: '',
          girl_type: '',
        },
        afterRegistration: null,
        afterLogin: null,
      }
    },
    watch: {
      showModify(newVal, prevVal) {
        this.$emit('input', newVal)
      },
      value(newVal, prevVal) {
        this.showModify = newVal
      },
    },
    methods: {
      resetCaptcha() {
        this.captchaDisplay = false;
        this.$nextTick(() => {
          this.captchaDisplay = true;
        })
      },
      open(params={}) {
        this.typeUser = '';
        this.typeEscort = '';
        this.loginForm.type = '';
        this.loginForm.girl_type = '';
        this.showModify = true;
        if(params.mode) {
          this.mode = params.mode;
        } else {
          this.mode = "login";
        }
        if(params.afterRegistration) {
          this.afterRegistration = params.afterRegistration;
        } else {
          this.afterRegistration = null;
        }
        if(params.afterLogin) {
          this.afterLogin = params.afterLogin;
        } else {
          this.afterLogin = null;
        }
      },
      openConfirmEmailModal() {
        this.$refs.confirmEmailModal.open();
      },
      closed() {
        this.mode = 'login'
      },
      backButtonClick() {
        if (this.mode === 'register')
          this.mode = 'login'
      },
      emailVerifySend() {
        this.$axios.post('/auth/verify/send/' + this.userForConfirmId)
          .then((response) => {
            if(response.data.success) {
              Message.success(this.$t('verify.email_sended'))
            } else {
              Message.error(this.$t('verify.email_send_error'))
            }
          })
      },
      async submitLoginForm() {
        this.loading = true;
        let token;
        try {
          token = await this.$recaptcha.getResponse();
        } catch (error) {
          this.loading = false;
          Message.error(this.$t('auth.captcha_error'));
          return;
        }
        await this.$store.dispatch('auth/login', Object.assign({recaptcha: token}, this.loginForm))
          .then((response) => {
            this.loading = false;
            this.showModify = false;
            if (this.userForConfirmId) {
              this.$store.dispatch('auth/setUserForConfirmId', null)
            }
            if(typeof this.afterLogin === 'function') {
              this.afterLogin();
            } else {
              if(this.loginForm.type === 'girl') {
                this.$router.push(this.localePath('profile'));
              } else if (this.loginForm.type === 'client') {
                this.$router.push(this.localePath('profile-client'));
              } else {
                this.$router.push(this.localePath('profile-agency'));
              }
            }
          })
          .catch((error) => {
            this.loading = false;
            this.resetCaptcha();
            if(error.response && error.response.data.error) {
              if (error.response.data.error == 'email_unverified' && error.response.data.user_id) {
                this.$store.dispatch('auth/setUserForConfirmId', error.response.data.user_id)
                Message.error(this.$t('auth.email_unverified'))
              } else {
                Message.error(this.$t('auth.incorrect_credentials'))
              }
            }
          })
      },
      async submitRegisterForm() {
        this.loading = true;
        let token;
        try {
          token = await this.$recaptcha.getResponse();
        } catch (error) {
          this.loading = false;
          Message.error(this.$t('auth.captcha_error'));
          return;
        }
        await this.$store.dispatch('auth/register', Object.assign({recaptcha: token}, this.loginForm))
          .then((response) => {
            this.loading = false;
            this.showModify = false;
            this.$ga.event('register', this.loginForm.type);
            if(typeof this.afterRegistration === 'function') {
              this.afterRegistration();
            } else {
              this.$emailConfirmModal.open();
            }
          })
          .catch((error) => {
            this.resetCaptcha();
            this.loading = false
          })
      },
      validateState(ref) {
        if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
          return !this.errors.has(ref)
        }
        return null
      },
      onError (error) {
        Message.error(this.$t('auth.captcha_error'))
      }
    },
    beforeMount() {
      // here we need to listen for emited events
      // we declared those events inside our plugin
      LoginModal.EventBus.$on('open', (params) => {
        this.open(params)
      })
    }
  }
</script>

<style>
  .TermsAndConditions__terms {
    margin-top: 40px;
    font-size: 14px;
    line-height: 20px;
    text-align: center;
  }
  .back {
    cursor: pointer;
  }
  .register-form .col-form-label{
    font-size: 25px;
  }
  .register-last-text {
    display: block;
    font-size: 25px;
  }
  .step-radio-list {
    margin: 0;
    padding: 0;
    list-style: none;
  }
  .register-radio {
    display: grid;
    border-radius: 0;
    grid-template-columns: repeat(2, 1fr);
    grid-auto-rows: 1fr;
    grid-column-gap: 10px;
    grid-row-gap: 10px;
  }
  .register-radio>div {
    border: 1px solid #425486;
    display: flex;
    width: 100%;
    margin: 0;
    padding: 0;
  }
  .register-radio .custom-control-label::before {
    top: calc(50% - 9px);
    left: 6px;
  }
  .register-radio .custom-control-label {
    width: 100%;
    padding: 1em;
    padding-left: 2rem;
  }
  .resend-email-login-link {
    color: #FA6B6B;
    display: block;
  }
  .resend-email-login-link:hover {
    background: #f1f2f6;
    text-decoration: underline !important;
  }
  @media only screen and (max-width: 600px) {
    .register-radio {
      grid-template-columns: repeat(1, 1fr);
    }
  }
</style>
