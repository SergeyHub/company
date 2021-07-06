const state = () => ({
  messages: [],
});

const mutations = {
  PREPEND_MESSAGES(state, data) {
    state.messages.unshift(...data)
  },
  APPEND_MESSAGE(state, message) {
    state.messages.push(message)
  }
};

const actions = {
  async fetchMessages({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/support`, {params: params})
        .then((res) => {
          commit('PREPEND_MESSAGES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async sendMessage({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/support`, data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  appendMessage({ commit }, message) {
    commit('APPEND_MESSAGE', message)
  }
};

const getters = {
  messages: state => state.messages,
};

export default {
  state,
  getters,
  actions,
  mutations
}
