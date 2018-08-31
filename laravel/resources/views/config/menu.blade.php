@extends('layouts.adminbsb')
@section('title', 'MENU')

@section('content')
<!-- Draggable Handles -->
<div class="row clearfix">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					Daftar Menu
				</h2>
			</div>
			<div class="body">
				<div class="clearfix m-b-20">
					<div class="dd nestable-with-handle">
						<ol class="dd-list" id="listmenu">
						@foreach ($menus as $menu)
	                    	<li class="dd-item dd3-item" data-id="{{ $menu['id'] }}">
								<div class="dd-handle dd3-handle"></div>
								<div class="dd3-content"><a href="#" class="menulist" onclick="edit(this)" id="menu{{ $menu['id'] }}" data-id="{{ $menu['id'] }}" data-title="{{ $menu['title'] }}" data-url="{{ $menu['url'] }}" data-icon="{{ $menu['icon'] }}"><i class="material-icons pull-left">{{ $menu['icon'] }}</i>&nbsp;&nbsp;{{ $menu['title'] }}</a><a href="#" onclick="delete_menu(this)" class="pull-right" data-id="{{ $menu['id'] }}" data-title="{{ $menu['title'] }}">(hapus)</a></div>
								<?php list_menu($menu); ?>
							</li>
	                    @endforeach
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2 id="manage-menu">
					Tambah Menu
				</h2>
			</div>
			<div class="body">
            	<div class="row clearfix">
					<div class="col-sm-12">
                        <label for="menu-id">Judul</label>
                        <div class="form-group">
                            <div class="form-line success">
                                <input type="hidden" id="menu-id" class="form-control">
                                <input type="text" id="menu-title" class="form-control">
                            </div>
                        </div>
                        <label for="menu-icon">Icon</label><button type="button" class="btn btn-default waves-effect pull-right" data-toggle="modal" data-target="#icons"><i class="material-icons" id="display-icon">help</i></button>
                        <div class="form-group">
                            <div class="form-line success">
                                <input type="text" id="menu-icon" class="form-control" readonly="readonly">
                            </div>
                        </div>
                        <label for="menu-url">URL</label>
                        <div class="form-group">
                            <div class="form-line success">
                                <input type="text" id="menu-url" class="form-control">
                            </div>
                        </div>
                        <div id="buttons">
                    		<button type="button" class="btn btn-primary m-t-15 waves-effect pull-right" id="save">TAMBAH MENU</button>
                        </div>
	                </div>
	            </div>
			</div>
		</div>
	</div>
</div>
<!-- #END# Draggable Handles -->
<div class="modal fade" id="icons" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">PILIH ICON</h4>
            </div>
            <div class="modal-body">
            	@include('icons.materialicon')
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<!-- JQuery Nestable Css -->
<link href="{{ asset('template/adminbsb/plugins/nestable/jquery-nestable.css') }}" rel="stylesheet" />
<style type="text/css">
	.menulist, .menulist:hover, .menulist:visited {
		text-decoration: none;
	}
	#listmenu .material-icons {
		font-size: 20px;
	}
	.iconnya {
		cursor: pointer;
	}
</style>
@endpush

@push('script')
<!-- Jquery Nestable -->
<script src="{{ asset('template/adminbsb/plugins/nestable/jquery.nestable.js') }}"></script>
<script type="text/javascript">
	var reset = function() {
    	$('#menu-id').val('');
    	$('#menu-title').val('');
    	$('#menu-icon').val('');
    	$('#menu-url').val('');
    	$('#display-icon').html('help');
    	$('#manage-menu').html('TAMBAH MENU');
    	$('.cancel').remove();
	    $('#save').html('TAMBAH');
	}
	var edit = function(menu) {
    	var id = $(menu).data('id');
    	var title = $(menu).data('title');
    	var icon = $(menu).data('icon');
    	var url = $(menu).data('url');
    	var cancelbutton = '<button type="button" class="btn btn-warning m-t-15 waves-effect pull-left cancel" onclick="reset()">BATAL</button>';
    	$('#menu-id').val(id);
    	$('#menu-title').val(title);
    	$('#menu-icon').val(icon);
    	$('#menu-url').val(url);
    	$('#display-icon').html(icon);
    	$('#manage-menu').html('UPDATE MENU "<strong>'+title+'</strong>"');
    	$('#save').html('UPDATE');
    	$('.cancel').remove();
    	$('#buttons').append(cancelbutton);
	}
	var delete_menu = function(menu) {
    	var id = $(menu).data('id');
    	var title = $(menu).data('title');
    	swal({
	        title: "Yakin?",
	        text: "Menu "+title+"-nya mau di hapus?",
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
	        	url: "{{ url('/menu/delete_menu') }}",
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
	$(function () {
	    $('.dd').nestable();

	    $('.dd').on('change', function () {
	        var $this = $(this);
	        var serializedData = window.JSON.stringify($($this).nestable('serialize'));
	        $.ajax({
	        	type: "POST",
	        	data: {_token: '{{ csrf_token() }}', menus: serializedData},
	        	url: "{{ url('/menu/sort_menu') }}",
	        	success: function(data) {
	        		showAlert(data, 'bg-blue');
	        	},
	        	error: function(data) {
			        showAlert('Error: ' + data, 'bg-red');
	        		console.log(data);
	        	}
	        });
	    });

	    $('.iconnya').on('click', function() {
	    	var icon = $(this).find('i.material-icons').html();
	    	$('#menu-icon').val(icon);
	    	$('#display-icon').html(icon);
	    	$('#icons').modal('hide');
	    });

	    $('#save').on('click', function() {
	    	var id = $('#menu-id').val();
	    	var title = $('#menu-title').val();
	    	var icon = $('#menu-icon').val();
	    	var url = $('#menu-url').val();
	    	$('#save').attr('disabled', 'disabled');
	    	if (title == '' || icon == '' || url == '') {
	    		showAlert('Isi semua datanya dong.. Ada yang belum diisi tuh!!', 'bg-deep-orange');
	    		setInterval(function() {
	    			$('#save').removeAttr('disabled');
	    		}, 2000);
	    	} else {
		    	if (id > 0) {
			        $.ajax({
			        	type: "POST",
			        	data: {_token: '{{ csrf_token() }}', id:id, title:title, icon:icon, url:url},
			        	url: "{{ url('/menu/update_menu') }}",
			        	success: function(data) {
			        		$('#menu'+id).html('<i class="material-icons pull-left">'+icon+'</i>&nbsp;&nbsp;'+title);
			        		$('#menu'+id).data('title', title);
			        		$('#menu'+id).data('icon', icon);
			        		$('#menu'+id).data('url', url);
			        		showAlert(data, 'bg-blue');
			        		reset();
	    					setInterval(function() {
	    						$('#save').removeAttr('disabled');
	    					}, 2000);
			        	},
			        	error: function(data) {
			        		showAlert('Error: ' + data, 'bg-red');
	    					setInterval(function() {
	    						$('#save').removeAttr('disabled');
	    					}, 2000);
	        				console.log(data);
			        	}
			        });
		    	} else {
			        $.ajax({
			        	type: "POST",
			        	dataType: "json",
			        	data: {_token: '{{ csrf_token() }}', title:title, icon:icon, url:url},
			        	url: "{{ url('/menu/add_menu') }}",
			        	success: function(data) {
					    	var html = '<li class="dd-item dd3-item" data-id="'+data.id+'">'+
												'<div class="dd-handle dd3-handle"></div>'+
												'<div class="dd3-content"><a href="#" class="menulist" onclick="edit(this)" id="menu'+data.id+'" data-id="'+data.id+'" data-title="'+title+'" data-url="'+url+'" data-icon="'+icon+'"><i class="material-icons pull-left">'+icon+'</i>&nbsp;&nbsp;'+title+'</a><a href="#" onclick="delete_menu(this)" class="pull-right" data-id="'+data.id+'" data-title="'+data.title+'">(hapus)</a></div>'+
											'</li>';
			        		$('#listmenu').append(html);
			        		showAlert(data.message, 'bg-blue');
			        		reset();
	    					setInterval(function() {
	    						$('#save').removeAttr('disabled');
	    					}, 2000);
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
		    }
	    });
	});
</script>
@endpush