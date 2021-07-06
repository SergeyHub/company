<template>
  <div>
    <breadcrumbs :items="breadcrumbs"/>
    <heading-seo/>
    <girl-placeholders v-if="loading"/>
    <b-row v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="30" v-else>
      <geographies-block/>
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
</template>

<script>
  import {mapGetters} from 'vuex'
  import ModelBlock from '~/components/ModelBlock'
  import GirlPlaceholders from '~/components/GirlPlaceholders'
  import CountriesBlock from '~/components/CountriesBlock'
  import Breadcrumbs from '~/components/Breadcrumbs'
  import HeadingSeo from '~/components/HeadingSeo'
  import BButton from "bootstrap-vue/src/components/button/button";
  import GeographiesBlock from '~/components/GeographiesBlock'

  export default {
    components: {
      BButton,
      Breadcrumbs,
      ModelBlock,
      GirlPlaceholders,
      CountriesBlock,
      HeadingSeo,
      GeographiesBlock
    },
    computed: {
      ...mapGetters('girls', ['girls', 'params']),
      ...mapGetters(['country'])
    },
    data() {
      return {
        loading: true,
        busy: true,
        page: 1,
        breadcrumbs: [{
          text: this.$t('titles.travels')
        }]
      }
    },
    // head() {
    //   let title = this.$t('titles.travels');
    //   return {
    //     title: title
    //   }
    // },
    asyncData({store}) {
      store.dispatch('girls/resetGirls');
      store.dispatch('girls/setCurrentSection', 'travels');
      let params = {};
      if (store.state.country) {
        params.country = store.state.country.id
      }
      return store.dispatch('girls/fetchTravelGirls', params)
        .then((response) => {
          return {
            loading: false,
            busy: response.meta.last_page == 1,
            last_page: response.meta.last_page,
            total: response.meta.total,
          }
        })
    },
    methods: {
      loadMore() {
        this.busy = true;
        if (this.page == this.last_page)
          return;

        this.page++;
        let params = {page: this.page};
        if (this.$store.state.country)
          params.country = this.$store.state.country.id;

        this.$store.dispatch('girls/fetchTravelGirls', params)
          .then((response) => {
            this.busy = false;
          })
      }
    }
  }
</script>

<style>
  .girl-placeholder .vue-content-placeholders-img {
    height: 400px;
  }
</style>
