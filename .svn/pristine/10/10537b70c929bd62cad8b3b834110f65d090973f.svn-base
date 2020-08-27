@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        RFQ
        <small>Update Request For Quotation</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - RFQ</li>
        <li><a href="{{ route('prctrfqs.index') }}"><i class="fa fa-files-o"></i> Daftar RFQ</a></li>
        <li class="active">Update RFQ</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update RFQ</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($prctrfq, ['url' => route('prctrfqs.save', [base64_encode($prctrfq->no_ssr), base64_encode($prctrfq->part_no), base64_encode($prctrfq->nm_proses)]),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eproc.rfq._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection