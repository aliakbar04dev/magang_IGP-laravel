@extends('layouts.app')
@section('content')
<style type="text/css">
  input[type="text"]{
      text-transform : uppercase

    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Registrasi Ulang Karyawan
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="glyphicon glyphicon-info-sign"></i> Reg karyawan</li>
      <li class="active"><i class="fa fa-files-o"></i> Registrasi Ulang Karyawan </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="row" id="field_detail">
      <div class="col-md-12">
        <div class="box box-primary">
          {!! Form::model($hrdt_regis_ulang1, ['url' => route('mobiles.UpdateRegistrasiUlangKaryawan', base64_encode($tahun)),
            'method'=>'put', 'files' => true, 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'form_id']) !!}
            <div class="box-header with-border">
              <h3 class="box-title">Data Registrasi Karyawan</h3>
              <div class="box-body form-horizontal">         
                <!-- /.form-group -->
                <div class="form-group"> 
                  <div class="col-md-4">         
                    {!! Form::label('tahun', 'Tahun') !!}
                    {!! Form::select('tahun', ['2019' => '2019', '2020' => '2020'], $tahun, ['class'=>'form-control select2', 'id' => 'tahun', 'required']) !!}
                  </div>
                </div>

                {{-- 
                <div class="form-group">
                  <div class="col-sm-2">
                    <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                  </div>
                </div>
                --}}
              </div>
            </div>
              <!-- /.box-header -->
            <div class="box-body" style="text-align: center">
              <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                  Actual Data
                </div>
                <div class="col-md-4">
                  Revisi Data
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  1. Nama
                </div>
                <div class="col-md-4">
                  {!! Form::text('nama', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'nama', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_nama', null, ['class'=>'form-control','placeholder'=> 'Revisi Nama', 'id' => 'rev_nama']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  2. Tempat/ Tgl Lahir
                </div>
                <div class="col-md-2">
                  {!! Form::text('tmp_lahir', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'tmp_lahir', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-2">
                  @if (empty($hrdt_regis_ulang1->tgl_lahir))
                    {!! Form::date('tgl_lahir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => '-', 'id' => 'tgl_lahir']) !!}
                  @else
                    {!! Form::date('tgl_lahir', \Carbon\Carbon::parse($hrdt_regis_ulang1->tgl_lahir), ['class'=>'form-control','placeholder' => 'tanggal', 'required', 'id' => 'tgl_lahir', 'readonly' => 'readonly']) !!}
                  @endif
                </div>
                <div class="col-md-2">
                  {!! Form::text('rev_tmp_lahir', null, ['class'=>'form-control','placeholder' => 'Tempat Tinggal', 'id' => 'rev_tmp_lahir']) !!}
                </div>
                <div class="col-md-2">
                  @if (empty($hrdt_regis_ulang1->rev_tgl_lahir))
                    {!! Form::date('rev_tgl_lahir', \Carbon\Carbon::parse($hrdt_regis_ulang1->tgl_lahir), ['class'=>'form-control','placeholder' => 'Tanggal', 'id' => 'rev_tgl_lahir']) !!}
                  @else
                    {!! Form::date('rev_tgl_lahir', \Carbon\Carbon::parse($hrdt_regis_ulang1->rev_tgl_lahir), ['class'=>'form-control','placeholder' => 'tanggal', 'required', 'id' => 'rev_tgl_lahir']) !!}
                  @endif
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  3. No KTP
                </div>
                <div class="col-md-4">
                  {!! Form::text('no_ktp', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'no_ktp', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_no_ktp', null, ['class'=>'form-control','placeholder' => 'No KTP', 'id' => 'rev_no_ktp']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  4. Agama
                </div>
                <div class="col-md-4">
                  {!! Form::text('agama', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'agama', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::select('rev_agama', ['ISLAM' => 'ISLAM', 'KRISTEN' => 'KRISTEN', 'KATHOLIK' => 'KATHOLIK', 'HINDU' => 'HINDU', 'BUDHA' => 'BUDHA'], $hrdt_regis_ulang1->rev_agama, ['class'=>'form-control select2', 'id' => 'rev_agama', 'required']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  5. Jenis Kelamin
                </div>
                <div class="col-md-4">
                  {!! Form::text('kelamin', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'kelamin', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                   {!! Form::select('rev_kelamin', [ null => null, 'L' => 'L', 'P' => 'P'], $hrdt_regis_ulang1->rev_kelamin, ['class'=>'form-control select2', 'id' => 'rev_kelamin']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  6. Golongan Darah
                </div>
                <div class="col-md-4">
                  {!! Form::text('gol_darah', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'gol_darah', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                   {!! Form::select('rev_gol_darah', [ null => null, 'A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O'], $hrdt_regis_ulang1->rev_gol_darah, ['class'=>'form-control select2', 'id' => 'rev_gol_darah']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  7. Tempat Tinggal Domisili
                </div>
                <div class="col-md-8">
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  a. Alamat
                </div>
                <div class="col-md-4">
                  {!! Form::text('domisili_alamat', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'domisili_alamat', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_domisili_alamat', null, ['class'=>'form-control','placeholder' => 'Alamat Domisili', 'id' => 'rev_domisili_alamat']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  b. kelurahan
                </div>
                <div class="col-md-4">
                  {!! Form::text('domisili_kel', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'domisili_kel', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_domisili_kel', null, ['class'=>'form-control','placeholder' => 'kelurahan Domisili', 'id' => 'rev_domisili_kel']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  c. kecamatan
                </div>
                <div class="col-md-4">
                  {!! Form::text('domisili_kec', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'domisili_kec', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_domisili_kec', null, ['class'=>'form-control','placeholder' => 'kecamatan Domisili', 'id' => 'rev_domisili_kec']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  d. kota 
                </div>
                <div class="col-md-4">
                  {!! Form::text('domisili_kota', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'domisili_kota', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_domisili_kota', null, ['class'=>'form-control','placeholder' => 'Kota Domisili', 'id' => 'rev_domisili_kota']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  e. kode pos
                </div>
                <div class="col-md-4">
                  {!! Form::text('domisili_kdpos', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'domisili_kdpos', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_domisili_kdpos', null, ['class'=>'form-control','placeholder' => 'kode pos Domisili', 'id' => 'rev_domisili_kdpos']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  f. Telp
                </div>
                <div class="col-md-4">
                  {!! Form::text('domisili_tlp', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'domisili_tlp', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_domisili_tlp', null, ['class'=>'form-control','placeholder' => 'Telp Domisili', 'id' => 'rev_domisili_tlp']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  g. HP
                </div>
                <div class="col-md-4">
                  {!! Form::text('domisili_hp', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'domisili_hp', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_domisili_hp', null, ['class'=>'form-control','placeholder' => 'HP Domisili', 'id' => 'rev_domisili_hp']) !!}
                </div>
              </div>

              <div class="row">
                &nbsp;
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  Upload Surat Keterangan Domisili
                </div>
                <div class="col-md-8">
                  {!! Form::file('rev_domisili_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
                  @if (!empty($hrdt_regis_ulang1->rev_domisili_pict))
                    <p>
                      <img src="{{ $image_codes_domisili }}" alt="File Not Found" class="img-rounded img-responsive" width="25%">
                    </p>
                  @endif
                  {!! $errors->first('rev_domisili_pict', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  Alamat Sesuai KTP
                </div>
                <div class="col-md-8">
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  a. Alamat
                </div>
                <div class="col-md-4">
                  {!! Form::text('ktp_alamat', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'ktp_alamat', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_ktp_alamat', null, ['class'=>'form-control','placeholder' => 'Alamat ktp', 'id' => 'rev_ktp_alamat']) !!}
                </div>
              </div>
              
              <div class="row">
                &nbsp;
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  b. kel.
                </div>
                <div class="col-md-4">
                  {!! Form::text('ktp_kel', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'ktp_kel', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_ktp_kel', null, ['class'=>'form-control','placeholder' => 'Kel. ktp', 'id' => 'rev_ktp_kel']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  c. kec.
                </div>
                <div class="col-md-4">
                  {!! Form::text('ktp_kec', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'ktp_kec', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_ktp_kec', null, ['class'=>'form-control','placeholder' => 'Kec. ktp', 'id' => 'rev_ktp_kec']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  d. kota
                </div>
                <div class="col-md-4">
                  {!! Form::text('ktp_kota', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'ktp_kota', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_ktp_kota', null, ['class'=>'form-control','placeholder' => 'Kota ktp', 'id' => 'rev_ktp_kota']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  e. kode pos
                </div>
                <div class="col-md-4">
                  {!! Form::text('ktp_kdpos', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'ktp_kdpos', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_ktp_kdpos', null, ['class'=>'form-control','placeholder' => 'kode pos ktp', 'id' => 'rev_ktp_kdpos']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  f. Telp 
                </div>
                <div class="col-md-4">
                  {!! Form::text('ktp_tlp', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'ktp_tlp', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_ktp_tlp', null, ['class'=>'form-control','placeholder' => 'Telp ktp', 'id' => 'rev_ktp_tlp']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  g.  HP
                </div>
                <div class="col-md-4">
                  {!! Form::text('ktp_hp', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'ktp_hp', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_ktp_hp', null, ['class'=>'form-control','placeholder' => 'HP ktp', 'id' => 'rev_ktp_hp']) !!}
                </div>
              </div>
              
              <div class="row">
                &nbsp;
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left;">
                  Upload KTP
                </div>
                <div class="col-md-8">
                  {!! Form::file('rev_ktp_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
                  @if (!empty($hrdt_regis_ulang1->rev_ktp_pict))
                    <p>
                      <img src="{{ $image_codes_ktp }}" alt="File Not Found" class="img-rounded img-responsive" width="25%">
                    </p>
                  @endif
                  {!! $errors->first('rev_ktp_pict', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              
              <div class="row">
                &nbsp;
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left;">
                  8. Pendidikan Terakhir
                </div>
                <div class="col-md-4">
                  {!! Form::text('pend_akhir', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'pend_akhir', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {{-- {!! Form::text('rev_pend_akhir', null, ['class'=>'form-control','placeholder' => 'Pendidikan Terakhir', 'id' => 'rev_pend_akhir']) !!} --}}

                  {!! Form::select('rev_pend_akhir', $detail_pendidikan_akhir , $hrdt_regis_ulang1->rev_pend_akhir, ['class'=>'form-control select2', 'id' => 'rev_pend_akhir']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1" style="text-align: left">
                  9.
                </div>
                <div class="col-md-3" style="text-align: left">
                  -Fakultas
                </div>
                <div class="col-md-4">
                  {!! Form::text('pend_fakultas', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'pend_fakultas', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_pend_fakultas', null, ['class'=>'form-control','placeholder' => 'Fakultas', 'id' => 'rev_pend_fakultas']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  -Jurusan
                </div>
                <div class="col-md-4">
                  {!! Form::text('pend_jurusan', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'pend_jurusan', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_pend_jurusan', null, ['class'=>'form-control','placeholder' => 'Jurusan', 'id' => 'rev_pend_jurusanp']) !!}
                </div>
              </div>
              
              <div class="row">
                &nbsp;
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  Upload Ijazah
                </div>
                <div class="col-md-8">
                  {!! Form::file('rev_pend_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
                  @if (!empty($hrdt_regis_ulang1->rev_pend_pict))
                    <p>
                      <img src="{{ $image_codes_pend }}" alt="File Not Found" class="img-rounded img-responsive" width="25%">
                    </p>
                  @endif
                  {!! $errors->first('rev_pend_pict', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              
              <div class="row">
                &nbsp;
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  10. Status Marital
                </div>
                <div class="col-md-8">
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table width="100%" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="text-align: center;" width="10%">No</th>
                        <th style="text-align: center;" width="15%">Keluarga</th>
                        <th style="text-align: center;" width="15%">Nama</th>
                        <th style="text-align: center;" width="15%">Tempat / Tgl Lahir</th>
                        <th style="text-align: center;" width="10%%">L/P</th>
                        <th style="text-align: center;" width="15%">Pendidikan</th>
                        <th style="text-align: center;" width="15%">pekerjaan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @for ($i = 0; $i < 4; $i++)
                        <tr>
                          <td>{{ $i+1 }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->nama_status_klg }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->nama }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->tmp_lahir }} / {{ \Carbon\Carbon::parse($hrdt_regis_ulang2[$i]->tgl_lahir)->format('d-m-Y') }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->kelamin }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->desc_pend }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->pekerjaan }}</td>
                        </tr>
                      @endfor
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  Revisi
                </div>
                <div class="col-md-8">
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table width="100%" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="text-align: center;" width="10%">No</th>
                        <th style="text-align: center;" width="15%">Keluarga</th>
                        <th style="text-align: center;" width="15%">Nama</th>
                        <th style="text-align: center;" width="15%">Tempat / Tgl Lahir</th>
                        <th style="text-align: center;" width="10%%">L/P</th>
                        <th style="text-align: center;" width="15%">Pendidikan</th>
                        <th style="text-align: center;" width="15%">pekerjaan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @for ($i = 0; $i < 4; $i++)
                        <tr>
                          <td>{{ $i+1 }}</td>
                          <td>
                            {!! Form::select('rev_status_klg'.$i, [ null => null, 'A' => 'ANAK', 'I' => 'ISTRI', 'S' => 'SUAMI'], $hrdt_regis_ulang2[$i]->rev_status_klg, ['class'=>'form-control select2', 'id' => 'rev_status_klg'.$i]) !!}
                          </td>
                          <td>
                            {!! Form::text('rev_nama'.$i, $hrdt_regis_ulang2[$i]->rev_nama, ['class'=>'form-control','placeholder' => 'Nama', 'id' => 'rev_nama'.$i]) !!}
                          </td>
                          <td>
                            {!! Form::text('rev_tmp_lahir'.$i, $hrdt_regis_ulang2[$i]->rev_tmp_lahir, ['class'=>'form-control','placeholder' => 'Tempat Tinggal', 'id' => 'rev_tmp_lahir'.$i]) !!}
                            @if (empty($hrdt_regis_ulang2[$i]->rev_tgl_lahir))
                              {!! Form::date('rev_tgl_lahir'.$i, \Carbon\Carbon::parse($hrdt_regis_ulang2[$i]->tgl_lahir), ['class'=>'form-control','placeholder' => 'Tanggal', 'id' => 'rev_tgl_lahir'.$i]) !!}
                            @else
                              {!! Form::date('rev_tgl_lahir'.$i, \Carbon\Carbon::parse($hrdt_regis_ulang2[$i]->rev_tgl_lahir), ['class'=>'form-control','placeholder' => 'tanggal', 'required', 'id' => 'rev_tgl_lahir'.$i]) !!}
                            @endif
                          </td>
                          <td>
                            {!! Form::select('rev_kelamin'.$i, [ null => null, 'L' => 'L', 'P' => 'P'], $hrdt_regis_ulang2[$i]->rev_kelamin, ['class'=>'form-control select2', 'id' => 'rev_kelamin'.$i]) !!}
                          </td>
                          <td>
                            {!! Form::select('rev_kd_pend'.$i, $detail_pendidikan , $hrdt_regis_ulang2[$i]->rev_kd_pend, ['class'=>'form-control select2', 'id' => 'rev_kd_pend'.$i]) !!}
                          </td>
                          <td>
                            {!! Form::text('rev_pekerjaan'.$i, $hrdt_regis_ulang2[$i]->rev_pekerjaan, ['class'=>'form-control','placeholder' => 'pekerjaan', 'id' => 'rev_pekerjaan'.$i]) !!}
                          </td>
                        </tr>
                      @endfor
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  Upload KK
                </div>
                <div class="col-md-8">
                  {!! Form::file('rev_kk_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
                  @if (!empty($hrdt_regis_ulang1->rev_kk_pict))
                    <p>
                      <img src="{{ $image_codes_kk }}" alt="File Not Found" class="img-rounded img-responsive" width="25%">
                    </p>
                  @endif
                  {!! $errors->first('rev_kk_pict', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  11. Nama Orang Tua & Mertua
                </div>
                <div class="col-md-8">
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table width="100%" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="text-align: center;" width="10%">No</th>
                        <th style="text-align: center;" width="15%">Keluarga</th>
                        <th style="text-align: center;" width="15%">Nama</th>
                        <th style="text-align: center;" width="15%">Tempat / Tgl Lahir</th>
                        <th style="text-align: center;" width="10%%">L/P</th>
                        <th style="text-align: center;" width="15%">pekerjaan</th>
                        <th style="text-align: center;" width="15%">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @for ($i = 4; $i < 8; $i++)
                        <tr>
                          <td>{{ $i+1 }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->nama_status_klg }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->nama }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->tmp_lahir }} / {{ \Carbon\Carbon::parse($hrdt_regis_ulang2[$i]->tgl_lahir)->format('d-m-Y') }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->kelamin }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->pekerjaan }}</td>
                          <td>{{ $hrdt_regis_ulang2[$i]->keterangan }}</td>
                        </tr>
                      @endfor
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  Revisi
                </div>
                <div class="col-md-8">
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <table width="100%" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="text-align: center;" width="10%">No</th>
                        <th style="text-align: center;" width="15%">Keluarga</th>
                        <th style="text-align: center;" width="15%">Nama</th>
                        <th style="text-align: center;" width="15%">Tempat / Tgl Lahir</th>
                        <th style="text-align: center;" width="10%%">L/P</th>
                        <th style="text-align: center;" width="15%">pekerjaan</th>
                        <th style="text-align: center;" width="15%">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @for ($i = 4; $i < 8; $i++)
                        <tr>
                          <td>{{ $i+1 }}</td>
                          <td>
                            {!! Form::select('rev_status_klg'.$i, [ null => null, 'M' => 'MERTUA', 'O' => 'ORANG TUA'], $hrdt_regis_ulang2[$i]->rev_status_klg, ['class'=>'form-control select2', 'id' => 'rev_status_klg'.$i]) !!}
                          </td>
                          <td>
                            {!! Form::text('rev_nama'.$i, $hrdt_regis_ulang2[$i]->rev_nama, ['class'=>'form-control','placeholder' => 'Nama', 'id' => 'rev_nama'.$i]) !!}
                          </td>
                          <td>
                            {!! Form::text('rev_tmp_lahir'.$i, $hrdt_regis_ulang2[$i]->rev_tmp_lahir, ['class'=>'form-control','placeholder' => 'Tempat Tinggal', 'id' => 'rev_tmp_lahir'.$i]) !!}
                            @if (empty($hrdt_regis_ulang2[$i]->rev_tgl_lahir))
                              {!! Form::date('rev_tgl_lahir'.$i, \Carbon\Carbon::parse($hrdt_regis_ulang2[$i]->tgl_lahir), ['class'=>'form-control','placeholder' => 'Tanggal', 'id' => 'rev_tgl_lahir'.$i]) !!}
                            @else
                              {!! Form::date('rev_tgl_lahir'.$i, \Carbon\Carbon::parse($hrdt_regis_ulang2[$i]->rev_tgl_lahir), ['class'=>'form-control','placeholder' => 'tanggal', 'required', 'id' => 'rev_tgl_lahir'.$i]) !!}
                            @endif
                          </td>
                          <td>
                            {!! Form::select('rev_kelamin'.$i, [ null => null, 'L' => 'L', 'P' => 'P'], $hrdt_regis_ulang2[$i]->rev_kelamin, ['class'=>'form-control select2', 'id' => 'rev_kelamin'.$i]) !!}</td>
                          <td>
                            {!! Form::text('rev_pekerjaan'.$i, $hrdt_regis_ulang2[$i]->rev_pekerjaan, ['class'=>'form-control','placeholder' => 'pekerjaan', 'id' => 'rev_pekerjaan'.$i]) !!}
                          </td>
                          <td>
                            {!! Form::text('rev_keterangan'.$i, $hrdt_regis_ulang2[$i]->rev_keterangan, ['class'=>'form-control','placeholder' => 'keterangan', 'id' => 'rev_keterangan'.$i]) !!}
                          </td>
                        </tr>
                      @endfor
                    </tbody>
                  </table>
                </div>
              </div>
              
              <div class="row">
                &nbsp;
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  Upload KK Orang Tua
                </div>
                <div class="col-md-8">
                  {!! Form::file('rev_kk_ortu_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
                  @if (!empty($hrdt_regis_ulang1->rev_kk_ortu_pict))
                    <p>
                      <img src="{{ $image_codes_kk_ortu }}" alt="File Not Found" class="img-rounded img-responsive" width="25%">
                    </p>
                  @endif
                  {!! $errors->first('rev_kk_ortu_pict', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              
              <div class="row">
                &nbsp;
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  Upload KK Mertua
                </div>
                <div class="col-md-8">
                  {!! Form::file('rev_kk_mertua_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
                  @if (!empty($hrdt_regis_ulang1->rev_kk_mertua_pict))
                    <p>
                      <img src="{{ $image_codes_kk_mertua }}" alt="File Not Found" class="img-rounded img-responsive" width="25%">
                    </p>
                  @endif
                  {!! $errors->first('rev_kk_mertua_pict', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              
              <div class="row">
                &nbsp;
              </div>

              <div class="row">
                <div class="col-md-4" style="text-align: left">
                  12. Biodata Kepegawaian
                </div>
                <div class="col-md-8">
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  1. Tgl Masuk IGP Group
                </div>

                <div class="col-md-4">
                  @if (empty($hrdt_regis_ulang1->tgl_masuk_gkd))
                    {!! Form::date('tgl_masuk_gkd', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tanggal', 'id' => 'tgl_masuk_gkd', 'readonly' => 'readonly']) !!}
                  @else
                    {!! Form::date('tgl_masuk_gkd'.$i, \Carbon\Carbon::parse($hrdt_regis_ulang1->tgl_masuk_gkd), ['class'=>'form-control','placeholder' => 'tanggal', 'required', 'id' => 'tgl_masuk_gkd', 'readonly' => 'readonly']) !!}
                  @endif
                </div>
                <div class="col-md-4">
                  @if (empty($hrdt_regis_ulang1->rev_tgl_masuk_gkd))
                    {!! Form::date('rev_tgl_masuk_gkd', \Carbon\Carbon::parse($hrdt_regis_ulang1->tgl_masuk_gkd), ['class'=>'form-control','placeholder' => 'Tanggal', 'id' => 'rev_tgl_masuk_gkd']) !!}
                  @else
                    {!! Form::date('rev_tgl_masuk_gkd', \Carbon\Carbon::parse($hrdt_regis_ulang1->rev_tgl_masuk_gkd), ['class'=>'form-control','placeholder' => 'tanggal', 'required', 'id' => 'rev_tgl_masuk_gkd']) !!}
                  @endif
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  2. PT
                </div>
                <div class="col-md-4">
                  {!! Form::text('kd_pt', null, ['class'=>'form-control','placeholder' => 'PT', 'id' => 'kd_pt', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_kd_pt', null, ['class'=>'form-control','placeholder' => 'PT', 'id' => 'rev_kd_pt']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  3. Bagian
                </div>
                <div class="col-md-4">
                  {!! Form::text('kode_sie', null, ['class'=>'form-control','placeholder' => 'Bagian', 'id' => 'kode_sie', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_kode_sie', null, ['class'=>'form-control','placeholder' => 'Bagian', 'id' => 'rev_kode_sie']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-2" style="text-align: left">
                  a. Divisi
                </div>
                <div class="col-md-4">
                  {!! Form::text('desc_div', null, ['class'=>'form-control','placeholder' => 'Divisi', 'id' => 'desc_div', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_desc_div', null, ['class'=>'form-control','placeholder' => 'Divisi', 'id' => 'rev_desc_div']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-2" style="text-align: left">
                  b. Departemen
                </div>
                <div class="col-md-4">
                  {!! Form::text('desc_dep', null, ['class'=>'form-control','placeholder' => 'Departemen', 'id' => 'desc_dep', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_desc_dep', null, ['class'=>'form-control','placeholder' => 'Departemen', 'id' => 'rev_desc_dep']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-2" style="text-align: left">
                  c. Seksi
                </div>
                <div class="col-md-4">
                  {!! Form::text('desc_sie', null, ['class'=>'form-control','placeholder' => 'Seksi', 'id' => 'desc_sie', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_desc_sie', null, ['class'=>'form-control','placeholder' => 'Seksi', 'id' => 'rev_desc_sie']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  4. Jabatan
                </div>
                <div class="col-md-4">
                  {!! Form::text('desc_jab', null, ['class'=>'form-control','placeholder' => 'Jabatan', 'id' => 'desc_jab', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_desc_jab', null, ['class'=>'form-control','placeholder' => 'Jabatan', 'id' => 'rev_desc_jab']) !!}
                </div>
              </div>

              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="text-align: left">
                  5. Email IGP Group
                </div>
                <div class="col-md-4">
                  {!! Form::text('email', null, ['class'=>'form-control','placeholder' => '-', 'id' => 'email', 'readonly' => 'readonly']) !!}
                </div>
                <div class="col-md-4">
                  {!! Form::text('rev_email', null, ['class'=>'form-control','placeholder' => 'Email IGP Group', 'id' => 'rev_email']) !!}
                </div>
              </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="col-md-12">
                <div class="col-md-1">
                  {!! Form::submit('Save As Draft', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-1">
                  <input type="button" class="btn btn-success" id ="btnSubmit" value="SUBMIT">
                </div>
                <div class="col-md-9">
                </div>
              </div> 
            </div>  
          {!! Form::close() !!}
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
@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){
    

    var submitted = "{{ $hrdt_regis_ulang1->submit_by }}";
    if (submitted != ""){
      $(':submit').prop('disabled', true);
      $(':button').prop('disabled', true);
      $(':text').prop('readonly',true);
    }

    $('#tahun').on('change', function() {
      var urlRedirect = "{{ route('mobiles.RegistrasiUlangKaryawan', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa($("#tahun").val()));
      window.location.href = urlRedirect;
    });

    $('#btnSubmit').click(function() {
      swal({
          title: 'Sekali Submit tidak bisa di rubah kembali?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, Submit!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          submitRegis();
        }, function (dismiss) {
        });
    });
    function submitRegis() {

      var urlRedirect = "{{ route('mobiles.UbahStatusRegistrasiUlangKaryawan', ['param', 'param2', 'param3']) }}";
      urlRedirect = urlRedirect.replace('param', window.btoa('SUBMIT'));
      urlRedirect = urlRedirect.replace('param2', window.btoa($("#tahun").val()));
      urlRedirect = urlRedirect.replace('param3', window.btoa("{{ Auth::user()->username }}"));
      window.location.href = urlRedirect;
    }
  });
</script>
@endsection