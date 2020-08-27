@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Setting Jenis Oli/Mesin
        <small>Update Setting Jenis Oli/Mesin</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Master</li>
        <li><a href="{{ route('mtctmoilings.index') }}"><i class="fa fa-files-o"></i> Setting Jenis Oli/Mesin</a></li>
        <li class="active">Update</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Setting Jenis Oli/Mesin</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($mtctmoiling, ['url' => route('mtctmoilings.update', base64_encode($mtctmoiling->kd_mesin)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('mtc.oli.setting._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection