@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Konstanta
        <small>Update Master Konstanta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> QA - Konstanta</li>
        <li><a href="{{ route('konstanta.index') }}"><i class="fa fa-files-o"></i> Master Konstanta</a></li>
        <li class="active">Update Master Konstanta</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Master Konstanta</h3> &nbsp;&nbsp; <a class="btn btn-primary" href="{{ route('konstanta.create') }}"><span class="fa fa-plus"></span> Add Konstanta</a>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($mcalkonstanta, ['url' => route('konstanta.update', base64_encode($mcalkonstanta->kode_kons)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eqa.konstanta._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection