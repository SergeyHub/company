<template>
  <div>
    <modal id="country" v-model="showModify" class="country" size="lg" hide-header hide-footer	centered>

      <div class="country__wrap" v-if="showModify">
        <div class="country__search">
          <label>
            <input type="text" v-model="query" :placeholder="$t('countries.search')">
          </label>
        </div>
        <div class="country__search-result">
          <div class="country__search-result-row">
            <div class="country__search-result-col" v-for="(countries_chunk, index) in countriesChunks" :key="index">
              <ul>
                <li v-for="country_field in countries_chunk"
                    :key="country_field.id"
                    :class="{'active-country': country && country.id === country_field.id}"
                >
                  <a
                    :href="localePath({name: countryName, params: {country: country_field.slug, geography: geography ? geography.slug : null }})"
                    @click.prevent="selectCountry(country_field.slug)"
                    :title="country_field.name"
                  >
                    <div class="country__item">
                      <div class="country__item-title">
                        <div class="country__item-flag" v-if="country_field.code">
                          <img v-lazy="cdn_assets + '/img/countries/'+country_field.code+'.png'">
                        </div>
                        <div class="country__item-name">{{ country_field.name }}</div>
                      </div>
                      <div class="country__item-count">{{ country_field.girls_count }}</div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </modal>
  </div>
  <!--<div>
    <modal v-model="showModify" class="countries-modal" size="lg" hide-header hide-footer	centered>
      <b-row slot="header">
        <b-col lg="10" cols="10">
          <input type="text" class="form-control" v-model="query" :placeholder="$t('countries.search')                                                                          ">
        </b-col>
      </b-row>
      <div class="row">
        <div class="col-md-4 location__countries" v-for="(countries_chunk, index) in countriesChunks" :key="index">
          <ul>
            <li v-for="country_field in countries_chunk"
                :key="country_field.id"
                :class="{'active-country': country && country.id === country_field.id}">
              <a :href="localePath({name: countryName, params: {country: country_field.slug, geography: geography ? geography.slug : null }})" @click.prevent="selectCountry(country_field.slug)">
                <div class="country-flag" v-if="country_field.code">
                  <img :src="cdn_assets + '/img/countries/'+country_field.code+'.png'">
                </div>
                {{ country_field.name }}
                <span class="girls_count">{{ country_field.girls_count }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </modal>
  </div>-->
</template>

<script>
  import { mapGetters } from 'vuex'
  import Modal from "../Modal";
  import CountryModal from '~/components/CountryModal'

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
      ...mapGetters(['countries', 'country', 'geography']),
      ...mapGetters('girls', ['section']),
      countriesChunks() {
        var countries = this.countries;
        if(this.query) {
          var regex = new RegExp(this.query, "i");
          countries = countries.filter(country => regex.test(country.name));
        }
        return _.chunk(Object.values(countries), 60);
      },
      countryName() {
        if (this.section) {
          return 'country-' + this.section + (this.$route.params.geography ? '-geography' : '');
        }
        return 'country'
      },
      countryCityName() {
        if (this.section) {
          return 'country-city-' + this.section;
        }
        return 'country-city'
      }
    },
    methods: {
      async open() {
        this.showModify = true;
        await this.$store.dispatch('setCountries', this.section)
      },
      close() {
        this.showModify = false
      },
      generateCountryLink(slug) {
        return 'https://' + slug + '.' + process.env.base_domain + (this.$i18n.locale !== 'en' ? '/' + this.$i18n.locale : '');
      },
      selectCountry(slug) {
        this.$router.push(this.localePath({name: this.countryName, params: {country: slug, geography: this.geography ? this.geography.slug : null }}));
        //let country = this.countries.find(country => country.slug == slug)
        //this.$store.commit('SET_CURRENT_COUNTRY', country.id)
        //this.$store.dispatch('fetchTopCities', country.id)
        this.$cityModal.open()
        this.close()
      },
    },
    beforeMount() {
      CountryModal.EventBus.$on('open', (params) => {
        this.open(params)
      })
    }
  }
</script>

<style>
  .location__countries {
    border: solid #e5e5e5;
    border-width: 0 1px 0 0px;
  }
  .location__countries ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .location__countries ul li a {
    position: relative;
    display: block;
    overflow: hidden;
    padding: 8px 30px 8px 35px;
    font-size: 18px;
    line-height: 20px;
    color: #1c1c1c;
    text-decoration: none;
    margin-left: -1px;
  }
  .location__countries ul li a .country-flag {
    font-style: normal;
    position: absolute;
    color: #a2a2a2;
    left: 5px;
    top: 6px;
    font-weight: normal;
  }
  .location__countries ul li a .country-flag img {
    width: 20px;
  }
  .location__countries .active-country {
    font-weight: bold;
  }
  .location__countries .girls_count {
    position: absolute;
    right: 0;
    font-size: 16px;
    color: #ccc
  }
</style>
