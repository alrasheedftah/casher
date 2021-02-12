<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{

    protected $table='subcategories';

    protected $primarykey='id';

    protected $fillable=[
        'name',
        'description',
        'icon',
        'category_id',

    ];

    function category(){
        return $this->belongsTo(Category::class);
    }

    function items(){
        return $this->hasMany(Subcategory::class);
    }

}
