import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/FacultyManagement',
      name: 'FacultyManagementApp',
      component: () => import('@/FacultyManagementApp.vue'),
      meta: {
        pageTitle: 'App',
        breadcrumb: [
          {
            text: 'App',
            active: true,
          },
        ],
      },
    },
    {
      path: '/StudentManagement',
      name: 'StudentManagementApp',
      component: () => import('@/StudentManagementApp.vue'),
      meta: {
        pageTitle: 'App2',
        breadcrumb: [
          {
            text: 'App2',
            active: true,
          },
        ],
      },
    },
    {
      path: '/error-404',
      name: 'error-404',
      component: () => import('@/views/error/Error404.vue'),
      meta: {
        layout: 'full',
      },
    },  
    {
      path: '*',
      redirect: 'error-404',
    },
  ],
})

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

export default router
