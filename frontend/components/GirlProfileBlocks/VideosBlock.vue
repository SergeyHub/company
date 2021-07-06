<template>
  <div id="video" class="profile__video">
    <div class="container">
      <div class="profile__section-title">{{ $t('public_profile.video') }}</div>
      <template v-for="(video, index) in videos">
        <a
          v-if="index == 1"
          :key="'video'+index"
          :href="video.url"
          data-fancybox="gallery-video"
        >
          <div class="profile__video-thumb">
            <div class="profile__video-wrap">
              <!--<div class="profile__video-title">
                <span>{{ $t('public_profile.see_my_video') }}</span>
                <small>Только для участников</small>
              </div>-->
              <div class="profile__video-play"></div>
            </div>
            <img v-lazy="video.thumb" class="thumb" alt="">
          </div>
        </a>
      </template>
    </div>
  </div>
    <!--<accordion icon="fa-film" class="detail-block-phone" v-if="videos.length">
      <template slot="title">
        {{$t('public_profile.videos')}}
      </template>
      <template slot="body">
        <div v-loading="loading">
          <b-row>
            <b-col cols="12" sm="6" v-for="(video, index) in videos" :key="'video'+index">
              <a  @click.prevent class="ilightbox-video girl-profile-main-picture" data-type="video" :href="video.url">
                <d-card class="video-item" v-lazy:background-image="video.thumb">
                  <div class="video-play">
                <span class="fa-stack">
                  <i class="fas fa-circle fa-stack-1x"></i>
                  <i class="fas fa-play fa-stack-1x"></i>
                </span>
                  </div>
                </d-card>
              </a>
            </b-col>
          </b-row>
        </div>
      </template>
    </accordion>-->
</template>

<script>
  import { mapGetters } from 'vuex'
  import Accordion from '~/components/Accordion'

  export default {
    computed: {
      ...mapGetters('girls', ['current_girl']),
      videos() {
        return this.current_girl.videos
      }
    },
    components: {
      Accordion
    },
    data() {
      return {
        loading: true,
        video_slider: null,
      }
    },
    methods: {
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
    }
  }
</script>

<style>
  @media(max-width: 768px) {
    .profile-details-right .slick-slide {
      display: block;
      margin: 20px 10px;
    }
    .profile-details-right .slick-slide div {
      transition: all 0.5s ease-in-out;
    }

    .profile-details-right .slick-center div {
      -moz-transform: scale(1.08);
      -ms-transform: scale(1.08);
      -o-transform: scale(1.08);
      -webkit-transform: scale(1.08);
      color: #e67e22;
      opacity: 1;
      transform: scale(1.08);
    }
  }
  @media(max-width: 500px) {
    .profile-details-right .slick-list {
      overflow: visible;
    }
    .profile-details-right .slick-next {
      right: -12px;
    }
    .profile-details-right .slick-prev {
      left: -12px;
    }
  }
</style>
