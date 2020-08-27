@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Alat Ukur
        <small>Update Master Alat Ukur</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> QC - Alat Ukur</li>
        <li><a href="{{ route('mstalatukur.index') }}"><i class="fa fa-files-o"></i> Master Alat Ukur</a></li>
        <li class="active">Update Master Alat Ukur</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Master Alat Ukur</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($tclbr005m, ['url' => route('mstalatukur.update', base64_encode($tclbr005m->id_no)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eqc.mstalatukur._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection