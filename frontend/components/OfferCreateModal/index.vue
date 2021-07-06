<template>
  <div>
    <modal v-model="showModify" size="lg" :title="$t('offers.title_'+type)">
      <template slot="header">
        {{ $t('offers.title_' + type) }}
      </template>
      <input-multilang
        :label="$t('offers.name')"
        :state="validateState('offer_name')"
        v-validate="'multilang:10,40'"
        name="offer_name"
        :placeholder="$t('offers.enter_name')"
        :error="errors.first('offer_name')"
        v-model="offerData.name" />

      <b-form-group
        :label="$t('profile.country')"
        label-for="country"
      >
          <b-form-select
            id="country"
            v-model="offerData.country"
            text-field="name"
            value-field="id"
            :options="countries"
            v-validate="{ required: true }"
            aria-describedby="input-3-live-feedback"
            :state="validateState('country')"
            name="country"/>
          <b-form-invalid-feedback id="input-3-live-feedback">
            {{ errors.first('country') }}
          </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group
        :label="$t('profile.city')"
        label-for="city"
      >
          <b-form-select
            id="city"
            v-model="offerData.city"
            text-field="name"
            value-field="id"
            :options="cities"
            v-validate="{ required: true }"
            aria-describedby="input-4-live-feedback"
            :state="validateState('city')"
            name="city"/>
          <b-form-invalid-feedback id="input-4-live-feedback">
            {{ errors.first('city') }}
          </b-form-invalid-feedback>
      </b-form-group>

      <b-form-group
        :label="$t('offers.cost')"
        label-for="cost"
      >
        <div class="inputContainer required">
          <b-row>
            <b-col cols="11" class="input_with_tooltip">
              <b-form-input
                id="cost"
                v-model="offerData.cost"
                :state="validateState('cost')"
                v-validate="{ required: true, numeric: true, min_value: 1, max_value: 1000000000 }"
                aria-describedby="input-cost-live-feedback"
                name="cost"
                type="number">
              </b-form-input>
              <b-form-invalid-feedback id="input-cost-live-feedback">
                {{ errors.first('cost') }}
              </b-form-invalid-feedback>
            </b-col>
            <b-col cols="1" class="question_block" style="margin-top: 5px">
              <i class="fas fa-dollar-sign" v-b-tooltip.hover :title="$t('offers.cost_tooltip')"></i>
            </b-col>
          </b-row>
        </div>
      </b-form-group>

      <textarea-multilang
        :label="$t('offers.content')"
        :state="validateState('offer_content')"
        v-validate="'multilang:10,300'"
        name="offer_content"
        :placeholder="$t('offers.enter_content')"
        :error="errors.first('offer_content')"
        v-model="offerData.content" />
      <template slot="footer">
        <b-button @click="sendForm" variant="primary">
          {{ $t('offers.'+type) }}
        </b-button>
      </template>
    </modal>
  </div>
</template>

<script>
  import Modal from '~/components/Modal'
  import TextareaMultilang from '~/components/TextareaMultilang'
  import InputMultilang from '~/components/InputMultilang'
  import { mapGetters } from 'vuex'
  import { Message } from 'element-ui'

  export default {
    components: { Modal, TextareaMultilang, InputMultilang },
    props: {
      title: {
        type: String,
        default: () => ''
      },
      value: {
        type: Boolean,
        default: () => false
      }
    },
    computed: {
      ...mapGetters(['countries', 'cities']),
      offerCountry() {
        return this.offerData.country;
      }
    },
    data() {
      return {
        showModify: this.value,
        loading: true,
        type: 'create',
        offerData: {
          name: {'en': '', 'ru': ''},
          content: {'en': '', 'ru': ''},
          country: null,
          city: null,
        }
      }
    },
    watch: {
      showModify(newVal, prevVal) {
        this.$emit('input', newVal)
      },
      offerCountry(newVal, prevVal) {
        if(!newVal)
          return;
        this.$store.dispatch('getCitiesForCountry', newVal)
          .then(({ data }) => {
            this.offerData.city = data.length ? data[0].id : null;
          })
      }
    },
    async mounted() {
      if(!this.$store.state.countries.length)
        await this.$store.dispatch('setCountries')
    },
    methods: {
      validateState(ref) {
        if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
          return !this.errors.has(ref);
        }
        return null
      },
      sendForm() {
        this.$validator.validateAll().then(result => {
          if (!result)
            return;
          let action = this.type === 'edit' ? 'editOffer' : 'createOffer';
          this.$store.dispatch('profile/'+action, this.offerData)
            .then((data) => {
              this.close();
              Message.success(this.$t('offers.message_success_'+this.type));

              if(this.type === 'create') {
                /*
                // отправляем запрос на создание счета
                this.$store.dispatch('profile/offerBillCreate', data.id)
                  .then((data) => {
                    this.$paymentModal.open({
                      bill: data,
                      title: this.$t('offers.pay_offer_publication'),
                    })
                  })
                  .catch((error) => {
                    Message.error('Error')
                  })
                  */
              }
            })
            .catch((error) => {
              Message.error('Error')
            })
        })
      },
      open(params={}) {
        this.showModify = true;
        if(params.type) {
          this.type = params.type;
        } else {
          this.type = 'create';
        }
        if(params.offer) {
          this.offerData = _.clone(params.offer);
        } else {
          this.offerData = {
            name: '',
            content: '',
            country: null,
            city: null,
          }
        }
      },
      close() {
        this.showModify = false;
      },
    }
  }
</script>
