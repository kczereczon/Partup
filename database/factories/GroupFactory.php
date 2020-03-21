<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Group;
use App\User;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName,
        'owner_id' => User::all()->random(1)[0]->id,
        'news_webhook' => $faker->imageUrl(),
        'homework_webhook' => $faker->imageUrl(),
        'exams_webhook' => $faker->imageUrl(),
    ];
});
