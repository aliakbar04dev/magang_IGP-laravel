@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Line
        <small>Update Line</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - MASTER</li>
        <li><a href="{{ route('engtmlines.index') }}"><i class="fa fa-files-o"></i> Line</a></li>
        <li class="active">Update Line</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Line</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($engtmlines, ['url' => route('engtmlines.update', base64_encode($engtmlines->kd_line)),
            'method'=>'put', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eng.master.line._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection