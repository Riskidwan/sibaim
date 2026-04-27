<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionReceived extends Notification
{
    use Queueable;

    protected $submission;

    /**
     * Create a new notification instance.
     */
    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Konfirmasi Permohonan PSU - ' . $this->submission->no_registrasi)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Terima kasih telah mengajukan permohonan PSU melalui SIBAIM.')
            ->line('Permohonan Anda telah kami terima dengan detail sebagai berikut:')
            ->line('**Nomor Registrasi:** ' . $this->submission->no_registrasi)
            ->line('**Lokasi:** ' . $this->submission->lokasi_pembangunan)
            ->line('**Status:** Verifikasi Dokumen')
            ->line('Tim kami akan segera memproses berkas Anda. Anda akan menerima notifikasi email kembali jika terdapat pembaruan status.')
            ->line('Terima kasih.');
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
            'title' => 'Permohonan Terkirim',
            'type' => 'submission',
            'message' => "Permohonan PSU baru (" . $this->submission->no_registrasi . ") berhasil dikirim dan sedang dalam verifikasi.",
        ];
    }
}
