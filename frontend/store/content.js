const state = () => ({
  content: null,
  contents: []
});

const mutations = {
  SET_CONTENT(state, data) {
    state.content = data
  },
  SET_CONTENTS(state, data) {
    state.contents = data
  }
};

const actions = {
  async fetchContent({ commit }, slug) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/content/'+slug)
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  async saveContent({ commit }, data) {
    return new Promise((resolve, reject) => {
      this.$axios.put('/content/'+data.id, data)
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  async fetchContentForEdit({ commit }, slug) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/content/'+slug+'/edit')
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  async fetchAllContents({ commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/content/')
        .then((response) => {
          commit('SET_CONTENTS', response.data.data)
          resolve(response.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  }
};

const getters = {
  contents: state => state.contents,
};

export default {
  state,
  getters,
  actions,
  mutations
}
