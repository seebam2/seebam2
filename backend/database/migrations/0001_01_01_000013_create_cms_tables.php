<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cms_posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->index();
            $table->text('resumo')->nullable();
            $table->longText('conteudo');
            $table->string('imagem_destaque')->nullable();
            $table->enum('tipo', ['noticia', 'evento'])->default('noticia');
            $table->enum('status', ['rascunho', 'publicado', 'agendado'])->default('rascunho');
            $table->datetime('data_publicacao')->nullable();
            $table->datetime('data_evento')->nullable();
            $table->string('local_evento')->nullable();
            $table->foreignId('autor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('cms_paginas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->index();
            $table->longText('conteudo');
            $table->integer('ordem')->default(0);
            $table->boolean('publicado')->default(false);
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('cms_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('descricao')->nullable();
            $table->string('arquivo');
            $table->string('tipo_arquivo')->nullable();
            $table->unsignedBigInteger('tamanho_bytes')->default(0);
            $table->boolean('publico')->default(false);
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('formularios', function (Blueprint $table) {
            $table->id('form_cod_formulario');
            $table->string('form_nome_formulario');
            $table->string('form_descr_formulario');
            $table->string('form_path_formulario');
            $table->datetime('form_dt_vigencia')->nullable();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formularios');
        Schema::dropIfExists('cms_documentos');
        Schema::dropIfExists('cms_paginas');
        Schema::dropIfExists('cms_posts');
    }
};
