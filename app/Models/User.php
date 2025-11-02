<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes', // ✅ corrected typo
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'user_type' => UserType::class,
    ];

    protected $attributes = [
        'user_type' => UserType::USER,
    ];

    /**
     * Automatically sync Spatie roles with enum user_type
     */
    protected static function booted()
    {
        static::created(function (User $user) {
            $role = match ($user->user_type) {
                UserType::ADMIN => 'Admin',
                UserType::USER => 'User',
                UserType::GUEST => 'Guest',
                default => 'User',
            };

            if (! $user->hasRole($role)) {
                $user->assignRole($role);
            }
        });
    }

    // ✅ Simplified enum-based helpers
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isUser(): bool
    {
        return $this->hasRole('User');
    }

    public function isGuest(): bool
    {
        return $this->hasRole('Guest');
    }

    // ✅ Removed recursion issue
    public function hasAnyNamedRole(array $roles): bool
    {
        return $this->hasAnyRole($roles);
    }

    // Relationships
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
