<?php
namespace App\Http\Controllers\Api;

use App\Models\CmsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsPostController extends BaseApiController
{
    public function index(Request $request)
    {
        $q = CmsPost::tenantScope($this->tenantId($request))->with('autor');
        if ($request->filled('tipo')) $q->where('tipo', $request->tipo);
        if ($request->filled('status')) $q->where('status', $request->status);
        return $this->success($q->orderByDesc('created_at')->paginate($request->per_page ?? 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string', 'resumo' => 'nullable|string', 'conteudo' => 'required|string',
            'tipo' => 'required|in:noticia,evento', 'status' => 'sometimes|in:rascunho,publicado,agendado',
            'data_publicacao' => 'nullable|date', 'data_evento' => 'nullable|date', 'local_evento' => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['titulo']);
        $data['tenant_id'] = $this->tenantId($request);
        $data['autor_id'] = $request->user()->id;
        return $this->created(CmsPost::create($data));
    }

    public function show(Request $request, $id)
    {
        return $this->success(CmsPost::tenantScope($this->tenantId($request))->with('autor')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $post = CmsPost::tenantScope($this->tenantId($request))->findOrFail($id);
        $data = $request->validate([
            'titulo' => 'sometimes|string', 'resumo' => 'nullable|string', 'conteudo' => 'sometimes|string',
            'tipo' => 'sometimes|in:noticia,evento', 'status' => 'sometimes|in:rascunho,publicado,agendado',
            'data_publicacao' => 'nullable|date', 'data_evento' => 'nullable|date', 'local_evento' => 'nullable|string',
        ]);
        if (isset($data['titulo'])) $data['slug'] = Str::slug($data['titulo']);
        $post->update($data);
        return $this->success($post->fresh());
    }

    public function destroy(Request $request, $id)
    {
        CmsPost::tenantScope($this->tenantId($request))->findOrFail($id)->delete();
        return $this->deleted();
    }
}
