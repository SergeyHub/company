<template>
    <span class="chat_msg_item"
          :class="message.from_me ? 'chat_msg_item_user' : 'chat_msg_item_admin'">
      <div class="chat_avatar" v-if="!message.from_me">
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
