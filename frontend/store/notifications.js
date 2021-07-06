const state = () => ({
  notifications: []
});

const mutations = {
  SET_NOTIFICATIONS(state, data) {
    state.notifications = data
  },
  UPDATE_NOTIFICATION(state, data) {
    state.notifications.forEach((item, index) => {
      if(item.id == data.id) {
        state.notifications[index] = Object.assign(state.notifications[index], data)
      }
    })
  },
  SET_READ(state, ids) {
    for(let index in state.notifications) {
      if(ids.indexOf(state.notifications[index].id) !== -1) {
        state.notifications[index].read_at = new Date().toString()
      }
    }
  }
}


const actions = {
  async fetchNotifications({ commit, rootGetters }) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/users/'+ rootGetters['auth/loggedUser'].id +'/notifications')
        .then((res) => {
          commit('SET_NOTIFICATIONS', res.data.data)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchUnreadNotifications({ commit, rootGetters }) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/users/'+ rootGetters['auth/loggedUser'].id +'/notifications/unread')
        .then((res) => {
          commit('SET_NOTIFICATIONS', res.data.data)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async setAsRead({ commit, rootGetters }, ids = []) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/users/'+ rootGetters['auth/loggedUser'].id +'/notifications/markAsRead', { id: ids })
        .then((res) => {
          commit('SET_READ', ids)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
}


const getters = {
  allNotifications: state => state.notifications
};

export default {
  state,
  getters,
  actions,
  mutations
}
