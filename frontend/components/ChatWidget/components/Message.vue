<template>
    <span class="chat_msg_item"
          :class="message.from_admin ? 'chat_msg_item_admin' : 'chat_msg_item_user'">
      <div class="chat_avatar" v-if="message.from_admin">
        <img src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"/>
      </div>
      {{ message.content }}
    </span>
</template>

<script>
  export default {
    props: {
      message: {
        required: true,
        type: Object
      }
    }
  }
</script>
