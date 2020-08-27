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
        <li><i class="fa fa-files-o"></i> E-PROCUREMENT - REQUEST FOR QUOTATION</li>
        <li><a href="{{ route('prctrfqs.indexall') }}"><i class="fa fa-files-o"></i> Daftar RFQ</a></li>
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
        {!! Form::model($prctrfq, ['url' => route('prctrfqs.update', base64_encode($prctrfq->no_rfq)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @if ($prctrfq->nm_proses === "FORGING")
            @include('eproc.rfq._form-forging')
          @elseif($prctrfq->nm_proses === "TUBE")
            @include('eproc.rfq._form-tube')
          @elseif($prctrfq->nm_proses === "ASSY PART")
            @include('eproc.rfq._form-assypart')
          @elseif($prctrfq->nm_proses === "MACHINING")
            @include('eproc.rfq._form-machining')
          @elseif($prctrfq->nm_proses === "HEAT TREATMENT")
            @include('eproc.rfq._form-ht')
          @elseif($prctrfq->nm_proses === "STAMPING")
            @include('eproc.rfq._form-stamping')
          @elseif($prctrfq->nm_proses === "PAINTING")
            @include('eproc.rfq._form-painting')
          @elseif($prctrfq->nm_proses === "CASTING")
            @include('eproc.rfq._form-casting')
          @endif
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection