<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table='components';
    protected $fillable=[
        'name',
        'description',
        'packaging_type',
        'quantity',
        'icon',
    ];

    function purches(){
        return $this->belongsToMany(Purches::class,'components_purches');
    }
}
