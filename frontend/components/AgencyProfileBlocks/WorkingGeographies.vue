<template>
  <accordion icon="fa-globe">
    <template slot="title">
      {{ $t('public_profile.working_areas') }}
    </template>
    <template slot="body">
      {{ agency.geographies.join(', ') }}
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
