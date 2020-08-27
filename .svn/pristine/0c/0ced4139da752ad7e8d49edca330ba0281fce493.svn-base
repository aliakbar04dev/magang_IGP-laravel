@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Daftar Masalah [Plant]
        <small>Update Daftar Masalah</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('mtctdftmslhplants.index') }}"><i class="fa fa-files-o"></i> Daftar Masalah [Plant]</a></li>
        <li class="active">
          Update DM
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Update Daftar Masalah [Plant]
          </h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($mtctdftmslh, ['url' => route('mtctdftmslhplants.update', base64_encode($mtctdftmslh->no_dm)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('mtc.mtctdftmslhplant._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection