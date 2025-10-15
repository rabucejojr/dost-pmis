<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserType;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factory_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_type' => UserType::class,
        ];
    }
    protected $casts = [
        'user_type' => UserType::class,
    ];

    protected $attributes = [
        'user_type' => UserType::USER,
    ];

    // 👇 Helper methods for readability
    public function isAdmin(): bool
    {
        return $this->user_type === UserType::ADMIN;
    }

    public function isUser(): bool
    {
        return $this->user_type === UserType::USER;
    }
    public function isGuest(): bool
    {
        return $this->user_type === UserType::GUEST;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->user_type, $roles);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
