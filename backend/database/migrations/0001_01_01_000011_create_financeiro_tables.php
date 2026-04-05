<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Normalized monthly dues (replaces the old column-per-month design)
        Schema::create('mensalidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asso_inscricao_associado');
            $table->integer('ano');
            $table->tinyInteger('mes');
            $table->decimal('valor', 10, 2)->default(0);
            $table->enum('status', ['pago', 'pendente', 'atrasado', 'isento'])->default('pendente');
            $table->date('data_pagamento')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->string('observacao')->nullable();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('asso_inscricao_associado')->references('asso_inscricao_associado')->on('associados')->cascadeOnDelete();
            $table->unique(['asso_inscricao_associado', 'ano', 'mes']);
            $table->index(['tenant_id', 'ano', 'mes']);
            $table->index('status');
        });

        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asso_inscricao_associado');
            $table->unsignedBigInteger('depe_iddependente')->nullable();
            $table->enum('tipo', ['mensalidade', 'servico', 'convenio', 'outro'])->default('mensalidade');
            $table->decimal('valor', 10, 2);
            $table->date('data_pagamento');
            $table->string('forma_pagamento')->nullable();
            $table->string('banco_agencia')->nullable();
            $table->string('comprovante')->nullable();
            $table->text('observacao')->nullable();
            $table->unsignedBigInteger('mensalidade_id')->nullable();
            $table->unsignedBigInteger('serv_cod_servico')->nullable();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('asso_inscricao_associado')->references('asso_inscricao_associado')->on('associados')->cascadeOnDelete();
            $table->foreign('depe_iddependente')->references('depe_iddependente')->on('dependentes')->nullOnDelete();
            $table->foreign('mensalidade_id')->references('id')->on('mensalidades')->nullOnDelete();
            $table->foreign('serv_cod_servico')->references('serv_cod_servico')->on('servicos')->nullOnDelete();

            $table->index(['tenant_id', 'data_pagamento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
        Schema::dropIfExists('mensalidades');
    }
};
