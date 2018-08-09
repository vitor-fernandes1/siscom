<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiscomEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siscom_empresa', function (Blueprint $table) {
            $table->increments('pk_empresa');
            $table->string('nm_nome_empresa', 150);
            $table->string('ds_endereco_empresa', 100)->nullable();
            $table->string('ds_telefone_empresa', 50)->nullable();
            $table->string('ds_email_empresa', 150)->nullable();
            $table->string('ds_cnpj_empresa', 150)->nullable();
            $table->timestamp('dt_cadastro_empresa')->useCurrent();
            $table->timestamp('dt_atualizacao_empresa')->nullable();
            $table->timestamp('dt_exclusao_empresa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siscom_empresa');
    }
}
