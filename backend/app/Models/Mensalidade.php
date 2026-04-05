<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mensalidade extends Model
{
    protected $table = 'mensalidades';
    protected $fillable = ['asso_inscricao_associado', 'ano', 'mes', 'valor', 'status', 'data_pagamento', 'data_vencimento', 'observacao', 'tenant_id'];
    protected $casts = ['valor' => 'decimal:2', 'data_pagamento' => 'date', 'data_vencimento' => 'date'];

    public function associado(): BelongsTo { return $this->belongsTo(Associado::class, 'asso_inscricao_associado', 'asso_inscricao_associado'); }
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }

    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }

    public function getNomeMesAttribute(): string
    {
        $meses = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        return $meses[$this->mes] ?? '';
    }
}
