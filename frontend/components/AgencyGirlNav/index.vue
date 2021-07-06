<template>
  <div>
    <div class="Typography_h2 mb-4">
      Редактирование модели (ID #{{current_girl.id}}, {{current_girl.name}})
    </div>

      <b-nav pills class="profile-nav">
        <b-nav-item :to="localePath({name: 'profile-agency-mans-id', params: {id: current_girl.id}})"
                    :active="isCurrentPath('/profile-agency/girls/'+current_girl.id)">
          <div class="step-number" v-if="!profileIsVerified">1</div>
          <div class="nav-inside">
            <div class="nav-icon profile-icon">
              {{ $t('profile_nav.profile') }}
            </div>
          </div>
        </b-nav-item>
        <b-nav-item :to="localePath({name: 'profile-agency-mans-id-photos', params: {id: current_girl.id}})"
                    :class="{inactive: !profileIsFilled, animated: profileIsFilled && !photosIsFilled}"
                    :active="isCurrentPath('/profile-agency/girls/'+current_girl.id+'/photos')"
                    :disabled="!profileIsFilled">
          <div class="step-number" v-if="!profileIsVerified">2</div>
          <div class="nav-inside">
            <div class="nav-icon photos-icon">
              {{ $t('profile_nav.photos') }}
            </div>
          </div>
        </b-nav-item>
        <b-nav-item :to="localePath({name: 'profile-agency-mans-id-validate', params: {id: current_girl.id}})"
                    :class="{inactive: !profileIsFilled || !photosIsFilled, animated: photosIsFilled && !profileIsVerified}"
                    :active="isCurrentPath('/profile-agency/girls/'+current_girl.id+'/validate')"
                    :disabled="!photosIsFilled || !profileIsFilled">
          <div class="step-number" v-if="!profileIsVerified">3</div>
          <div class="nav-inside">
            <div class="nav-icon validation-icon">
              {{ $t('profile_nav.validation') }}
            </div>
          </div>
        </b-nav-item>
      </b-nav>

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
        return this.currentPath === path;
      }
    }
  }
</script>
