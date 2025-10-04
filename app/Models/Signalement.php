<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    protected $fillable = [
        'poste_id',
        'gestionnaire_id',
        'message',
        'etat',
    ];

    public function poste()
    {
        return $this->belongsTo(Poste::class);
    }

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }
}
