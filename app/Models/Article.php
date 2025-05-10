<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function familles()
    {
        return $this->belongsTo(Famille::class);
    }

    public function marques()
    {
        return $this->belongsTo(Marque::class);
    }

    public function unites()
    {
        return $this->belongsTo(Unite::class);
    }
    public function details()
    {
        return $this->hasMany(Detail_bl::class);
    }

}
