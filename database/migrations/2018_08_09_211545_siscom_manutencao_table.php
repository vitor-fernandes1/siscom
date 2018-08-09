<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiscomManutencaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siscom_manutencao', function (Blueprint $table) {
            $table->increments('pk_manutencao');
            $table->string('ds_descricao_manutencao', 300)->nullable();
            $table->decimal('vl_valor_manutencao', 10, 2)->unsigned()->default(0);
            $table->unsignedInteger('fk_pk_tipo_manutencao');
            $table->foreign('fk_pk_tipo_manutencao','constraint_fk_pk_tipo_manutencao')
                ->references('pk_tipo_manutencao')
                ->on('siscom_tipo_manutencao')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('fk_pk_prioridade');
            $table->foreign('fk_pk_prioridade','constraint_fk_pk_prioridade')
                ->references('pk_prioridade')
                ->on('siscom_prioridade')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('fk_pk_situacao');
            $table->foreign('fk_pk_situacao','constraint_fk_pk_situacao')
                    ->references('pk_situacao')
                    ->on('siscom_situacao')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->unsignedInteger('fk_pk_avaliacao');
            $table->foreign('fk_pk_avaliacao','constraint_fk_pk_avaliacao')
                    ->references('pk_avaliacao')
                    ->on('siscom_avaliacao')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->unsignedInteger('fk_pk_empresa');
            $table->foreign('fk_pk_empresa','constraint_fk_pk_empresa')
                    ->references('pk_empresa')
                    ->on('siscom_empresa')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->unsignedInteger('fk_pk_equipamento');
            $table->foreign('fk_pk_equipamento','constraint_fk_pk_equipamento')
                    ->references('pk_equipamento')
                    ->on('siscom_equipamento')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamp('dt_cadastro_manutencao')->useCurrent();
            $table->timestamp('dt_atualizacao_manutencao')->nullable();
            $table->timestamp('dt_exclusao_manutencao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siscom_manutencao');
    }
}
