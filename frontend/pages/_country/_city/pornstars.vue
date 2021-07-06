<template>
  <div>
    <breadcrumbs/>
    <heading-seo/>
    <div class="row mt-3">
      <div class="col-md-12 mb-3">
        <div class="row align-items-center">
          <div class="col-6">
            <h2 class="Typography_h2">{{ $t('titles.pornstars') }}</h2>
          </div>
        </div>
      </div>
      <template v-if="girls.length">
        <b-col cols="6" md="4" v-for="model in girls" :key="'girl/'+model.id">
          <model-block :model="model"/>
        </b-col>
      </template>
      <div v-else class="col-12">
        {{ $t('city_page.not_found_virgins') }}
      </div>
    </div>
  </div>
</template>

<script>
  import Breadcrumbs from '~/components/Breadcrumbs'
  import ModelBlock from '~/components/ModelBlock'
  import GirlsSlider from '~/components/GirlsSlider'
  import HeadingSeo from '~/components/HeadingSeo'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      Breadcrumbs,
      ModelBlock,
      GirlsSlider,
      HeadingSeo
    },
    computed: {
      ...mapGetters(['country', 'city']),
      ...mapGetters('offers', ['offers']),
      ...mapGetters('girls', ['section'])
    },
    data() {
      return {
        loading: false,
        showSlider: false,
      }
    },
    // head() {
    //   let title = this.$i18n.t('heading_seo.title_city')
    //     .replace(/%in_city%/gi, (this.city && this.city.id ? this.$t('other.in_the') + this.city.name : ''));
    //
    //   let description = this.$i18n.t('descriptions.home_page_pornstars_city')
    //     .replace(/%city%/gi, (this.city && this.city.id ? this.city.name : ''));
    //
    //   return {
    //     title: title,
    //     meta: [
    //       { hid: 'description', name: 'description', content: description }
    //     ]
    //   }
    // },
    beforeDestroy() {
      this.showSlider = false;
    },
    async asyncData({req, res, store, params, error}) {
      store.dispatch('girls/resetGirls');
      store.dispatch('girls/setCurrentSection', 'pornstars');

      if(!store.state.country || store.state.country.slug !== params.country) {
        try {
          await store.dispatch('fetchAndSetCountry', {
            slug: params.country,
            section: 'pornstars'
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
      let response = await store.dispatch('girls/fetchPornstarGirls', query);
      return {
        girls: _.cloneDeep(response.data),
        loading: false,
        showSlider: !!response.data.length
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
