<template>
  <div>
    <ul class="countries-menu">
      <li v-for="country in countries_first_five" :key="country.slug">
        <div class="country-row" :class="{current_country: country_global && country_global.id===country.id}">
          <router-link :to="localePath({name: countryName, params: {country: country.slug, geography: geography ? geography.slug : null }})" :title="country.name">
            <div class="country-flag" v-if="country.code">
              <img :src="cdn_assets + '/img/countries/'+country.code+'.png'">
            </div>
            {{ country.name }}
            <span>({{ country.girls_count }})</span>
          </router-link>
        </div>
        <!--<b-collapse :visible="country_global && country_global.id===country.id" tag="ul"
                    v-if="country.cities && country.cities.length && !hideCities"
                    :id="'collapse-'+country.slug"
                    class="countries-menu_cities">
          <li v-for="city in country.cities" :key="city.slug">
            <router-link :to="localePath({name: countryCityName, params: {country: country.slug, city: city.slug}})"
                         :title="city.name">
              {{ city.name }}
              <span>({{ city.girls_count }})</span>
            </router-link>
          </li>
        </b-collapse>-->
      </li>
    </ul>
    <AppButton mode="dark" @click.native="openModal">
      {{ $t('countries.more_countries') }}
    </AppButton>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  //import BCollapse from "bootstrap-vue/src/components/collapse/collapse";
  import AppButton from '~/components/AppButton'

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
    components: { AppButton },
    computed: {
      ...mapGetters(['countries', 'top_countries', 'geography']),
      ...mapGetters('girls', ['section']),
      hideCities() {
        if (this.section) {
          return this.section == 'travels' || this.section == 'agencies' ? true : false;
        }
        return false;
      },
      country_global() {
        return this.$store.getters.country;
      },
      countries_first_five() {
        if(this.country_global)
          return [this.country_global, ...this.top_countries.filter(el => el.id !== this.country_global.id)];
        return this.top_countries;
      },
      countryName() {
        if (this.section && this.withFilterSection) {
          return 'country-' + this.section + (this.$route.params.geography ? '-geography' : '');
        }
        return 'country'
      },
      withFilterSection() {
        return sectionsArr.includes(this.section);
      },
      countryCityName() {
        if (this.section) {
          return 'country-city-' + this.section;
        }
        return 'country-city'
      }
    },
    data() {
      return {
        cdn_assets: process.env.cdn_assets
      }
    },
    methods: {
      generateCountryLink(slug) {
        return 'https://' + slug + '.' + process.env.base_domain + (this.$i18n.locale !== 'en' ? '/' + this.$i18n.locale : '');
      },
      generateCityLink(country_slug, city_slug) {
        return this.generateCountryLink(country_slug) + '/' + city_slug;
      },
      openModal() {
        this.$countryModal.open();
      },
      setCountries() {
        let section = this.withFilterSection ? this.section : 'girls'
        this.$store.dispatch('setTopCountries', section)
        if (this.$route.params.country) {
          this.$store.dispatch('fetchAndSetCountry', {
            slug: this.$route.params.country,
            section: section
          });
        }
      }
    },
    watch: {
      $route (to, from){
        this.setCountries();
      },
    },
    mounted() {
      this.setCountries();
    }
  }
</script>

<style>
  .countries-block-wrapper {
    border-right: 1px solid rgba(0,0,0,0.05);
    padding: 0 20px 20px 0;
  }
  .countries-menu {
    list-style-type: none;
    margin: 10px 10px 20px 7px;
    padding: 0;
  }
  .countries-menu li {
    padding: 5px 0 5px 0px;
    border-bottom: 1px solid #e7e7e7;
  }
  .countries-menu li:last-child {
    border-bottom: none;
  }
  .country-row {
    display: flex;
    align-items: center;
  }
  .country-row.current_country {
    font-weight: bold;
  }
  .country-row.current_country a span {
    font-weight: normal;
  }
  .country-row i {
    flex-basis: 10%;
    font-size: 12px;
  }
  .countries-menu li a {
    flex-basis: 100%;
    position: relative;
    display: flex;
    font-size: 0.9em;
    color: #484949;
    overflow: hidden;
    padding: 2px 0px 0px 35px;
    text-decoration: none;
    margin-left: -1px;
  }
  .countries-menu li a .country-flag {
    font-style: normal;
    position: absolute;
    color: #a2a2a2;
    left: 5px;
    top: 0px;
    font-weight: normal;
  }
  .countries-menu li a .country-flag img {
    width: 20px;
  }
  .countries-menu li a span {
    position: absolute;
    right: 0px;
    font-size: 12px;
    color: #999999;
    top: 1px;
  }
  .countries-menu_cities {
    margin-top: 5px;
    list-style-type: none;
    margin-left: 0px;
    padding: 0;
  }
  .countries-menu_cities li {
    padding: 0px 0px 5px 15px;
    border: none;
  }
  .countries-menu_cities li a {
    padding: 2px 0px 0px 21px;
  }
</style>
