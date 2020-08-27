@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Simbol PFC
        <small>Update Simbol PFC</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - MASTER</li>
        <li><a href="{{ route('engtmsimbols.index') }}"><i class="fa fa-files-o"></i> Simbol PFC</a></li>
        <li class="active">Update Simbol PFC</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Simbol PFC</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($engtmsimbol, ['url' => route('engtmsimbols.update', base64_encode($engtmsimbol->id)),
            'method'=>'put', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eng.pfc.simbol._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection