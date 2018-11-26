<?php

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
        $this->call(UserRoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ReportReasonTableSeeder::class);
        $this->call(ChannelTableSeeder::class);
        $this->call(TopicTableSeeder::class);
        $this->call(DiscussionTableSeeder::class);
        $this->call(ReplyTableSeeder::class);
    }
}
