<template>
  <div id="chat_converse"
       class="chat_conversion chat_converse"
       v-infinite-scroll="loadMore"
       infinite-scroll-disabled="busy"
       infinite-scroll-distance="10">
    <message
      v-for="(message, index) in messages"
      :message="message"
      :key="index" />
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import Message from './Message'

  export default {
    components: {
      Message
    },
    computed: {
      ...mapGetters('support', ['messages'])
    },
    data() {
      return {
        busy: false
      }
    },
    watch: {
      messages: {
        deep: true,
        handler(newVal, prevVal) {
          this.$nextTick(() => {
            this.scrollToBottom()
          })
        }
      }
    },
    methods: {
      loadMore() {
        this.busy = true;
        this.$store.dispatch('support/fetchMessages')
          .then(() => {
            this.busy = true;
            this.scrollToBottom();
          })
      },
      scrollToBottom() {
        var objDiv = document.getElementById("chat_converse");
        objDiv.scrollTop = objDiv.scrollHeight;
      }
    }
  }
</script>
