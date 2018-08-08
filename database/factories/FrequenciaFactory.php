<?php

use Faker\Generator as Faker;

use App\Models\Frequencia;

$factory->define(Frequencia::class, function (Faker $faker) {
    return [
            'nr_hrs_antes_frequencia'     => $faker->numberBetween(1000,9000),
            'nr_hrs_depois_frequencia'    => $faker->numberBetween(1000,9000),
            'nr_hrs_pago_frequencia'      => $faker->numberBetween(1000,9000),
            'hr_entrada_frequencia'       => $faker->dateTime,
            'hr_saida_frequencia'         => $faker->dateTime,
            'ref_frequencia'              => $faker->date,
            'dt_frequencia'               => $faker->date
    
    ];
});
