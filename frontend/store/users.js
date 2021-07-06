const state = () => ({
  users: [],
  current_user: null
});

const mutations = {
  SET_USERS(state, data) {
    state.users = data
  },

  REMOVE_USER(state, user_id) {
    let index = state.users.findIndex(el => el.id == user_id);
    state.users.splice(index, 1);
  },


  RESET_USERS(state) {
    state.users = []
  },

  SET_USER(state, data) {
    state.current_user = data
  },

  APPEND_USERS(state, data) {
    for(let user of data) {
      state.users.push(user)
    }
  },

  UPDATE_USER(state, data) {
    if(state.current_user !== null && state.current_user.id == data.id) {
      state.current_user = {...state.current_user, ...data }
    }
    for(let index in state.users) {
      if(state.users[index].id == data.id) {
        state.users[index] = { ...state.users[index], ...data }
      }
    }
  }

};

const actions = {
  async listUsers({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/users', {params})
        .then(({ data }) => {
          commit('SET_USERS', data.data)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async loadMoreUsers({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/users', {params})
        .then(({ data }) => {
          commit('APPEND_USERS', data.data)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },


  async listVipUsers({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/users/vip', {params})
        .then(({ data }) => {
          commit('SET_USERS', data.data)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async loadMoreVipUsers({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/users/vip', {params})
        .then(({ data }) => {
          commit('APPEND_USERS', data.data)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchUser({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/users/'+id)
        .then(({ data }) => {
          commit('SET_USER', data.data)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async confirmEmail({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/users/'+id+'/confirmEmail')
        .then(({ data }) => {
          commit('UPDATE_USER', {id: id, email_verified_at: (new Date())})
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async banUser({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/users/'+id+'/ban', id)
        .then(({ data }) => {
          commit('UPDATE_USER', {id, deleted_at: data.deleted_at})
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },


  async unbanUser({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/users/'+id+'/unban', id)
        .then(({ data }) => {
          commit('UPDATE_USER', {id, deleted_at: data.deleted_at})
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchEditUser({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/users/${id}/edit`)
        .then((res) => {
          commit('SET_USER', res.data.data)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },

  async createUser({commit}, params) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/users', params)
        .then(({ data }) => {
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async updateUser({commit}, params) {
    return new Promise((resolve, reject) => {
      this.$axios.put('/users/'+params.id, params)
        .then(({ data }) => {
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async removeUser({commit}, user_id) {
    return new Promise((resolve, reject) => {
      this.$axios.delete('/users/'+user_id)
        .then(({ data }) => {
          commit('REMOVE_USER', user_id)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  }

};

const getters = {
  users: state => state.users,
  current_user: state => state.current_user
};

export default {
  state,
  getters,
  actions,
  mutations
}
