<?php
namespace App\Http\Controllers\Api;

use App\Models\Agencia;
use Illuminate\Http\Request;

class AgenciaController extends BaseApiController
{
    public function index(Request $request)
    {
        $q = Agencia::tenantScope($this->tenantId($request))->with('banco');
        if ($request->filled('banco')) $q->where('banc_cod_banco', $request->banco);
        if ($request->filled('busca')) $q->where('agnc_descr_agencia', 'like', "%{$request->busca}%");
        return $this->success($q->orderBy('agnc_descr_agencia')->paginate($request->per_page ?? 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agnc_descr_agencia' => 'required|string', 'agnc_numero_agencia' => 'required|string',
            'agnc_cod_municipio' => 'required|string', 'banc_cod_banco' => 'required|exists:bancos,banc_cod_banco',
            'agnc_endereco_agencia' => 'nullable|string', 'agnc_observacao_agencia' => 'nullable|string',
            'agnc_situacao_agencia' => 'sometimes|string', 'agnc_telefone_1_agencia' => 'nullable|string',
            'agnc_telefone_2_agencia' => 'nullable|string',
        ]);
        $data['tenant_id'] = $this->tenantId($request);
        return $this->created(Agencia::create($data)->load('banco'));
    }

    public function show(Request $request, $id)
    {
        return $this->success(Agencia::tenantScope($this->tenantId($request))->with(['banco', 'historicoProfissional.associado'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $ag = Agencia::tenantScope($this->tenantId($request))->findOrFail($id);
        $ag->update($request->validate([
            'agnc_descr_agencia' => 'sometimes|string', 'agnc_numero_agencia' => 'sometimes|string',
            'agnc_cod_municipio' => 'sometimes|string', 'banc_cod_banco' => 'sometimes|exists:bancos,banc_cod_banco',
            'agnc_endereco_agencia' => 'nullable|string', 'agnc_observacao_agencia' => 'nullable|string',
            'agnc_situacao_agencia' => 'sometimes|string', 'agnc_telefone_1_agencia' => 'nullable|string',
            'agnc_telefone_2_agencia' => 'nullable|string',
        ]));
        return $this->success($ag->fresh());
    }

    public function destroy(Request $request, $id)
    {
        Agencia::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }
}
