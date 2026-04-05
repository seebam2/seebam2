<?php
namespace App\Http\Controllers\Api;

use App\Models\AssociadoAgencia;
use Illuminate\Http\Request;

class HistoricoProfissionalController extends BaseApiController
{
    public function index(Request $request)
    {
        $q = AssociadoAgencia::with(['associado', 'agencia.banco', 'cargo', 'situacao']);
        if ($request->filled('associado')) $q->where('asso_inscricao_associado', $request->associado);
        return $this->success($q->orderByDesc('asag_dt_admissao')->paginate($request->per_page ?? 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asso_inscricao_associado' => 'required|exists:associados,asso_inscricao_associado',
            'agnc_cod_agencia' => 'required|exists:agencias,agnc_cod_agencia',
            'asag_matricula' => 'nullable|integer',
            'carg_cod_cargo' => 'required|exists:cargos,carg_cod_cargo',
            'asag_dt_admissao' => 'nullable|date',
            'asag_dt_demissao' => 'nullable|date',
            'sias_cod_situacao_associado' => 'required|exists:situacao_associado,sias_cod_situacao_associado',
            'asag_comentario' => 'nullable|string',
        ]);
        return $this->created(AssociadoAgencia::create($data)->load(['agencia.banco', 'cargo', 'situacao']));
    }

    public function show($id)
    {
        return $this->success(AssociadoAgencia::with(['associado', 'agencia.banco', 'cargo', 'situacao'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $hist = AssociadoAgencia::findOrFail($id);
        $hist->update($request->validate([
            'agnc_cod_agencia' => 'sometimes|exists:agencias,agnc_cod_agencia',
            'asag_matricula' => 'nullable|integer',
            'carg_cod_cargo' => 'sometimes|exists:cargos,carg_cod_cargo',
            'asag_dt_admissao' => 'nullable|date',
            'asag_dt_demissao' => 'nullable|date',
            'sias_cod_situacao_associado' => 'sometimes|exists:situacao_associado,sias_cod_situacao_associado',
            'asag_comentario' => 'nullable|string',
        ]));
        return $this->success($hist->fresh());
    }

    public function destroy($id)
    {
        AssociadoAgencia::findOrFail($id)->delete();
        return $this->deleted();
    }
}
