<template>
  <div>
    <div class="profile__contact-row">
      <h3 class="profile__contact-title">{{ $t('public_profile.contacts') }}:</h3>

      <div class="profile__contact-inner">
        <div class="profile__contact-phone">
          <img :src="current_girl.phone_image"/>
        </div>
        <div class="profile__contact-messenger">
          <template v-for="(method, index) in current_girl.contact_methods">
            <div class="profile__contact-item" :key="method">{{ method }}</div>
            <div v-show="(index+1) < current_girl.contact_methods.length" class="profile__contact-item" :key="method"><ins>•</ins></div>
          </template>
        </div>
        <div class="profile__contact-lang">
          <template
            v-for="(language, index) in current_girl.languages"
          >
            <div :key="language" class="profile__contact-item">{{ language }}</div>
            <div :key="language" v-show="(index+1) < current_girl.languages.length" class="profile__contact-item"><ins>•</ins></div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import {mapGetters} from "vuex";

  export default {
    computed: {
      ...mapGetters('girls', ['current_girl']),
    }
  }
</script>
