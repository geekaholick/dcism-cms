export default [
  {
    title: 'Home',
    route: 'home',
    icon: 'HomeIcon',
  },
  {
    title: 'Second Page',
    route: 'second-page',
    icon: 'FileIcon',
  },
  {
    title: 'Announcements',
    icon: 'PackageIcon',
    children: [
      {
        title: 'All Announcements',
        route: 'view-all-announcements',
      },
      {
        title: 'Bookmarks',
        route: 'view-bookmarked-announcements',
      },
    ],
  },
]
