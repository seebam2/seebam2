<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('associados', function (Blueprint $table) {
            $table->id('asso_inscricao_associado');
            $table->string('asso_nome_associado');
            $table->date('asso_data_nasc');
            $table->char('asso_sexo_associado', 1);
            $table->unsignedBigInteger('esci_cod_estado_civil');
            $table->string('asso_naturalidade_associado')->nullable();
            $table->string('asso_nacionalidade_associado')->default('Brasileira');
            $table->string('asso_mae_associado')->nullable();
            $table->string('asso_pai_associado')->nullable();
            $table->unsignedBigInteger('esco_cod_escolaridade');
            $table->string('asso_email_associado')->nullable();
            $table->integer('asso_carteira_profissional')->nullable();
            $table->integer('asso_serie_associado')->nullable();
            $table->unsignedBigInteger('asso_estado_serie')->nullable();
            $table->string('asso_cpf_associado')->unique();
            $table->string('asso_rg_associado')->nullable();
            $table->unsignedBigInteger('asso_estado_rg')->nullable();
            $table->string('asso_pis_associado')->nullable();
            $table->string('asso_logradouro_endereco')->nullable();
            $table->string('asso_numero_endereco')->nullable();
            $table->string('asso_complemento_endereco')->nullable();
            $table->string('asso_bairro_endereco')->nullable();
            $table->string('asso_cep_endereco', 10)->nullable();
            $table->unsignedBigInteger('asso_cidade_endereco')->nullable();
            $table->unsignedBigInteger('asso_estado_endereco')->nullable();
            $table->bigInteger('asso_matric_sindicalizador')->nullable();
            $table->boolean('asso_ativo_associado')->default(true);
            $table->boolean('asso_sindicalista_associado')->default(false);
            $table->datetime('asso_data_inscricao');
            $table->string('asso_telefone_1_associado', 20)->nullable();
            $table->string('asso_telefone_2_associado', 20)->nullable();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();

            $table->foreign('esci_cod_estado_civil')->references('esci_cod_estado_civil')->on('estados_civis');
            $table->foreign('esco_cod_escolaridade')->references('esco_cod_escolaridade')->on('escolaridades');
            $table->foreign('asso_estado_serie')->references('esta_cod_estado')->on('estados');
            $table->foreign('asso_estado_rg')->references('esta_cod_estado')->on('estados');
            $table->foreign('asso_cidade_endereco')->references('muni_cod_municipio')->on('municipios');
            $table->foreign('asso_estado_endereco')->references('esta_cod_estado')->on('estados');

            $table->index('tenant_id');
            $table->index('asso_ativo_associado');
        });
    }

    public function down(): void { Schema::dropIfExists('associados'); }
};
