<template>
  <div>
    <breadcrumbs/>
    <heading-seo/>
    <!--<girl-placeholders v-if="loading"/>-->
    <div class="archive video" v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="30">
      <div class="container">
        <div class="row">
          <div
            class="col-4 col-md-4 col-sm-6 col-xs-12"
            :key="'video'+index"
            v-for="(video, index) in videos"
          >
            <div class="archive__video">
              <router-link :to="modelLink(video.girl)" :title="modelTitle(video.girl)">
                <div class="archive__video--meta">
                  <div class="archive__video--meta-avatar">
                    <img
                      v-lazy="video.girl.avatar"
                      :alt="modelAlt(video.girl)"
                    >
                  </div>
                  <div class="archive__video--meta-name">{{ video.girl.name }}</div>
                </div>
              </router-link>

              <a data-fancybox="gallery-video" :href="video.url">
                <div class="archive__video--thumb">
                  <div class="thumb__img" v-lazy:background-image="video.thumb || video.girl.avatar" alt=""> </div>
                </div>
                <div class="archive__video--play"></div>
              </a>
            </div>
          </div>
          <p class="col-4 col-md-4 col-sm-6 col-xs-12" v-show="!videos.length">
            {{ $t('errors.videos_not_found') }}
          </p>
        </div>
        <div
          v-if="!busy"
          @click="loadMore"
          :title="$t('load_more')"
          class="archive__btn"
        >
          <div class="btn btn-border">
            {{ $t('load_more') }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!---<div>
  <breadcrumbs :items="breadcrumbs"/>
  <heading-seo/>
  <girl-placeholders v-if="loading"/>
  <b-row v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="30" v-else>
    <b-col cols="12" sm="6" lg="4" v-for="(video, index) in videos" :key="'video'+index" class="video-with-info">
        <a @click.prevent class="ilightbox-video" data-type="video" :href="video.url">
          <d-card class="video-item" v-lazy:background-image="video.thumb">
          <div class="video-play">
              <span class="fa-stack">
                <i class="fas fa-circle fa-stack-1x"></i>
                <i class="fas fa-play fa-stack-1x"></i>
              </span>
          </div>
          </d-card>
        </a>
      <router-link class="video-info clearfix" :to="localePath({name: 'mans-id', params: {id: video.girl.id}})">
        <div class="video-avatar" v-lazy:background-image="video.girl.avatar"/>
        <div class="video-girl-name">{{video.girl.name}}</div>
        <div class="video-girl-where text-secondary">{{video.girl.country_name}} / {{video.girl.city}}</div>
      </router-link>
    </b-col>
    <b-col class="text-center" v-if="total == 0">
      {{ $t('errors.videos_not_found') }}
    </b-col>
  </b-row>
  <b-button variant="primary" @click="loadMore" v-if="!busy">
    {{ $t('other.load_more') }}
  </b-button>
  </div>-->
</template>

<script>
import {mapGetters} from 'vuex'
import GirlPlaceholders from '~/components/GirlPlaceholders'
import CountriesBlock from '~/components/CountriesBlock'
import Breadcrumbs from '~/components/Breadcrumbs'
import HeadingSeo from '~/components/HeadingSeo'

function stopVideos() {
  $("video").each(function () {
    if (!$(this)[0].paused) $(this)[0].pause();  // pause if not paused
  });
}

export default {
  computed: {
    ...mapGetters('girls', ['videos', 'params']),
    ...mapGetters(['country'])
  },
  components: {
    Breadcrumbs,
    GirlPlaceholders,
    CountriesBlock,
    HeadingSeo
  },
  data() {
    return {
      loading: true,
      video_slider: null,
      busy: true,
      page: 1,
      breadcrumbs: [{
        text: this.$t('titles.title_videos')
      }]
    }
  },
  head() {
    let title = this.$t('titles.title_videos_country');
    title = title.replace(/%country%/gi, (this.country ? this.country.name : ''));

    let description = this.$t('descriptions.videos_country').replace('%country%', this.country.name)

    return {
      title: title,
      meta: [
        { hid: 'description', name: 'description', content: description }
      ]
    }
  },
  async asyncData({store, params, error}) {
    store.dispatch('girls/resetVideos');
    store.dispatch('girls/setCurrentSection', 'videos');
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
    let filter_params = {};
    if (store.state.country) {
      filter_params.country = store.state.country.id
    }
    return store.dispatch('girls/fetchVideoGirls', filter_params)
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
      if (this.$store.state.country) {
        params.country = this.$store.state.country.id;
      }

      this.$store.dispatch('girls/fetchVideoGirls', params)
        .then((response) => {
          this.busy = false;
        })
    },
    initViewer() {
      var self = this;
      var button_text = this.$t('public_profile.get_access_to_original_photos');
      self.video_slider = $(".ilightbox-video").iLightBox({
        type: 'video',
        fullViewPort: "fill",
        path: "horizontal",
        controls: {
          arrows: !0,
          thumbnail: 0,
        },
        callback: {
          onBeforeChange: stopVideos
        }
      });
      this.loading = false;
    },
    appendScripts() {
      var element = document.getElementById('ilightbox_script');
      element && element.remove();
      var script = document.createElement('script');
      script.src = process.env.cdn_assets + '/ilightbox/js/ilightbox.packed.js';
      script.id = 'ilightbox_script';
      script.onload = () => {
        this.initViewer()
      };
      document.head.append(script);
    },
  },
  mounted() {
    this.appendScripts();
  },
  beforeDestroy() {
    if(this.video_slider) {
      this.video_slider.destroy();
      this.video_slider = null;
    }
  },
  beforeRouteLeave (to, from, next) {
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
.video-girl-where {
  float: right;
  color: #000000;
  width: calc(100% - 50px);
}
</style>
