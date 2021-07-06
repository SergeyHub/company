<template>
  <div id="chat_form" class="chat_converse chat_form">
    <a id="chat_fourth_screen" class="fab is-visible"><i class="zmdi zmdi-arrow-right"></i></a>
    <span class="chat_msg_item chat_msg_item_admin">
            <div class="chat_avatar">
               <img src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"/>
            </div>Hey there! Any question?</span>
    <span class="chat_msg_item chat_msg_item_user">
            Hello!</span>
    <span class="status">20m ago</span>
    <span class="chat_msg_item chat_msg_item_admin">
            <div class="chat_avatar">
               <img src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"/>
            </div>Agent typically replies in a few hours. Don't miss their reply.
            <div>
              <br>
              <form class="get-notified">
                  <label for="chat_log_email">Get notified by email</label>
                  <input id="chat_log_email" placeholder="Enter your email"/>
                  <i class="zmdi zmdi-chevron-right"></i>
              </form>
            </div></span>

    <span class="chat_msg_item chat_msg_item_admin">
            <div class="chat_avatar">
               <img src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"/>
            </div>Send message to agent.
            <div>
              <form class="message_form">
                  <input placeholder="Your email"/>
                  <input placeholder="Technical issue"/>
                  <textarea rows="4" placeholder="Your message"></textarea>
                  <button>Send</button>
              </form>

        </div></span>
  </div>
</template>
