@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        NPK/Plant
        <small>Update NPK/Plant</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Master</li>
        <li><a href="{{ route('prodnpks.index') }}"><i class="fa fa-files-o"></i> NPK/Plant</a></li>
        <li class="active">Update NPK/Plant</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update NPK/Plant</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($prodnpk, ['url' => route('prodnpks.update', base64_encode($prodnpk->npk)),
            'method'=>'put', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('prod.plant._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection