<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $guarded = [
    	'id'
    ];

    public $timestamps = false;

    protected $keyType = 'double';

    public function district() {
        return $this->belongsTo('App\District');
    }
}
