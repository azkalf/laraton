<?php

// Berisi fungsi yang sering digunakan dalam aplikasi

function roled($url)
{
	return App\User::roleCheck($url);
}

function yesno($key = null)
{
	$yesno = ['yes' => 'Ya', 'no' => 'Tidak'];
	if (!empty($key)) {
		return $yesno[$key];
	}
	return $yesno;
}

function gender($key = null)
{
	$gender = ['m' => 'Laki-laki', 'f' => 'Perempuan'];
	if (!empty($key)) {
		return $gender[$key];
	}
	return $gender;
}

function groups() {
	return App\Group::where('id', '>', Auth::User()->group_id)->pluck('name', 'id')->toArray();
}

function ftext($text)
{
	return ucwords(strtolower($text));
}

function province($code)
{
	return ucwords(strtolower(App\Province::find($code)->name));
}

function regency($code)
{
	return ucwords(strtolower(App\Regency::find($code)->name));
}

function district($code)
{
	return ucwords(strtolower(App\District::find($code)->name));
}

function village($code)
{
	return ucwords(strtolower(App\Village::find($code)->name));
}

function provinces()
{
	return App\Province::pluck('name', 'id')->toArray();
}

function regencies($province_id)
{
	return App\Regency::where('province_id', $province_id)->pluck('name', 'id')->toArray();
}

function districts($regency_id)
{
	return App\District::where('regency_id', $regency_id)->pluck('name', 'id')->toArray();
}

function villages($district_id)
{
	return App\Village::where('district_id', $district_id)->pluck('name', 'id')->toArray();
}

function address($village_id)
{
	$village = App\Village::find($village_id);
	return village($village->id).' Kec. '.district($village->district->id).' '.regency($village->district->regency->id).' '.province($village->district->regency->province->id);
}

function paddress($village_id)
{
	$village = App\Village::find($village_id);
	return regency($village->district->regency->id).', '.province($village->district->regency->province->id);
}

function fdate($date)
{
	setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
	return strftime('%A %d %B %Y', strtotime($date));
}

function validation_errors($errors)
{
    $error_messages = [];
    foreach ($errors->toArray() as $field => $error) {
        $error_messages[] = t($field);
    }
    return 'Terdapat kesalahan pengisian pada kolom '.implode(', ', $error_messages);
}

function t($field)
{
	$columns = [
		'fullname' => 'Nama Lengkap',
		'idcard' => 'NIK',
		'date_birth' => 'Tanggal Lahir',
		'gender' => 'Jenis Kelamin',
		'province_id' => 'Provinsi',
		'regency_id' => 'Kab/Kota',
		'district_id' => 'Kecamatan',
		'village_id' => 'Desa/Kelurahan',
		'province' => 'Provinsi',
		'regency' => 'Kab/Kota',
		'district' => 'Kecamatan',
		'village' => 'Desa/Kelurahan',
		'street' => 'Alamat',
		'photo' => 'Foto',
		'whatsapp' => 'Nomor Whatsapp',
		'phone' => 'Nomor Handphone',
		'scan_idcard' => 'Scan KTP',
		'vote' => 'Coblos',
		'volunteer' => 'Relawan',
	];
	$tcolumn = array_key_exists($field, $columns) ? $columns[$field] : $field;
	return $tcolumn;
}

function check_unique($field, $table, $column)
{
	$check = DB::table($table)->where($column, $field)->first();
	return $check ? true : false;
}

function print_menu($menu)
{
    if ((isset($menu['items']) && count($menu['items']))) {
        echo '<ul class="ml-menu">';
        foreach ($menu['items'] as $items) {
            $toggled = child_active($items) ? ' toggled' : '';
            $treeview = (isset($items['items']) && count($items['items'])) ? ' class="menu-toggle'.$toggled.'"' : '';
            $url = (isset($items['items']) && count($items['items'])) ? '#' : $items['url'];
            $active = (request()->is($items['url']) || request()->is($items['url'].'/*')) ? ' class="active"' : '';
            echo '<li'.$active.'><a href="'.$url.'"'.$treeview.'><i class="material-icons">'.$items['icon'].'</i><span>'.$items['title'].'</span></a>';
            print_menu($items);
        }
        echo '</ul>';
    }
}

function child_active($menu)
{
    if ((isset($menu['items']) && count($menu['items']))) {
        foreach ($menu['items'] as $items) {
        	if (request()->is($items['url'])) {
        		return true;
        	}
        }
    }
    return false;
}

function list_menu($menu)
{
    if ((isset($menu['items']) && count($menu['items']))) {
        echo '<ol class="dd-list">';
        foreach ($menu['items'] as $items) {
			echo '<li class="dd-item dd3-item" data-id="'.$items['id'].'">
				<div class="dd-handle dd3-handle"></div>
				<div class="dd3-content"><a href="#" class="menulist" onclick="edit(this)" id="menu'.$items['id'].'" data-id="'.$items['id'].'" data-title="'.$items['title'].'" data-url="'.$items['url'].'" data-icon="'.$items['icon'].'"><i class="material-icons pull-left">'.$items['icon'].'</i>&nbsp;&nbsp;'.$items['title'].'</a><a href="#" onclick="delete_menu(this)" class="pull-right" data-id="'.$items['id'].'" data-title="'.$items['title'].'">(hapus)</a></div>
			</li>';
            list_menu($items);
        }
        echo '</ol>';
    }
}

function sort_menu($menu)
{
	if (isset($menu->children) && count($menu->children)) {
		$order = 0;
		foreach ($menu->children as $list) {
			$children = App\Menu::find($list->id);
			$children->order = $order;
			$children->parent = $menu->id;
			$children->save();
			$order++;
			sort_menu($list);
		}
	}
}

function list_menu_box($menu, $level)
{
	$level++;
    if ((isset($menu['items']) && count($menu['items']))) {
		foreach ($menu['items'] as $items) {
            echo '<input type="checkbox" id="menu'.$items['id'].'" class="chk-col-green filled-in checkbox-group" value='.$items['id'].' name="menu"/>
            	<label for="menu'.$items['id'].'" class="checkbox_menu level'.$level.'">'.$items['title'].'</label>';
            list_menu_box($items, $level);
		}
	}
}

function protected_menu($menu)
{
	$menus = [1,2,3,4,5];
	if (in_array($menu, $menus))
		return true;
	return false;
}

function protected_group($group)
{
	$groups = [1,2,3];
	if (in_array($group, $groups))
		return true;
	return false;
}

function protected_user($user)
{
	$users = [1,2,3,4];
	if (in_array($user, $users))
		return true;
	return false;
}

function education_levels($level = null)
{
    $levels = [
    	's3' => 'Doktor (S3)',
    	's2' => 'Magister (S2)',
    	's1' => 'Sarjana (S1)',
    	'd4' => 'Diploma (D4)',
    	'd3' => 'Diploma (D3)',
    	'd2' => 'Diploma (D2)',
    	'd1' => 'Diploma (D1)',
    	'sma' => 'SMU/MA/Sederajat',
    	'smp' => 'SMP/MTs/Sederajat',
    	'sd' => 'SD/MI/Sederajat',
    	'tk' => 'TK/RA/Sederajat',
    ];
    if ($level)
    	return $levels[$level];
    return $levels;
}

function skins()
{
	return array(
		"red"=>"Red",
        "pink"=>"Pink",
        "purple"=>"Purple",
        "deep-purple"=>"Deep Purple",
        "indigo"=>"Indigo",
        "blue"=>"Blue",
        "light-blue"=>"Light Blue",
        "cyan"=>"Cyan",
        "teal"=>"Teal",
        "green"=>"Green",
        "light-green"=>"Light Green",
        "lime"=>"Lime",
        "yellow"=>"Yellow",
        "amber"=>"Amber",
        "orange"=>"Orange",
        "deep-orange"=>"Deep Orange",
        "brown"=>"Brown",
        "grey"=>"Grey",
        "blue-grey"=>"Blue Grey",
        "black"=>"Black",
	);
}