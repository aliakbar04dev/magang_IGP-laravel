@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        FCM
        <small>Update Form Characteristic Matrix</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - TRANSAKSI - FCM</li>
        <li><a href="{{ route('engtfcm1s.index') }}"><i class="fa fa-files-o"></i> Daftar FCM</a></li>
        <li class="active">Update FCM</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update FCM</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($engtfcm1, ['url' => route('engtfcm1s.update', base64_encode($engtfcm1->id)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eng.fcm._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection