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
  <!--<div>
    <breadcrumbs :items="breadcrumbs"/>
    <heading-seo/>
    <girl-placeholders v-if="loading"/>
    <b-row v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="30" v-else>
      <b-col cols="12" md="12" v-for="model in reviews" :key="'review/'+model.id">
        <review-block :model="model"/>
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
      ...mapGetters('girls', ['reviews', 'params']),
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
      let title = this.$t('titles.title_reviews');
      let description = this.$t('descriptions.reviews');
      return {
        title: title,
        meta: [
          { hid: 'description', name: 'description', content: description }
        ]
      }
    },
    asyncData({store}) {
      store.dispatch('girls/resetReviews');
      store.dispatch('girls/setCurrentSection', 'reviews');
      let params = {};
      return store.dispatch('girls/fetchReviews', params)
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

        this.$store.dispatch('girls/fetchReviews', params)
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
