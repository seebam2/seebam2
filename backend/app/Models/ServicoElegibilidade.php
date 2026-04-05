<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicoElegibilidade extends Model
{
    protected $table = 'servico_elegibilidade';
    protected $fillable = ['tser_tipo_servico', 'pare_cod_parentesco', 'elegivel', 'tipo_cobranca', 'valor', 'percentual_desconto', 'tenant_id'];
    protected $casts = ['elegivel' => 'boolean', 'valor' => 'decimal:2', 'percentual_desconto' => 'decimal:2'];

    public function tipoServico(): BelongsTo { return $this->belongsTo(TipoServico::class, 'tser_tipo_servico', 'tser_tipo_servico'); }
    public function parentesco(): BelongsTo { return $this->belongsTo(Parentesco::class, 'pare_cod_parentesco', 'pare_cod_parentesco'); }
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }

    public function calcularValor(float $valorBase): float
    {
        if ($this->tipo_cobranca === 'gratuito') return 0;
        if ($this->tipo_cobranca === 'valor_fixo') return (float) $this->valor;
        if ($this->tipo_cobranca === 'percentual_desconto') return $valorBase * (1 - ($this->percentual_desconto / 100));
        return $valorBase;
    }

    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
