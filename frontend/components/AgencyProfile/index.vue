<template>
  <div class="row" style="position: relative">
    <div class="col-md-6">
      <div class="Typography_h2">
        {{ $t('agency_profile.title') }}
      </div>
    </div>
    <div class="col-md-6 legend mb-3">
      <span class="legendReq">{{ $t('profile.required_fields') }}</span>
      <span>{{ $t('profile.optional_fields') }}</span>
    </div>
    <div class="col-md-6">
      <b-card>
        <b-form-group
          label-cols-sm="5"
          :label="$t('agency_profile.name')"
          label-align-sm="right"
          label-for="name"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-row>
              <b-col cols="12">
                <b-form-input
                  id="name"
                  v-model="form.name"
                  :state="validateState('name')"
                  v-validate="{ required: true, min:2, max: 20 }"
                  :formatter="onlyEnglishAlphabet"
                  lazy-formatter
                  aria-describedby="input-name-live-feedback"
                  name="name"
                  size="sm">
                </b-form-input>
                <b-form-invalid-feedback id="input-name-live-feedback">
                  {{ errors.first('name') }}
                </b-form-invalid-feedback>
              </b-col>
            </b-row>
          </div>
        </b-form-group>
      </b-card>
      <b-card class="mt-3">
        <b-form-group
          label-cols-sm="4"
          :label="$t('agency_profile.phone')"
          label-align-sm="right"
          label-for="phone"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-row>
              <b-col cols="10" class="input_with_tooltip">
                <b-form-input
                  id="phone"
                  :value="form.phone"
                  @input="updatePhone"
                  :state="validateState('phone')"
                  v-validate="{ required: true, min: 6, max: 30 }"
                  aria-describedby="input-phone-live-feedback"
                  name="phone"
                  size="sm">
                </b-form-input>
                <b-form-invalid-feedback id="input-phone-live-feedback">
                  {{ errors.first('phone') }}
                </b-form-invalid-feedback>
              </b-col>
              <b-col cols="2" class="question_block">
                <i class="far fa-question-circle" v-b-tooltip.hover :title="$t('profile.phone_tooltip')"></i>
              </b-col>
            </b-row>
          </div>
        </b-form-group>
        <b-form-group
          label-cols-sm="4"
          :label="$t('profile.contact_methods')"
          label-align-sm="right" class="mb-0"
          label-size="sm"
        >
          <b-form-checkbox-group id="checkbox-group-2" v-model="form.contact_methods" name="flavour-2" class="mt-1">
            <b-form-checkbox :value="option.id" v-for="option in contactMethods" :key="'cont_method_' + option.id">
              {{ option.name }}
            </b-form-checkbox>
          </b-form-checkbox-group>
        </b-form-group>
      </b-card>
      <b-card class="mt-3">
        <select-geographies v-model="form.geographies" />
      </b-card>
      <b-card class="mt-3">
        <select-countries-many v-model="form.countries" />
      </b-card>
      <b-card class="mt-3">
        <b-form-group
          label-cols-sm="4"
          :label="$t('profile.site')"
          label-align-sm="right"
          label-for="name"
          label-size="sm"
        >
          <div class="inputContainer">
            <b-row>
              <b-col cols="10" class="input_with_tooltip">
                <b-form-input
                  id="profile_site"
                  v-model="form.profile_site"
                  :state="validateState('profile_site')"
                  v-validate="{ required: false, min:5 }"
                  :formatter="siteUrl"
                  lazy-formatter
                  aria-describedby="input-profile-site-live-feedback"
                  name="profile_site"
                  size="sm">
                </b-form-input>
                <b-form-invalid-feedback id="input-profile-site-live-feedback">
                  {{ errors.first('profile_site') }}
                </b-form-invalid-feedback>
              </b-col>
              <b-col cols="2" class="question_block">
                <i class="far fa-question-circle" v-b-tooltip.hover :title="$t('profile.site_tooltip')"></i>
              </b-col>
            </b-row>
          </div>
        </b-form-group>
      </b-card>
    </div>
    <div class="col-md-6 mt-3 mt-md-0">
      <b-card class="mb-3">
        <textarea-multilang
          :label="$t('agency_profile.about_agency')"
          :state="validateState('description')"
          v-validate="'multilang:10,1024'"
          name="about"
          :error="errors.first('description')"
          v-model="form.description" />
      </b-card>
      <b-card class="mb-3">
        <avatar-uploader :agency-id="form.id" :avatar="form.avatar"></avatar-uploader>
      </b-card>
    </div>

    <div class="col-md-12 mt-3">
      <AppButton mode="dark" @click="sendForm">{{ $t('profile.save') }}</AppButton>
    </div>
  </div>
</template>

<script>

  import { mapGetters } from 'vuex'
  import { Message } from 'element-ui'
  import SelectLanguages from '~/components/SelectLanguages'
  import SelectGeographies from '~/components/SelectGeographies'
  import SelectCountriesMany from '~/components/SelectCountriesMany'
  import SelectCosts from '~/components/SelectCosts'
  import SelectCountries from '~/components/SelectCountries'
  import TextareaMultilang from '~/components/TextareaMultilang'
  import InputGroup from '~/components/InputGroup'
  //import BButton from "bootstrap-vue/src/components/button/button";
  import AppButton from '~/components/AppButton'
  import AvatarUploader from "~/components/AgencyProfile/AvatarUploader";

  export default {
    props: {
      initData: {
        type: Object,
        default: () => {}
      },
      admin: {
        type: Boolean,
        default: () => false
      }
    },

    components: {
      AppButton,
      SelectLanguages,
      SelectGeographies,
      SelectCosts,

      SelectCountries,
      SelectCountriesMany,
      InputGroup,
      TextareaMultilang
    },

    data() {
      let form =  Object.assign({}, this.initData);
      return {
        loading: true,
        form: form,
      }
    },

    async mounted() {
      if(!this.$store.state.countries.length)
        await this.$store.dispatch('setCountries')
      if(!this.$store.state.options.contactMethods.length)
        await this.$store.dispatch('options/fetchContactMethods')
      this.loading = false;
    },

    watch: {
      profileCountry(newVal, prevVal) {
        this.$store.dispatch('getCitiesForCountry', newVal)
          .then(({ data }) => {
            this.form.city = data.length ? data[0].id : null;
          })
      }
    },

    computed: {
      ...mapGetters('auth', ['loggedUser', 'userType']),
      ...mapGetters(['countries', 'cities']),
      ...mapGetters('options', [
        'contactMethods'
      ]),
      ...mapGetters('profile', [
        'profileIsFilled',
      ]),

      profileCountry() {
        return this.form.country
      },
      phone() {
        return this.form.phone
      }
    },

    methods: {

      validateState(ref) {
        if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
          return !this.errors.has(ref)
        }
        return null
      },

      updatePhone(phone) {
        this.$set(this.form, 'phone', '+' + phone.replace(/[^0-9]/g, ''));
      },

      sendForm() {
        this.$validator.validateAll().then(result => {
          if(!result)
            return;

          this.$store.dispatch('profile/saveOwnAgency', this.form)
            .then(() => {
              Message.success(this.$t('profile.success_update'));
            })
            .catch(() => {
              Message.error('Error')
            })
        });
      },

      onlyDigit(value, event) {
        return value.replace(/\D/g,'');
      },

      onlyEnglishAlphabet(value, event) {
        return value.replace(/[^a-zA-Z]/g,'');
      },

      siteUrl(value, event) {
        value = value.replace(/[^0-9a-zA-Z\:\/.-]/g,'');
        try {
          let url = new URL(value);
          return url.origin != 'null' ? url.origin : '';
        }
        catch (e) {
          return '';
        }
      }
    }
  }
</script>

<style lang="scss">
  .example_block {
    span {
      color: #fa6b6b;
      border-bottom: 1px dotted;
      font-weight: 500;
      font-size: 14px;
      margin-bottom: 5px;
      display: inline-block;
    }
    p {
      font-size: 13px;
      margin-bottom: 0!important;
    }
  }
</style>
