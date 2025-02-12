@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kebutuhan Spare Parts Plant
        <small>Update Kebutuhan Spare Parts Plant</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('mtctlogpkbs.index') }}"><i class="fa fa-files-o"></i> Kebutuhan Spare Parts Plant</a></li>
        <li class="active">Update Kebutuhan Spare Parts Plant</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Kebutuhan Spare Parts Plant</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($mtctlogpkb, ['url' => route('mtctlogpkbs.update', base64_encode(\Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis'))),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('mtc.logbookpkb._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection