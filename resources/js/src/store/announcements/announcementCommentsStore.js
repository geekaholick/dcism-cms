/* eslint-disable camelcase */
/* eslint-disable no-shadow */
/* eslint-disable no-unused-vars */
import Api from '../../api/api'
import * as types from './announcementComments'

const state = {
  errors: null,
  comment_list: [],
  comment_count: 0,
}

const getters = {
  [types.GETTER_ALL_COMMENTS]: state => state.comment_list,
}

const actions = {
  [types.ACTION_GET_ALL_COMMENTS](context, data) {
    return new Promise(resolve => {
      console.log('actions comments')
      console.log(data)
      Api().get(data.items ? `/get-all-commentss?page=${data.page}&items=${data.items}`
        : `/get-all-comments?page=${data.page}`)
        .then(resp => {
          context.commit(types.MUTATION_SET_ALL_COMMENTS, resp.data)
          resolve(resp.data)
        })
        .catch(err => {
          context.commit(types.MUTATION_SET_ERROR, err.response.data.errors)
          resolve(err.response.data.errors)
        })
    })
  },
  [types.ACTION_GET_COMMENTS_COUNT](context, data) {
    return new Promise(resolve => {
      Api().get('/get-all-comments-count')
        .then(resp => {
          context.commit(types.MUTATION_SET_COMMENT_COUNT, resp.data)
          resolve(resp.data)
        })
        .catch(err => {
          context.commit(types.MUTATION_SET_ERROR, err.response.data.errors)
          resolve(err.response.data.errors)
        })
    })
  },
}

const mutations = {
  [types.MUTATION_SET_ALL_COMMENTS](state, comment_list) {
    state.comment_list = comment_list
  },
  [types.MUTATION_SET_ERROR](state, error) {
    state.errors = error
  },
  [types.MUTATION_SET_COMMENT_COUNT](state, count) {
    state.comment_count = count
  },

}

export default {
  state,
  actions,
  getters,
  mutations,
}
