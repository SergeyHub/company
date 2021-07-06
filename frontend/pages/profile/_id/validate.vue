<template>
  <div class="admin">
    <girl-nav/>
    <div class="admin__wrap">
      <div class="container">
        <div class="row admin__verify">

          <Alert
            v-if="showedNotification.id !== undefined && showedNotification.read_at == null"
            @close="setNotificationRead(showedNotification)"
            :closable="true"
          >
            <span v-html="$t('profile_nav.profile_verify_is_rejected')"></span>
            <span v-if="showedNotification.data.reason[lang].length">{{ showedNotification.data.reason[lang] }}</span>
            <span v-else>{{ $t('validation.not_specified') }}</span>
          </Alert>
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
              <router-link :to="localePath({name: 'profile-id-validate-upload', params: {id: current_girl.id}})" class="btn btn-accent">
                {{ $t('validation.verify_identity') }}
              </router-link>
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
  import GirlNav from '~/components/GirlNav'
  import Alert from '~/components/Alert'

  export default {
    layout: 'profile',
    middleware: 'is_girl',

    components: {
    //  SelectTariff,
      DocumentUpload,
      GirlNav,
      Alert
    },
    async asyncData({ store, params }) {
      return store.dispatch('notifications/fetchUnreadNotifications')
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
      ...mapGetters('notifications', [
        'allNotifications'
      ]),
      lang() {
        return this.$i18n.locale
      },
      failedVerificationNotifications() {
        return this.allNotifications.filter(
          (item) => {
            try {
              return item.data.type === 'girls.failed_verification' && item.data.girl_id == this.$route.params.id
            } catch(e) {
              return false
            }
          }
        )
      }
    },
    data() {
      return {
        showedNotification: {}
      }
    },
    created() {
      this.showedNotification = this.failedVerificationNotifications.length ? this.failedVerificationNotifications[0] : {}
    },

    methods: {
      openDocumentModal() {
        this.$refs.documentUploadModal.open();
      },
      setNotificationRead(notification) {
        this.$store.dispatch('notifications/setAsRead', [ notification.id ])
      }
    },

    watch: {
      allNotifications() {
        this.showedNotification = this.failedVerificationNotifications.length ? this.failedVerificationNotifications[0] : {}
      }
    },

    async fetch({ store, params }) {
      await store.dispatch('girls/fetchEditGirl', params.id)
    }
  }
</script>
