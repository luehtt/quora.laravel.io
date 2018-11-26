<?php

use App\Discussion;
use Illuminate\Database\Seeder;

class DiscussionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discussion::create([
            'id' => 1,
            'title' => 'Kinh nghiệm sử dụng Vanilla.js',
            'slug' => 'kinh-nghiem-su-dung-vanilla-js',
            'topic_id' => 2,
            'user_id' => 2,
            'view' => 4,
            'content' => 'Nulla nibh turpis, condimentum id semper sed, bibendum quis massa. Duis at libero sit amet quam ultrices bibendum. Aliquam ante magna, rhoncus quis ultrices a, scelerisque vel lectus. Donec vitae cursus ligula. In molestie ornare eros, a vestibulum sem auctor quis.'
        ]);

        Discussion::create([
            'id' => 2,
            'title' => 'Sử dụng CSS thiết kế Responsive',
            'slug' => 'su-dung-css-thiet-ke-responsive',
            'topic_id' => 2,
            'user_id' => 2,
            'view' => 10,
            'content' => 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus vestibulum lorem nibh, at dignissim tortor lobortis sit amet.'
        ]);

        Discussion::create([
            'id' => 3,
            'title' => 'Bootstrap 4 Grid sử dụng thế nào?',
            'slug' => 'bootstrap-4-grid-su-dung-the-nao',
            'topic_id' => 3,
            'user_id' => 3,
            'content' => 'Nulla nibh turpis, condimentum id semper sed, bibendum quis massa. Duis at libero sit amet quam ultrices bibendum. Aliquam ante magna, rhoncus quis ultrices a, scelerisque vel lectus. Donec vitae cursus ligula. In molestie ornare eros, a vestibulum sem auctor quis.'
        ]);

        Discussion::create([
            'id' => 4,
            'title' => 'So sánh Bootstrap 3 và Bootstrap 4',
            'slug' => 'so-sanh-css-bootstrap-3-va-bootstrap-4',
            'topic_id' => 3,
            'user_id' => 3,
            'content' => 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus vestibulum lorem nibh, at dignissim tortor lobortis sit amet.'
        ]);
    }
}
