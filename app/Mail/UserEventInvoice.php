<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $events;
    public $url;
    public $giphy_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $events)
    {
        $this->user = $user;
        $this->events = $events;

        if ($user->last_login === null) {
            // Generate a new reset password token
            $token = app('auth.password.broker')->createToken($user);
            $this->url = url(config('app.url').route('password.reset', ['token' => $token, 'email' => $user->email], false));
        } else {
            $this->url = url(config('app.url'), false);
        }

        $giphys = [
            'https://media.giphy.com/media/xaPhIclaKuBz2/giphy.gif',
            'https://media.giphy.com/media/z2R9CvTLQ2lcQ/giphy.gif',
            'https://media.giphy.com/media/3o8doUeyrZAinxcGBi/giphy.gif',
            'https://media.giphy.com/media/xTk9ZYCKvrTDDcSfKM/giphy.gif'
        ];

        $this->giphy_url = $giphys[array_rand($giphys)];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(sprintf('%s invoice 💲', $this->user->name))
            ->markdown('emails.users.invoice');
    }
}
