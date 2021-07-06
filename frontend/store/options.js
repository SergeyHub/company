const state = () => ({
  eyes: [],
  nationalities: [],
  hairs: [],
  currencies: [],
  languages: [],
  geographies: [],
  iLikes: [],
  readyFor: [],
  purposes: [],
  contactMethods: [],
  ethnicities: [],
  bodyHairs: [],
  orientations: [],
  bodies: [],
});

const mutations = {
  SET_EYES(state, eyes) {
    state.eyes = eyes
  },
  SET_NATIONALITIES(state, nationalities) {
    state.nationalities = nationalities
  },
  SET_HAIRS(state, hairs) {
    state.hairs = hairs
  },
  SET_CURRENCIES(state, data) {
    state.currencies = data
  },
  SET_LANGUAGES(state, data) {
    state.languages = data
  },
  SET_GEOGRAPHIES(state, data) {
    state.geographies = data
  },
  SET_I_LIKES(state, data) {
    state.iLikes = data
  },
  SET_READY_FOR(state, data) {
    state.readyFor = data
  },
  SET_ETHNICITIES(state, data) {
    state.ethnicities = data
  },
  SET_BODY_HAIRS(state, data) {
    state.bodyHairs = data
  },
  SET_ORIENTATIONS(state, data) {
    state.orientations = data
  },
  SET_BODIES(state, data) {
    state.bodies = data
  },
  SET_PURPOSES(state, data) {
    state.purposes = data
  },
  SET_CONTACT_METHODS(state, data) {
    state.contactMethods = data
  }
};

const actions = {
  async fetchEyes({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/eyes`)
        .then((res) => {
          commit('SET_EYES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchNationalities({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/nationalities`)
        .then((res) => {
          commit('SET_NATIONALITIES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchHairs({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/hairs`)
        .then((res) => {
          commit('SET_HAIRS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchCurrencies({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/currencies`)
        .then((res) => {
          commit('SET_CURRENCIES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchLanguages({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/languages`)
        .then((res) => {
          commit('SET_LANGUAGES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchGeographies({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/geographies`)
        .then((res) => {
          commit('SET_GEOGRAPHIES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchIlikes({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/i-likes`)
        .then((res) => {
          commit('SET_I_LIKES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchReadyFor({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/ready-for`)
        .then((res) => {
          commit('SET_READY_FOR', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchBodies({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/bodies`)
        .then((res) => {
          commit('SET_BODIES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchOrientations({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/orientations`)
        .then((res) => {
          commit('SET_ORIENTATIONS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchBodyHairs({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/body-hairs`)
        .then((res) => {
          commit('SET_BODY_HAIRS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchEthnicities({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/ethnicities`)
        .then((res) => {
          commit('SET_ETHNICITIES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchPurposes({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/purposes`)
        .then((res) => {
          commit('SET_PURPOSES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchContactMethods({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/contact-methods`)
        .then((res) => {
          commit('SET_CONTACT_METHODS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
};

const getters = {
  eyes: state => state.eyes,
  nationalities: state => state.nationalities,
  hairs: state => state.hairs,
  currencies: state => state.currencies,
  languages: state => state.languages,
  geographies: state => state.geographies,
  iLikes: state => state.iLikes,
  readyFor: state => state.readyFor,
  purposes: state => state.purposes,
  contactMethods: state => state.contactMethods,
  ethnicities: state => state.ethnicities,
  bodyHairs: state => state.bodyHairs,
  orientations: state => state.orientations,
  bodies: state => state.bodies,
};

export default {
  state,
  getters,
  actions,
  mutations
}
