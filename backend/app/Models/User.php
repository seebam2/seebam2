<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'avatar', 'phone', 'address', 'tenant_id', 'role_id', 'level', 'ativo'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'ativo' => 'boolean'];
    }

    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class, 'tenant_id'); }
    public function role(): BelongsTo { return $this->belongsTo(Role::class, 'role_id'); }

    public function isSuperAdmin(): bool { return $this->level === 9; }
    public function isAdmin(): bool { return $this->level >= 1; }

    public function scopeTenantScope($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
