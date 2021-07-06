<template>
  <i class="far fa-question-circle" v-tooltip="$props.content"></i>
</template>
<script>
export default {
  props: {
    content: {
      default: ''
    }
  }
}
</script>
