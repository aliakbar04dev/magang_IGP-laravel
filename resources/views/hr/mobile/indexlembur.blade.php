@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lembur
        <small>Lembur</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-phone"></i> HR - Mobile</li>
        <li class="active"><i class="fa fa-files-o"></i> Lembur</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">        
    		<div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
                {!! Form::label('lbltahun', 'Tahun') !!}
                <select name="filter_status_tahun" aria-controls="filter_status" 
                  class="form-control select2">
                  @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-2; $i--)
                    @if ($i == \Carbon\Carbon::now()->format('Y'))
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
                  <option value="01" @if ("01" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Januari</option>
                  <option value="02" @if ("02" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Februari</option>
                  <option value="03" @if ("03" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Maret</option>
                  <option value="04" @if ("04" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>April</option>
                  <option value="05" @if ("05" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Mei</option>
                  <option value="06" @if ("06" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juni</option>
                  <option value="07" @if ("07" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juli</option>
                  <option value="08" @if ("08" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Agustus</option>
                  <option value="09" @if ("09" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>September</option>
                  <option value="10" @if ("10" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Oktober</option>
                  <option value="11" @if ("11" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>November</option>
                  <option value="12" @if ("12" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Desember</option>
                </select>
            </div>
          </div>
    		  <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lblpt', 'PT') !!}
              <select name="filter_status_pt" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                <option value="IGP">PT. IGP</option>
                <option value="GKD">PT. GKD</option>
                <option value="WEP">PT. WEP</option>
                <option value="AGI">PT. AGI</option>
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lbldisplay', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
    		  </div>
    		  <!-- /.form-group -->
    		</div>
    		<!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 1%;">No</th>
                <th style="width: 5%;">NPK</th>
                <th>Nama</th>
                <th>PT</th>
                <th>Divisi</th>
                <th>Departemen</th>
                <th>Golongan</th>
                <th style="width: 10%;">GP</th>
                <th>Jml Hari Lembur</th>
                <th>Jml Hari Lembur Koreksi</th>
                <th>Jam Aktual Lembur</th>
                <th>Jam Aktual Lembur Koreksi</th>
                <th>Jam TUL Reguler</th>
                <th>Jam TUL Koreksi</th>
                <th style="width: 10%;">Jam TUL</th>
                <th>Uang Lembur Reguler</th>
                <th>Uang Lembur Koreksi</th>
                <th style="width: 10%;">Uang Lembur</th>
                <th>Transport</th>
                <th>Uang Makan</th>
                <th>THP LMT Reguler</th>
                <th>THP LMT Koreksi</th>
                <th>THP LMT</th>
                <th>Koreksi Pph 21</th>
                <th>THP Karyawan</th>
                <th style="width: 10%;">ALL{{-- Jumlah yg harus diterima --}}</th>
                <th>Potongan SPSI</th>
                <th>Potongan Koperasi</th>
                <th>Jumlah THP yg harus diterima</th>
                <th style="width: 10%;">THP 25</th>
                <th style="width: 10%;">THP 10</th>
                <th>Slip</th>
                <th>Tgl Sync</th>
                <th>Status Tampil</th>
                <th style="width: 5%;">Slip</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

$(document).ready(function(){

  var tableMaster = $('#tblMaster').DataTable({
    "columnDefs": [{
      "searchable": false,
      "orderable": false,
      "targets": 0,
    render: function (data, type, row, meta) {
        return meta.row + meta.settings._iDisplayStart + 1;
    }
    }],
    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    "iDisplayLength": 10,
    responsive: true,
    // "searching": false,
    // "scrollX": true,
    // "scrollY": "700px",
    // "scrollCollapse": true,
    // "paging": false,
    // "lengthChange": false,
    // "ordering": true,
    // "info": true,
    // "autoWidth": false,
    "order": [[17, 'desc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: "{{ route('mobiles.dashboardlembur') }}",
    columns: [
      {data: null, name: null},
      {data: 'npk_asli', name: 'npk_asli'},
      {data: 'nama', name: 'nama'},
      {data: 'kd_pt', name: 'kd_pt', className: "none"},
      {data: 'divisi', name: 'divisi', className: "none"},
      {data: 'departemen', name: 'departemen', className: "none"},
      {data: 'kd_gol', name: 'kd_gol', className: "none"},
      {data: 't_gp', name: 't_gp', className: "dt-right"},
      {data: 'jum_hk', name: 'jum_hk', className: "none"},
      {data: 'jum_hk_k', name: 'jum_hk_k', className: "none"},
      {data: 'jum_jam_akt', name: 'jum_jam_akt', className: "none"},
      {data: 'jum_jam_akt_k', name: 'jum_jam_akt_k', className: "none"},
      {data: 'jum_jam_tul', name: 'jum_jam_tul', className: "none"},
      {data: 'jum_jam_tul_k', name: 'jum_jam_tul_k', className: "none"},
      {data: 'tot_jam_tul', name: 'tot_jam_tul', className: "dt-right"},
      {data: 't_net_lbr', name: 't_net_lbr', className: "none"},
      {data: 't_net_lbr_k', name: 't_net_lbr_k', className: "none"},
      {data: 't_net_lbr_tot', name: 't_net_lbr_tot', className: "dt-right"},
      {data: 'u_tra_tot', name: 'u_tra_tot', className: "none"},
      {data: 'netu_mak_tot', name: 'netu_mak_tot', className: "none"},
      {data: 't_thp', name: 't_thp', className: "none"},
      {data: 't_thp_k', name: 't_thp_k', className: "none"},
      {data: 't_thp_tot', name: 't_thp_tot', className: "none"},
      {data: 'adj_pph21', name: 'adj_pph21', className: "none"},
      {data: 'tot_thp', name: 'tot_thp', className: "none"},
      {data: 'jum_diterima', name: 'jum_diterima', className: "dt-right"},
      {data: 'p_spsi', name: 'p_spsi', className: "none"},
      {data: 'p_kop', name: 'p_kop', className: "none"},
      {data: 'jum_thp', name: 'jum_thp', className: "none"},
      {data: 'thp_25', name: 'thp_25', className: "dt-right"},
      {data: 'thp_10', name: 'thp_10', className: "dt-right"},
      {data: 'kd_slip', name: 'kd_slip', className: "none"},
      {data: 'tgl_sync', name: 'tgl_sync', className: "none", orderable: false, searchable: false},
      {data: 'st_tampil', name: 'st_tampil', className: "none", orderable: false, searchable: false},
      {data: 'print', name: 'print', orderable: false, searchable: false}
    ]
    // , 
    // "footerCallback": function ( row, data, start, end, display ) {
    //   var api = this.api(), data;

    //   // Remove the formatting to get integer data for summation
    //   var intVal = function (i) {
    //       return typeof i === 'string' ?
    //           i.replace(/[\$,]/g, '')*1 :
    //           typeof i === 'number' ?
    //               i : 0;
    //   };

    //   var column = 4;
    //   total = api.column(column).data().reduce( function (a, b) {
    //     return intVal(a) + intVal(b);
    //   },0);
    //   total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    //   $(api.column(column).footer() ).html(
    //     // 'Total OK: '+ pageTotal + ' ('+ total +')'
    //     '<p align="right">' + total + '</p>'
    //   );

    //   var column = 5;
    //   total = api.column(column).data().reduce( function (a, b) {
    //     return intVal(a) + intVal(b);
    //   },0);
    //   total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    //   $(api.column(column).footer() ).html(
    //     // 'Total OK: '+ pageTotal + ' ('+ total +')'
    //     '<p align="right">' + total + '</p>'
    //   );
    // }
  });

  $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
    data.tahun = $('select[name="filter_status_tahun"]').val();
    data.bulan = $('select[name="filter_status_bulan"]').val();
    data.pt = $('select[name="filter_status_pt"]').val();
  });

  $('#display').click( function () {
    tableMaster.ajax.reload();
  });

  $('#display').click();
});
</script>
@endsection