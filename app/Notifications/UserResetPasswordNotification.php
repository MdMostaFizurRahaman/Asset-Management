<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserResetPasswordNotification extends Notification {

    public $token;
    public $subdomain;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subdomain, $token) {
        $this->token = $token;
        $this->subdomain = $subdomain;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
                ->subject('Asset Management : Password Reset')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->markdown('client.passwords.reset-email', ['subdomain'=>$this->subdomain, 'token' => $this->token]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
                //
        ];
    }

}
