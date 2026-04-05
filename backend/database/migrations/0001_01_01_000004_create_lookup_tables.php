<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id('esta_cod_estado');
            $table->string('esta_descr_estado');
            $table->string('esta_sigla', 2)->nullable();
            $table->timestamps();
        });

        Schema::create('municipios', function (Blueprint $table) {
            $table->id('muni_cod_municipio');
            $table->unsignedBigInteger('esta_cod_estado');
            $table->string('muni_descr_municipio');
            $table->timestamps();
            $table->foreign('esta_cod_estado')->references('esta_cod_estado')->on('estados');
        });

        Schema::create('estados_civis', function (Blueprint $table) {
            $table->id('esci_cod_estado_civil');
            $table->string('esci_descr_estado_civil');
            $table->timestamps();
        });

        Schema::create('escolaridades', function (Blueprint $table) {
            $table->id('esco_cod_escolaridade');
            $table->string('esco_descr_escolaridade');
            $table->timestamps();
        });

        Schema::create('parentescos', function (Blueprint $table) {
            $table->unsignedInteger('pare_cod_parentesco')->autoIncrement();
            $table->string('pare_descricao_parentesco');
            $table->timestamps();
        });

        Schema::create('cargos', function (Blueprint $table) {
            $table->id('carg_cod_cargo');
            $table->string('carg_descr_cargo');
            $table->date('carg_dt_vigencia')->nullable();
            $table->timestamps();
        });

        Schema::create('especialidades', function (Blueprint $table) {
            $table->id('espe_cod_especialidade');
            $table->string('espe_descr_especialidade');
            $table->date('espe_dt_vigencia')->nullable();
            $table->timestamps();
        });

        Schema::create('situacao_associado', function (Blueprint $table) {
            $table->id('sias_cod_situacao_associado');
            $table->string('sias_descr_situacao_associado');
            $table->date('sias_dt_vigencia')->nullable();
            $table->timestamps();
        });

        Schema::create('tipo_servicos', function (Blueprint $table) {
            $table->id('tser_tipo_servico');
            $table->string('tser_descr_tipo_servico');
            $table->date('tser_vigencia_tipo_servico')->nullable();
            $table->timestamps();
        });

        Schema::create('situacao_servicos', function (Blueprint $table) {
            $table->id('sise_situacao_servico');
            $table->string('sise_descr_situacao_servico');
            $table->date('sise_vigencia_situacao_servico')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('situacao_servicos');
        Schema::dropIfExists('tipo_servicos');
        Schema::dropIfExists('situacao_associado');
        Schema::dropIfExists('especialidades');
        Schema::dropIfExists('cargos');
        Schema::dropIfExists('parentescos');
        Schema::dropIfExists('escolaridades');
        Schema::dropIfExists('estados_civis');
        Schema::dropIfExists('municipios');
        Schema::dropIfExists('estados');
    }
};
