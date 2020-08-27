@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Setting NPK
        <small>Update Setting NPK</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - MASTER - PO</li>
        <li><a href="{{ route('prcmnpks.index') }}"><i class="fa fa-files-o"></i> Setting NPK</a></li>
        <li class="active">Update NPK</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update NPK</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($prcmnpk, ['url' => route('prcmnpks.update', base64_encode($prcmnpk->npk)),
            'method'=>'put', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eproc.po.npk._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection