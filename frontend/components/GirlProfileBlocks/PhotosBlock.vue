<template>
  <!--Details right: photos, videos-->
  <div>
    <div class="profile__section-title">{{ $t('public_profile.photo') }}</div>
    <div class="profile__gallery-row">
      <a
        v-for="(photo,index) in photos"
        :key="photo.id"
        :href="photo.big ? photo.big : photo.thumb"
        data-fancybox="gallery"
        :alt="getPhotoAlt(photo, index)"
        :title="getPhotoTitle()"
      >
        <div class="profile__gallery-item" v-lazy:background="photo.big ? photo.big : photo.thumb">
        </div>
      </a>
    </div>
  </div>
  <!--<div class="profile-details-right">
    <div class="sliding-content">

      <div class="newphotos">
        <div class="photos-wrapper" v-loading="loading">
          <slick
            ref="slick"
            :options="slickOptions">
            <template v-for="(photo, index) in photos">
              <a :key="index" @click.prevent class="ilightbox girl-profile-main-picture" data-type="image" :href="photo.big ? photo.big : photo.thumb">
                <img :src="photo.thumb ? photo.thumb : photo.big" :alt="current_girl.name + ' ' + $t('titles.virgin')" />
              </a>
            </template>
          </slick>
        </div>
      </div>

    </div>
  </div>-->
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    computed: {
      ...mapGetters('girls', ['current_girl']),
      photos() {
        return this.current_girl.photos
      }
    },
    data() {
      return {
        loading: true,
        photo_slider: null,
        slickOptions: {
          slidesToShow: 1,
          arrows: true,
          infinite: true,
          centerMode: false,
          centerPadding: '40px',
          responsive: [
            {
              breakpoint: 991,
              settings: {
                centerMode: true,
              }
            },
          ]
        },
      }
    },
    methods: {
      initViewer() {
        var self = this;
        $('[data-fancybox]').fancybox({
          clickOutside: 'close',
          buttons: [
            //"zoom",
            //"share",
            //"slideShow",
            //"fullScreen",
            //"download",
            //"thumbs",
            'close',
          ],
          protect: true, // РїРѕР»СЊР·РѕРІР°С‚РµР»СЊ РЅРµ РјРѕР¶РµС‚ СЃРѕС…СЂР°РЅРёС‚СЊ РёР·РѕР±СЂР°Р¶РµРЅРёРµ
          // toolbar  : false // СѓР±СЂР°Р»Рё РїР°РЅРµР»СЊ РёРЅСЃС‚СЂСѓРјРµРЅС‚РѕРІ
          mobile: {
            clickContent: 'close',
            clickSlide: 'close',
          },
        });
        /*
        var button_text = this.$t('public_profile.get_access_to_original_photos');
        self.photo_slider = $(".ilightbox").iLightBox({
          type: 'image',
          fullViewPort: "fill",
          path: "horizontal",
          controls: {
            arrows: !0,
            slideshow: !0
          }
        });*/
        this.loading = false;
      },
      appendScripts() {
        var element = document.getElementById('fancybox_script');
        element && element.remove();
        var script = document.createElement('script');
        script.src = process.env.cdn_assets + '/fancybox/jquery.fancybox.js';
        script.id = 'fancybox_script';
        script.onload = () => {
          this.initViewer()
        };
        document.head.append(script);
        /*
        var element = document.getElementById('ilightbox_script');
        element && element.remove();
        var script = document.createElement('script');
        script.src = process.env.cdn_assets + '/ilightbox/js/ilightbox.packed.js';
        script.id = 'ilightbox_script';
        script.onload = () => {
          this.initViewer()
        };
        document.head.append(script);*/
      },
      getPhotoTitle() {
        return [
          this.current_girl.name,
          this.current_girl.city.name,
          this.current_girl.age,
          this.$t('model_block.years_old')
        ].join(' ')
      },
      getPhotoAlt(photo, index) {
        return [
          this.$t('other.photo'),
          (index+1),
          this.current_girl.name,
          this.current_girl.city.name,
          this.current_girl.age,
          this.$t('model_block.years_old')
        ].join(' ');
      }
    },
    mounted() {
      this.appendScripts();
    },
    beforeDestroy() {
      if(this.photo_slider) {
        this.photo_slider.destroy();
        this.photo_slider = null;
      }
    }
  }
</script>

<style>
  @media(max-width: 991px) {
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
