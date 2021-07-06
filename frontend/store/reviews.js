const state = () => ({
  reviews: [],
  current_review: null
});

const mutations = {
  PUSH_REVIEWS(state, data) {
    state.reviews = [
      ...state.reviews,
      ...data
    ]
  },
  RESET_REVIEWS(state) {
    state.reviews = []
    state.current_review = null
  },
  SET_REVIEWS(state, data) {
    state.reviews = data
  },
  REMOVE_REVIEW(state, review_id) {
    let index = state.reviews.findIndex(el => el.id == review_id);
    state.reviews.splice(index, 1);
  },
  SET_REVIEW(state, data) {
    state.current_revieww = data
  },
  UPDATE_REVIEW(state, data) {
    if(state.current_review != null && state.current_review.id == data.id) {
      state.current_review = {
        ...state.current_review,
        ...data
      }
    }
    for(let reviewIndex in state.reviews) {
      if(state.reviews[reviewIndex].id == data.id) {
        for(let i in data) {
          state.reviews[reviewIndex][i] = data[i]
        }
      }
    }
  }
};

const actions = {

  async listReviews({commit}, params={}) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/reviews', {params})
        .then(({ data }) => {
          commit('PUSH_REVIEWS', data.data)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchReview({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get('/reviews/'+id)
        .then(({ data }) => {
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async publish({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/reviews/${id}/publish`)
        .then((res) => {
          commit('UPDATE_REVIEW', res.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },

  async unpublish({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/reviews/${id}/unpublish`)
        .then((res) => {
          commit('UPDATE_REVIEW', res.data)
          resolve(res.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },

  async fetchEditReview({commit}, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/reviews/${id}/edit`)
        .then((res) => {
          commit('SET_REVIEW', res.data.data)
          resolve(res.data.data)
        })
        .catch((exception) => {
          reject(exception)
        })
    })
  },

  async createReview({commit}, params) {
    return new Promise((resolve, reject) => {
      this.$axios.post('/reviews', params)
        .then(({ data }) => {
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async updateReview({commit}, params) {
    return new Promise((resolve, reject) => {
      this.$axios.put('/reviews/'+params.id, params)
        .then(({ data }) => {
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async removeReview({commit}, { id }) {
    return new Promise((resolve, reject) => {
      this.$axios.delete('/reviews/'+id)
        .then(({ data }) => {
          commit('REMOVE_REVIEW', id)
          resolve(data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  }

};

const getters = {
  reviews: state => state.reviews,
  current_review: state => state.current_review
};

export default {
  state,
  getters,
  actions,
  mutations
}
