@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Pekerjaan
        <small>Update Laporan Pekerjaan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('tmtcwo1s.index') }}"><i class="fa fa-files-o"></i> Laporan Pekerjaan</a></li>
        <li class="active">Update LP</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Laporan Pekerjaan</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($tmtcwo1, ['url' => route('tmtcwo1s.update', base64_encode($tmtcwo1->no_wo)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('mtc.lp._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection