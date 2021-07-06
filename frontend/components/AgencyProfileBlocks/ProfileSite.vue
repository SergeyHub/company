<template>
  <accordion icon="fa-globe">
    <template slot="title">
      {{ $t('public_profile.site') }}
    </template>
    <template slot="body">
      <a :href="agency.profile_site.url" target="_blank">{{ agency.profile_site.url }}</a>
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
