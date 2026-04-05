<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agencia extends Model
{
    protected $table = 'agencias';
    protected $primaryKey = 'agnc_cod_agencia';
    protected $fillable = ['agnc_descr_agencia', 'agnc_numero_agencia', 'agnc_cod_municipio', 'agnc_endereco_agencia', 'banc_cod_banco', 'agnc_observacao_agencia', 'agnc_situacao_agencia', 'agnc_telefone_1_agencia', 'agnc_telefone_2_agencia', 'tenant_id'];

    public function banco(): BelongsTo { return $this->belongsTo(Banco::class, 'banc_cod_banco', 'banc_cod_banco'); }
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    public function historicoProfissional(): HasMany { return $this->hasMany(AssociadoAgencia::class, 'agnc_cod_agencia', 'agnc_cod_agencia'); }

    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
