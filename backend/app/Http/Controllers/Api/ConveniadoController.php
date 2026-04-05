<?php
namespace App\Http\Controllers\Api;

use App\Models\Conveniado;
use Illuminate\Http\Request;

class ConveniadoController extends BaseApiController
{
    public function index(Request $request)
    {
        $q = Conveniado::tenantScope($this->tenantId($request))->with('especialidade');
        if ($request->filled('busca')) $q->where('conv_nome_conveniado', 'like', "%{$request->busca}%");
        if ($request->filled('especialidade')) $q->where('espe_cod_especialidade', $request->especialidade);
        return $this->success($q->orderBy('conv_nome_conveniado')->paginate($request->per_page ?? 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'espe_cod_especialidade' => 'required|exists:especialidades,espe_cod_especialidade',
            'conv_nome_conveniado' => 'required|string', 'conv_horario_funcionamento' => 'nullable|string',
            'conv_endereco_conveniado' => 'nullable|string', 'conv_telefone_1_conveniado' => 'nullable|string',
            'conv_telefone_2_conveniado' => 'nullable|string', 'conv_observacao_conveniado' => 'nullable|string',
            'conv_dt_vigencia' => 'nullable|date',
        ]);
        $data['tenant_id'] = $this->tenantId($request);
        return $this->created(Conveniado::create($data)->load('especialidade'));
    }

    public function show(Request $request, $id)
    {
        return $this->success(Conveniado::tenantScope($this->tenantId($request))->with(['especialidade', 'servicos'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $c = Conveniado::tenantScope($this->tenantId($request))->findOrFail($id);
        $c->update($request->validate([
            'espe_cod_especialidade' => 'sometimes|exists:especialidades,espe_cod_especialidade',
            'conv_nome_conveniado' => 'sometimes|string', 'conv_horario_funcionamento' => 'nullable|string',
            'conv_endereco_conveniado' => 'nullable|string', 'conv_telefone_1_conveniado' => 'nullable|string',
            'conv_telefone_2_conveniado' => 'nullable|string', 'conv_observacao_conveniado' => 'nullable|string',
            'conv_dt_vigencia' => 'nullable|date', 'conv_ativo' => 'boolean',
        ]));
        return $this->success($c->fresh());
    }

    public function destroy(Request $request, $id)
    {
        Conveniado::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }
}
