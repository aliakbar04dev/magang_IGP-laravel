@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Scan Surat Jalan Claim
        <small>Scan Surat Jalan Claim</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PPC KIM - TRANSAKSI</li>
        <li><a href="{{ route('ppctdnclaimsj1s.all') }}"><i class="fa fa-files-o"></i> SURAT JALAN CLAIM</a></li>
        <li class="active">Scan SJ CLAIM</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Scan Surat Jalan Claim</h3>
        </div>
        <!-- /.box-header -->
        @include('eppc.sjclaim._formscan')
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection