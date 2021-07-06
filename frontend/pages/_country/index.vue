<template>
  <!--<div>
    <breadcrumbs :items="breadcrumbs"/>
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
  </div>-->
  <div>
    <breadcrumbs/>
    <heading-seo/>
    <!--<girl-placeholders v-if="loading"/>-->

    <girls-filter v-model="filter" :value.sync="filter"></girls-filter>

    <girls-archive
      :girls="girls"
      :total="total"
      :last_page="last_page"
      :loading="loading"
      :busy="busy"
      :showSidebar="true"

      v-infinite-scroll="loadMore"
      infinite-scroll-disabled="busy"
      infinite-scroll-distance="30"
      @loadMore="loadMore"
    />
  </div>
</template>

<script>
import {mapGetters, mapState} from 'vuex'
  import ModelBlock from '~/components/ModelBlock'
  import GirlPlaceholders from '~/components/GirlPlaceholders'
  import CountriesBlock from '~/components/CountriesBlock'
  import Breadcrumbs from '~/components/Breadcrumbs'
  import GirlsFilter from '~/components/GirlsFilter'
  import HeadingSeo from '~/components/HeadingSeo'
  import GirlsArchive from '~/components/GirlsArchive'

  export default {
    components: {
      Breadcrumbs,
      ModelBlock,
      GirlPlaceholders,
      CountriesBlock,
      HeadingSeo,
      GirlsArchive,
      GirlsFilter
    },
    computed: {
      ...mapGetters('girls', ['girls', 'params', 'section']),
      ...mapGetters(['country']),
      ...mapState({
        filter: state => state.filter.value
      }),
    },
    data() {
      return {
        loading: true,
        busy: true,
        page: 1,
        breadcrumbs: [{
          text: this.$t('titles.virgins')
        }]
      }
    },
    head() {
      let title = this.$t('titles.home_page_country');
      title = title.replace(/%country_prepositional%/gi, (this.country && this.country.id ? (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : ''))
        .replace(/%country_genitive%/gi, (this.country && this.country.id ? (this.country.name_genitive ? this.country.name_genitive : this.country.name) : ''))
        .replace(/%country_instrumental%/gi, (this.country && this.country.id ? (this.country.name_instrumental ? this.country.name_instrumental : this.country.name) : ''))
        .replace(/%country_dative%/gi, (this.country && this.country.id ? (this.country.name_dative ? this.country.name_dative : this.country.name) : ''))
        .replace(/%country_accusative%/gi, (this.country && this.country.id ? (this.country.name_accusative ? this.country.name_accusative : this.country.name) : ''))
        .replace(/%city_prepositional%/gi, (this.city && this.city.id ? (this.city.name_prepositional ? this.city.name_prepositional : this.city.name) : ''))
        .replace(/%city_genitive%/gi, (this.city && this.city.id ? (this.city.name_genitive ? this.city.name_genitive : this.city.name) : ''))
        .replace(/%city_instrumental%/gi, (this.city && this.city.id ? (this.city.name_instrumental ? this.city.name_instrumental : this.city.name) : ''))
        .replace(/%city_dative%/gi, (this.city && this.city.id ? (this.city.name_dative ? this.city.name_dative : this.city.name) : ''))
        .replace(/%city_accusative%/gi, (this.city && this.city.id ? (this.city.name_accusative ? this.city.name_accusative : this.city.name) : ''))
        .replace(/%country%/gi, (this.country && this.country.id ? this.country.name : ''))
        .replace(/%city%/gi, (this.city && this.city.id ? this.city.name : ''))
      let description = this.country ? this.$t('descriptions.home_country') : this.$t('descriptions.home');
      description = description.replace(/%country_prepositional%/gi, (this.country && this.country.id ? (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : ''))
        .replace(/%country_genitive%/gi, (this.country && this.country.id ? (this.country.name_genitive ? this.country.name_genitive : this.country.name) : ''))
        .replace(/%country_instrumental%/gi, (this.country && this.country.id ? (this.country.name_instrumental ? this.country.name_instrumental : this.country.name) : ''))
        .replace(/%country_dative%/gi, (this.country && this.country.id ? (this.country.name_dative ? this.country.name_dative : this.country.name) : ''))
        .replace(/%country_accusative%/gi, (this.country && this.country.id ? (this.country.name_accusative ? this.country.name_accusative : this.country.name) : ''))
        .replace(/%city_prepositional%/gi, (this.city && this.city.id ? (this.city.name_prepositional ? this.city.name_prepositional : this.city.name) : ''))
        .replace(/%city_genitive%/gi, (this.city && this.city.id ? (this.city.name_genitive ? this.city.name_genitive : this.city.name) : ''))
        .replace(/%city_instrumental%/gi, (this.city && this.city.id ? (this.city.name_instrumental ? this.city.name_instrumental : this.city.name) : ''))
        .replace(/%city_dative%/gi, (this.city && this.city.id ? (this.city.name_dative ? this.city.name_dative : this.city.name) : ''))
        .replace(/%city_accusative%/gi, (this.city && this.city.id ? (this.city.name_accusative ? this.city.name_accusative : this.city.name) : ''))
        .replace(/%country%/gi, (this.country && this.country.id ? this.country.name : ''))
        .replace(/%city%/gi, (this.city && this.city.id ? this.city.name : ''))
      description = description.replace(/%count%/gi, (this.total ? this.total : 0));
      return {
        title: title,
        meta: [
          { hid: 'description', name: 'description', content: description }
        ]
      }
    },
    async asyncData({ store, params, error }) {
      await store.dispatch('girls/resetGirls');
      await store.dispatch('girls/setCurrentSection', ''); //girls section
      if(!store.state.country || store.state.country.slug !== params.country) {
        try {
          await store.dispatch('fetchAndSetCountry',  {
            slug: params.country,
            section: 'girls'
          });
        } catch (err) {
          return error({statusCode: 404, message: err.message})
        }
      }
      let filter_params = {};
      if (store.state.country) {
        filter_params.country = store.state.country.id
      }
      let response = await store.dispatch('girls/fetchGirls', filter_params)
      return {
        loading: false,
        busy: response.meta.last_page == 1,
        last_page: response.meta.last_page,
        total: response.meta.total,
      }
    },

    watch: {
      filter: {
        handler(val){
          this.page = 1;
          this.$store.dispatch('girls/resetGirls');
          this.loading = true
          let params = {};
          if (this.$store.state.country) {
            params.country = this.$store.state.country.id
          }
          params = {
            ...params,
            ...this.filter
          }

          return this.$store.dispatch('girls/fetchGirls', params)
            .then((response) => {
                this.loading = false
                this.busy = response.meta.last_page == 1
                this.last_page= response.meta.last_page
                this.total = response.meta.total
              }
            )
        },
        deep: true
      }
    },

    methods: {
      loadMore() {
        this.busy = true;
        if (this.page == this.last_page)
          return;

        this.page++;
        let params = {
          page: this.page,
          ...this.filter
        };
        if (this.$store.state.country)
          params.country = this.$store.state.country.id;

        this.$store.dispatch('girls/fetchGirls', params)
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
