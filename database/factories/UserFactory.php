<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'address'           => 'Landmark 5, Nguyen Huu Canh',
        'avatar'            => 'https://via.placeholder.com/150',
        'birth_day'         => '01/01/2020',
        'name'              => $this->faker->name,
        'email'             => $this->faker->unique()->safeEmail,
        'gender'            => rand(0, 1),
        'password'          => '$2y$10$1IcAWCrSnkGsF95spji8LeWXgXyLDZ6hPeqyEi9EwHBDrzsHL5nYS', // password
        'phone'             => '03' . rand(8, 9) . rand(1000000, 9999999),
        'remember_token'    => Str::random(60),
        'role_id'           => 2,
        'shop'              => rand(1, 50)
    ];
});
