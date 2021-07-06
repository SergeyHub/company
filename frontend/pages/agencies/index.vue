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
    <b-button variant="primary" @click="loadMore" v-if="!loading">
      {{ $t('other.load_more') }}
    </b-button>
  </div>
</template>

<script>
  import Breadcrumbs from '~/components/Breadcrumbs'
  import HeadingSeo from '~/components/HeadingSeo'
  import AgencyBlock from '~/components/AgencyBlock'
  import { mapGetters } from 'vuex'

  export default {

    components: {
      Breadcrumbs,
      HeadingSeo,
      AgencyBlock
    },

    computed: {
      ...mapGetters('agencies', ['agencies'])
    },

    data() {
      return {
        loading: true,
        breadcrumbs: [{
          text: this.$t('links.agencies')
        }],
        page: 1,
      }
    },
    // head() {
    //   let title = this.$t('titles.title_agencies');
    //   let description = this.$t('descriptions.agencies');
    //   return {
    //     title: title,
    //     meta: [
    //       { hid: 'description', name: 'description', content: description }
    //     ]
    //   }
    // },
    asyncData({ store }) {
      store.dispatch('agencies/resetAgencies');
      store.dispatch('girls/setCurrentSection', 'agencies');
      return store.dispatch('agencies/fetchAgencies')
        .then((response) => {
          return {
            loading: response.meta.last_page == 1,
            last_page: response.meta.last_page,
            total: response.meta.total
          }
        })
    },
    methods: {
      loadMore() {
        this.loading = true;
        if(this.page == this.last_page)
          return;

        this.page++;
        let params = {page: this.page};

        this.$store.dispatch('agencies/fetchAgencies', params)
          .then((response) => {
            this.loading = false;
          })
      }
    }
  }
</script>
