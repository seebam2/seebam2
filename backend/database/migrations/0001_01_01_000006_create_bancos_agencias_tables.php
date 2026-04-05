<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bancos', function (Blueprint $table) {
            $table->id('banc_cod_banco');
            $table->string('banc_descricao_banco');
            $table->string('banc_situacao_banco')->default('Ativo');
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('agencias', function (Blueprint $table) {
            $table->id('agnc_cod_agencia');
            $table->string('agnc_descr_agencia');
            $table->string('agnc_numero_agencia');
            $table->string('agnc_cod_municipio');
            $table->string('agnc_endereco_agencia')->nullable();
            $table->unsignedBigInteger('banc_cod_banco');
            $table->string('agnc_observacao_agencia')->nullable();
            $table->string('agnc_situacao_agencia')->default('Ativa');
            $table->string('agnc_telefone_1_agencia', 20)->nullable();
            $table->string('agnc_telefone_2_agencia', 20)->nullable();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();
            $table->foreign('banc_cod_banco')->references('banc_cod_banco')->on('bancos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agencias');
        Schema::dropIfExists('bancos');
    }
};
