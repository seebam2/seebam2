<?php
namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use App\Models\Plano;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantController extends BaseApiController
{
    public function index()
    {
        return $this->success(Tenant::with('plano')->withCount(['users', 'associados'])->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string', 'cnpj' => 'nullable|string|unique:tenants',
            'email' => 'nullable|email', 'telefone' => 'nullable|string', 'endereco' => 'nullable|string',
            'cidade' => 'nullable|string', 'estado' => 'nullable|string|max:2', 'cep' => 'nullable|string',
            'plano_id' => 'required|exists:planos,id', 'plano_validade' => 'nullable|date',
        ]);
        $data['slug'] = Str::slug($data['nome']);
        return $this->created(Tenant::create($data)->load('plano'));
    }

    public function show($id)
    {
        return $this->success(Tenant::with('plano')->withCount(['users', 'associados'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $t = Tenant::findOrFail($id);
        $t->update($request->validate([
            'nome' => 'sometimes|string', 'cnpj' => "nullable|string|unique:tenants,cnpj,{$id}",
            'email' => 'nullable|email', 'telefone' => 'nullable|string', 'cor_primaria' => 'nullable|string',
            'cor_secundaria' => 'nullable|string', 'plano_id' => 'sometimes|exists:planos,id',
            'plano_validade' => 'nullable|date', 'ativo' => 'boolean',
        ]));
        return $this->success($t->fresh());
    }

    public function destroy($id)
    {
        Tenant::findOrFail($id)->delete();
        return $this->deleted();
    }

    public function planos()
    {
        return $this->success(Plano::where('ativo', true)->get());
    }
}
