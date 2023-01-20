<?php

namespace App\Common\Components\Mail;

use App\Common\Models\User\UserWeb;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActivation extends Mailable
{
    use Queueable, SerializesModels;

    public UserWeb $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserWeb $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Активация аккаунта для пользователя ' . $this->user->first_name ?? '')
                    ->view('mail.account.activation');
    }
}
