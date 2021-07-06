<template>
  <div>
    <breadcrumbs/>
    <heading-seo/>
    <girl-placeholders v-if="loading"/>
    <div class="archive" v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="30">
      <div class="container">
        <div class="archive__reviews reviews">
          <div class="reviews__row">
            <review-block
              v-for="model in reviews"
              :key="'review/'+model.id"
              :model="model"
            />
            <p v-if="total == 0">
              {{ $t('errors.reviews_not_found') }}
            </p>
          </div>
        </div>
        <div class="archive__btn">
          <button
            v-if="!busy"
            @click="loadMore"
            :title="$t('load_more')"
            class="btn btn-border"
          >
            {{ $t('other.load_more') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  import ReviewBlock from '~/components/ReviewBlock'
  import GirlPlaceholders from '~/components/GirlPlaceholders'
  import CountriesBlock from '~/components/CountriesBlock'
  import Breadcrumbs from '~/components/Breadcrumbs'
  import HeadingSeo from '~/components/HeadingSeo'

  export default {
    components: {
      Breadcrumbs,
      ReviewBlock,
      GirlPlaceholders,
      CountriesBlock,
      HeadingSeo
    },
    computed: {
      ...mapGetters('girls', ['reviews', 'params', 'section']),
      ...mapGetters(['country'])
    },
    data() {
      return {
        loading: true,
        busy: true,
        page: 1,
        breadcrumbs: [{
          text: this.$t('titles.reviews')
        }]
      }
    },
    head() {
      let title = this.$t('titles.title_reviews_country');
      title = title.replace(/%country%/gi, (this.country ? this.country.name : ''));
      let description = this.$t('descriptions.reviews_country');
      description = description.replace(/%country%/gi, (this.country ? (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : ''));
      return {
        title: title,
        meta: [
          { hid: 'description', name: 'description', content: description }
        ]
      }
    },
    async asyncData({req, res, store, params, error}) {
      await store.dispatch('girls/resetReviews');
      await store.dispatch('girls/setCurrentSection', 'reviews');
      if(!store.state.country || store.state.country.slug !== params.country) {
        try {
          await store.dispatch('fetchAndSetCountry', {
            slug: params.country,
            section: 'reviews'
          });
        } catch (err) {
          return error({statusCode: 404, message: err.message})
        }
      }
      let filter_params = {};
      if (store.state.country) {
        filter_params.country = store.state.country.id
      }
      let response = await store.dispatch('girls/fetchReviews', filter_params)
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

        this.$store.dispatch('girls/fetchReviews', params)
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
