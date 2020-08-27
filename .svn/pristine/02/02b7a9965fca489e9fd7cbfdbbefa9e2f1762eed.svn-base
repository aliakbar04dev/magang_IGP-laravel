@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	
	<section class="content-header">
      <h1>
        Daftar Pengajuan Lupa Prik
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Lupa Prik</li>
        <li><a href="{{ route('mobiles.indexlupaprik') }}"><i class="fa fa-files-o"></i> Daftar Pengajuan </a></li>
		  <li class="active">Tambah Lupa Prik</li>
      </ol>
    </section>
	
	
    

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Pengajuan Lupa Prik</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
     <div class="box-body">
  <div class="form-group">
  {!! Form::open(['url' => route('mobiles.storelupaprik'), 'method' => 'post', 'class'=>'form-horizontal']) !!}


			<div class="form-group{{ $errors->has('npk') ? ' has-error' : '' }}">
			{!! Form::label('npk', 'NPK Pemohon', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::text('npk', ($kar->first()->npk), ['class'=>'form-control' , 'readonly' => 'true']) !!}
			{!! $errors->first('npk', '<p class="help-block">:message</p>') !!}
			</div>
			</div>

<br>			
			<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
			{!! Form::label('nama', 'Nama Pemohon', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::text('nama', $kar->first()->nama, ['class'=>'form-control' , 'readonly' => 'true']) !!}
			{!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
			</div>
			</div>
<br>

			<div class="form-group{{ $errors->has('namapt') ? ' has-error' : '' }}">
			{!! Form::label('namapt', 'Nama PT', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::text('namapt', $kar->first()->kd_pt, ['class'=>'form-control' , 'readonly' => 'true']) !!}
			{!! $errors->first('namapt', '<p class="help-block">:message</p>') !!}
			</div>
			</div>			
			
			
<br>

			<div class="form-group{{ $errors->has('namabagian') ? ' has-error' : '' }}">
			{!! Form::label('namabagian', 'Nama Dept.', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::text('namabagian', $kar->first()->desc_dep, ['class'=>'form-control' , 'readonly' => 'true']) !!}
			{!! $errors->first('namabagian', '<p class="help-block">:message</p>') !!}
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
	

<hr>
			
			<div class="form-group{{ $errors->has('tgllupa') ? ' has-error' : '' }}">
			{!! Form::label('tgllupa', 'Tanggal Lupa', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::date('tgllupa', null, ['class'=>'form-control']) !!}
			{!! $errors->first('tgllupa', '<p class="help-block">:message</p>') !!}
			</div>
			</div>
			<br>

			<div class="form-group{{ $errors->has('jamin') ? ' has-error' : '' }}">
			{!! Form::label('jamin', 'Jam Masuk', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::time('jamin', null, ['class'=>'form-control ']) !!}
			
			{!! $errors->first('jamin', '<p class="help-block">:message</p>') !!}
			</div>
			</div>
			
			<br>

			<div class="form-group{{ $errors->has('jamout') ? ' has-error' : '' }}">
			{!! Form::label('jamout', 'Jam Keluar', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::time('jamout', null, ['class'=>'form-control']) !!}
			{!! $errors->first('jamout', '<p class="help-block">:message</p>') !!}
			</div>
			</div>
			
			<br>

			<div class="form-group{{ $errors->has('alasanlupa') ? ' has-error' : '' }}">
			{!! Form::label('alasanlupa', 'Alasan Lupa', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-4">
			{!! Form::text('alasanlupa', null, ['class'=>'form-control']) !!}
			{!! $errors->first('alasanlupa', '<p class="help-block">:message</p>') !!}
			</div>
			</div>
<br> <br>

	<div class="box-footer">
			<div class="form-group">
			<div class="col-md-4 col-md-offset-2"> 
			{!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!} 
			 <a class="btn btn-default" href="{{ route('mobiles.indexlupaprik') }}"> Batal </a> 
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