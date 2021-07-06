<template>
  <div class="chat_dialog"
       :class="{active: active, unread: dialog.lastMessage && !dialog.lastMessage.read && !dialog.lastMessage.from_me}"
       @click="!active ? $emit('openDialog', dialog) : ''">
    <div class="chat_dialog-avatar-wrapper">
      <div class="chat_dialog-avatar" :style="{ 'background-image': 'url(' + dialog.avatar + ')' }">
      </div>
    </div>
    <div class="chat_dialog-info">
      <div class="chat_dialog-top">
        <span class="chat_dialog-title">{{ dialog.recipient ? dialog.recipient.name : 'Not found' }}</span>
        <span class="chat_dialog-date" v-if="dialog.lastMessage">
          {{ lastMessageDate }}
        </span>
      </div>
      <p class="chat_dialog-message" v-if="dialog.lastMessage">
        {{ dialog.lastMessage.content }}
      </p>
    </div>
  </div>
</template>

<script>
  import dayjs from 'dayjs'

  export default {
    props: {
      dialog: {
        type: Object,
        required: true
      },
      active: {
        type: Boolean,
        default: () => false
      }
    },
    computed: {
      lastMessageDate() {
        let current_day_date = dayjs();
        let message_date = dayjs(this.dialog.lastMessage.created_at);
        let same_day = current_day_date.isSame(message_date, 'day');
        let same_month = current_day_date.isSame(message_date, 'month');
        let same_year = current_day_date.isSame(message_date, 'year');
        if(same_day && same_month && same_year)
          return message_date.format('HH:mm');
        return message_date.format('DD.MM.YYYY');
      }
    }
  }
</script>
