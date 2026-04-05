<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banco extends Model
{
    protected $table = 'bancos';
    protected $primaryKey = 'banc_cod_banco';
    protected $fillable = ['banc_descricao_banco', 'banc_situacao_banco', 'tenant_id'];

    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    public function agencias(): HasMany { return $this->hasMany(Agencia::class, 'banc_cod_banco', 'banc_cod_banco'); }

    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
