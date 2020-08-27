@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Keterangan Pengajuan
        <small>Edit Pengajuan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i>HRD</li>
        <li><i class="fa fa-files-o"></i>Suket Karyawan</li>
        <li class="active"><i class="fa fa-files-o"></i>Edit Pengajuan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header text-center">Edit Data Pengajuan</div>


                <div class="box-body">

                   {{--  @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif--}}

                                @include('layouts._flash')

                    
                    
                    {{ Form::model($pengajusuket, ['url' => route('mobiles.updatesuketkaryawan', $pengajusuket[0]->nosk), 'method' => 'PUT', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'form_id']) }}
                  


                    <div class="form-group row">
                        <label for="nosk" class="col-md-4 col-form-label text-md-right">Nomor Surat</label>
                        <div class="col-md-4">
                            {!! Form::text('nosk', $pengajusuket[0]->nosk, ['class' => 'form-control', 'readonly' => '']) !!}                            
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tglsurat" class="col-md-4 col-form-label text-md-right">Tanggal</label>
                        <div class="col-md-4">
                            {!! Form::text('tglsurat', Carbon\Carbon::parse($pengajusuket[0]->tglsurat)->format('d-m-Y'), ['class' => 'form-control', 'readonly' => '']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="nama" class="col-md-4 col-form-label text-md-right">Nama Karyawan</label>
                        <div class="col-md-4">
                            
                            {!! Form::text('nama', $pengajusuket[0]->nama, ['class' => 'form-control', 'readonly' => '']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                        <div class="col-md-4">
                            {!! Form::text('status', $pengajusuket[0]->status, ['class' => 'form-control', 'readonly' => '']) !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('keperluan') ? ' has-error' : '' }}">
                        <label for="keperluan" class="col-md-4 col-form-label text-md-right">Keperluan</label>
                        <div class="col-md-5">
                            
                            
                            
                            {!! Form::textarea('keperluan', $pengajusuket[0]->keperluan, ['class'=>'form-control' ]) !!}
                        {!! $errors->first('keperluan', '<p class="help-block">:message</p>') !!}
                                                        
                            
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-3">
                            {!! Form::submit('Ubah Data', ['class' => 'btn btn-success']) !!}
                            <a href="{{ route('mobiles.suketkaryawan') }}" class="btn btn-danger">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

