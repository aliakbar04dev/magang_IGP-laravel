@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Permintaan Kalibrasi
        <small>Alat Ukur</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> QA - Alat Ukur</li>
        <li><a href="{{ route('kalibrasi.index') }}"><i class="fa fa-files-o"></i> Permintaan Kalibrasi</a></li>
        <li class="active">Update Permintaan Kalibrasi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Permintaan Kalibrasi</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($tcalorder1, ['url' => route('kalibrasi.update', base64_encode($tcalorder1->no_order)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eqa.kalibrasi._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection