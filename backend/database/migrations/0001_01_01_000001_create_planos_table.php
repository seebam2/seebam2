<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('valor_mensal', 10, 2)->default(0);
            $table->integer('limite_usuarios')->default(5);
            $table->integer('limite_associados')->default(500);
            $table->boolean('cms_habilitado')->default(false);
            $table->boolean('relatorios_avancados')->default(false);
            $table->boolean('portal_associado')->default(false);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('planos'); }
};
