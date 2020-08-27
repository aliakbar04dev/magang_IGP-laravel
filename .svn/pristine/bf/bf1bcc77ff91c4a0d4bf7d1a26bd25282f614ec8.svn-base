@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Autorisasi Sertifikat
      <small>Kalibrasi</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i> QA - Autorisasi Sertifikat</li>
      <li><a href="{{ route('kalserti.indexapp') }}"><i class="fa fa-files-o"></i> Autorisasi Sertifikat</a></li>
      <li class="active">Autorisasi Sertifikat</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Autorisasi Sertifikat</h3>
      </div>
      <!-- /.box-header -->

      <!-- form start -->
      {!! Form::model($mcalserti, ['url' => route('kalserti.update', base64_encode($mcalserti->no_serti)),
      'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
      @include('eqa.kalserti.approval._form')
      {!! Form::close() !!}
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection