<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conveniados', function (Blueprint $table) {
            $table->id('conv_cod_conveniado');
            $table->unsignedBigInteger('espe_cod_especialidade');
            $table->string('conv_nome_conveniado');
            $table->string('conv_horario_funcionamento')->nullable();
            $table->string('conv_endereco_conveniado')->nullable();
            $table->string('conv_telefone_1_conveniado', 20)->nullable();
            $table->string('conv_telefone_2_conveniado', 20)->nullable();
            $table->text('conv_observacao_conveniado')->nullable();
            $table->datetime('conv_dt_vigencia')->nullable();
            $table->boolean('conv_ativo')->default(true);
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('espe_cod_especialidade')->references('espe_cod_especialidade')->on('especialidades');
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id('serv_cod_servico');
            $table->unsignedBigInteger('tser_tipo_servico');
            $table->unsignedBigInteger('asso_inscricao_associado');
            $table->unsignedBigInteger('sise_situacao_servico');
            $table->unsignedBigInteger('depe_iddependente')->nullable();
            $table->unsignedBigInteger('conv_cod_conveniado')->nullable();
            $table->string('serv_observacoes_servico')->nullable();
            $table->datetime('serv_data_criacao')->nullable();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('tser_tipo_servico')->references('tser_tipo_servico')->on('tipo_servicos');
            $table->foreign('asso_inscricao_associado')->references('asso_inscricao_associado')->on('associados')->cascadeOnDelete();
            $table->foreign('sise_situacao_servico')->references('sise_situacao_servico')->on('situacao_servicos');
            $table->foreign('depe_iddependente')->references('depe_iddependente')->on('dependentes')->nullOnDelete();
            $table->foreign('conv_cod_conveniado')->references('conv_cod_conveniado')->on('conveniados')->nullOnDelete();
        });

        Schema::create('associado_conveniado', function (Blueprint $table) {
            $table->id('asco_id_asso_conveniado');
            $table->unsignedBigInteger('asso_inscricao_associado');
            $table->unsignedBigInteger('conv_cod_conveniado');
            $table->unsignedBigInteger('depe_iddependente')->nullable();
            $table->unsignedBigInteger('serv_cod_servico')->nullable();
            $table->timestamps();

            $table->foreign('asso_inscricao_associado')->references('asso_inscricao_associado')->on('associados')->cascadeOnDelete();
            $table->foreign('conv_cod_conveniado')->references('conv_cod_conveniado')->on('conveniados')->cascadeOnDelete();
            $table->foreign('depe_iddependente')->references('depe_iddependente')->on('dependentes')->nullOnDelete();
            $table->foreign('serv_cod_servico')->references('serv_cod_servico')->on('servicos')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('associado_conveniado');
        Schema::dropIfExists('servicos');
        Schema::dropIfExists('conveniados');
    }
};
