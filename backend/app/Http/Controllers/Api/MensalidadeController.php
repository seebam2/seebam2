<?php
namespace App\Http\Controllers\Api;

use App\Models\Mensalidade;
use Illuminate\Http\Request;

class MensalidadeController extends BaseApiController
{
    public function index(Request $request)
    {
        $q = Mensalidade::tenantScope($this->tenantId($request))->with('associado');
        if ($request->filled('associado')) $q->where('asso_inscricao_associado', $request->associado);
        if ($request->filled('ano')) $q->where('ano', $request->ano);
        if ($request->filled('status')) $q->where('status', $request->status);
        return $this->success($q->orderBy('ano')->orderBy('mes')->paginate($request->per_page ?? 100));
    }

    public function gradeAnual(Request $request)
    {
        $request->validate(['associado' => 'required|integer', 'ano' => 'required|integer']);
        $mensalidades = Mensalidade::tenantScope($this->tenantId($request))
            ->where('asso_inscricao_associado', $request->associado)
            ->where('ano', $request->ano)->orderBy('mes')->get();
        return $this->success($mensalidades);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asso_inscricao_associado' => 'required|exists:associados,asso_inscricao_associado',
            'ano' => 'required|integer', 'mes' => 'required|integer|between:1,12',
            'valor' => 'required|numeric|min:0', 'status' => 'sometimes|in:pago,pendente,atrasado,isento',
            'data_pagamento' => 'nullable|date', 'data_vencimento' => 'nullable|date',
            'observacao' => 'nullable|string',
        ]);
        $data['tenant_id'] = $this->tenantId($request);
        return $this->created(Mensalidade::create($data));
    }

    public function gerarAnual(Request $request)
    {
        $request->validate([
            'asso_inscricao_associado' => 'required|exists:associados,asso_inscricao_associado',
            'ano' => 'required|integer', 'valor' => 'required|numeric|min:0',
        ]);
        $tenantId = $this->tenantId($request);
        $criadas = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $criadas[] = Mensalidade::firstOrCreate(
                ['asso_inscricao_associado' => $request->asso_inscricao_associado, 'ano' => $request->ano, 'mes' => $mes, 'tenant_id' => $tenantId],
                ['valor' => $request->valor, 'status' => 'pendente', 'data_vencimento' => "{$request->ano}-" . str_pad($mes, 2, '0', STR_PAD_LEFT) . "-10"]
            );
        }
        return $this->created($criadas, 'Mensalidades geradas');
    }

    public function baixar(Request $request, $id)
    {
        $m = Mensalidade::tenantScope($this->tenantId($request))->findOrFail($id);
        $m->update(['status' => 'pago', 'data_pagamento' => $request->data_pagamento ?? now()]);
        return $this->success($m->fresh(), 'Baixa realizada');
    }

    public function update(Request $request, $id)
    {
        $m = Mensalidade::tenantScope($this->tenantId($request))->findOrFail($id);
        $m->update($request->validate([
            'valor' => 'sometimes|numeric', 'status' => 'sometimes|in:pago,pendente,atrasado,isento',
            'data_pagamento' => 'nullable|date', 'observacao' => 'nullable|string',
        ]));
        return $this->success($m->fresh());
    }

    public function destroy(Request $request, $id)
    {
        Mensalidade::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }
}
