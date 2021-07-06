function getDefaultState() {
  return {
    value: {
      age_from: null,
      age_to: null,
      height_from: null,
      height_to: null,
      nationality: null,
      hairs: null,
      verified: null,
      ready_for_travels: null
    }
  }
};

const state = getDefaultState

const mutations = {
  SET_AGE_FROM(state, val) {
    state.age_from = val
  },
  SET_AGE_TO(state, val) {
    state.age_to = val
  },
  SET_HEIGHT_FROM(state, val) {
    state.height_from = val
  },
  SET_HEIGHT_TO(state, val) {
    state.height_to = val
  },
  SET_NATIONALITY(state, val) {
    state.nationality = val
  },
  SET_HAIRS(state, val) {
    state.hairs = val
  },
  SET_VERIFIED(state, val) {
    state.verified = val
  },
  UPDATE(state, map) {
    for(let i in map) {
      if(state.value[i] !== undefined) {
        state.value[i] = map[i]
      }
    }
  },
  reset(state) {
    const defaultState = getDefaultState()

    for(let i in defaultState.value) {
      state.value[i] = defaultState.value[i]
    }
  },

  SET_READY_FOR_TRAVELS(state, val) {
    state.ready_for_travels = val
  },
};

const actions = {
  setAgeFrom({ commit }, val) {
    commit('SET_AGE_FROM', val)
  },
  setAgeTo({ commit }, val) {
    commit('SET_AGE_TO', val)
  },
  setHeightFrom({ commit }, val) {
    commit('SET_HEIGHT_FROM', val)
  },
  setHeightTo({ commit }, val) {
    commit('SET_HEIGHT_TO', val)
  },
  setNationality({ commit }, val) {
    commit('SET_NATIONALITY', val)
  },
  setVerified({ commit }, val) {
    commit('SET_VERIFIED', val)
  },
  setHairs({ commit }, val) {
    commit('SET_HAIRS', val)
  },
  setReadyForTravels({ commit }, val) {
    commit('SET_READY_FOR_TRAVELS', val)
  }
};

const getters = {
  age_from: state => state.value.age_from,
  age_to: state => state.value.age_to,
  height_from: state => state.value.height_from,
  height_to: state => state.value.height_to,
  nationality: state => state.value.nationality,
  hairs: state => state.value.hairs,
  verified: state => state.value.verified,
  ready_for_travels: state => state.ready_for_travels,

  all: state => state.value
}

export default {
  state,
  getters,
  actions,
  mutations
}
