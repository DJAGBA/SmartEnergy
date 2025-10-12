<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Client;
use App\Models\Coupure;


class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'coupure_id', 'type', 'envoyée', 'date_envoi', 'data', 'read_at', 'notifiable_id', 'notifiable_type'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function coupure()
    {
        return $this->belongsTo(Coupure::class);
    }
protected $keyType = 'string';
public $incrementing = false;

}
