<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosteProblemeIntNotification extends Notification
{
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

    public function id()
    {
        // Génère un entier aléatoire entre 100000 et 999999
        return random_int(100000, 999999);
    }
}