<template>
  <div class="chat_tab_wrap" :class="{active: active}" @click="!active ? $emit('selectDialog') : ''">
    <div class="chat_tab_imgcont">
      <div class="chat_tab_img" :style="{'background-image':'url('+dialog.avatar+')'}"></div>
    </div>
    <div class="chat_tab_typing_wrap">
      <div class="chats_sp chat_tab_typing_icon"></div>
    </div>
    <div class="chat_tab_counter"></div>
  </div>
</template>

<script>
  export default {
    props: {
      dialog: {
        type: Object,
        default: () => {}
      },
      active: {
        type: Boolean,
        default: () => false
      }
    }
  }
</script>

<style>
  .chat_tab_wrap.active .chat_tab_img {
    border: 2px solid yellow;
  }
</style>
