<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiscomPrioridadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siscom_prioridade', function (Blueprint $table) {
            $table->increments('pk_prioridade');
            $table->string('ds_prioridade', 50);
            $table->timestamp('dt_cadastro_prioridade')->useCurrent();
            $table->timestamp('dt_atualizacao_prioridade')->nullable();
            $table->timestamp('dt_exclusao_prioridade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siscom_prioridade');
    }
}
