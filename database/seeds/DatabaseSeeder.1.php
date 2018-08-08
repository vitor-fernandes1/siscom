<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // Inicializar constantes do sistema no BD
        $this->call('InitDefaultValuesSeeder');
        // Inicializar com dados de instituições bancárias
        $this->call('InitBancosTableSeeder');

        // Para Testes em Desenvolvimento - Com dados falsos e aleatórios
        //$this->call(ApenadoTableSeeder::class);
    }
}
