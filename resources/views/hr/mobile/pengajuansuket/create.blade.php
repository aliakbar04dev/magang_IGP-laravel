@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Keterangan Pengajuan
        <small>Tambah Pengajuan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i>HRD</li>
        <li><i class="fa fa-files-o"></i>Suket Karyawan</li>
        <li class="active"><i class="fa fa-files-o"></i>Tambah Pengajuan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     
      <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header text-center"><b>Pengajuan Surat Keterangan</b></div>

                <div class="box-body">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li><b>Pesan: </b>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
                           
                        {!! Form::open(['url' => route('mobiles.storesuketkaryawan'), 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                        <div class="form-group row">
                            
                            {!! Form::hidden('nosk', $nosk, ['class' => 'form-control']) !!}
                             {!! Form::hidden('npk_dep_head', $npk_dep_head, ['class' => 'form-control']) !!}
                            {!! Form::hidden('npk', Auth::User()->username, ['class' => 'form-control']) !!}

                            
                        </div>


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="Tanggal">Tanggal:</label>
                            <div class="col-md-5">
                             {!! Form::text('tglsurat', date('d-m-Y'), ['class' => 'form-control', 'readonly' => '']) !!} 
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="nama">Nama Karyawan: </label>
                            <div class="col-md-5">
                              {!! Form::text('nama', Auth::User()->name, ['class' => 'form-control', 'readonly' => '']) !!}
                            </div>
                        </div>

                       
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="status">Status Permintaan: </label>
                            <div class="col-md-5">
                                {!! Form::text('status', 'Belum Approval', ['class' => 'form-control', 'readonly' => '']) !!}
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
                                
                                {!! Form::textarea('keperluan', null, ['class' => 'form-control']) !!}
                                
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-3 center-block">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                <a class="btn btn-secondary" disabled>Cetak</a>
                                <a href="{{ route('mobiles.suketkaryawan') }}" class="btn btn-primary">Cancel</a>
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

