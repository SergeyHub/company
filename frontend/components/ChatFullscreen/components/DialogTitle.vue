<template>
  <a href="#" @click.prevent="openPage"
    class="chat_fullscreen-title"
    v-if="currentDialog.id"
  >
    <div class="title-options only-mobile" @click="$store.dispatch('chat/setCurrentDialog', {})">
      <i class="fas fa-chevron-left"></i>
    </div>
    <div class="title-avatar_wrapper">
      <div class="title-avatar" :style="{ 'background-image': 'url(' + currentDialog.avatar + ')' }">
      </div>
    </div>
    <div class="title-info">
      <div class="title-name">
        {{ currentDialog.recipient ? currentDialog.recipient.name : 'Not found' }}
      </div>
    </div>
    <div class="title-options">

    </div>
  </a>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    computed: {
      ...mapGetters('chat', ['currentDialog'])
    },

    methods: {
      openPage() {
        if(!this.currentDialog.recipient || this.currentDialog.recipient.type !== 'girl')
          return;
        this.$router.push(
          this.localePath({name: 'mans-id', params: {id: this.currentDialog.recipient.girl_id}})
        );
        this.closeChat()
      },

      closeChat() {
        this.$chat.close()
      }
    }
  }
</script>
