<?php

use Faker\Generator as Faker;

use App\Models\Pena;

$factory->define(Pena::class, function (Faker $faker) {
    return [
        
        'nr_processo_pena' => $faker->randomNumber,
        'ds_pena' => $faker->text
        
    ];
});
