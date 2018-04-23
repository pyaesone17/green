<?php 

require __DIR__.'/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Green\Models\User;
use Green\Support\PasswordHasher;

$app = new Green\App(realpath(__DIR__));

Capsule::schema()->drop("ratings");
Capsule::schema()->drop("recipes");
Capsule::schema()->drop("users");

if(Capsule::schema()->hasTable('users')===false){
    Capsule::schema()->create('users', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    });  
}

if (Capsule::schema()->hasTable('recipes')===false) {
    Capsule::schema()->create('recipes', function ($table) {
        $table->increments('id');
        $table->integer('user_id')->unsigned()->nullable();
        $table->string('name');
        $table->integer('prepare_time');
        $table->integer('difficulty');
        $table->boolean('vegetarian');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
}

if (Capsule::schema()->hasTable('ratings')===false) {
    Capsule::schema()->create('ratings', function ($table) {
        $table->increments('id');
        $table->integer('recipe_id')->unsigned();
        $table->integer('user_id')->unsigned()->nullable();
        $table->integer('stars');
        $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
}

if(User::whereEmail('test@hellofresh.com')->first()==null) {
    User::create([
        'name' => 'hello fresh',
        'email' => 'test@hellofresh.com',
        'password' => PasswordHasher::hash("hellofresh")
    ]);
}