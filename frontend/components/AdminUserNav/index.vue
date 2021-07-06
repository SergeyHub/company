<template>
  <div class="admin__nav">
    <no-ssr>
      <div  class="container">
        <!--<div class="Typography_h2 mb-4">
        {{ $t('profile_nav.editing_girl') }} (ID #{{current_girl.id}}, {{current_girl.name}})
      </div>-->

        <ul>
          <li>
            <router-link
              :to="localePath({name: 'adminkas-users-id-mans', params: {id: userId}})"
              :active="isCurrentPath('/adminkas/users/'+userId+'/girls')"
            >
              <!--<div class="step-number" v-if="!profileIsVerified">1</div>-->
              {{ $t('profile_nav.girls') }}
            </router-link>
          </li>
          <li>
            <router-link
              :to="localePath({name: 'adminkas-users-id-settings', params: {id: userId}})"
              :active="isCurrentPath('/adminkas/users/'+userId+'/settings')"
            >
              {{ $t('profile_nav.settings') }}
            </router-link>
          </li>
        </ul>
      </div>
    </no-ssr>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters('users', ['current_user']),
    currentPath() {
      return this.$route.path.replace('/' + this.$i18n.locale, '');
    },
    userId() {
      return this.$route.params.id
    }
  },
  methods: {
    isCurrentPath(path) {
      return path === this.currentPath;
    }
  }
}
</script>
