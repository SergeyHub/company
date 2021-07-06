<template>
  <div>
    <div class="Typography_h3 mb-4">Редактирование отзыва ID #{{form.id}}</div>
    <div class="col-md-12">
      <b-card>
        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.your_email')"
          label-align-sm="right"
          label-for="email"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-row>
              <b-col cols="12" class="input_with_tooltip">
                <b-form-input
                  id="email"
                  v-model="form.email"
                  name="email"
                  size="sm">
                </b-form-input>
              </b-col>
            </b-row>
          </div>
        </b-form-group>

        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.your_nickname')"
          label-align-sm="right"
          label-for="nickname"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-row>
              <b-col cols="12" class="input_with_tooltip">
                <b-form-input
                  id="nickname"
                  v-model="form.nickname"
                  name="nickname"
                  size="sm">
                </b-form-input>
              </b-col>
            </b-row>
          </div>
        </b-form-group>
        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.your_review')"
          label-align-sm="right"
          label-for="your_review"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-row>
              <b-col cols="12" class="input_with_tooltip">
                <b-form-textarea
                  id="your_review"
                  v-model="form.review"
                  required
                  :placeholder="$t('public_profile.your_review')"
                  rows="4"
                  style="height: 135px;"
                ></b-form-textarea>
              </b-col>
            </b-row>
          </div>
        </b-form-group>
        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.meeting_date')"
          label-align-sm="right"
          label-for="meeting_date"
          label-size="sm"
        >
          <div class="inputContainer required">
            <date-picker id="meeting_date" v-model="form.meeting_date" format="yyyy.MM.dd" type="date" :placeholder="$t('public_profile.meeting_date')"  input-class="form-control"></date-picker>
          </div>
        </b-form-group>
        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.meeting_country')"
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
              aria-describedby="input-3-live-feedback"
              name="country"
              size="sm"/>
          </div>
        </b-form-group>

        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.meeting_city')"
          label-align-sm="right"
          label-for="meeting_city"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-form-input
              id="meeting_city"
              v-model="form.meeting_city"
              required
              :placeholder="$t('public_profile.meeting_city')"
            ></b-form-input>
          </div>
        </b-form-group>
        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.price')"
          label-align-sm="right"
          label-for="price"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-form-input
              id="price"
              v-model="form.price"
              required
              :placeholder="$t('public_profile.price')"
            ></b-form-input>
          </div>
        </b-form-group>
        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.currency')"
          label-align-sm="right"
          label-for="currency"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-form-select
              id="currency"
              v-model="form.currency"
              text-field="title"
              :placeholder="$t('public_profile.currency')"
              value-field="id"
              :options="currencies"
              name="currency"
              size="sm">
            </b-form-select>
          </div>
        </b-form-group>
        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.duration')"
          label-align-sm="right"
          label-for="duration"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-form-input
              id="duration"
              v-model="form.duration"
              required
              :placeholder="$t('public_profile.duration')"
            ></b-form-input>
          </div>
        </b-form-group>

        <b-form-group
          label-cols-sm="4"
          :label="$t('public_profile.duration_type')"
          label-align-sm="right"
          label-for="duration_type"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-form-select
              id="duration_type"
              v-model="form.duration_type"
              text-field="name"
              value-field="id"
              :options="duration_types"
              name="duration_type"
              size="sm"/>
          </div>
        </b-form-group>
        <b-form-group
          label-cols-sm="4"
          :label="$t('reviews.published')"
          label-align-sm="right"
          label-for="duration"
          label-size="sm"
        >
          <div class="inputContainer required">
            <b-form-checkbox v-model="form.published"></b-form-checkbox>
          </div>
        </b-form-group>
      </b-card>
    </div>
    <div class="col-md-12 mt-3">
      <b-button variant="primary" @click="sendForm">{{ $t('profile.save') }}</b-button>
    </div>
  </div>
</template>

<script>
  import { Message } from 'element-ui'
  import {mapGetters} from "vuex";

  export default {
    layout: 'admin',

    data() {
      return {
        form: {},
        duration_types: {
          'days': this.$t('public_profile.days'),
          'hours': this.$t('public_profile.hours')
        }
      }
    },

    async asyncData({ store, params }) {
      return store.dispatch('reviews/fetchReview', params.id)
        .then((data) => {
          return {
            form: _.cloneDeep(data.data)
          }
        })
    },

    computed: {
      ...mapGetters(['countries']),
      ...mapGetters('options', ['currencies']),
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

          this.$store.dispatch('reviews/updateReview', this.form)
            .then(() => {
              Message.success(this.$t('settings.success_update'));
            })
        });
      }
    },
    async mounted() {
      if (!this.$store.state.countries.length)
        await this.$store.dispatch('setCountries')
      if(!this.$store.state.options.currencies.length)
        await this.$store.dispatch('options/fetchCurrencies')
    }
  }
</script>
