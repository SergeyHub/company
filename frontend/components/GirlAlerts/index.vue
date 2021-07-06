<template>
  <div>
    <template v-if="publishButtonActive">
      <d-alert class="text-center" theme="light" show>
        <div v-html="$t('profile_nav.profile_active_to_publish')"></div>
      </d-alert>
      <d-button theme="success" class="w-100 mb-1" @click="publishAction">
        {{ $t('profile_nav.publish_profile') }}
      </d-button>
      <hr>
    </template>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    computed: {
      ...mapGetters('auth', ['loggedUser', 'userType']),
      ...mapGetters('girls', ['current_girl', 'current_girl_avatar']),
      publishButtonActive() {
        return this.current_girl_avatar && this.current_girl.status === 'active'
          && this.current_girl.country;
      }
    },
    methods: {
      publishAction() {
        this.$store.dispatch('girls/publishProfile', this.current_girl.id)
          .then((response) => {
            this.$toasted.success(this.$t('profile_nav.success_published')).goAway(1000)
          })
      }
    },
  }
</script>
