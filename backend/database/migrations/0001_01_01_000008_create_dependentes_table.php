<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dependentes', function (Blueprint $table) {
            $table->id('depe_iddependente');
            $table->unsignedBigInteger('depe_inscricao');
            $table->string('depe_nome');
            $table->string('depe_sexo', 1);
            $table->date('depe_datanascimento');
            $table->unsignedInteger('pare_cod_parentesco');
            $table->datetime('depe_datainscricao');
            $table->date('depe_datavencimento')->nullable();
            $table->boolean('depe_badicional')->default(false);
            $table->boolean('depe_ativo')->default(true);
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('depe_inscricao')->references('asso_inscricao_associado')->on('associados')->cascadeOnDelete();
            $table->foreign('pare_cod_parentesco')->references('pare_cod_parentesco')->on('parentescos');

            $table->index('tenant_id');
        });
    }
    public function down(): void { Schema::dropIfExists('dependentes'); }
};
