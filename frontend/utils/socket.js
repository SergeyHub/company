import io from 'socket.io-client'
if(!process.server)
  window.io = io;
import Echo from 'laravel-echo'
import { EventBus } from '~/utils/event-bus'
import {Message} from "element-ui";

export default class Socket {

  constructor (user_id, token, app) {
    this.socket = new Echo({
      broadcaster: 'socket.io',
      host: 'http://'+process.env.base_domain+':6001',
      auth: { headers: { 'Authorization': 'Bearer ' + token } }
    });
    this.xsocket_channel = 'App.User.' + user_id;
    this.app = app;
    this.registerSocketEventHandlers()
  }

  registerSocketEventHandlers () {
    this.socket.private(this.xsocket_channel)
      .notification((notification) => {
        if(notification.type === 'BillPaid') {
          EventBus.$emit('BillPaid', notification);
          // если оплата публикации анкеты
          if(notification.bill_type === 'OrderGirlPublication') {
            this.app.store.dispatch('profile/setVerifiedIndependent', 'wait');
            Message.success(this.app.i18n.t('validation.profile_sended'));
          }
        }
      })
      .listen('.SupportMessage', ({ message }) => {
        EventBus.$emit('SupportMessage', message);
        this.app.store.dispatch('support/appendMessage', message);
      })
      .listen('.PrivateMessage', (message_object) => {
        EventBus.$emit('PrivateMessage', message_object);
        this.app.store.dispatch('chat/appendNewMessage', message_object);
      })
  }

  disconnect () {
    if(this.socket) {
      this.socket.leave(this.xsocket_channel)
      this.socket = null;
      this.xsocket_channel = null;
    }
  }

}
