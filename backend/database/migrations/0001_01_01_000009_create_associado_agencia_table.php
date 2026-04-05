<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('associado_agencia', function (Blueprint $table) {
            $table->id('asag_id_associado_agencia');
            $table->unsignedBigInteger('asso_inscricao_associado');
            $table->unsignedBigInteger('agnc_cod_agencia');
            $table->unsignedInteger('asag_matricula')->nullable();
            $table->unsignedBigInteger('carg_cod_cargo');
            $table->datetime('asag_dt_admissao')->nullable();
            $table->datetime('asag_dt_demissao')->nullable();
            $table->unsignedBigInteger('sias_cod_situacao_associado');
            $table->text('asag_comentario')->nullable();
            $table->timestamps();

            $table->foreign('asso_inscricao_associado')->references('asso_inscricao_associado')->on('associados')->cascadeOnDelete();
            $table->foreign('agnc_cod_agencia')->references('agnc_cod_agencia')->on('agencias');
            $table->foreign('carg_cod_cargo')->references('carg_cod_cargo')->on('cargos');
            $table->foreign('sias_cod_situacao_associado')->references('sias_cod_situacao_associado')->on('situacao_associado');
        });
    }
    public function down(): void { Schema::dropIfExists('associado_agencia'); }
};
