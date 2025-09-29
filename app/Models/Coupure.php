<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Zone;
use App\Models\Poste;
use App\Models\Notification;

class Coupure extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'etat',
        'date_debut',
        'date_fin',
        'duree_prevue',
        'motif',
        'priorite',
        'gestionnaire_id',
        'zone_id',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function postes()
    {
        return $this->belongsToMany(Poste::class, 'coupure_poste');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}