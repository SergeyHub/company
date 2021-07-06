import { playNotification } from '../utils'

function mapMessage(message, user_id) {
  message.from_me = message.user_from_id == user_id;
  return message;
}

function mapDialog(dialog, user_id) {
  if(!dialog.userFirst)
    return dialog;

  let recipient = dialog.userFirst.id == user_id ? dialog.userSecond : dialog.userFirst;
  if(recipient && recipient.avatar) {
    dialog.avatar =  recipient.avatar;
  } else if (recipient && recipient.type == 'client') {
    dialog.avatar =  process.env.cdn_assets + '/img/man_avatar.png';
  } else {
    dialog.avatar =  process.env.cdn_assets + '/img/female_avatar.png';
  }
  dialog.recipient = recipient;

  if(dialog.lastMessage) {
    dialog.lastMessage = mapMessage(dialog.lastMessage, user_id);
  }

  return dialog;
}

const state = () => ({
  dialogs: [],
  currentDialog: {},
  messages: [],
});

const mutations = {
  SET_DIALOGS(state, data) {
    state.dialogs = data
  },
  PREPEND_DIALOG(state, dialog) {
    // ищем, есть ли такой же диалог
    let dialogIndex = state.dialogs
      .findIndex(
        el => el.id == dialog.id
          || dialog.recipient && el.id == 'tmp_dialog_with_' + dialog.recipient.id
          || el.recipient && 'tmp_dialog_with_' + el.recipient.id == dialog.id
      );
    if(dialogIndex == -1) {
      state.dialogs.unshift(dialog);
    } else {
      // проставляем корректный dialog_id (если приходит dialog через сокет, то в нем корректный dialog_id)
      let findedDialog = state.dialogs[dialogIndex];
      if(String(dialog.id).indexOf('tmp_dialog_with_') == -1 && String(findedDialog.id).indexOf('tmp_dialog_with_')!=-1) {
        state.dialogs[dialogIndex].id = dialog.id;
      }
    }
  },
  SET_CURRENT_DIALOG(state, dialog) {
    state.currentDialog = dialog
  },
  SET_MESSAGES(state, data) {
    state.messages = data
  },
  APPEND_MESSAGE(state, message) {
    if(message.dialog_id == state.currentDialog.id) {
      state.messages.push(message)
    }
    let dialogIndex = state.dialogs.findIndex(el => el.id == message.dialog_id);
    let dialog = state.dialogs[dialogIndex];
    dialog.lastMessage = message;
    // обновляем позицию дилога
    state.dialogs.splice(dialogIndex, 1);
    state.dialogs.unshift(dialog);
  },
  RESET_MESSAGES(state) {
    state.messages = []
  },

  MARK_AS_READ(state, message_id) {
    let message_index = state.messages.findIndex(el => el.id == message_id);
    if(message_index !== -1) {
      state.messages[message_index].read = 1;
    }
    // ищем сообщение в диалогах
    let dialog_index = state.dialogs.findIndex(el => el.lastMessage && el.lastMessage.id == message_id);
    if(dialog_index !== -1)
      state.dialogs[dialog_index].lastMessage.read = 1;
  }
};

const actions = {
  async fetchDialogs({commit, rootGetters}) {
    let user_id = rootGetters['auth/loggedUser'].id;
    return new Promise((resolve, reject) => {
      this.$axios.get(`/messages`)
        .then((res) => {
          let dialogs = res.data.data;
          dialogs.map((dialog) => mapDialog(dialog, user_id))
            .filter(dialog => !!dialog.recipient);
          commit('SET_DIALOGS', dialogs)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async sendMessage({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/messages`, data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async markAsRead({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/messages/markAsRead`, {id})
        .then((res) => {
          commit('MARK_AS_READ', id)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchMessages({ commit, rootGetters }, dialog_id) {
    let user_id = rootGetters['auth/loggedUser'].id;
    return new Promise((resolve, reject) => {
      this.$axios.get(`/messages/listDialog`, {params: {dialog_id}})
        .then((res) => {
          let messages = res.data.data.reverse();
          messages.map((message) => mapMessage(message, user_id));
          commit('SET_MESSAGES', messages)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  appendNewMessage({ commit, state, rootGetters, dispatch }, message_object) {
    let user_id = rootGetters['auth/loggedUser'].id;
    // если это новый диалог
    if(message_object.dialog) {
      let dialog = mapDialog(message_object.dialog, user_id);
      commit('PREPEND_DIALOG', dialog)
    }
    let message = message_object.message;
    message = mapMessage(message, user_id);
    commit('APPEND_MESSAGE', message)

    // если это текущий открытый диалог, то проставляем сообщение прочитанным
    if(state.currentDialog.id == message.dialog_id && !message.from_me) {
      dispatch('markAsRead', message.id)
    }

    // если сообщение не от этого пользователя, то играем звук
    if(!message.from_me) {
      playNotification()
    }
  },
  prependDialog({ commit, state, rootGetters }, dialog_object) {
    let user_id = rootGetters['auth/loggedUser'].id;
    let dialog = mapDialog(dialog_object, user_id);
    commit('PREPEND_DIALOG', dialog)
  },
  appendMessage({ commit }, message) {
    commit('APPEND_MESSAGE', message)
  },
  setCurrentDialog({ commit }, dialog) {
    commit('SET_CURRENT_DIALOG', dialog)
  },
  resetMessages({ commit }) {
    commit('RESET_MESSAGES')
  }
};

const getters = {
  dialogs: state => state.dialogs,
  currentDialog: state => state.currentDialog,
  messages: state => state.messages,
  unreadCount: state => {
    return state.dialogs.filter(dialog => dialog.lastMessage && !dialog.lastMessage.from_me && !dialog.lastMessage.read).length;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
}
