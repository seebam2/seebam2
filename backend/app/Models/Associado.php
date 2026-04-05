<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Associado extends Model
{
    protected $table = 'associados';
    protected $primaryKey = 'asso_inscricao_associado';
    protected $fillable = [
        'asso_nome_associado', 'asso_data_nasc', 'asso_sexo_associado',
        'esci_cod_estado_civil', 'asso_naturalidade_associado', 'asso_nacionalidade_associado',
        'asso_mae_associado', 'asso_pai_associado', 'esco_cod_escolaridade',
        'asso_email_associado', 'asso_carteira_profissional', 'asso_serie_associado',
        'asso_estado_serie', 'asso_cpf_associado', 'asso_rg_associado', 'asso_estado_rg',
        'asso_pis_associado', 'asso_logradouro_endereco', 'asso_numero_endereco',
        'asso_complemento_endereco', 'asso_bairro_endereco', 'asso_cep_endereco',
        'asso_cidade_endereco', 'asso_estado_endereco', 'asso_matric_sindicalizador',
        'asso_ativo_associado', 'asso_sindicalista_associado', 'asso_data_inscricao',
        'asso_telefone_1_associado', 'asso_telefone_2_associado', 'tenant_id',
    ];

    protected $casts = [
        'asso_data_nasc' => 'date',
        'asso_data_inscricao' => 'datetime',
        'asso_ativo_associado' => 'boolean',
        'asso_sindicalista_associado' => 'boolean',
    ];

    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    public function estadoCivil(): BelongsTo { return $this->belongsTo(EstadoCivil::class, 'esci_cod_estado_civil', 'esci_cod_estado_civil'); }
    public function escolaridade(): BelongsTo { return $this->belongsTo(Escolaridade::class, 'esco_cod_escolaridade', 'esco_cod_escolaridade'); }
    public function estadoEndereco(): BelongsTo { return $this->belongsTo(Estado::class, 'asso_estado_endereco', 'esta_cod_estado'); }
    public function cidadeEndereco(): BelongsTo { return $this->belongsTo(Municipio::class, 'asso_cidade_endereco', 'muni_cod_municipio'); }
    public function dependentes(): HasMany { return $this->hasMany(Dependente::class, 'depe_inscricao', 'asso_inscricao_associado'); }
    public function historicoProfissional(): HasMany { return $this->hasMany(AssociadoAgencia::class, 'asso_inscricao_associado', 'asso_inscricao_associado'); }
    public function mensalidades(): HasMany { return $this->hasMany(Mensalidade::class, 'asso_inscricao_associado', 'asso_inscricao_associado'); }
    public function pagamentos(): HasMany { return $this->hasMany(Pagamento::class, 'asso_inscricao_associado', 'asso_inscricao_associado'); }
    public function servicos(): HasMany { return $this->hasMany(Servico::class, 'asso_inscricao_associado', 'asso_inscricao_associado'); }

    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
    public function scopeAtivos($q) { return $q->where('asso_ativo_associado', true); }
    public function scopeInativos($q) { return $q->where('asso_ativo_associado', false); }
}
