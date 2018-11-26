<?php

use App\Channel;
use Illuminate\Database\Seeder;

class ChannelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Channel::create([
            'id' => 1,
            'name' => 'HTML',
            'slug' => 'html',
            'description' => 'Hypertext Markup Language is the standard markup language for creating web pages and web applications.'
        ]);

        Channel::create([
            'id' => 2,
            'name' => 'PHP',
            'slug' => 'php',
            'description' => 'PHP Hypertext Preprocessor (PHP) is a programming language that allows web developers to create dynamic content that interacts with databases. PHP is basically used for developing web based software applications.'
        ]);

        Channel::create([
            'id' => 3,
            'name' => 'Java',
            'slug' => 'java',
            'description' => 'Java is a general-purpose computer-programming language that is concurrent, class-based, object-oriented.'
        ]);

        Channel::create([
            'id' => 4,
            'name' => 'Node.js',
            'slug' => 'node-js',
            'description' => 'Node.js is an open-source, cross-platform JavaScript run-time environment that executes JavaScript code outside of a browser.'
        ]);
    }
}
