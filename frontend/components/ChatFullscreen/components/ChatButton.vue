<template>
  <a id="prime" class="chat_button" :class="{'is-float': show}" @click.prevent="openChat">
    <i :class="{'far fa-comment':!show, 'fas fa-times': show, 'is-active': show, 'is-visible': show}" />
    <div class="count_unread" v-show="unreadCount">{{ unreadCountFormatted }}</div>
  </a>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    computed: {
      ...mapGetters('auth', ['isAuthentificated']),
      ...mapGetters('chat', ['dialogs', 'unreadCount']),
      unreadCountFormatted() {
        if(this.unreadCount > 9)
          return '9+';
        return this.unreadCount;
      }
    },
    data() {
      return {
        show: false
      }
    },
    methods: {
      openChat() {
        if(this.isAuthentificated && this.dialogs.length) {
          // открываем диалоги
          this.$chat.open()
        } else {
          // открываем поддержку
          this.$intercom.show()
        }
      }
    }
  }
</script>

<style lang="scss">
  .chat_button {
    display: block;
    width: 60px;
    height: 60px;
    text-align: center;
    color: #fff;
    cursor: pointer;
    -webkit-transition: all .1s ease-out;
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 998;
    overflow: hidden;
    box-shadow: rgba(0, 0, 0, 0.06) 0px 1px 6px 0px, rgba(0, 0, 0, 0.16) 0px 2px 32px 0px;
    border-radius: 50%;
    background: rgb(0, 113, 178);
    animation: 250ms ease 0s 1 normal none running animation-bhegco;
    transition: box-shadow 80ms ease-in-out 0s;
    i {
      font-size: 30px;
      line-height: 60px;
      -webkit-transition: all .2s ease-out;
      -webkit-transition: all .2s ease-in-out;
      transition: all .2s ease-in-out;
      color: #fff;
    }
    .count_unread {
      position: fixed;
      right: 60px;
      bottom: 60px;
      z-index: 10;
      background: red;
      color: #fff;
      padding: 2px;
      border-radius: 100%;
      width: 22px;
      height: 22px;
      font-size: 11px;
      border: 1px solid;
      box-shadow: -1px -1px 7px rgba(0,0,0,0.2);
    }
  }
</style>
