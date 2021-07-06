<template>
  <div>
    <div
      class="profile-slider swiper-container profile-slider-container"
      id="photos"
    >
      <div class="profile__bage">
        <div class="profile__bage-item pornstar" v-if="current_girl.pornstar == true">
          <span>PORN STAR</span>
        </div>
        <div class="profile__bage-item new"  v-if="current_girl.profile_age !== undefined && current_girl.profile_age < 14">
          <span>new</span>
        </div>
        <div class="profile__bage-item top"  v-if="current_girl.is_top == true">
          <span>top</span>
        </div>
        <div class="profile__bage-item vip"  v-if="current_girl.vip">
          <span>vip</span>
        </div>
      </div>

      <div class="profile__meta">
        <div class="profile__realphoto">
          <div class="profile__realphoto-title" v-if="current_girl.verified == 'yes'">{{ $t('public_profile.real_photos') }}</div>
          <div class="profile__realphoto-count"><ins>+{{ photos.length }}</ins>  {{ $t('public_profile.photo') }}</div>
          <div class="profile__realphoto-title invert" v-if="current_girl.ready_for_travels == 1">{{ $t('models.ready_for_travels') }}</div>
        </div>

        <h1 class="profile__name">{{ current_girl.name }}</h1>
        <div class="profile__city">{{ current_girl.country.name }} ({{ current_girl.city.name }})</div>
      </div>

      <a :href="current_girl.videos[0].url" data-fancybox="gallery-video" class="profile__video-btn" v-if="current_girl.videos.length">
        <span>{{ $t('public_profile.see_my_video') }}</span>
        <div class="profile__video-btn-play"></div>
      </a>
      <div class="swiper-wrapper">
        <div
          class="swiper-slide"
          v-for="(photo) in photos"
          :key="photo.id"
        >
          <a
            :href="photo.big ? photo.big : photo.thumb"
            data-fancybox="gallery"
          >
            <div class="profile-slide">
              <img :src="photo.big ? photo.big : photo.thumb" :alt="current_girl.name + ' ' + $t('titles.virgin')">
            </div>
          </a>
        </div>
      </div>
      <!--
      <div class="swiper-wrapper">
        <div class="swiper-slide" v-for="photo in photos" :key="photo.id">
          <a href="photo.big ? photo.big : photo.thumb" data-fancybox="gallery">
            <div class="profile-slide">
              <img :src="photo.thumb ? photo.thumb : photo.big" :alt="current_girl.name + ' ' + $t('titles.virgin')">
            </div>
          </a>
        </div>
      </div>-->

      <!-- Add Arrows -->
      <div class="swiper-btn-next" @click="sliderInstance.slideNext()"></div>
      <div class="swiper-btn-prev" @click="sliderInstance.slidePrev()"></div>
    </div>

    <div class="profile__btn">
      <div class="container">
        <div class="profile__btn-row">
          <div class="profile__btn-col">
            <AppButton mode="accent" class="btn-mess" @click.native="openMessageModal"> {{ $t('public_profile.send_message') }} </AppButton>
            <AppButton mode="custom" class="btn-favorite" @click.native="addToFavourites" :class="{active: isFavourite}"></AppButton>
          </div>
          <div class="profile__btn-col">
            <AppButton mode="dark" @click.native="$emit('showReviewModal')">
              <svg><use xlink:href="/files/sprite.svg#icon--like"/></svg> {{ $t('profile.write_review') }}
            </AppButton>
            <AppButton mode="dark" class="btn-hide" @click.native="hideModel">
              <template v-if="!current_girl.hidden">
                <svg><use xlink:href="/files/sprite.svg#icon--hide"/></svg>
                <span>{{ $t('public_profile.hide_model') }}</span>
              </template>
              <template v-else>
                <span>{{ $t('profile.model_hidden') }}</span>
              </template>
            </AppButton>
          </div>
          <div class="profile__btn-col">
            <AppButton
              mode="custom"
              tag="div"
              class="btn-quote profile--addnote"
              @click.native="showBookmarkModal"
            >
              <template v-if="!(current_girl.bookmark && current_girl.bookmark.content)">{{ $t('public_profile.add_bookmark') }}</template>
              <template v-else>{{ $t('public_profile.change_bookmark') }}</template>
            </AppButton>
            <AppButton
              mode="custom"
              tag="div"
              class="btn-beef"
              @click.native="openFakeModal"
            >
              <div class="icon"></div>
              <span>{{ $t('public_profile.report') }}</span>
            </AppButton>
          </div>
        </div>
      </div>
    </div>

    <div class="container" v-if="current_girl.bookmark">
      <div class="profile__quote">
        <div class="profile__quote-p">{{ current_girl.bookmark.content }}</div>
        <div class="profile__quote-info">{{ $t('public_profile.bookmark_only_shown') }}</div>
      </div>
    </div>
    <FakeModal ref="fakeModal"/>
    <BookmarkModal ref="bookmarkModal"/>
  </div>
</template>
<script>
  import {mapGetters} from "vuex";
  import AppButton from '~/components/AppButton'
  import FakeModal from '~/components/FakeModal'
  import BookmarkModal from '~/components/BookmarkModal'
  import Swiper from 'swiper';

  export default {
    components: {
      AppButton,
      FakeModal,
      BookmarkModal
    },
    computed: {
      ...mapGetters('girls', ['current_girl', 'favourites']),
      ...mapGetters('auth', ['isAuthentificated']),
      photos() {
        return this.current_girl.photos
      },
      isFavourite() {
        return this.favourites.findIndex(el => el.id == this.current_girl.id) > -1;
      }
    },
    data() {
      return {
        rendered: false,
        swiperOptions: {
          slidesPerView: 3,
          spaceBetween: 0,
          loop: true,
          loopFillGroupWithBlank: true,
          navigation: {
            nextEl: '.swiper-btn-next',
            prevEl: '.swiper-btn-prev',
          },

          breakpoints: {
            0: {
              slidesPerView: 1,
            },
            480: {
              slidesPerView: 1,
            },
            640: {
              slidesPerView: 3,
            },
          },
        },
        sliderInstance: null
      }
    },
    mounted() {
      this.sliderInstance = new Swiper('.profile-slider', this.swiperOptions)
      this.appendScripts()
    },
    methods: {
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
      },
      initViewer(){
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
      },
      openMessageModal() {
        this.$emit('showMessageModal')
      },
      openFakeModal() {
        this.$refs.fakeModal.open()
      },
      showBookmarkModal() {
        this.$refs.bookmarkModal.open()
      },
      addToFavourites(){
        if(!this.isAuthentificated) {
          return this.$router.push(this.localePath('login'))
        }
        if (!this.isFavourite) {
          this.$store.dispatch('girls/addToFavourites', this.$route.params.id)
        } else {
          this.$store.dispatch('girls/removeFromFavourites', this.$route.params.id)
        }
      },
      hideModel() {
        if(!this.isAuthentificated) {
          return this.$router.push(this.localePath('login'))
        }
        if(!this.current_girl.hidden) {
          this.$store.dispatch('girls/addToHidden', this.$route.params.id)
            .then((result) => {
              if(result.success) {
                Message.success(this.$t('public_profile.addedToHidden'))
              }
            })
            .catch((error) => {
              if(error.response && error.response.data.error) {
                Message.error(error.response.data.error)
              } else {
                Message.error(this.$t('public_profile.error_occured'))
              }
            })
        } else {
          this.$store.dispatch('girls/removeFromHidden', this.$route.params.id)
            .then((result) => {
              if(result.success) {
                Message.success(this.$t('public_profile.removedFromHidden'))
              }
            })
            .catch((error) => {
              if(error.response && error.response.data.error) {
                Message.error(error.response.data.error)
              } else {
                Message.error(this.$t('public_profile.error_occured'))
              }
            })
        }
      }
    }
  }
</script>
