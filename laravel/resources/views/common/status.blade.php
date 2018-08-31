@if (Session::has('success'))
<div class="alert bg-green alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<h4><i class="icon fa fa-check"></i> Success!</h4>
	{{ Session::get('success') }}
</div>
@endif
@if (Session::has('error'))
<div class="alert bg-red alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<h4><i class="icon fa fa-warning"></i> Ooops!</h4>
	{{ Session::get('error') }}
</div>
@endif