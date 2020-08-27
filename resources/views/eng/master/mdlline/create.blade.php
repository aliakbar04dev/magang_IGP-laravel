@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Model Line
        <small>Add Model Line</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - MASTER</li>
        <li><a href="{{ route('engtmdllines.index') }}"><i class="fa fa-files-o"></i> Model Line</a></li>
        <li class="active">Add Model Line</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Model Line</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::open(['url' => route('engtmdllines.store'),
            'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eng.master.mdlline._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection