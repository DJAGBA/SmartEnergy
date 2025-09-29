<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicienNotification extends Model
{
    protected $fillable = ['technicien_id', 'poste_id', 'message', 'lu'];

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class);
    }
}