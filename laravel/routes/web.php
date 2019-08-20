<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use App\Menu;
use App\Regency;
use App\District;
use App\Village;

Route::get('/', function () {
    return view('frontend');
});

Route::get('403/', function () {
    return view('errors.403');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/change_skin', 'HomeController@change_skin');

// AJAX ADMINISTRATIVES DATA
Route::get('/information/create/ajax-regencies',function(Request $request)
{
    $province_id = $request->province_id;
    $regency_id = $request->regency_id;
    $regencies = Regency::where('province_id','=',$province_id)->orderBy('name')->get();
    $listRegencies = '';
    foreach ($regencies as $regency) {
        $selected = $regency->id == $regency_id ? ' selected' : '';
        $listRegencies .= '<option value="'.$regency->id.'"'.$selected.'>'.$regency->name.'</option>';
    }
    return $listRegencies;
});

Route::get('/information/create/ajax-districts',function(Request $request)
{
    $regency_id = $request->regency_id;
    $district_id = $request->district_id;
    $districts = District::where('regency_id','=',$regency_id)->orderBy('name')->get();
    $listDistricts = '';
    foreach ($districts as $district) {
        $selected = $district->id == $district_id ? ' selected' : '';
        $listDistricts .= '<option value="'.$district->id.'"'.$selected.'>'.$district->name.'</option>';
    }
    return $listDistricts;
});

Route::get('/information/create/ajax-villages',function(Request $request)
{
    $district_id = $request->district_id;
    $village_id = $request->village_id;
    $villages = village::select('villages.id', 'villages.name')->where('district_id','=',$district_id)->orderBy('name')->get();
    $listVillages = '';
    foreach ($villages as $village) {
        $selected = $village->id == $village_id ? ' selected' : '';
        $listVillages .= '<option value="'.$village->id.'"'.$selected.'>'.$village->name.'</option>';
    }
    return $listVillages;
});

// MANAGE MENU
Route::get('/menu', 'ConfigurationController@menu')->name('menu');
Route::post('/menu/sort_menu', 'ConfigurationController@sort_menu');
Route::post('/menu/update_menu', 'ConfigurationController@update_menu');
Route::post('/menu/add_menu', 'ConfigurationController@add_menu');
Route::post('/menu/delete_menu', 'ConfigurationController@delete_menu');

// MANAGE GROUP
Route::get('/group', 'ConfigurationController@group')->name('group');
Route::post('/group/fill_menu', 'ConfigurationController@fill_menu');
Route::post('/group/save', 'ConfigurationController@update_menu_group');
Route::post('/group/edit_group', 'ConfigurationController@edit_group');
Route::post('/group/add_group', 'ConfigurationController@add_group');
Route::post('/group/delete_group', 'ConfigurationController@delete_group');

// MANAGE USER
Route::get('/user', 'ConfigurationController@user')->name('user');
Route::post('/user/get_user', 'ConfigurationController@get_user');
Route::post('/user/create', 'ConfigurationController@create_user');
Route::post('/user/delete_user', 'ConfigurationController@delete_user');

// MANAGE PENGATURAN
Route::get('/pengaturan', 'ConfigurationController@setting');
Route::post('/pengaturan/update_pengaturan', 'ConfigurationController@update_setting');
Route::post('/pengaturan/reset_logo', 'ConfigurationController@reset_logo');
Route::post('/pengaturan/update_logo', 'ConfigurationController@update_logo');
Route::post('/pengaturan/reset_poster', 'ConfigurationController@reset_poster');
Route::post('/pengaturan/update_poster', 'ConfigurationController@update_poster');
Route::post('/pengaturan/reset_bg', 'ConfigurationController@reset_bg');
Route::post('/pengaturan/update_bg', 'ConfigurationController@update_bg');

// MANAGE PROFILE
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/profile/photo', 'HomeController@photo_profile');
Route::post('/profile/poster', 'HomeController@poster_profile');
Route::post('/profile/update', 'HomeController@update_profile');
Route::post('/profile/password', 'HomeController@update_password');
Route::post('/profile/address', 'HomeController@get_address');
Route::post('/profile/remove_photo', 'HomeController@remove_photo');
Route::post('/profile/remove_poster', 'HomeController@remove_poster');
Route::post('/profile/add_social', 'HomeController@add_social');
Route::post('/profile/update_social', 'HomeController@update_social');
Route::post('/profile/get_social', 'HomeController@get_social');
Route::post('/profile/remove_social', 'HomeController@remove_social');
Route::post('/profile/add_education', 'HomeController@add_education');
Route::post('/profile/update_education', 'HomeController@update_education');
Route::post('/profile/get_education', 'HomeController@get_education');
Route::post('/profile/remove_education', 'HomeController@remove_education');
Route::post('/profile/add_work', 'HomeController@add_work');
Route::post('/profile/update_work', 'HomeController@update_work');
Route::post('/profile/get_work', 'HomeController@get_work');
Route::post('/profile/remove_work', 'HomeController@remove_work');