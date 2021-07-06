const state = () => ({
  agency: null,
  agencies: []
});

const mutations = {
  SET_AGENCY(state, data) {
    state.agency = data
  },
  RESET_AGENCIES(state, data) {
    state.agencies = []
  },
  APPEND_AGENCIES(state, data) {
    state.agencies.push(...data)
  }
};

const actions = {
  async fetchAgency({ commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/agencies/${id}`)
        .then((res) => {
          commit('SET_AGENCY', res.data.data)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  async fetchAgencies({ commit }, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/agencies', {params: params})
        .then((response) => {
          commit('APPEND_AGENCIES', response.data.data)
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  resetAgencies({ commit }) {
    commit('RESET_AGENCIES')
  },
};

const getters = {
  agencies: state => state.agencies,
  agency: state => state.agency,
};

export default {
  state,
  getters,
  actions,
  mutations
}
