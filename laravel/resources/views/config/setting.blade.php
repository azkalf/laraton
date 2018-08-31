@extends('layouts.adminbsb')
@section('title', 'SETTING')

@section('content')
<div class="row clearfix">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-right">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>Basic Setting</h2>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line success">
                                <input type="text" id="setting-appname" name="appname" class="form-control" value="{{ $setting->appname }}" required="required">
                                <label class="form-label" for="setting-appname">Nama Aplikasi <span class="col-red">*</span></label>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line success">
                                <input type="text" id="setting-subname" name="subname" class="form-control" value="{{ $setting->subname }}" required="required">
                                <label class="form-label" for="setting-subname">Sub Nama Aplikasi <span class="col-red">*</span></label>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line success">
                                <input type="text" id="setting-copyright" name="copyright" class="form-control" value="{{ $setting->copyright }}" required="required">
                                <label class="form-label" for="setting-copyright">Copyright <span class="col-red">*</span></label>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line success">
                                <input type="text" id="setting-version" name="version" class="form-control" value="{{ $setting->version }}" required="required">
                                <label class="form-label" for="setting-version">Versi <span class="col-red">*</span></label>
                            </div>
                        </div>
                        <label class="form-label" for="setting-skin">Default Skin <span class="col-red">*</span></label>
                        <div class="form-group form-float">
                            <div class="form-line success">
                                {{ Form::select('skin', skins(), $setting->skin, ['class'=>'form-control show-tick', 'id'=>'setting-skin', 'required'=>"required"]) }}
                            </div>
                        </div>
                        <div id="buttons">
                            <button type="button" class="btn btn-primary m-t-15 waves-effect pull-right" id="save">SIMPAN</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>Default Background</h2><small>( <a href="{{ url('403') }}">403</a> / <a href="{{ url('404') }}">404</a> )</small>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-xs-12 m-b-0">
                        <div class="image-content">
                            <div class="image-overlay overlay-bg"><div class="image-overlay-content"><img src="{{ asset('images/loader.gif')}}" alt="Loading..."/></div></div>
                            <img src="{{ asset('uploads/images/'.$setting->bg) }}" class="img-responsive thumbnail" id="setting-bg" style="width: 100%; cursor: pointer;" data-toggle="modal" data-target="#bg-update">
                        </div>
                        <form id="uploadBg" method="post" enctype="multipart/form-data">
                            <input type="file" name="bg" id="input-bg" style="display: none;" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>Logo</h2>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-xs-12 m-b-0">
                        <div class="image-content">
                            <div class="image-overlay overlay-logo"><div class="image-overlay-content"><img src="{{ asset('images/loader.gif')}}" alt="Loading..."/></div></div>
                            <img src="{{ asset('uploads/images/'.$setting->logo) }}" class="img-responsive thumbnail bg-striped" id="setting-logo" style="width: 100%; cursor: pointer;" data-toggle="modal" data-target="#logo-update">
                        </div>
                        <form id="uploadLogo" method="post" enctype="multipart/form-data">
                            <input type="file" name="logo" id="input-logo" style="display: none;" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
	    <div class="card">
	        <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>Poster</h2>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-xs-12 m-b-0">
                        <div class="image-content">
                            <div class="image-overlay overlay-poster"><div class="image-overlay-content"><img src="{{ asset('images/loader.gif')}}" alt="Loading..."/></div></div>
                            <img src="{{ asset('uploads/images/posters/'.$setting->poster) }}" class="img-responsive thumbnail" id="setting-poster" style="width: 100%; cursor: pointer;" data-toggle="modal" data-target="#poster-update">
                        </div>
                        <form id="uploadPoster" method="post" enctype="multipart/form-data">
                            <input type="file" name="poster" id="input-poster" style="display: none;" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LOGO -->
<div class="modal fade" id="logo-update" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title align-center">Mau Apa?</h4>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-info waves-effect" onclick="$('#input-logo').trigger('click');$('#logo-update').modal('hide');">Ganti Logo</button>
                <button type="button" class="btn btn-danger waves-effect pull-right" onclick="resetLogo();">Reset Logo</button>
            </div>
        </div>
    </div>
</div>

<!-- POSTER -->
<div class="modal fade" id="poster-update" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title align-center">Mau Apa?</h4>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-info waves-effect" onclick="$('#input-poster').trigger('click');$('#poster-update').modal('hide');">Ganti Poster</button>
                <button type="button" class="btn btn-danger waves-effect pull-right" onclick="resetPoster();">Reset Poster</button>
            </div>
        </div>
    </div>
</div>

<!-- LOGO -->
<div class="modal fade" id="bg-update" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title align-center">Mau Apa?</h4>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-info waves-effect" onclick="$('#input-bg').trigger('click');$('#bg-update').modal('hide');">Ganti Background</button>
                <button type="button" class="btn btn-danger waves-effect pull-right" onclick="resetBg();">Reset</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style type="text/css">
    .image-content{position: relative;}
    .image-overlay{position: absolute;left: 0; top: 0; right: 0; bottom: 0;z-index: 2;background-color: rgba(255,255,255,0.8);display: none;}
    .image-overlay-content {
        position: absolute;
        transform: translateY(-50%);
         -webkit-transform: translateY(-50%);
         -ms-transform: translateY(-50%);
        top: 50%;
        left: 0;
        right: 0;
        text-align: center;
        color: #555;
    }
    .bg-striped {
        background: repeating-linear-gradient(
          45deg,
          #e9e9e9,
          #e9e9e9 10px,
          grey 10px,
          grey 20px
        );
    }
</style>
<!-- JQuery DataTable Css -->
<link href="{{ asset('template/adminbsb/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
<!-- Bootstrap Select Css -->
<link href="{{ asset('template/adminbsb/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@push('script')
<!-- Select Plugin Js -->
<script src="{{ asset('template/adminbsb/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('template/adminbsb/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript">
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

    function resetLogo() {
        swal({
            title: "Yakin?",
            text: "Logonya mau direset?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, reset aja!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: 'setting/reset_logo',
                data: {_token: '{{ csrf_token() }}'},
                type: 'POST',
                success: function(data) {
                    swal("Berhasil!", data, "success");
                    $('#logo').attr('src', "{{ asset('uploads/images/mtk_white.png') }}");
                    $('#setting-logo').attr('src', "{{ asset('uploads/images/mtk_white.png') }}");
                },
                error: function(data) {
                    swal("Gagal!", data, "error");
                }
            });
        });
        $('#logo-update').modal('hide');
    }

    function resetPoster() {
        swal({
            title: "Yakin?",
            text: "Posternya mau direset?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, reset aja!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: 'setting/reset_poster',
                data: {_token: '{{ csrf_token() }}'},
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    swal("Berhasil!", data.message, "success");
                    $('#poster_image').attr('src', "{{ asset('uploads/images/posters') }}/"+data.poster);
                    $('#fit_poster_image').css('background', "url('{{ asset('uploads/images/posters') }}/fit_"+data.poster);
                    $('#fit_poster_image').css('background-size', 'cover');
                    $('#setting-poster').attr('src', "{{ asset('uploads/images/posters/poster.jpg') }}");
                },
                error: function(data) {
                    swal("Gagal!", data.message, "error");
                }
            });
        });
        $('#poster-update').modal('hide');
    }

    function resetBg() {
        swal({
            title: "Yakin?",
            text: "Default Background-nya mau direset?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, reset aja!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: 'setting/reset_bg',
                data: {_token: '{{ csrf_token() }}'},
                type: 'POST',
                success: function(data) {
                    swal("Berhasil!", data, "success");
                    $('#bg').attr('src', "{{ asset('uploads/images/bg.jpg') }}");
                    $('#setting-bg').attr('src', "{{ asset('uploads/images/bg.jpg') }}");
                },
                error: function(data) {
                    swal("Gagal!", data, "error");
                }
            });
        });
        $('#bg-update').modal('hide');
    }

    $(function () {
        $('#save').on('click', function() {
            var appname = $('#setting-appname').val();
            var subname = $('#setting-subname').val();
            var copyright = $('#setting-copyright').val();
            var version = $('#setting-version').val();
            var skin = $('#setting-skin').val();
            $('#save').attr('disabled', 'disabled');
            if (appname == '' || copyright == '' || version == '' || skin == '' || subname == '') {
                swal("Eitss!", 'Isi semua datanya dong.. Ada yang belum diisi tuh!!', "error");
                setInterval(function() {
                    $('#save').removeAttr('disabled');
                }, 2000);
            } else {
                $.ajax({
                    type: "POST",
                    data: {_token: '{{ csrf_token() }}', appname:appname, subname:subname, copyright:copyright, version:version, skin:skin},
                    url: "{{ url('/setting/update_setting') }}",
                    success: function(data) {
                        showAlert(data, 'bg-blue');
                        setInterval(function() {
                            $('#save').removeAttr('disabled');
                        }, 2000);
                        $('#appname').html(appname+'<br><small>'+subname+'</small>');
                        document.title = 'SETTING - '+appname;
                        $('.copyright').html(copyright);
                        $('.version').html(version);
                    },
                    error: function(data) {
                        showAlert('Error: ' + data, 'bg-red');
                        setInterval(function() {
                            $('#save').removeAttr('disabled');
                        }, 2000);
                        console.log(data);
                    }
                });
            }
        });

        $('#input-logo').on('change', function() {
            filename = $('#input-logo').val();
            var parts = filename.split('.');
            var ext = parts[parts.length - 1];
            if (!isImage(ext)) {
                swal("Eitss!", 'ini bukan file gambar', "error");
            } else {
                $('.overlay-logo').show();
                var logo = $('#input-logo')[0].files[0];
                var form = new FormData();
                form.append('_token', '{{ csrf_token() }}');
                form.append('logo', logo);
                $.ajax({
                    url: 'setting/update_logo',
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        $('#logo').attr('src', "{{ asset('uploads/images') }}/"+data.logo+"?"+new Date().getTime());
                        $('#setting-logo').attr('src', "{{ asset('uploads/images') }}/"+data.logo+"?"+new Date().getTime());
                        showAlert(data.message, 'bg-blue');
                        $('.overlay-logo').hide();
                    },
                    error: function(data) {
                        showAlert('Error: ' + data.message, 'bg-red');
                    }
                });
            }
        });

        $('#input-poster').on('change', function() {
            filename = $('#input-poster').val();
            var parts = filename.split('.');
            var ext = parts[parts.length - 1];
            if (!isImage(ext)) {
                swal("Eitss!", 'ini bukan file gambar', "error");
            } else {
                $('.overlay-poster').show();
                var poster = $('#input-poster')[0].files[0];
                var form = new FormData();
                form.append('_token', '{{ csrf_token() }}');
                form.append('poster', poster);
                $.ajax({
                    url: 'setting/update_poster',
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        $('#poster_image').attr('src', "{{ asset('uploads/images/posters') }}/"+data.poster);
                        $('#fit_poster_image').css('background', "url('{{ asset('uploads/images/posters') }}/fit_"+data.poster);
                        $('#fit_poster_image').css('background-size', 'cover');
                        $('#setting-poster').attr('src', "{{ asset('uploads/images/posters') }}/"+data.poster+"?"+new Date().getTime());
                        showAlert(data.message, 'bg-blue');
                        $('.overlay-poster').hide();
                    },
                    error: function(data) {
                        showAlert('Error: ' + data.message, 'bg-red');
                    }
                });
            }
        });

        $('#input-bg').on('change', function() {
            filename = $('#input-bg').val();
            var parts = filename.split('.');
            var ext = parts[parts.length - 1];
            if (!isImage(ext)) {
                swal("Eitss!", 'ini bukan file gambar', "error");
            } else {
                $('.overlay-bg').show();
                var bg = $('#input-bg')[0].files[0];
                var form = new FormData();
                form.append('_token', '{{ csrf_token() }}');
                form.append('bg', bg);
                $.ajax({
                    url: 'setting/update_bg',
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data) {
                        $('#bg').attr('src', "{{ asset('uploads/images') }}/"+data.bg+"?"+new Date().getTime());
                        $('#setting-bg').attr('src', "{{ asset('uploads/images') }}/"+data.bg+"?"+new Date().getTime());
                        showAlert(data.message, 'bg-blue');
                        $('.overlay-bg').hide();
                    },
                    error: function(data) {
                        showAlert('Error: ' + data.message, 'bg-red');
                    }
                });
            }
        });
    });
</script>
@endpush