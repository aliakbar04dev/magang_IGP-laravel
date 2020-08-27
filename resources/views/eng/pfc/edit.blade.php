@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PFC
        <small>Update Process Flow Chart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - TRANSAKSI - PFC</li>
        <li><a href="{{ route('engttpfc1s.index') }}"><i class="fa fa-files-o"></i> Daftar PFC</a></li>
        <li class="active">Update PFC</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update PFC</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($engttpfc1, ['url' => route('engttpfc1s.update', base64_encode($engttpfc1->id)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eng.pfc._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection