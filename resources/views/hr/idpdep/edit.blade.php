@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        IDP
        <small>Update Individual Development Plan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('hrdtidpdep1s.index') }}"><i class="fa fa-files-o"></i> Daftar IDP</a></li>
        <li class="active">Update IDP {{ $hrdtidpdep1->tahun }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update IDP {{ $hrdtidpdep1->tahun }}</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($hrdtidpdep1, ['url' => route('hrdtidpdep1s.update', base64_encode($hrdtidpdep1->id)),
            'method'=>'put', 'files'=>'true', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('hr.idpdep._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection