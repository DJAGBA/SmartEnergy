<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable; // ← nécessaire pour les notifications
use App\Models\Agence;
use App\Models\Poste;
use App\Models\Souscription;
use App\Models\Notification;

class Client extends Model
{
    use HasFactory, Notifiable; // ← ajoute Notifiable

    protected $fillable = ['nom', 'reference', 'email', 'telephone', 'agence_id', 'poste_id', 'canal_preferé'];

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class);
    }

    public function souscription()
    {
        return $this->hasOne(Souscription::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // ✅ Méthode requise pour Twilio
    public function routeNotificationForTwilio()
    {
        return $this->telephone; // doit contenir un numéro au format international
    }

    public function zone()
{
    return $this->belongsTo(Zone::class);
}
}