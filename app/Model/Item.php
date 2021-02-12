<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table='items';

    protected $fillable=[
        'name',
        'description',
        'photo',
        'quantity',
        'price',
        'packaging_type',
        'subcategory_id'
    ];

    function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }

    function orders(){
        return $this->belongsToMany(Order::class,'orders_items');
    }
}
