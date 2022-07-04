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
      path: '/view-all-announcement',
      name: 'announcement',
      component: () => import('@/views/announcement.vue'),
      meta: {
        pageTitle: 'All Announcement',
        breadcrumb: [
          {
            text: 'All Announcement',
            active: true,
          },
        ],
      },
    },
        {
      path: '/calendar',
      name: 'calendar',
      component: () => import('@/views/calendar.vue'),
      meta: {
        pageTitle: 'Department Calendar',
        breadcrumb: [
          {
            text: 'Department Calendar',
            active: true,
          },
        ],
      },
    },
          {
      path: '/notifications',
      name: 'notifications',
      component: () => import('@/views/notifications.vue'),
      meta: {
        pageTitle: 'Notifications',
        breadcrumb: [
          {
            text: 'Notifications',
            active: true,
          },
        ],
      },
    },
             {
      path: '/memo',
      name: 'memo',
      component: () => import('@/views/memo.vue'),
      meta: {
        pageTitle: 'Memo',
        breadcrumb: [
          {
            text: 'Memo',
            active: true,
          },
        ],
      },
    },
                {
      path: '/settings',
      name: 'settings',
      component: () => import('@/views/settings.vue'),
      meta: {
        pageTitle: 'Settings',
        breadcrumb: [
          {
            text: 'Settings',
            active: true,
          },
        ],
      },
    },
            {
      path: '/bookmarked-announcement',
      name: 'bookmarked',
      component: () => import('@/views/bookmark.vue'),
      meta: {
        pageTitle: 'Bookmarked Announcement',
        breadcrumb: [
          {
            text: 'Bookmarked Announcement',
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
