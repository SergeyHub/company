<template>
  <div>
    <breadcrumbs/>
    <heading-seo/>
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
</template>

<script>
  import ModelBlock from '~/components/ModelBlock'
  import GirlPlaceholders from '~/components/GirlPlaceholders'
  import CountriesBlock from '~/components/CountriesBlock'
  import Breadcrumbs from '~/components/Breadcrumbs'
  import HeadingSeo from '~/components/HeadingSeo'
  import BButton from "bootstrap-vue/src/components/button/button";
  import { mapGetters } from 'vuex'

  export default {
    components: {
      BButton,
      Breadcrumbs,
      ModelBlock,
      GirlPlaceholders,
      CountriesBlock,
      HeadingSeo
    },
    computed: {
      ...mapGetters(['country', 'city']),
      ...mapGetters('girls', ['girls', 'params', 'section']),
    },
    data() {
      return {
        loading: true,
        busy: true,
        page: 1,
      }
    },
    // head() {
    //   let title = this.$i18n.t('heading_seo.title_city')
    //     .replace(/%in_city%/gi, (this.city && this.city.id ? this.$t('other.in_the') + this.city.name : ''));
    //
    //   let description = this.$i18n.t('descriptions.home_page_vip_city')
    //     .replace(/%city%/gi, (this.city && this.city.id ? this.city.name : ''));
    //
    //   return {
    //     title: title,
    //     meta: [
    //       { hid: 'description', name: 'description', content: description }
    //     ]
    //   }
    // },
    async asyncData({req, res, store, params, error}) {
      store.dispatch('girls/resetGirls');
      store.dispatch('girls/setCurrentSection', 'vip');

      if(!store.state.country || store.state.country.slug !== params.country) {
        try {
          await store.dispatch('fetchAndSetCountry', {
            slug: params.country,
            section: 'vip'
          });
        } catch (err) {
          return error({statusCode: 404, message: err.message})
        }
      }

      let current_city = store.state.city;

      if (!current_city || current_city.slug !== params.city) {
        try {
          await store.dispatch('setCurrentCity', params.city);
        } catch (err) {
          return error({statusCode: 404, message: err.message})
        }
      }

      let query = {};
      if (store.state.country)
        query.country = store.state.country.id;
      if (store.state.city)
        query.city = store.state.city.id;
      let response = await store.dispatch('girls/fetchVipGirls', query);
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
        if (this.$store.state.city)
          params.city = this.$store.state.city.id;

        this.$store.dispatch('girls/fetchVipGirls', params)
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
