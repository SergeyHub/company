<template>
  <div class="chat_header" v-if="currentDialog.recipient">
    <div class="chat_option">
      <div class="header_img">
        <div class="header_img_bg" :style="{'background-image': 'url('+currentDialog.avatar+')'}"/>
      </div>
      <span id="chat_head">{{ currentDialog.recipient.name }}</span>
      <br>
      <span class="agent">{{ currentDialog.recipient.type }}</span>
      <span class="online">(Online)</span>
      <i class="fas fa-times" @click="$emit('close')"></i>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    computed: {
      ...mapGetters('chat', ['currentDialog'])
    }
  }
</script>

<style>
  .chat_header {
    font-size: 13px;
    font-weight: 500;
    color: #f3f3f3;
    background: #fa6b6b;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    padding-top: 8px;
    -webkit-box-flex: 0;
    -ms-flex: 0 1 45px;
    flex: 0 1 45px;
  }
  .chat_header .fa-times {
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 30px;
    cursor: pointer;
  }
  .chat_header .span {
    float:right;
  }
  .chat_option {
    float: left;
    font-size: 15px;
    list-style: none;
    position: relative;
    height: 100%;
    width: 100%;
    text-align: relative;
    letter-spacing: 0.5px;
    font-weight: 400
  }

  .chat_option .header_img_bg {
    border-radius: 50%;
    width: 55px;
    height: 55px;
    background-size: cover;
    float: left;
    margin: 0px 20px 10px 20px;
    border: 4px solid rgba(0, 0, 0, 0.21);
  }

  .change_img img{
    width: 35px;
    margin: 0px 20px 0px 20px;
  }
  .chat_option .agent {
    font-size: 12px;
    font-weight: 300;
  }
  .chat_option .online{
    opacity: 0.4;
    font-size: 11px;
    font-weight: 300;
  }
</style>
