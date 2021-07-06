<template>
  <modal id="city" v-model="showModify" class="country" size="lg" hide-header hide-footer	centered v-if="country">

    <div class="country__wrap">
      <div class="country__search">
        <div class="country__search-title">
          <span>{{ $t('cities.select_city_in') }} {{ country.name }}</span>

          <a
            @click.prevent="changeCountry()"
            class="edit-country"
          >
            {{ $t('cities.change_country') }}
          </a>
        </div>
        <label>
          <input type="text" v-model="query" :placeholder="$t('cities.search')">
        </label>
      </div>
      <div class="country__search-result">
        <div class="country__search-result-row">
          <div class="country__search-result-col" v-for="(cities_chunk, index) in citiesChunks" :key="index">
            <ul>
              <li v-for="city_field in cities_chunk"
                  :key="city_field.id"
                  :class="{'active-country': city && city.id === city_field.id}"
              >
                <a
                  @click="selectCity(city_field.slug)"
                  :to="localePath({name: countryCityName, params: {country: country.slug, city: city_field.slug}})"
                  :title="city_field.name"
                >
                  <div class="country__item">
                    <div class="country__item-title">
                      <div class="country__item-name">{{ city_field.name }}</div>
                    </div>
                    <div class="country__item-count">{{ city_field.girls_count }}</div>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </modal>
  <!--<modal id="city" v-model="showModify" class="country" size="lg" hide-header hide-footer	centered v-if="country">

    <div class="country__wrap">
      <div class="country__search">
        <div class="country__search-title">
          <span>{{ $t('cities.select_city_in') }} {{ country.name }}</span>

          <a
            @click.prevent="changeCountry()"
            class="edit-country"
          >
            {{ $t('cities.change_country') }}
          </a>
        </div>
        <label>
          <input type="text" v-model="query" :placeholder="$t('cities.search')">
        </label>
      </div>
      <div class="country__search-result">
        <div class="country__search-result-row">
          <div class="country__search-result-col" v-for="(cities_chunk, index) in citiesChunks" :key="index">
            <ul>
              <li v-for="city_field in cities_chunk"
                  :key="city_field.id"
                  :class="{'active-country': city && city.id === city_field.id}"
              >
                <a
                  @click="selectCity(city_field.slug)"
                  :to="localePath({name: countryCityName, params: {country: country.slug, city: city_field.slug}})"
                  :title="city_field.name"
                >
                  <div class="country__item">
                    <div class="country__item-title">
                      <div class="country__item-name">{{ city_field.name }}</div>
                    </div>
                    <div class="country__item-count">{{ city_field.girls_count }}</div>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </modal>-->
</template>

<script>
  import { mapGetters } from 'vuex'
  import Modal from "../Modal";
  import CityModal from '~/components/CityModal'
  // Секции в которых есть фильтрация по городам
  let sectionsArr = [
    'girls',
    'pornstars',
    'top50',
    'travels',
    'vip',
    'kept-womans',
    'dating',
    'shemales',
    'reviews',
    'agencies'
  ]
  export default {
    components: {Modal},
    props: {
      value: {
        type: Boolean,
        default: () => false
      }
    },
    data() {
      return {
        query: '',
        showModify: this.value,
        cdn_assets: process.env.cdn_assets
      }
    },
    watch: {
      showModify(newVal, prevVal) {
        this.$emit('input', newVal)
      },
      value(newVal, prevVal) {
        this.showModify = newVal
      }
    },
    computed: {
      ...mapGetters(['city', 'geography', 'country']),
      ...mapGetters('girls', ['section']),
      citiesChunks() {
        var cities = this.country.cities;
        if(typeof cities !== 'object' || !cities.length) cities = []
        if(this.query) {
          var regex = new RegExp(this.query, "i");
          cities = cities.filter(city => regex.test(city.name));
        }

        return _.chunk(Object.values(cities), 60);
      },
      cityName() {
        if (this.section && this.withFilterSection) {
          if (this.$route.params.geography && this.section == 'travels') {
            return 'city-' + this.section + (this.$route.params.geography ? '-geography' : '');
          }
          if (this.section == 'travels') {
            return 'city-' + this.section
          }
          return this.section + '-city'
        }
        return 'city'
      },
      withFilterSection() {
        return sectionsArr.includes(this.section);
      },
      countryCityName() {
        if (this.section) {
          if(this.section == 'travels') {
            if(this.$route.params.country) {
              return 'country-city-' + this.section + (this.$route.params.geography ? '-geography' : '');
            }
            return this.section + (this.$route.params.geography ? '-geography' : '');
          }
          return 'country-city-' + this.section;
        }
        return 'country-city'
      }
    },
    methods: {
      async open() {
        this.showModify = true;

        //await this.$store.dispatch('getCitiesForCountry', this.country.id)
      },
      close() {
        this.showModify = false
      },
      generateCityLink(slug) {
        return 'https://' + slug + '.' + process.env.base_domain + (this.$i18n.locale !== 'en' ? '/' + this.$i18n.locale : '');
      },
      selectCity(slug) {
        this.$router.push(this.localePath({name: this.countryCityName, params: {country: this.country.slug, city: slug}}))
        //this.$router.push(this.localePath({name: this.cityName, params: {city: slug, geography: this.geography ? this.geography.slug : null }}));
        this.close()
      },
      changeCountry() {
        this.$countryModal.open()
        this.close()
      }
    },
    beforeMount() {
      CityModal.EventBus.$on('open', (params) => {
        this.open(params)
      })
    }
  }
</script>

