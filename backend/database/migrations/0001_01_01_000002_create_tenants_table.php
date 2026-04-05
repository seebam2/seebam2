<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->string('cnpj', 18)->unique()->nullable();
            $table->string('email')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('endereco')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('logo')->nullable();
            $table->string('cor_primaria', 7)->default('#2563eb');
            $table->string('cor_secundaria', 7)->default('#7c3aed');
            $table->foreignId('plano_id')->constrained('planos');
            $table->date('plano_validade')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tenants'); }
};
