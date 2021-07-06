<template>
  <div>
    <agency-girl-nav/>

    <div class="row mb-4" v-if="profileOnInspection">
      <div class="col-md-7">
        <div class="Typography_h2">{{ $t('validation.publication_profile') }}</div>
        <p>{{ $t('validation.wait_verification') }}</p>
        <p><strong>{{ $t('validation.have_questions') }}</strong></p>
        <p>{{ $t('validation.email_us') }} <strong>support@mybestgigolo.com</strong></p>
      </div>
    </div>

    <div class="row mb-4" v-if="profileIsPublished">
      <div class="col-md-7">
        <div class="Typography_h2">{{ $t('validation.publication_profile') }}</div>
        <p>{{ $t('validation.successfully_published') }}</p>
      </div>
    </div>

    <div class="row mb-4" v-if="!profileIsPublished && !profileOnInspection">
      <div class="col-md-7">
        <div class="Typography_h2">{{ $t('validation.publication_profile') }}</div>
        <div v-html="$t('validation.warning_block')"></div>
        <div v-html="$t('validation.is_it_safe_block')"></div>
      </div>
      <div class="col-md-5">
        <div class="Typography_h2">
          {{ $t('validation.checked_all_data') }}
        </div>
        <p class="publication_agreements">
          {{ $t('validation.before_sending') }}
          <a :href="localePath('terms')" target="_blank">
            <span>{{ $t('auth.terms_of_use') }}</span>
          </a>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-7">
        <div class="Typography_h2">
          {{ $t('validation.id_confirmation') }}
        </div>
        <template v-if="!profileIsVerified && !profileOnVerify">
          <p>{{ $t('validation.id_confirmation_description') }}</p>
          <b-btn variant="primary" @click="openDocumentModal">
            {{ $t('validation.verify_identity') }}
          </b-btn>
        </template>
        <template v-if="profileOnVerify">
          {{ $t('validation.document_on_review') }}
        </template>
        <template v-if="profileIsVerified">
          {{ $t('validation.document_verified') }}
        </template>
      </div>
    </div>
    <document-upload ref="documentUploadModal" @uploaded="openTariffModal" />
  </div>
</template>

<script>
  import { EventBus } from "~/utils/event-bus";
  import { mapGetters } from 'vuex'
  import DocumentUpload from '~/components/DocumentUpload'
  import AgencyGirlNav from '~/components/AgencyGirlNav'

  export default {
    layout: 'profile',
    middleware: 'is_agency',

    components: {
      DocumentUpload,
      AgencyGirlNav
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
