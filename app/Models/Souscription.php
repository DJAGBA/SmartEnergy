<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Client;

class Souscription extends Model
{
 use HasFactory;

    protected $fillable = ['client_id', 'canal', 'code_validation', 'valide'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
