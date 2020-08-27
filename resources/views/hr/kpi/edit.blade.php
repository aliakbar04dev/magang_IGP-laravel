@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        KPI Division
        <small>Update KPI Division <b>{{ Auth::user()->masKaryawan()->desc_div }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('hrdtkpis.index') }}"><i class="fa fa-files-o"></i> Daftar KPI Division</a></li>
        <li class="active">Update KPI Division {{ $hrdtkpi->tahun }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update KPI Division {{ $hrdtkpi->tahun }}</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($hrdtkpi, ['url' => route('hrdtkpis.update', base64_encode($hrdtkpi->id)),
            'method'=>'put', 'files'=>'true', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('hr.kpi._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection