@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Check Sheet 
      <small>CPP</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i> QA - Check Sheet Schedule CPP</li>
      <li><a href="{{ route('schedulecpp.index') }}"><i class="fa fa-files-o"></i> Schedule CPP</a></li>
      <li class="active">Update Check Sheet</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Update Check Sheet</h3>
      </div>
      <!-- /.box-header -->

      <!-- form start -->
      {!! Form::model($qatTrCpp01, ['url' => route('ceksheetcpp.update', base64_encode($qatTrCpp01->no_doc)),
      'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
      @include('eqa.schedulecpp.ceksheet._form')
      {!! Form::close() !!}
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection