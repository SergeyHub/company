<template>
  <div class="fab_field">
    <a id="fab_send" class="fab is-visible" @click.prevent="send">
      <i class="fab fa-telegram-plane"></i>
    </a>
    <textarea id="chatSend" v-model="content" name="chat_message" placeholder="Send a message" class="chat_field chat_message"></textarea>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        content: ''
      }
    },
    methods: {
      send() {
        if(!this.content || !this.content.length)
          return;
        this.$store.dispatch('support/sendMessage', {content: this.content})
          .then(() => {
            this.content = '';
          })
      }
    }
  }
</script>
