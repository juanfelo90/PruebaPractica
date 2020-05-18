<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table = 'tienda';
    //protected $primaryKey = 'id';
 //

    public function Productos()
    {
        return $this->hasMany('App\Tienda');
    }
}
