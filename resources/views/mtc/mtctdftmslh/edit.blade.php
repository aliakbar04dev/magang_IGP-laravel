@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @if ($mtctdftmslh->st_cms === "T")
          Daftar CMS
          <small>Update CMS</small>
        @else
          Daftar Masalah
          <small>Update Daftar Masalah</small>
        @endif
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li>
          @if ($mtctdftmslh->st_cms === "T")
            <a href="{{ route('mtctdftmslhs.indexcms') }}"><i class="fa fa-files-o"></i> Daftar CMS</a>
          @else
            <a href="{{ route('mtctdftmslhs.index') }}"><i class="fa fa-files-o"></i> Daftar Masalah</a>
          @endif
        </li>
        <li class="active">
          @if ($mtctdftmslh->st_cms === "T")
            Update CMS
          @else
            Update DM
          @endif
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            @if ($mtctdftmslh->st_cms === "T")
              Update CMS
            @else
              Update Daftar Masalah
            @endif
          </h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($mtctdftmslh, ['url' => route('mtctdftmslhs.update', base64_encode($mtctdftmslh->no_dm)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @if ($mtctdftmslh->st_cms === "T")
            @include('mtc.mtctdftmslh._formcms')
          @else
            @include('mtc.mtctdftmslh._form')
          @endif
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection