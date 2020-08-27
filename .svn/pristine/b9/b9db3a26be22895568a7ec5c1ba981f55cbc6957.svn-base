@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master PIC Ijin Kerja
        <small>Add PIC Ijin Kerja</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> EHS - Master</li>
        <li><a href="{{ route('ehsmwppics.index') }}"><i class="fa fa-files-o"></i> PIC Ijin Kerja</a></li>
        <li class="active">Add PIC Ijin Kerja</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add PIC Ijin Kerja</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::open(['url' => route('ehsmwppics.store'),
            'method' => 'post', 'files'=>'true', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('ehs.wp.pic._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection