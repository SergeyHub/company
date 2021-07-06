const state = () => ({
  offers: [],
  current_offer: {},
  params: {}
});

const mutations = {
  APPEND_OFFERS(state, data) {
    state.offers.push(...data)
  },
  SET_OFFER(state, data) {
    state.current_offer = data
  },
  SET_OFFERS(state, data) {
    state.offers = data
  },
  RESET_OFFERS(state) {
    state.offers = []
  },
  REMOVE_OFFER(state, id) {
    let index = state.offers.findIndex(el => el.id == id);
    if(index !== -1)
      state.offers.splice(index, 1);
  }
};

const actions = {
  async fetchOffers({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/offers`, {params: params})
        .then((res) => {
          commit('APPEND_OFFERS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchAllOffers({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/offers/all`, {params: params})
        .then((res) => {
          commit('SET_OFFERS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },

  async fetchOffer({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/offers/${id}`)
        .then((res) => {
          commit('SET_OFFER', res.data.data)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },

  async fetchEditOffer({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/offers/${id}/edit`)
        .then((res) => {
          commit('SET_OFFER', res.data.data)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },

  async updateOffer({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.put(`/offers/${data.id}`, data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },

  async removeOffer({ commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.delete(`/offers/${id}`)
        .then((res) => {
          commit('REMOVE_OFFER', id);
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  resetOffers({ commit }) {
    commit('RESET_OFFERS')
  },

  async buyAccessToOffer({ commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/offers/${id}/buy`)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
};

const getters = {
  offers: state => state.offers,
  current_offer: state => state.current_offer,
  params: state => state.params
};

export default {
  state,
  getters,
  actions,
  mutations
}
