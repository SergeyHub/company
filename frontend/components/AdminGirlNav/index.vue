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
              :to="localePath({name: 'adminkas-mans-id', params: {id: current_girl.id}})"
              :active="isCurrentPath('/adminkas/mans/'+current_girl.id)"
            >
              <!--<div class="step-number" v-if="!profileIsVerified">1</div>-->
              {{ $t('profile_nav.profile') }}
            </router-link>
          </li>
          <li>
            <router-link
              :to="localePath({name: 'adminkas-mans-id-photos', params: {id: current_girl.id}})"
              :class="{inactive: !profileIsFilled, animated: profileIsFilled && !photosIsFilled}"
              :active="isCurrentPath('/adminkas/mans/'+current_girl.id+'/photos')"
              :disabled="!profileIsFilled"
            >
              <!--<div class="step-number" v-if="!profileIsVerified">2</div>-->
              {{ $t('profile_nav.photos') }}
            </router-link>
          </li>
          <li>
            <router-link
              :to="localePath({name: 'adminkas-mans-id-validate', params: {id: current_girl.id}})"
              :class="{inactive: !profileIsFilled || !photosIsFilled, animated: photosIsFilled && !profileIsVerified}"
              :active="isCurrentPath('/adminkas/mans/'+current_girl.id+'/validate')"
              :disabled="!photosIsFilled || !profileIsFilled"
            >
              <!--<div class="step-number" v-if="!profileIsVerified">3</div>-->
              {{ $t('profile_nav.validation') }}
            </router-link>
          </li>
        </ul>

        <!--
        <no-ssr v-if="!profileIsFilled">
          <d-alert class="text-center" theme="light" show>
            <div v-html="$t('profile_nav.fill_profile')"></div>
          </d-alert>
        </no-ssr>

        <no-ssr v-if="profileIsRejected">
          <d-alert class="text-center" theme="light" show>
            <div v-html="$t('profile_nav.profile_is_rejected') + independent_profile.rejected_reason"></div>
          </d-alert>
        </no-ssr>

        <no-ssr v-if="profileVerifyIsRejected">
          <d-alert class="text-center" theme="light" show>
            <div v-html="$t('profile_nav.profile_verify_is_rejected') + independent_profile.rejected_verification_reason"></div>
          </d-alert>
        </no-ssr>

        <no-ssr v-if="profileIsFilled && !photosIsFilled">
          <d-alert class="text-center" theme="light" show>
            <div v-html="$t('profile_nav.fill_avatar')"></div>
          </d-alert>
        </no-ssr>

        <no-ssr v-if="profileIsFilled && photosIsFilled && !profileIsVerified && !profileOnVerify">
          <d-alert class="text-center" theme="light" show>
            <div v-html="$t('profile_nav.verify_your_profile')"></div>
          </d-alert>
        </no-ssr>

        <no-ssr v-if="profileOnInspection">
          <d-alert class="text-center" theme="light" show>
            <div v-html="$t('profile_nav.your_profile_on_verify')"></div>
          </d-alert>
        </no-ssr>
        -->
      </div>
    </no-ssr>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters('girls', [
      'current_girl',
      'profileIsFilled',
      'photosIsFilled',
      'profileIsRejected',
      'profileIsVerified',
      'profileOnVerify',
      'profileVerifyIsRejected',
      'profileOnInspection'
    ]),
    currentPath() {
      return this.$route.path.replace('/' + this.$i18n.locale, '');
    }
  },
  methods: {
    isCurrentPath(path) {
      return path === this.currentPath;
    }
  }
}
</script>
