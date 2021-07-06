const state = () => ({
  independent_profile: {},
  client_profile: {},
  agency_profile: {},
  offers: [],
});

const mutations = {
  SET_INDEPENDENT_PROFILE(state, data) {
    state.independent_profile = data
  },
  SET_INDEPENDENT_PROFILE_STATUS(state, status) {
    state.independent_profile.status = status
  },
  SET_INDEPENDENT_PROFILE_COVER(state, data) {
    state.independent_profile.cover = data
  },
  SET_DOCUMENT(state, data) {
    state.independent_profile.document = data
  },
  APPEND_INDEPENDENT_PROFILE_PHOTO(state, data) {
    state.independent_profile.photos.push(data)
  },
  APPEND_INDEPENDENT_PROFILE_VIDEO(state, data) {
    state.independent_profile.videos.push(data)
  },
  SET_AGENCY_PROFILE(state, data) {
    state.agency_profile = data
  },
  SET_PUBLISHED_AGENCY(state) {
    state.agency_profile.status = 'published'
  },
  SET_GIRLS(state, data) {
    state.girls = data
  },
  SET_AVATAR(state, media_id) {
    // прошлая аватарка
    var avatar = state.independent_profile.photos.filter(photo => photo.avatar).length;
    state.independent_profile.photos = state.independent_profile.photos.map(function (photo) {
      if(photo.id == media_id)
        photo.avatar = true;
      else photo.avatar = false;
      return photo;
    })
    // если не было прошлой аватарки, то смотрим, были ли заполнены данные
    // и проставляем статус active
    if(!avatar && state.independent_profile.country && state.independent_profile.name) {
      state.independent_profile.status = 'active';
    }
  },
  REMOVE_PHOTO(state, params) {
    // если аватарка, то меняем статус профиля на wait
    var media = state.independent_profile.photos[params.index];
    if(media.avatar) {
      state.independent_profile.status = 'wait'
    }
    state.independent_profile.photos.splice(params.index, 1);
  },
  REMOVE_VIDEO(state, params) {
    state.independent_profile.videos.splice(params.index, 1);
  },

  SET_VERIFIED_STATUS(state, data) {
    state.independent_profile.verified = data
  },

  SET_STATUS(state, data) {
    state.independent_profile.status = data
  },

  SET_CLIENT_PROFILE(state, data) {
    state.client_profile = data
  },

  SET_OFFERS(state, data) {
    state.offers = data
  },

  PREPEND_OFFER(state, data) {
    state.offers.unshift(data)
  },

  UPDATE_OFFER(state, data) {
    let offer_index = state.offers.findIndex(el => el.id === data.id);
    state.offers.splice(offer_index, 1, data);
  },

  REMOVE_OFFER(state, index) {
    state.offers.splice(index, 1)
  }
};

const actions = {
  async uploadAgencyAvatar({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/agencies/${data.id}/uploadAvatar`, {id: data.media_id})
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchIndependentProfile({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/profile/own-girl`)
        .then((res) => {
          if (res.status === 200) {
            commit('SET_INDEPENDENT_PROFILE', res.data.data)
          }
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchAgencyProfile({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/profile/own-agency`)
        .then((res) => {
          if (res.status === 200) {
            commit('SET_AGENCY_PROFILE', res.data.data)
          }
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async publishProfile({ commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/publish`)
        .then((res) => {
          if (res.status === 200) {
            commit('SET_INDEPENDENT_PROFILE_STATUS', 'publish')
          }
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  setVerifiedIndependent({ commit }, status='wait') {
    commit('SET_VERIFIED_STATUS', status)
  },

  setCover({ commit }, url) {
    commit('SET_INDEPENDENT_PROFILE_COVER', url)
  },

  appendPhoto({ commit }, url) {
    commit('APPEND_INDEPENDENT_PROFILE_PHOTO', url)
  },

  appendVideo({ commit }, url) {
    commit('APPEND_INDEPENDENT_PROFILE_VIDEO', url)
  },

  removePhotoFromState({ commit }, params) {
    commit('REMOVE_PHOTO', params)
  },

  removeVideoFromState({ commit }, params) {
    commit('REMOVE_VIDEO', params)
  },

  async saveOwnGirl({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.put(`/girls/${data.id}`, data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  setAvatar({ commit }, media_id) {
    commit('SET_AVATAR', media_id)
  },

  async fetchClientProfile({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/profile/own-client`)
        .then((res) => {
          if (res.status === 200) {
            commit('SET_CLIENT_PROFILE', res.data.data)
          }
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async saveOwnClient({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.put(`/clients/${data.id}`, data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async saveOwnAgency({ commit }, data) {
    return new Promise((resolve, reject) => {
      this.$axios.put(`/agencies/${data.id}`, data)
        .then((res) => {
          commit('SET_PUBLISHED_AGENCY')
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchAgencyGirls({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/profile/girls`)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchClientOffers({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/offers/own-offers`)
        .then((res) => {
          commit('SET_OFFERS', res.data.data);
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async createGirl({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls`, data)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async createGirlByGirl({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/storeByGirl`, data)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async createOffer({ commit }, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/offers`, data)
        .then((res) => {
          commit('PREPEND_OFFER', res.data.data)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async editOffer({ commit }, data) {
    return new Promise((resolve, reject) => {
      this.$axios.put(`/offers/${data.id}`, data)
        .then((res) => {
          commit('UPDATE_OFFER', data)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async offerBillCreate({ commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/offers/${id}/publish`)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async offerRemove({ commit }, data) {
    return new Promise((resolve, reject) => {
      this.$axios.delete(`/offers/${data.id}`)
        .then((res) => {
          commit('REMOVE_OFFER', data.index);
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async setActivate({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/activate`)
        .then((res) => {
          commit('SET_STATUS', 'active')
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
};

const getters = {
  profileIsFilled: (state) => {
    return state.independent_profile && state.independent_profile.country && state.independent_profile.name
  },
  photosIsFilled: (state) => {
    return state.independent_profile && state.independent_profile.photos && state.independent_profile.photos.length;
  },
  profileIsVerified: state => state.independent_profile && state.independent_profile.verified === 'yes',
  profileOnVerify: state => state.independent_profile && state.independent_profile.verified === 'wait',
  profileVerifyIsRejected: state => state.independent_profile && state.independent_profile.verified === 'rejected',
  profileOnInspection: state => state.independent_profile && state.independent_profile.status === 'active',
  profileIsPublished: state => state.independent_profile && state.independent_profile.status === 'published',
  profileIsRejected: state => state.independent_profile && state.independent_profile.status === 'rejected',
  agencyProfileIsPublished: state => state.agency_profile && state.agency_profile.status === 'published',
  independent_profile: state => state.independent_profile,
  independent_profile_avatar: (state) => {
    return state.independent_profile.photos &&
      state.independent_profile.photos.filter(photo => photo.avatar).length
  },
  client_profile: state => state.client_profile,
  agency_profile: state => state.agency_profile,
  offers: state => state.offers,
};

export default {
  state,
  getters,
  actions,
  mutations
}
