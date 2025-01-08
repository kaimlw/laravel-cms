<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'web_id',
        'display_name',
        'username',
        'email',
        'password',
        'roles',
    ];

    /**
     * Set Validation Message
     */
    public const VALIDATION_MESSAGE = [
        'username.required' => 'Username harus diisi',
        'username.unique' => 'Username sudah digunakan oleh pengguna lain',
        'email.email' => 'Format email tidak valid',
        'password.min' => 'Password minimal terdiri atas 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak sesuai'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
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
        ];
    }

    /**
     * Define relation with Webs Table
     * Relation: (Web)One-to-Many(User)
     */
    public function web(): BelongsTo
    {
        return $this->belongsTo(Web::class);
    }

    /**
     * Define relation with Post Table
     * Relation: (Web)One-to-Many(Post)
     */
    public function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
