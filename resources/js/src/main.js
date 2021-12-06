import Vue from 'vue'
import { ToastPlugin, ModalPlugin } from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'

import router from './router'
import store from './store'
import App from './App.vue'

// Global Components
import './global-components'

// 3rd party plugins
import '@/libs/portal-vue'
import '@/libs/toastification'
import moment from 'moment'
import VueSweetalert2 from 'vue-sweetalert2';
import VueExpandableImage from 'vue-expandable-image'

// Expandable image plugin
Vue.use(VueExpandableImage)

// Alert plugin
Vue.use(VueSweetalert2);

// BSV Plugin Registration
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)

// Composition API
Vue.use(VueCompositionAPI)

// import core styles
require('@core/scss/core.scss')

// import assets styles
require('@/assets/scss/style.scss')

// Format Date plugin
Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('MMMM DD, YYYY')
  }
})

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
