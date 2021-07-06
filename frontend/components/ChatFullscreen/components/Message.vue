<template>
    <span class="chat_msg_item"
          :class="message.from_me ? 'chat_msg_item_user' : 'chat_msg_item_admin'">
      <div class="chat_avatar" v-if="!message.from_me">
        <img :src="currentDialog.avatar"/>
      </div>
      {{ message.content }}
    </span>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    props: {
      message: {
        required: true,
        type: Object
      }
    },
    computed: {
      ...mapGetters('chat', ['currentDialog'])
    }
  }
</script>

<style>
  .chat_msg_item {
    position: relative;
    margin: 8px 0 15px 0;
    padding: 8px 10px;
    max-width: 60%;
    display: block;
    word-wrap: break-word;
    border-radius: 3px;
    clear: both;
    z-index: 999;
  }
  .chat_msg_item .chat_avatar {
    position: absolute;
    top: 0;
  }

  .chat_msg_item.chat_msg_item_admin .chat_avatar {
    left: -52px;
    background: rgba(0, 0, 0, 0.03);
  }

  .chat_msg_item.chat_msg_item_user .chat_avatar {
    right: -52px;
    background: rgba(0, 0, 0, 0.6);
  }

  .chat_msg_item .chat_avatar, .chat_avatar img {
    width: 40px;
    height: 40px;
    text-align: center;
    border-radius: 50%;
  }

  .chat_msg_item.chat_msg_item_admin {
    margin-left: 60px;
    float: left;
    background: rgba(0, 0, 0, 0.03);
    color: #666;
  }

  .chat_msg_item.chat_msg_item_user {
    margin-right: 20px;
    float: right;
    background: #42a5f5;
    color: #eceff1;
  }

  .chat_msg_item.chat_msg_item_admin:before {
    content: '';
    position: absolute;
    top: 15px;
    left: -12px;
    z-index: 998;
    border: 6px solid transparent;
    border-right-color: rgba(255, 255, 255, .4);
  }
</style>
