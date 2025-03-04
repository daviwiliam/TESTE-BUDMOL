<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class SubscriptionConfirmation extends Mailable
{
    public $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    public function build()
    {
        return $this->subject('Confirmação de Inscrição')
                    ->view('emails.subscription_confirmation')
                    ->with([
                        'subscription' => $this->subscription,
                    ]);
    }
}
