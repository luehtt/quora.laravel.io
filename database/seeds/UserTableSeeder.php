<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => '1',
            'name' => 'Lue Quora',
            'password' => bcrypt('password'),
            'email' => 'thanhtoan@demo.com',
            'user_role_id' => 1,
        ]);

        User::create([
            'id' => '2',
            'name' => 'Hạ Âu',
            'password' => bcrypt('password'),
            'email' => 'haau@demo.com',
            'user_role_id' => 2,
            'photo' => 'fujita-maiko.jpg'
        ]);

        User::create([
            'id' => '3',
            'name' => 'Trân Trân',
            'password' => bcrypt('password'),
            'email' => 'trantran@demo.com',
            'user_role_id' => 2,
            'photo' => 'junchi-photo.jpg'
        ]);

        User::create([
            'id' => '4',
            'name' => 'Tạ Thị Chương',
            'password' => bcrypt('password'),
            'email' => 'tachuong@demo.com',
            'user_role_id' => 3,
        ]);

        User::create([
            'id' => '5',
            'name' => 'Hiếu Thảo',
            'password' => bcrypt('password'),
            'email' => 'hieuthao@demo.com',
            'user_role_id' => 3,
        ]);

        User::create([
            'id' => '6',
            'name' => 'Tú Ocschos',
            'password' => bcrypt('password'),
            'email' => 'ocschos@demo.com',
            'user_role_id' => 3,
        ]);
    }
}
