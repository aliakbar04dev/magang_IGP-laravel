@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Alat Ukur
        <small>Update Riwayat Alat Ukur</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> QC - Alat Ukur</li>
        <li><a href="{{ route('histalatukur.index') }}"><i class="fa fa-files-o"></i> Riwayat Alat Ukur</a></li>
        <li class="active">Update Riwayat Alat Ukur</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Riwayat Alat Ukur</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($tclbr001t, ['url' => route('histalatukur.update', base64_encode($tclbr001t->no_serial)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eqc.histalatukur._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection