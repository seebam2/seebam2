<?php
namespace App\Http\Controllers\Api;

use App\Models\Pagamento;
use Illuminate\Http\Request;

class PagamentoController extends BaseApiController
{
    public function index(Request $request)
    {
        $q = Pagamento::tenantScope($this->tenantId($request))->with(['associado', 'dependente']);
        if ($request->filled('associado')) $q->where('asso_inscricao_associado', $request->associado);
        if ($request->filled('tipo')) $q->where('tipo', $request->tipo);
        if ($request->filled('de')) $q->whereDate('data_pagamento', '>=', $request->de);
        if ($request->filled('ate')) $q->whereDate('data_pagamento', '<=', $request->ate);
        return $this->success($q->orderByDesc('data_pagamento')->paginate($request->per_page ?? 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asso_inscricao_associado' => 'required|exists:associados,asso_inscricao_associado',
            'depe_iddependente' => 'nullable|exists:dependentes,depe_iddependente',
            'tipo' => 'required|in:mensalidade,servico,convenio,outro',
            'valor' => 'required|numeric|min:0', 'data_pagamento' => 'required|date',
            'forma_pagamento' => 'nullable|string', 'banco_agencia' => 'nullable|string',
            'observacao' => 'nullable|string', 'mensalidade_id' => 'nullable|exists:mensalidades,id',
            'serv_cod_servico' => 'nullable|exists:servicos,serv_cod_servico',
        ]);
        $data['tenant_id'] = $this->tenantId($request);
        return $this->created(Pagamento::create($data)->load('associado'));
    }

    public function show(Request $request, $id)
    {
        return $this->success(Pagamento::tenantScope($this->tenantId($request))->with(['associado', 'dependente', 'mensalidade', 'servico'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $p = Pagamento::tenantScope($this->tenantId($request))->findOrFail($id);
        $p->update($request->validate([
            'tipo' => 'sometimes|in:mensalidade,servico,convenio,outro',
            'valor' => 'sometimes|numeric', 'data_pagamento' => 'sometimes|date',
            'forma_pagamento' => 'nullable|string', 'observacao' => 'nullable|string',
        ]));
        return $this->success($p->fresh());
    }

    public function destroy(Request $request, $id)
    {
        Pagamento::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }
}
