<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    protected $table = "ingredients";

    protected $fillable = ['name', 'pizza_id', 'price'];

    public function pizza(){
        return $this->belongsTo('App\Pizzas');
    }
}
