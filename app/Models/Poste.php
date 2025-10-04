<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poste extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_poste',
        'agence_id',
        'etat',
        'created_by',
    ];

    // Relation many-to-many avec les zones
    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'poste_zone');
    }

    // Relation avec les clients
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    // Relation avec les coupures
    public function coupures()
    {
        return $this->belongsToMany(Coupure::class, 'coupure_poste');
    }

    // Accessor : récupérer la première zone
    public function getFirstZoneAttribute()
    {
        return $this->zones->first();
    }

    // Accessor : récupérer l’agence via la première zone
    public function getAgenceAttribute()
    {
        return $this->first_zone?->agence;
    }
}