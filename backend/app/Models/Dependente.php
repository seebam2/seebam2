<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dependente extends Model
{
    protected $table = 'dependentes';
    protected $primaryKey = 'depe_iddependente';
    protected $fillable = ['depe_inscricao', 'depe_nome', 'depe_sexo', 'depe_datanascimento', 'pare_cod_parentesco', 'depe_datainscricao', 'depe_datavencimento', 'depe_badicional', 'depe_ativo', 'tenant_id'];
    protected $casts = ['depe_datanascimento' => 'date', 'depe_datainscricao' => 'datetime', 'depe_datavencimento' => 'date', 'depe_badicional' => 'boolean', 'depe_ativo' => 'boolean'];

    public function associado(): BelongsTo { return $this->belongsTo(Associado::class, 'depe_inscricao', 'asso_inscricao_associado'); }
    public function parentesco(): BelongsTo { return $this->belongsTo(Parentesco::class, 'pare_cod_parentesco', 'pare_cod_parentesco'); }
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }

    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
