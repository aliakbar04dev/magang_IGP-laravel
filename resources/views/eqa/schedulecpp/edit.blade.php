@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Schedule 
      <small>CPP</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i> QA - Schedule CPP</li>
      <li><a href="{{ route('schedulecpp.index') }}"><i class="fa fa-files-o"></i> Schedule CPP</a></li>
      <li class="active">Add Schedule CPP</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Schedule CPP</h3>
      </div>
      <!-- /.box-header -->
      
      <!-- form start -->
      {!! Form::model($schedulecpp, ['url' => route('schedulecpp.update', base64_encode($schedulecpp->no_doc)),
      'method' => 'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
      @include('eqa.schedulecpp._form')
      {!! Form::close() !!}
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection   