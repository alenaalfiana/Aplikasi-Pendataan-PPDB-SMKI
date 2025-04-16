<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Akun PPDB SMKIU Anda Telah Dibuat')
                    ->view('emails.user-credentials')
                    ->with([
                        'name' => $this->userData['name'],
                        'email' => $this->userData['email'],
                        'password' => $this->userData['password'],
                        'verified' => $this->userData['verified'] ?? false,
                    ]);
    }
}
