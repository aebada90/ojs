<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_EDITOR = 'journal_editor';
    public const ROLE_AUTHOR = 'author';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'organization',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isJournalEditor(): bool
    {
        return $this->role === self::ROLE_EDITOR;
    }

    public function isAuthor(): bool
    {
        return $this->role === self::ROLE_AUTHOR;
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_EDITOR => 'Journal Editor',
            default => 'Author',
        };
    }
}
