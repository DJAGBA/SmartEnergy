<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Zone;
use App\Models\Client;

class Agence extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'localisation'];

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}