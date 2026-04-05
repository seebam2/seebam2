<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsPost extends Model
{
    protected $table = 'cms_posts';
    protected $fillable = ['titulo', 'slug', 'resumo', 'conteudo', 'imagem_destaque', 'tipo', 'status', 'data_publicacao', 'data_evento', 'local_evento', 'autor_id', 'tenant_id'];
    protected $casts = ['data_publicacao' => 'datetime', 'data_evento' => 'datetime'];

    public function autor(): BelongsTo { return $this->belongsTo(User::class, 'autor_id'); }
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }

    public function scopePublicados($q) { return $q->where('status', 'publicado')->where('data_publicacao', '<=', now()); }
    public function scopeNoticias($q) { return $q->where('tipo', 'noticia'); }
    public function scopeEventos($q) { return $q->where('tipo', 'evento'); }
    public function scopeTenantScope($q, $tenantId) { return $q->where('tenant_id', $tenantId); }
}
