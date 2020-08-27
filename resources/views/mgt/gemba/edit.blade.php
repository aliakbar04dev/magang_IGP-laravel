@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @if ($mode_cm === "T")
          Daftar Genba BOD - Countermeasure
          <small>Update Genba BOD - Countermeasure</small>
        @else
          Daftar Genba BOD
          <small>Update Genba BOD</small>
        @endif
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> MANAGEMENT - Transaksi</li>
        @if ($mode_cm === "T")
          <li><a href="{{ route('mgmtgembas.indexcm') }}"><i class="fa fa-files-o"></i> Daftar Genba BOD - CM</a></li>
        @else
          <li><a href="{{ route('mgmtgembas.index') }}"><i class="fa fa-files-o"></i> Daftar Genba BOD</a></li>
        @endif
        <li class="active">Update Genba BOD</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          @if ($mode_cm === "T")
            <h3 class="box-title">Update Genba BOD - Countermeasure</h3>
          @else
            <h3 class="box-title">Update Genba BOD</h3>
            @if (!empty($mgmtgemba->no_gemba))
              <div class="box-tools pull-right">
                <a class="btn btn-success" href="{{ route('mgmtgembas.create') }}">
                  <span class="fa fa-plus"></span>
                </a>
              </div>
            @endif
          @endif
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($mgmtgemba, ['url' => route('mgmtgembas.update', base64_encode($mgmtgemba->no_gemba)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('mgt.gemba._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection