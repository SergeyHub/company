<template>
  <div>
    <breadcrumbs :items="breadcrumbs"/>
    <heading-seo/>
    <div class="feed agencies-container" infinite-scroll-disabled="loading" infinite-scroll-distance="30">
      <agency-block :agency="agency" v-for="(agency, index) in agencies" :key="'agency/'+index"></agency-block>
      <div class="col-md-12 text-center" v-if="total===0">
        {{ $t('errors.agencies_not_found') }}
      </div>
    </div>
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
  import AgencyBlock from '~/components/AgencyBlock'
  import Breadcrumbs from '~/components/Breadcrumbs'
  import HeadingSeo from '~/components/HeadingSeo'
  import BButton from "bootstrap-vue/src/components/button/button";

  export default {
    components: {
      BButton,
      Breadcrumbs,
      ModelBlock,
      GirlPlaceholders,
      CountriesBlock,
      HeadingSeo,
      AgencyBlock
    },
    computed: {
      ...mapGetters('girls', ['params', 'section']),
      ...mapGetters('agencies', ['agencies']),
      ...mapGetters(['country']),
    },
    data() {
      return {
        loading: true,
        busy: true,
        page: 1,
        breadcrumbs: [{
          text: this.$t('titles.agencies')
        }]
      }
    },
    // head() {
    //   let title = this.$t('titles.title_agencies_country');
    //   title = title.replace(/%country%/gi, (this.country ? (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : ''));
    //   let description = this.$t('descriptions.agencies_country');
    //   description = description.replace(/%country%/gi, (this.country ? (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : ''));
    //   return {
    //     title: title,
    //     meta: [
    //       { hid: 'description', name: 'description', content: description }
    //     ]
    //   }
    // },
    async asyncData({ store, params, error }) {
      await store.dispatch('agencies/resetAgencies');
      await store.dispatch('girls/setCurrentSection', 'agencies');
      if(!store.state.country || store.state.country.slug !== params.country) {
        try {
          await store.dispatch('fetchAndSetCountry', {
            slug: params.country,
            section: 'agencies'
          });
        } catch (err) {
          return error({statusCode: 404, message: err.message})
        }
      }
      let filter_params = {};
      if (store.state.country) {
        filter_params.country = store.state.country.id
      }
      let response = await store.dispatch('agencies/fetchAgencies', filter_params)
      return {
        loading: false,
        busy: response.meta.last_page == 1,
        last_page: response.meta.last_page,
        total: response.meta.total,
      }
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

        this.$store.dispatch('agencies/fetchAgencies', params)
          .then((response) => {
            this.busy = false;
          })
      }
    },

    beforeRouteLeave (to, from, next) {
      if(!to.params.city)
        this.$store.dispatch('resetCity');
      if(!to.params.country)
        this.$store.dispatch('resetCountry');
      next();
    }
  }
</script>

<style>
  .girl-placeholder .vue-content-placeholders-img {
    height: 400px;
  }
</style>
