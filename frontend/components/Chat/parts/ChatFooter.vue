<template>
  <div class="fab_field">
    <a id="fab_send" class="fab is-visible" @click.prevent="send">
      <i class="fab fa-telegram-plane"></i>
    </a>
    <input
      id="chatSend"
      v-model="content"
      name="chat_message"
      placeholder="Send a message"
      v-on:keyup.enter="send"
      class="chat_field chat_message">
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    computed: {
      ...mapGetters('chat', ['currentDialog'])
    },
    data() {
      return {
        content: ''
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

<style>
  .fab_field {
    width: 100%;
    display: inline-block;
    text-align: center;
    background: #fff;
    border-top: 1px solid #eee;
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
    -webkit-box-flex: 0;
    -ms-flex: 0 1 40px;
    flex: 0 1 40px;
  }

  .chat_field {
    position: relative;
    margin: 5px 0 5px 0;
    width: 70%;
    font-size: 12px;
    line-height: 30px;
    font-weight: 500;
    color: #4b4b4b;
    -webkit-font-smoothing: antialiased;
    font-smoothing: antialiased;
    border: none;
    outline: none;
    display: inline-block;
  }

  .chat_field.chat_message {
    height: 30px;
    resize: none;
    font-size: 13px;
    font-weight: 400;
    line-height: 32px;
    overflow: hidden;
  }
</style>
