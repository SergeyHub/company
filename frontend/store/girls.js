const state = () => ({
  girls: [],
  videos: [],
  reviews: [],
  favourites: [],
  current_girl: {},
  hidden: [],
  params: {},
  tariffs: [],
  vip_tariffs: [],
  section: '',
});

const mutations = {
  APPEND_GIRLS(state, data) {
    state.girls.push(...data)
  },
  APPEND_VIDEOS(state, data) {
    state.videos.push(...data)
  },
  APPEND_REVIEWS(state, data) {
    state.reviews.push(...data)
  },
  UPDATE_GIRL(state, data) {
    for(let girlIndex in state.girls) {
      if(state.girls[girlIndex].id == data.id) {
        state.girls[girlIndex] = Object.assign(state.girls[girlIndex], data)
      }
    }

    if(state.current_girl !== null && state.current_girl.id == data.id) {
      state.current_girl = Object.assign(state.current_girl, data)
    }
  },
  RESET_GIRLS(state) {
    state.girls = []
  },
  RESET_VIDEOS(state) {
    state.videos = []
  },
  RESET_REVIEWS(state) {
    state.reviews = []
  },
  SET_GIRLS(state, data) {
    state.girls = data
  },
  MAKE_HIDDEN(state, girl_id) {
    let index = state.girls.findIndex(el => el.id == girl_id)
    if(index !== -1) {
      state.girls[index].hidden = true
    }

    if(state.current_girl.id == girl_id) {
      state.current_girl.hidden = true
    }
  },
  MAKE_NOT_HIDDEN(state, girl_id) {
    let index = state.girls.findIndex(el => el.id == girl_id)
    if(index !== -1) {
      state.girls[index].hidden = false
    }

    if(state.current_girl.id == girl_id) {
      state.current_girl.hidden = false
    }

    index = state.hidden.findIndex(el => el.id == girl_id);
    state.hidden.splice(index, 1);
  },
  SET_HIDDEN(state, data) {
    state.hidden = data
  },
  SET_GIRL(state, data) {
    state.current_girl = data
  },
  SET_FAVOURITES(state, data) {
    state.favourites = data
  },
  SET_GIRL_PROFILE_COVER(state, data) {
    state.current_girl.cover = data
  },
  SET_VERIFIED(state, status='yes') {
    state.current_girl.verified = status;
  },
  SET_DOCUMENT(state, data) {
    state.current_girl.document = data
  },
  SET_BOOKMARK(state, {girl_id, content}) {
    if(state.current_girl.id == girl_id) {
      if( state.current_girl.bookmark == null ||  state.current_girl.bookmark == undefined) {
        state.current_girl.bookmark = {}
      }
      state.current_girl.bookmark.content = content
    }
  },

  SET_REJECT_VERIFICATION_REASON(state, reason) {
    state.current_girl.rejected_verification_reason = reason;
  },
  SET_REJECT_REASON(state, reason) {
    state.current_girl.rejected_reason = reason;
  },
  APPEND_GIRL_PHOTO(state, data) {
    state.current_girl.photos.push(data)
  },
  APPEND_VIDEO(state, data) {
    state.current_girl.videos.push(data)
  },
  APPEND_GIRL_PUBLIC_PHOTO(state, data) {
    state.current_girl.public_photos.push(data)
  },
  APPEND_FAVOURITES(state, data) {
    state.favourites.push(data)
  },
  SET_GIRL_STATUS(state, data) {
    state.current_girl.status = data
  },

  SET_CURRENT_SECTION(state, data) {
    state.section = data
  },

  SET_GIRL_AVATAR(state, media_id) {
    // прошлая аватарка
    var avatar = state.current_girl.photos.filter(photo => photo.avatar).length;
    state.current_girl.photos = state.current_girl.photos.map(function (photo) {
      if(photo.id == media_id)
        photo.avatar = true;
      else photo.avatar = false;
      return photo;
    })
    // если не было прошлой аватарки, то смотрим, были ли заполнены данные
    // и проставляем статус active
    if(!avatar && state.current_girl.country && state.current_girl.name) {
      state.current_girl.status = 'active';
    }
  },

  REMOVE_FAVOURITE(state, favourite_id) {
    let index = state.favourites.findIndex(el => el.id == favourite_id);
    state.favourites.splice(index, 1);
  },

  REMOVE_PHOTO_GIRL(state, params) {
    if(params.type == 'public') {
      state.current_girl.public_photos.splice(params.index, 1);
      return;
    }

    // если аватарка, то меняем статус профиля на wait
    var media = state.current_girl.photos[params.index];
    if(media.avatar) {
      state.current_girl.status = 'wait'
    }

    state.current_girl.photos.splice(params.index, 1);
  },

  REMOVE_VIDEO_GIRL(state, params) {
    if(params.type == 'public_videos') {
      state.current_girl.public_videos.splice(params.index, 1);
      return;
    }
    state.current_girl.videos.splice(params.index, 1);
  },

  SET_TARIFFS(state, data) {
    state.tariffs = data;
  },

  SET_VIP_TARIFFS(state, data) {
    state.vip_tariffs = data;
  }
};

const actions = {
  async fetchGirls({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls`, {params: params})
        .then((res) => {
          commit('APPEND_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchHidden({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/hidden`, {params: params})
        .then((res) => {
          commit('SET_HIDDEN', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async searchGirls({commit}, val='') {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls`, {params: {query: val}})
        .then((res) => {
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchAllGirls({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/all`, {params: params})
        .then((res) => {
          commit('SET_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchRandomGirls({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/random`, {params: params})
        .then((res) => {
          commit('APPEND_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchTop50Girls({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/top50`, {params: params})
        .then((res) => {
          commit('APPEND_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchVipGirls({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/vip`, {params: params})
        .then((res) => {
          commit('APPEND_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchTravelGirls({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/travels`, {params: params})
        .then((res) => {
          commit('APPEND_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchKeptWomans({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/keptWomans`, {params: params})
        .then((res) => {
          commit('APPEND_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchDatingGirls({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/dating`, {params: params})
        .then((res) => {
          commit('APPEND_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchShemales({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/shemales`, {params: params})
        .then((res) => {
          commit('APPEND_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchVideoGirls({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/videos`, {params: params})
        .then((res) => {
          commit('APPEND_VIDEOS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchReviews({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/reviews`, {params: params})
        .then((res) => {
          commit('APPEND_REVIEWS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchFavourites({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/favourites`, {params: params})
        .then((res) => {
          commit('SET_FAVOURITES', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchPornstarGirls({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/pornstar`, {params: params})
        .then((res) => {
          commit('APPEND_GIRLS', res.data.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async sendClientApplication(store, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/client-applications', data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async addToHidden({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/addToHidden`)
        .then((res) => {
          if(res.data.success != false) {
            commit('MAKE_HIDDEN', id)
            resolve(res.data)
          }
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  async removeFromHidden({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/removeFromHidden`)
        .then((res) => {
          commit('MAKE_NOT_HIDDEN', id)
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  resetGirls({ commit }) {
    commit('RESET_GIRLS')
  },
  resetReviews({ commit }) {
    commit('RESET_REVIEWS')
  },
  resetVideos({ commit }) {
    commit('RESET_VIDEOS')
  },
  async fetchGirl({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/${id}`)
        .then((res) => {
          commit('SET_GIRL', res.data.data)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchEditGirl({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/${id}/edit`)
        .then((res) => {
          commit('SET_GIRL', res.data.data)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async fetchOwnedGirl({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/girls/${id}/owned`)
        .then((res) => {
          commit('SET_GIRL', res.data.data)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async createGirl({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls`)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async deleteGirl({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/destroy`)
        .then((res) => {
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },
  async saveGirl({commit}, data) {
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
  async addToFavourites({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/addToFavourites`)
        .then((res) => {
          if(res.data.success !== false) {
            commit('APPEND_FAVOURITES', res.data.data)
            resolve(res.data)
          }
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  async removeFromFavourites({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/removeFromFavourites`)
        .then((res) => {
          commit('REMOVE_FAVOURITE', id)
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async saveReview({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/reviews`, data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  async sendFakeReport({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/fake-reports`, data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },
  async uploadCover({commit}, allData) {
    let formData = new FormData()
    formData.append('file', allData.file)

    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${allData.id}/cover`, formData)
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async removePhoto({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${data.id}/removePhoto`, {id: data.media_id})
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async removeVideo({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${data.id}/removeVideo`, {id: data.media_id})
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async uploadAvatar({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${data.id}/setAvatar`, {id: data.media_id})
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async uploadHiddenPhoto({commit}, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${data.id}/hidden-photos`, data)
        .then((res) => {
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async girlUploadDocument({commit}, data) {
    return new Promise((resolve, reject) => {
      let formData = new FormData();
      formData.append('file', data.file);
      this.$axios.post(`/girls/${data.id}/documents`, formData)
        .then((res) => {
          commit('SET_DOCUMENT', res.data.data)
          commit('SET_VERIFIED', 'wait')
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  setCover({ commit }, url) {
    commit('SET_GIRL_PROFILE_COVER', url)
  },

  appendPhoto({ commit }, url) {
    commit('APPEND_GIRL_PHOTO', url)
  },

  appendVideo({ commit }, url) {
    commit('APPEND_VIDEO', url)
  },

  appendPublicPhoto({ commit }, data) {
    commit('APPEND_GIRL_PUBLIC_PHOTO', data)
  },

  removePhotoFromState({ commit }, params) {
    commit('REMOVE_PHOTO_GIRL', params)
  },

  removeVideoFromState({ commit }, params) {
    commit('REMOVE_VIDEO_GIRL', params)
  },

  setAvatar({ commit }, media_id) {
    commit('SET_GIRL_AVATAR', media_id)
  },

  setCurrentSection({ commit }, section) {
    commit('SET_CURRENT_SECTION', section)
  },

  async fetchPublicationBill({ commit }, data) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${data.id}/publish`, data)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async buyAccessToGirl({ commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/buy`)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async setBookmark({ commit }, { girl_id, content }) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${girl_id}/bookmark`, {content})
        .then((res) => {
          commit('SET_BOOKMARK', {girl_id, content})
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async verifyGirl({ commit }, { id }) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/verify`)
        .then((res) => {
          commit('SET_VERIFIED')
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async publishGirl({ commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/publishProfile`)
        .then((res) => {
          commit('SET_GIRL_STATUS', 'published')
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async unpublishGirl({ commit }, { id, reason }) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/unpublishProfile`, { reason })
        .then((res) => {
          commit('SET_GIRL_STATUS', 'rejected')
          commit('SET_REJECT_REASON', reason)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async unverifyGirl({ commit }, { id, reason }) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/girls/${id}/unverify`, { reason })
        .then((res) => {
          commit('SET_VERIFIED', 'rejected')
          commit('SET_REJECT_VERIFICATION_REASON', reason)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchTariffs({ commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/tariffs`)
        .then((res) => {
          commit('SET_TARIFFS', res.data.data)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },


  async fetchVipTariffs({ commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/vip-tariffs`)
        .then((res) => {
          commit('SET_VIP_TARIFFS', res.data.data)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchOwnGirls({commit}) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/profile/own-girls`)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async makeVip({commit}, params) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/girls/'+ params.id +'/vip/issue', params)
        .then(res => {
          commit('UPDATE_GIRL', res.data.data)
          resolve(res.data)
        })
        .catch(e => {
          reject(e)
        })
    })
  },

  async removeVip({commit}, params) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/girls/'+ params.id +'/vip/remove', params)
        .then(res => {
          commit('UPDATE_GIRL', res.data.data)
          resolve(res.data)
        })
        .catch(e => {
          reject(e)
        })
    })
  },

  async getVipPaymentLink({commit}, params) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/girls/'+ params.girl_id +'/vip/getPaymentLink', params)
        .then(res => {
          resolve(res.data)
        })
        .catch(e => {
          reject(e)
        })
    })
  },

  async fetchVerificationGirls({commit}, params) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/girls/verification', {params})
        .then(({data}) => {
          commit('APPEND_GIRLS', data.data)
          resolve(data)
        })
        .catch(error => {
          reject(error)
        })
    })
  }
};

const getters = {
  girls: state => state.girls,
  videos: state => state.videos,
  reviews: state => state.reviews,
  favourites: state => state.favourites,
  tariffs: state => state.tariffs,
  vip_tariffs: state => state.vip_tariffs,
  hidden: state => state.hidden,
  current_girl_avatar: (state) => {
    return state.current_girl.photos &&
      state.current_girl.photos.filter(photo => photo.avatar).length
  },
  current_girl: state => state.current_girl,
  section: state => state.section,
  params: state => state.params,
  profileOnInspection: state => state.current_girl && state.current_girl.status === 'active',
  profileIsPublished: (state) => {
    return state.current_girl && state.current_girl.status === 'published'
  },
  profileIsRejected: (state) => {
    return state.current_girl && state.current_girl.status === 'rejected'
  },
  profileIsFilled: (state) => {
    return state.current_girl && state.current_girl.country && state.current_girl.name
  },
  photosIsFilled: (state) => {
    return state.current_girl && state.current_girl.photos && state.current_girl.photos.length;
  },
  profileIsVerified: state => state.current_girl && state.current_girl.verified === 'yes',
  profileOnVerify: state => state.current_girl && state.current_girl.verified === 'wait',
  profileVerifyIsRejected: state => state.current_girl && state.current_girl.verified === 'rejected',
};

export default {
  state,
  getters,
  actions,
  mutations
}
