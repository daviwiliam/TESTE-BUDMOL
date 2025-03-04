<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class SubscriptionCancellation extends Mailable
{
    public $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    public function build()
    {
        return $this->subject('Cancelamento de Inscrição')
                    ->view('emails.subscription_cancellation')
                    ->with([
                        'subscription' => $this->subscription,
                    ]);
    }
}
