@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ijin Kerja
        <small>Update Ijin Kerja</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> EHS - Transaksi</li>
        <li><a href="{{ route('ehstwp1s.index') }}"><i class="fa fa-files-o"></i> Daftar Ijin Kerja</a></li>
        <li class="active">Update Ijin Kerja</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Ijin Kerja</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($ehstwp1, ['url' => route('ehstwp1s.update', base64_encode($ehstwp1->id)),
            'method'=>'put', 'files'=>'true', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('ehs.wp._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection