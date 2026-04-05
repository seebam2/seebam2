<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Servico extends Model
{
    protected $table = 'servicos';
    protected $primaryKey = 'serv_cod_servico';
    protected $fillable = ['tser_tipo_servico', 'asso_inscricao_associado', 'sise_situacao_servico', 'depe_iddependente', 'conv_cod_conveniado', 'serv_observacoes_servico', 'serv_data_criacao', 'tenant_id'];
    protected $casts = ['serv_data_criacao' => 'datetime'];

    public function tipoServico(): BelongsTo { return $this->belongsTo(TipoServico::class, 'tser_tipo_servico', 'tser_tipo_servico'); }
    public function associado(): BelongsTo { return $this->belongsTo(Associado::class, 'asso_inscricao_associado', 'asso_inscricao_associado'); }
    public function situacao(): BelongsTo { return $this->belongsTo(SituacaoServico::class, 'sise_situacao_servico', 'sise_situacao_servico'); }
    public function dependente(): BelongsTo { return $this->belongsTo(Dependente::class, 'depe_iddependente', 'depe_iddependente'); }
    public function conveniado(): BelongsTo { return $this->belongsTo(Conveniado::class, 'conv_cod_conveniado', 'conv_cod_conveniado'); }
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }

    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
