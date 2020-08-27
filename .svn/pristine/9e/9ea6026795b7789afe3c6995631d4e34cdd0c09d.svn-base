@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @if ($mode_cm === "T")
          Daftar EHS Patrol - Countermeasure
          <small>Update EHS Patrol - Countermeasure</small>
        @else
          Daftar EHS Patrol
          <small>Update EHS Patrol</small>
        @endif
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> EHS - Transaksi</li>
        @if ($mode_cm === "T")
          <li><a href="{{ route('mgmtgembaehss.indexcm') }}"><i class="fa fa-files-o"></i> Daftar EHS Patrol - CM</a></li>
        @else
          <li><a href="{{ route('mgmtgembaehss.index') }}"><i class="fa fa-files-o"></i> Daftar EHS Patrol</a></li>
        @endif
        <li class="active">Update EHS Patrol</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          @if ($mode_cm === "T")
            <h3 class="box-title">Update EHS Patrol - Countermeasure</h3>
          @else
            <h3 class="box-title">Update EHS Patrol</h3>
            <div class="box-tools pull-right">
              <a class="btn btn-success" href="{{ route('mgmtgembaehss.create') }}">
                <span class="fa fa-plus"></span>
              </a>
            </div>
          @endif
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($mgmtgemba, ['url' => route('mgmtgembaehss.update', base64_encode($mgmtgemba->no_gemba)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('mgt.gembaehs._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection