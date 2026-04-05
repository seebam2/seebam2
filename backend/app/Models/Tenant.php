<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $fillable = ['nome', 'slug', 'cnpj', 'email', 'telefone', 'endereco', 'cidade', 'estado', 'cep', 'logo', 'cor_primaria', 'cor_secundaria', 'plano_id', 'plano_validade', 'ativo'];
    protected $casts = ['ativo' => 'boolean', 'plano_validade' => 'date'];

    public function plano(): BelongsTo { return $this->belongsTo(Plano::class, 'plano_id'); }
    public function users(): HasMany { return $this->hasMany(User::class, 'tenant_id'); }
    public function associados(): HasMany { return $this->hasMany(Associado::class, 'tenant_id'); }
    public function bancos(): HasMany { return $this->hasMany(Banco::class, 'tenant_id'); }
    public function agencias(): HasMany { return $this->hasMany(Agencia::class, 'tenant_id'); }
    public function conveniados(): HasMany { return $this->hasMany(Conveniado::class, 'tenant_id'); }
    public function configuracoes(): HasMany { return $this->hasMany(Configuracao::class, 'tenant_id'); }
}
