<?php
namespace App\Http\Controllers\Api;

use App\Models\Servico;
use App\Models\ServicoElegibilidade;
use App\Models\Conveniado;
use Illuminate\Http\Request;

class ServicoController extends BaseApiController
{
    public function index(Request $request)
    {
        $q = Servico::tenantScope($this->tenantId($request))->with(['tipoServico', 'associado', 'situacao', 'conveniado']);
        if ($request->filled('associado')) $q->where('asso_inscricao_associado', $request->associado);
        if ($request->filled('tipo')) $q->where('tser_tipo_servico', $request->tipo);
        return $this->success($q->orderByDesc('created_at')->paginate($request->per_page ?? 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tser_tipo_servico' => 'required|exists:tipo_servicos,tser_tipo_servico',
            'asso_inscricao_associado' => 'required|exists:associados,asso_inscricao_associado',
            'sise_situacao_servico' => 'required|exists:situacao_servicos,sise_situacao_servico',
            'depe_iddependente' => 'nullable|exists:dependentes,depe_iddependente',
            'conv_cod_conveniado' => 'nullable|exists:conveniados,conv_cod_conveniado',
            'serv_observacoes_servico' => 'nullable|string',
        ]);
        $data['tenant_id'] = $this->tenantId($request);
        $data['serv_data_criacao'] = now();
        return $this->created(Servico::create($data)->load(['tipoServico', 'associado', 'situacao']));
    }

    public function show(Request $request, $id)
    {
        return $this->success(Servico::tenantScope($this->tenantId($request))->with(['tipoServico', 'associado', 'situacao', 'dependente', 'conveniado'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $s = Servico::tenantScope($this->tenantId($request))->findOrFail($id);
        $s->update($request->validate([
            'sise_situacao_servico' => 'sometimes|exists:situacao_servicos,sise_situacao_servico',
            'serv_observacoes_servico' => 'nullable|string',
        ]));
        return $this->success($s->fresh());
    }

    public function destroy(Request $request, $id)
    {
        Servico::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }

    public function verificarElegibilidade(Request $request)
    {
        $request->validate([
            'tser_tipo_servico' => 'required', 'pare_cod_parentesco' => 'nullable|integer',
        ]);
        $regra = ServicoElegibilidade::tenantScope($this->tenantId($request))
            ->where('tser_tipo_servico', $request->tser_tipo_servico)
            ->where('pare_cod_parentesco', $request->pare_cod_parentesco)
            ->first();

        if (!$regra) {
            return $this->success(['elegivel' => false, 'mensagem' => 'Sem regra de elegibilidade definida']);
        }

        return $this->success([
            'elegivel' => $regra->elegivel,
            'tipo_cobranca' => $regra->tipo_cobranca,
            'valor' => $regra->valor,
            'percentual_desconto' => $regra->percentual_desconto,
        ]);
    }
}
