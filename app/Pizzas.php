<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pizzas extends Model
{
    protected $table = "pizzas";

    protected $fillable = ['name', 'price'];

    public function ingredients(){
        return $this->hasMany('App\Ingredients','pizza_id');
    }
}
