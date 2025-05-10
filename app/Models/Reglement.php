<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reglement extends Model
{

    protected $guarded = ["id"];
    use HasFactory;

    public function modeReglement()
    {
        return $this->belongsTo(Mode_Reglement::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
