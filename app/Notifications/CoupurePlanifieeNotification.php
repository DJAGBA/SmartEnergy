<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Coupure;

class CoupurePlanifieeNotification extends Notification
{
    public function __construct(public Coupure $coupure) {}

    public function via($notifiable)
    {
        return ['mail']; // ✅ Twilio désactivé ici
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle coupure planifiée')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Une coupure a été planifiée.')
            ->line('Zone : ' . optional($this->coupure->zone)->nom)
            ->line('Début : ' . $this->coupure->date_debut->format('d/m/Y H:i'))
            ->line('Fin : ' . $this->coupure->date_fin->format('d/m/Y H:i'))
            ->action('Voir les détails', url('/coupures/' . $this->coupure->id));
    }
}