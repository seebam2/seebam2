<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plano extends Model
{
    protected $table = 'planos';
    protected $fillable = ['nome', 'descricao', 'valor_mensal', 'limite_usuarios', 'limite_associados', 'cms_habilitado', 'relatorios_avancados', 'portal_associado', 'ativo'];
    protected $casts = ['valor_mensal' => 'decimal:2', 'cms_habilitado' => 'boolean', 'relatorios_avancados' => 'boolean', 'portal_associado' => 'boolean', 'ativo' => 'boolean'];

    public function tenants(): HasMany { return $this->hasMany(Tenant::class, 'plano_id'); }
}
