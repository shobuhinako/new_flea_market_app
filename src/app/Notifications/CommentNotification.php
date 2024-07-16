<?php

namespace App\Notifications;

use App\Models\TransactionComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TransactionComment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $comment = $this->comment;
        $url = route('show.login');

        return (new MailMessage)
                    ->line('新しいコメントがあります')
                    ->line($comment->content)
                    ->action('コメントを確認する', $url)
                    ->line('取引状況確認ページに移動して、詳細をご確認ください。');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $data = [
            'comment_id' => $this->comment->id,
            'item_id' => $this->comment->item_id,
            'transaction_id' => $this->comment->transaction_id,
            'content' => $this->comment->content,
        ];

        return $data;
    }
}
