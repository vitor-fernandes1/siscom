<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiscomAvaliacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siscom_avaliacao', function (Blueprint $table) {
            $table->increments('pk_avaliacao');
            $table->string('ds_avaliacao', 50);
            $table->timestamp('dt_cadastro_avaliacao')->useCurrent();
            $table->timestamp('dt_atualizacao_avaliacao')->nullable();
            $table->timestamp('dt_exclusao_avaliacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siscom_avaliacao');
    }
}
