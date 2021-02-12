<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='categories';

    protected $fillable=[
        'name',
        'description',
        'icon'
    ];

    function subcategories(){
        return $this->hasMany(Subcategory::class);
    }

}
