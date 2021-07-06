<template>
  <div class="col-12 col-md-12">
    <vue-dropzone
      :options="dropzoneOptions"
      :useCustomSlot="true"
      @vdropzone-success="photoUploaded"
      @vdropzone-queue-complete="progressUpload"
      id="dropzone-photos"
      class="admin__media-uploud"
    >
      <span>{{ $t('photos.drag_and_drop_photos') }}</span>
      <AppButton :mode="custom" class="btn btn-border">
        {{ $t('photos.select_images') }}
      </AppButton>
    </vue-dropzone>
  </div>
  <!--
  <div class="row mt-4">
    <div class="col-md-12">
      <vue-dropzone :options="dropzoneOptions"
                    :useCustomSlot="true"
                    @vdropzone-success="photoUploaded"
                    @vdropzone-queue-complete="progressUpload"
                    id="dropzone-photos">
        <div class="dropzone-custom-content">
          <div class="Typography_h3 dropzone-custom-title">{{ $t('photos.drag_and_drop_photos') }}</div>
          <AppButton mode="dark" class="mt-2">{{ $t('photos.select_images') }}</AppButton>
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
    components: { AppButton },
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
          url: this.$axios.apiUrl + '/girls/' + this.girlId + '/photos',
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
      photoUploaded(file, response) {
        this.$store.dispatch('girls/appendPhoto', response)
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
    border: 2px dashed rgba(255, 188, 63, 0.3) !important;
    background-color: #000 !important;
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
  .dz-message {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
</style>
