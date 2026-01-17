<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationCreated extends Notification
{
    use Queueable;

    protected $reservation;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        $reservation,
        $user,
    ) {
        $this->reservation = $reservation;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from($this->user->email, $this->user->name)
            ->subject('New Reservation Created')
            ->line('A new reservation has been created.')
            ->line('Reservation Details:')
            ->line('Time Start: ' . $this->reservation->time_start)
            ->line('Time End: ' . $this->reservation->time_end);
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
            //
        ];
    }
}
