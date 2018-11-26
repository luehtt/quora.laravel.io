<?php

use App\Reply;
use Illuminate\Database\Seeder;

class ReplyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reply::create([
            'discussion_id' => 1,
            'user_id' => 3,
            'content' => 'Nulla eget nibh hendrerit, lacinia ex vitae, dignissim quam. Donec finibus nisl auctor euismod ultricies. Phasellus mollis placerat lacus in tristique. Nunc eu justo lorem. Vivamus risus augue, egestas bibendum blandit sit amet, laoreet iaculis tortor. Proin ut orci aliquet lacus pharetra dignissim.'
        ]);

        Reply::create([
            'discussion_id' => 1,
            'user_id' => 3,
            'content' => 'Quisque fermentum suscipit eros porttitor dictum. Nullam bibendum commodo neque, ut gravida libero euismod eu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vestibulum a tempus ex. Fusce ut eros ullamcorper, feugiat purus at, tempus neque.'
        ]);

        Reply::create([
            'discussion_id' => 1,
            'user_id' => 3,
            'content' => 'Nulla eget nibh hendrerit, lacinia ex vitae, dignissim quam. Donec finibus nisl auctor euismod ultricies. Phasellus mollis placerat lacus in tristique. Nunc eu justo lorem. Vivamus risus augue, egestas bibendum blandit sit amet, laoreet iaculis tortor. Proin ut orci aliquet lacus pharetra dignissim.'
        ]);

        Reply::create([
            'discussion_id' => 1,
            'user_id' => 3,
            'content' => 'Quisque fermentum suscipit eros porttitor dictum. Nullam bibendum commodo neque, ut gravida libero euismod eu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vestibulum a tempus ex. Fusce ut eros ullamcorper, feugiat purus at, tempus neque.'
        ]);

        Reply::create([
            'discussion_id' => 2,
            'user_id' => 4,
            'content' => 'Nulla eget nibh hendrerit, lacinia ex vitae, dignissim quam. Donec finibus nisl auctor euismod ultricies. Phasellus mollis placerat lacus in tristique. Nunc eu justo lorem. Vivamus risus augue, egestas bibendum blandit sit amet, laoreet iaculis tortor. Proin ut orci aliquet lacus pharetra dignissim.'
        ]);

        Reply::create([
            'discussion_id' => 2,
            'user_id' => 4,
            'content' => 'Quisque fermentum suscipit eros porttitor dictum. Nullam bibendum commodo neque, ut gravida libero euismod eu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vestibulum a tempus ex. Fusce ut eros ullamcorper, feugiat purus at, tempus neque.'
        ]);
    }
}
