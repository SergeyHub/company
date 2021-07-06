<template>
  <div class="cover-uploader row" v-loading="loading">
    <div class="col-md-5" v-if="activeGirl.cover && type != 'cover_change'">
      <d-card class="text-center">
        <d-card-header>
          {{ $t('photos.current_cover') }}
        </d-card-header>
        <d-card-img :src="activeGirl.cover" :width="'100%'"></d-card-img>
        <d-card-footer>
          <d-button @click="changeCover" theme="success">
            {{ $t('photos.change_cover') }}
          </d-button>
        </d-card-footer>
      </d-card>
    </div>

    <div class="cover-uploader-left" :class="option.img ? 'col-md-7' : 'col-md-12'" v-else>
      <div class="cover-uploader-box" id="drop-area-cover">
        <div class="cover-uploader-box-content" v-if="!option.img">
          <h3>{{ $t('photos.drag_and_drop_cover') }}</h3>
          <d-button @click="type='new'" v-if="type=='cover_change'" theme="secondary">
            {{ $t('photos.back') }}
          </d-button>
          <d-button @click="clickUpload">
            {{ $t('photos.select_image') }}
          </d-button>
        </div>
        <vueCropper
          v-if="option.img"
          ref="cropper"
          :img="option.img"
          :outputSize="option.size"
          :outputType="option.outputType"
          :info="false"
          :canScale="false"
          :full="option.full"
          :canMove="option.canMove"
          :canMoveBox="option.canMoveBox"
          :fixedBox="option.fixedBox"
          :fixed="true"
          :original="option.original"
          :autoCrop="true"
          :centerBox="option.centerBox"
          :high="option.high"
          :fixedNumber="option.fixedNumber"
          :infoTrue="option.infoTrue"
          :maxImgSize="option.maxImageSize"
          @realTime="realTime"
          @cropMoving="cropMoving"
          :enlarge="option.enlarge"
          :mode="option.mode"
        ></vueCropper>
      </div>

      <div class="cover-uploader-buttons" v-if="option.img">
        <d-button @click="clearCrop" theme="danger">
          {{ $t('photos.reset') }}
        </d-button>
        <d-button @click="changeScale(1)">
          <i class="fas fa-search-plus"></i>
        </d-button>
        <d-button @click="changeScale(-1)">
          <i class="fas fa-search-minus"></i>
        </d-button>
        <d-button @click="rotateLeft">
          <i class="fas fa-undo"></i>
        </d-button>
        <d-button @click="rotateRight">
          <i class="fas fa-redo"></i>
        </d-button>
      </div>

      <input type="file" id="uploads" style="display: none;" accept="image/png, image/jpeg, image/gif, image/jpg" @change="uploadImg($event)">
    </div>

    <div class="cover-uploader-right col-md-5" v-if="option.img">
      <d-alert theme="light" show>
        {{ $t('photos.preview') }}
      </d-alert>
          <div :style="previewStyle">
            <div :style="previews.div">
              <img :src="previews.url" :style="previews.img">
            </div>
          </div>
      <d-button @click="finish" theme="success" class="mt-3">
        <i class="fas fa-check"></i> {{ $t('photos.upload_cover') }}
      </d-button>
    </div>
  </div>
</template>

<script>
  import { Message } from 'element-ui'
  import { mapGetters } from 'vuex'

  export default {
    data() {
      return {
        type: 'new',
        loading: false,
        model: false,
        modelSrc: null,
        previews: {},
        previewStyle: {},
        option: {
          img: "",
          size: 1,
          full: true,
          outputType: "png",
          canMove: true,
          fixedBox: false,
          fixedNumber: [2.4, 1],
          original: false,
          canMoveBox: true,
          centerBox: false,
          high: false,
          cropData: {},
          enlarge: 1,
          mode: 'contain',
          maxImgSize: 10000
        }
      }
    },
    computed: {
      ...mapGetters('girls', ['current_girl']),
      ...mapGetters('profile', ['independent_profile']),
      activeGirl() {
        return this.independent_profile.id ? this.independent_profile : this.current_girl;
      }
    },
    methods: {
      changeCover() {
        this.type = 'cover_change'
        this.$nextTick(() => {
          this.dragListenerInit()
        })
      },

      coverUploaded(response) {
        if(this.independent_profile.id) {
          this.$store.dispatch('profile/setCover', response.url)
        } else {
          this.$store.dispatch('girls/setCover', response.url)
        }
        this.type = 'new'
        this.option.img = null;
      },

      clearCrop() {
        this.$refs.cropper.clearCrop();
        this.option.img = null;
      },

      changeScale(num) {
        num = num || 1;
        this.$refs.cropper.changeScale(num);
      },

      rotateLeft() {
        this.$refs.cropper.rotateLeft();
      },

      rotateRight() {
        this.$refs.cropper.rotateRight();
      },

      finish() {
        this.loading = true;
          this.$refs.cropper.getCropBlob(data => {
            this.$store.dispatch('girls/uploadCover', {file: data, id: this.activeGirl.id})
              .then((response) => {
                this.loading = false;
                this.coverUploaded(response);
                Message.success({
                  showClose: true,
                  message: this.$t('cover_uploader.success_message')
                })
              })
              .catch((error) => {
                this.loading = false
                Message.error({
                  showClose: true,
                  message: this.$t('cover_uploader.error_message')
                })
              })
          });
      },

      realTime(data) {
        var previews = data;
        this.previewStyle = {
          width: previews.w + "px",
          height: previews.h + "px",
          overflow: "hidden",
          margin: "0 auto",
          zoom: (320 / previews.w),
          border: "2px solid black"
        };
        this.previews = data;
      },

      uploadImg(e) {
        var file = e.target ? e.target.files[0] : e[0];
        var filename = e.target ? e.target.value : e[0].name;

        if (!/\.(jpg|jpeg|png|JPG|JPEG|PNG)$/.test(filename)) {
          Message.error({
            showClose: true,
            message: this.$t('cover_uploader.format_error')
          })
          return false;
        }

        var self = this;

        var img = new Image();
        img.src = window.URL.createObjectURL(file);
        img.onload = function()
        {
          var width = img.naturalWidth;
          var height = img.naturalHeight;
          if(width < 987 || height < 380) {
            Message.error({
              showClose: true,
              message: self.$t('cover_uploader.dimensions_error')
            })
          } else {
            self.option.img = img.src;
          }
        };
      },
      cropMoving(data) {
        this.option.cropData = data;
      },
      clickUpload() {
        document.querySelector('#uploads').click()
      },
      dragListenerInit() {
        var self = this;
        let dropArea = document.getElementById('drop-area-cover');
        if(!dropArea)
          return;
        ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
          dropArea.addEventListener(eventName, preventDefaults, false)
        });
        function preventDefaults (e) {
          e.preventDefault()
          e.stopPropagation()
        }
        ;['dragenter', 'dragover'].forEach(eventName => {
          dropArea.addEventListener(eventName, highlight, false)
        })
        ;['dragleave', 'drop'].forEach(eventName => {
          dropArea.addEventListener(eventName, unhighlight, false)
        })
        function highlight(e) {
          dropArea.classList.add('highlight')
        }
        function unhighlight(e) {
          dropArea.classList.remove('highlight')
        }
        dropArea.addEventListener('drop', handleDrop, false)
        function handleDrop(e) {
          let dt = e.dataTransfer
          let files = dt.files
          self.uploadImg(files)
        }
      }
    },
    mounted() {
      this.$nextTick(() => {
        this.dragListenerInit()
      })
    }
  }
</script>

<style>
  .cover-uploader {
    width: 100%;
  }
  .cover-uploader-left {

  }
  .active-cover {
    width: 100%;
  }
  .cover-uploader-right {
    text-align: center;
  }
  .cover-uploader-box {
    height: 250px;
    border: 2px solid;
    margin-bottom: 10px;
    position: relative;
  }
  .cover-uploader-box.highlight {
    border: 2px dotted #4aa0e6;
  }
  .cover-uploader-box .cover-uploader-box-content {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    text-align: center;
  }
  .cover-uploader .cover-uploader-buttons {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
</style>
