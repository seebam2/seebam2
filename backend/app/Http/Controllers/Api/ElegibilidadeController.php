<?php
namespace App\Http\Controllers\Api;

use App\Models\ServicoElegibilidade;
use Illuminate\Http\Request;

class ElegibilidadeController extends BaseApiController
{
    public function index(Request $request)
    {
        $q = ServicoElegibilidade::tenantScope($this->tenantId($request))->with(['tipoServico', 'parentesco']);
        if ($request->filled('tipo_servico')) $q->where('tser_tipo_servico', $request->tipo_servico);
        return $this->success($q->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tser_tipo_servico' => 'required|exists:tipo_servicos,tser_tipo_servico',
            'pare_cod_parentesco' => 'nullable|exists:parentescos,pare_cod_parentesco',
            'elegivel' => 'boolean',
            'tipo_cobranca' => 'required|in:gratuito,valor_fixo,percentual_desconto',
            'valor' => 'nullable|numeric', 'percentual_desconto' => 'nullable|numeric|between:0,100',
        ]);
        $data['tenant_id'] = $this->tenantId($request);
        return $this->created(ServicoElegibilidade::create($data)->load(['tipoServico', 'parentesco']));
    }

    public function update(Request $request, $id)
    {
        $e = ServicoElegibilidade::tenantScope($this->tenantId($request))->findOrFail($id);
        $e->update($request->validate([
            'elegivel' => 'boolean',
            'tipo_cobranca' => 'sometimes|in:gratuito,valor_fixo,percentual_desconto',
            'valor' => 'nullable|numeric', 'percentual_desconto' => 'nullable|numeric|between:0,100',
        ]));
        return $this->success($e->fresh());
    }

    public function destroy(Request $request, $id)
    {
        ServicoElegibilidade::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }
}
