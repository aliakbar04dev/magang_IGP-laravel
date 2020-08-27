@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mapping BPID
        <small>Update Mapping BPID</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - MASTER - PO</li>
        <li><a href="{{ route('prctepobpids.index') }}"><i class="fa fa-files-o"></i> Mapping BPID</a></li>
        <li class="active">Update Mapping BPID</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Mapping BPID</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($prctepobpid, ['url' => route('prctepobpids.update', base64_encode($prctepobpid->kd_bpid)),
            'method'=>'put', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eproc.po.mapping._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection