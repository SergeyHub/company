<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Entity\Girl\Girl;

class FailedVerification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var string */
    private $reason;

    private $girl;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Girl $girl, $reason)
    {
        $this->reason = $reason;
        $this->girl = $girl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $reason = gettype($this->reason) == 'array' ? $this->reason['en'] : $this->reason;

        return (new MailMessage)
            ->subject('Failed profile verification')
            ->line('You are not verified.')
            ->line('Reason: ' . $reason)
            ->action('Go to site', url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'reason' => $this->reason,
            'girl_id' => $this->girl->id,
            'type' => $this->broadcastType()
        ];
    }

    public function broadcastType()
    {
        return 'girls.failed_verification';
    }
}
