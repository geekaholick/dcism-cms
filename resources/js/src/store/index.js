import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import app from './app'
import appConfig from './app-config'
import verticalMenu from './vertical-menu'
import announcementStore from './announcements/announcementStore'
import user from './user'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    app,
    appConfig,
    verticalMenu,
    announcementStore,
    user,
  },
  strict: process.env.DEV,
})
