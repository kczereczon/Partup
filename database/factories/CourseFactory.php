<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Course;
use App\Group;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName,
        'owner_id' => '',
        'group_id' => Group::all()->random(0)->id,
    ];
});
