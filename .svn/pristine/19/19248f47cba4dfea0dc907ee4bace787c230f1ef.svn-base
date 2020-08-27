@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Email Supplier (QPR)
        <small>Update Email Supplier (QPR)</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-exchange"></i> QPR</li>
        <li><a href="{{ route('qpremails.index') }}"><i class="fa fa-lock"></i> Daftar Email Supplier (QPR)</a></li>
        <li class="active">Update Email</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Email Supplier (QPR)</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($qpremail, ['url' => route('qpremails.update', base64_encode($qpremail->id)),
            'method'=>'put', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('eqc.emails._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection