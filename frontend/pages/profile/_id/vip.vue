<template>
  <div>
    <girl-nav/>
    <section>
      <div class="premium">
        <div class="premium-wrap">
          <div class="container">
            <h1 class="mb-50">{{ $t('profile_vip.title') }}</h1>
            <!--<h3>Настоящие отзывы от реальных пользователей о парнях и моделях, которые разместили свои анкеты на сайте mybestgigolo.com.</h3>-->

            <div class="row">
              <div class="col-6 col-md-6 col-xs-12">
                <p>{{ $t('profile_vip.description_1') }}</p>
              </div>
              <div class="col-6 col-md-6 col-xs-12">
                <p>{{ $t('profile_vip.description_2') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="container">
        <div class="pricing__switch">
          <ul class="pricing__switch-wrap">
            <li>
              <div
                class="pricing__switch-item pricing__switch-mont"
                :class="{ 'pricing__switch-active': priceType == 'month' }"
                @click="priceType = 'month'"
              >
                {{ $t('profile_vip.month') }}
              </div>
            </li>
            <li>
              <div
                class="pricing__switch-item pricing__switch-year"
                :class="{ 'pricing__switch-active': priceType == 'year' }"
                @click="priceType = 'year'"
              >
                {{ $t('profile_vip.year') }}
              </div>
            </li>
            <!--<div class="pricing__switch-overlay"></div>-->
          </ul>
        </div>
        <div class="pricing__grid">
          <div
            v-for="tariff in vip_tariffs"
            :key="tariff.id"
            :class="{ 'pricing__grid-active': tariff.popular || 1 }"
            class="pricing__grid-item"
          >
            <div class="pricing__grid-item-hit">{{ $t('profile_vip.most_popular') }}</div>
            <div>
              <div class="pricing__grid-item-price">
                <span
                  class="price price-mont"
                  :class="{ ' price-active': priceType == 'month' }"
                >
                    $<ins>{{ tariff.month_cost }}</ins>
                </span>
                <span
                  class="price price-year"
                  :class="{ ' price-active': priceType == 'year' }"
                >
                    $<ins>{{ tariff.year_cost }}</ins>
                </span>
                <span class="symbol">
                    /<small>{{ priceType == 'month' ? $t('profile_vip.month') : $t('profile_vip.year') }}</small>
                </span>
              </div>
              <div class="pricing__grid-item-name">{{ tariff.name }}</div>
              <div class="pricing__grid-item-desc">{{ tariff.description }}</div>
              <div class="pricing__grid-item-edge">
                <ul>
                  <li>{{ $t('profile_vip.advantage_1') }}</li>
                  <li>{{ $t('profile_vip.advantage_2') }}</li>
                  <li>{{ $t('profile_vip.advantage_3') }}</li>
                  <li>{{ $t('profile_vip.advantage_4') }}</li>
                </ul>
              </div>
            </div>
            <div class="pricing__grid-item-choice">
              <button
                @click.prevent="startPayment(tariff.id)"
                class="btn btn-radius"
              >{{ $t('profile_vip.select_plan') }}</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import GirlNav from '~/components/GirlNav'
import { mapGetters } from 'vuex'

export default {
  layout: 'profile',

  components: {
    GirlNav
  },

  computed: {
    ...mapGetters('girls', ['vip_tariffs', 'current_girl'])
  },

  data() {
    return {
      priceType: 'month'
    }
  },

  async asyncData({ store, params }) {
    return store.dispatch('girls/fetchEditGirl', params.id)
      .then((data) => {
        if(data.country) {
          return Promise.resolve(
            store.dispatch('girls/fetchVipTariffs'),
            store.dispatch('getCitiesForCountry', data.country)
          )
            .then(() => {
              return {
                form: _.cloneDeep(data)
              }
            })
            .catch(() => {
              return {
                form: _.cloneDeep(data)
              }
            })
        }
        return {
          form: _.cloneDeep(data)
        }
      })
  },
  created() {
    this.$store.dispatch('girls/fetchVipTariffs')
  },
  methods: {

    startPayment(tariff_id) {
      let params = {
        tariff_id: tariff_id,
        cost_type: this.priceType,
        girl_id: this.current_girl.id
      }

      this.$store.dispatch('girls/getVipPaymentLink', params)
      .then((data) => {
        window.location.href = data.link
      })
      .catch(e => console.log(e))
    }
  }

}
</script>
