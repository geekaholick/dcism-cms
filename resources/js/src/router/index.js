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
      path: '/',
      name: 'home',
      component: () => import('@/views/Home.vue'),
      meta: {
        pageTitle: 'Home',
        breadcrumb: [
          {
            text: 'Home',
            active: true,
          },
        ],
      },
    },
    {
      path: '/memos',
      name: 'Memos',
      component: () => import('@/views/Memo/Memos.vue'),
      meta: {
        pageTitle: 'Memos',
        breadcrumb: [
          {
            text: 'Memos',
            active: true,
          },
        ],
      },
    },
    {
      path: '/memos/create',
      name: 'MemoCreate',
      component: () => import('@/views/Memo/MemoCreate.vue'),
      meta: {
        pageTitle: 'Create Memo',
        breadcrumb: [
          {
            text: 'Create Memo',
            active: true,
          },
        ],
      },
    },
    {
      path: '/memos/show/:id',
      name: 'MemoDetails',
      component: () => import('@/views/Memo/MemoDetails.vue'),
      meta: {
        pageTitle: 'Memo Details',
        breadcrumb: [
          {
            text: 'Memo Details',
            active: true,
          },
        ],
      },
    },
    {
      path: '/memos/edit/:id',
      name: 'MemoEdit',
      component: () => import('@/views/Memo/MemoEdit.vue'),
      meta: {
        pageTitle: 'Update Memo',
        breadcrumb: [
          {
            text: 'Update Memo',
            active: true,
          },
        ],
      },
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/Login.vue'),
      meta: {
        layout: 'full',
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
