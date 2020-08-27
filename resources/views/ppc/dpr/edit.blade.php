@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        DPR
        <small>Update Delivery Problem Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PPC - Transaksi</li>
        <li><a href="{{ route('ppctdprs.index') }}"><i class="fa fa-files-o"></i> Daftar DPR</a></li>
        <li class="active">Update DPR</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update DPR</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($ppctdpr, ['url' => route('ppctdprs.update', base64_encode($ppctdpr->no_dpr)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('ppc.dpr._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection