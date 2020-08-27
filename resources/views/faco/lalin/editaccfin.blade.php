@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Serah Terima dari Accounting ke Finance
        {{-- <small>Update Serah Terima dari Accounting ke Finance</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> FACO - Lalu Lintas</li>
        <li><a href="{{ route('lalins.indexaccfin') }}"><i class="fa fa-files-o"></i> Accounting ke Finance</a></li>
        <li class="active">Update Serah Terima</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Serah Terima dari Accounting ke Finance</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($model, ['url' => route('lalins.update', base64_encode($model->no_laf)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('faco.lalin._formaccfin')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection