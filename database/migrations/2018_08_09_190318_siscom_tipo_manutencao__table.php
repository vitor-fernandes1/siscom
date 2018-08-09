<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiscomTipoManutencaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siscom_tipo_manutencao', function (Blueprint $table) {
            $table->increments('pk_tipo_manutencao');
            $table->string('ds_tipo_manutencao', 50);
            $table->timestamp('dt_cadastro_tipo_manutencao')->useCurrent();
            $table->timestamp('dt_atualizacao_tipo_manutencao')->nullable();
            $table->timestamp('dt_exclusao_tipo_manutencao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siscom_tipo_manutencao');
    }
}
