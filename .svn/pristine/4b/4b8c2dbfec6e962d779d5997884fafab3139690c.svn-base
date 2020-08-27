@extends('layouts.app')
@section('content')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
        <small>Change Password</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-gear"></i> Change Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
		<div class="box box-primary">
	        <div class="box-header with-border">
			  <h3 class="box-title">Change Password</h3>
			</div>
        	<!-- /.box-header -->
        	<!-- form start -->
			{!! Form::model(auth()->user(), ['url' => url('/settings/password'),
							'method' => 'post', 'role'=>'form', 'id'=>'form_id']) !!}
		        <div class="box-body">
		          <div class="row">
		            <div class="col-md-6">
		              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					    {!! Form::label('password', 'Password lama (*)') !!}
						{!! Form::password('password', ['class'=>'form-control','placeholder' => 'Password lama', 'required']) !!}
						{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
					  </div>
		              <!-- /.form-group -->
		              <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
					    {!! Form::label('new_password', 'Password baru (*)') !!}
						{!! Form::password('new_password', ['class'=>'form-control','placeholder' => 'Password baru', 'required']) !!}
						{!! $errors->first('new_password', '<p class="help-block">:message</p>') !!}
					  </div>
		              <!-- /.form-group -->
		              <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
					    {!! Form::label('new_password_confirmation', 'Konfirmasi password (*)') !!}
						{!! Form::password('new_password_confirmation', ['class'=>'form-control','placeholder' => 'Konfirmasi Password baru', 'required']) !!}
						{!! $errors->first('new_password_confirmation', '<p class="help-block">:message</p>') !!}
					  </div>
					  <!-- /.form-group -->
					  @if (strlen(Auth::user()->username) == 5)
					  <div class="form-group{{ $errors->has('portal') ? ' has-error' : '' }}">
					  	{!! Form::checkbox('portal', 'T', true, ['id'=>'portal']) !!} <b>Portal</b>&nbsp;&nbsp;
					  	{!! Form::checkbox('intranet', 'T', null, ['id'=>'intranet']) !!} <b>Intranet</b>&nbsp;&nbsp;
					  	{!! Form::checkbox('igpro', 'T', null, ['id'=>'igpro']) !!} <b>IG-Pro</b>
					  	{!! $errors->first('portal', '<p class="help-block">:message</p>') !!}
					  </div>
					  <!-- /.form-group -->
					  @endif
					  <div class="form-group">
					    <p class="help-block">(*) tidak boleh kosong</p>
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
				  <a class="btn btn-default" href="{{ url('/home') }}">Cancel</a>
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
document.getElementById("password").focus();

$(function () {
	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
  });
});

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