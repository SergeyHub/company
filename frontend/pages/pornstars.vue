<template>
  <div>
    <breadcrumbs :items="breadcrumbs"/>
    <heading-seo/>
    <favourites/>
    <girl-placeholders v-if="loading"/>

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
  import {mapGetters} from 'vuex'
  import ModelBlock from '~/components/ModelBlock'
  import GirlPlaceholders from '~/components/GirlPlaceholders'
  import CountriesBlock from '~/components/CountriesBlock'
  import Breadcrumbs from '~/components/Breadcrumbs'
  import HeadingSeo from '~/components/HeadingSeo'
  import BButton from "bootstrap-vue/src/components/button/button";
  import GirlsArchive from '~/components/GirlsArchive'

  export default {
    components: {
      BButton,
      Breadcrumbs,
      ModelBlock,
      GirlPlaceholders,
      CountriesBlock,
      HeadingSeo,
      GirlsArchive
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
          text: this.$t('titles.pornstars')
        }]
      }
    },
    // head() {
    //   let title = this.$t('titles.pornstars');
    //   return {
    //     title: title
    //   }
    // },
    asyncData({store}) {
      store.dispatch('girls/resetGirls');
      store.dispatch('girls/setCurrentSection', 'pornstars');
      let params = {};
      if (store.state.country) {
        params.country = store.state.country.id
      }
      return store.dispatch('girls/fetchPornstarGirls', params)
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

        this.$store.dispatch('girls/fetchPornstarGirls', params)
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
