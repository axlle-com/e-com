<?php

namespace App\Common\Components\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public string $body = '';

    public function __construct(string $message)
    {
        $this->body = $message;
    }

    public function build()
    {
        return $this->view('mail.notify_admin');
    }
}
