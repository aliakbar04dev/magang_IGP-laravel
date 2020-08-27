@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Production 
      <small>POS</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i> Production - Production POS</li>
      <li><a href="{{ route('schedulecpp.index') }}"><i class="fa fa-files-o"></i> Production POS</a></li>
      <li class="active">Add Production POS</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Production POS</h3>
      </div>
      <!-- /.box-header -->
      
      <!-- form start -->
      {!! Form::model($prodpos, ['url' => route('prodpos.update', base64_encode($prodpos->id)),
      'method' => 'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
      @include('prod.prodpos._form')
      {!! Form::close() !!}
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection   