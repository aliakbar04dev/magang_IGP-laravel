@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        DN Claim to Supplier
        <small>DN Claim to Supplier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-truck"></i> CLAIM - TRANSAKSI</li>
        <li class="active"><i class="fa fa-files-o"></i> DN - CLAIM</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">DN Claim to Supplier</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
            <div class="col-sm-3">
              {!! Form::label('lblsite', 'Site') !!}
              <select id="filter_site" name="filter_site" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                <option value="IGPJ">IGP - JAKARTA</option>
                <option value="IGPK">IGP - KARAWANG</option>
              </select>
            </div>
            <div class="col-sm-3">
              {!! Form::label('openperiode', 'Open Periode') !!}
              {!! Form::text('openperiode', $openperiode, ['class'=>'form-control','placeholder' => 'Open Periode', 'disabled'=>'']) !!}
            </div>
    		  </div>
    		  <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('filter_bulan', 'Bulan') !!}
              <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" 
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
            <div class="col-sm-2">
              {!! Form::label('filter_tahun', 'Tahun') !!}
              <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
              class="form-control select2">
                @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                  @if ($i == \Carbon\Carbon::now()->format('Y'))
                    <option value={{ $i }} selected="selected">{{ $i }}</option>
                  @else
                    <option value={{ $i }}>{{ $i }}</option>
                  @endif
                @endfor
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblnodn', 'No. DN (F9)') !!}
              <div class="input-group">
                <input type="text" id="kd_pono" name="kd_pono" class="form-control" placeholder="No. DN" onkeydown="keyPressedNoDn(event)" onchange="validateNoDn()">
                <span class="input-group-btn">
                  <button id="btnpopupnodn" name="btnpopupnodn" type="button" class="btn btn-info" onclick="popupNoDn()" data-toggle="modal" data-target="#dnModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
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
                <th rowspan="2" style="width: 1%;text-align:center;">No</th>
                <th colspan="2" style="text-align:center;">WH</th>
                <th rowspan="2" style="width: 10%;text-align:center;">No. DN</th>
                <th rowspan="2" style="width: 10%;text-align:center;">Tgl DN</th>
                <th rowspan="2">Supplier</th>
                <th colspan="3" style="text-align:center;">QTY</th>
                <th rowspan="2">Revisi</th>
                <th rowspan="2">Ket. Revisi</th>
              </tr>
              <tr>
                <th style="width: 8%;text-align:center;">From</th>
                <th style="width: 8%;text-align:center;">To</th>
                <th style="width: 5%;">DN</th>
                <th style="width: 5%;">SJ</th>
                <th style="width: 5%;">ACT</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
        
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">
                    <p>
                      <label id="info-detail">Detail</label>
                    </p>
                  </h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th rowspan="2" style="width: 5%;">No. POS</th>
                        <th rowspan="2" style="width: 15%;">Item</th>
                        <th rowspan="2">Deskripsi</th>
                        <th rowspan="2" style="width: 20%;">Keterangan</th>
                        <th colspan="3" style="text-align:center;">QTY</th>
                      </tr>
                      <tr>
                        <th style="width: 5%;">DN</th>
                        <th style="width: 5%;">SJ</th>
                        <th style="width: 5%;">ACT</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->

      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal DN -->
  @include('ppc.dnclaim.popup.dnModal')
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("filter_site").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function keyPressedNoDn(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnodn').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("display").focus();
    }
  }

  function popupNoDn() {
    var myHeading = "<p>Popup No. DN</p>";
    $("#dnModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupNoDnDnClaim', ['param','param2']) }}';
    url = url.replace('param2', window.btoa($('select[name="filter_site"]').val()));
    url = url.replace('param', window.btoa($('select[name="filter_tahun"]').val() + "" + $('select[name="filter_bulan"]').val()));

    var lookupDn = $('#lookupDn').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
        { data: 'kd_pono', name: 'kd_pono'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupDn tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupDn.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_pono").value = value["kd_pono"];
            $('#dnModal').modal('hide');
          });
        });
        $('#dnModal').on('hidden.bs.modal', function () {
          var kd_pono = document.getElementById("kd_pono").value.trim();
          if(kd_pono === '') {
            document.getElementById("kd_pono").value = "";
            document.getElementById("kd_pono").focus();
          } else {
            document.getElementById("display").focus();
          }
        });
      },
    });
  }

  function validateNoDn() {
    var kd_pono = document.getElementById("kd_pono").value.trim();
    if(kd_pono !== '') {
      var url = '{{ route('datatables.validasiNoDnDnClaim', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_pono));
      url = url.replace('param', window.btoa($('select[name="filter_site"]').val()));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_pono").value = result["kd_pono"];
          document.getElementById("display").focus();
        } else {
          document.getElementById("kd_pono").value = "";
          document.getElementById("kd_pono").focus();
          swal("No. DN tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_pono").value = "";
    }
  }

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
      "iDisplayLength": 5,
      responsive: true,
      "order": [[4, 'desc'],[3, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('baaniginh008s.dashboardall') }}",
      columns: [
        {data: null, name: null, className: "dt-center"}, 
        {data: 'kd_whfrom', name: 'kd_whfrom', className: "dt-center"}, 
        {data: 'kd_whto', name: 'kd_whto', className: "dt-center"}, 
        {data: 'kd_pono', name: 'kd_pono', className: "dt-center"}, 
        {data: 'tgl_dn', name: 'tgl_dn', className: "dt-center"}, 
        {data: 'kd_bpid', name: 'kd_bpid'}, 
        {data: 'qty_dn', name: 'qty_dn', className: "dt-right"}, 
        {data: 'qty_sj', name: 'qty_sj', className: "dt-right"}, 
        {data: 'qty_act', name: 'qty_act', className: "dt-right"}, 
        {data: 'no_revisi', name: 'no_revisi', className: "none"}, 
        {data: 'ket_revisi', name: 'ket_revisi', className: "none"}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail DN';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var kd_pono = tableMaster.cell(index, 3).data();
          document.getElementById("info-detail").innerHTML = 'Detail DN (' + kd_pono + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(kd_pono.replace(regex, "")));
        }
      }
    });

    var urlDetail = '{{ route('baaniginh008s.detail', 'param') }}';
    urlDetail = urlDetail.replace('param', "-");
    var tableDetail = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      responsive: true,
      "order": [[0, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: urlDetail,
      columns: [
        {data: 'no_pos', name: 'no_pos', className: "dt-center"},
        {data: 'kd_item', name: 'kd_item'},
        {data: 'item_name', name: 'item_name'}, 
        {data: 'nm_trket', name: 'nm_trket'}, 
        {data: 'qty_dn', name: 'qty_dn', className: "dt-right"}, 
        {data: 'qty_sj', name: 'qty_sj', className: "dt-right"}, 
        {data: 'qty_act', name: 'qty_act', className: "dt-right"}
      ],
    });

    function initTable(data) {
      var urlDetail = '{{ route('baaniginh008s.detail', 'param') }}';
      urlDetail = urlDetail.replace('param', data);
      tableDetail.ajax.url(urlDetail).load();
    }

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tahun = $('select[name="filter_tahun"]').val();
      data.bulan = $('select[name="filter_bulan"]').val();
      data.site = $('select[name="filter_site"]').val();
      data.kd_pono = $('input[name="kd_pono"]').val();
    });

    $('#display').click( function () {
      // tableMaster.ajax.reload()
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('-'));
        }
        // if(tableMaster.rows().count() > 0) {
        //   // $('#tblMaster tbody tr:eq(0)').click();
        //   tableMaster.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
        // }
      });
    });

    // $('#display').click();
  });
</script>
@endsection