<template>
  <div class="mt-3 overflow-hidden">
    <p class="text-center mt-5" v-if="!verified">{{$t('verify.email_verification_pending')}}</p>
    <p class="text-center mt-5" v-else>{{$t('verify.email_verification_success')}}</p>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import { Message } from 'element-ui'
  export default {
    data() {
      return {
        verified: false
      }
    },
    computed: {
      ...mapGetters('auth', ['loggedUser']),
    },
    methods: {
      async verifyEmail() {
        this.$axios.post(`/auth/verify/${this.$route.params.token}`)
          .then((res) => {
            if (res.data.success) {
              Message.success(this.$t('verify.success_verify'))
              if (this.loggedUser) {
                this.$router.push(this.localePath({
                  name: 'profile',
                }))
                this.$store.dispatch('auth/fetchUser');
              } else {
                this.verified = true;
              }
            } else {
              Message.error(this.$t('verify.email_verification_error'))
            }
          })
      }
    },
    mounted() {
      this.verifyEmail();
    }
  }
</script>
