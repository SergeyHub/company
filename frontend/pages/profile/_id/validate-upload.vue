<template>
  <div>
    <no-ssr>
      <div class="admin__nav">
        <div class="container">
          <ul>
            <li class="pointer">
              <a @click.prevent="$router.go(-1)">{{ $t('auth.back') }}</a>
            </li>
          </ul>
        </div>
      </div>
    </no-ssr>
    <div class="admin__wrap">
      <div class="container">
        <div class="admin__verify admin__verify-upload center">
          <div class="col-12 col-md-12">
            <h1 v-html="$t('validation.upload_passport')"></h1>
            <p v-html="$t('validation.for_verification_need_passport')"></p>
            <div class="admin__verify-upload-img">
              <img :src="cdn_assets_prefix + '/img/verify.jpg'" alt="">
            </div>
            <button
              class="btn btn-border"
              @click="selectPhoto"
              v-loading="loading"
            >
              {{ $t('validation.select_photo') }}
            </button>
            <p>{{ $t('validation.passport_need_for_verify') }}</p>
            <p>{{ $t('validation.passport_view_admin') }}</p>
          </div>
        </div>
      </div>
    </div>
    <input type="file" id="uploads" style="display: none;" accept="image/png, image/jpeg, image/gif, image/jpg" @change="uploadImg($event)">
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
import { Message } from 'element-ui'

export default {
  data() {
    return {
      loading: false,
      cdn_assets: process.env.cdn_assets
    }
  },
  watch: {
    value(newVal, prevVal) {
      this.showModify = newVal
    }
  },
  computed: {
    ...mapGetters('girls', ['tariffs', 'current_girl']),
  },
  methods: {
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

      formData.id = this.$route.params.id;

      this.$store.dispatch('girls/girlUploadDocument', formData)
        .then(() => {
          this.loading = false;
          this.$router.push(this.localePath({
            name: 'profile-id-validate',
            params: {id: this.$route.params.id}
          }))
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
