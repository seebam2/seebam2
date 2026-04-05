<?php
namespace App\Http\Controllers\Api;

use App\Models\Dependente;
use Illuminate\Http\Request;

class DependenteController extends BaseApiController
{
    public function index(Request $request)
    {
        $query = Dependente::tenantScope($this->tenantId($request))->with(['associado', 'parentesco']);
        if ($request->filled('associado')) $query->where('depe_inscricao', $request->associado);
        if ($request->filled('parentesco')) $query->where('pare_cod_parentesco', $request->parentesco);
        return $this->success($query->orderBy('depe_nome')->paginate($request->per_page ?? 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'depe_inscricao' => 'required|exists:associados,asso_inscricao_associado',
            'depe_nome' => 'required|string',
            'depe_sexo' => 'required|string|max:1',
            'depe_datanascimento' => 'required|date',
            'pare_cod_parentesco' => 'required|exists:parentescos,pare_cod_parentesco',
            'depe_datavencimento' => 'nullable|date',
            'depe_badicional' => 'boolean',
        ]);
        $data['tenant_id'] = $this->tenantId($request);
        $data['depe_datainscricao'] = now();
        return $this->created(Dependente::create($data)->load('parentesco'));
    }

    public function show(Request $request, $id)
    {
        return $this->success(Dependente::tenantScope($this->tenantId($request))->with(['associado', 'parentesco'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $dep = Dependente::tenantScope($this->tenantId($request))->findOrFail($id);
        $dep->update($request->validate([
            'depe_nome' => 'sometimes|string',
            'depe_sexo' => 'sometimes|string|max:1',
            'depe_datanascimento' => 'sometimes|date',
            'pare_cod_parentesco' => 'sometimes|exists:parentescos,pare_cod_parentesco',
            'depe_datavencimento' => 'nullable|date',
            'depe_badicional' => 'boolean',
            'depe_ativo' => 'boolean',
        ]));
        return $this->success($dep->fresh());
    }

    public function destroy(Request $request, $id)
    {
        Dependente::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }
}
