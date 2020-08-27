@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Truck Control
        <small>Update Truck Control Delivery</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PPC - Monitoring</li>
        <li><a href="{{ route('mtruck.index') }}"><i class="fa fa-files-o"></i> Monitoring Truck Control</a></li>
        <li class="active">Update Truck Control Delivery</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Truck Control Delivery</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($ppctTruckCustRemark, ['url' => route('mtruck.update', base64_encode($ppctTruckCustRemark->no_cycle)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('ppc.mtruck._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection