<?php

use App\UserRole;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create([ 'name' => 'ADMIN' ]);
        UserRole::create([ 'name' => 'MODERATOR' ]);
        UserRole::create([ 'name' => 'USER' ]);
    }
}
