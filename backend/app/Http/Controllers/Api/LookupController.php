<?php
namespace App\Http\Controllers\Api;

use App\Models\{Estado, Municipio, EstadoCivil, Escolaridade, Parentesco, Cargo, Especialidade, SituacaoAssociado, TipoServico, SituacaoServico};
use Illuminate\Http\Request;

class LookupController extends BaseApiController
{
    public function estados() { return $this->success(Estado::orderBy('esta_descr_estado')->get()); }
    public function municipios(Request $request) {
        $q = Municipio::query();
        if ($request->filled('estado')) $q->where('esta_cod_estado', $request->estado);
        return $this->success($q->orderBy('muni_descr_municipio')->get());
    }
    public function estadosCivis() { return $this->success(EstadoCivil::orderBy('esci_descr_estado_civil')->get()); }
    public function escolaridades() { return $this->success(Escolaridade::orderBy('esco_descr_escolaridade')->get()); }
    public function parentescos() { return $this->success(Parentesco::orderBy('pare_descricao_parentesco')->get()); }
    public function cargos() { return $this->success(Cargo::orderBy('carg_descr_cargo')->get()); }
    public function especialidades() { return $this->success(Especialidade::orderBy('espe_descr_especialidade')->get()); }
    public function situacoesAssociado() { return $this->success(SituacaoAssociado::all()); }
    public function tiposServico() { return $this->success(TipoServico::all()); }
    public function situacoesServico() { return $this->success(SituacaoServico::all()); }
}
