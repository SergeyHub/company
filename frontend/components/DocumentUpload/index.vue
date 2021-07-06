<template>
  <div class="document_modal">
    <modal v-model="showModify" :title="$t('validation.upload_passport')">
      <template slot="header">
        <p class="text-center" v-html="$t('validation.for_verification_need_passport')">
        </p>
      </template>
      <div class="text-center">
        <img :src="cdn_assets + '/img/pass_selfie.png'">
        <b-button variant="primary" class="mt-3 mb-3" @click="selectPhoto" v-loading="loading">
          {{ $t('validation.select_photo') }}
        </b-button>
        <p style="font-size: 12px">
          {{ $t('validation.passport_need_for_verify') }}
        </p>
        <p style="font-size: 12px">
          {{ $t('validation.passport_view_admin') }}
        </p>
      </div>
      <input type="file" id="uploads" style="display: none;" accept="image/png, image/jpeg, image/gif, image/jpg" @change="uploadImg($event)">
    </modal>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import Modal from "../Modal";
  import { Message } from 'element-ui'

  export default {
    components: {Modal},
    data() {
      return {
        showModify: this.value,
        loading: false,
        cdn_assets: process.env.cdn_assets
      }
    },
    watch: {
      showModify(newVal, prevVal) {
        this.$emit('input', newVal)
      },
      value(newVal, prevVal) {
        this.showModify = newVal
      }
    },
    computed: {
      ...mapGetters('girls', ['tariffs', 'current_girl']),
    },
    methods: {
      open() {
        this.showModify = true;
      },
      close() {
        this.showModify = false
      },
      selectPhoto() {
        document.querySelector('#uploads').click()
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

        this.loading = true;

        let formData = {
          file: file
        };

        formData.id = this.current_girl.id;

        this.$store.dispatch('girls/girlUploadDocument', formData)
          .then(() => {
            this.loading = false;
            this.close();
            this.$ga.event('girl', 'document_uploaded');
            this.$emit('uploaded')
          })
          .catch(() => {
            this.loading = false;
            Message.error('Error!')
          })
      }
    }
  }
</script>
