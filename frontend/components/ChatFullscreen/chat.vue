<template>
  <div class="chat_fullscreen-wrapper" v-show="show_">
    <div class="chat_fullscreen-left" :class="{active: !currentDialog.id}">
      <div class="chat_fullscreen-options-wrapper">
        <div class="title-options" @click="closeDialog">
          <i class="fas fa-chevron-left"></i>
        </div>
        <div class="title-row">
          {{ $t('dialogs.dialogs') }}
        </div>
      </div>
      <div class="chat_fullscreen-dialogs">
        <dialog-entry
          @openDialog="openDialog"
          :active="currentDialog.id === dialog.id"
          :dialog="dialog"
          v-for="(dialog, index) in dialogs"
          :key="index"/>
      </div>
      <div class="chat_fullscreen-support" @click="openSupport">
        <i class="fas fa-question-circle"></i>
        <span>{{ $t('dialogs.support') }}
          <template v-if="supportUnreadCount">({{ supportUnreadCount }})</template>
        </span>
      </div>
    </div>
    <div class="chat_fullscreen-right" :class="{active: !!currentDialog.id}">
      <dialog-title/>
      <dialog-body/>
      <dialog-input v-show="!!currentDialog.id"/>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import DialogEntry from './components/DialogEntry'
  import DialogInput from './components/DialogInput'
  import DialogTitle from './components/DialogTitle'
  import DialogBody from './components/DialogBody'
  import ChatFullscreen from '~/components/ChatFullscreen'

  export default {
    components: {
      DialogEntry,
      DialogBody,
      DialogTitle,
      DialogInput
    },
    computed: {
      ...mapGetters('auth', ['isAuthentificated']),
      ...mapGetters('chat', ['currentDialog', 'dialogs']),
      supportUnreadCount() {
        return this.$intercom.unreadCount
      }
    },
    data() {
      return {
        show_: false
      }
    },
    watch: {
      show_(newVal, prevVal) {
        document.body.style.overflow = newVal ? 'hidden' : 'auto';
      }
    },
    methods: {
      openSupport() {
        this.$intercom.show()
      },
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
      ChatFullscreen.EventBus.$on('open', (params) => {
        if(params.user_id) {
          this.openDialogWithUser(params.user_id)
        } else {
          this.show_ = true;
        }
      });
      ChatFullscreen.EventBus.$on('close', () => {
        this.closeDialog()
      })
    },
    mounted() {
      if(this.isAuthentificated)
        this.$store.dispatch('chat/fetchDialogs')
    }
  }
</script>

<style lang="scss">
  .chat_fullscreen-wrapper {
    position: fixed;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    z-index: 999999999;
    background: #fff;
    display: flex;
    font-family: "Helvetica Neue", "Apple Color Emoji", Helvetica, Arial, sans-serif !important;
    .chat_fullscreen-left {
      height: 100%;
      width: 20%;
      border-right: 1px solid #eee;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      .chat_fullscreen-options-wrapper {
        width: 100%;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        position: relative;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50px;
        flex: 0 0 50px;
        .title-options {
          -webkit-box-flex: 0;
          -ms-flex: 0 1 30px;
          flex: 0 1 30px;
          text-align: center;
          height: 100%;
          line-height: 50px;
          font-size: 20px;
        }
        .title-row {
          width: 85%;
          text-align: center;
          font-weight: 600;
          font-size: 16px;
        }
      }
      .chat_fullscreen-search-wrapper {
        width: 100%;
        border-bottom: 1px solid #eee;
        padding: 0 10px;
        display: flex;
        align-items: center;
        position: relative;
        height: 50px;
        input {
          border: none;
          background: #eee;
          border-radius: 5px;
          width: 80%;
          transition: width 0.2s;
          padding: 3px 30px;
          line-height: 25px;
          font-size: 16px;
          font-weight: 200;
          &:focus {
            border: none;
            outline: none;
            width: 100%;
          }
        }
        .fa-search {
          position: absolute;
          left: 17px;
          top: 17px;
        }
        .fa-times-circle {
          position: absolute;
          right: 17px;
          top: 17px;
        }
      }
      .chat_fullscreen-support {
        border-top: 1px solid #eee;
        text-align: center;
        align-items: center;
        cursor: pointer;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50px;
        flex: 0 0 50px;
        i {
          color: #fa6b6b;
          margin-right: 5px;
          font-size: 18px;
        }
        span {
          font-size: 20px;
          line-height: 50px;
          text-transform: uppercase;
        }
      }
      .chat_fullscreen-dialogs {
        overflow: auto;
        flex: 1 1 auto;
        .chat_dialog {
          height: 70px;
          border-bottom: 1px solid #eee;
          align-items: center;
          display: flex;
          padding: 0 10px;
          .chat_dialog-avatar-wrapper {
            .chat_dialog-avatar {
              height: 50px;
              width: 50px;
              background-size: cover;
              background-repeat: no-repeat;
              border-radius: 100%;
            }
          }
          .chat_dialog-info {
            width: 100%;
            height: 100%;
            padding: 6px 0 6px 14px;
            .chat_dialog-top {
              display: flex;
              overflow: hidden;
              .chat_dialog-title {
                font-weight: bold;
                width: 50%;
                overflow: hidden;
              }
              .chat_dialog-date {
                width: 50%;
                overflow: hidden;
                text-align: right;
                color: #aaa;
                font-size: 13px;
                margin-top: 3px;
              }
            }
            .chat_dialog-message {
              /* autoprefixer: off */
              -webkit-box-orient: vertical;
              -webkit-line-clamp: 2;
              /* autoprefixer: on */
              font-size: 14px;
              display: block;
              display: -webkit-box;
              max-width: 100%;
              margin: 0 auto;
              line-height: 1;
              overflow: hidden;
              text-overflow: ellipsis;
              font-weight: 200;
              color: #aaa;
            }
          }
          &.active {
            background: #5682a3;
            .chat_dialog-info {
              .chat_dialog-title, .chat_dialog-message, .chat_dialog-date {
                color: #fff
              }
            }
          }
          &.unread {
            background: #7bbcec;
            .chat_dialog-info {
              .chat_dialog-title, .chat_dialog-message, .chat_dialog-date {
                color: #fff
              }
            }
          }
        }
      }
    }
    .chat_fullscreen-right {
      width: 80%;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      .chat_fullscreen-title {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50px;
        flex: 0 0 50px;
        border-bottom: 1px solid #eee;
        align-items: center;
        display: flex;
        padding: 0 20px;
        color: #5a6169!important;
        .title-avatar_wrapper {
          .title-avatar {
            height: 36px;
            width: 36px;
            background-size: cover;
            background-repeat: no-repeat;
            border-radius: 100%;
          }
        }
        .title-info {
          -webkit-box-flex: 1;
          -ms-flex: 1 1 auto;
          flex: 1 1 auto;
          padding: 0 10px;
          .title-name {
            font-weight: 600;
            font-size: 15px;
            line-height: 20px;
          }
          .title-description {
            color: #aaa;
            font-size: 14px;
            line-height: 16px;
          }
        }
        .title-options {
          -webkit-box-flex: 0;
          -ms-flex: 0 0 50px;
          flex: 0 0 50px;
          text-align: center;
          height: 100%;
          line-height: 50px;
          font-size: 20px;
        }
      }
      @media(max-width: 700px) {
        .chat_fullscreen-title {
          padding: 0;
        }
      }
      .chat_fullscreen-body {
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        overflow: auto;
      }
      .chat_fullscreen-input_wrapper {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50px;
        flex: 0 0 50px;
        border-top: 1px solid #eee;
        display: flex;
        align-items: center;
        .input_wrapper-attachment, .input_wrapper-options {
          flex: 0 1 60px;
          line-height: 20px;
          text-align: center;
          vertical-align: middle;
          color: #aaa;
          transition: all 0.2s ease-out;
          &.active {
            color: #5682a3
          }
        }
        input {
          flex: 1 1 auto;
          border: none;
          font-weight: 200;
          font-size: 16px;
          &:active {
            border: none;
            outline: none;
          }
          &:focus {
            border: none;
            outline: none;
          }
        }
        i {
          font-size: 26px;
        }
      }
    }
  }

  .only-mobile {
    display: none;
  }
  @media(max-width: 700px) {
    .only-mobile {
      display: block;
    }
    .chat_fullscreen-wrapper {
      display: flex;
      left: 0;
      right: 0;
      bottom: 0;
      top: -70px;
      padding-bottom: 70px;
      transform: translateY(70px);
      .chat_fullscreen-left {
        transition: all 0.5s ease-out;
        opacity: 0;
        height: 100%;
        position: absolute;
        top: 0;
        right: 100vw;
        &.active {
          display: flex;
          width: 100%;
          opacity: 1;
          right: 0;
        }
      }
      .chat_fullscreen-right {
        transition: all 0.5s ease-out;
        opacity: 0;
        right: -100vw;
        top: 0;
        position: absolute;
        height: 100%;
        &.active {
          width: 100%;
          opacity: 1;
          right: 0;
        }
      }
    }
  }
</style>
