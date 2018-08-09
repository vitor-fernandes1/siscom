<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiscomEquipamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siscom_equipamento', function (Blueprint $table) {
            $table->increments('pk_equipamento');
            $table->string('ds_nome_equipamento', 150);
            $table->date('dt_compra_equipamento', 150);
            $table->string('ds_descricao_equipamento', 150);
            $table->decimal('ds_valor_equipamento', 10, 2)->unsigned();
            $table->unsignedInteger('fk_pk_tipo_equipamento');
            $table->foreign('fk_pk_tipo_equipamento','constraint_fk_pk_tipo_equipamento')
                ->references('pk_tipo_equipamento')
                ->on('siscom_tipo_equipamento')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamp('dt_cadastro_equipamento')->useCurrent();
            $table->timestamp('dt_atualizacao_equipamento')->nullable();
            $table->timestamp('dt_exclusao_equipamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siscom_equipamento');
    }
}
