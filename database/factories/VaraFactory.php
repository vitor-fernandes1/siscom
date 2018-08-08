<?php

use Faker\Generator as Faker;

use App\Models\Vara;

$factory->define(Vara::class, function (Faker $faker) {
    return [
        'nm_vara' => $faker->name,
    ];
});
