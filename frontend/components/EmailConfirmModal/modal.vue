<template>
  <modal v-model="showModify"
         :title="$t('auth.check_email_title')"
         size="md">
    <template slot="footer">
      <div class="text-center">
        {{$t('auth.check_email_text')}}
      </div>
      <div class="text-center mt-3">
        <button class="btn btn-sm btn-primary mt-1" @click="emailVerifySend">{{$t('profile_nav.resend_verify_email')}}</button>
      </div>
      <div class="text-center mt-3 text-muted">
        {{$t('auth.check_spam')}}
      </div>
    </template>
  </modal>
</template>

<script>
  import Modal from '~/components/Modal'
  import {mapGetters} from "vuex";
  import {Message} from "element-ui";
  import EmailConfirmModal from './index.js'

  export default {
    props: {
      value: {
        type: Boolean,
        default: () => false
      }
    },
    components: {
      Modal
    },
    data() {
      return {
        showModify: this.value,
      }
    },
    computed: {
      ...mapGetters('auth', ['userForConfirmId'])
    },
    watch: {
      showModify(newVal, prevVal) {
        if (!newVal) {
          this.$store.dispatch('auth/setUserForConfirmId', null)
        }
      }
    },
    methods: {
      open() {
        this.showModify = true;
      },
      emailVerifySend() {
        this.$axios.post('/auth/verify/send/' + this.userForConfirmId)
          .then((response) => {
            if(response.data.success) {
              Message.success(this.$t('verify.email_sended'))
            } else {
              Message.error(this.$t('verify.email_send_error'))
            }
          })
      },
    },
    beforeMount() {
      // here we need to listen for emited events
      // we declared those events inside our plugin
      EmailConfirmModal.EventBus.$on('open', (params) => {
        this.open(params)
      })
    }
  }
</script>

<style>
</style>
