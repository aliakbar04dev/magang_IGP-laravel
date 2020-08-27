@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Serah dari Finance ke Kasir
        {{-- <small>Add Serah dari Finance ke Kasir</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> FACO - Lalu Lintas</li>
        <li><a href="{{ route('lalins.indexfinksr') }}"><i class="fa fa-files-o"></i> Finance ke Kasir</a></li>
        <li class="active">Add Serah</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Serah Terima dari Finance ke Kasir</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::open(['url' => route('lalins.store'),
            'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('faco.lalin._formfinksr')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection