const state = () => ({
  bills: [],
});

const mutations = {
  SET_BILLS(state, data) {
    state.bills = data
  }
};

const actions = {
  async fetchAllBills({ commit }, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/bills/all', {params})
        .then((response) => {
          commit('SET_BILLS', response.data.data)
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchBills({ commit }, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/bills', {params})
        .then((response) => {
          commit('SET_BILLS', response.data.data)
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async getBill({ commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/bills/'+id)
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  }
};

const getters = {
  bills: state => state.bills,
};

export default {
  state,
  getters,
  actions,
  mutations
}
