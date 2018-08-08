<?php

use Faker\Generator as Faker;

use App\Models\Pecunia;

$factory->define(Pecunia::class, function (Faker $faker) {
    return [
        'nr_parcelas_pecuniaria' => $faker->randomDigitNotNull,
        'vl_pecuniaria'          => $faker->randomFloat,
        'dt_inicio_pecuniaria'   => $faker->dateTime,   
    ];
});
