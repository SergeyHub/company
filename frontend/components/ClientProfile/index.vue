<template>
  <div class="admin__wrap">
    <div class="container">
      <h1>
        {{ $t('profile.title') }}
      </h1>

      <div class="row admin__profile">
        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="name"
            >
              {{ $t('profile.nickname') }} <ins>*</ins>
              <AppTooltip :content="$t('profile.nickname_tooltip')"/>
            </label>
            <div class="admin__profile-input">
              <!--<b-form-input
                id="name"
                v-model="form.name"
                :state="validateState('name')"
                v-validate="{ required: true, min:2, max: 20 }"
                :formatter="onlyEnglishAlphabet"
                lazy-formatter
                aria-describedby="input-name-live-feedback"
                name="name"
                size="sm">
              </b-form-input>-->
              <text-input
                id="name"
                type="text"
                :name="'name'"
                v-model="form.name"
                v-validate="{ required: true, min:2, max: 20 }"
              />
              <div class="invalid-feedback">
                {{ errors.first('name') }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="nationality"
            >
              {{ $t('profile.nationality') }} <ins>*</ins>
            </label>
            <select-with-search
              v-model="form.nationality"
              :options="nationalitiesFormatted"
              :state="validateState('nationality')"
              v-validate="{ required: true }"
              name="nationality"
              :key="'form.nationality'"
              :error="errors.first('nationality')"
            />
            <div class="invalid-feedback">
              {{ errors.first('nationality') }}
            </div>
          </div>
        </div>

        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="country"
            >
              {{ $t('profile.country') }} <ins>*</ins>
            </label>
            <select-with-search
              v-model="form.country"
              :options="countriesFormatted"
              :state="validateState('country')"
              v-validate="{ required: true }"
              name="country"
              :key="'form.country'"
              :error="errors.first('country')"
            />
            <div class="invalid-feedback">
              {{ errors.first('country') }}
            </div>
          </div>
        </div>

        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="city"
            >
              {{ $t('profile.city') }} <ins>*</ins>
            </label>
            <select-with-search
              v-model="form.city"
              :options="citiesFormatted"
              :state="validateState('city')"
              v-validate="{ required: true }"
              name="city"
              :error="errors.first('city')"
            />
            <div class="invalid-feedback">
              {{ errors.first('city') }}
            </div>
          </div>
        </div>

        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-input">
            <label
              class="input-lable"
              for="age"
            >
              {{ $t('profile.age') }} <ins>*</ins>
              <AppTooltip :content="$t('profile.age_tooltip')"/>
            </label>
            <text-input
              id="age"
              type="number"
              v-model="form.age"
              name="age"
              v-validate="{ required: true, numeric: true, min_value: 18, max_value: 100 }"
            />
            <!--
           <b-form-input
             id="age"
             v-model="form.age"
             :state="validateState('age')"
             v-validate="{ required: true, numeric: true, min_value: 18, max_value: 100 }"
             aria-describedby="input-age-live-feedback"
             name="age"
             type="number"
             size="sm">
           </b-form-input>-->
            <div class="invalid-feedback">
              {{ errors.first('age') }}
            </div>
          </div>
        </div>

        <!--<div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label class="input-lable">confirm</label>
            <button class="btn btn-border">Send sms</button>
          </div>
        </div>-->

        <div class="col-12 col-xs-12">
          <div class="admin__profile-item">
            <label class="input-lable">{{ $t('profile.about') }} <ins>*</ins></label>
            <div class="admin__profile-textarea">
              <textarea-multilang
                :state="validateState('about')"
                validate="'multilang:10,1024'"
                :name="'about'"
                :error="errors.first('about')"
                v-model="form.about"
                :cols="30"
                :rows="10"
              />
              <div class="invalid-feedback">
                {{ errors.first('about') }}
              </div>
            </div>
          </div>
          <hr>
        </div>

        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
            >
              {{ $t('profile.phone') }} <ins>*</ins>
              <AppTooltip :content="$t('profile.phone_tooltip')"/>
            </label>
            <div class="admin__profile-input">
              <!--
              <b-form-input
                id="phone"
                :value="form.phone"
                @input="updatePhone"
                :state="validateState('phone')"
                v-validate="{ required: true, min: 6, max: 30 }"
                aria-describedby="input-phone-live-feedback"
                name="phone"
                size="sm">
              </b-form-input>-->
              <text-input
                type="text"
                name="phone"
                :disabled="sms_sended || success_verification"
                :value="form.phone"
                v-validate="{ required: true }"
                @input="updatePhone"
              />

              <div class="invalid-feedback">
                {{ errors.first('phone') }}
              </div>
            </div>
          </div>

          <div
            class="admin__profile-item"
          >
            <button
              class="btn btn-border mb-20"
              v-if="!sms_sended && !success_verification"
              @click="sendSms"
            >{{ $t('verify.send_sms') }}</button>

            <template v-if="sms_sended && !success_verification">
              <!--
                <b-col>
                      <b-form-input
                        id="code"
                        v-model="code"
                        :state="validateState('code')"
                        v-validate="{ required: true, min: 5, max: 5, numeric: true }"
                        aria-describedby="input-code-live-feedback"
                        name="code"
                        :placeholder="$t('verify.sms_code')"
                        size="sm">
                      </b-form-input>
                    </b-col>
                    <b-col>
                      <b-button @click="sendCode" size="sm" variant="primary">
                        {{ $t('verify.verify') }}
                      </b-button>
                    </b-col>
              -->
              <label class="input-lable"  >
                {{ $t('verify.sms_code') }} <ins>*</ins>
              </label>
              <div class="admin__profile-input">
                <text-input
                  id="code"
                  type="text"
                  v-model="code"
                  name="code"
                  v-validate="{ required: true, min: 5, max: 5, numeric: true }"
                />

                <div class="invalid-feedback">
                  {{ errors.first('phone') }}
                </div>
              </div>
              <button
                class="btn btn-border mb-20"
                @click="sendCode"
              >{{ $t('verify.verify') }}</button>
            </template>
          </div>
        </div>

        <div class="col-6 col-md-6 col-xs-12">

        </div>

        <div class="col-12 col-md-12">
          <hr>
          <button
            @click="sendForm"
            class="btn btn-border"
          >{{ $t('profile.save') }}</button>
        </div>
      </div>
    </div>
  </div>
  <!--
  <div class="row" style="position: relative">
    <div class="col-md-12 mb-3">
      <div class="row">
        <div class="col-md-6">
          <div class="Typography_h2">{{ $t('profile.title') }}</div>
        </div>
        <div class="col-md-6 legend mb-3">
          <span class="legendReq">{{ $t('profile.required_fields') }}</span>
          <span>{{ $t('profile.optional_fields') }}</span>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <b-card>
        <b-form-group
          label-cols-sm="4"
          :label="$t('profile.nickname')"
          label-align-sm="right"
          label-for="name"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-row>
              <b-col cols="10" class="input_with_tooltip">
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
                <div id="input-name-live-feedback">
                  {{ errors.first('name') }}
                </div>
              </b-col>
              <b-col cols="2" class="question_block">
                <i class="far fa-question-circle" v-tooltip="$t('profile.nickname_tooltip')"></i>
              </b-col>
            </b-row>
          </div>
        </b-form-group>
        <b-form-group
          label-class="font-weight-bold pt-0"
          class="mb-0"
        >
          <b-form-group
            label-cols-sm="4"
            :label="$t('profile.nationality')"
            label-align-sm="right"
            label-for="nationality"
            label-size="sm"
          >
            <div class="inputContainer required">
              <b-form-select
                id="nationality"
                v-model="form.nationality"
                :options="nationalities"
                size="sm"
                text-field="name"
                value-field="id"
                v-validate="{ required: true }"
                aria-describedby="input-2-live-feedback"
                :state="validateState('nationality')"
                name="nationality"
              ></b-form-select>
              <div id="input-2-live-feedback">
                {{ errors.first('nationality') }}
              </div>
            </div>
          </b-form-group>

          <b-form-group
            label-cols-sm="4"
            :label="$t('profile.country')"
            label-align-sm="right"
            label-for="country"
            label-size="sm"
          >
            <div class="inputContainer required">
              <b-form-select
                id="country"
                v-model="form.country"
                text-field="name"
                value-field="id"
                :options="countries"
                v-validate="{ required: true }"
                aria-describedby="input-3-live-feedback"
                :state="validateState('country')"
                name="country"
                size="sm"/>
              <div id="input-3-live-feedback">
                {{ errors.first('country') }}
              </div>
            </div>
          </b-form-group>

          <b-form-group
            label-cols-sm="4"
            :label="$t('profile.city')"
            label-align-sm="right"
            label-for="city"
            label-size="sm"
          >
            <div class="inputContainer required">
              <b-form-select
                id="city"
                v-model="form.city"
                text-field="name"
                value-field="id"
                :options="cities"
                v-validate="{ required: true }"
                aria-describedby="input-4-live-feedback"
                :state="validateState('city')"
                name="city"
                size="sm"/>
              <div id="input-4-live-feedback">
                {{ errors.first('city') }}
              </div>
            </div>
          </b-form-group>
          <b-form-group
            label-cols-sm="4"
            :label="$t('profile.age')"
            label-align-sm="right"
            label-for="age"
            label-size="sm"
          >
            <div class="inputContainer required">
              <b-row>
                <b-col cols="10" class="input_with_tooltip">
                  <b-form-input
                    id="age"
                    v-model="form.age"
                    :state="validateState('age')"
                    v-validate="{ required: true, numeric: true, min_value: 18, max_value: 100 }"
                    aria-describedby="input-age-live-feedback"
                    name="age"
                    type="number"
                    size="sm">
                  </b-form-input>
                  <div class="invalid-feedback">
                    {{ errors.first('age') }}
                  </div>
                </b-col>
                <b-col cols="2" class="question_block">
                  <i class="far fa-question-circle" v-v-tooltip="$t('profile.age_tooltip')"></i>
                </b-col>
              </b-row>
            </div>
          </b-form-group>
          <b-form-group
            label-cols-sm="4"
            :label="$t('profile.phone')"
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
                    :disabled="sms_sended"
                    size="sm">
                  </b-form-input>
                  <div id="input-phone-live-feedback">
                    {{ errors.first('phone') }}
                  </div>
                </b-col>
                <b-col cols="2" class="question_block">
                  <i class="far fa-question-circle" v-v-tooltip="$t('profile.phone_tooltip')"></i>
                </b-col>
                <b-col>
                  <b-row v-if="sms_sended && !success_verification" class="mt-1">
                    <b-col>
                      <b-form-input
                        id="code"
                        v-model="code"
                        :state="validateState('code')"
                        v-validate="{ required: true, min: 5, max: 5, numeric: true }"
                        aria-describedby="input-code-live-feedback"
                        name="code"
                        :placeholder="$t('verify.sms_code')"
                        size="sm">
                      </b-form-input>
                    </b-col>
                    <b-col>
                      <b-button @click="sendCode" size="sm" variant="primary">
                        {{ $t('verify.verify') }}
                      </b-button>
                    </b-col>
                  </b-row>
                  <b-button v-if="!sms_sended && !success_verification"
                            @click="sendSms"
                            size="sm"
                            variant="primary"
                            class="mt-1">
                      {{ $t('verify.send_sms') }}
                  </b-button>
                </b-col>
              </b-row>
            </div>
          </b-form-group>
        </b-form-group>
      </b-card>
    </div>

    <div class="col-md-6 mt-3 mt-md-0">
      <b-card>
        <textarea-multilang
          :label="$t('profile.about')"
          :state="validateState('about')"
          v-validate="'multilang:10,1024'"
          name="about"
          :error="errors.first('about')"
          v-model="form.about" />
      </b-card>
    </div>

    <div class="col-md-12 mt-3">
      <b-button variant="primary" @click="sendForm">{{ $t('profile.save') }}</b-button>
    </div>
  </div>
  -->
</template>

<script>
import { mapGetters } from 'vuex'
import { Message } from 'element-ui'
import InputGroup from '~/components/InputGroup'
import TextareaMultilang from '~/components/TextareaMultilang'
import SelectWithSearch from '~/components/SelectWithSearch'
import TextInput from '~/components/TextInput'
import SelectInput from '~/components/SelectInput'
import CheckboxInput from '~/components/CheckboxInput'
import AppTooltip from '~/components/AppTooltip'

export default {
  props: {
    initData: {
      type: Object,
      default: () => {}
    }
  },

  components: {
    InputGroup,
    TextareaMultilang,
    SelectWithSearch,
    TextInput,
    SelectInput,
    CheckboxInput,
    AppTooltip
  },

  data() {
    return {
      loading: true,
      form: Object.assign({}, this.initData),
      sms_sended: false,
      success_verification: false,
      code: null
    }
  },

  computed: {
    ...mapGetters('auth', ['loggedUser', 'userType']),
    ...mapGetters('profile', [
      'client_profile',
    ]),
    ...mapGetters(['countries', 'cities']),
    ...mapGetters('options', ['nationalities']),
    profileCountry() {
      return this.form.country
    },
    phone() {
      return this.form.phone
    },
    nationalitiesFormatted() {
      let nationalities = [];
      this.nationalities.forEach(($nationality) => {
        nationalities.push({
          id: $nationality.id,
          text: $nationality.name
        });
      });
      return nationalities;
    },
    countriesFormatted() {
      let countries = [];
      this.countries.forEach(($country) => {
        countries.push({
          id: $country.id,
          text: $country.name
        });
      });
      return countries;
    },
    citiesFormatted() {
      let cities = [];
      this.cities.forEach(($city) => {
        cities.push({
          id: $city.id,
          text: $city.name
        });
      });
      return cities;
    }
  },

  watch: {
    profileCountry(newVal, prevVal) {
      this.$store.dispatch('getCitiesForCountry', newVal)
        .then(({ data }) => {
          this.form.city = data.length ? data[0].id : null;
        })
    },
    'form.country': async function(newVal) {
      await this.$store.dispatch('getCitiesForCountry', newVal)
    }
  },

  async mounted() {
    if(this.form.phone) {
      this.sms_sended = true;
      this.success_verification = true;
    }
    if(!this.$store.state.countries.length)
      await this.$store.dispatch('setCountries')
    if(!this.$store.state.options.nationalities.length)
      await this.$store.dispatch('options/fetchNationalities')
    this.loading = false;
    if(this.form.country) {
      await this.$store.dispatch('getCitiesForCountry', this.form.country)
    }
  },
  methods: {
    updatePhone(phone) {
      this.$set(this.form, 'phone', '+' + phone.replace(/[^0-9]/g, ''));
    },

    validateState(ref) {
      if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
        return !this.errors.has(ref)
      }
      return null
    },

    sendForm() {
      if(!this.success_verification) {
        Message.error(this.$t('verify.you_need_verify_phone'));
        return;
      }
      this.$validator.validateAll().then(result => {
        if(!result) {
          Message.error(this.$t('validation.wrong_data'))
          return;
        }

        this.$store.dispatch('profile/saveOwnClient', this.form)
          .then(() => {
            Message.success(this.$t('profile.success_update'))
          })
          .catch(() => {
            Message.error('Error')
          })
      });
    },

    onlyEnglishAlphabet(value, event) {
      return value.replace(/[^a-zA-Z]/g,'');
    },

    sendSms() {
      if(!this.phone || !this.phone.length)
        return;
      this.$axios.post('/verify/send', {phone: this.phone})
        .then((response) => {
          if(response.data.success) {
            this.sms_sended = true;
            if(response.data.already_verified) {
              this.success_verification = true
              Message.success(this.$t('verify.success_verify'))
            } else {
              Message.success(this.$t('verify.sms_sended'))
            }
          } else {
            let error = response.data.error ? response.data.error : '';
            Message.error(this.$t('verify.sms_send_error') + error)
          }
        })
        .catch((error) => {
          Message.error(this.$t('verify.sms_send_error'))
        })
    },

    sendCode() {
      this.$axios.post('/verify/verify', {code: this.code})
        .then((response) => {
          if(response.data.success) {
            this.success_verification = true
            Message.success(this.$t('verify.success_verify'))
          } else {
            let error = response.data.error ? response.data.error : '';
            Message.error(this.$t('verify.error_verify') + error)
          }
        })
        .catch((error) => {
          Message.error(this.$t('verify.error_verify'))
        })
    }
  }
}
</script>
