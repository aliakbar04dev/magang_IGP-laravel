@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Rate MP
        <small>Update Master Rate MP</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - Master</li>
        <li><a href="{{ route('bgttcrrates.index') }}"><i class="fa fa-files-o"></i> Rate MP</a></li>
        <li class="active">Update Rate MP</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Master Rate MP</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($bgttcrrate, ['url' => route('bgttcrrates.update', base64_encode($bgttcrrate->thn_period)),
            'method'=>'put', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('budget.rate._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection