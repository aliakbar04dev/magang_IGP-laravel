@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Permission
        <small>Update Permission</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('permissions.index') }}"><i class="fa fa-lock"></i> Permission</a></li>
        <li class="active">Update Permission</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update Permission</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($permission, ['url' => route('permissions.update', base64_encode($permission->id)),
            'method'=>'put', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('permissions._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection