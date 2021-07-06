<template>
  <accordion icon="fa-mobile-alt" class="detail-block-phone">
    <template slot="title">
      {{ $t('public_profile.call_mobile_agency') }}
    </template>
    <template slot="body">
      <img :src="agency.phone_image"/>
      <div class="contact-options" v-if="agency.contact_methods.length">
        <div>
          {{ agency.contact_methods.join(' • ') }}
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
      ...mapGetters('agencies', ['agency'])
    }
  }
</script>
