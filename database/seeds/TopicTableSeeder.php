<?php

use App\Topic;
use Illuminate\Database\Seeder;

class TopicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topic::create([
            'id' => 1,
            'name' => 'HTML',
            'slug' => 'html',
            'channel_id' => 1,
            'description' => 'Hypertext Markup Language is the standard markup language for creating web pages and web applications.'
        ]);

        Topic::create([
            'id' => 2,
            'name' => 'CSS',
            'slug' => 'css',
            'channel_id' => 1,
            'description' => 'Cascading Style Sheets is a style sheet language used for describing the presentation of a document written in a markup language like HTML.'
        ]);

        Topic::create([
            'id' => 3,
            'name' => 'Bootstrap',
            'slug' => 'bootstrap',
            'channel_id' => 1,
            'description' => 'Bootstrap is a free and open-source front-end framework for designing websites and web applications.'
        ]);

        Topic::create([
            'id' => 4,
            'name' => 'Material',
            'slug' => 'material',
            'channel_id' => 1,
            'description' => 'Material is a React components that implement Google Material Design.'
        ]);

        Topic::create([
            'id' => 5,
            'name' => 'PHP',
            'slug' => 'php',
            'channel_id' => 2,
            'description' => 'The PHP Hypertext Preprocessor (PHP) is a programming language that allows web developers to create dynamic content that interacts with databases. PHP is basically used for developing web based software applications.'
        ]);

        Topic::create([
            'id' => 6,
            'name' => 'Laravel',
            'slug' => 'laravel',
            'channel_id' => 2,
            'description' => 'Laravel is a free, open-source PHP web framework, intended for the development of web applications following the model–view–controller (MVC).'
        ]);

        Topic::create([
            'id' => 7,
            'name' => 'Symfony',
            'slug' => 'symphony',
            'channel_id' => 2,
            'description' => 'Symfony is a PHP web application framework and a set of reusable PHP components/libraries.'
        ]);

        Topic::create([
            'id' => 8,
            'name' => 'Phalcon',
            'slug' => 'phalcon',
            'channel_id' => 2,
            'description' => 'Phalcon is a free, open-source PHP web framework, based on the model–view–controller (MVC) pattern.'
        ]);

        Topic::create([
            'id' => 9,
            'name' => 'Yii',
            'slug' => 'yii',
            'channel_id' => 2,
            'description' => 'Yii is an open source, object-oriented, component-based MVC PHP web application framework.'
        ]);

        Topic::create([
            'id' => 10,
            'name' => 'CodeIgniter',
            'slug' => 'code-igniter',
            'channel_id' => 2,
            'description' => 'CodeIgniter is an open-source software rapid development web framework, for use in building dynamic web sites with PHP.'
        ]);

        Topic::create([
            'id' => 11,
            'name' => 'Java',
            'slug' => 'java',
            'channel_id' => 3,
            'description' => 'Java is a general-purpose computer-programming language that is concurrent, class-based, object-oriented.'
        ]);

        Topic::create([
            'id' => 12,
            'name' => 'JSF',
            'slug' => 'jsf',
            'channel_id' => 3,
            'description' => 'JavaServer Faces is a Java specification for building component-based user interfaces for web applications.'
        ]);

        Topic::create([
            'id' => 13,
            'name' => 'Spring Boot',
            'slug' => 'spring-boot',
            'channel_id' => 3,
            'description' => 'Spring Boot is an open source Java-based framework used to create a Micro Service.'
        ]);

        Topic::create([
            'id' => 14,
            'name' => 'Struts',
            'slug' => 'struts',
            'channel_id' => 3,
            'description' => 'Struts 2 is an open-source web application framework for developing Java EE web applications.'
        ]);

        Topic::create([
            'id' => 15,
            'name' => 'Node.js',
            'slug' => 'node-js',
            'channel_id' => 4,
            'description' => 'Node.js is an open-source, cross-platform JavaScript run-time environment that executes JavaScript code outside of a browser.'
        ]);

        Topic::create([
            'id' => 16,
            'name' => 'Express.js',
            'slug' => 'express.js',
            'channel_id' => 4,
            'description' => 'Express.js is a web application framework for Node.js, designed for building web applications and APIs.'
        ]);

        Topic::create([
            'id' => 17,
            'name' => 'Koa',
            'slug' => 'koa',
            'channel_id' => 4,
            'description' => 'Koa is a new web framework for Node.js, aims to be a smaller, more expressive, and more robust foundation.'
        ]);
    }
}
