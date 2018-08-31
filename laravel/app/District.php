<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [
    	'id'
    ];

    public $timestamps = false;

    public function regency() {
        return $this->belongsTo('App\Regency');
    }

    public function province() {
        return $this->belongsTo('App\Province');
    }

    public function villages()
    {
        return $this->hasMany('App\Village');
    }
}
