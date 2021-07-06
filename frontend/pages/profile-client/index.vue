<template>
  <div>
    <client-profile :initData="form"/>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import ClientProfile from '~/components/ClientProfile'

  export default {
    layout: 'profile',
    middleware: 'is_client',

    components: {
      ClientProfile
    },

    computed: {
      ...mapGetters('profile', ['client_profile'])
    },

    // head() {
    //   return {
    //     title: this.$t('profile.title')
    //   }
    // },

    async asyncData({ store }) {
      return store.dispatch('profile/fetchClientProfile')
        .then((data) => {
          return {
            form: _.cloneDeep(data)
          }
        })
    },

    methods: {
      validateState(ref) {
        if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
          return !this.errors.has(ref)
        }
        return null
      },

      sendForm() {
        this.$validator.validateAll().then(result => {
          if(!result)
            return;

          this.$store.dispatch('profile/updateAgency', this.form)
            .then(() => {
              this.$toasted.success(this.$t('profile.success_update')).goAway(1000)
            })
        });
      }
    }
  }
</script>
