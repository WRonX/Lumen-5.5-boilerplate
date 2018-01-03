<?php

use App\Models\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function(Faker $faker)
{
    static $password;
    static $activationToken;
    
    return
    [
        'email'            => $faker->unique()->safeEmail,
        'password'         => $password ? : $password = app('hash')->make('password'),
        'name'             => $faker->name,
        'activation_token' => $activationToken ? : $activationToken = 'token',
        'remember_token'   => str_random(32),
    ];
});
