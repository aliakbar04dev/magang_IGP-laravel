@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Surat Jalan Claim
        <small>Update Surat Jalan Claim</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> CLAIM - TRANSAKSI</li>
        <li><a href="{{ route('ppctdnclaimsj1s.index') }}"><i class="fa fa-files-o"></i> SURAT JALAN CLAIM</a></li>
        <li class="active">Update SJ CLAIM</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Surat Jalan Claim</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($model, ['url' => route('ppctdnclaimsj1s.update', base64_encode($model->no_certi)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eppc.sjclaim._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection