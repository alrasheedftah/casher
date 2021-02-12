<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Purches extends Model
{
    protected $table='purches';

    protected $fillable=[
        'total_price',
        'date_price',
        'image'
    ];

    function components(){
        return $this->belongsToMany(Component::class,'components_purches');
    }
}
