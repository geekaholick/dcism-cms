<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();
        \App\Models\Roles::factory(3)->create();
        \App\Models\UserPrivileges::factory(5)->create();
        // uncomment this when we have column names for this Model
        \App\Models\PrivilegeLevelInfo::factory(3)->create();


        \App\Models\AnnouncementApproval::factory(5)->create();
        \App\Models\AnnouncementComments::factory(150)->create();
        \App\Models\Announcements::factory(150)->create();
        \App\Models\AnnouncementImages::factory(5)->create();
        \App\Models\Bookmarks::factory(50)->create();

        \App\Models\MemoRepo::factory(5)->create();
        \App\Models\Notifications::factory(100)->create();
    }
}
