<template>
  <div class="col-12 col-md-12">
    <vue-dropzone
      :useCustomSlot="true"
      :options="dropzoneOptions"
      @vdropzone-success="videoUploaded"
      @vdropzone-queue-complete="progressUpload"
      id="dropzone-videos"
      class="admin__media-uploud"
    >
      <span>{{ $t('videos.drag_and_drop_videos') }}</span>
      <AppButton :mode="custom" class="btn btn-border">
        {{ $t('videos.select_videos') }}
      </AppButton>
    </vue-dropzone>
  </div>
  <!--<div class="row mt-4">
    <div class="col-md-12">
      <vue-dropzone :options="dropzoneOptions"
                    :useCustomSlot="true"
                    @vdropzone-success="videoUploaded"
                    @vdropzone-queue-complete="progressUpload"
                    id="dropzone-videos">
        <div class="dropzone-custom-content">
          <div class="Typography_h3 dropzone-custom-title">{{ $t('videos.drag_and_drop_videos') }}</div>
          <AppButton mode="dark" class="mt-2">{{ $t('videos.select_videos') }}</AppButton>
        </div>
      </vue-dropzone>
    </div>
  </div>-->
</template>

<script>
  import { mapGetters } from 'vuex'
  //import BButton from "bootstrap-vue/src/components/button/button";
  import AppButton from '~/components/AppButton'

  export default {
    components: {AppButton},
    props: {
      girlId: {
        type: Number,
        required: true
      }
    },

    computed:{
      ...mapGetters('girls', ['current_girl']),
      activeGirl() {
        return this.current_girl;
      }
    },

    data() {
      return {
        dropzoneOptions: {
          url: this.$axios.apiUrl + '/girls/' + this.girlId + '/videos',
          thumbnailWidth: 200,
          addRemoveLinks: false,
          maxFiles: 10,
          headers: {
            'Authorization': 'Bearer ' + this.$store.state.auth.token
          }
        }
      }
    },

    methods: {
      videoUploaded(file, response) {
        this.$store.dispatch('girls/appendVideo', response)
      },
      progressUpload() {
          setTimeout(() => {
            this.$emit('uploaded')
          }, 1500)
      }
    }
  }
</script>

<style>
  .vue-dropzone {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    border: 2px dashed #e5e5e5;
  }

  .dropzone-custom-content {
    text-align: center;
  }

  .dropzone-custom-title {
    margin-top: 0;
    color: #00b782;
    font-family: 'GTWalsheimPro';
    color: #132968;
  }
</style>
