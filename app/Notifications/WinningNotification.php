<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WinningNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $bettingLog;
    public function __construct($bettingLog)
    {
        $this->bettingLog = $bettingLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $winning_amount = $this->bettingLog->winning_amount;
        $title = $this->bettingLog->title;
        return [
            'content' => 'ဂုဏ်ယူပါတယ်! '.$title.' Section မှ ဆုကြေးငွေ '. number_format($winning_amount) .' Ks ကိုရရှိပါတယ်။',
            'winning_amount' => $winning_amount,
            'title' => $title,
            'id' => $this->bettingLog->id,
        ];
    }
}
