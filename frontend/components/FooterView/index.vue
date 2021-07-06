<template>
  <div>
    <content-block
      v-if="showSeoBlock && showSeo"
      class="prefooter__seoblock"
      :slug="bottomSlug"
      :key="bottomSlug"
    />

    <footer id="footer" class="footer">
      <div class="footer__nav">
        <div class="container">
          <div class="row">
            <div class="col-6 col-md-6 col-sm-12">
              <div class="footer__nav-title">Mybestgigolo</div>

              <div class="row">
                <div class="col-6 col-md-6 col-sm-6">
                  <ul>
                    <li>
                      <router-link
                        :to="virginsPage"
                        :title="$t('links.home')"
                      >
                        {{ $t('links.home') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        :to="top50Page"
                        :title="$t('links.top50')"
                      >
                        {{ $t('links.top50') }}
                      </router-link>
                    </li>
                    <!--<li>
                      <router-link
                        :to="pornstarsPage"
                        :title="$t('links.pornstars')"
                      >
                        {{ $t('links.pornstars') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        :to="travelsPage"
                        :title="$t('links.travels')"
                      >
                        {{ $t('links.travels') }}
                      </router-link>
                    </li>-->
                  </ul>
                </div>
                <div class="col-6 col-md-6 col-sm-6">
                  <ul>
                    <!--<li>
                      <router-link
                        :to="datingPage"
                        :title="$t('links.dating')"
                      >
                        {{ $t('links.dating') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        :to="shemalesPage"
                        :title="$t('links.shemales')"
                      >
                        {{ $t('links.shemales') }}
                      </router-link>
                    </li>-->
                    <li>
                      <router-link
                        :to="videosPage"
                        :title="$t('links.videos')"
                      >
                        {{ $t('links.videos') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        :to="reviewsPage"
                        :title="$t('links.reviews')"
                      >
                        {{ $t('links.reviews') }}
                      </router-link>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-3 col-md-3 col-sm-12">
              <div class="footer__nav-title">{{ $t('footer.about_us') }}</div>
              <ul>
                <li>
                  <router-link
                    :to="localePath('terms')"
                    :title="$t('footer.terms_of_use')"
                  >
                    {{ $t('footer.terms_of_use') }}
                  </router-link>
                </li>
                <li>
                  <router-link
                    :to="localePath('privacy')"
                    :title="$t('footer.privacy_policy')"
                  >
                    {{ $t('footer.privacy_policy') }}
                  </router-link>
                </li>
              </ul>

            </div>
            <div class="col-3 col-md-3 col-sm-12" v-show="topCities.length">
              <div class="footer__nav-title">{{ $t('footer.popular_cities') }}</div>
              <ul>
                <li
                  v-for="(city,index) in topCities"
                  :key="index"
                >
                  <router-link
                    :to="localePath({name: countryCityName, params: {country: country.slug, city: city.slug}})"
                    :title="city.name"
                  >
                    {{ city.name }}
                  </router-link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="footer__copy">
        <div class="container">
          <div class="footer__copy-wrap">
            <div class="footer__copy-wrap">
              <router-link
                class="footer__copy-logo"
                :to="localePath('index')"
                :title="$t('titles.logo')"
              >
                <img
                  :src="cdn_assets_prefix + '/files/icons/svg/logo.svg'"
                  :alt="$t('alts.logo')"
                  :title="$t('titles.logo')"
                >
              </router-link>
              <div class="footer__copy-text">{{ $t('footer.copyright') }}</div>
            </div>
            <div class="footer__copy-payments">
              <img src="/files/icons/svg/icon--payments.svg" alt="">
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <!--
    <div>
    <div class="footer-info row">
      <div class="copyright" v-if="!showSeoBlock">
        MyBestGigolo.com © 2020 | The site is owned and operated by Barmao LTD. Trust Company Complex, Ajeltake Road, Ajeltake Island, MH96960, Majuro, Marshall Islands<br>
        All rights reserved!
        <div class="footer-links">
          <router-link :to="localePath('terms')">
            <span>{{ $t('footer.terms_of_use') }}</span>
          </router-link>
          <i class="fas fa-circle"></i>
          <router-link :to="localePath('privacy')">
            <span>{{ $t('footer.privacy_policy') }}</span>
          </router-link>
        </div>
      </div>
      <div class="footer-info-box row" v-if="showSeoBlock">
        <div class="footer-info-block col-md-12">
          <content-block :slug="bottomSlug" :key="bottomSlug"/>
        </div>
      </div>
    </div>
    <div class="copyright" v-if="showSeoBlock">
      MyBestGigolo.com © 2020 | The site is owned and operated by Barmao LTD. Trust Company Complex, Ajeltake Road, Ajeltake Island, MH96960, Majuro, Marshall Islands<br>
      All rights reserved!
      <div class="footer-links">
        <router-link :to="localePath('terms')">
          <span>{{ $t('footer.terms_of_use') }}</span>
        </router-link>
        <i class="fas fa-circle"></i>
        <router-link :to="localePath('privacy')">
          <span>{{ $t('footer.privacy_policy') }}</span>
        </router-link>
      </div>
    </div>
  </div>
  -->
</template>

<script>
  import ContentBlock from '~/components/ContentBlock'
  import { mapGetters } from 'vuex'

  export default {
    props: {
      showSeo: {
        type: Boolean,
        default: true
      }
    },
    components: {
      ContentBlock
    },

    computed: {
      ...mapGetters('auth', ['isAuthentificated', 'loggedUser', 'isGirl']),
      ...mapGetters('profile', ['independent_profile', 'client_profile']),
      ...mapGetters(['country', 'city']),
      topCities() {
        return this.country && this.country.cities ? [...this.country.cities].sort((a,b) => b.girls_count - a.girls_count).slice(0,4) : []
      },
      countryCityName() {
        if (this.section) {
          return this.section + '-country-city';
        }
        return 'country-city'
      },
      bottomSlug() {
        if (this.city && this.city.id) {
          return 'bottom_seo_city';
        }
        if (this.country && this.country.id){
          return 'bottom_seo_country';
        }
        return 'bottom_seo_main';
      },
      userName() {
        if(!this.isAuthentificated)
          return null;
        if(this.isGirl && this.independent_profile && this.independent_profile.name) {
          return this.independent_profile.name;
        }
        if(!this.isGirl && this.client_profile && this.client_profile.name) {
          return this.client_profile.name;
        }
        return null;
      },
      showSeoBlock() {
        return this.routes_show.indexOf(this.$route.name) !== -1;
      },
      virginsPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'country-city', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'country', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('index');
      },
      pornstarsPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'pornstars-country-city', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'pornstars-country', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('pornstars');
      },
      top50Page() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'country-city-top50', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'country-top50', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('top50');
      },
      travelsPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'country-city-travels', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'country-travels', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('travels');
      },
      vipPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'vip-country-city', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'vip-country', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('vip');
      },
      keptWomansPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'kept-womans-country-city', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'kept-womans-country', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('kept-womans');
      },
      shemalesPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'shemales-country-city', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'shemales-country', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('shemales');
      },
      datingPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'dating-country-city', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'dating-country', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('dating');
      },
      reviewsPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'country-city-reviews', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'country-reviews', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('reviews');
      },
      videosPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'country-city-videos', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'country-videos', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('videos');
      },
      agenciesPage() {
        if(this.$route.params.country) {
          if(this.$route.params.city) {
            return this.localePath({name: 'agencies-country-city', params: {country: this.$route.params.country, city: this.$route.params.city}})
          } else {
            return this.localePath({name: 'agencies-country', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('agencies');
      }
    },

    data() {
      return {
        routes_show: [
          'country-city___en', 'country-city___ru',
          'country___en', 'country___ru', 'index___en', 'index___ru',
          'country-city-virgins___en', 'country-city-virgins___ru',
        ],
      }
    },

    watch: {
      isAuthentificated: {
        immediate: true,
        handler: function (newVal, prevVal) {
          if(!process.server && process.env.production)
            this.$intercom.update(this.getDataForIntercom())
          if(!process.server && newVal)
            this.$ga.set('userId', this.loggedUser.id)
        }
      },
      $route(newVal, prevVal) {
        if(process.env.production)
          this.$intercom.update()
      }
    },

    methods: {
      getDataForIntercom() {
        if(this.isAuthentificated) {
          return {
            name: this.userName,
            email: this.loggedUser.email,
            user_id: this.loggedUser.id,
            user_hash: this.loggedUser.intercom_hash,
            hide_default_launcher: true,
          }
        }
        return {
          hide_default_launcher: true,
        }
      }
    },

    mounted() {
      if(process.env.production)
        this.$intercom.boot(this.getDataForIntercom())
      if(!process.server && this.isAuthentificated)
        this.$ga.set('userId', this.loggedUser.id)
    }
  }
</script>
