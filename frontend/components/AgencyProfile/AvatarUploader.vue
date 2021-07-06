<template>
  <div class="row">
    <img class="avatar mb-4" id="avatar">
    <div class="col-md-12 agency-avatar-uploader">
      <vue-dropzone :options="dropzoneOptions"
                    :useCustomSlot="true"
                    @vdropzone-success="photoUploaded"
                    @vdropzone-queue-complete="progressUpload"
                    id="dropzone-photos"
                    ref="dropzoneAgencyAvatar"
                    >
        <div class="dropzone-custom-content">
          <div class="Typography_h3 dropzone-custom-title">{{ $t('photos.drag_and_drop_avatar') }}</div>
        </div>
        <AppButton mode="dark" class="mt-2" >{{ $t('photos.select_image') }}</AppButton>
      </vue-dropzone>
    </div>
  </div>
</template>

<script>
  //import BButton from "bootstrap-vue/src/components/button/button";
  import AppButton from '~/components/AppButton'
  import {Message} from "element-ui";

  export default {
    components: { AppButton },
    props: {
      agencyId: {
        type: Number,
        required: true
      },
      avatar: {
        type: String,
        required: false
      }
    },

    data() {
      return {
        dropzoneOptions: {
          url: this.$axios.apiUrl + '/agencies/' + this.agencyId + '/uploadAvatar',
          thumbnailWidth: 200,
          addRemoveLinks: false,
          maxFiles: 1,
          uploadMultiple: false,
          headers: {
            'Authorization': 'Bearer ' + this.$store.state.auth.token
          }
        }
      }
    },

    methods: {
      photoUploaded(file, response) {
        if(response.success) {
          setTimeout(() => {
            document.getElementById("avatar").src = response.url;
            document.getElementById("avatar").style.display = 'block';
            }, 300);
        }
        this.$refs.dropzoneAgencyAvatar.removeAllFiles();
      },
      progressUpload() {
          setTimeout(() => {
            this.$emit('uploaded');
            Message.success(this.$t('photos.success_uploaded_photos'));
          }, 1500)
      }
    },
    mounted() {
      if (this.avatar) {
        document.getElementById("avatar").src = this.avatar;
        document.getElementById("avatar").style.display = 'block';
      }
    }

  }
</script>

<style>
  .vue-dropzone {
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

  .dropzone .dz-message {
    margin: 0 0;
  }

</style>
