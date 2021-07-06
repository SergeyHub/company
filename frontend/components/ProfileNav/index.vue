<template>
  <div class="admin__nav" v-if="loggedUser">
    <div class="container">
      <template v-if="isGirl">
        <!--<no-ssr v-if="!profileIsFilled">
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
        </no-ssr>-->

        <ul v-if="isGirl">
          <li>
            <router-link :to="localePath('profile')" :active="isCurrentPath('/profile')">
              {{ $t('profile_nav.profiles') }}
            </router-link>
          </li>
          <li>
            <router-link :to="localePath('profile-settings')" :active="isCurrentPath('/profile/settings')">
              {{ $t('profile_nav.settings') }}
            </router-link>
          </li>
          <li>
            <router-link :to="localePath('profile-orders')" :active="isCurrentPath('/profile/orders')">
              {{ $t('profile_nav.orders') }}
            </router-link>
          </li>
        </ul>
      </template>

      <ul v-if="isClient">
        <li>
          <router-link :to="localePath('profile-client')" :active="isCurrentPath('/profile-client')">
            {{ $t('profile_nav.profile') }}
          </router-link>
        </li>
        <li>
          <router-link :to="localePath('profile-client-settings')" :active="isCurrentPath('/profile-client/settings')">
            {{ $t('profile_nav.settings') }}
          </router-link>
        </li>
        <li>
          <router-link :to="localePath('profile-client-orders')" :active="isCurrentPath('/profile-client/orders')">
            {{ $t('profile_nav.orders') }}
          </router-link>
        </li>
        <li>
          <router-link
            :to="localePath('profile-client-favorites')"
            :active="isCurrentPath('/profile-client/favorites')">
            {{ $t('profile_nav.favorites') }}
          </router-link>
        </li>
        <li>
          <router-link
            :to="localePath('profile-client-hidden')"
            :active="isCurrentPath('/profile-client/hidden')">
            {{ $t('profile_nav.hidden') }}
          </router-link>
        </li>
      </ul>

      <template v-if="isAgency">
        <no-ssr v-if="!agencyProfileIsPublished">
          <div class="text-center" theme="light" show>
            <div v-html="$t('profile_nav.agency_inactive')"></div>
          </div>
        </no-ssr>
      </template>
      <template v-if="!loggedUser.email_verified_at">
        <div class="text-center" theme="light" show>
          <div v-html="$t('profile_nav.email_unverified')"></div>
          <button class="btn btn-sm btn-primary mt-1" @click="emailVerifySend">{{$t('profile_nav.resend_verify_email')}}</button>
        </div>
      </template>

      <ul pills class="profile-nav" v-if="isAgency">
        <li>
          <router-link :to="localePath('profile-agency-mans')" :active="isCurrentPath('/profile-agency/girls')" id="tooltip-button-4">
            {{ $t('profile_nav.girls') }}
          </router-link>
        </li>
        <li>
          <router-link
            :to="localePath('profile-agency')"
            :active="isCurrentPath('/profile-agency')"
            :class="{animated: !agencyProfileIsPublished}"
          >
              {{ $t('profile_nav.profile') }}
          </router-link>
        </li>
        <li>
          <router-link :to="localePath('profile-agency-settings')" :active="isCurrentPath('/profile-agency/settings')">
            {{ $t('profile_nav.settings') }}
          </router-link>
        </li>
        <li>
          <router-link :to="localePath('profile-agency-orders')" :active="isCurrentPath('/profile-agency/orders')">
            {{ $t('profile_nav.orders') }}
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import {Message} from "element-ui";

  export default {
    computed: {
      ...mapGetters('auth', ['loggedUser', 'isClient', 'isGirl', 'isAgency']),
      ...mapGetters('profile', [
        'independent_profile',
        'independent_profile_avatar',
        'profileIsFilled',
        'photosIsFilled',
        'profileIsRejected',
        'profileVerifyIsRejected',
        'profileIsVerified',
        'profileIsPublished',
        'profileOnVerify',
        'client_profile',
        'profileOnInspection',
        'agencyProfileIsPublished',
      ]),
      currentPath() {
        return this.$route.path.replace('/' + this.$i18n.locale, '');
      }
    },
    methods: {
      isCurrentPath(path) {
        return this.currentPath === path;
      },
      emailVerifySend() {
        this.$axios.post('/auth/verify/send/' + this.loggedUser.id)
          .then((response) => {
            if(response.data.success) {
                Message.success(this.$t('verify.email_sended'))
            } else {
              Message.error(this.$t('verify.email_send_error'))
            }
          })
      },
    },
    async mounted() {
      if(this.isClient && !this.client_profile.id) {
        await this.$store.dispatch('profile/fetchClientProfile')
      }
    }
  }
</script>
