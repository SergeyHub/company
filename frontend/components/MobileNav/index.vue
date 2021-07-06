<template>
  <div>
    <modal v-model="showModify" class="countries-modal mobile-nav" size="lg" hide-header hide-footer	centered>
      <a href="/" class="logo nuxt-link-exact-active nuxt-link-active mb-3">
        <img :src="cdn_assets + '/img/logo.png'" alt="" class="img-responsive">
      </a>
      <div class="row">
        <div class="col-md-12 location__countries">
          <ul>
            <li class="nav-item">
              <a href="#"  @click.prevent="routeAndClose(localePath('index'))">
                {{ $t('links.home') }}
              </a>
            </li>
            <li class="nav-item">
              <a href="#" @click.prevent="routeAndClose(pornstarsPage)">
                {{ $t('links.pornstars') }}
              </a>
            </li>
            <li class="nav-item">
              <a href="#" @click.prevent="routeAndClose(travelsPage)">
                {{ $t('links.travels') }}
              </a>
            </li>
            <li class="nav-item">
              <a href="#" @click.prevent="routeAndClose(datingPage)">
                {{ $t('links.dating') }}
              </a>
            </li>
            <li class="nav-item">
              <a href="#" @click.prevent="routeAndClose(localePath('videos'))">
                {{ $t('links.videos') }}
              </a>
            </li>
            <li class="nav-item">
              <a href="#" @click.prevent="routeAndClose(top50Page)">
                {{ $t('links.top50') }}
              </a>
            </li>
            <li class="nav-item">
              <a href="#" @click.prevent="routeAndClose(localePath('reviews'))">
                {{ $t('links.reviews') }}
              </a>
            </li>
            <li class="nav-item">
              <a href="#" @click.prevent="routeAndClose(localePath('adminkas'))" v-if="isAdmin">
                {{ $t('links.admin') }}
              </a>
            </li>
          </ul>
        </div>
        <div class="col-md-12 mt-5">
          <ul class="countries-menu">
            <li v-for="country in countries_first_five" :key="country.slug">
              <div class="country-row" :class="{current_country: country_global && country_global.id===country.id}">
                <a href="#" @click.prevent="routeAndClose(localePath({name: countryName, params: {country: country.slug, geography: geography ? geography.slug : null }}))" :title="country.name">
                  <div class="country-flag" v-if="country.code">
                    <img :src="cdn_assets + '/img/countries/'+country.code+'.png'">
                  </div>
                  {{ country.name }}
                  <span>({{ country.girls_count }})</span>
                </a>
              </div>
              <b-collapse :visible="country_global && country_global.id===country.id" tag="ul"
                          v-if="country.cities && country.cities.length && !travelSection"
                          :id="'collapse-'+country.slug"
                          class="countries-menu_cities">
            <li v-for="city in country.cities" :key="city.slug">
            <a href="#" @click.prevent="routeAndClose(localePath({name: countryCityName, params: {country: country.slug, city: city.slug}}))"
                           :title="city.name">
                {{ city.name }}
                <span>({{ city.girls_count }})</span>
              </a>
            </li>
            </b-collapse>
            </li>
          </ul>
          <b-button variant="primary" @click="openCountriesModal">
            {{ $t('countries.more_countries') }}
          </b-button>
        </div>
        <div class="col-md-12 mt-5 text-center">
          {{ $t('other.language') }}:
          <b-dropdown class="lang-dropdown" style="width: auto">
            <template slot="button-content">
              <img v-bind:src="cdn_assets + currentLocale.image">
              <span style="color:#000;font-size:15px;margin-left: 5px">
                {{ currentLocale.name }}
              </span>
            </template>
            <b-dropdown-item v-for="locale in availableLocales"
                             :key="locale.code"
                             :href="switchLocalePath(locale.code)"
                             @click.prevent="$router.push(switchLocalePath(locale.code))">
              <img v-bind:src="cdn_assets + locale.image">
              {{ locale.name }}
            </b-dropdown-item>
          </b-dropdown>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  //import BAlert from "bootstrap-vue/src/components/alert/alert";
  import Modal from "../Modal";

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
      ...mapGetters(['countries', 'top_countries']),
      ...mapGetters('auth', [
        'isAuthentificated',
        'loggedUser',
        'isAdmin'
      ]),
      ...mapGetters('girls', ['section']),
      travelSection() {
        if (this.section) {
          return this.section == 'travels' ? true : false;
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
      },
      availableLocales() {
        return this.$i18n.locales.filter(i => i.code !== this.$i18n.locale)
      },
      currentLocale() {
        return this.$i18n.locales.filter(i => i.code === this.$i18n.locale)[0]
      },
      virginsPage() {
        if(this.$route.params.country) {
          return this.localePath({name: 'country', params: {country: this.$route.params.country }})
        }
        return this.localePath('index');
      },
      pornstarsPage() {
        if(this.$route.params.country) {
          return this.localePath({name: 'country-pornstars', params: {country: this.$route.params.country }})
        }
        return this.localePath('pornstars');
      },
      top50Page() {
        if(this.$route.params.country) {
          return this.localePath({name: 'country-top50', params: {country: this.$route.params.country }})
        }
        return this.localePath('top50');
      },
      travelsPage() {
        if(this.$route.params.country) {
          return this.localePath({name: 'country-travels', params: {country: this.$route.params.country }})
        }
        return this.localePath('travels');
      },
      vipPage() {
        if(this.$route.params.country) {
          return this.localePath({name: 'country-vip', params: {country: this.$route.params.country }})
        }
        return this.localePath('vip');
      },
      keptWomansPage() {
        if(this.$route.params.country) {
          return this.localePath({name: 'country-kept-womans', params: {country: this.$route.params.country }})
        }
        return this.localePath('kept-womans');
      },
      shemalesPage() {
        if(this.$route.params.country) {
          return this.localePath({name: 'country-shemales', params: {country: this.$route.params.country }})
        }
        return this.localePath('shemales');
      },
      datingPage() {
        if(this.$route.params.country) {
          return this.localePath({name: 'country-dating', params: {country: this.$route.params.country }})
        }
        return this.localePath('dating');
      }
    },
    methods: {
      generateCountryLink(slug) {
        return 'https://' + slug + '.' + process.env.base_domain + (this.$i18n.locale !== 'en' ? '/' + this.$i18n.locale : '');
      },
      generateCityLink(country_slug, city_slug) {
        return this.generateCountryLink(country_slug) + '/' + city_slug;
      },
      open() {
        this.showModify = true;
      },
      close() {
        this.showModify = false
      },
      routeAndClose(route) {
        this.close();
        this.$router.push(route)
      },
      openCountriesModal() {
        this.close();
        this.$countryModal.open();
      }
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
  .mobile-nav .location__countries ul li a {
    position: relative;
    display: block;
    overflow: hidden;
    padding: 8px 0px 8px 10px;
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
  .location__countries ul li a .country-flag.with_icon {
    left: 15px;
    top: 8px;
  }
  .location__countries ul li a .country-flag img {
    width: 20px;
  }
  .active-country {
    font-weight: bold;
  }
</style>
