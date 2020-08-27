@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Part
        <small>Update Part</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - MASTER</li>
        <li><a href="{{ route('engtmparts.index') }}"><i class="fa fa-files-o"></i> Part</a></li>
        <li class="active">Update Part</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Part</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($engtmparts, ['url' => route('engtmparts.update', base64_encode($engtmparts->part_no)),
            'method'=>'put', 'role'=>'form', 'class'=>'form-horizontal', 'id'=>'form_id']) !!}
          @include('eng.master.part._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection