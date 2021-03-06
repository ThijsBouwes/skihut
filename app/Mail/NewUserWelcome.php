<?php

namespace App\Mail;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserWelcome extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, SendGrid;

    public $user;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        // Generate a new reset password token
        $token = app('auth.password.broker')->createToken($user);

        $this->url = url(config('app.url').route('password.reset', ['token' => $token, 'email' => $user->email], false));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->addTracking(get_class(), $this->user);

        return $this->subject(sprintf('%s Welcome 👋🏼', $this->user->name))
                    ->markdown('emails.users.welcome');
    }
}
