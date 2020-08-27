
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
      <div class="box-header with-border">
        <h3 class="box-title"></h3>
      </div>
      <!-- /.box-header -->


      {!! Form::model($pistandard, ['url' => route('pistandards.postrevisi', [ base64_decode($pistandard->no_pisigp), base64_decode($pistandard->norev)]),
      'method'=>'post', 'files'=>'true', 'class'=>'form-horizontal']) !!}
      @include('pis.supplier._formrevisi ')
      {!! Form::close() !!}
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection