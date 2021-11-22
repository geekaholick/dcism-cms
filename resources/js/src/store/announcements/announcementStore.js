/* eslint-disable no-shadow */
/* eslint-disable no-unused-vars */
import Api from '../../api/api'
import * as types from './announcementTypes'

const state = {
  errors: null,
  announcement_list: [],
}

const getters = {
  [types.GETTER_ALL_ANNOUNCEMENTS]: state => state.announcement_list,
}

const actions = {
  [types.ACTION_GET_ALL_ANNOUNCEMENTS](context, data) {
    return new Promise(resolve => {
      console.log('actions announcements')
    //   Api().get(temp)
    //     .then(resp => {
    //       context.commit(types.MUTATION_SET_ALL_JOB, resp.data)
    //       resolve(resp.data)
    //     })
    //     .catch(err => {
    //       context.commit(types.MUTATION_SET_ERROR, err.response.data.errors)
    //       resolve(err.response.data.errors)
    //     })
    })
  },
}

export default {
  state,
  actions,
  getters,
}
