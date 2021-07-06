<template>
  <accordion icon="fa-edit">
    <template slot="title">
      Reviews
    </template>
    <template slot="body">
      Not reviews
    </template>
  </accordion>
</template>

<script>
  import Accordion from '~/components/Accordion'

  export default {
    components: {
      Accordion
    }
  }
</script>
