<template>
  <div class="admin">
    <admin-girl-nav/>
    <div class="admin__wrap">
      <div class="container">
        <div class="row admin__verify">
          <div class="col-12 col-md-12" v-if="profileOnInspection">
            <h2>{{ $t('validation.publication_profile') }}</h2>
            <p>{{ $t('validation.wait_verification') }}</p>
            <p><strong>{{ $t('validation.have_questions') }}</strong></p>
            <p>{{ $t('validation.email_us') }} <strong>support@mybestgigolo.com</strong></p>
          </div>

          <div class="col-12 col-md-12" v-if="profileIsPublished">
            <h2>{{ $t('validation.publication_profile') }}</h2>
            <p v-html="$t('validation.successfully_published')"></p>
          </div>

          <div class="col-12 col-md-12" v-if="!profileIsPublished && !profileOnInspection">
            <h2>{{ $t('validation.publication_profile') }}</h2>
            <div v-html="$t('validation.warning_block')"></div>
            <div v-html="$t('validation.is_it_safe_block')"></div>
          </div>

          <div class="col-12 col-md-12">
            <h2 v-html="$t('validation.id_confirmation')"></h2>
            <template v-if="!profileIsVerified && !profileOnVerify">
              <p v-html="$t('validation.id_confirmation_description')"></p>
            </template>
            <template v-if="profileOnVerify">
              <p>{{ $t('validation.document_on_review') }}</p>
            </template>
            <template v-if="profileIsVerified">
              <p>{{ $t('validation.document_verified') }}</p>
            </template>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "~/utils/event-bus";
import { mapGetters } from 'vuex'
//import SelectTariff from '~/components/SelectTariff'
import DocumentUpload from '~/components/DocumentUpload'
import AdminGirlNav from '~/components/AdminGirlNav'

export default {
  layout: 'admin',

  components: {
    //  SelectTariff,
    DocumentUpload,
    AdminGirlNav
  },

  computed: {
    ...mapGetters('girls', [
      'current_girl',
      'profileIsFilled',
      'photosIsFilled',
      'profileIsRejected',
      'profileIsVerified',
      'profileOnVerify',
      'profileOnInspection',
      'profileVerifyIsRejected',
      'profileIsPublished'
    ]),
  },

  // head() {
  //   return {
  //     title: this.$t('profile_nav.validation')
  //   }
  // },

  methods: {
    openTariffModal() {
      this.$store.dispatch('set');
//        this.$refs.selectTariffModal.open();
    },
    openDocumentModal() {
      this.$refs.documentUploadModal.open();
    }
  },

  async fetch({ store, params }) {
    await store.dispatch('girls/fetchEditGirl', params.id)
  }
}
</script>

<style>
.publication_agreements {
  font-size: 12px;
  text-align: center;
  color: #ccc;
}
</style>
