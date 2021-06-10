<?php

namespace App\Notifications;

use App\LoggableMailMessage;
use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class TicketRespondedTo extends Notification
{
    use Queueable;

    private Ticket $ticket;
    private TicketResponse $ticketResponse;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, TicketResponse $ticketResponse)
    {
        $this->ticket = $ticket;
        $this->ticketResponse = $ticketResponse;
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


    public function toMail($notifiable): MailMessage
    {
        return (new LoggableMailMessage)
            ->subject('[#'.$this->ticket->id.'] '. $this->ticket->subject .' - ticket has been responded to')
            ->bccIf(!is_null(config('app.defaults.bcc.email')), config('app.defaults.bcc.email'), config('app.defaults.bcc.name'))
            ->greeting('Hello ' . $notifiable->name)
            ->line(new HtmlString('<small>--Please do not reply to this email as this is a system generated message--</small>'))
            ->line('Response:')
            ->line(new HtmlString($this->ticketResponse->content))
            ->line('NOTE: If you wish to view this ticket progress online or reply with additional information regarding this ticket, click "View Ticket" below')
            ->action('View Ticket', route('tickets.show', $this->ticket->id))
            ->line(new HtmlString('<small>You are receiving this message because you either created a ticket on our helpdesk system or have subscribed to notifications for a ticket created by one of your colleagues!</small>'));
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content("Alpha IT Centre Helpdesk: " . '[#'.$this->ticket->id.'] '. $this->ticket->subject .' - ticket has been responded to');
    }
}
