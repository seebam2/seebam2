<?php
namespace App\Http\Controllers\Api;

use App\Models\Associado;
use Illuminate\Http\Request;

class AssociadoController extends BaseApiController
{
    public function index(Request $request)
    {
        $query = Associado::tenantScope($this->tenantId($request))
            ->with(['estadoCivil', 'escolaridade', 'estadoEndereco', 'cidadeEndereco']);

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('asso_nome_associado', 'like', "%{$busca}%")
                  ->orWhere('asso_cpf_associado', 'like', "%{$busca}%")
                  ->orWhere('asso_inscricao_associado', $busca);
            });
        }

        if ($request->filled('status')) {
            $query->where('asso_ativo_associado', $request->status === 'ativo');
        }

        $associados = $query->orderBy('asso_nome_associado')->paginate($request->per_page ?? 15);
        return $this->success($associados);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asso_nome_associado' => 'required|string|max:191',
            'asso_data_nasc' => 'required|date',
            'asso_sexo_associado' => 'required|string|max:1',
            'esci_cod_estado_civil' => 'required|exists:estados_civis,esci_cod_estado_civil',
            'esco_cod_escolaridade' => 'required|exists:escolaridades,esco_cod_escolaridade',
            'asso_cpf_associado' => 'required|string|unique:associados,asso_cpf_associado',
            'asso_nacionalidade_associado' => 'nullable|string',
            'asso_mae_associado' => 'nullable|string',
            'asso_pai_associado' => 'nullable|string',
            'asso_email_associado' => 'nullable|email',
            'asso_rg_associado' => 'nullable|string',
            'asso_pis_associado' => 'nullable|string',
            'asso_logradouro_endereco' => 'nullable|string',
            'asso_numero_endereco' => 'nullable|string',
            'asso_complemento_endereco' => 'nullable|string',
            'asso_bairro_endereco' => 'nullable|string',
            'asso_cep_endereco' => 'nullable|string',
            'asso_cidade_endereco' => 'nullable|integer',
            'asso_estado_endereco' => 'nullable|integer',
            'asso_telefone_1_associado' => 'nullable|string',
            'asso_telefone_2_associado' => 'nullable|string',
            'asso_ativo_associado' => 'boolean',
            'asso_sindicalista_associado' => 'boolean',
        ]);

        $data['tenant_id'] = $this->tenantId($request);
        $data['asso_data_inscricao'] = now();
        $data['asso_nacionalidade_associado'] = $data['asso_nacionalidade_associado'] ?? 'Brasileira';

        $associado = Associado::create($data);
        return $this->created($associado->load(['estadoCivil', 'escolaridade']));
    }

    public function show(Request $request, $id)
    {
        $associado = Associado::tenantScope($this->tenantId($request))
            ->with(['estadoCivil', 'escolaridade', 'estadoEndereco', 'cidadeEndereco', 'dependentes.parentesco', 'historicoProfissional.agencia.banco', 'historicoProfissional.cargo', 'historicoProfissional.situacao', 'mensalidades', 'pagamentos', 'servicos.tipoServico'])
            ->findOrFail($id);

        return $this->success($associado);
    }

    public function update(Request $request, $id)
    {
        $associado = Associado::tenantScope($this->tenantId($request))->findOrFail($id);

        $data = $request->validate([
            'asso_nome_associado' => 'sometimes|string|max:191',
            'asso_data_nasc' => 'sometimes|date',
            'asso_sexo_associado' => 'sometimes|string|max:1',
            'esci_cod_estado_civil' => 'sometimes|exists:estados_civis,esci_cod_estado_civil',
            'esco_cod_escolaridade' => 'sometimes|exists:escolaridades,esco_cod_escolaridade',
            'asso_cpf_associado' => "sometimes|string|unique:associados,asso_cpf_associado,{$id},asso_inscricao_associado",
            'asso_nacionalidade_associado' => 'nullable|string',
            'asso_mae_associado' => 'nullable|string',
            'asso_pai_associado' => 'nullable|string',
            'asso_email_associado' => 'nullable|email',
            'asso_rg_associado' => 'nullable|string',
            'asso_logradouro_endereco' => 'nullable|string',
            'asso_numero_endereco' => 'nullable|string',
            'asso_complemento_endereco' => 'nullable|string',
            'asso_bairro_endereco' => 'nullable|string',
            'asso_cep_endereco' => 'nullable|string',
            'asso_cidade_endereco' => 'nullable|integer',
            'asso_estado_endereco' => 'nullable|integer',
            'asso_telefone_1_associado' => 'nullable|string',
            'asso_telefone_2_associado' => 'nullable|string',
            'asso_ativo_associado' => 'boolean',
            'asso_sindicalista_associado' => 'boolean',
        ]);

        $associado->update($data);
        return $this->success($associado->fresh());
    }

    public function destroy(Request $request, $id)
    {
        Associado::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }
}
