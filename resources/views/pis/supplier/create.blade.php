
@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      PART INSPECTION STANDARD (PIS)
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i>PART INSPECTION STANDARD (PIS)</li>
      <li class="active">Add PIS</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border" style="background-color: #FF6347">
        <h3 class="box-title" style="font-size:1vw;">INPUT PART INSPECTION STANDARD (PIS)</h3>
      </div>
      <!-- /.box-header -->

      <!-- form start -->
      {!! Form::open(['url' => route('pistandards.store'),
      'method' => 'post', 'files'=>'true', 'role'=>'form', 'id'=>'form_id']) !!}
      @include('pis.supplier._form')
      {!! Form::close() !!}
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection