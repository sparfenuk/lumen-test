<?php

namespace App\Notification;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ResetPasswordNotification extends Notification
{

    protected $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return void
     */
    public function toMail($notifiable)
    {
        return Mail::send('emails.password_reset', ['token' => $this->token], function ($m) use ($notifiable) {
            $m->to($notifiable->email)->subject('Reset Password');
        });
    }
}
