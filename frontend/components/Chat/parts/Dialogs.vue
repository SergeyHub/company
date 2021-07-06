<template>
  <div class="chat-dialogs-wrapper">
    <dialog-tab
      v-for="(dialog, index) in dialogs"
      :dialog="dialog"
      :active="currentDialog.id === dialog.id"
      @selectDialog="$emit('openDialog', dialog)"
      :key="index"
    />
  </div>
</template>

<script>
  import DialogTab from './DialogTab'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      DialogTab
    },
    computed: {
      ...mapGetters('chat', ['dialogs', 'currentDialog'])
    },
    mounted() {
      this.$store.dispatch('chat/fetchDialogs')
    }
  }
</script>

<style>
  .chat-dialogs-wrapper {
    position: absolute;
    left: 15px;
    bottom: 25px;
    text-align: center;
    z-index: 1500;
    background-color: #dae1e8;
    border-radius: 3px;
    overflow: hidden;
  }

  .chat_tab_wrap {
    display: block;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    padding: 5px;
  }

  .chat_tab_imgcont {
    position: relative;
    -o-transition: height 100ms ease-in-out, opacity 100ms ease-in-out;
    transition: height 100ms ease-in-out, opacity 100ms ease-in-out;
  }

  .chat_tab_img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-size: cover;
    vertical-align: middle;
  }
</style>
