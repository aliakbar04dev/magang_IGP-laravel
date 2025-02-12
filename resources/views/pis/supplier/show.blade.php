
@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
    PART INSPECTION STANDARD (PIS)
    <small>Revisi Data</small>
    </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Master</li>
        <li><a href=""><i class="fa fa-files-o"></i>PART INSPECTION STANDARD (PIS)</a></li>
      </ol>
    </section>

    <!-- Main content -->
  
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($pistandards, ['url' => route('pisstaff.store', [base64_decode($pistandards->no_pisigp),base64_decode($pistandards->norev),base64_decode($pistandards->submit)]),
            'method'=>'post', 'role'=>'form', 'files'=>'true','id'=>'form_id']) !!}
          @include('pis.supplier._show')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection