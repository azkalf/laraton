@extends('layouts.adminbsb')
@section('title', 'USER')

@section('content')
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <div class="card">
	        <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <h2>Daftar User</h2>
                    </div>
                    <div class="col-xs-12 col-sm-6 align-right">
                        <button type="button" class="btn btn-primary waves-effect pull-right" id="add" data-toggle="modal" data-target="#user-input">TAMBAH</button>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover user-table dataTable" id="user-table">
                        <thead>
                            <th width="80">Foto</th>
                            <th>Info</th>
                            <th width="50">Aksi</th>
                        </thead>
                        <tfoot>
                            <th>Foto</th>
                            <th>Info</th>
                            <th>Aksi</th>
                        </tfoot>
                        <tbody>
                        	@foreach($users as $user)
                            <?php $photo = !empty($user->photo) ? $user->photo : ($user->gender == 'm' ? 'ikhwan.png' : 'akhwat.png'); ?>
                        	<tr>
                        		<td><img src="{{ asset('uploads/images/users/'.$photo) }}" class="img-responsive thumbnail m-b-0" style="max-width: 100px; max-height: 150px;"></td>
                                <td>
                                    <strong><i>ID</i></strong> {{ $user->id }}<br>
                                    <strong><i>Nama User</i></strong> {{ $user->name }}<br>
                                    <strong><i>Nama Lengkap</i></strong> {{ $user->fullname }}<br>
                                    <strong><i>Email</i></strong> {{ $user->email }}
                                </td>
                        		<td align="center"><a href="javascript:void(0);" title="detail" onclick="detail_user('{{ $user->id }}');"><i class="glyphicon glyphicon-user"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:vodi(0);" title="hapus" onclick="delete_user('{{ $user->id }}', '{{ $user->name }}')"><i class="glyphicon glyphicon-trash"></i></a></td>
                        	</tr>
                        	@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =================================== MODAL DIALOGUE ==================================== -->

<!-- DETAIL USER -->
<div class="modal fade" id="user-detail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data User</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-bordered table-striped" id="user-table">
                    <tbody>
                        <tr>
                            <th width="170">ID</th>
                            <td id="user-id"></td>
                        </tr>
                        <tr>
                            <th>Nama User</th>
                            <td id="user-name"></td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td id="user-fullname"></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td id="user-sex"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="user-email"></td>
                        </tr>
                        <tr>
                            <th>No. Handphone</th>
                            <td id="user-phone"></td>
                        </tr>
                        <tr>
                            <th>Tempat, Tanggal Lahir</th>
                            <td id="user-birth"></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td id="user-birthdate"></td>
                        </tr>
                        <tr>
                            <th>Tentang User</th>
                            <td id="user-about"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" onclick="resetFormPassword();">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<!-- USER FORM -->
<div class="modal fade" id="user-input" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah User</h4>
            </div>
            <form id="user-form" method="post" action="{{ url('user/create') }}">
                @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group form-float">
                                <div class="form-line success">
                                    <input type="text" id="user-name" name="name" class="form-control" required="required">
                                    <label class="form-label" for="user-name">Nama User <span class="col-red">*</span></label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line success">
                                    <input type="text" id="user-fullname" name="fullname" class="form-control" required="required">
                                    <label class="form-label" for="user-fullname">Nama Lengkap <span class="col-red">*</span></label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line success">
                                    <input type="email" id="user-email" name="email" class="form-control" required="required">
                                    <label class="form-label" for="user-email">Email</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <input type="radio" name="gender" id="male" class="with-gap" value="m">
                                <label for="male">Laki-laki</label>
                                <input type="radio" name="gender" id="female" class="with-gap" value="f">
                                <label for="female" class="m-l-20">Perempuan</label>
                            </div>
                            <hr>
                            <label class="form-label" for="user-group">Role Grup <span class="col-red">*</span></label>
                            <div class="form-group form-float">
                                <div class="form-line success">
                                    {{ Form::select('group_id', groups(), null, ['class'=>'form-control show-tick', 'id'=>'user-group', 'required'=>"required"]) }}
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line success">
                                    <input type="password" id="user-password" name="password" class="form-control" required="required">
                                    <label class="form-label" for="user-group">Password <span class="col-red">*</span></label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line success">
                                    <input type="password" id="user-password-confirm" name="password-confirm" class="form-control" required="required">
                                    <label class="form-label" for="user-group">Password (Lagi) <span class="col-red">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<!-- JQuery DataTable Css -->
<link href="{{ asset('template/adminbsb/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
<!-- Bootstrap Select Css -->
<link href="{{ asset('template/adminbsb/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@push('script')
<!-- Select Plugin Js -->
<script src="{{ asset('template/adminbsb/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<!-- Jquery DataTable Plugin Js -->
<script src="{{ asset('template/adminbsb/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('template/adminbsb/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
<!-- Jquery Validation Plugin Css -->
<script src="{{ asset('template/adminbsb/plugins/jquery-validation/jquery.validate.js') }}"></script>
<script src="{{ asset('template/adminbsb/plugins/jquery-validation/localization/messages_id.js') }}"></script>
<script type="text/javascript">
	$(function() {
		$('.user-table').DataTable({
            dom: '<"col-md-6"l><"col-md-6"f>rt<"col-md-6"i><"col-md-6"p>',
            responsive: true
	    });

        $('#user-form').validate({
            rules: {
                'password-confirm': {
                    equalTo: '#user-password'
                },
                'gender': {
                    required: true
                }
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            }
        });
    });

    function detail_user(uid) {
        $.ajax({
            type: "POST",
            data: {_token: '{{ csrf_token() }}', id:uid},
            url: "{{ url('/user/get_user') }}",
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('#user-id').html(uid);
                $('#user-name').html(data.name);
                $('#user-fullname').html(data.fullname);
                $('#user-sex').html(data.sex);
                $('#user-email').html(data.email);
                $('#user-phone').html(data.phone);
                var birth = data.birthdate;
                if (data.birthplace != '') {
                    birth = data.birthplace+', '+data.birthdate;
                }
                $('#user-birth').html(birth);
                $('#user-address').html(data.address);
                $('#user-detail').modal('show');
            },
            error: function(data) {
                showAlert('Error: ' + data, 'bg-red');
            }
        })
    }

    var delete_user = function(id, name) {
        swal({
            title: "Yakin?",
            text: "User "+name+"-nya mau di hapus?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus aja!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {_token: '{{ csrf_token() }}', id:id},
                url: "{{ url('/user/delete_user') }}",
                success: function(data) {
                    if (data.status == 'success') {
                        swal("Terhapus!", data.message, "success");
                        setInterval(function(){
                            location.reload();
                        }, 1000);
                    } else {
                        swal("Yaaahh!", data.message, "error");
                    }
                },
                error: function(data) {
                    swal("Error!", data, "error");
                    console.log(data);
                }
            });
        });
    }
</script>
@endpush