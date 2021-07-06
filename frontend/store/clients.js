const state = () => ({
  clients: [],
});

const mutations = {
  SET_CLIENTS(state, data) {
    state.clients = data
  }
};

const actions = {
  async fetchClients({ commit }, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/clients/', {params})
        .then((response) => {
          commit('SET_CLIENTS', response.data.data)
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  }
};

const getters = {
  clients: state => state.clients,
};

export default {
  state,
  getters,
  actions,
  mutations
}
