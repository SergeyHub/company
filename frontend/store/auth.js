const state = () => ({
  user: null,
  user_for_confirm_id: null,
  token: null
});

const mutations = {
  SET_USER(state, user) {
    state.user = user;
  },
  SET_USER_FOR_CONFIRM_ID(state, id) {
    state.user_for_confirm_id = id;
  },
  SET_TOKEN(state, token) {
    state.token = token
    if(token) {
      this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    }
    if(!process.server) {
      this.$cookies.set('token_mybestgigalo', token, {path: '/'});
    }
  },
  LOGOUT(state) {
    state.user = null;
    state.token = null;
    this.$cookies.remove('token_mybestgigalo', {path: '/'});
    this.$axios.defaults.headers.common['Authorization'] = 'Bearer ';
  }
};

const actions = {
  async login({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/auth/login`, data)
        .then((res) => {
          commit('SET_USER', res.data.data)
          commit('SET_TOKEN', res.data.data.token)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async register({ commit }, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/auth/register`, data)
        .then((res) => {
          commit('SET_USER_FOR_CONFIRM_ID', res.data.user_id)
          resolve()
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async resetPasswordRequest({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/auth/password/sendResetLink', data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((err) => {
          reject(err)
        })
    })
  },
  async authByResetToken({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/auth/password/authByResetToken', data)
        .then(response => {
          commit('SET_USER', response.data.data)
          commit('SET_TOKEN', response.data.data.token)
          resolve(response.data)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  async fetchUser({ commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/auth/me`)
        .then((res) => {
          commit('SET_USER', res.data.data)
          resolve(res.data.data)
        })
        .catch((error) => {
          commit('SET_USER', null)
          commit('SET_TOKEN', null)
          reject(error)
        })
    })
  },
  async saveUser({ commit }, data) {
    return new Promise((resolve, reject) => {
      this.$axios.put(`/users/${data.id}`, data)
        .then((res) => {
          commit('SET_USER', _.clone(data))
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  setUserForConfirmId({ commit }, data) {
    commit('SET_USER_FOR_CONFIRM_ID', data)
  },
  async logout({ commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/auth/logout`)
        .then((res) => {
          commit('LOGOUT')
          resolve()
        })
        .catch((error) => {
          commit('LOGOUT')
          reject(error)
        })
    })
  },
  async emailVerifySend({ commit }, userForConfirmId) {
    return this.$axios.post('/auth/verify/send/' + userForConfirmId)
  },
};

const getters = {
  isAuthentificated: state => !!state.user,
  loggedUser: state => state.user,
  userForConfirmId: state => state.user_for_confirm_id,
  userType: state => state.user ? state.user.type : null,
  isGirl: state => state.user && state.user.type === 'girl',
  isClient: state => state.user && state.user.type === 'client',
  isAgency: state => state.user && state.user.type === 'agency',
  isAdmin: state => state.user && state.user.role === 'admin',
  isModerator: state => state.user && state.user.role === 'moderator',
};

export default {
  state,
  getters,
  actions,
  mutations
}
