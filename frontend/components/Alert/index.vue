<template>
  <div
    class="alert"
  >
    <div
      class="alert__close"
      v-if="closable"
      @click="$emit('close')"
    >✕</div>
    <div class="alert__title">
      <slot name="title"/>
    </div>
    <div class="alert__content">
      <slot/>
    </div>
  </div>
</template>
<script>
  export default {
    props: {
      closable: {
        type: Boolean,
        default: false
      }
    }
  }
</script>
