@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        BPB CR Consumable
        <small>Reguler</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-truck"></i> PPC - TRANSAKSI</li>
        <li><a href="{{ route('bpbcrcons.index') }}"><i class="fa fa-files-o"></i> PPC - BPB CR Consumable Reguler</a></li>
        <li class="active">Update BPB CR Consumable Reguler</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Update BPB CR Consumable Reguler</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
        {!! Form::model($whstconscr01, ['url' => route('bpbcrcons.update', base64_encode($whstconscr01->no_doc)),
            'method'=>'put', 'files'=>'true', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
          @include('ppc.bpbcrcons._form')
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection