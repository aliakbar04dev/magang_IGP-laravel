@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reg Karyawan
        <small>Detail Reg Karyawan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> HRD</li>
        <li><a href="#"><i class="fa fa-files-o"></i> Reg Karyawan</a></li>
        <li class="active">Detail {{-- {{ $mtcmnpk->npk }} --}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Reg Karyawan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 5%;"><b>No. Reg</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->no_reg }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Npk</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->npk }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Nama</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->nama }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Tanggal Masuk</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ Carbon\Carbon::parse($mas_karyawan->tgl_masuk)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Kd PT</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kd_pt }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Kode Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kode_site }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Tanggal Lahir</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ Carbon\Carbon::parse($mas_karyawan->tgl_lahir)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Agama</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->agama }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Agama Desc</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->agama_desc }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Kode PTKP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kd_ptkp }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>No. KPA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->no_kpa }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Tanggal DPA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->tgl_dpa }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Tempat Lahir</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->tmp_lahir }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Kode Gol</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kode_gol }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Kode Divisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kode_div }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Deskripsi Divisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->desc_div }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Kode Departemen</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kode_dep }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Divisi Departemen</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->desc_dep }}</td>
                  </tr>
                   <tr>
                    <td style="width: 5%;"><b>Kode SIE</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kode_sie }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Deskripsi SIE</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->desc_sie }}</td>
                  </tr>
                   <tr>
                    <td style="width: 5%;"><b>Ranking</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->rangking }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Status Pegawai</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->stat_peg }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Kode Jabatan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kd_jab }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Deskripsi Jabatan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->desc_jab }}</td>
                  </tr> <tr>
                    <td style="width: 5%;"><b>Kelamin</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kelamin }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Jamsostek</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->jamsostek }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Marital</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->marital }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Fakultas</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->fakultas }}</td>
                  </tr> <tr>
                    <td style="width: 5%;"><b>Kode Area Kerja</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kd_area_kerja }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Tanggal Masuk GKD</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->tgl_masuk_gkd }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Foto</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->foto }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Email</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->email }}</td>
                  </tr> <tr>
                    <td style="width: 5%;"><b>NPK Atasan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->npk_atasan }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Status Pegawai</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->status_pegawai }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Kode Warga</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kd_warga }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Nama Warga</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->nm_warga }}</td>
                  </tr>
                   <tr>
                    <td style="width: 5%;"><b>Gol. Darah</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->gol_darah }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Nomor KTP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->no_ktp }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Kel Biaya</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kel_biaya }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>No HP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->no_hp }}</td>
                  </tr> <tr>
                    <td style="width: 5%;"><b>No NPWP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->no_npwp }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Tgl Sync</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ Carbon\Carbon::parse($mas_karyawan->tgl_sync)->format('d/m/Y') }}</td>
                  </tr> <tr>
                    <td style="width: 5%;"><b>Initial</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->initial }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>NPK Div Head</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->npk_div_head }}</td>
                  </tr> <tr>
                    <td style="width: 5%;"><b>NPK Dep Head</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->npk_dep_head }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>NPK Sec Head</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->npk_sec_head }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>BPJS Ket</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->bpjsket }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Rekening Mandiri</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->rek_mandiri }}</td>
                  </tr> <tr>
                    <td style="width: 5%;"><b>BPJS Kes</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->bpjskes }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>BPJS Kes File</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->bpjskes_file }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>BPJS Ket File</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->bpjsket_file }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Rekening Mandiri File</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->rek_mandiri_file }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>NPK LC</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->npk_lc }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="box-footer">
        <a class="btn btn-primary" href="{{ route('hrdtregkars.indexlistregkar') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Reg Karyawan" id="btn-cancel">Kembali</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
{{-- <script type="text/javascript">
  $("#btn-delete").click(function(){
    var npk = "{{ $mtcmnpk->npk }}";
    var msg = 'Anda yakin menghapus NPK/Plant: ' + npk + '?';
    var txt = '';
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('mtcmnpks.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(npk));
      window.location.href = urlRedirect;
    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        // swal(
        //   'Cancelled',
        //   'Your imaginary file is safe :)',
        //   'error'
        // )
      }
    })
  });
</script> --}}
@endsection