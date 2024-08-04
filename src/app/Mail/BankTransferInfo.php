<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Item;
// use App\Models\SoldItem;

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

        // $soldItem = SoldItem::where('item_id', $item->id)
        //                     ->where('user_id', auth()->id())
        //                     ->first();

        // if ($couponId) {
        //     $discountedPrice = $discountedPrice;
        // } else {
        //     $discountedPrice = $item->price;
        // }
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
                        // 'itemPrice' => $this->item->price,
                        'itemPrice' => $this->discountedPrice,

                    ]);
    }
}
