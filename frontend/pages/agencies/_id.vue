<template>
  <div class="mt-3 overflow-hidden">
    <div class="body-container-content">
      <div class="homepagetitle agency-title">

       <h1 class="header-title text-center"><span itemprop="name">{{agency.name}}</span></h1>
      </div>

      <div class="profile-details">
        <div class="logo">
          <img :src="agency.avatar" :alt="agency.name">
        </div>

        <div class="text-center mt-4" style="display: block;">{{agency.description}}</div>

        <div class="badges">
            <span class="agency-badge more-girls-badge">{{$t('agencies.girls')}}: {{agency.girls.length}}</span>
        </div>
        <phone-block></phone-block>
        <working-geographies></working-geographies>
        <profile-site v-if="siteExist" />
        <h4 class="text-center mt-4 mb-4">{{ $t('agencies.girls_title') }}</h4>
        <girl-placeholders v-if="loading"/>
        <b-row v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="30" v-else>
          <b-col cols="6" md="4" v-for="model in girls" :key="'girl/'+model.id">
            <model-block :model="model"/>
          </b-col>
          <b-col class="text-center" v-if="total == 0">
            {{ $t('errors.models_not_found') }}
          </b-col>
        </b-row>
        <b-button variant="primary" @click="loadMore" v-if="!busy">
          {{ $t('other.load_more') }}
        </b-button>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import { Message } from 'element-ui'
  import ModelBlock from '~/components/ModelBlock'

  import PhoneBlock from '~/components/AgencyProfileBlocks/PhoneBlock'
  import WorkingGeographies from '~/components/AgencyProfileBlocks/WorkingGeographies'
  import GirlPlaceholders from '~/components/GirlPlaceholders'
  import ProfileSite from '~/components/AgencyProfileBlocks/ProfileSite'

  export default {
    components: {
      PhoneBlock,
      ModelBlock,
      WorkingGeographies,
      GirlPlaceholders,
      ProfileSite
    },
    // head() {
    //   let title =  this.$t('titles.agency') + ' ' +  this.agency.name;
    //
    //   return {
    //     title: title,
    //     meta: [
    //       {name: 'og:title', content: title},
    //     ]
    //   }
    // },
    data() {
      return {
        loading: true,
        busy: true,
        page: 1,
      }
    },
    computed: {
      ...mapGetters('agencies', ['agency']),
      ...mapGetters('girls', ['girls']),
      siteExist() {
        return this.agency.profile_site;
      }
    },
    async asyncData({ store, params, error }) {
      try {
        await store.dispatch('girls/setCurrentSection', 'agencies');
        await store.dispatch('agencies/fetchAgency', params.id)
        store.dispatch('girls/resetGirls');
        let paramsGirl = {agency: params.id};
        return await store.dispatch('girls/fetchGirls', paramsGirl)
          .then((response) => {
            return {
              loading: false,
              busy: response.meta.last_page == 1,
              last_page: response.meta.last_page,
              total: response.meta.total,
            }
          })
      } catch (e) {
        error({ statusCode: 404, message: e.message })
      }
    },
    methods: {
      loadMore() {
        this.busy = true;
        if (this.page == this.last_page)
          return;

        this.page++;
        let paramsGirl = {page: this.page, agency: this.agency.id};

        this.$store.dispatch('girls/fetchGirls', paramsGirl)
          .then((response) => {
            this.busy = false;
          })
      }
    },
  }
</script>
<style type="text/css">
  .homepagetitle {
    width: 100%;
    margin: 10px 0 11px;
  }
  h1 {
    font-size: 55px;
    font-weight: 700;
    color: #333a3f;
    text-align: center;
    line-height: 55px;
    padding: 0 10px;
  }
  .profile-details .logo {
    text-align: center;
  }
  .agency-badge {
    padding: 4px 6px;
    margin: 0 2px;
    border-radius: 2px;
    color: #fff;
    font-size: 13px;
    font-family: Helvetica,Arial,sans-serif;
    font-weight: 700;
    background-color: #6b737a;
  }
  .badges {
    text-align: center;
    margin: 10px 0 25px;
  }
</style>
