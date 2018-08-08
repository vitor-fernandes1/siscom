<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Apenado::class, function (Faker $faker) {
    return [
       
        'nm_apenado'     => $faker->name,
        'nr_cpf_apenado' => $faker->randomNumber
           

    ];
});
