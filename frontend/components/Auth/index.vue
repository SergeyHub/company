<template>
  <no-ssr>
    <div>
      <div class="page__auth-title">
        {{ $t(`auth.${mode}`) }}
      </div>

      <template v-if="mode=='login'">
        <div class="page__auth-form login">
          <form @submit.prevent="submitLoginForm">
            <div class="page__auth-form-field">
              <div class="page__auth-form-field-item page__auth-form-field-item-error">
                <label>{{ $t('auth.email') }}</label>
                <input
                  type="text"
                  class="error"
                  :placeholder="$t('auth.enter_email')"
                  v-model="loginForm.email"
                  required
                >
              </div>
              <div class="page__auth-form-field-item">
                <label>{{ $t('auth.your_password') }}</label>
                <input
                  type="password"
                  :placeholder="$t('auth.enter_password')"
                  v-model="loginForm.password"
                  minlength="6"
                  required
                >
              </div>
              <!--<div class="page__auth-form-field-item">
                <a href="#" class="page__auth-repass">Забыли Ваш пароль?</a>
              </div>-->
              <div class="page__auth-form-field-item" v-if="captchaDisplay">
                <recaptcha
                  @error="onError"
                />
              </div>
              <!--
              <div class="page__auth-form-field-item">
                <a href="#" class="page__auth-repass">{{ $t('auth.forgot_password') }}</a>
              </div>-->
              <div class="page__auth-form-field-item btn-width">
                <AppButton mode="custom" class="btn btn-accent btn-signin">{{ $t('auth.login') }}</AppButton>
                <AppButton mode="custom" class="btn btn-nofocus btn-signup" @click.prevent.native="openRegister">
                  {{ $t('auth.register') }}
                </AppButton>
              </div>

              <div class="page__auth-form-field-item text-center">
                <router-link
                  v-if="previousPage == null"
                  :to="virginsPage"
                  :title="$t('titles.home')"
                  class="btn btn-text btn-backpage"
                >
                  {{ $t('titles.home') }}
                </router-link>
                <router-link
                  v-else
                  :to="localePath(previousPage)"
                  :title="$t('auth.back')"
                  class="btn btn-text btn-backpage"
                >
                  {{ $t('auth.back') }}
                </router-link>

                <div class="text-center">
                  <router-link :to="'password/reset'">{{ $t('auth.reset_password') }}</router-link>
                </div>
              </div>
            </div>
          </form>
        </div>
      </template>
      <template v-if="mode == 'register'">
        <div class="page__auth-form singup">
          <form @submit.prevent="submitRegisterForm">
            <template v-if="step === 1">
              <div id="box-1" class="page__auth-form-box">
                <div class="page__auth-title">
                  {{ $t('auth.you_are') }}
                </div>
                <div class="page__auth-form-box-wrap">
                  <div
                    class="page__auth-form-box-item"
                    @click="typeUser = 'girls'"
                    :class="{ active: typeUser == 'girls' }"
                  >
                    <div class="page__auth-form-box-item-title">
                      <span></span>
                      {{ $t('auth.escort') }}
                    </div>
                    <div class="page__auth-form-box-item-ul">
                      <div class="page__auth-form-box-item-li">{{ $t('auth.largest_network') }}</div>
                      <div class="page__auth-form-box-item-li">{{ $t('auth.easy_upload_book') }}</div>
                      <div class="page__auth-form-box-item-li">{{ $t('auth.targeted_users') }}</div>
                      <div class="page__auth-form-box-item-li">{{ $t('auth.free_registration') }}</div>
                    </div>
                  </div>
                  <div
                    class="page__auth-form-box-item"
                    @click="typeUser = 'client'"
                    :class="{ active: typeUser == 'client' }"
                  >
                    <div class="page__auth-form-box-item-title">
                      <span></span>
                      {{ $t('auth.client') }}
                    </div>
                    <div class="page__auth-form-box-item-ul">
                      <div class="page__auth-form-box-item-li">{{ $t('auth.a_lot_of_profiles') }}</div>
                      <div class="page__auth-form-box-item-li">{{ $t('auth.easy_to_search_male') }}</div>
                      <div class="page__auth-form-box-item-li">{{ $t('auth.profiles_from_all_world') }}</div>
                      <div class="page__auth-form-box-item-li">{{ $t('auth.free_registration') }}</div>
                    </div>
                  </div>
                </div>
                <div
                  class="page__auth-form-next"
                >
                  <div
                    class="btn btn-mess"
                    @click="nextStep"
                    v-if="step != 2"
                    :class="{'disabled' : !nextStepActive}"
                  >{{ $t('auth.next') }}</div>
                </div>
              </div>
            </template>
            <template v-if="step === 2">
              <div id="box-4" class="page__auth-form-box">
                <div class="page__auth-title">
                  {{ $t('account_type.you_will_register_as') }} {{ $t(`account_type.${loginForm.type}`) }}
                </div>
                <div class="page__auth-form-field">
                  <div class="page__auth-form-field-item">
                    <label>{{ $t('auth.email') }}</label>
                    <input
                      type="text"
                      :placeholder="$t('auth.email')"
                      v-model="loginForm.email"
                    >
                  </div>
                  <div class="page__auth-form-field-item">
                    <label>{{ $t('auth.your_password') }}</label>
                    <input
                      type="password"
                      :placeholder="$t('auth.enter_password')"
                      v-model="loginForm.password"
                    >
                  </div>

                  <div class="page__auth-form-field-item">
                    <recaptcha
                      @error="onError"
                      v-if="captchaDisplay"
                    />
                  </div>

                  <div class="page__auth-form-field-item">
                    <AppButton
                      mode="custom"
                      class="btn btn-accent btn-one"
                    >{{ $t('auth.register') }}</AppButton>
                  </div>
                  <div class="page__auth-form-field-item go-login">
                    <span>{{ $t('auth.already_a_member') }}</span>
                    <router-link :to="localePath('login')">{{ $t('auth.login_btn_text') }}</router-link>
                  </div>
                  <div class="page__auth-form-field-item bottom">
                    <div class="privacy">
                      {{ $t('auth.by_creating') }} <a href="#">{{ $t('auth.terms_of_use') }}</a><br> {{ $t('auth.and') }} <a href="#">{{ $t('auth.privacy_policy') }}</a>
                    </div>
                  </div>
                </div>
              </div>
            </template>
            <div class="page__auth-form-next">
              <router-link
                v-if="previousPage == null"
                :to="virginsPage"
                :title="$t('titles.home')"
                class="btn btn-text btn-backpage"
              >
                {{ $t('titles.home') }}
              </router-link>
              <router-link
                v-else
                :to="localePath(previousPage)"
                :title="$t('auth.back')"
                class="btn btn-text btn-backpage"
              >
                {{ $t('auth.back') }}
              </router-link>
            </div>
          </form>
        </div>
      </template>
      <template v-if="mode === 'email_confirmation'">
        <div id="box-5" class="page__auth-form-box">
          <div class="page__auth-title">
            {{ $t('auth.check_email_text') }}
          </div>
          <div class="page__auth-form-field">
            <AppButton
              mode="accent"
              @click.native="sendEmail"
            >{{ $t('profile_nav.resend_verify_email') }}</AppButton>
            <!--<div class="page__auth-form-field-item go-login">
              <span>{{ $t('auth.already_a_member') }}</span>
              <router-link :to="'/login'">{{ $t('auth.login') }}</router-link>
              <a href='#' @click.prevent="$router.go(-1)">{{ $t('titles.home') }}</a>
            </div>-->
          </div>
        </div>
      </template>
      <template v-if="mode == 'reset_password_request'">
        <div class="page__auth-form-box">
          <form @submit.prevent="resetPasswordRequest">
            <div class="page__auth-form-field">
              <div class="page__auth-form-field-item">
                <label>{{ $t('auth.put_your_email') }}</label>
                <input
                  type="email"
                  :placeholder="$t('auth.put_your_email')"
                  v-model="loginForm.email"
                  required
                >
              </div>
              <div class="page__auth-form-field-item">
                <AppButton
                  :mode="'custom'"
                  class="btn btn-signup"
                >{{ $t('auth.reset') }}</AppButton>
              </div>
            </div>
          </form>
        </div>
      </template>
    </div>
  </no-ssr>
</template>
<script>
import { Message } from 'element-ui'
//import Modal from '~/components/Modal'
//import LoginModal from './index.js'
import AppButton from '~/components/AppButton';
import {mapGetters} from "vuex";

export default {
  props: {
    previousPage: {
      default: '/'
    },
    value: {
      type: Boolean,
      default: () => false
    },
    currentMode: {
      type: String
    }
  },
  components: {
    AppButton
  },
  computed: {
    virginsPage() {
      if(this.$route.params.country) {
        if(this.$route.params.city) {
          return this.localePath({name: 'country-city', params: {country: this.$route.params.country, city: this.$route.params.city}})
        } else {
          return this.localePath({name: 'country', params: {country: this.$route.params.country}})
        }
      }
      return this.localePath('index');
    },
    options() {
      return [
        { text: this.$t('auth.agency'), value: 'agency' },
        { text: this.$t('auth.model'), value: 'girl' },
      ];
    },
    nextStepActive() {
      return this.steps[this.step_cursor + 1] !== undefined;
    },
    prevStepActive() {
      return this.steps[this.step_cursor - 1] !== undefined;
    },
    ...mapGetters('auth', ['userForConfirmId']),
  },
  data() {
    return {
      loading: false,
      captchaDisplay: true,
      showModify: this.value,
      mode: 'login',
      step: 1,
      steps: [1],
      step_cursor: 0,
      typeUser: '',
      typeEscort: '',
      loginForm: {
        email: null,
        //email_repeat: null,
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
    typeUser(newVal, prevVal) {
      if (newVal == 'girls') {
        this.steps = this.steps.slice(0, 1);
        this.loginForm.type = 'girl';
        this.steps.push(2);
      }
      if (newVal == 'client') {
        this.steps = this.steps.slice(0, 1);
        this.loginForm.type = 'client';
        this.steps.push(2);
      }
    },
    /*'loginForm.type': function(newVal, oldVal){
      if (newVal == 'girl') {
        this.steps = this.steps.slice(0, this.step_cursor + 1);
        this.steps.push(3);
      }
    },
    'loginForm.girl_type': function(newVal, oldVal){
      if (newVal != '') {
        this.steps = this.steps.slice(0, this.step_cursor + 1);
        this.steps.push(2);
      }
    }*/
  },
  methods: {
    resetPasswordRequest() {
      this.$store.dispatch('auth/resetPasswordRequest', {email: this.loginForm.email})
        .then((res) => {
          if(res.success) {
            Message.success(this.$t('auth.password_link_sent'))
            this.loginForm.email = ''
          } else {
            Message.error(this.$t('auth.error_occured'))
          }
        })
    },
    openRegister() {
      this.$router.push(this.localePath('register'))
    },
    nextStep() {
      if (this.nextStepActive) {
        this.step = this.steps[this.step_cursor + 1];
        this.step_cursor++;
      }
    },
    resetCaptcha() {
      this.captchaDisplay = false;
      this.$nextTick(() => {
        this.captchaDisplay = true;
      })
    },
    open(params={}) {
      this.step = 1;
      this.steps = [1];
      this.step_cursor = 0;
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
    sendEmail() {
      this.$store.dispatch('auth/emailVerifySend', this.userForConfirmId)
        .then((response) => {
          if(response.data.success) {
            Message.success(this.$t('verify.email_sended'))
          } else {
            Message.error(this.$t('verify.email_send_error'))
          }
        })
    },
    openConfirmEmailModal() {
      this.$refs.confirmEmailModal.open();
    },
    closed() {
      this.mode = 'login'
    },
    backButtonClick() {
      if (this.mode === 'register' && this.step > 1) {
        if (this.prevStepActive) {
          this.step = this.steps[this.step_cursor - 1];
          this.step_cursor--;
        }
      } else {
        if (this.mode === 'register')
          this.mode = 'login'
      }
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
              this.mode = 'email_confirmation'
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
          //this.$router.go(-1)
          this.$ga.event('register', this.loginForm.type);
          if(typeof this.afterRegistration === 'function') {
            this.afterRegistration();
          } else {
            this.mode = 'email_confirmation'
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
    if(this.$props.currentMode) this.mode = this.$props.currentMode
    // here we need to listen for emited events
    // we declared those events inside our plugin
    /*LoginModal.EventBus.$on('open', (params) => {
        this.open(params)
    })*/
  }
}
</script>
