<template>
  <div class="chat_fullscreen-input_wrapper">
    <div class="input_wrapper-attachment">
      <i class="fas fa-paperclip"></i>
    </div>
    <input id="chat_input"
           type="text"
           v-model="content"
           :placeholder="$t('dialogs.write_message')"
           v-on:keyup.enter="send">
    <div class="input_wrapper-options"
         @click="send"
         :class="{active: content && content.length}">
      <i class="fab fa-telegram-plane"></i>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import { isMobileDevice } from "../../../utils";

  export default {
    computed: {
      ...mapGetters('chat', ['currentDialog'])
    },
    watch: {
      currentDialog: {
        deep: true,
        handler(newVal, prevVal) {
          if(newVal.id && !isMobileDevice()) {
            document.getElementById('chat_input').focus()
          }
        }
      }
    },
    data() {
      return {
        content: '',
      }
    },
    methods: {
      send() {
        if(!this.content || !this.content.length)
          return;
        this.$store.dispatch('chat/sendMessage', {
          content: this.content,
          user_to: this.currentDialog.recipient.id
        }).then(() => {
          this.content = '';
        })
      }
    }
  }
</script>
