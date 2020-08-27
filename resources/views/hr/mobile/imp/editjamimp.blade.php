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
		  <li class="active">Edit Jam Pengajuan IMP</li>
      </ol>
    </section>
	
	
    

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Ijin Meninggalkan Pekerjaan</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
     <div class="box-body">
  <div class="form-group">
 {!! Form::model($ImpPengajuan, ['url' => route('mobiles.update', base64_encode($ImpPengajuan->noimp)),
           'method'=>'put', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}


  
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


			<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
			{!! Form::label('Status', 'Status Permintaan', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			<td>
				@if($ImpPengajuan->status == 0)
			        <b style="color: red">BELOM APPROVE</b>        
				@elseif($ImpPengajuan->status == 1)	
				    <b style="color: green">DISETUJUI</b>  	
				@elseif($ImpPengajuan->status == 2)
				   <b style="color: red">DITOLAK</b>  
				@endif			
			</td>
			</div>
			</div>
	

		<hr>

			
				<div class="form-group{{ $errors->has('jamimp') ? ' has-error' : '' }}">
				{!! Form::label('jamimp', 'Jam Berangkat', ['class'=>'col-md-2 control-label']) !!}
				<div class="col-md-4">

	
					 	{!! Form::time('jamimp', null , ['class'=>'form-control ']) !!}
					 	{!! $errors->first('jamimp', '<p class="help-block">:message</p>') !!}
			
				</div>
				</div>
				

			
			<br>

			<div class="form-group{{ $errors->has('nopol') ? ' has-error' : '' }}">
			{!! Form::label('nopol', 'No Pol', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::text('nopol', null, ['class'=>'form-control ','readonly']) !!}
			
			{!! $errors->first('nopol', '<p class="help-block">:message</p>') !!}
			</div>
			</div>

			<div class="form-group{{ $errors->has('keperluan') ? ' has-error' : '' }}">
			{!! Form::label('keperluan', 'keperluan', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::textarea('keperluan', null, ['class'=>'form-control ','readonly']) !!}
			
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