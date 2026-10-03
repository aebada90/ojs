<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Vendor\Models\Vendor;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'avatar',
        'locale',
        'timezone',
        'currency',
        'bio',
        'is_active',
        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'provider',
        'provider_id',
        'metadata',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'metadata' => 'array',
        ];
    }

    /**
     * Send the email verification notification.
     *
     * Hostinger SMTP misconfig must never become HTTP 500 on Resend/Register.
     * On failure we flash an on-page signed verify link instead.
     */
    public function sendEmailVerificationNotification(): void
    {
        $inlineUrl = VerifyEmail::signedUrl($this);

        try {
            $this->notify(new VerifyEmail);
        } catch (\Throwable $e) {
            report($e);

            session()->flash('verification_mail_failed', true);
            session()->flash('verification_inline_url', $inlineUrl);

            return;
        }

        if (config('platform.verify_inline_fallback')) {
            session()->flash('verification_inline_url', $inlineUrl);
        }
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }
}
