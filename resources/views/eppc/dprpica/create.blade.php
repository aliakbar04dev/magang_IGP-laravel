@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PICA DEPR
        <small>Add PICA DEPR</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> E-PPC - Transaksi</li>
        <li><a href="{{ route('ppctdprs.showall', base64_encode($no_dpr)) }}"><i class="fa fa-exchange"></i> {{ $no_dpr }}</a></li>
        <li class="active">Add PICA DEPR</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add PICA DEPR: <strong>{{ $no_dpr }}</strong></h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::open(['url' => route('ppctdprpicas.store'),
            'method' => 'post', 'files'=>'true', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eppc.dprpica._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection