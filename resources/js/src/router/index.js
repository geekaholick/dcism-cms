/* eslint-disable import/no-unresolved */
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
      path: '/second-page',
      name: 'second-page',
      component: () => import('@/views/SecondPage.vue'),
      meta: {
        pageTitle: 'Second Page',
        breadcrumb: [
          {
            text: 'Second Page',
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
      path: '/view-all-announcements',
      name: 'view-all-announcements',
      component: () => import('@/views/announcements/all/AllAnnouncement.vue'),
      meta: {
        contentRenderer: 'sidebar-left-detached',
        contentClass: 'ecommerce-application',
        pageTitle: 'All Announcements',
        breadcrumb: [
          {
            text: 'View All Announcements',
            active: true,
          },
        ],
      },
    },
    {
      path: '/user-role-privilege-management',
      name: 'user-role-privilege-management',
      component: () => import('@/views/UserRolePrivilegeManagement/UserRolePrivilegeApp.vue'),
      meta: {
       // contentRenderer: 'sidebar-left-detached',
        //contentClass: 'ecommerce-application',
        pageTitle: 'User Role Management',
        breadcrumb: [
          {
            text: 'User Role Management',
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
