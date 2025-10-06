<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use App\Models\Coupure;

class CoupurePlanifieeNotification extends Notification
{
    public function __construct(public Coupure $coupure) {}

   public function via($notifiable)
{
    $canaux = json_decode($notifiable->canal_preferé, true);

    // Si le champ est vide, mal formé ou non-array → fallback
    if (!is_array($canaux) || empty($canaux)) {
        return ['mail'];
    }

    // Filtrer les canaux supportés uniquement
    $canauxValides = array_intersect($canaux, ['mail', 'vonage']);

    // Si aucun canal valide → fallback
    if (empty($canauxValides)) {
        return ['mail'];
    }

    return $canauxValides;
}



   public function toMail($notifiable)
{
    \Log::info('Notification email générée pour : ' . $notifiable->email);

    return (new MailMessage)
        ->subject('Nouvelle coupure planifiée')
        ->greeting('Bonjour ' . $notifiable->nom)
        ->line('Une coupure a été planifiée dans votre zone.')
        ->line('Zone : ' . optional($this->coupure->zone)->nom)
        ->line('Début : ' . optional($this->coupure->date_debut)->format('d/m/Y H:i'))
        ->line('Fin : ' . optional($this->coupure->date_fin)->format('d/m/Y H:i'))
        ->line('Motif : ' . $this->coupure->motif)
        ->action('Voir les détails', url('/coupures/' . $this->coupure->id))
        ->line('Merci de votre compréhension.');
}


    // public function toVonage($notifiable)
    // {
    //     return (new VonageMessage)
    //         ->content('Coupure prévue dans votre zone ' .
    //                   optional($this->coupure->zone)->nom .
    //                   ' de ' . optional($this->coupure->date_debut)->format('d/m/Y H:i') .
    //                   ' à ' . optional($this->coupure->date_fin)->format('d/m/Y H:i') .
    //                   '. Motif : ' . $this->coupure->motif);
    // }

    public function toArray($notifiable)
    {
        return [
            'zone' => optional($this->coupure->zone)->nom,
            'debut' => optional($this->coupure->date_debut)->format('d/m/Y H:i'),
            'fin' => optional($this->coupure->date_fin)->format('d/m/Y H:i'),
            'motif' => $this->coupure->motif,
        ];
    }
}