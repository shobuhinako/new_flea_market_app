<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Item;

class BankTransferInfo extends Mailable
{
    use Queueable, SerializesModels;

    public $item;
    public $discountedPrice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Item $item, $discountedPrice)
    {
        $this->item = $item;
        $this->discountedPrice = $discountedPrice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.bank-transfer')
                    ->subject('振込先情報')
                    ->with([
                        'itemName' => $this->item->name,
                        'itemPrice' => $this->discountedPrice,
                    ]);
    }
}
