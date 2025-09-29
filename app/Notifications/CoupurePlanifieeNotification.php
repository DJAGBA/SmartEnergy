<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Coupure;
use NotificationChannels\Twilio\TwilioSmsMessage;



class CoupurePlanifieeNotification extends Notification
{
    public function __construct(public Coupure $coupure) {}

    public function via($notifiable)
    {
        return ['mail', 'vonage']; // ou ['mail', 'sms'] selon ton canal
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

    public function via($notifiable)
{
    return ['twilio']; // ou ['mail', 'twilio'] si tu veux les deux
}

public function toTwilio($notifiable)
{
    return (new TwilioSmsMessage())
        ->content("📢 Coupure planifiée : {$this->coupure->motif} du {$this->coupure->date_debut->format('d/m/Y H:i')} au {$this->coupure->date_fin->format('d/m/Y H:i')}.");
}

    
}

