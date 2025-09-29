<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Agence;
use App\Models\Poste;
use App\Models\Coupure;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'agence_id', 'created_by'];

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function postes()
    {
        return $this->belongsToMany(Poste::class, 'poste_zone');
    }

    public function coupures()
    {
        return $this->belongsToMany(Coupure::class, 'coupure_zone');
    }
}