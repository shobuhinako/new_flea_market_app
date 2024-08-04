<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CouponCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $coupon;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('クーポン発行のお知らせ')
                    ->view('emails.coupon-created')
                    ->with([
                        'couponCode' => $this->coupon->code,
                        'discount' => $this->coupon->discount,
                        'expiresAt' => $this->coupon->expires_at,
                    ]);
    }
}
