@if (count($errors) > 0)
	<div class="alert bg-red alert-dismissible" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong>Whoops! ada yang salah!</strong>
		<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif