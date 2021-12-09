import axios from 'axios'

export default {
  namespaced: true,
  state: {
    user_id: null,
    role_id: null,
    user_email: '',
    first_name: '',
    last_name: '',
    user_image: '',
    created_at: null,
    updated_at: null,
  },
  getters: {
    getLoggedInUserData: state => state,
    getFirstName: state => state.first_name,
    getLastName: state => state.last_name,
    getRoleName: state => {
      let role
      if(state.role_id === 1) {
        role = 'Head'
      }else if(state.role_id === 2) {
        role = 'Faculty'
      }else if(state.role_id === 3) {
        role = 'Student'
      }
      return role
    }
  },
  mutations: {
    loginUserData(state, payload) {
      state.user_id = payload.id
      state.role_id = payload.role_id
      state.user_email = payload.user_email
      state.first_name = payload.first_name
      state.last_name = payload.last_name
      state.user_image = payload.user_image
      state.created_at = payload.created_at
      state.updated_at = payload.updated_at
    },
  },
  actions: {
    async setLoginUserData(state) {
      axios.get('/api/auth/user', {
        headers: {
          'Content-Type': 'application/json',
          Authorization: localStorage.getItem('token_type') + ' ' + localStorage.getItem('access_token'),
        },
      }).then(res => {
        state.commit('loginUserData', res.data)
      })
    },
  },
}
