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
        <li class="active"><i class="fa fa-files-o"></i>Tampil Pengajuan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header text-center">Tampil Data Pengajuan</div>


                <div class="box-body">

                   {{--  @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif--}}

                                @include('layouts._flash')

                    


                    <div class="form-group row">
                        <label for="nosk" class="col-md-4 col-form-label text-md-right">Nomor Surat</label>
                        <div class="col-md-4">
                            {!! Form::text('nosk', $rowsuket->nosk, ['class' => 'form-control', 'readonly' => '']) !!}                            
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tglsurat" class="col-md-4 col-form-label text-md-right">Tanggal</label>
                        <div class="col-md-4">
                            {!! Form::text('tglsurat', Carbon\Carbon::parse($rowsuket->tglsurat )->format('d-m-Y'), ['class' => 'form-control', 'readonly' => '']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="nama" class="col-md-4 col-form-label text-md-right">Nama Karyawan</label>
                        <div class="col-md-4">
                            
                            {!! Form::text('nama', $rowsuket->nama, ['class' => 'form-control', 'readonly' => '']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                        <div class="col-md-4">
                            {!! Form::text('status', $rowsuket->status, ['class' => 'form-control', 'readonly' => '']) !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('keperluan') ? ' has-error' : '' }}">
                        <label for="keperluan" class="col-md-4 col-form-label text-md-right">Keperluan</label>
                        <div class="col-md-5">
                            
                            
                            
                        {!! Form::textarea('keperluan', $rowsuket->keperluan, ['class'=>'form-control', 'readonly' => '' ]) !!}
                        {!! $errors->first('keperluan', '<p class="help-block">:message</p>') !!}
                                                        
                            
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-3">
                            <a href="{{ route('mobiles.suketpengajuan') }}" class="btn btn-danger">Kembali</a>
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

