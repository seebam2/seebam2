<?php
namespace App\Http\Controllers\Api;

use App\Models\Associado;
use App\Models\Mensalidade;
use App\Models\Pagamento;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends BaseApiController
{
    public function financeiro(Request $request)
    {
        $tenantId = $this->tenantId($request);
        $ano = $request->ano ?? now()->year;

        $receitaPorMes = Pagamento::tenantScope($tenantId)->whereYear('data_pagamento', $ano)
            ->select(DB::raw('MONTH(data_pagamento) as mes'), DB::raw('SUM(valor) as total'), 'tipo')
            ->groupBy(DB::raw('MONTH(data_pagamento)'), 'tipo')->orderBy('mes')->get();

        $totalAno = Pagamento::tenantScope($tenantId)->whereYear('data_pagamento', $ano)->sum('valor');

        return $this->success(['ano' => $ano, 'receita_por_mes' => $receitaPorMes, 'total_ano' => (float) $totalAno]);
    }

    public function inadimplencia(Request $request)
    {
        $tenantId = $this->tenantId($request);

        $inadimplentes = Mensalidade::tenantScope($tenantId)->where('status', 'atrasado')
            ->join('associados', 'mensalidades.asso_inscricao_associado', '=', 'associados.asso_inscricao_associado')
            ->select('associados.asso_inscricao_associado', 'associados.asso_nome_associado', 'associados.asso_cpf_associado',
                DB::raw('COUNT(*) as meses_atrasados'), DB::raw('SUM(mensalidades.valor) as valor_total'))
            ->groupBy('associados.asso_inscricao_associado', 'associados.asso_nome_associado', 'associados.asso_cpf_associado')
            ->orderByDesc('meses_atrasados')->get();

        return $this->success(['total_inadimplentes' => $inadimplentes->count(), 'valor_total' => $inadimplentes->sum('valor_total'), 'detalhes' => $inadimplentes]);
    }

    public function servicos(Request $request)
    {
        $tenantId = $this->tenantId($request);
        $ano = $request->ano ?? now()->year;

        $porTipo = Servico::tenantScope($tenantId)->whereYear('created_at', $ano)
            ->join('tipo_servicos', 'servicos.tser_tipo_servico', '=', 'tipo_servicos.tser_tipo_servico')
            ->select('tipo_servicos.tser_descr_tipo_servico as servico', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo_servicos.tser_descr_tipo_servico')->orderByDesc('total')->get();

        $porMes = Servico::tenantScope($tenantId)->whereYear('created_at', $ano)
            ->select(DB::raw('MONTH(created_at) as mes'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))->orderBy('mes')->get();

        return $this->success(['ano' => $ano, 'por_tipo' => $porTipo, 'por_mes' => $porMes]);
    }

    public function associados(Request $request)
    {
        $tenantId = $this->tenantId($request);

        $total = Associado::tenantScope($tenantId)->count();
        $ativos = Associado::tenantScope($tenantId)->ativos()->count();
        $inativos = $total - $ativos;
        $sindicalistas = Associado::tenantScope($tenantId)->where('asso_sindicalista_associado', true)->count();

        $porMes = Associado::tenantScope($tenantId)->whereYear('asso_data_inscricao', now()->year)
            ->select(DB::raw('MONTH(asso_data_inscricao) as mes'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(asso_data_inscricao)'))->orderBy('mes')->get();

        return $this->success(['total' => $total, 'ativos' => $ativos, 'inativos' => $inativos, 'sindicalistas' => $sindicalistas, 'novos_por_mes' => $porMes]);
    }
}
