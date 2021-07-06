<template>
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
  <!--
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
  </div>-->
</template>

<script>
  import ModelBlock from '~/components/ModelBlock'
  import GirlPlaceholders from '~/components/GirlPlaceholders'
  import CountriesBlock from '~/components/CountriesBlock'
  import Breadcrumbs from '~/components/Breadcrumbs'
  import GirlsFilter from '~/components/GirlsFilter'
  import HeadingSeo from '~/components/HeadingSeo'
  import GirlsArchive from '~/components/GirlsArchive'
  import {mapGetters, mapState} from 'vuex'

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
    head() {
      let title = this.$i18n.t('titles.home_page_virgins_city')
        .replace(/%city%/gi, (this.city && this.city.id ? this.city.name : ''));

      let description = this.$i18n.t('descriptions.home_city_virgins')
        .replace(/%city%/gi, (this.city && this.city.id ? this.city.name : ''));

      description = description.replace(/%count%/gi, (this.total ? this.total : 0));

      return {
        title: title,
        meta: [
          { hid: 'description', name: 'description', content: description }
        ]
      }
    },
    async asyncData({req, res, store, params, error}) {
      store.dispatch('girls/resetGirls');
      store.dispatch('girls/setCurrentSection', ''); //girls section

      if(!store.state.country || store.state.country.slug !== params.country) {
        try {
          await store.dispatch('fetchAndSetCountry', {
            slug: params.country,
            section: 'girls'
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
      let response = await store.dispatch('girls/fetchGirls', query);
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

        this.$store.dispatch('girls/fetchGirls', params)
          .then((response) => {
            this.busy = false;
          })
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
    beforeRouteLeave (to, from, next) {
      if(!to.params.city)
        this.$store.dispatch('resetCity');
      if(!to.params.country)
        this.$store.dispatch('resetCountry');
      next();
    }
  }
</script>
