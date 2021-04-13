<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_id, $hash)
    {
        $this->url = URL::temporarySignedRoute(
            'order.verify',
            Carbon::now()->addMinutes(Config::get('verification_expire_time', 60)),
            [
                'id' => $order_id,
                'hash' => $hash
            ]
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Config::get('mail.teacher_email'))
        ->subject('Potvrzení objednávky')
        ->view('emails.reservation.confirmation');
    }
}
