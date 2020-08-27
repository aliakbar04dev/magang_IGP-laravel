@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PICA
        <small>Update PICA</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('picas.index') }}"><i class="fa fa-exchange"></i> PICA</a></li>
        <li class="active">Update PICA</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update PICA</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($pica, ['url' => route('picas.update', base64_encode($pica->id)),
            'method'=>'put', 'files'=>'true', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eqc.picas._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection