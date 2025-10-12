<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Poste;

class PanneSignaléeNotification extends Notification
{
    public $poste;
    public $message;

    public function __construct(Poste $poste, $message = null)
    {
        $this->poste = $poste;
        $this->message = $message;
    }

   public function via($notifiable)
{
    return ['database'];
}

public function toDatabase($notifiable)
{
    return [
        'poste_id' => $this->poste->id,
        'code_poste' => $this->poste->code_poste,
        'zone' => $this->poste->zone ? $this->poste->zone->nom : 'Zone inconnue',
        'message' => $this->message,
        'url' => route('postes.show', $this->poste->id),
        'signalé_par' => 'Gestionnaire',
        'created_at' => now(),
    ];
}
    
public function uniqueId()
{
    return null;
}

public function id()
{
    return null;
}

}