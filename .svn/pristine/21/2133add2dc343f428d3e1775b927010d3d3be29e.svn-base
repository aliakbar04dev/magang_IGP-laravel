@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	
	<section class="content-header">
      <h1>
        Ijin Meninggalkan Pekerjaan
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> IMP</li>
        <li><a href="{{ route('mobiles.indeximp') }}"><i class="fa fa-files-o"></i> Ijin Meninggalkan Pekerjaan </a></li>
		  <li class="active">Tambah Pengajuan IMP</li>
      </ol>
    </section>
	
	
        <!-- Main content -->
    <section class="content">
      {{-- @include('layouts._flash') --}}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Ijin Meninggalkan Pekerjaan</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
     <div class="box-body">
  <div class="form-group">
  {!! Form::open(['url' => route('mobiles.storeimp'), 'method' => 'post', 'class'=>'form-horizontal','id' => 'form_id']) !!}


  
<br>			
			<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
			{!! Form::label('nama', 'Nama Karyawan', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::text('nama', $kar->first()->nama, ['class'=>'form-control' , 'readonly' => 'true']) !!}
			{!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
			</div>
			</div>
<br>



			<div class="form-group{{ $errors->has('namaatasan') ? ' has-error' : '' }}">
			{!! Form::label('namaatasan', 'Nama Atasan', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::text('namaatasan', $namaatasan->first()->nama, ['class'=>'form-control' , 'readonly' => 'true']) !!}
			{!! $errors->first('namaatasan', '<p class="help-block">:message</p>') !!}
			</div>
			</div>

<br>
			<div class="form-group{{ $errors->has('npkatasan') ? ' has-error' : '' }}">
			<div class="col-md-4">
			{!! Form::hidden('npkatasan', $kar->first()->npk_atasan, ['class'=>'form-control' , 'readonly' => 'true']) !!}
			{!! $errors->first('npkatasan', '<p class="help-block">:message</p>') !!}
			</div>
			</div>


			<div class=  "form-group{{ $errors->has('status') ? ' has-error' : '' }}">
			{!! Form::label('Status', 'Status Permintaan', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			<td>
				<b style="color: red">BELOM APPROVE</b>  	
			</td>
			</div>
			</div>
	

<hr>


			<div class="form-group{{ $errors->has('jamimp') ? ' has-error' : '' }}">
			{!! Form::label('jamimp', 'Jam Berangkat', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::time('jamimp',null , ['class'=>'form-control ','disable']) !!}
			
			{!! $errors->first('jamimp', '<p class="help-block">:message</p>') !!}
			</div>
			</div>
			
			<br>

			<div class="form-group{{ $errors->has('nopol') ? ' has-error' : '' }}">
			{!! Form::label('nopol', 'No Pol', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::text('nopol', null, ['class'=>'form-control ']) !!}
			
			{!! $errors->first('nopol', '<p class="help-block">:message</p>') !!}
			</div>
			</div>

			<div class="form-group{{ $errors->has('keperluan') ? ' has-error' : '' }}">
			{!! Form::label('keperluan', 'keperluan', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::textarea('keperluan', null, ['class'=>'form-control ']) !!}
			
			{!! $errors->first('keperluan', '<p class="help-block">:message</p>') !!}
			</div>
			</div>

	
			
			<br>


<br> <br>

	<div class="box-footer">
			<div class="form-group">
			<div class="col-md-4 col-md-offset-2"> 
			{!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!} 
			 <a class="btn btn-default" href="{{ route('mobiles.indeximp') }}"> Batal </a> 
			</div>
			</div>
			</div>
			
			{!! Form::close() !!}
			
</div>
</div>


      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('scripts')

<script type="text/javascript">
	$('#form_id').submit(function (e, params) {

	  var localParams = params || {};
	  if (!localParams.send) {
	    e.preventDefault();
	    var valid = 'T';
	    if(valid === 'T') {
	      //additional input validations can be done hear
	      swal({
	        title: 'Apakah data pengajuan sudah benar?',
	        text: '',
	        type: 'question',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
	        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No!',
	        allowOutsideClick: true,
	        allowEscapeKey: true,
	        allowEnterKey: true,
	        reverseButtons: false,
	        focusCancel: false,
	      }).then(function () {
	        $(e.currentTarget).trigger(e.type, { 'send': true });
	          swal({
	            position: 'top-end',
	            type: 'success',
	            title: 'Berhasil Mengajukan Ijin Meninggalkan Pekerjaan!',
	            text: '',
	            showConfirmButton: false,
	            timer: 2500
	          })
	        //  table.ajax.reload();
	          
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
	  }
	});
</script>

@endsection
