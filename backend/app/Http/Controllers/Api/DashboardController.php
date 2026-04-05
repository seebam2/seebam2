<?php
namespace App\Http\Controllers\Api;

use App\Models\Associado;
use App\Models\Mensalidade;
use App\Models\Pagamento;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseApiController
{
    public function index(Request $request)
    {
        $tenantId = $this->tenantId($request);

        $totalAssociados = Associado::tenantScope($tenantId)->count();
        $associadosAtivos = Associado::tenantScope($tenantId)->ativos()->count();
        $associadosInativos = $totalAssociados - $associadosAtivos;

        $mesAtual = now()->month;
        $anoAtual = now()->year;

        $receitaMensal = Pagamento::tenantScope($tenantId)
            ->whereMonth('data_pagamento', $mesAtual)->whereYear('data_pagamento', $anoAtual)
            ->sum('valor');

        $inadimplentes = Mensalidade::tenantScope($tenantId)
            ->where('status', 'atrasado')->distinct('asso_inscricao_associado')->count('asso_inscricao_associado');

        $atendimentosMes = Servico::tenantScope($tenantId)
            ->whereMonth('created_at', $mesAtual)->whereYear('created_at', $anoAtual)->count();

        $receitaMeses = Pagamento::tenantScope($tenantId)
            ->whereYear('data_pagamento', $anoAtual)
            ->select(DB::raw('MONTH(data_pagamento) as mes'), DB::raw('SUM(valor) as total'))
            ->groupBy(DB::raw('MONTH(data_pagamento)'))->orderBy('mes')->get();

        $servicosPorTipo = Servico::tenantScope($tenantId)
            ->join('tipo_servicos', 'servicos.tser_tipo_servico', '=', 'tipo_servicos.tser_tipo_servico')
            ->select('tipo_servicos.tser_descr_tipo_servico as nome', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo_servicos.tser_descr_tipo_servico')->get();

        $atividadeRecente = Associado::tenantScope($tenantId)->orderByDesc('created_at')->limit(5)
            ->get(['asso_inscricao_associado', 'asso_nome_associado', 'created_at']);

        $topInadimplentes = Mensalidade::tenantScope($tenantId)
            ->where('status', 'atrasado')
            ->join('associados', 'mensalidades.asso_inscricao_associado', '=', 'associados.asso_inscricao_associado')
            ->select('associados.asso_nome_associado as nome', DB::raw('COUNT(*) as meses'), DB::raw('SUM(mensalidades.valor) as total'))
            ->groupBy('associados.asso_inscricao_associado', 'associados.asso_nome_associado')
            ->orderByDesc('meses')->limit(5)->get();

        return $this->success([
            'kpis' => [
                'total_associados' => $totalAssociados,
                'associados_ativos' => $associadosAtivos,
                'associados_inativos' => $associadosInativos,
                'receita_mensal' => (float) $receitaMensal,
                'inadimplentes' => $inadimplentes,
                'atendimentos_mes' => $atendimentosMes,
            ],
            'receita_meses' => $receitaMeses,
            'servicos_por_tipo' => $servicosPorTipo,
            'atividade_recente' => $atividadeRecente,
            'top_inadimplentes' => $topInadimplentes,
        ]);
    }
}
