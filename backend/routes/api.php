<?php

use App\Http\Controllers\Api\{
    AuthController, DashboardController, AssociadoController, DependenteController,
    BancoController, AgenciaController, HistoricoProfissionalController,
    MensalidadeController, PagamentoController, ServicoController, ConveniadoController,
    ElegibilidadeController, CmsPostController, LookupController, TenantController,
    RelatorioController
};
use Illuminate\Support\Facades\Route;

// Public
Route::post('/login', [AuthController::class, 'login']);

// Lookup (public for forms)
Route::prefix('lookup')->group(function () {
    Route::get('/estados', [LookupController::class, 'estados']);
    Route::get('/municipios', [LookupController::class, 'municipios']);
    Route::get('/estados-civis', [LookupController::class, 'estadosCivis']);
    Route::get('/escolaridades', [LookupController::class, 'escolaridades']);
    Route::get('/parentescos', [LookupController::class, 'parentescos']);
    Route::get('/cargos', [LookupController::class, 'cargos']);
    Route::get('/especialidades', [LookupController::class, 'especialidades']);
    Route::get('/situacoes-associado', [LookupController::class, 'situacoesAssociado']);
    Route::get('/tipos-servico', [LookupController::class, 'tiposServico']);
    Route::get('/situacoes-servico', [LookupController::class, 'situacoesServico']);
});

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Associados
    Route::apiResource('associados', AssociadoController::class);

    // Dependentes
    Route::apiResource('dependentes', DependenteController::class);

    // Bancos
    Route::apiResource('bancos', BancoController::class);

    // Agências
    Route::apiResource('agencias', AgenciaController::class);

    // Histórico Profissional
    Route::apiResource('historico-profissional', HistoricoProfissionalController::class);

    // Mensalidades
    Route::get('/mensalidades/grade', [MensalidadeController::class, 'gradeAnual']);
    Route::post('/mensalidades/gerar-anual', [MensalidadeController::class, 'gerarAnual']);
    Route::post('/mensalidades/{id}/baixar', [MensalidadeController::class, 'baixar']);
    Route::apiResource('mensalidades', MensalidadeController::class);

    // Pagamentos
    Route::apiResource('pagamentos', PagamentoController::class);

    // Serviços
    Route::post('/servicos/verificar-elegibilidade', [ServicoController::class, 'verificarElegibilidade']);
    Route::apiResource('servicos', ServicoController::class);

    // Conveniados
    Route::apiResource('conveniados', ConveniadoController::class);

    // Elegibilidade
    Route::apiResource('elegibilidade', ElegibilidadeController::class)->except(['show']);

    // CMS
    Route::apiResource('cms/posts', CmsPostController::class);

    // Relatórios
    Route::prefix('relatorios')->group(function () {
        Route::get('/financeiro', [RelatorioController::class, 'financeiro']);
        Route::get('/inadimplencia', [RelatorioController::class, 'inadimplencia']);
        Route::get('/servicos', [RelatorioController::class, 'servicos']);
        Route::get('/associados', [RelatorioController::class, 'associados']);
    });

    // Super Admin - Tenants
    Route::middleware('can:superadmin')->group(function () {
        Route::apiResource('tenants', TenantController::class);
        Route::get('/planos', [TenantController::class, 'planos']);
    });
});
