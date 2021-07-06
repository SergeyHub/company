<template>
  <div class="admin__wrap">
    <div class="container">
      <h1>{{ $t('photos.title') }}</h1>

      <div
        class="row admin__media"
      >
        <div
          v-for="(photo, index) in activeGirl.photos"
          :key="photo.url"
          v-if="activeGirl.photos.length"
          v-loading="loading_images"
          class="col-3 col-md-3 col-sm-6 col-xs-12"
        >
          <div
            :class="{avatar: photo.avatar}"
            class="admin__media-thumb"
          >
            <div class="avatar__title" v-if="photo.avatar">Главная фотография</div>
            <div
              class="admin__media-btn"
              v-if="!photo.avatar"
            >
              <button class="btn btn-accent favorit" @click="makePrimary(index)">
                {{ $t('photos.make_primary') }}
              </button>
              <button class="btn del" @click="deletePhoto(index)">
                <i class="fas fa-trash-alt"></i> {{ $t('photos.delete') }}
              </button>
            </div>
            <img :src="photo.url" alt="">
          </div>
        </div>
        <no-ssr>
          <photos-uploader :girl-id="activeGirl.id" @uploaded="photosUploaded" />
        </no-ssr>
      </div>

      <h1>{{ $t('videos.title') }}</h1>

      <div
        class="row admin__media"
      >
        <div
          v-for="(video, index) in activeGirl.videos"
          :key="video.url"
          v-if="activeGirl.videos.length"
          v-loading="loading_videos"
          class="col-3 col-md-3 col-sm-6 col-xs-12"
        >
          <div class="admin__media-thumb">
            <div class="admin__media-btn">
              <button class="btn btn-border del" @click="deleteVideo(index)">
                <i class="fas fa-trash-alt"></i> {{ $t('videos.delete') }}
              </button>
            </div>

            <img v-if="video.thumb" :src="video.thumb" :alt="$t('videos.processing')">
            <div v-else class="processing-video" :id="'processing'+index">
              <div>{{ $t('videos.processing') }}</div>
            </div>

          </div>
        </div>
        <no-ssr>
          <videos-uploader :girl-id="activeGirl.id" @uploaded="videosUploaded" />
        </no-ssr>
      </div>
    </div>
  </div>
  <!--<div>
    <div class="row">
      <div class="col-md-8">
        <div class="Typography_h2">
          {{ $t('photos.title') }}
        </div>
      </div>
    </div>
    <div class="row mt-4" v-if="activeGirl.photos.length" v-loading="loading_images">
      <div class="col-md-3" v-for="(photo, index) in activeGirl.photos" :key="photo.url">
        <div class="photo-block" :class="{'photo-block-avatar': photo.avatar}">
          <img :src="photo.url">
          <div class="photo-block-content">
            <d-button theme="success" @click="makePrimary(index)" size="sm" class="mb-2" v-if="!photo.avatar">
              {{ $t('photos.make_primary') }}
            </d-button>
            <d-button theme="danger" @click="deletePhoto(index)" size="sm">
              <i class="fas fa-trash-alt"></i> {{ $t('photos.delete') }}
            </d-button>
          </div>
        </div>
      </div>
    </div>
    <no-ssr>
      <photos-uploader :girl-id="activeGirl.id" @uploaded="photosUploaded" />
    </no-ssr>

    <div class="row mt-4">
      <div class="col-md-8">
        <div class="Typography_h2">
          {{ $t('videos.title') }}
        </div>
      </div>
    </div>

    <div class="row mt-4" v-if="activeGirl.videos.length" v-loading="loading_videos">
      <div class="col-md-3" v-for="(video, index) in activeGirl.videos" :key="video.url">
        <div class="video-block">
          <img v-if="video.thumb" :src="video.thumb" :alt="$t('videos.processing')">
          <div v-else class="processing-video" :id="'processing'+index">
            <div>{{ $t('videos.processing') }}</div>
          </div>
          <div class="video-block-content">
            <d-button theme="danger" @click="deleteVideo(index)" size="sm">
              <i class="fas fa-trash-alt"></i> {{ $t('videos.delete') }}
            </d-button>
          </div>
        </div>
      </div>
    </div>
    <no-ssr>
      <videos-uploader :girl-id="activeGirl.id" @uploaded="videosUploaded" />
    </no-ssr>
  </div>-->
</template>

<script>
  import { mapGetters } from 'vuex'
  import { MessageBox, Message } from 'element-ui'
  import CoverUploader from '~/components/GirlProfile/CoverUploader'
  import PhotosUploader from '~/components/GirlProfile/PhotosUploader'
  import VideosUploader from '~/components/GirlProfile/VideosUploader'
  //import ImageEditor from '~/components/ImageEditor'

  export default {

    props: {
      girlType: {
        type: String,
        default: () => 'independent'
      },
      admin: {
        type: Boolean,
        default: () => false
      }
    },

    components: {
      CoverUploader,
      PhotosUploader,
      VideosUploader,
      //ImageEditor
    },

    computed: {
      ...mapGetters('auth', ['userType', 'isAgency']),
      ...mapGetters('girls', ['current_girl']),
      ...mapGetters('profile', ['independent_profile', 'profileIsVerified']),
      profileIsVerified() {
          return this.$store.getters['girls/profileIsVerified'];
      },
      activeGirl() {
          return this.current_girl;
      }
    },

    data() {
      return {
        loading_images: false,
        loading_videos: false
      }
    },

    methods: {
      openImageEditor(photo) {
        this.$refs.ImageEditor.open(photo)
      },
      makePrimary(index) {
        this.loading_images = true;
        var data = {
          media_id: this.activeGirl.photos[index].id,
          id: this.activeGirl.id
        };
        this.$store.dispatch('girls/uploadAvatar', data)
          .then((response) => {
            this.loading_images = false;
            this.$store.dispatch('girls/setAvatar',
              data.media_id
            )
          })
          .catch((error) => {
            this.loading_images = false;
          })
      },
      photosUploaded() {
        Message.success(this.$t('photos.success_uploaded_photos'));
        // отправляем на верификацию
        if(!this.admin && !this.profileIsVerified) {
          this.$ga.event('girl', 'photos_uploaded');
          // if (this.isAgency) {
          //   this.$router.push(this.localePath({
          //     name: 'profile-agency-mans-id-validate',
          //     params: {id: this.activeGirl.id}
          //   }))
          // } else {
          //   this.$router.push(this.localePath({
          //     name: 'profile-id-validate',
          //     params: {id: this.activeGirl.id}
          //   }))
          // }
        }
      },
      videosUploaded() {
        Message.success(this.$t('videos.success_uploaded_videos'));
      },
      hiddenPhotoUploaded(data) {
        this.$store.dispatch('girls/appendPublicPhoto', data)
      },
      deletePhoto(index, public_store=false) {
        var media = public_store ? this.activeGirl.public_photos[index] : this.activeGirl.photos[index];
        var warning_text = media.avatar
          ? this.$t('photos.delete_avatar_warning_text')
          : this.$t('photos.delete_photo_warning_text');

        MessageBox.confirm(warning_text, this.$t('photos.warning'), {
          confirmButtonText: 'OK',
          cancelButtonText: this.$t('photos.cancel'),
          type: 'warning'
        }).then(() => {
          this.loading_images = true;
          var data = {
            media_id: media.id,
            id: this.activeGirl.id
          };
          this.$store.dispatch('girls/removePhoto', data)
            .then((response) => {
              let needOtherAvatar = this.activeGirl.photos[index].avatar;
              this.loading_images = false;
              this.$store.dispatch('girls/removePhotoFromState',
                {index: index, type: (public_store ? 'public' : 'private')}
              );
              if (needOtherAvatar && this.activeGirl.photos.length > 0) {
                this.$store.dispatch('girls/setAvatar',this.activeGirl.photos[0].id);
              }
              Message.success({
                showClose: true,
                message: this.$t('photos.photo_success_deleted')
              })
            })
            .catch((error) => {
              this.loading_images = false;
              Message.error({
                showClose: true,
                message: this.$t('photos.photo_error_delete')
              })
            })
        }).catch(() => {
          //
        });
      },
      deleteVideo(index, public_store=false) {
        var media = public_store ? this.activeGirl.public_videos[index] : this.activeGirl.videos[index];
        var warning_text = this.$t('videos.delete_video_warning_text');

        MessageBox.confirm(warning_text, this.$t('videos.warning'), {
          confirmButtonText: 'OK',
          cancelButtonText: this.$t('videos.cancel'),
          type: 'warning'
        }).then(() => {
          this.loading_videos = true;
          var data = {
            media_id: media.id,
            id: this.activeGirl.id
          };
          this.$store.dispatch('girls/removeVideo', data)
            .then((response) => {
              this.loading_videos = false;
              this.$store.dispatch('girls/removeVideoFromState',
                {index: index, type: (public_store ? 'public' : 'private')}
              );
              Message.success({
                showClose: true,
                message: this.$t('videos.video_success_deleted')
              })
            })
            .catch((error) => {
              this.loading_videos = false;
              Message.error({
                showClose: true,
                message: this.$t('videos.video_error_delete')
              })
            })
        }).catch(() => {
          //
        });
      }
    }
  }
</script>

<style>
  .photo-block {
    position: relative;
    box-shadow: 1px 1px 5px rgba(0,0,0,.3);
    border: 10px solid #fff;
    margin-bottom: 20px;
    height: 200px;
    overflow: hidden;
    text-align: center
  }
  .video-block {
    position: relative;
    box-shadow: 1px 1px 5px rgba(0,0,0,.3);
    border: 10px solid #fff;
    height: 153px;
    margin-bottom: 20px;
    overflow: hidden;
    text-align: center
  }
  .video-block img {
    display: inline-block;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    max-width: 100%;
    max-height: 133px;
  }
  .photo-block.photo-block-avatar {
    border: 10px solid #ffb4b4;
  }
  .photo-block img {
    height: 100%;
  }
  .photo-block-content,
  .video-block-content {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: all 0.4s ease;
  }
  .photo-block:hover .photo-block-content,
  .video-block:hover .video-block-content{
    opacity: 1;
    background: rgba(255,255,255,0.8);
  }
  .processing-video {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>
