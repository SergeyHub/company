<template>
  <modal
    id="popup__reviews"
    v-model="showModify"
    ref="modal"
  >
    <div class="popup__wrap" v-if="$refs.modal">
      <div class="popup__header">
        <div class="popup__header-title">{{ $t('public_profile.your_review') }}</div>
      </div>
      <div class="popup__content">
        <div>
          <div>
            <div class="form-group">
              <textarea-multilang
                name="review"
                v-model="form.review"
                v-validate="'multilang:10,1024'"
                :placeholder="$t('reviews.modal_title')+'..'"
                :error="errors.first('review')"
              ></textarea-multilang>
            </div>

            <div class="form-group admin__profile-input">
              <text-input
                :mode="'profile'"
                name="nickname"
                v-model="form.nickname"
                v-validate="{ required: true, min:2, max: 20, alpha: true }"
                :placeholder="$t('public_profile.your_nickname')"
              />

              <div class="invalid-feedback">
                {{ errors.first('nickname') }}
              </div>
            </div>

            <div class="form_group admin__profile-input">
              <text-input
                :mode="'profile'"
                type="email"
                name="email"
                v-model="form.email"
                v-validate="{ required: true, email: true, min:2}"
                :placeholder="$t('public_profile.your_email')"
              />
              <div class="invalid-feedback">
                {{ errors.first('email') }}
              </div>
            </div>



            <rate-input
              v-model="form.stars"
              v-validate="{ required: true }"
              :name="'stars'"
            />
            <div class="invalid-feedback tcenter">
              {{ errors.first('stars') }}
            </div>
          </div>
          <!--<div class="col-sm-12 col-6">
            <div class="form-group">
              <date-picker
                class="dark"
                v-model="form.meeting_date"
                format="yyyy.MM.dd"
                type="date"
                :placeholder="$t('public_profile.meeting_date')"
                input-class="form-control"
              ></date-picker>
            </div>
            <div class="form-group">
              <select-input
                class="dark"
                v-if="countries.length"
                v-model="form.country"
                :options="countries"
                :placeholder="$t('public_profile.meeting_country')"
                text-field="name"
                value-field="id"
                name="country"
              />
            </div>

          <div class="form-group">
            <input-multilang
              class="dark"
              :placeholder="$t('public_profile.meeting_city')"
              name="review"
              :error="errors.first('meeting_city')"
              v-model="form.meeting_city" />
          </div>

           <div class="form-group">
              <div class="row">
                <div class="col-sm-12 col-7">
                  <text-input
                    type="number"
                    class="dark"
                    name="price"
                    v-model="form.price"
                    :placeholder="0"
                  />
                </div>
                <div class="col-sm-12 col-5">
                  <select-input
                    class="dark"
                    v-if="currencies.length"
                    text-field="title"
                    value-field="id"
                    :options="currencies"
                    v-model="form.currency"
                  />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12 col-7">
                  <text-input
                    type="number"
                    class="dark"
                    name="price"
                    v-model="form.duration"
                    :placeholder="0"
                  />
                </div>
                <div class="col-sm-12 col-5">
                  <select-input
                    class="dark"
                    text-field="name"
                    value-field="id"
                    v-if="duration_types.length"
                    :options="duration_types"
                    v-model="form.duration_type"
                  />
                </div>
              </div>
            </div>
          </div>-->
        </div>
      </div>
      <div class="popup__footer mt-30">
        <button
          class="btn btn-submit"
          @click="sendReview"
        >
          {{ $t('reviews.publish') }}
        </button>
      </div>
    </div>
  </modal>
  <!--
    <modal v-model="showModify"
           :title="$t('public_profile.your_review')"
           size="lg"
    class="review-modal">
      <template slot="footer">
        <div class="row" style="display: flex">
          <div class="col-md-6">
            <textarea-multilang
              :placeholder="$t('public_profile.your_review')"
              v-validate="'multilang:10,2048'"
              :rows="8"
              name="review"
              :error="errors.first('review')"
              v-model="form.review" />
            <b-form-input
              v-model="form.nickname"
              required
              :placeholder="$t('public_profile.your_nickname')"

            ></b-form-input>
            <b-form-input
              v-model="form.email"
              required
              :placeholder="$t('public_profile.your_email')"

            ></b-form-input>
          </div>
          <div class="col-md-6">
            <date-picker v-model="form.meeting_date" format="yyyy.MM.dd" type="date" :placeholder="$t('public_profile.meeting_date')"  input-class="form-control"></date-picker>
            <b-form-select
              id="country"
              v-model="form.country"
              text-field="name"
              value-field="id"
              :options="countries"
              v-validate="{ required: true }"
              aria-describedby="input-3-live-feedback"
              name="country"
              />
            <input-multilang
              :placeholder="$t('public_profile.meeting_city')"
              v-validate="'multilang:10,200'"
              name="review"
              :error="errors.first('meeting_city')"
              v-model="form.meeting_city" />
            <b-form-input
              v-model="form.price"
              required
              :placeholder="$t('public_profile.price')"
              class="col-md-7"
              style="float:left;"

            ></b-form-input>
            <b-form-select
              id="country"
              v-model="form.currency"
              text-field="title"
              value-field="id"
              :options="currencies"
              v-validate="{ required: true }"
              name="currency"
              class="col-md-4"
              style="float:right;">
            </b-form-select>
            <b-form-input
              v-model="form.duration"
              required
              :placeholder="$t('public_profile.duration')"
              class="col-md-7"
              style="float:left;"

            ></b-form-input>
            <b-form-select
              id="country"
              v-model="form.duration_type"
              text-field="name"
              value-field="id"
              :options="duration_types"
              v-validate="{ required: true }"
              name="duration_type"

              class="col-md-4"
              style="float:right;"/>
          </div>
        </div>
        <div class="text-center mt-3">
          <button @click.prevent="sendReview" class="brn btn-sm btn-primary">{{$t('public_profile.send_review')}}</button>
        </div>
      </template>
    </modal>-->
</template>

<script>
import Modal from '~/components/Modal'
import TextareaMultilang from '~/components/TextareaMultilang'
import InputMultilang from '~/components/InputMultilang'
import TextInput from '~/components/TextInput'
import RateInput from '~/components/RateInput'
import {mapGetters} from "vuex";
import {Message} from "element-ui";

export default {
  props: {
    value: {
      type: Boolean,
      default: () => false
    }
  },
  components: {
    Modal,
    TextareaMultilang,
    InputMultilang,
    TextInput,
    RateInput
  },
  data() {
    return {
      girl_type: '',
      showModify: this.value,
      form: {},
      duration_types: [
        { id: 'days', name: this.$t('public_profile.days') },
        { id: 'hours', name: this.$t('public_profile.hours') }
      ]
    }
  },
  computed: {
    ...mapGetters(['countries']),
    ...mapGetters('options', ['currencies']),
  },
  methods: {
    open() {
      this.showModify = true;
    },
    close() {
      this.showModify = false;
    },
    sendReview() {
      this.$validator.validateAll().then(result => {
        if (!result)
          return;

        let data = this.form;
        data.girl = this.$route.params.id;
        this.$store.dispatch('girls/saveReview', data)
          .then(() => {
            Message.success(this.$t('public_profile.review_sended'));
            this.close();
            this.form = {};
          });
      })
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

<style>
.review-modal input,
.review-modal select{
  height: 48px;
  margin-top: 1rem;
}
.review-modal .form-group {
  margin-bottom: 0;
}
.review-modal textarea {
  margin-top: 1rem;
  height: 176px;
}
.vdp-datepicker input[readonly] {
  background-color: #F1F2F6;
  cursor: pointer;
}
</style>
