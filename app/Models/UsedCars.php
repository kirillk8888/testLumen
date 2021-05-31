<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class UsedCars extends Model
{
    protected $fillable = [
        'dataStart', 'dataEnd', 'user_id','car_id'
    ];

    public function user_cars () {
        return $this->hasOne('App\Models\Cars', 'user_id');
        return $this->hasOne('App\Models\User', 'user_id');
    }


}
