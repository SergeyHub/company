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
              <text-input
                id="name"
                type="text"
                name="name"
                v-model="form.name"
                v-validate="{ required: true, min:2, max: 20, english: true }"
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
              for="real_name"
            >
              {{ $t('profile.real_name') }} <ins>*</ins>
              <AppTooltip :content="$t('profile.real_name_tooltip')"/>
            </label>

            <!--<b-form-input
              id="real_name"
              v-model="form.real_name"
              :formatter="onlyEnglishAlphabet"
              lazy-formatter
              :state="validateState('real_name')"
              v-validate="{ required: true, min:2, max: 20 }"
              aria-describedby="input-real_name-live-feedback"
              name="real_name"
              size="sm">
            </b-form-input>-->
            <div class="admin__profile-input">
              <text-input
                id="real_name"
                type="text"
                name="real_name"
                v-model="form.real_name"
                v-validate="{ required: true, min:2, max: 20, english: true }"
              />
              <div class="invalid-feedback">
                {{ errors.first('real_name') }}
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
              for="body"
            >
              {{ $t('profile.body') }} <ins>*</ins>
            </label>
            <select-with-search
              v-model="form.body"
              :options="bodies"
              text-field="name"
              value-field="id"
              :state="validateState('body')"
              v-validate="{ required: true }"
              name="body"
            />

            <div class="invalid-feedback">
              {{ errors.first('body') }}
            </div>
          </div>
        </div>


        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="body_hair"
            >
              {{ $t('profile.body_hair') }} <ins>*</ins>
            </label>
            <select-with-search
              v-model="form.body_hair"
              :options="bodyHairs"
              text-field="name"
              value-field="id"
              :state="validateState('body')"
              v-validate="{ required: true }"
              name="body_hair"
            />

            <div class="invalid-feedback">
              {{ errors.first('body_hair') }}
            </div>
          </div>
        </div>


        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="orientation"
            >
              {{ $t('profile.orientation') }} <ins>*</ins>
            </label>
            <select-with-search
              v-model="form.orientation"
              :options="orientations"
              text-field="name"
              value-field="id"
              :state="validateState('orientation')"
              v-validate="{ required: true }"
              name="orientation"
            />

            <div class="invalid-feedback">
              {{ errors.first('orientation') }}
            </div>
          </div>
        </div>

        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="ethnicity"
            >
              {{ $t('profile.ethnicity') }} <ins>*</ins>
            </label>
            <select-with-search
              v-model="form.ethnicity"
              :options="ethnicities"
              text-field="name"
              value-field="id"
              :state="validateState('ethnicity')"
              v-validate="{ required: true }"
              name="ethnicity"
            />

            <div class="invalid-feedback">
              {{ errors.first('ethnicity') }}
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
              :validating="changedSelect2.country || try_send"
              :error="errors.first('country')"/>

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
              name="city"
              :options="citiesFormatted"
              :state="validateState('city')"
              v-validate="{ required: true }"
              :validating="changedSelect2.city || try_send"
            />
            <div class="invalid-feedback">
              {{ errors.first('city') }}
            </div>
          </div>
        </div>

        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="eye"
            >
              {{ $t('profile.eyes_color') }} <ins>*</ins>
            </label>
            <select-with-search
              :searchable="false"
              v-model="form.eye"
              :options="eyes"
              text-field="name"
              value-field="id"
              v-validate="{ required: true }"
              name="eye"
            />

            <div class="invalid-feedback">
              {{ errors.first('eye') }}
            </div>
          </div>
        </div>

        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="hairs_color"
            >
              {{ $t('profile.hairs_color') }} <ins>*</ins>
            </label>
            <select-with-search
              :searchable="false"
              v-model="form.hair"
              :options="hairs"
              text-field="name"
              value-field="id"
              name="hairs"
              id="hairs_color"
              v-validate="{ required: true }"
            />

            <div class="invalid-feedback">
              {{ errors.first('hairs') }}
            </div>
          </div>
        </div>

        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="height"
            >
              {{ $t('profile.height') }} <ins>*</ins>
            </label>
            <div class="admin__profile-input">
              <text-input
                id="height"
                type="text"
                name="height"
                v-model="form.height"
                v-validate="{ required: true, numeric: true, min_value: 130, max_value: 240 }"
              />
              <div class="admin__profile-input-type">{{ $t('profile.sm') }}</div>

              <div class="invalid-feedback">
                {{ errors.first('height') }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="weight"
            >
              {{ $t('profile.weight') }} <ins>*</ins>
            </label>
            <div class="admin__profile-input">
              <text-input
                id="weight"
                type="text"
                name="weight"
                v-validate="{ required: true, numeric: true, min_value: 30, max_value: 240 }"
                v-model="form.weight"
              />
              <div class="admin__profile-input-type">{{ $t('profile.kg') }}</div>

              <div class="invalid-feedback">
                {{ errors.first('weight') }}
              </div>
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
              type="text"
              name="age"
              v-validate="{ required: true, numeric: true, min_value: 18, max_value: 100 }"
              v-model="form.age"
            />
            <div class="invalid-feedback">
              {{ errors.first('age') }}
            </div>
          </div>
        </div>

        <div class="col-12 col-xs-12">
          <div class="admin__profile-item">
            <label class="input-lable">{{ $t('profile.about') }} <ins>*</ins></label>
            <div class="admin__profile-textarea">
              <textarea-multilang
                v-validate="'multilang:10,1024'"
                v-model="form.about"
                name="about"
              />
              <div class="invalid-feedback">
                {{ errors.first('about') }}
              </div>
            </div>
          </div>
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
              <text-input
                id="phone"
                type="text"
                :value="form.phone"
                v-validate="{ required: true, min: 6, max: 30 }"
                @input="updatePhone"
                name="phone"
              />
              <div class="invalid-feedback">
                {{ errors.first('phone') }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-9 col-md-9 col-xs-12">
          <checkbox-group
            class="admin__profile-item center"
            :label="$t('profile.contact_methods')"
            :options="contactMethods"
            v-model="form.contact_methods"
            textField="name"
            valueField="id"
          />
        </div>

        <div class="col-12 col-md-12">
          <hr>
        </div>

        <div class="col-12 col-md-12">
          <div class="admin__profile-item">
            <checkbox-input
              :label="$t('profile.ready_for_travels')"
              :checked="form.ready_for_travels == 1"
              name="ready_for_travels"
              v-model="form.ready_for_travels"
            />
          </div>
        </div>

        <div
          class="col-12 col-md-12"
        >
          <select-costs v-model="form.costs" />
        </div>

        <div class="col-12 col-md-12">
          <checkbox-group
            class="admin__profile-item center"
            :label="$t('meeting_places.incall')"
            :options="meetingPointsHandled"
            v-model="form.meeting_points_incall"
            textField="text"
            valueField="id"
          />
        </div>

        <div class="col-12 col-md-12">
          <checkbox-group
            class="admin__profile-item center"
            :label="$t('meeting_places.outcall')"
            :options="meetingPointsHandled"
            v-model="form.meeting_points_outcall"
            textField="text"
            valueField="id"
          />
        </div>

        <div class="col-12 col-md-12">
          <hr>
        </div>

        <div class="col-12 col-md-12">
          <checkbox-group
            class="admin__profile-item center"
            :label="$t('profile.meeting_with')"
            :options="meetingWithHandled"
            v-model="form.meeting_with"
            textField="text"
            valueField="id"
          />
        </div>

        <div class="col-12 col-md-12">
          <hr>
        </div>

        <div class="col-12 col-md-12">
          <select-ready-for v-model="form.ready_fors" />
        </div>


        <div class="col-12 col-md-12">
          <hr>
        </div>

        <div class="col-12 col-md-12">
          <select-what-ilike v-model="form.what_likes" />
        </div>

        <div class="col-12 col-md-12">
          <hr>
        </div>

        <!--<div class="col-12 col-md-12">
          <checkbox-group
            class="admin__profile-item center"
            :label="$t('profile.is_pornstar')"
            :options="[{text: 'Yes', value: 1}]"
            v-model="form.pornstar"
            textField="text"
            valueField="id"
          />
        </div>

        <div class="col-12 col-md-12">
          <hr>
        </div>-->

        <!--<div class="col-3 col-md-3 col-xs-12">
          <div class="admin__profile-item">
            <label
              class="input-lable"
              for="profile_site"
            >
              {{ $t('profile.site') }}
              <AppTooltip :content="$t('profile.site_tooltip')"/>
            </label>
            <div class="admin__profile-input">
              <text-input
                id="profile_site"
                type="text"
                v-model="form.profile_site"
              />
              <div class="invalid-feedback">
                {{ errors.first('profile_site') }}
              </div>
            </div>
          </div>
        </div>-->

        <div class="col-12 col-md-12">
          <hr>
        </div>

        <div class="col-6 col-md-6 col-xs-12">
          <select-languages
            v-model="form.languages"
          />
        </div>
        <div class="col-6">

        </div>

        <!--<b-form-group
              label-class="font-weight-bold pt-0"
              class="mb-0"
            >
        </b-form-group>
          <b-card class="mt-3">
            <b-form-group
              label-cols-sm="4"
              :label="$t('profile.meeting_with')"
              label-align-sm="right" class="mb-0"
              label-size="sm"
            >
              <b-form-checkbox-group id="checkbox-group-2" v-model="form.meeting_with" name="flavour-2" class="mt-1">
                <b-form-checkbox :value="option" v-for="option in meetingWith" :key="option">
                  {{ $t('meeting_with.' + option) }}
                </b-form-checkbox>
              </b-form-checkbox-group>
            </b-form-group>
          </b-card>

        <div class="col-md-7 mt-3 mt-md-0">
          <b-card class="mb-3">
            <textarea-multilang
              :label="$t('profile.about')"
              :state="validateState('about')"
              v-validate="'multilang:10,1024'"
              name="about"
              :error="errors.first('about')"
              v-model="form.about" />
          </b-card>

          <b-card class="mt-3">
            <b-form-group
              label-cols-sm="2"
              :label="$t('meeting_places.incall')"
              label-align-sm="right" class="mb-0"
              label-size="sm"
            >
              <div class="inputContainer required">
                <b-form-checkbox-group id="checkbox-group-2" v-model="form.meeting_points_incall" name="flavour-2" class="mt-1 ml-3">
                  <b-form-checkbox :value="option" v-for="option in meetingPoints" :key="option">
                    {{ $t('meeting_places.' + option) }}
                  </b-form-checkbox>
                </b-form-checkbox-group>
              </div>
            </b-form-group>
            <b-form-group
              label-cols-sm="2"
              :label="$t('meeting_places.outcall')"
              label-align-sm="right" class="mb-0"
              label-size="sm"
            >
              <div class="inputContainer required">
                <b-form-checkbox-group id="checkbox-group-2" v-model="form.meeting_points_outcall" name="flavour-2" class="mt-1 ml-3">
                  <b-form-checkbox :value="option" v-for="option in meetingPoints" :key="option">
                    {{ $t('meeting_places.' + option) }}
                  </b-form-checkbox>
                </b-form-checkbox-group>
              </div>
            </b-form-group>
          </b-card>

          <b-card class="mt-3">
            <select-costs v-model="form.costs" />
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
          <b-card class="mt-3" v-if="isAdmin">
            <b-form-group
              label-cols-sm="4"
              :label="$t('profile.vip')"
              label-align-sm="right" class="mb-0"
              label-size="sm"
            >
              <div class="inputContainer mt-1">
                <b-form-checkbox
                  v-model="form.vip"
                >
                  {{$t('profile.is_vip_yes')}}
                </b-form-checkbox>
              </div>
            </b-form-group>
          </b-card>

        </div>-->

        <div class="col-md-12 mt-3">
          <AppButton mode="dark" @click.native="sendForm">{{ $t('profile.save') }}</AppButton>
        </div>
        <!--<document-upload ref="documentUploadModal" v-model="documentUploadOpened"/>-->
      </div>
    </div>
  </div>
</template>

<script>

  import { mapGetters } from 'vuex'
  import { Message } from 'element-ui'
  import SelectLanguages from '~/components/SelectLanguages'
  import SelectGeographies from '~/components/SelectGeographies'
  import SelectReadyFor from '~/components/SelectReadyFor'
  import SelectWhatIlike from '~/components/SelectWhatIlike'
  import DocumentUpload from '~/components/DocumentUpload'
  import SelectCosts from '~/components/SelectCosts'
  import SelectCountries from '~/components/SelectCountries'
  import TextareaMultilang from '~/components/TextareaMultilang'
  import SelectWithSearch from '~/components/SelectWithSearch'
  import InputGroup from '~/components/InputGroup'
  import CheckboxGroup from '~/components/CheckboxGroup'
  import TextInput from '~/components/TextInput'
  import AppButton from '~/components/AppButton'
  import AppTooltip from '~/components/AppTooltip'
  import CheckboxInput from '~/components/CheckboxInput';


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
      SelectWhatIlike,
      SelectReadyFor,
      SelectCosts,
      CheckboxGroup,
      CheckboxInput,

      SelectCountries,
      InputGroup,
      TextareaMultilang,
      DocumentUpload,
      SelectWithSearch,
      TextInput,
      AppTooltip
    },

    data() {
      let form =  Object.assign({}, this.initData);
      form.meeting_points_incall = form.meeting_points
        .filter(point => point['type'] === 'incall')
        .map(point => point['place']);
      form.meeting_points_outcall = form.meeting_points
        .filter(point => point['type'] === 'outcall')
        .map(point => point['place']);

      return {
        loading: true,
        form: form,
        meetingPoints: ['hotel', 'flat'],
        meetingWith: ['girls', 'boys', 'couples'],
        documentUploadOpened: false,
        try_send: false,
        changedSelect2: {
          nationality: false,
          country: false,
          city: false
        }
      }
    },

    async mounted() {
        await this.$store.dispatch('setCountries');
      if(!this.$store.state.options.eyes.length)
        await this.$store.dispatch('options/fetchEyes')
      if(!this.$store.state.options.nationalities.length)
        await this.$store.dispatch('options/fetchNationalities')
      if(!this.$store.state.options.hairs.length)
        await this.$store.dispatch('options/fetchHairs')
      if(!this.$store.state.options.currencies.length)
        await this.$store.dispatch('options/fetchCurrencies')
      if(!this.$store.state.options.languages.length)
        await this.$store.dispatch('options/fetchLanguages')
      if(!this.$store.state.options.geographies.length)
        await this.$store.dispatch('options/fetchGeographies')
      if(!this.$store.state.options.iLikes.length)
        await this.$store.dispatch('options/fetchIlikes')
      if(!this.$store.state.options.readyFor.length)
        await this.$store.dispatch('options/fetchReadyFor')
      if(!this.$store.state.options.contactMethods.length)
        await this.$store.dispatch('options/fetchContactMethods')
      if(!this.$store.state.options.bodies.length)
        await this.$store.dispatch('options/fetchBodies')
      if(!this.$store.state.options.orientations.length)
        await this.$store.dispatch('options/fetchOrientations')
      if(!this.$store.state.options.bodyHairs.length)
        await this.$store.dispatch('options/fetchBodyHairs')
      if(!this.$store.state.options.ethnicities.length)
        await this.$store.dispatch('options/fetchEthnicities')
      this.loading = false;
    },

    watch: {
      profileCountry(newVal, prevVal) {
        this.$store.dispatch('getCitiesForCountry', newVal)
          .then(({ data }) => {
            this.form.city = data.length ? data[0].id : null;
          })
      },
      documentUploadOpened(newVal, prevVal) {
        if (!newVal) {
          if (!(this.profileIsVerified || this.profileOnVerify)) {
            this.form.pornstar = false;
          }
        }
      },
      nationality(newVal, prevVal) {
        this.changedSelect2.nationality = true;
      },
      country(newVal, prevVal) {
        this.changedSelect2.country = true;
      },
      city(newVal, prevVal) {
        this.changedSelect2.city = true;
      },
    },

    computed: {
      ...mapGetters('auth', ['loggedUser', 'userType', 'isAgency', 'isAdmin']),
      ...mapGetters(['countries', 'cities']),
      ...mapGetters('options', [
        'eyes', 'nationalities', 'hairs', 'currencies', 'contactMethods', 'ethnicities', 'bodyHairs', 'orientations', 'bodies'
      ]),

      meetingPointsHandled() {
        return this.meetingPoints.map(item => ({
          text: this.$t('meeting_places.' + item),
          id: item
        }))
      },

      meetingWithHandled() {
        return this.meetingWith.map(item => ({
          text: this.$t('meeting_with.' + item),
          id: item
        }))
      },

      profileOnVerify() {
        return this.$store.getters['girls/profileOnVerify']
      },

      profileIsVerified() {
          return this.$store.getters['girls/profileIsVerified'];
      },

      profileIsFilled() {
          return this.$store.getters['girls/profileIsFilled'];
      },

      profileCountry() {
        return this.form.country
      },
      nationality() {
        return this.form.nationality
      },
      country() {
        return this.form.country
      },
      city() {
        return this.form.city
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

    methods: {
      validateState(ref) {
        if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
          return !this.errors.has(ref)
        }
        return null
      },

      /*pornstarChange() {
        if (this.form.pornstar && !this.profileIsVerified && !this.profileOnVerify) {
          this.openDocumentModal();
        }
      },*/

      openDocumentModal() {
        this.$refs.documentUploadModal.open();
      },

      updatePhone(phone) {
        this.$set(this.form, 'phone', '+' + phone.replace(/[^0-9]/g, ''));
      },

      sendForm() {
        this.$validator.validateAll().then(result => {
          this.try_send = true;
          if(!result) {
            Message.error(this.$t('validation.wrong_data'))
            return;
          }
          if (this.form.pornstar && !this.profileIsVerified && !this.profileOnVerify) {
           // this.openDocumentModal();
           // return;
          }
          let data = this.form;
          // оставляем только заполненные ценники
          data.costs = [...data.costs.filter(cost => !!cost.amount)];
          data.meeting_points = [
            ...data.meeting_points_incall.map(place => {
              return {place, type: 'incall'}
            }),
            ...data.meeting_points_outcall.map(place => {
              return {place, type: 'outcall'}
            })
          ];

          this.$store.dispatch('girls/saveGirl', data)
            .then(() => {
              Message.success(this.$t('profile.success_update'));
              // если это первое заполнение анкеты (и редактирование не из админки)
              if(!this.admin && !this.profileIsFilled) {
                this.$ga.event('girl', 'fill_profile');
                if (this.isAgency) {
                  this.$router.push(this.localePath({
                    name: 'profile-agency-girls-id-photos',
                    params: {id: this.form.id}
                  }))
                } else {
                  this.$router.push(this.localePath({
                    name: 'profile-id-photos',
                    params: {id: this.form.id}
                  }))
                }
              }
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
