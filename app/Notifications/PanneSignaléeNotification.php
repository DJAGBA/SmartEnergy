<?php

namespace App\Notifications;

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class PanneSignaléeNotification extends Notification
{
    public $poste;
    public $message;

    public function __construct($poste, $message = null)
    {
        $this->poste = $poste;
        $this->message = $message;
    }

    // On utilise uniquement la base de données
    public function via($notifiable)
    {
        return ['database'];
    }

    // Ce qui sera enregistré dans la table notifications
    public function toDatabase($notifiable)
    {
        return [
            'poste_id' => $this->poste->id,
            'code_poste' => $this->poste->code_poste,
            'zone' => $this->poste->zones->pluck('nom')->join(', '),
            'message' => $this->message,
            'url' => route('postes.show', $this->poste->id),
            'signalé_par' => auth()->user()->name ?? 'Un gestionnaire',
            'created_at' => now(),
        ];
    }
}

