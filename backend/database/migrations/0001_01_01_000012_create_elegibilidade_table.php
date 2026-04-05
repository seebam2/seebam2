<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('servico_elegibilidade', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tser_tipo_servico');
            $table->unsignedInteger('pare_cod_parentesco')->nullable()->comment('NULL = titular');
            $table->boolean('elegivel')->default(true);
            $table->enum('tipo_cobranca', ['gratuito', 'valor_fixo', 'percentual_desconto'])->default('gratuito');
            $table->decimal('valor', 10, 2)->nullable();
            $table->decimal('percentual_desconto', 5, 2)->nullable();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('tser_tipo_servico')->references('tser_tipo_servico')->on('tipo_servicos');
            $table->foreign('pare_cod_parentesco')->references('pare_cod_parentesco')->on('parentescos');

            $table->unique(['tser_tipo_servico', 'pare_cod_parentesco', 'tenant_id'], 'elegibilidade_unique');
        });
    }
    public function down(): void { Schema::dropIfExists('servico_elegibilidade'); }
};
