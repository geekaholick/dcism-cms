/* eslint-disable camelcase */
/* eslint-disable no-shadow */
/* eslint-disable no-unused-vars */
import Api from '../../api/api'
import * as types from './announcementTypes'

const state = {
  errors: null,
  announcement_list: [],
  announcement_count: 0,
}

const getters = {
  [types.GETTER_ALL_ANNOUNCEMENTS]: state => state.announcement_list,
}

const actions = {
  [types.ACTION_GET_ALL_ANNOUNCEMENTS](context, data) {
    return new Promise(resolve => {
      Api().get(`/get-all-announcements?page=${data.args.page}&items=${data.args.perPage}&q=${data.args.q}&sort=${data.args.sortBy}&month=${data.args.months}&year=${data.args.years}&user_id=${data.user_id}`)
        .then(resp => {
          context.commit(types.MUTATION_SET_ALL_ANNOUNCEMENTS, resp.data)
          resolve(resp.data)
        })
        .catch(err => {
          context.commit(types.MUTATION_SET_ERROR, err.response.data.errors)
          resolve(err.response.data.errors)
        })
    })
  },
  [types.ACTION_GET_ANNOUNCEMENTS_COUNT](context, data) {
    return new Promise(resolve => {
      Api().get(`/get-all-announcements-count?q=${data.args.q}&sort=${data.args.sortBy}&month=${data.args.months}&year=${data.args.years}`)
        .then(resp => {
          context.commit(types.MUTATION_SET_ANNOUNCEMENT_COUNT, resp.data)
          resolve(resp.data)
        })
        .catch(err => {
          context.commit(types.MUTATION_SET_ERROR, err.response.data.errors)
          resolve(err.response.data.errors)
        })
    })
  },
  [types.ACTION_GET_FILTERED_ANNOUNCEMENTS](context, data) {
    return new Promise(resolve => {
      Api().get(`/get-filtered-announcements?page=${data.page}&items=${data.items}&q=${data.q}`)
        .then(resp => {
          resolve(resp.data)
        })
        .catch(err => {
          context.commit(types.MUTATION_SET_ERROR, err.response.data.errors)
          resolve(err.response.data.errors)
        })
    })
  },
  [types.ACTION_BOOKMARK_ANNOUNCEMENT](context, data) {
    return new Promise(resolve => {
      Api().post('/bookmark-announcement', data)
        .then(res => {
          resolve(res.data)
        })
        .catch(err => {
          context.commit(types.MUTATION_SET_ERROR, err.response.data.errors)
          resolve(err.response.data.errors)
        })
    })
  },
  [types.ACTION_UNBOOKMARK_ANNOUNCEMENT](context, data) {
    return new Promise(resolve => {
      Api().post('/unbookmark-announcement', data)
        .then(res => {
          resolve(res.data)
        })
        .catch(err => {
          context.commit(types.MUTATION_SET_ERROR, err.response.data.errors)
          resolve(err.response.data.errors)
        })
    })
  },
}

const mutations = {
  [types.MUTATION_SET_ALL_ANNOUNCEMENTS](state, announcement_list) {
    state.announcement_list = announcement_list
  },
  [types.MUTATION_SET_ERROR](state, error) {
    state.errors = error
  },
  [types.MUTATION_SET_ANNOUNCEMENT_COUNT](state, count) {
    state.announcement_count = count
  },

}

export default {
  state,
  actions,
  getters,
  mutations,
}
