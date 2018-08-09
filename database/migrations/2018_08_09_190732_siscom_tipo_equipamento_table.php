<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiscomTipoEquipamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siscom_tipo_equipamento', function (Blueprint $table) {
            $table->increments('pk_tipo_equipamento');
            $table->string('ds_tipo_equipamento', 50);
            $table->timestamp('dt_cadastro_tipo_equipamento')->useCurrent();
            $table->timestamp('dt_atualizacao_tipo_equipamento')->nullable();
            $table->timestamp('dt_exclusao_tipo_equipamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siscom_tipo_equipamento');
    }
}
