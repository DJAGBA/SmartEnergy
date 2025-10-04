<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PosteProblemeNotification extends Notification
{
    use Queueable;
public $message;
public $posteId;

public function __construct($message, $posteId)
{
    $this->message = $message;
    $this->posteId = $posteId;
}

public function via($notifiable)
{
    return ['database'];
}

public function toDatabase($notifiable)
{
    return [
        'message' => $this->message,
        'poste_id' => $this->posteId,
    ];
}
}