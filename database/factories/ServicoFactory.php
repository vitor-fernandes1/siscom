<?php

use Faker\Generator as Faker;

use App\Models\Servico;

$factory->define(Servico::class, function (Faker $faker) {
    return [
        'nr_hrs_servico' => $faker->time,
        'nr_min_hrs_mes_servico' => $faker->time,
        'nr_max_hrs_mes_servico' => $faker->time,

    ];
});
