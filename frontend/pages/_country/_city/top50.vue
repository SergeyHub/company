<template>
  <div>
    <breadcrumbs :items="breadcrumbs"/>
    <heading-seo/>

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
  import ModelBlock from '~/components/ModelBlock'
  import GirlPlaceholders from '~/components/GirlPlaceholders'
  import CountriesBlock from '~/components/CountriesBlock'
  import Breadcrumbs from '~/components/Breadcrumbs'
  import HeadingSeo from '~/components/HeadingSeo'
  import GirlsArchive from '~/components/GirlsArchive'
  import {mapGetters, mapState} from 'vuex'
  import GirlsFilter from '~/components/GirlsFilter'

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
      ...mapGetters(['country', 'city']),
      ...mapGetters('girls', ['girls', 'params', 'section']),

      ...mapState({
        filter: state => state.filter.value
      }),
    },
    data() {
      return {
        loading: true,
        busy: true,
        page: 1,
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
    head() {
      let title = this.$i18n.t('titles.top50_city');

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

      return {
        title: title
      }
    },
    async asyncData({req, res, store, params, error}) {
      store.dispatch('girls/resetGirls');
      store.dispatch('girls/setCurrentSection', 'top50');

      if(!store.state.country || store.state.country.slug !== params.country) {
        try {
          await store.dispatch('fetchAndSetCountry', {
            slug: params.country,
            section: 'top50'
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
      let response = await store.dispatch('girls/fetchTop50Girls', query);
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
        let params = {
          page: this.page,
          ...this.filter
        };
        if (this.$store.state.country)
          params.country = this.$store.state.country.id;
        if (this.$store.state.city)
          params.city = this.$store.state.city.id;

        this.$store.dispatch('girls/fetchTop50Girls', params)
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
