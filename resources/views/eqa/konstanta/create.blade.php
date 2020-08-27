@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Konstanta 
      <small>Konstanta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> QA - Konstanta</li>
        <li><a href="{{ route('konstanta.index') }}"><i class="fa fa-files-o"></i> Master Konstanta</a></li>
        <li class="active">Add Master Konstanta</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Master Konstanta</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::open(['url' => route('konstanta.store'),
            'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
           @include('eqa.konstanta._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection