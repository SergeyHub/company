<template>
  <div class="chat-wrapper">
    <div class="chat" :class="{'is-visible':show_}">
      <chat-header @close="closeDialog"/>
      <chat-conversation v-if="show_"/>
      <chat-footer/>
    </div>
    <dialogs @openDialog="openDialog" />
  </div>
</template>

<script>
  import Dialogs from './parts/Dialogs'
  import ChatHeader from './parts/ChatHeader'
  import ChatFooter from './parts/ChatFooter'
  import ChatConversation from './parts/ChatConversation'
  import { mapGetters } from 'vuex'
  import Chat from '~/components/Chat'

  export default {
    components: {
      Dialogs,
      ChatHeader,
      ChatFooter,
      ChatConversation
    },

    data() {
      return {
        show_: false
      }
    },

    computed: {
      ...mapGetters('chat', ['currentDialog', 'dialogs'])
    },

    methods: {
      openDialog(dialog) {
        this.$store.dispatch('chat/resetMessages');
        this.$store.dispatch('chat/setCurrentDialog', dialog);
        this.show_ = true;
      },
      closeDialog() {
        this.$store.dispatch('chat/resetMessages');
        this.$store.dispatch('chat/setCurrentDialog', {});
        this.show_ = false;
      },
      openDialogWithUser(user_id) {
        let dialogs = this.dialogs.filter(dialog => dialog.recipient && dialog.recipient.id == user_id);
        if(dialogs.length) {
          this.openDialog(dialogs[0])
        }
      }
    },

    beforeMount() {
      Chat.EventBus.$on('open', (params) => {
        if(params.user_id) {
          this.openDialogWithUser(params.user_id)
        }
      })
    }
  }
</script>

<style lang="scss">
  .chat-wrapper {
    position: fixed;
    left: 0;
    bottom: 0;
    z-index: 99999999;
  }
  .chat {
    display: none;
    position: absolute;
    left: 85px;
    bottom: 20px;
    width: 300px;
    font-size: 12px;
    line-height: 22px;
    font-weight: 500;
    -webkit-font-smoothing: antialiased;
    font-smoothing: antialiased;
    box-shadow: 1px 1px 100px 2px rgba(0, 0, 0, 0.22);
    border-radius: 10px;
    -webkit-transition: all .2s ease-out;
    -webkit-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
    overflow: hidden;
    height: 400px;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    background: #fff;
    opacity: 0;
  }

  .chat.is-visible {
    opacity: 1;
    display: flex;
    -webkit-animation: zoomInTwo .2s cubic-bezier(.42, 0, .58, 1);
    animation: zoomInTwo .2s cubic-bezier(.42, 0, .58, 1);
  }


  #fab_send {
    float: right;
    background: rgba(0, 0, 0, 0);
    width: 20%;
  }

  #fab_send .fa-telegram-plane {
    background: #fff;
    cursor: pointer;
    line-height: 45px;
    font-size: 22px;
  }

  .chat_converse {
    position: relative;
    background: #fff;
    margin: 6px 0 0px 0;
    min-height: 0;
    font-size: 12px;
    line-height: 18px;
    overflow-y: auto;
    width: 100%;
    float: right;
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
  }

  .chat .chat_converse .chat_msg_item {
    position: relative;
    margin: 8px 0 15px 0;
    padding: 8px 10px;
    max-width: 60%;
    display: block;
    word-wrap: break-word;
    border-radius: 3px;
    -webkit-animation: zoomInTwo .5s cubic-bezier(.42, 0, .58, 1);
    animation: zoomInTwo .5s cubic-bezier(.42, 0, .58, 1);
    clear: both;
    z-index: 999;
  }
  .status {
    margin: 45px -50px 0 0;
    float: right;
    font-size: 11px;
    opacity: 0.3;
  }
  .status2 {
    margin: -10px 20px 0 0;
    float: right;
    display: block;
    font-size: 11px;
    opacity: 0.3;
  }
  .chat .chat_converse .chat_msg_item .chat_avatar {
    position: absolute;
    top: 0;
  }

  .chat .chat_converse .chat_msg_item.chat_msg_item_admin .chat_avatar {
    left: -52px;
    background: rgba(0, 0, 0, 0.03);
  }

  .chat .chat_converse .chat_msg_item.chat_msg_item_user .chat_avatar {
    right: -52px;
    background: rgba(0, 0, 0, 0.6);
  }

  .chat .chat_converse .chat_msg_item .chat_avatar, .chat_avatar img{
    width: 40px;
    height: 40px;
    text-align: center;
    border-radius: 50%;
  }

  .chat .chat_converse .chat_msg_item.chat_msg_item_admin {
    margin-left: 60px;
    float: left;
    background: rgba(0, 0, 0, 0.03);
    color: #666;
  }

  .chat .chat_converse .chat_msg_item.chat_msg_item_user {
    margin-right: 20px;
    float: right;
    background: #42a5f5;
    color: #eceff1;
  }

  .chat .chat_converse .chat_msg_item.chat_msg_item_admin:before {
    content: '';
    position: absolute;
    top: 15px;
    left: -12px;
    z-index: 998;
    border: 6px solid transparent;
    border-right-color: rgba(255, 255, 255, .4);
  }

  @keyframes zoomInTwo {
    0% {
      -webkit-transform: scale(0);
      transform: scale(0);
      opacity: 0.0;
    }
    100% {
      -webkit-transform: scale(1);
      transform: scale(1);
      opacity: 1;
    }
  }
</style>
