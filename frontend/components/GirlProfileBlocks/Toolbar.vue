<template>
  <div
    v-show="visible"
    class="profile__toolbar"
  >
    <AppButton mode="custom" class="btn-border btn btn-icon" @click.native="scrollTop">↑</AppButton>
    <AppButton mode="accent" class="btn-mess" @click.native="$emit('showMessageModal')"> {{ $t('public_profile.send_message') }} </AppButton>
  </div>
</template>
<script>
import AppButton from '~/components/AppButton'

export default {
  components: {
    AppButton
  },
  data() {
    return {
      visible: false
    }
  },
  mounted() {
    this.onScroll()
    document.querySelector('body').onscroll = this.onScroll.bind(this)
  },
  methods: {
    onScroll(e) {
      if(window.scrollY > 50) {
        this.visible = true
      } else {
        this.visible = false
      }
    },
    scrollTop() {
      $("html").animate({"scrollTop":0},"slow");
    }
  }
}
</script>
