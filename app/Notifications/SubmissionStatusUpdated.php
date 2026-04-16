<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionStatusUpdated extends Notification
{
    use Queueable;

    protected $submission;
    protected $oldStatus;
    protected $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct($submission, $oldStatus, $newStatus)
    {
        $this->submission = $submission;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'no_registrasi' => $this->submission->no_registrasi,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Status permohonan " . $this->submission->no_registrasi . " telah diubah dari " . ($this->oldStatus ?? '-') . " menjadi " . $this->newStatus . ".",
        ];
    }
}
