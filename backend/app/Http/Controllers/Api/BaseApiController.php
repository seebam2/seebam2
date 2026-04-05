<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected function tenantId(Request $request): ?int
    {
        return $request->user()?->tenant_id;
    }

    protected function success($data = null, string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $status);
    }

    protected function created($data = null, string $message = 'Criado com sucesso'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    protected function error(string $message = 'Erro', int $status = 400, $errors = null): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message, 'errors' => $errors], $status);
    }

    protected function deleted(string $message = 'Removido com sucesso'): JsonResponse
    {
        return $this->success(null, $message);
    }
}
