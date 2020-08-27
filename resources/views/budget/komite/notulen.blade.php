@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Komite Investasi
        <small>Notulen Komite Investasi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('bgttkomite1s.allnotulen') }}"><i class="fa fa-files-o"></i> Notulen Komite Investasi</a></li>
        <li class="active">Notulen Komite Investasi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Notulen Komite Investasi</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($bgttkomite1, ['url' => route('bgttkomite1s.updatenotulen', base64_encode($bgttkomite1->no_komite)),
            'method'=>'post', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('budget.komite._formnotulen')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection