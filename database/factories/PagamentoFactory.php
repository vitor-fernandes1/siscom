<?php

use Faker\Generator as Faker;

use App\Models\Pagamento;

$factory->define(Pagamento::class, function (Faker $faker) {
    return [
        'vl_antes_pagamento'   => $faker->numberBetween(1000,9000),
        'vl_pago_pagamento'    => $faker->numberBetween(1000,9000),
        'vl_atual_pagamento   '=> $faker->numberBetween(1000,9000),
        'dt_pagamento'         => $faker->dateTime,
        'ref_pagamento'        => $faker->date,
        'nr_guia_pagamento'    => $faker->randomDigitNotNull
          
    ];
});
