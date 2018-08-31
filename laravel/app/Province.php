<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $guarded = [
    	'id'
    ];

    public $timestamps = false;

    public function regency()
    {
        return $this->hasMany('App\Regency');
    }

    public function disricts()
    {
        return $this->hasManyThrough('App\Regency', 'App\District');
    }

    public function villages()
    {
        return $this->hasManyThrough('App\Regency', 'App\District', 'App\Village');
    }
}
