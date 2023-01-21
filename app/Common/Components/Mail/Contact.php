<?php

namespace App\Common\Components\Mail;

use App\Common\Models\User\UserGuest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public string $body;
    public UserGuest $user;

    public function __construct(string $body, UserGuest $user)
    {
        $this->body = $body;
        $this->user = $user;
    }

    public function build(): self
    {
        return $this->subject('Письмо с сайта от ' . $this->user->name ?? '')->view('mail.contact');
    }
}
