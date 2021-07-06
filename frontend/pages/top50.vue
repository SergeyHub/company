<template>
  <div>
    <breadcrumbs :items="breadcrumbs"/>
    <heading-seo/>
    <!--<girl-placeholders v-if="loading"/>-->

    <girls-filter v-model="filter" :value.sync="filter"></girls-filter>

    <girls-archive
      :girls="girls"
      :total="total"
      :last_page="last_page"
      :loading="loading"
      :busy="busy"

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
  import HeadingSeo from '~/components/HeadingSeo'
  import GirlsArchive from '~/components/GirlsArchive'
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
      ...mapGetters('girls', ['girls', 'params']),
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
        breadcrumbs: [/*{
          text: this.$t('titles.top50')
        }*/]
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
       let title = this.$t('titles.top50');
       return {
         title: title
       }
    },
    asyncData({store}) {
      store.dispatch('girls/resetGirls');
      store.dispatch('girls/setCurrentSection', 'top50');
      let params = {};
      if (store.state.country) {
        params.country = store.state.country.id
      }
      return store.dispatch('girls/fetchTop50Girls', params)
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
        let params = {
          page: this.page,
          ...this.filter
        };
        if (this.$store.state.country)
          params.country = this.$store.state.country.id;

        this.$store.dispatch('girls/fetchTop50Girls', params)
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
