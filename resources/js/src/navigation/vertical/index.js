export default [
    {
        title: "Home",
        route: "home",
        icon: "HomeIcon",
    },
    {
        title: "Announcement",
        route: "second-page",
        icon: "LayoutIcon",
        children: [
            {
                title: "All Announcement",
                route: "second-page",
            },
            {
                title: "Bookmarked Announcement",
                route: null,
            },
        ],
    },
    {
        title: "Department Calendar",
        route: null,
        icon: "CalendarIcon",
    },
    {
        title: "Notifications",
        route: null,
        icon: "BellIcon",
    },
    {
        title: "Memo",
        route: null,
        icon: "FileTextIcon",
    },
];
