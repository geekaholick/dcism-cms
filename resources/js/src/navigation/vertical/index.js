export default [
    {
        title: "Home",
        route: "home",
        icon: "HomeIcon",
    },
    {
        title: "Announcement",
        route: "second-page",
        icon: "FileIcon",
        children: [
            {
                title: "Bookmarked Announcement",
                route: "second-page",
            },
        ],
    },
    {
        title: "Department Calendar",
        route: "second-page",
        icon: "CalendarIcon",
    },
    {
        title: "Memo",
        route: "second-page",
        icon: "FileTextIcon",
    },
];
