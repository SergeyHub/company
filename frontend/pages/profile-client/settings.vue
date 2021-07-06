<template>
  <div class="admin__wrap">
    <div class="container">
      <h1>{{ $t('settings.title') }}</h1>

      <div class="row admin__profile">

        <div class="col-6 col-md-6 col-xs-12">
          <div class="admin__profile-item">
            <label class="input-lable" for="email">{{ $t('settings.email') }}:</label>
            <div class="admin__profile-input">
              <text-input
                id="email"
                v-model="form.email"
                disabled
                name="email"
              />
              <div class="invalid-feedback">
                {{ errors.first('email') }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-12">
        </div>
        <div class="col-3 col-md-3 col-xs-12 mb-20">
          <div class="admin__profile-item">
            <label
              :title="$t('settings.password_tooltip')"
              class="input-lable"
              for="new_password"
            >{{ $t('settings.new_password') }}</label>
            <div class="admin__profile-input">
              <text-input
                name="new_password"
                type="new_password"
                v-model="form.password"
                v-validate="'min:8|max:16'"
              />
              <div class="invalid-feedback">
                {{ errors.first('new_password') }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-xs-12">
          <button class="btn btn-border" @click="sendForm">{{ $t('profile.save') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!--

      <div class="row" style="position: relative">
    <div class="col-md-12 mb-3">
      <div class="Typography_h2">{{ $t('settings.title') }}</div>
    </div>
    <div class="col-md-6">
      <b-card>
        <b-form-group
          label-cols-sm="3"
          :label="$t('settings.email')"
          label-align-sm="right"
          label-for="name"
          label-size="sm"
        >
                <b-form-input
                  id="email"
                  v-model="form.email"
                  disabled
                  aria-describedby="input-email-live-feedback"
                  name="email"
                  size="sm">
                </b-form-input>
        </b-form-group>
      </b-card>
    </div>

    <div class="col-md-6 mt-3 mt-md-0">
      <b-card>
        <b-form-group
          label-cols-sm="4"
          :label="$t('settings.new_password')"
          label-align-sm="right"
          label-for="password"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-row>
              <b-col cols="10" class="input_with_tooltip">
                <b-form-input
                  id="password"
                  type="password"
                  v-model="form.password"
                  :state="validateState('password')"
                  v-validate="{ required: true, min: 6, max: 20 }"
                  aria-describedby="input-password-live-feedback"
                  name="password"
                  size="sm">
                </b-form-input>
                <b-form-invalid-feedback id="input-password-live-feedback">
                  {{ errors.first('password') }}
                </b-form-invalid-feedback>
              </b-col>
              <b-col cols="2" class="question_block">
                <i class="far fa-question-circle" v-b-tooltip.hover :title="$t('settings.password_tooltip')"></i>
              </b-col>
            </b-row>
          </div>
        </b-form-group>

      </b-card>
    </div>

    <div class="col-md-12 mt-3">
      <b-button variant="primary" @click="sendForm">{{ $t('profile.save') }}</b-button>
    </div>
  </div>-->
</template>

<script>
import TextInput from '~/components/TextInput'
import CheckboxInput from '~/components/CheckboxInput'
import { mapGetters } from 'vuex'
import { Message } from 'element-ui'

export default {
  layout: 'profile',
  middleware: 'is_client',
  components: {
    TextInput,
    CheckboxInput
  },
  computed: {
    ...mapGetters('auth', ['loggedUser']),
  },

  head() {
    return {
      title: this.$t('settings.title')
    }
  },

  data() {
    return {
      form: {},
    }
  },

  mounted() {
    this.form = _.clone(this.loggedUser);
  },

  methods: {
    validateState(ref) {
      if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
        return !this.errors.has(ref)
      }
      return null
    },

    sendForm() {
      this.$validator.validateAll().then(result => {
        if(!result)
          return;

        this.$store.dispatch('auth/saveUser', this.form)
          .then(() => {
            Message.success(this.$t('settings.success_update'));
            this.form.password = ''
          })
      });
    }
  }
}
</script>
