<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Cars extends Model
{
    protected $fillable = [
        'brand', 'model', 'VIN','color', 'transmission', 'user_id'
    ];

    public function user () {
        return $this->belongsTo('App\Models\User');
    }


}
