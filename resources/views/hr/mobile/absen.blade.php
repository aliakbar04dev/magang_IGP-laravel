@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Absensi
        <small>Absensi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> HR - Mobile</li>
        <li class="active"><i class="fa fa-files-o"></i> Absensi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Detail Absensi</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
    		<div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
                {!! Form::label('lbltahun', 'Tahun') !!}
                <select name="filter_status_tahun" aria-controls="filter_status" 
                  class="form-control select2">
                  @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-2; $i--)
                    @if ($i == base64_decode($tahun))
                      <option value={{ $i }} selected="selected">{{ $i }}</option>
                    @else
                      <option value={{ $i }}>{{ $i }}</option>
                    @endif
                  @endfor
                </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblbulan', 'Bulan') !!}
              <select name="filter_status_bulan" aria-controls="filter_status" 
                class="form-control select2">
                  <option value="01" @if ("01" == base64_decode($bulan)) selected="selected" @endif>Januari</option>
                  <option value="02" @if ("02" == base64_decode($bulan)) selected="selected" @endif>Februari</option>
                  <option value="03" @if ("03" == base64_decode($bulan)) selected="selected" @endif>Maret</option>
                  <option value="04" @if ("04" == base64_decode($bulan)) selected="selected" @endif>April</option>
                  <option value="05" @if ("05" == base64_decode($bulan)) selected="selected" @endif>Mei</option>
                  <option value="06" @if ("06" == base64_decode($bulan)) selected="selected" @endif>Juni</option>
                  <option value="07" @if ("07" == base64_decode($bulan)) selected="selected" @endif>Juli</option>
                  <option value="08" @if ("08" == base64_decode($bulan)) selected="selected" @endif>Agustus</option>
                  <option value="09" @if ("09" == base64_decode($bulan)) selected="selected" @endif>September</option>
                  <option value="10" @if ("10" == base64_decode($bulan)) selected="selected" @endif>Oktober</option>
                  <option value="11" @if ("11" == base64_decode($bulan)) selected="selected" @endif>November</option>
                  <option value="12" @if ("12" == base64_decode($bulan)) selected="selected" @endif>Desember</option>
                </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lbldisplay', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
            <div class="col-sm-3">
              {!! Form::label('lblrefresh', 'Action') !!}
              <button id="refresh" type="button" class="form-control btn btn-success" data-toggle="tooltip" data-placement="top" title="Refresh Data">Refresh Data (Jika data tidak sesuai)</button>
            </div>
          </div>
    		</div>
    		<!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th rowspan="2" style="width: 5%;">Tanggal</th>
                <th rowspan="2" style="width: 15%;">Hari</th>
                <th colspan="2" style='text-align: center'>Jam</th>
                <th colspan="2" style='text-align: center'>Shift</th>
                <th rowspan="2" style="width: 10%;">Jam Kerja</th>
                <th rowspan="2">Keterangan</th>
              </tr>
              <tr>
                <th style="width: 8%;">IN</th>
                <th style="width: 8%;">OUT</th>
                <th style="width: 8%;">Kerja</th>
                <th style="width: 8%;">PKL</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
      </div>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Rekap Absen</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" id="rekap">
          <table class="table table-striped" cellspacing="0" width="100%">
            <tbody>
              <tr>
                <td style="width: 10%;"><b>Masuk</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->masuk }}</td>
                <td style="width: 10%;"><b>Satu Prik</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->satu_prik }}</td>
                <td style="width: 15%;"><b>Tidak ada keterangan</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td>{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->tdk_ada_ket }}</td>
              </tr>
              <tr>
                <td style="width: 10%;"><b>Telat</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->telat }}</td>
                <td style="width: 10%;"><b>Ijin Telat</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->ijin_telat }}</td>
                <td style="width: 15%;"><b>Sakit</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td>{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->sakit }}</td>
              </tr>
              <tr>
                <td style="width: 10%;"><b>Cuti</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->cuti }}</td>
                <td style="width: 10%;"><b>Cuti Besar</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->cbs }}</td>
                <td style="width: 15%;"><b>Cuti Tahunan</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td>{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->cth }}</td>
              </tr>
              <tr>
                <td style="width: 10%;"><b>Cuti Massal</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->cms }}</td>
                <td style="width: 10%;"><b>Cuti Hamil</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->ct_hamil }}</td>
                <td style="width: 15%;"><b>Cuti Haid</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td>{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->ct_haid }}</td>
              </tr>
              <tr>
                <td style="width: 10%;"><b>Ijin Upah</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->ijin_upah }}</td>
                <td style="width: 10%;"><b>Ijin Non Upah</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->inin_non_upah }}</td>
                <td style="width: 15%;"><b>Ijin Dispensasi PUK</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td>{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->ijin_dispensasi_puk }}</td>
              </tr>
              <tr>
                <td style="width: 10%;"><b>Libur Biasa</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->libur_biasa }}</td>
                <td style="width: 10%;"><b>Libur Resmi</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->libur_resmi }}</td>
                <td style="width: 15%;"><b>Training</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td>{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->training }}</td>
              </tr>
              <tr>
                <td style="width: 10%;"><b>Shift 1</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->shift_1 }}</td>
                <td style="width: 10%;"><b>Shift 2</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td style="width: 6%;">{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->shift_2 }}</td>
                <td style="width: 15%;"><b>Shift 3</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td>{{ Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->shift_3 }}</td>
              </tr>
              <tr>
                <td style="width: 10%;"><b>Tgl Sync</b></td>
                <td style="width: 1%;"><b>:</b></td>
                <td colspan="7">{{ Carbon\Carbon::parse(Auth::user()->rekapAbsen(base64_decode($tahun), base64_decode($bulan))->tgl_sync)->format('d/m/Y H:i') }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>

      @if (Auth::user()->username === "14438" || Auth::user()->username === "05770" || Auth::user()->username === "05325")
        <div>
          <a class="btn btn-danger" href="{{ route('mobiles.absenprik') }}" data-toggle="tooltip" data-placement="top" title="Data Lembur">Data Absen Mesin Finger</a>
        </div>
      @endif
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

$(document).ready(function(){

  var tahun = "{{ $tahun }}";
  var bulan = "{{ $bulan }}";
  var url = "{{ route('mobiles.dashboardabsen', ['param','param2']) }}";
  url = url.replace('param2', bulan);
  url = url.replace('param', tahun);

  var tableMaster = $('#tblMaster').DataTable({
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 10,
    responsive: true,
    "searching": false,
    // "scrollX": true,
    // "scrollY": "700px",
    // "scrollCollapse": true,
    "paging": false,
    // "lengthChange": false,
    // "ordering": true,
    // "info": true,
    // "autoWidth": false,
    "order": [],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: url,
    columns: [
      {data: 'tgl', name: 'tgl', className: "dt-center", orderable: false, searchable: false},
      {data: 'hari', name: 'hari', orderable: false, searchable: false},
      {data: 'jam_in', name: 'jam_in', className: "dt-center", orderable: false, searchable: false},
      {data: 'jam_out', name: 'jam_out', className: "dt-center", orderable: false, searchable: false},
      {data: 'shift', name: 'shift', className: "dt-center", orderable: false, searchable: false},
      {data: 'shift_pkl', name: 'shift_pkl', className: "dt-center", orderable: false, searchable: false},
      {data: 'jam_kerja', name: 'jam_kerja', className: "dt-center", orderable: false, searchable: false},
      {data: 'ket', name: 'ket', orderable: false, searchable: false}
    ]
  });

  $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
    data.tahun = $('select[name="filter_status_tahun"]').val();
    data.bulan = $('select[name="filter_status_bulan"]').val();
  });

  $('#display').click( function () {
    var tahun = $('select[name="filter_status_tahun"]').val();
    var bulan = $('select[name="filter_status_bulan"]').val();

    var urlRedirect = "{{ route('mobiles.absen', ['param','param2']) }}";
    urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
    urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
    window.location.href = urlRedirect;
  });

  $('#refresh').click( function () {
    var tahun = $('select[name="filter_status_tahun"]').val();
    var bulan = $('select[name="filter_status_bulan"]').val();

    var urlRedirect = "{{ route('mobiles.refreshabsen', ['param','param2']) }}";
    urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
    urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
    window.location.href = urlRedirect;
  });
});
</script>
@endsection