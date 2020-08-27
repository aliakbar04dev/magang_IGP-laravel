@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Serah Terima dari Kasir ke Accounting
        {{-- <small>Update Serah Terima dari Kasir ke Accounting</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> FACO - Lalu Lintas</li>
        <li><a href="{{ route('lalins.indexksracc') }}"><i class="fa fa-files-o"></i> Kasir ke Accounting</a></li>
        <li class="active">Update Serah Terima</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Serah Terima dari Kasir ke Accounting</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($model, ['url' => route('lalins.update', base64_encode($model->no_lka)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('faco.lalin._formksracc')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection