<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable =[
        'total',
        'user_id'
    ];
    protected $table='orders';

    function items(){
        return $this->belongsToMany(Item::class,'orders_items')->withPivot(['quantity'])->withTimestamps();
    }

    function user(){
        return $this->belongsTo(User::class);
    }


}
