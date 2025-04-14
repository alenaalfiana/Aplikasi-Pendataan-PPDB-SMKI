<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\FormPendaftaran;
use Illuminate\Support\Collection;

class SurveyorAssignmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $students;
    protected $periode;

    /**
     * Create a new notification instance.
     *
     * @param Collection $students
     * @param mixed $periode
     * @return void
     */
    public function __construct(Collection $students, $periode)
    {
        $this->students = $students;
        $this->periode = $periode;
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
            ->subject('Penugasan Survei Siswa Baru')
            ->view('emails.surveyor-assignment', [
                'surveyor' => $notifiable,
                'students' => $this->students,
                'periode' => $this->periode
            ]);
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
            'students' => $this->students,
            'periode' => $this->periode
        ];
    }
}