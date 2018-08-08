<?php

use Faker\Generator as Faker;

use App\Models\Multa;

$factory->define(Multa::class, function (Faker $faker) {
    return [
        'vl_multa' => $faker->numberBetween(1000,9000),
    ];
});
