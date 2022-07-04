export default [
    {
        title: "Home",
        route: "home",
        icon: "HomeIcon",
    },
    {
        title: "Announcement",
        icon: "LayoutIcon",
        children: [
            {
                title: "All Announcement",
                route: "announcement",
            },
            {
                title: "Bookmarked Announcement",
                route: "bookmarked",
            },
        ],
    },
    {
        title: "Department Calendar",
        route: "calendar",
        icon: "CalendarIcon",
    },
    {
        title: "Notifications",
        route: "notifications",
        icon: "BellIcon",
    },
    {
        title: "Memo",
        route: "memo",
        icon: "FileTextIcon",
    },
        {
        title: "Settings",
        route: "settings",
        icon: "SettingsIcon",
    },
];
