<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProjectMessage extends Notification
{
    use Queueable;

    /**
     * The project instance.
     *
     * @var mixed
     */
    protected $project;

    /**
     * Create a new notification instance.
     *
     * @param mixed $project
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database', 'mail']; // ou apenas 'database' para notificação interna
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Nova mensagem no projeto: ' . $this->project->title,
            'link' => route('projects.messages.store', $this->project)
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
