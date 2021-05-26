<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use PHPUnit\TextUI\XmlConfiguration\Logging\TestDox\Html;

class TicketCreated extends Notification
{
    use Queueable;


    private Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (!is_null($notifiable->phone_verified_at)) {
            return $notifiable->comms_preference;
        }

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
            ->subject('[#'.$this->ticket->id.'] '. $this->ticket->subject .' - ticket has been created')
            ->greeting('Hello ' . $notifiable->name)
            ->line(new HtmlString('<small>--Please do not reply to this email as this is a system generated message--</small>'))
            ->line('Content: '. new HtmlString($this->ticket->content))
            ->line('NOTE: If you wish to view this ticket progress online or reply with additional information regarding this ticket, click "View Ticket" below')
            ->action('View Ticket', route('tickets.show', $this->ticket->id))
            ->line(new HtmlString('<small>You are receiving this message because you are a technical support agent on the Alpha IT Centre Helpdesk system!</small>'));

    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content("Alpha IT Centre Helpdesk: " . '[#'.$this->ticket->id.'] '. $this->ticket->subject .' - ticket has been created');
    }
}
