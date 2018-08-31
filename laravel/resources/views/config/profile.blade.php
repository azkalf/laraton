@extends('layouts.adminbsb')
@section('title', 'PROFILE')

@section('content')
<?php
    $photo = !empty($profile->photo) ? $profile->photo : ($profile->gender == 'm' ? 'ikhwan.png' : 'akhwat.png');
    $poster = !empty($profile->poster) ? $profile->poster : 'poster.jpg';
    $address = !empty($profile->village_id) ? paddress($profile->village_id) : $profile->address;
?>
<div class="row clearfix">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <!-- MAIN PROFILE -->
        <div class="card">
            <div class="header">
                <h2>
                    {{ strtoupper($profile->fullname) }}
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#password-edit">Ganti password</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-xs-12 m-b-0">
                        <form id="uploadphoto" method="post" enctype="multipart/form-data">
                            <img src="{{ asset('uploads/images/users/'.$photo) }}" class="img-responsive thumbnail" id="profile_photo" style="width: 100%; cursor: pointer;" data-toggle="modal" data-target="#photo-update">
                            <input type="file" name="photo" id="photo" required style="display: none;" />
                        </form>
                        <div class="profile-info">
                            <i class="icon fas fa-user col-black"></i><span id="p-name">{{ $profile->name }}</span><br>
                            <i class="icon fas fa-map-marker-alt col-cyan"></i><span id="p-address">{{ $address }}</span><br>
                            <i class="icon fas fa-envelope col-pink"></i><span id="p-email">{{ $profile->email }}</span><br>
                            <i class="icon fas fa-mobile col-orange"></i><span id="p-phone">{{ $profile->phone }}</span><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SOCIAL MEDIA -->
        <div class="card">
            <div class="header">
                <h2>
                    SOCIAL MEDIA
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#social-input" onclick="reset_social();">Tambah Social Media</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <table width="100%" id="social-table">
                @if(count($profile->socials) > 0)
                @foreach($profile->socials as $social)
                    <tr data-id="{{ $social->id }}">
                        <td width="45"><a href="{{ $social->link }}" target="_blank"><span class="{{ $social->icon }} socicon-icon" style="background-color: {{ $social->color }};"></span></a></td>
                        <td><a href="{{ $social->link }}" target="_blank">{{ $social->name }}</a></td>
                        <td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_social('{{ $social->id }}');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_social('{{ $social->id }}')"><i class="fa fa-trash"></i></a></td>
                    </tr>
                @endforeach
                @else
                    <tr data-id="empty"><td align="center"><i>Tidak ada data.</i></td></tr>
                @endif
                </table>
            </div>
        </div>
        <!-- POSTER -->
        <div class="card">
            <div class="header">
                <h2>
                    POSTER
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-xs-12 m-b-0">
                        <form id="uploadposter" method="post" enctype="multipart/form-data">
                            <img src="{{ asset('uploads/images/posters/'.$poster) }}" class="img-responsive thumbnail" id="poster_image" style="width: 100%; cursor: pointer;" data-toggle="modal" data-target="#poster-update">
                            <input type="file" name="poster" id="poster" required style="display: none;" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-6 col-xs-12">
        <!-- USER INFO -->
        <div class="card">
            <div class="header">
                <h2>
                    DATA PRIBADI
                </h2>
            </div>
            <div class="body table-responsive">
                <table class="table table-hover table-bordered table-striped" id="profile-table">
                    <tbody>
                        <tr>
                            <th width="180">Nama User</th>
                            <td data-column="name">{{ $profile->name }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td data-column="fullname">{{ $profile->fullname }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td data-editable="false" data-toggle="modal" data-target="#gender-edit" id="gender-column">{{ gender($profile->gender) }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td data-column="email">{{ $profile->email }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td data-column="phone">{{ $profile->phone }}</td>
                        </tr>
                        <tr>
                            <th>Tempat Tanggal Lahir</th>
                            <td data-editable="false" data-toggle="modal" data-target="#birth-edit" id="birth-column">{{ $profile->birthplace.', '.fdate($profile->birthdate) }}</td>
                        </tr>
                        <tr>
                            <?php $address = !empty($profile->village_id) ? address($profile->village_id) : ''; ?>
                            <th>Alamat</th>
                            <td data-editable="false" data-toggle="modal" data-target="#address-edit" id="address-column">{{ $profile->address.' '.$address.' '.$profile->postcode }}</td>
                        </tr>
                        <tr>
                            <th>Tentang Pribadi</th>
                            <td data-column="about">{!! $profile->about !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- EDUCATION INFO -->
        <div class="card">
            <div class="header">
                <h2>
                    RIWAYAT PENDIDIKAN
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#education-input" onclick="reset_education();">Tambah Riwayat Pendidikan</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <table width="100%" id="education-table">
                @if(count($profile->educations) > 0)
                @foreach($profile->educations as $school)
                    <?php 
                    $years = !empty($school->year_out) ? $school->year_in.' - '.$school->year_out : ($school->current == 'yes' ? $school->year_in.' - Sekarang' : $school->year_in);
                    $majors = !empty($school->majors) ? ' Jurusan '.$school->majors : '';
                    ?>
                    <tr data-id="{{ $school->id }}" valign="top">
                        <td width="120"><strong>{{ $years }}</strong></td>
                        <td><strong>{{ $school->name }}</strong><br><small>Tingkat {{ education_levels($school->level).$majors }}</small><br><small>di {{ $school->place }}</small></td>
                        <td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_education('{{ $school->id }}');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_education('{{ $school->id }}')"><i class="fa fa-trash"></i></a></td>
                    </tr>
                @endforeach
                @else
                    <tr data-id="empty"><td align="center"><i>Tidak ada data.</i></td></tr>
                @endif
                </table>
            </div>
        </div>
        <!-- WORK INFO -->
        <div class="card">
            <div class="header">
                <h2>
                    RIWAYAT PEKERJAAN
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#work-input" onclick="reset_work();">Tambah Riwayat Pekerjaan</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <table width="100%" id="work-table">
                @if(count($profile->works) > 0)
                @foreach($profile->works as $work)
                    <?php 
                    $years = !empty($work->year_out) ? $work->year_in.' - '.$work->year_out : ($work->current == 'yes' ? $work->year_in.' - Sekarang' : $work->year_in);
                    $name = !empty($work->office) ? $work->office : $work->name;
                    $position = !empty($work->position) ? '<br><small>Sebagai '.$work->position.'</small>' : '';
                    ?>
                    <tr data-id="{{ $work->id }}" valign="top">
                        <td width="120"><strong>{{ $years }}</strong></td>
                        <td><strong>{{ $name }}</strong>{!! $position !!}<br><small>di {{ $work->place }}</small></td>
                        <td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_work('{{ $work->id }}');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_work('{{ $work->id }}')"><i class="fa fa-trash"></i></a></td>
                    </tr>
                @endforeach
                @else
                    <tr data-id="empty"><td align="center"><i>Tidak ada data.</i></td></tr>
                @endif
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============== MODAL DIALOGUE ==================== -->

<!-- cHANGE PASSWORD -->
<div class="modal fade" id="password-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ganti Password</h4>
            </div>
            <div class="modal-body">
                <form id="password-form">
                    <div class="form-group form-float">
                        <div class="form-line warning">
                            <input type="password" id="old_password" class="form-control">
                            <label class="form-label">Password saat ini <span class="col-red">*</span></label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" id="new_password" class="form-control">
                            <label class="form-label">Password baru <span class="col-red">*</span></label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" id="confirm_password" class="form-control">
                            <label class="form-label">Password baru (lagi) <span class="col-red">*</span></label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="changePassword();">SIMPAN</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" onclick="resetFormPassword();">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<!-- CHANGE GENDER -->
<div class="modal fade" id="gender-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Jenis Kelamin</h4>
            </div>
            <div class="modal-body">
                {{ Form::select('gender', ['m'=>'Laki-laki', 'f'=>'Perempuan'], $profile->gender, ['class'=>'form-control show-tick', 'id'=>'gender']) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="changeJK();">SIMPAN</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<!-- CHANGE DATE PLACE BIRTH -->
<div class="modal fade" id="birth-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tempat, Tanggal Lahir</h4>
            </div>
            <div class="modal-body">
                <label class="form-label">Tempat Lahir <span class="col-red">*</span></label>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" id="birthplace" name="birthplace" class="form-control" value="{{ $profile->birthplace }}">
                    </div>
                </div>
                <label class="form-label">Tanggal Lahir <span class="col-red">*</span></label>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="datepicker form-control" id="birthdate" placeholder="Please choose a date..." value="{{ fdate($profile->birthdate) }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="changeBirth();">SIMPAN</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<!-- CHANGE ADDRESS -->
<div class="modal fade" id="address-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Perbaharui Alamat</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 m-b-15">
                        <label class="form-label">Provinsi</label>
                        {{ Form::select('province_id', [null=>'Pilih Provinsi']+provinces(), !empty($profile->village_id) ? $profile->village->district->regency->province->id : null, ['class'=>'form-control show-tick', 'id'=>'provinces', 'onChange'=>'getRegencies(this.value);']) }}
                    </div>
                    <div class="col-md-6 m-b-15">
                        <label class="form-label">Kota/Kabupaten</label>
                        {{ Form::select('regency_id', !empty($profile->village_id) ? regencies($profile->village->district->regency->province->id) : [null=>'Pilih Kota/Kabupaten'], !empty($profile->village_id) ? $profile->village->district->regency->id : null, ['class'=>'form-control show-tick', 'id'=>'regencies', 'onChange'=>'getDistricts(this.value);']) }}
                    </div>
                    <div class="col-md-6 m-b-15">
                        <label class="form-label">Kecamatan</label>
                        {{ Form::select('district_id', !empty($profile->village_id) ? districts($profile->village->district->regency->id) : [null=>'Pilih Kecamatan'], !empty($profile->village_id) ? $profile->village->district->id : null, ['class'=>'form-control show-tick', 'id'=>'districts', 'onChange'=>'getVillages(this.value);']) }}
                    </div>
                    <div class="col-md-6 m-b-15">
                        <label class="form-label">Kelurahan/Desa <span class="col-red">*</span></label>
                        {{ Form::select('village_id', !empty($profile->village_id) ? villages($profile->village->district->id) : [null=>'Pilih Kelurahan/Desa'], !empty($profile->village_id) ? $profile->village->id : null, ['class'=>'form-control show-tick', 'id'=>'villages']) }}
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <label class="form-label">Alamat <span class="col-red">*</span></label>
                        <div class="form-group">
                            <div class="form-line">
                                <textarea rows="1" class="form-control no-resize auto-growth" placeholder="Alamat" id="address">{!! $profile->address !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label class="form-label">Kode POS <span class="col-red">*</span></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="number" id="postcode" name="postcode" class="form-control" value="{{ $profile->postcode }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="changeAddress();">SIMPAN</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<!-- PROFILE PHOTO -->
<div class="modal fade" id="photo-update" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title align-center">Mau Apa?</h4>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-info waves-effect" onclick="$('#photo').trigger('click');$('#photo-update').modal('hide');">Ganti Foto</button>
                <button type="button" class="btn btn-danger waves-effect pull-right" onclick="removePhoto();">Hapus Foto</button>
            </div>
        </div>
    </div>
</div>

<!-- POSTER PHOTO -->
<div class="modal fade" id="poster-update" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title align-center">Mau Apa?</h4>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-info waves-effect" onclick="$('#poster').trigger('click');$('#poster-update').modal('hide');">Ganti Poster</button>
                <button type="button" class="btn btn-danger waves-effect pull-right" onclick="removePoster();">Hapus Poster</button>
            </div>
        </div>
    </div>
</div>

<!-- SOCIAL MEDIA FORM -->
<div class="modal fade" id="social-input" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Media Sosial</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <label for="social-name">Nama <span class="col-red">*</span></label>
                        <div class="form-group">
                            <div class="form-line success">
                                <input type="hidden" id="social-id" class="form-control">
                                <input type="text" id="social-name" class="form-control">
                            </div>
                        </div>
                        <label for="social-icon">Icon <span class="col-red">*</span></label><a class="waves-effect pull-right" data-toggle="modal" data-target="#socicon" id="display-icon"><span class="socicon-internet socicon-icon" style="background-color: black;"></span></a>
                        <div class="form-group">
                            <div class="form-line success">
                                <input type="text" id="social-icon" class="form-control" readonly="readonly">
                            </div>
                        </div>
                        <label for="social-link">Link <span class="col-red">*</span></label>
                        <div class="form-group m-b-0">
                            <div class="form-line success">
                                <input type="text" id="social-link" class="form-control">
                            </div>
                            <span><small>gunakan http:// atau https://</small></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="save_social();">SIMPAN</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<!-- SOCION ICON LIST -->
<div class="modal fade" id="socicon" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            @include('icons.socicon')
        </div>
    </div>
</div>

<!-- EDUCATION FORM -->
<div class="modal fade" id="education-input" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Riwayat Pendidikan</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <form id="education-form">
                        <div class="col-sm-12">
                            <label for="education-name">Nama Instansi <span class="col-red">*</span></label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="hidden" id="education-id" class="form-control">
                                    <input type="text" id="education-name" class="form-control">
                                </div>
                            </div>
                            <label for="education-level">Tingkat <span class="col-red">*</span></label>
                            <div class="form-group">
                                <div class="form-line success">
                                    {{ Form::select('education-level', [null=>'--Pilih Tingkat--']+education_levels(), null, ['class'=>'form-control show-tick', 'id'=>'education-level']) }}
                                </div>
                            </div>
                            <label for="education-majors">Jurusan</label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="text" id="education-majors" class="form-control">
                                </div>
                            </div>
                            <label for="education-place">Lokasi <span class="col-red">*</span></label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="text" id="education-place" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="education-year_in">Tahun Masuk <span class="col-red">*</span></label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="number" id="education-year_in" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="education-year_out">Tahun Keluar</label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="number" id="education-year_out" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="education-status">Status <span class="col-red">*</span></label>
                            <div class="form-group m-b-0">
                                <div class="form-line success">
                                    {{ Form::select('education-status', [null=>'--Status Sekarang--', 'yes'=>'Masih Belajar', 'no'=>'Sudah Keluar'], null, ['class'=>'form-control show-tick', 'id'=>'education-status']) }}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="save_education();">SIMPAN</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<!-- WORK FORM -->
<div class="modal fade" id="work-input" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Riwayat Pendidikan</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <form id="work-form">
                        <div class="col-sm-12">
                            <label for="work-name">Nama Pekerjaan/Profesi <span class="col-red">*</span></label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="hidden" id="work-id" class="form-control">
                                    <input type="text" id="work-name" class="form-control">
                                </div>
                            </div>
                            <label for="work-office">Nama Kantor/Dinas</label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="text" id="work-office" class="form-control">
                                </div>
                            </div>
                            <label for="work-position">Jabatan/Posisi</label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="text" id="work-position" class="form-control">
                                </div>
                            </div>
                            <label for="work-place">Lokasi <span class="col-red">*</span></label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="text" id="work-place" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="work-year_in">Tahun Mulai <span class="col-red">*</span></label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="number" id="work-year_in" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="work-year_out">Tahun Berhenti</label>
                            <div class="form-group">
                                <div class="form-line success">
                                    <input type="number" id="work-year_out" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="work-status">Status <span class="col-red">*</span></label>
                            <div class="form-group m-b-0">
                                <div class="form-line success">
                                    {{ Form::select('work-status', [null=>'--Status Sekarang--', 'yes'=>'Masih Bekerja', 'no'=>'Sudah Berhenti'], null, ['class'=>'form-control show-tick', 'id'=>'work-status']) }}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="save_work();">SIMPAN</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<!-- Bootstrap Select Css -->
<link href="{{ asset('template/adminbsb/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

<!-- Bootstrap Material Datetime Picker Css -->
<link href="{{ asset('template/adminbsb/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />

<!-- Fontawesome Iconpicker -->
<link href="{{ asset('ext/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css')}}" rel="stylesheet">
@endpush

@push('script')
<!-- Select Plugin Js -->
<script src="{{ asset('template/adminbsb/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<!-- Editable Table Plugin Js -->
<script src="{{ asset('template/adminbsb/plugins/editable-table/mindmup-editabletable.js') }}"></script>

<!-- Moment Plugin Js -->
<script src="{{ asset('template/adminbsb/plugins/momentjs/moment-with-locales.js') }}"></script>

<!-- Autosize Plugin Js -->
<script src="{{ asset('template/adminbsb/plugins/autosize/autosize.js' )}}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{ asset('template/adminbsb/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

<!-- Fontawesome Iconpicker -->
<script src="{{ asset('ext/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.js') }}"></script>

<script type="text/javascript">
    var getRegencies = function(province_id) {
        $.get('{{ url("information") }}/create/ajax-regencies?province_id=' + province_id, function(data) {
            $('#regencies').html(data);
            regency_id = $('#regencies').val();
            getDistricts(regency_id);
            $('#regencies').selectpicker('refresh');
        });
    }

    var getDistricts = function(regency_id) {
        $.get('{{ url("information") }}/create/ajax-districts?regency_id=' + regency_id, function(data) {
            $('#districts').html(data);
            district_id = $('#districts').val();
            getVillages(district_id);
            $('#districts').selectpicker('refresh');
        });
    }

    var getVillages = function(district_id) {
        $.get('{{ url("information") }}/create/ajax-villages?district_id=' + district_id, function(data) {
            $('#villages').html(data);
            $('#villages').selectpicker('refresh');
        });
    }

    function isImage(ext) {
        switch (ext.toLowerCase()) {
        case 'jpg':
        case 'gif':
        case 'bmp':
        case 'png':
            //etc
            return true;
        }
        return false;
    }

    function isValidUrl(url){
        var myVariable = url;
        if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(myVariable)) {
            return 1;
        } else {
            return -1;
        }   
    }

    function removePhoto() {
        swal({
            title: "Yakin?",
            text: "Fotonya mau dihapus?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus aja!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: 'profile/remove_photo',
                data: {_token: '{{ csrf_token() }}'},
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    swal("Berhasil!", data.message, "success");
                    $('#profile_photo').attr('src', "{{ asset('uploads/images/users') }}/"+data.photo);
                    $('#fit_profile_photo').attr('src', "{{ asset('uploads/images/users') }}/fit_"+data.photo);
                },
                error: function(data) {
                    swal("Gagal!", data, "error");
                }
            });
        });
        $('#photo-update').modal('hide');
    }

    function removePoster() {
        swal({
            title: "Yakin?",
            text: "Posternya mau dihapus?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus aja!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: 'profile/remove_poster',
                data: {_token: '{{ csrf_token() }}'},
                type: 'POST',
                success: function(data) {
                    swal("Berhasil!", data, "success");
                    $('#poster_image').attr('src', "{{ asset('uploads/images/posters') }}/poster.jpg");
                    $('#fit_poster_image').css('background', "url('{{ asset('uploads/images/posters') }}/fit_poster.jpg");
                    $('#fit_poster_image').css('background-size', 'cover');
                },
                error: function(data) {
                    swal("Gagal!", data, "error");
                    console.log(data);
                }
            });
        });
        $('#poster-update').modal('hide');
    }

    function remove_social(sid) {
        swal({
            title: "Yakin?",
            text: "Mau hapus media sosial ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus aja!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: 'profile/remove_social',
                data: {_token: '{{ csrf_token() }}', id:sid},
                type: 'POST',
                success: function(data) {
                    swal("Berhasil!", data, "success");
                    $('#social-table').find('[data-id="'+sid+'"]').remove();
                    var trlength = $('#social-table tr').length;
                    if (trlength < 2) {
                        var trempty = '<tr data-id="empty"><td colspan="3" align="center"><i>Tidak ada data.</i></td></tr>';
                        $('#social-table').append(trempty);
                    }
                },
                error: function(data) {
                    swal("Gagal!", data, "error");
                    console.log(data);
                }
            });
        });
        $('#poster-update').modal('hide');
    }

    function reset_social() {
        $('#social-id').val('');
        $('#social-name').val('');
        $('#social-icon').val('');
        $('#social-link').val('');
        $('#display-icon').html('<span class="socicon-internet socicon-icon" style="background-color: black;"></span>');
    }

    function edit_social(sid) {
        $.ajax({
            type: "POST",
            data: {_token: '{{ csrf_token() }}', id:sid},
            url: "{{ url('/profile/get_social') }}",
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('#social-id').val(sid);
                $('#social-name').val(data.name);
                $('#social-icon').val(data.icon);
                $('#display-icon').html('<span class="socicon-icon '+data.icon+'" style="background-color: '+data.color+'"></span>');
                $('#social-link').val(data.link);
                $('#social-input').modal('show');
            },
            error: function(data) {
                showAlert('Error: ' + data, 'bg-red');
            }
        })
    }

    function save_social() {
        var id = $('#social-id').val();
        var name = $('#social-name').val();
        var icon = $('#social-icon').val();
        var color = $('#display-icon').find('span.socicon-icon').css('background-color');
        var link = $('#social-link').val();
        if (name == '' || icon == '' || link == '') {
            swal('Eits!!', 'Isi semua datanya dong.. Ada yang belum diisi tuh!!', 'error');
        } else {
            console.log(isValidUrl(link));
            if (isValidUrl(link) == -1) {
                swal('Eits!!', 'Link harus valid', 'error');
                return false;
            }
            if (id > 0) {
                $.ajax({
                    type: "POST",
                    data: {_token: '{{ csrf_token() }}', id:id, name:name, icon:icon, link:link, color:color},
                    url: "{{ url('/profile/update_social') }}",
                    success: function(data) {
                        showAlert(data, 'bg-blue');
                        var td = '<td width="45"><a href="'+link+'" target="_blank"><span class="'+icon+' socicon-icon" style="background-color: '+color+';"></span></a></td><td><a href="'+link+'" target="_blank">'+name+'</a></td><td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_social('+id+');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_social('+id+');"><i class="fa fa-trash"></i></a></td>';
                        $('#social-table').find('[data-id="empty"]').remove();
                        $('#social-table').find('[data-id="'+id+'"]').html(td);
                        $('#social-input').modal('hide');
                    },
                    error: function(data) {
                        showAlert('Error: ' + data, 'bg-red');
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {_token: '{{ csrf_token() }}', name:name, icon:icon, link:link, color:color},
                    url: "{{ url('/profile/add_social') }}",
                    success: function(data) {
                        showAlert(data.message, 'bg-blue');
                        var tr = '<tr data-id="'+data.id+'"><td width="45"><a href="'+link+'" target="_blank"><span class="'+icon+' socicon-icon" style="background-color: '+color+';"></span></a></td><td><a href="'+link+'" target="_blank">'+name+'</a></td><td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_social('+data.id+');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_social('+data.id+');"><i class="fa fa-trash"></i></a></td></tr>';
                        $('#social-table').find('[data-id="empty"]').remove();
                        $('#social-table').append(tr);
                        $('#social-input').modal('hide');
                    },
                    error: function(data) {
                        console.log(data);
                        showAlert('Error: ' + data, 'bg-red');
                    }
                });
            }
        }
    }

    function remove_education(sid) {
        swal({
            title: "Yakin?",
            text: "Mau hapus riwayat pendidikan ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus aja!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: 'profile/remove_education',
                data: {_token: '{{ csrf_token() }}', id:sid},
                type: 'POST',
                success: function(data) {
                    swal("Berhasil!", data, "success");
                    $('#education-table').find('[data-id="'+sid+'"]').remove();
                    var trlength = $('#education-table tr').length;
                    if (trlength < 2) {
                        var trempty = '<tr data-id="empty"><td colspan="3" align="center"><i>Tidak ada data.</i></td></tr>';
                        $('#education-table').append(trempty);
                    }
                },
                error: function(data) {
                    swal("Gagal!", data, "error");
                    console.log(data);
                }
            });
        });
        $('#poster-update').modal('hide');
    }

    function reset_education() {
        $('#education-form')[0].reset();
        $("#education-id").val('');
        $("#education-level").selectpicker("refresh");
        $("#education-status").selectpicker("refresh");
    }

    function edit_education(sid) {
        $.ajax({
            type: "POST",
            data: {_token: '{{ csrf_token() }}', id:sid},
            url: "{{ url('/profile/get_education') }}",
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('#education-id').val(sid);
                $('#education-name').val(data.name);
                $('#education-place').val(data.place);
                $('#education-level').val(data.level);
                $('#education-level').selectpicker('refresh');
                $('#education-majors').val(data.majors);
                $('#education-year_in').val(data.year_in);
                $('#education-year_out').val(data.year_out);
                $('#education-status').val(data.current);
                $('#education-status').selectpicker('refresh');
                $('#education-input').modal('show');
            },
            error: function(data) {
                showAlert('Error: ' + data, 'bg-red');
            }
        })
    }

    function save_education() {
        var id = $('#education-id').val();
        var name = $('#education-name').val();
        var level = $('#education-level').val();
        var majors = $('#education-majors').val();
        var place = $('#education-place').val();
        var year_in = +$('#education-year_in').val();
        var year_out = +$('#education-year_out').val(); 
        var status = $('#education-status').val();
        if (name == '' || level == '' || place == '' || year_in == '' || status == '') {
            swal('Error', 'Kolom bertanda (*) harus diisi!!', 'error');
        } else {
            var currentYear = (new Date()).getFullYear();
            if (year_in < 1945 || year_in > currentYear) {
                swal('Error', 'Data Tahun Masuk harus rentang dari tahun 1945 dan tahun '+currentYear, 'error');
                return false;
            }
            if (year_out && (year_out < 1945 || year_out > currentYear)) {
                swal('Error', 'Data Tahun Keluar rentang dari tahun 1945 dan tahun '+currentYear, 'error');
                return false;
            }
            if (year_out && year_out < year_in) {
                swal('Error', 'Data Tahun Masuk tidak boleh lebih dari Tahun Keluar', 'error');
                return false;
            }
            if (status == 'yes' && year_out) {
                swal('Error', 'Tidak bisa set Masih Belajar jika Tahun Keluar diisi!!', 'error');
                $('#education-year_out').val('');
                return false;
            }
            if (id > 0) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {_token: '{{ csrf_token() }}', id:id, name:name, level:level, majors:majors, place:place, year_in:year_in, year_out:year_out, status:status},
                    url: "{{ url('/profile/update_education') }}",
                    success: function(data) {
                        showAlert(data.message, 'bg-blue');
                        var years = year_in;
                        if (year_out) {
                            var years = year_in+' - '+year_out;
                        }
                        if (status == 'yes') {
                            var years = year_in+' - Sekarang';
                        }
                        var vmajors = '';
                        if (majors) {
                            vmajors = ' Jurusan '+majors;
                        }
                        var td = '<td width="120"><strong>'+years+'</strong></td><td><strong>'+name+'</strong><br><small>Tingkat '+data.level+vmajors+'</small><br><small>di '+place+'</small></td><td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_education('+id+');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_education('+id+')"><i class="fa fa-trash"></i></a></td>';
                        $('#education-table').find('[data-id="empty"]').remove();
                        $('#education-table').find('[data-id="'+id+'"]').html(td);
                        $('#education-input').modal('hide');
                    },
                    error: function(data) {
                        showAlert('Error: ' + data, 'bg-red');
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {_token: '{{ csrf_token() }}', name:name, level:level, majors:majors, place:place, year_in:year_in, year_out:year_out, status:status},
                    url: "{{ url('/profile/add_education') }}",
                    success: function(data) {
                        showAlert(data.message, 'bg-blue');
                        var years = year_in;
                        if (year_out) {
                            var years = year_in+' - '+year_out;
                        }
                        if (status == 'yes') {
                            var years = year_in+' - Sekarang';
                        }
                        var vmajors = '';
                        if (majors) {
                            vmajors = ' Jurusan '+majors;
                        }
                        var tr = '<tr data-id="'+data.id+'" valign="top"><td width="120"><strong>'+years+'</strong></td><td><strong>'+name+'</strong><br><small>Tingkat '+data.level+vmajors+'</small><br><small>di '+place+'</small></td><td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_education('+data.id+');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_education('+data.id+')"><i class="fa fa-trash"></i></a></td></tr>';
                        $('#education-table').find('[data-id="empty"]').remove();
                        $('#education-table').append(tr);
                        $('#education-input').modal('hide');
                    },
                    error: function(data) {
                        console.log(data);
                        showAlert('Error: ' + data, 'bg-red');
                    }
                });
            }
        }
    }

    function remove_work(sid) {
        swal({
            title: "Yakin?",
            text: "Mau hapus riwayat pekerjaan ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus aja!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: 'profile/remove_work',
                data: {_token: '{{ csrf_token() }}', id:sid},
                type: 'POST',
                success: function(data) {
                    swal("Berhasil!", data, "success");
                    $('#work-table').find('[data-id="'+sid+'"]').remove();
                    var trlength = $('#work-table tr').length;
                    if (trlength < 2) {
                        var trempty = '<tr data-id="empty"><td colspan="3" align="center"><i>Tidak ada data.</i></td></tr>';
                        $('#work-table').append(trempty);
                    }
                },
                error: function(data) {
                    swal("Gagal!", data, "error");
                    console.log(data);
                }
            });
        });
        $('#poster-update').modal('hide');
    }

    function reset_work() {
        $('#work-form')[0].reset();
        $("#work-id").val('');
        $("#work-status").selectpicker("refresh");
    }

    function edit_work(sid) {
        $.ajax({
            type: "POST",
            data: {_token: '{{ csrf_token() }}', id:sid},
            url: "{{ url('/profile/get_work') }}",
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('#work-id').val(sid);
                $('#work-name').val(data.name);
                $('#work-position').val(data.position);
                $('#work-office').val(data.office);
                $('#work-place').val(data.place);
                $('#work-year_in').val(data.year_in);
                $('#work-year_out').val(data.year_out);
                $('#work-status').val(data.current);
                $('#work-status').selectpicker('refresh');
                $('#work-input').modal('show');
            },
            error: function(data) {
                showAlert('Error: ' + data, 'bg-red');
            }
        })
    }

    function save_work() {
        var id = $('#work-id').val();
        var name = $('#work-name').val();
        var position = $('#work-position').val();
        var office = $('#work-office').val();
        var place = $('#work-place').val();
        var year_in = +$('#work-year_in').val();
        var year_out = +$('#work-year_out').val(); 
        var status = $('#work-status').val();
        if (name == '' || place == '' || year_in == '' || status == '') {
            swal('Error', 'Kolom bertanda (*) harus diisi!!', 'error');
        } else {
            var currentYear = (new Date()).getFullYear();
            if (year_in < 1945 || year_in > currentYear) {
                swal('Error', 'Data Tahun Masuk harus rentang dari tahun 1945 dan tahun '+currentYear, 'error');
                return false;
            }
            if (year_out && (year_out < 1945 || year_out > currentYear)) {
                swal('Error', 'Data Tahun Keluar rentang dari tahun 1945 dan tahun '+currentYear, 'error');
                return false;
            }
            if (year_out && year_out < year_in) {
                swal('Error', 'Data Tahun Masuk tidak boleh lebih dari Tahun Keluar', 'error');
                return false;
            }
            if (status == 'yes' && year_out) {
                swal('Error', 'Tidak bisa set Masih Belajar jika Tahun Keluar diisi!!', 'error');
                $('#work-year_out').val('');
                return false;
            }
            vwork = '';
            vposition = '';
            if (id > 0) {
                $.ajax({
                    type: "POST",
                    data: {_token: '{{ csrf_token() }}', id:id, name:name, position:position, office:office, place:place, year_in:year_in, year_out:year_out, status:status},
                    url: "{{ url('/profile/update_work') }}",
                    success: function(data) {
                        showAlert(data, 'bg-blue');
                        var years = year_in;
                        if (year_out) {
                            var years = year_in+' - '+year_out;
                        }
                        if (status == 'yes') {
                            var years = year_in+' - Sekarang';
                        }
                        var vwork = name;
                        if (office) {
                            vwork = office;
                        }
                        if (position) {
                            vposition = '<br><small>Sebagai '+position+'</small>';
                        }
                        var td = '<td width="120"><strong>'+years+'</strong></td><td><strong>'+vwork+'</strong>'+vposition+'<br><small>di '+place+'</small></td><td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_work('+id+');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_work('+id+')"><i class="fa fa-trash"></i></a></td>';
                        $('#work-table').find('[data-id="empty"]').remove();
                        $('#work-table').find('[data-id="'+id+'"]').html(td);
                        $('#work-input').modal('hide');
                    },
                    error: function(data) {
                        showAlert('Error: ' + data, 'bg-red');
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {_token: '{{ csrf_token() }}', name:name, position:position, office:office, place:place, year_in:year_in, year_out:year_out, status:status},
                    url: "{{ url('/profile/add_work') }}",
                    success: function(data) {
                        showAlert(data.message, 'bg-blue');
                        var years = year_in;
                        if (year_out) {
                            var years = year_in+' - '+year_out;
                        }
                        if (status == 'yes') {
                            var years = year_in+' - Sekarang';
                        }
                        var vwork = name;
                        if (office) {
                            vwork = office;
                        }
                        if (position) {
                            vposition = '<br><small>Sebagai '+position+'</small>';
                        }
                        var tr = '<tr data-id="'+data.id+'" valign="top"><td width="120"><strong>'+years+'</strong></td><td><strong>'+vwork+'</strong>'+vposition+'<br><small>di '+place+'</small></td><td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_work('+data.id+');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_work('+data.id+')"><i class="fa fa-trash"></i></a></td></tr>';
                        $('#work-table').find('[data-id="empty"]').remove();
                        $('#work-table').append(tr);
                        $('#work-input').modal('hide');
                    },
                    error: function(data) {
                        console.log(data);
                        showAlert('Error: ' + data, 'bg-red');
                    }
                });
            }
        }
    }

    function updateData(column, newValue) {
        $.ajax({
            url: 'profile/update',
            data: {_token: '{{ csrf_token() }}', column: column, value: newValue},
            type: 'POST',
            success: function(data) {
                showAlert(data, 'bg-blue');
                $('#p-'+column).html(newValue);
            },
            error: function(data) {
                showAlert('Error: Data gagal diupdate', 'bg-red');
            }
        });
    }

    function changeJK() {
        var gender = $('#gender').val();
        if (gender == 'm') {
            var gender_val = 'Laki-laki';
        } else {
            var gender_val = 'Perempuan';
        }
        swal({
            title: "Yakin?",
            text: "Mau ganti Jenis Kelamin?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, ganti aja!",
            closeOnConfirm: false
        }, function () {
            window.onkeydown = null;
            window.onfocus = null;
            updateData('gender', gender);
            swal("Berhasil!", "Data Jenis Kelamin berhasil diganti.", "success");
            $('#gender-column').html(gender_val);
            $('#gender-edit').modal('hide');
        });
    }

    function changeBirth() {
        var birthplace = $('#birthplace').val();
        var birthdate = moment($('#birthdate').val(), 'dddd DD MMMM YYYY').format('YYYY-MM-DD');
        var birth_val = birthplace+", "+$('#birthdate').val();
        swal({
            title: "Yakin?",
            text: "Mau ganti Tempat, Tanggal Lahir?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, ganti aja!",
            closeOnConfirm: false
        }, function () {
            window.onkeydown = null;
            window.onfocus = null;
            updateData('birthplace', birthplace);
            updateData('birthdate', birthdate);
            swal("Berhasil!", "Data Tempat, Tanggal Lahir berhasil diganti.", "success");
            $('#birth-column').html(birth_val);
            $('#birth-edit').modal('hide');
        });
    }

    function changeAddress() {
        var village_id = $('#villages').val();
        var address = $('#address').val();
        var postcode = $('#postcode').val();
        swal({
            title: "Yakin?",
            text: "Data Alamatnya sudah bener?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, sudah!",
            closeOnConfirm: false
        }, function () {
            window.onkeydown = null;
            window.onfocus = null;
            if (village_id && address && postcode) {
                if (postcode.length == 5) {
                    updateData('village_id', village_id);
                    updateData('address', address);
                    updateData('postcode', postcode);
                    $.ajax({
                        url: 'profile/address',
                        data: {_token: '{{ csrf_token() }}', village_id: village_id},
                        type: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            swal("Berhasil!", "Data Alamat berhasil diganti.", "success");
                            $('#p-address').html(data.paddress);
                            $('#address-column').html(address+' '+data.address+' '+postcode);
                            $('#address-edit').modal('hide');
                        }
                    });
                } else {
                    swal("Gagal!", "Data Kode POS harus 5 digit.", "error");
                }
            } else {
                swal("Isi Dong!", "Datanya nggak diisi semua tuh!", "error");
            }
        });
    }

    function resetFormPassword() {
        $('#password-form')[0].reset();
        $('#password-form').find('div.form-line').removeClass('focused');
    }

    function changePassword() {
        var old_password = $('#old_password').val();
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        swal({
            title: "Yakin?",
            text: "Mau ganti Password?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, ganti aja!",
            closeOnConfirm: false
        }, function () {
            window.onkeydown = null;
            window.onfocus = null;
            if (old_password && new_password && confirm_password) {
                if (new_password === confirm_password) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/profile/password') }}",
                        dataType: 'json',
                        data: {_token: '{{ csrf_token() }}', new_password:new_password, old_password:old_password},
                        success: function(data) {
                            if (data.success) {
                                swal("Berhasil!", data.message, "success");
                                $('#password-edit').modal('hide');
                                resetFormPassword();
                            } else {
                                swal("Yaaahh!", data.message, "error");
                                $('#old_password').val('');
                                window.setTimeout(function () { 
                                    $('#old_password').focus(); 
                                }, 0);
                            }
                        },
                        error: function(data) {
                            swal("Error!", data, "error");
                            console.log(data);
                        }
                    });
                } else {
                    swal("Nggak sama!", "Password Baru gak sama!\nCek lagi, bisi salah!", "error");
                }
            } else {
                swal("Isi Dong!", "Datanya nggak diisi semua tuh!", "error");
            }
        });
    }

    $(function () {
        //Textare auto growth
        autosize($('textarea.auto-growth'));

        $('.iconnya').on('click', function() {
            var icon = $(this).find('span.icon-name').html();
            var background = $(this).find('span.socicon-icon').css('background-color');
            $('#social-icon').val(icon);
            $('#display-icon').html('<span class="'+icon+' socicon-icon" style="background-color: '+background+'"></span>');
            $('#socicon').modal('hide');
        });

        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY',
            clearButton: true,
            weekStart: 1,
            time: false,
            lang: 'id-ID'
        });

        $('#profile-table').editableTableWidget();

        $('table td').on('change', function(evt, newValue) {
            var column = $(this).data('column');
            var required = ['name', 'fullname', 'email', 'phone'];
            newValue = newValue.trim();
            if (newValue) {
                if (column == 'phone') {
                    var numbers = /^[0-9]+$/;
                    if (newValue.match(numbers)) {
                        updateData(column, newValue);
                    } else {
                        swal('Error', 'Format data tidak sesuai!\ncontoh: 089658590616', 'error');
                        return false;
                    }
                } else if (column == 'email') {
                    if (isEmail(newValue)) {
                        updateData(column, newValue);
                    } else {
                        swal('Error', 'Format data tidak sesuai!\ncontoh: saklu07@gmail.com', 'error');
                        return false;
                    }
                } else {
                    updateData(column, newValue);
                }
            } else {
                if (required.indexOf(column) > -1) {
                    swal('Error', 'Data nggak boleh kosong!', 'error');
                    return false;
                } else {
                    updateData(column, newValue);
                }
            }
        });

        $('#photo').on('change', function() {
            filename = $('#photo').val();
            var parts = filename.split('.');
            var ext = parts[parts.length - 1];
            if (!isImage(ext)) {
                alert('bukan image');
            } else {
                var id = $('#uploadphoto').val();
                var photo = $('#photo')[0].files[0];
                var form = new FormData();
                form.append('id', id);
                form.append('_token', '{{ csrf_token() }}');
                form.append('photo', photo);
                $.ajax({
                    url: 'profile/photo',
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        $('#profile_photo').attr('src', "{{ asset('uploads/images/users') }}/"+data.photo+"?"+new Date().getTime());
                        $('#fit_profile_photo').attr('src', "{{ asset('uploads/images/users') }}/fit_"+data.photo+"?"+new Date().getTime());
                        showAlert(data.message, 'bg-blue');
                    },
                    error: function(data) {
                        showAlert('Error: ' + data, 'bg-red');
                    }
                });
            }
        });
        
        $('#poster').on('change', function() {
            filename = $('#poster').val();
            var parts = filename.split('.');
            var ext = parts[parts.length - 1];
            if (!isImage(ext)) {
                alert('bukan image');
            } else {
                var id = $('#uploadposter').val();
                var poster = $('#poster')[0].files[0];
                var form = new FormData();
                form.append('id', id);
                form.append('_token', '{{ csrf_token() }}');
                form.append('poster', poster);
                $.ajax({
                    url: 'profile/poster',
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        $('#poster_image').attr('src', "{{ asset('uploads/images/posters') }}/"+data.poster+"?"+new Date().getTime());
                        $('#fit_poster_image').css('background', "url('{{ asset('uploads/images/posters') }}/fit_"+data.poster+"?"+new Date().getTime());
                        $('#fit_poster_image').css('background-size', 'cover');
                        showAlert(data.message, 'bg-blue');
                    },
                    error: function(data) {
                        showAlert('Error: ' + data, 'bg-red');
                    }
                });
            }
        })
    })
</script>
@endpush