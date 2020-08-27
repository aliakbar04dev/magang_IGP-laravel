@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Keterangan Pengajuan
        <small>Daftar Pengajuan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i>HRD</li>
        <li class="active"><i class="fa fa-files-o"></i>Suket Karyawan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-md-12">
          <div class="box box-primary">
                <div class="box-header text-center"><b>Submit Surat Keterangan</b></div>

                <div class="box-body">

                        
                        <div class="alert alert-success" role="alert">
                           Pesan: Data Pengajuan Berhasil Disimpan
                        </div>
                   
                    
                        <div class="form-group row">
                            {!! Form::hidden('npk', Auth::user()->username, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="Nomor Surat">Nomor Surat</label>
                            <div class="col-md-5">
                              {!! Form::text('nosk', $nosk, ['class' => 'form-control', 'readonly' => '']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="Tanggal">Tanggal Pengajuan:</label>
                            <div class="col-md-5">
                             {!! Form::text('tglsurat', date('d-m-Y', strtotime($tglsurat)), ['class' => 'form-control', 'readonly' => '']) !!} 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="nama">Nama Karyawan: </label>
                            <div class="col-md-5">
                              {!! Form::text('nama', $nama, ['class' => 'form-control', 'readonly' => '']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="">Alamat: </label>
                            <div class="col-md-5">
                                {!! Form::text('alamat', $alamat, ['class' => 'form-control', 'readonly' => '']) !!}
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Keperluan: </label>
                            <div class="col-md-5">
                               
                               {!! Form::textarea('keperluan', $keperluan, ['class' => 'form-control', 'readonly' => '', 'cols' => '30', 'rows' => '10']) !!}
                               
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'disabled']) !!}
                                <a href="{{ route('mobiles.suketkaryawan') }}" class="btn btn-primary">OK</a>
                            </div>
                        </div>
                    </form>
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

