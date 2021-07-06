<template>
  <div class="chat_header">
    <div class="chat_option">
      <div class="header_img">
        <img src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"/>
      </div>
      <span id="chat_head">Jane Doe</span> <br> <span class="agent">Agent</span> <span class="online">(Online)</span>
      <i class="fas fa-times" @click="$emit('close')"></i>
    </div>
  </div>
</template>
