<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Configuracao extends Model
{
    protected $table = 'configuracoes';
    protected $fillable = ['tenant_id', 'chave', 'valor', 'grupo'];

    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }

    public static function getValor(int $tenantId, string $chave, $default = null)
    {
        $config = static::where('tenant_id', $tenantId)->where('chave', $chave)->first();
        return $config ? $config->valor : $default;
    }

    public static function setValor(int $tenantId, string $chave, $valor, string $grupo = 'geral')
    {
        return static::updateOrCreate(['tenant_id' => $tenantId, 'chave' => $chave], ['valor' => $valor, 'grupo' => $grupo]);
    }
}
