@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Update Profile
			<small>Update Profile</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="{{ url('/settings/profile') }}"><i class="fa fa-gear"></i> User Profile</a></li>
			<li class="active">Update profile</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		@include('layouts._flash')
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Update Profile</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			{!! Form::model(auth()->user(), ['url' => url('/settings/profile'),
			'method' => 'post', 'files'=>'true', 'role'=>'form', 'id' => 'form_id']) !!}
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							{!! Form::label('name', 'Nama (*)') !!}
							{!! Form::text('name', null, ['class'=>'form-control','placeholder' => 'Nama', 'maxlength' => 255, 'required']) !!}
							{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
						</div>
						<!-- /.form-group -->
						<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
							{!! Form::label('username', 'Username (*)') !!}
							{!! Form::text('username', null, ['class'=>'form-control','placeholder' => 'Username', 'minlength' => 5, 'maxlength' => 50, 'required', 'readonly'=>'readonly', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)']) !!}
							{!! $errors->first('username', '<p class="help-block">:message</p>') !!}
						</div>
						<!-- /.form-group -->
						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							{!! Form::label('email', 'Email (*)') !!}
							{!! Form::email('email', null, ['class'=>'form-control','placeholder' => 'Email', 'maxlength' => 255, 'required', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)']) !!}
							{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
						</div>
						<!-- /.form-group -->
						<div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
							{!! Form::label('picture', 'Profile Picture') !!}
							{!! Form::file('picture', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
							@if (Auth::user()->picture)
							<p>
								<img src="{{ Auth::user()->foto() }}" class="img-rounded img-responsive">
							</p>
							@endif
							{!! $errors->first('picture', '<p class="help-block">:message</p>') !!}
						</div>
						<!-- /.form-group -->
					</div>
					<div class="col-md-6">
						<div class="form-group{{ $errors->has('init_supp') ? ' has-error' : '' }}">
							{!! Form::label('init_supp', 'Init (*)') !!}
							@if (strlen(Auth::user()->username) > 5)
							{!! Form::text('init_supp', null, ['class'=>'form-control','placeholder' => 'Init', 'maxlength' => 10, 'required', 'readonly'=>'readonly', 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
							@else
							{!! Form::text('init_supp', null, ['class'=>'form-control','placeholder' => 'Init', 'maxlength' => 10, 'required', 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
							@endif
							{!! $errors->first('init_supp', '<p class="help-block">:message</p>') !!}
						</div>
						<!-- /.form-group -->
						<div class="form-group{{ $errors->has('no_hp') ? ' has-error' : '' }}">
							{!! Form::label('no_hp', 'No. HP') !!}
							{!! Form::text('no_hp', null, ['class'=>'form-control','placeholder' => 'No. HP', 'maxlength' => 15]) !!}
							{!! $errors->first('no_hp', '<p class="help-block">:message</p>') !!}
						</div>
						<!-- /.form-group -->
						<div class="form-group{{ $errors->has('telegram_id') ? ' has-error' : '' }}">
							{!! Form::label('telegram_id', 'ID Telegram') !!}
							{!! Form::text('telegram_id', null, ['class'=>'form-control','placeholder' => 'ID Telegram', 'maxlength' => 50]) !!}
							{!! $errors->first('telegram_id', '<p class="help-block">:message</p>') !!}
						</div>
						<!-- /.form-group -->
						<div class="form-group{{ $errors->has('st_collapse') ? ' has-error' : '' }}">
						{!! Form::label('st_collapse', 'Auto Hide Menu') !!}
							{!! Form::select('st_collapse', ['T' => 'Yes', 'F' => 'No'], null, ['class'=>'form-control select2', 'required']) !!}
							{!! $errors->first('st_collapse', '<p class="help-block">:message</p>') !!}
						</div>
						<!-- /.form-group -->
					</div>
				</div>
				<!-- /.row -->
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				{!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
				&nbsp;&nbsp;
				<a class="btn btn-default" href="{{ url('/settings/profile') }}">Cancel</a>
				&nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
			</div>
			{!! Form::close() !!}
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('scripts')
<script type="text/javascript">
	document.getElementById("name").focus();

	//Initialize Select2 Elements
    $(".select2").select2();

	function autoUpperCase(a){
		a.value = a.value.toUpperCase();
	}

	function autoLowerCase(a){
		a.value = a.value.toLowerCase();
	}

	$('#form_id').submit(function (e, params) {
		var localParams = params || {};
		if (!localParams.send) {
			e.preventDefault();
        //additional input validations can be done hear
        swal({
        	title: 'Are you sure?',
        	text: "",
        	type: 'question',
        	showCancelButton: true,
        	confirmButtonColor: '#3085d6',
        	cancelButtonColor: '#d33',
        	confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, save it!',
        	cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        	allowOutsideClick: true,
        	allowEscapeKey: true,
        	allowEnterKey: true,
        	reverseButtons: false,
        	focusCancel: false,
        }).then(function () {
		  // swal(
		  //   'Deleted!',
		  //   'Your file has been deleted.',
		  //   'success'
		  // )
		  //remove these events;
		  //window.onkeydown = null;
		  //window.onfocus = null;
		  $(e.currentTarget).trigger(e.type, { 'send': true });
		}, function (dismiss) {
		  // dismiss can be 'cancel', 'overlay',
		  // 'close', and 'timer'
		  if (dismiss === 'cancel') {
		    // swal(
		    //   'Cancelled',
		    //   'Your imaginary file is safe :)',
		    //   'error'
		    // )
		}
	})
    }
});
</script>
@endsection