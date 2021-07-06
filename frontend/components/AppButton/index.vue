<template>
  <component :is="tag"
    :class="{
      'btn btn-accent': $props.mode == 'default' || $props.mode == 'accent',
      'btn btn-icon btn-reviews': $props.mode == 'dark',
      'btn btn-border': $props.mode == 'dark-border',
      'btn-custom': ''
    }"
  >
    <slot/>
  </component>
</template>
<script>
  export default {
    props: {
      mode: {
        default: 'default'
      },
      tag: {
        default: 'button'
      }
    },

  }
</script>
