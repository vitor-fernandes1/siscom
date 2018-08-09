<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiscomSituacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siscom_situacao', function (Blueprint $table) {
            $table->increments('pk_situacao');
            $table->char('ds_tipo_situacao', 30);
            $table->timestamp('dt_cadastro_situacao')->useCurrent();
            $table->timestamp('dt_atualizacao_situacao')->nullable();
            $table->timestamp('dt_exclusao_situacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siscom_situacao');
    }
}
