@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        CR Activities
        <small>Update CR Activities</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - TRANSAKSI</li>
        <li><a href="{{ route('bgttcrregiss.index') }}"><i class="fa fa-files-o"></i> CR Activities</a></li>
        <li class="active">Update CR Activities</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update CR Activities</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($bgttcrregis, ['url' => route('bgttcrregiss.update', base64_encode($bgttcrregis->id)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('budget.activity._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection