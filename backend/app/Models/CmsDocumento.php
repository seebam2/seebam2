<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsDocumento extends Model
{
    protected $table = 'cms_documentos';
    protected $fillable = ['titulo', 'descricao', 'arquivo', 'tipo_arquivo', 'tamanho_bytes', 'publico', 'tenant_id'];
    protected $casts = ['publico' => 'boolean'];

    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
