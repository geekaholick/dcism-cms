import Vue from 'vue'
export default new Vue()
import { ToastPlugin, ModalPlugin } from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'
import { TablePlugin } from 'bootstrap-vue'
import { FormInputPlugin } from 'bootstrap-vue'
import { LayoutPlugin } from 'bootstrap-vue'
import { PaginationPlugin } from 'bootstrap-vue'
import { FormPlugin } from 'bootstrap-vue'
import { FormSelectPlugin } from 'bootstrap-vue'
import { FormFilePlugin } from 'bootstrap-vue'
import { ButtonPlugin } from 'bootstrap-vue'
import { ImagePlugin } from 'bootstrap-vue'
import { AlertPlugin } from 'bootstrap-vue'

import router from './router'
import store from './store'
import FacultyManagementApp from './FacultyManagementApp.vue'
import StudentManagementApp from './StudentManagementApp.vue'

// Global Components
import './global-components'

// 3rd party plugins
import '@/libs/portal-vue'
import '@/libs/toastification'

// BSV Plugin Registration
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)
Vue.use(TablePlugin)
Vue.use(FormInputPlugin)
Vue.use(LayoutPlugin)
Vue.use(PaginationPlugin)
Vue.use(FormPlugin)
Vue.use(FormSelectPlugin)
Vue.use(FormFilePlugin)
Vue.use(ButtonPlugin)
Vue.use(ImagePlugin)
Vue.use(AlertPlugin)

// Composition API
Vue.use(VueCompositionAPI)

// import core styles
require('@core/scss/core.scss')

// import assets styles
require('@/assets/scss/style.scss')

Vue.config.productionTip = false

if(document.getElementById("FacultyManagementApp")){
new Vue({
  router,
  store,
  render: h => h(FacultyManagementApp),
}).$mount('#FacultyManagementApp')
}

if(document.getElementById("StudentManagementApp")){
  new Vue({
    router,
    store,
    render: h => h(StudentManagementApp),
  }).$mount('#StudentManagementApp')
  }