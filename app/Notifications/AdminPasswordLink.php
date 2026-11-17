<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Mail met een link om een wachtwoord in te stellen: bij "wachtwoord vergeten"
 * én als uitnodiging voor een nieuwe beheerder.
 */
class AdminPasswordLink extends Notification
{
    public function __construct(public string $token, public bool $invite = false) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('admin.password.reset', ['token' => $this->token, 'email' => $notifiable->email]);
        $minutes = config('auth.passwords.users.expire');

        return (new MailMessage)
            ->subject($this->invite ? 'Je account voor de beheeromgeving van '.config('site.name') : 'Wachtwoord opnieuw instellen')
            ->markdown('mail.admin-password-link', [
                'name' => $notifiable->name,
                'url' => $url,
                'minutes' => $minutes,
                'invite' => $this->invite,
            ]);
    }
}
