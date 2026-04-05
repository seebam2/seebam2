<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsPagina extends Model
{
    protected $table = 'cms_paginas';
    protected $fillable = ['titulo', 'slug', 'conteudo', 'ordem', 'publicado', 'tenant_id'];
    protected $casts = ['publicado' => 'boolean'];

    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
