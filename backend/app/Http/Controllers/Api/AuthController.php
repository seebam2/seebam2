<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseApiController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Credenciais inválidas.']]);
        }

        if (!$user->ativo) {
            return $this->error('Usuário desativado.', 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->success([
            'user' => $user->load('tenant', 'role'),
            'token' => $token,
        ], 'Login realizado com sucesso');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success(null, 'Logout realizado');
    }

    public function me(Request $request)
    {
        return $this->success($request->user()->load('tenant', 'role'));
    }
}
