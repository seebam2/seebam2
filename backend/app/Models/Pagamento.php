<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    protected $table = 'pagamentos';
    protected $fillable = ['asso_inscricao_associado', 'depe_iddependente', 'tipo', 'valor', 'data_pagamento', 'forma_pagamento', 'banco_agencia', 'comprovante', 'observacao', 'mensalidade_id', 'serv_cod_servico', 'tenant_id'];
    protected $casts = ['valor' => 'decimal:2', 'data_pagamento' => 'date'];

    public function associado(): BelongsTo { return $this->belongsTo(Associado::class, 'asso_inscricao_associado', 'asso_inscricao_associado'); }
    public function dependente(): BelongsTo { return $this->belongsTo(Dependente::class, 'depe_iddependente', 'depe_iddependente'); }
    public function mensalidade(): BelongsTo { return $this->belongsTo(Mensalidade::class); }
    public function servico(): BelongsTo { return $this->belongsTo(Servico::class, 'serv_cod_servico', 'serv_cod_servico'); }
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }

    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
