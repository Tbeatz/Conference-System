<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReviewerNotification extends Notification
{
    use Queueable;

    protected $submission;

    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    public function via($notifiable)
    {
        // Can use mail, database, broadcast, etc.
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Submission Assigned')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new conference submission has been assigned to you for review.')
            ->action('View Submission', url('/conference-submissions/' . $this->submission->id))
            ->line('Thank you for your contribution!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'submission_id' => $this->submission->id,
            'title' => $this->submission->topic,
            'message' => 'A new paper has been assigned to you.',
        ];
    }
}
