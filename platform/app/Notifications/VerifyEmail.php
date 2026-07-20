<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Synchronous (non-queued) verification email — required on Hostinger shared hosting
 * where queue workers only run briefly via cron.
 */
class VerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        $locale = is_object($notifiable) && isset($notifiable->locale) && $notifiable->locale
            ? $notifiable->locale
            : app()->getLocale();

        return (new MailMessage)
            ->subject(__('platform.verify.mail_subject', [], $locale))
            ->line(__('platform.verify.mail_line', [], $locale))
            ->action(__('platform.verify.mail_action', [], $locale), static::signedUrl($notifiable))
            ->line(__('platform.verify.mail_outro', [], $locale));
    }

    /**
     * Public helper so controllers can show an on-page link when SMTP fails.
     */
    public static function signedUrl(object $notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes((int) Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    protected function verificationUrl($notifiable): string
    {
        return static::signedUrl($notifiable);
    }
}
