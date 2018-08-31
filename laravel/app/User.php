<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
// use Sofa\Eloquence\Eloquence;

class User extends Authenticatable
{
    // use Eloquence;

    use Notifiable;

    // protected $searchableColumns = ['fullname', 'name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'password_confirmation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function group() {
        return $this->belongsTo('App\Group');
    }

    public function socials() {
        return $this->hasMany('App\Social');
    }

    public function educations() {
        return $this->hasMany('App\Education')->orderBy('year_in', 'desc');
    }

    public function works() {
        return $this->hasMany('App\Work')->orderBy('year_in', 'desc');
    }

    public function village() {
        return $this->belongsTo('App\Village');
    }

    public static function roleCheck($url) {
        $menu = Menu::select('id')->where('url', $url)->first();
        if (empty($menu->id)) {
            return false;
        } else {
            $haveAccess = Role::where('group_id', Auth::User()->group_id)->where('menu_id', $menu->id)->first();
            if (!$haveAccess) {
                return false;
            } else {
                return true;
            }
        }
    }
}
