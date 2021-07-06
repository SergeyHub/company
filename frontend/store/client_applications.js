const state = () => ({
  applications: [],
  current_application: null
});

const mutations = {
  SET_APPLICATIONS(state, data) {
    state.applications = data
  },
  REMOVE_APPLICATION(state, application_id) {
    let index = state.applications.findIndex(el => el.id == application_id);
    state.applications.splice(index, 1);
  },
  SET_APPLICATION(state, data) {
    state.current_application = data
  },
  PUSH_APPLICATIONS(state, data) {
    for(let i in data) {
      state.applications.push(data[i])
    }
  },
  RESET_APPLICATIONS(state) {
    state.applications = []
  }
};

const actions = {
  async fetchApplications({commit}, params= {}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/client-applications', {params})
        .then(({ data }) => {
          commit('PUSH_APPLICATIONS', data.data)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchApplication({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/applications/'+id)
        .then(({ data }) => {
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },


  async removeApplication({commit}, application_id) {
    return new Promise((resolve, reject) => {
      this.$axios.delete('/client-applications/'+application_id)
        .then(({ data }) => {
          commit('REMOVE_APPLICATION', application_id)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  }

};

const getters = {
  client_applications: state => state.applications,
  current_application: state => state.current_application
};

export default {
  state,
  getters,
  actions,
  mutations
}
