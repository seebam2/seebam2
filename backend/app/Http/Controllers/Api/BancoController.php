<?php
namespace App\Http\Controllers\Api;

use App\Models\Banco;
use App\Models\Agencia;
use Illuminate\Http\Request;

class BancoController extends BaseApiController
{
    public function index(Request $request)
    {
        return $this->success(Banco::tenantScope($this->tenantId($request))->withCount('agencias')->orderBy('banc_descricao_banco')->paginate($request->per_page ?? 50));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['banc_descricao_banco' => 'required|string', 'banc_situacao_banco' => 'sometimes|string']);
        $data['tenant_id'] = $this->tenantId($request);
        return $this->created(Banco::create($data));
    }

    public function show(Request $request, $id)
    {
        return $this->success(Banco::tenantScope($this->tenantId($request))->with('agencias')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $banco = Banco::tenantScope($this->tenantId($request))->findOrFail($id);
        $banco->update($request->validate(['banc_descricao_banco' => 'sometimes|string', 'banc_situacao_banco' => 'sometimes|string']));
        return $this->success($banco->fresh());
    }

    public function destroy(Request $request, $id)
    {
        Banco::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }
}
