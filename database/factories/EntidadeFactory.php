<?php

use Faker\Generator as Faker;

use App\Models\Entidade;

$factory->define(Entidade::class, function (Faker $faker) {
    return [
        'nm_entidade'       => $faker->name,
        'ds_email_entidade' => $faker->freeEmail
    ];
});
