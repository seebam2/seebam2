<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conveniado extends Model
{
    protected $table = 'conveniados';
    protected $primaryKey = 'conv_cod_conveniado';
    protected $fillable = ['espe_cod_especialidade', 'conv_nome_conveniado', 'conv_horario_funcionamento', 'conv_endereco_conveniado', 'conv_telefone_1_conveniado', 'conv_telefone_2_conveniado', 'conv_observacao_conveniado', 'conv_dt_vigencia', 'conv_ativo', 'tenant_id'];
    protected $casts = ['conv_dt_vigencia' => 'datetime', 'conv_ativo' => 'boolean'];

    public function especialidade(): BelongsTo { return $this->belongsTo(Especialidade::class, 'espe_cod_especialidade', 'espe_cod_especialidade'); }
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    public function servicos(): HasMany { return $this->hasMany(Servico::class, 'conv_cod_conveniado', 'conv_cod_conveniado'); }

    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
