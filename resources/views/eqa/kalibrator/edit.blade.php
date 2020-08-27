@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Kalibrator
        <small>Update Master Kalibrator</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> QA - Kalibrator</li>
        <li><a href="{{ route('kalibrator.index') }}"><i class="fa fa-files-o"></i> Master Kalibrator</a></li>
        <li class="active">Update Master Kalibrator</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Master Kalibrator</h3> &nbsp;&nbsp; <a class="btn btn-primary" href="{{ route('kalibrator.create') }}"><span class="fa fa-plus"></span> Add Kalibrator</a>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($mcalkalibrator, ['url' => route('kalibrator.update', base64_encode($mcalkalibrator->nomor)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eqa.kalibrator._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection