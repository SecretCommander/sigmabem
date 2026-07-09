<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Pengguna';
    protected $primaryKey = 'ID_Pengguna';
    public $timestamps = false;

    protected $fillable = [
        'Username',
        'Password',
        'Role',
        'Email',
        'is_active',
        'Last_login',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'date',
            'Last_login' => 'datetime',
        ];
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getAuthIdentifierName()
    {
        return 'Username';
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }


    public function isOnline(): bool
    {
        if (!$this->Last_login) {
            return false;
        }
        return Carbon::parse($this->Last_login)->diffInMinutes(now()) <= 5;
    }


    public function isActiveSession(): bool
    {
        return Session::has('user_id') && Session::get('user_id') == $this->ID_Pengguna;
    }


    public function markAsOnline(): void
    {
        $this->update([
            'is_active' => now()->toDateString(),
            'Last_login' => now(),
        ]);
    }


    public function markAsOffline(): void
    {
        $this->update([
            'Last_login' => $this->Last_login,
        ]);
    }


    public function isSuperadmin(): bool
    {
        return Session::get('user_role') === 'Superadmin';
    }

    public function isAdmin(): bool
    {
        return Session::get('user_role') === 'Admin';
    }

    public function isUser(): bool
    {
        return Session::get('user_role') === 'User';
    }

    public function hasRole(string $role): bool
    {
        return Session::get('user_role') === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array(Session::get('user_role'), $roles);
    }


    public function getStatusBadge(): string
    {
        if ($this->isActiveSession()) {
            return '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">● Online</span>';
        }

        if ($this->isOnline()) {
            return '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">● Baru Online</span>';
        }

        return '<span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-bold">● Offline</span>';
    }


    public function getLastLoginAttribute(): string
    {
        if (!$this->Last_login) {
            return 'Belum pernah login';
        }

        return Carbon::parse($this->Last_login)->diffForHumans();
    }


    public function getMenu(): array
    {
        return match (Session::get('user_role')) {
            'Superadmin' => [
                ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => '🏠'],
                ['name' => 'Proposal', 'route' => 'proposal.index', 'icon' => '📄'],
                ['name' => 'LPJ', 'route' => 'lpj.index', 'icon' => '📋'],
                ['name' => 'Users', 'route' => 'users.index', 'icon' => '👥'],
                ['name' => 'Settings', 'route' => 'settings.index', 'icon' => '⚙️'],
                ['name' => 'Logs', 'route' => 'logs.index', 'icon' => '📊'],
            ],
            'Admin' => [
                ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => '🏠'],
                ['name' => 'Proposal', 'route' => 'proposal.index', 'icon' => '📄'],
                ['name' => 'LPJ', 'route' => 'lpj.index', 'icon' => '📋'],
            ],
            'User' => [
                ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => '🏠'],
                ['name' => 'Proposal Saya', 'route' => 'user.proposals', 'icon' => '📄'],
                ['name' => 'LPJ Saya', 'route' => 'user.lpj', 'icon' => '📋'],
            ],
            default => [
                ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => '🏠'],
            ],
        };
    }

    // Relasi
    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }
}
