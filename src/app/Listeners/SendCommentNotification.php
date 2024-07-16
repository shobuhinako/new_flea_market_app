<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommentPosted  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        $comment = $event->comment;
        $item = $comment->item;

        // 出品者と購入者に通知を送信
        $seller = $item->user;
        $buyer = $comment->transaction->user;

        $seller->notify(new CommentNotification($comment));
        $buyer->notify(new CommentNotification($comment));
    }
}
