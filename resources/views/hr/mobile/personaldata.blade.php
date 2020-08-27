@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Personal Data
        <small>Personal Data</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Employee Info</li>
        <li class="active"><i class="fa fa-files-o"></i> Personal Data</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_dp">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Pribadi</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 15%;"><b>NPK</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->npk }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>NAMA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->nama }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>TEMPAT / TGL. LAHIR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->tmp_lahir }} / {{ \Carbon\Carbon::parse($mas_karyawan->tgl_lahir)->format('d-m-Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>NO. KTP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->no_ktp }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>AGAMA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->agama_desc }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>JENIS KELAMIN</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($mas_karyawan->kelamin === "L")
                        LAKI-LAKI
                      @elseif ($mas_karyawan->kelamin === "P")
                        PEREMPUAN
                      @else
                        TIDAK JELAS
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>MARITAL</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($mas_karyawan->marital))
                        @if ($mas_karyawan->marital === "TK")
                          BELUM MENIKAH ({{ $mas_karyawan->marital }})
                        @else
                          SUDAH MENIKAH ({{ $mas_karyawan->marital }})
                        @endif
                      @else
                        -
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>GOL DARAH</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->gol_darah }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>WARGA NEGARA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->nm_warga }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>PENDIDIKAN TERAKHIR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->pendidikan }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>FAKULTAS</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->fakultas }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>JURUSAN</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $jurusan }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>NAMA SEKOLAH</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $nama_sekolah }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>TAHUN LULUS</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $thn_lulus }}</td>
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
      @if($alamat_domisili != null && $alamat_ktp != null)
        <div class="row" id="field_alamat">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Alamat</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table class="table table-striped" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td colspan="3"><b>ALAMAT DOMISILI</b></td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>ALAMAT</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_domisili->desc_alam }}</td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>KELURAHAN / KECAMATAN</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_domisili->kelurahan }} / {{ $alamat_domisili->kecamatan }}</td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>RT / RW</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_domisili->rt }} / {{ $alamat_domisili->rw }}</td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>KOTA / KODE POS</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_domisili->kota }} / {{ $alamat_domisili->kd_pos }}</td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>TELEPON / HP</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_domisili->no_tel }}</td>
                    </tr>
                    <tr>
                      <td colspan="3"></td>
                    </tr>
                    <tr>
                      <td colspan="3"><b>ALAMAT KTP</b></td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>ALAMAT</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_ktp->desc_alam }}</td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>KELURAHAN / KECAMATAN</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_ktp->kelurahan }} / {{ $alamat_ktp->kecamatan }}</td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>RT / RW</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_ktp->rt }} / {{ $alamat_ktp->rw }}</td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>KOTA / KODE POS</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_ktp->kota }} / {{ $alamat_ktp->kd_pos }}</td>
                    </tr>
                    <tr>
                      <td style="width: 20%;"><b>TELEPON / HP</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $alamat_ktp->no_tel }}</td>
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
      @endif
      @if($keluarga->get()->count() > 0)
        <div class="row" id="field_kel">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Keluarga</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table class="table table-striped" cellspacing="0" width="100%">
                  <tbody>
                    @foreach ($keluarga->get() as $kel)
                      <tr>
                        <td style="width: 10%;"><b>{{ $kel->status_klg_desc }}</b></td>
                        <td style="width: 1%;"><b>:</b></td>
                        <td>{{ $kel->nama }} ({{ $kel->kelamin }})
                        @if (!empty($kel->tgl_lahir))
                          ({{ \Carbon\Carbon::parse($kel->tgl_lahir)->format('d-m-Y') }})
                        @else
                          (-)
                        @endif
                        </td>
                      </tr>
                    @endforeach
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
      @endif
      <div class="row" id="field_dk">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Karyawan</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 15%;"><b>EMAIL</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->email }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>TGL MASUK IGP GROUP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($mas_karyawan->tgl_masuk_gkd))
                        {{ \Carbon\Carbon::parse($mas_karyawan->tgl_masuk_gkd)->format('d-m-Y') }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>TGL MASUK</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($mas_karyawan->tgl_masuk))
                        {{ \Carbon\Carbon::parse($mas_karyawan->tgl_masuk)->format('d-m-Y') }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>TGL MASUK ANGKAT</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($mas_karyawan->tgl_angkat))
                        {{ \Carbon\Carbon::parse($mas_karyawan->tgl_angkat)->format('d-m-Y') }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>STATUS PEGAWAI</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->status_pegawai }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>GOLONGAN</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kode_gol }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>NO. DPA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $no_dpa }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>NO. BPJSTK</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->no_kpa }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>NO. BPJS KESEHATAN</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $nobpjs_kes }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>NO. NPWP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->no_npwp }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>KEANGGOTAAN SPSI</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($mas_karyawan->spsi === "Y")
                        YA
                      @else
                        TIDAK
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>PAJAK / PTKP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kd_ptkp }}</td>
                  </tr>
                  <tr>
                    <td colspan="3"></td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>PT</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kd_pt }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>DIVISI</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kode_div }} - {{ $mas_karyawan->desc_div }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>DEPARTEMEN</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kode_dep }} - {{ $mas_karyawan->desc_dep }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>SEKSI</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->kode_sie }} - {{ $mas_karyawan->desc_sie }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>JABATAN</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mas_karyawan->desc_jab }}</td>
                  </tr>
                  <tr>
                    <td colspan="3"></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>ATASAN</b></td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>SECTION HEAD</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mobile->namaByNpk($mas_karyawan->npk_sec_head) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>DEP HEAD</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mobile->namaByNpk($mas_karyawan->npk_dep_head) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>DIV HEAD</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mobile->namaByNpk($mas_karyawan->npk_div_head) }}</td>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection