<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_bl extends Model
{
    //
    protected $guarded = ["id"];
    use HasFactory;
    public function articles()
    {
        return $this->belongsTo(Article::class);
    }

    public function commandes()
    {
        return $this->belongsTo(Commande::class, 'command_id');
    }
}
