@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Humidity & Temperature
        <small>Update Master Humidity & Temperature</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> QA - Humidity & Temperature</li>
        <li><a href="{{ route('klbrtemp.index') }}"><i class="fa fa-files-o"></i> Master Humidity & Temperature</a></li>
        <li class="active">Update Master Humidity & Temperature</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Master Humidity & Temperature</h3> &nbsp;&nbsp; <a class="btn btn-primary" href="{{ route('klbrtemp.create') }}"><span class="fa fa-plus"></span> Add Humidity & Temperature</a>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($mcaltemphumi, ['url' => route('klbrtemp.update', base64_encode($mcaltemphumi->nomor)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eqa.klbrtemp._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection