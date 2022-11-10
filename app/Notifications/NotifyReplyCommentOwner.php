<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\ReplyComment;
use App\User;

class NotifyReplyCommentOwner extends Notification
{
    use Queueable;

    public $reply_comment;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ReplyComment $reply_comment, User $user)
    {
        $this->reply_comment = $reply_comment;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return ['reply_comment' => $this->reply_comment, 'user' => $this->user->name];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
