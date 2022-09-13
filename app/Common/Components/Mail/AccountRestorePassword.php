<?php

namespace App\Common\Components\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Common\Models\User\User;
use Illuminate\Queue\SerializesModels;

class AccountRestorePassword extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
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
        return $this->subject('Восстановление пароля для пользователя ' . $this->user->first_name ?? '')->view('mail.account.restore_password');
    }
}
