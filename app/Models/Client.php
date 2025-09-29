<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Agence;
use App\Models\Poste;
use App\Models\Souscription;
use App\Models\Notification;

class Client extends Model
{
    use HasFactory;

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
}
