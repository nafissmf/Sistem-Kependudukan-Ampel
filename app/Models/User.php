<?php

namespace App\Models;

use App\Enums\RoleCode;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids, Notifiable, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'fullname',
        'phone',
        'photo',
        'role_id',
        'village_id',
        'is_active',
        'last_login',
        'created_by',
        'updated_by',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Auth.js di versi Next.js memakai field `identifier` (username ATAU
     * email) untuk login. Di Laravel, kita replikasi lewat custom logic di
     * LoginRequest, bukan lewat kolom ini — kolom auth default tetap
     * 'username' supaya kompatibel dengan Auth::attempt().
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function hasRole(RoleCode $role): bool
    {
        return $this->role?->code === $role;
    }

    /** Shortcut RBAC: $user->can('penduduk', 'create') */
    public function canDo(string $module, string $action): bool
    {
        if (! $this->role) {
            return false;
        }

        return \App\Support\Rbac::has($this->role->code, $module, $action);
    }
}
