<template>
  <div>
    <div class="header__subtrate"></div>
    <email-confirm-modal/>
    <header id="header" class="header">
      <div class="container">
        <div class="header__top">
          <div class="header__logo logo">
            <router-link :to="localePath('index')">
              <img
                :src="cdn_assets_prefix + '/files/icons/svg/logo.svg'"
                :alt="$t('alts.logo')"
                :title="$t('titles.logo')"
              >
            </router-link>
          </div>
          <div class="header__search" @click="openSearchModal">
            <svg><use :xlink:href="cdn_assets_prefix + '/files/sprite.svg#icon--search'"/></svg>
            <ins>{{ $t('other.search') }}</ins>
          </div>
          <div class="mob-menu" @click="openMobileNav">
            <div id="hamburger__menu" class="hamburger__menu" :class="{animate: mobileNavShow}"></div>
          </div>
        </div>
        <div
          class="header__wrap"
          :class="{on: mobileNavShow}"
        >
          <div class="header__lang lang">
            <div class="header__lang-item"
                 :class="{active: locale.code == currentLocale.code}"
                 v-for="locale in availableLocales"
                 :key="locale.code"
                 :href="switchLocalePath(locale.code)"
                 @click.prevent="$router.push(switchLocalePath(locale.code))">
              {{ locale.code }}
            </div>
            <div>
              <div class="header__country">
                <div class="header__country-flag" v-if="country">
                  <img :src="`${cdn_assets}/img/countries/${country.code}.png`">
                </div>
                <div class="header__country-wrapper">
                  <div id="country" class="header__country-item" @click.prevent="openCountryModal">
                    <div
                      v-if="country"
                      class="header__country-title"
                    >
                      {{ country.name }}
                    </div>
                    <div
                      v-else
                      class="header__country-city"
                      @click="openCountryModal"
                    >
                      {{ $t('countries.select_country') }}
                    </div>
                    <span v-show="country">/</span>
                  </div>
                  <div id="city" v-show="country" class="header__country-item">

                    <div
                      class="header__country-city"
                      @click="openCityModal"
                    >
                      {{ city && city.name ? city.name :  $t('cities.select_city') }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div
            class="header__auth auth"
            v-if="!isAuthentificated"
          >
            <AppButton
                class="btn btn-header-singup"
                mode="custom"
                @click.native="$router.push(localePath('register'))"
            >
              {{ $t('auth.sign_up') }}
            </AppButton>
            <AppButton
                class="btn btn-header-singin"
                mode="custom"
                @click.native="$router.push(localePath('login'))"
            >
              {{ $t('auth.sign_in') }}
            </AppButton>
          </div>
          <div class="header__auth auth" v-else>
            <router-link
              :to="localePath('profile')"
              :title="$t('profile_nav.profile')"
              class="btn btn-header-singup"
            >
              {{ $t('profile_nav.profile') }}
            </router-link>
            <AppButton
              mode="custom"
              class="btn btn-header-singin"
              @click.native="logout"
              :title="$t('links.logout')"
            >
              {{ $t('links.logout') }}
            </AppButton>
          </div>
        </div>
      </div>
    </header>
    <nav
      class="nav"
      :style="{display: mobileNavShow ? 'block' : ''}"
    >
      <div class="container">
        <ul>
          <li>
            <router-link :to="virginsPage">
              {{ $t('links.home') }}
            </router-link>
          </li>
          <li>
            <router-link :to="top50Page">
              {{ $t('links.top50') }}
            </router-link>
          </li>
          <!--<li>
            <router-link :to="pornstarsPage">
              {{ $t('links.pornstars') }}
            </router-link>
          </li>-->
          <!--<li>
            <router-link :to="travelsPage">
              {{ $t('links.travels') }}
            </router-link>
          </li>-->
          <!--<li>
            <router-link :to="datingPage">
              {{ $t('links.dating') }}
            </router-link>
          </li>-->
          <!--<li>
            <router-link :to="shemalesPage">
              {{ $t('links.shemales') }}
            </router-link>
          </li>-->
          <li>
            <router-link :to="videosPage">
              {{ $t('links.videos') }}
            </router-link>
          </li>
          <li>
            <router-link :to="reviewsPage">
              {{ $t('links.reviews') }}
            </router-link>
          </li>
          <!--<li>
            <router-link :to="agenciesPage">
              {{ $t('links.agencies') }}
            </router-link>
          </li>-->
          <li v-if="isAdmin">
            <router-link :to="localePath('adminkas')">
              {{ $t('links.admin') }}
            </router-link>
          </li>
        </ul>
      </div>
    </nav>
  </div>
  <!--
  <header class="header row">
    <div class="col-3 p-0 d-md-none">
      <i class="fas fa-bars options_bar" @click="openMobileNav"></i>
    </div>
    <div class="col-md-3 col-5 logo-block">
      <router-link :to="localePath('index')" class="logo">
        <img :src="cdn_assets + '/img/logo.png'" class="img-responsive" alt="">
      </router-link>
    </div>
    <div class="col-md-8 col-3 profile_links_block">
      <a href="#" v-if="isAuthentificated" class="logout" @click.prevent="logout">
        <img :src="cdn_assets + '/img/logout.png'" alt="">
        <span class="d-none d-md-inline-block">{{ $t('links.logout') }}</span>
      </a>
      <div class="user">
        <router-link :to="localePath('profile')" v-if="isAuthentificated">
          <div class="profile-link">
            <img :src="cdn_assets + '/img/avatar.png'" alt="">
            <span class="d-none d-md-inline-block">{{ $t('links.open_profile') }}</span>
          </div>
        </router-link>
        <template v-else>
          <div class="profile-link d-md-none" @click="$loginModal.open">
            <img :src="cdn_assets + '/img/avatar.png'" alt="">
          </div>
          <b-btn size="sm" variant="primary" @click="$loginModal.open" class="d-none d-md-block">
            {{ $t('auth.sign_in') }}
          </b-btn>
        </template>
      </div>
    </div>
    <div class="col-md-1 lang-block d-none d-md-block">
      <b-dropdown class="lang-dropdown">
        <template slot="button-content">
          <img :src="cdn_assets + currentLocale.image">
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
    <div class="col-12 d-none d-md-block mb-3 mt-3">
      <nav class="nav text-center">
        <ul class="bd-navbar-nav mx-auto main-navbar">
          <li class="nav-item">
            <router-link :to="virginsPage">
              {{ $t('links.home') }}
            </router-link>
          </li>
          <!-<li class="nav-item">
            <router-link :to="pornstarsPage">
              {{ $t('links.pornstars') }}
            </router-link>
          </li>-->
          <!--<li class="nav-item">
            <router-link :to="travelsPage">
              {{ $t('links.travels') }}
            </router-link>
          </li>-->
          <!--<li class="nav-item">
            <router-link :to="datingPage">
              {{ $t('links.dating') }}
            </router-link>
          </li>--
          <li class="nav-item">
            <router-link :to="top50Page">
              {{ $t('links.top50') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="localePath('videos')">
              {{ $t('links.videos') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="localePath('reviews')">
              {{ $t('links.reviews') }}
            </router-link>
          </li>
          <li class="nav-item" v-if="isAdmin">
            <router-link :to="localePath('adminkas')">
              {{ $t('links.admin') }}
            </router-link>
          </li>
        </ul>
      </nav>
    </div>
    <mobile-nav ref="mobileNav"/>
  </header>
  -->
</template>

<script>
  import MobileNav from '~/components/MobileNav'
  import AppButton from '~/components/AppButton'
  import {mapGetters} from 'vuex'
  import {EventBus} from "~/utils/event-bus";

  export default {
    components: {
      MobileNav,
      AppButton
    },
    data() {
      return {
        login_modal_opened: false,
        cdn_assets: process.env.cdn_assets,
        mobileNavShow: false
      }
    },
    computed: {
      ...mapGetters('auth', [
        'isAuthentificated',
        'loggedUser',
        'isAdmin'
      ]),

      country() {
        return this.$store.getters.country
      },

      city() {
        return this.$store.getters.city
      },

      availableLocales() {
        return this.$i18n.locales//.filter(i => i.code !== this.$i18n.locale)
      },

      currentLocale() {
        return this.$i18n.locales.filter(i => i.code === this.$i18n.locale)[0]
      },

      virginsPage() {
        if(this.$route.params.city) {
          return this.localePath({name: 'country-city', params: {country: this.$route.params.country, city: this.$route.params.city }})
        }
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
        if(this.$route.params.city) {
          return this.localePath({name: 'country-city-top50', params: {country: this.$route.params.country, city: this.$route.params.city }})
        }
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
        if(this.$route.params.city) {
          return this.localePath({name: 'country-city-dating', params: {country: this.$route.params.country, city: this.$route.params.city }})
        }
        if(this.$route.params.country) {
          return this.localePath({name: 'country-dating', params: {country: this.$route.params.country }})
        }
        return this.localePath('dating');
      },
      reviewsPage() {
        if(this.$route.params.country) {
          if (this.$route.params.city) {
            return this.localePath({
              name: 'country-city-reviews',
              params: {country: this.$route.params.country, city: this.$route.params.city}
            })
          } else {
            return this.localePath({name: 'country-reviews', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('reviews');
      },
      agenciesPage() {
        if(this.$route.params.country) {
          if (this.$route.params.city) {
            return this.localePath({
              name: 'agencies-country-city',
              params: {country: this.$route.params.country, city: this.$route.params.city}
            })
          } else {
            return this.localePath({name: 'agencies-country', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('agencies');
      },
      videosPage() {
        if(this.$route.params.country) {
          if (this.$route.params.city) {
            return this.localePath({
              name: 'country-city-videos',
              params: {country: this.$route.params.country, city: this.$route.params.city}
            })
          } else {
            return this.localePath({name: 'country-videos', params: {country: this.$route.params.country}})
          }
        }
        return this.localePath('videos');
      }
    },

    methods: {
      logout() {
        this.$router.push(this.virginsPage);
        this.$store.dispatch('auth/logout')
      },
      openSearchModal(){
        this.$searchModal.open()
      },
      openMobileNav() {
        if(!this.mobileNavShow) {
          this.mobileNavShow = true
          $('body').addClass('nav-opened')
        } else {
          this.mobileNavShow = false
          $('body').removeClass('nav-opened')
        }
        //this.$refs.mobileNav.open()
      },
      openCountryModal() {
        this.$countryModal.open()
      },
      openCityModal() {
        this.$cityModal.open()
      }
    },
    mounted() {
      this.$router.beforeEach((from, to, next) => {
        if(this.mobileNavShow) {
          this.mobileNavShow = false
          $('body').removeClass('nav-opened')
        }
        next()
      })
    }
  }
</script>
