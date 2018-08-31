<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $guarded = [
    	'id'
    ];

    public $timestamps = false;

    public function province() {
        return $this->belongsTo('App\Province');
    }

    public function districts()
    {
        return $this->hasMany('App\District');
    }

    public function villages()
    {
        return $this->hasManyThrough('App\District', 'App\Village');
    }
}
