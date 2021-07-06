<template>
  <accordion icon="fa-mobile-alt" class="detail-block-phone">
    <template slot="title">
      {{ $t('public_profile.call_mobile') }}
    </template>
    <template slot="body">
        <img :src="current_girl.phone_image"/>
        <div class="contact-options" v-if="current_girl.contact_methods.length">
          <div>
            {{ current_girl.contact_methods.join(' • ') }}
          </div>
        </div>
        <div class="language-badges" v-if="current_girl.languages.length">
          <div class="language-badge"
               v-for="language in current_girl.languages"
               :key="language">
            {{ language }}
          </div>
        </div>
    </template>
  </accordion>
</template>

<script>
  import Accordion from '~/components/Accordion'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      Accordion
    },
    computed: {
      ...mapGetters('girls', ['current_girl'])
    }
  }
</script>
