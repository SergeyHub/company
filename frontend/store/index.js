const cookieparser = process.server ? require('cookieparser') : undefined

const state = () => ({
  top_countries: [],
  countries: [],
  cities: [],
  country: null,
  geography: null,
  geographies: null,
  agency: null,
  city: {},
  subscribed: false,
  archive_columns: 1
});

const mutations = {
  SET_COUNTRIES(state, countries) {
    state.countries = countries
  },

  SET_TOP_COUNTRIES(state, countries) {
    state.top_countries = countries
  },

  SET_CITIES(state, cities) {
    state.cities = cities
  },

  SET_CURRENT_COUNTRY(state, country) {
    state.country = country;
  },

  SET_GEOGRAPHIES(state, geographies) {
    state.geographies = geographies
  },

  SET_CURRENT_GEOGRAPHY(state, geography) {
    state.geography = geography;
  },

  SET_CURRENT_AGENCY(state, agency) {
    state.agency = agency;
  },

  SET_CURRENT_CITY(state, city) {
    state.city = city;
  },

  SET_SUBSCRIBED(state, data) {
    state.subscribed = data;
  },

  SET_ARCHIVE_COLUMNS(state, data) {
    state.archive_columns = data
    this.$cookies.set('archiveColumns', data)
  }
};

const actions = {
  async setCountries({commit}, section) {
    await this.$axios.get(`/countries`, {params: {section: section}})
      .then((res) => {
        if (res.status === 200) {
          commit('SET_COUNTRIES', res.data.data)
        }
      })
  },

  async setGeographies({commit}) {
    await this.$axios.get(`/geographies`)
      .then((res) => {
        if (res.status === 200) {
          commit('SET_GEOGRAPHIES', res.data.data)
        }
      })
  },

  async setTopCountries({commit}, section) {
    await this.$axios.get(`/countries/top`, {params: {section: section}})
      .then((res) => {
        if (res.status === 200) {
          commit('SET_TOP_COUNTRIES', res.data.data)
        }
      })
  },

  async getCitiesForCountry({commit}, country_id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/cities`, {params: {country_id: country_id}})
        .then((res) => {
          commit('SET_CITIES', res.data.data)
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchAndSetCountry({ commit }, data) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/countries/slug/${data.slug}`, {params: {section: data.section}})
        .then((res) => {
            commit('SET_CURRENT_COUNTRY', res.data.data)
            resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async fetchAndSetGeography({ commit }, slug) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/geographies/slug/${slug}`)
        .then((res) => {
          commit('SET_CURRENT_GEOGRAPHY', res.data.data)
          resolve(res.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async setCurrentCity({commit}, city_slug) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`/cities/slug/${city_slug}`)
        .then((res) => {
          commit('SET_CURRENT_CITY', res.data.data)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async resetCity({ commit }) {
    commit('SET_CURRENT_CITY', null)
  },

  async resetCountry({ commit }) {
    commit('SET_CURRENT_COUNTRY', null)
  },

  async resetGeography({ commit }) {
    commit('SET_CURRENT_GEOGRAPHY', null)
  },

  async resetAgency({ commit }) {
    commit('SET_CURRENT_AGENCY', null)
  },

  async nuxtServerInit ({ commit, dispatch, rootState }, { req, res, isDev }) {
    let token = this.$cookies.get('token_mybestgigalo')
    commit('auth/SET_TOKEN', token)
    if(token) {
      try {
        await dispatch('auth/fetchUser')
      } catch (e) {
        // удаляем токен авторизации
        this.$cookies.remove('token_mybestgigalo', {
          path: '/'
        })
      }
    }

    let archiveColumnsCount = this.$cookies.get('archiveColumns')
    if(archiveColumnsCount) {
      commit('SET_ARCHIVE_COLUMNS', archiveColumnsCount)
    }
  },

  // проверка подписки на новости
  async checkSubscribed({ commit }, type) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/subscribe/check`, {type})
        .then((res) => {
          commit('SET_SUBSCRIBED', res.data.exists)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  },

  async subscribe({ commit }, type) {
    return new Promise((resolve, reject) => {
      this.$axios.post(`/subscribe`, {type})
        .then((res) => {
          commit('SET_SUBSCRIBED', true)
          resolve(res.data.data)
        })
        .catch((error) => {
          reject(error)
        })
    })
  }
};

const getters = {
  countries: state => state.countries,
  top_countries: state => state.top_countries,
  cities: state => state.cities,
  country: state => state.country,
  geography: state => state.geography,
  geographies: state => state.geographies,
  agency: state => state.agency,
  city: state => state.city,
  subscribed: state => state.subscribed,
  archive_columns: state => state.archive_columns
};

export default {
  state,
  getters,
  actions,
  mutations
}
