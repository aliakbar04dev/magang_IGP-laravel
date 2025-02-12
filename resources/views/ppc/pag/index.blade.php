@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PAG
        <small>Perpindahan Antar Gudang</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-truck"></i> PPC - Laporan</li>
        <li class="active"><i class="fa fa-files-o"></i> PAG</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::hidden('tgl_awal_h', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_awal_h']) !!}
      {!! Form::hidden('tgl_akhir_h', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_akhir_h']) !!}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Perpindahan Antar Gudang</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
    		    <div class="col-sm-3">
              {!! Form::label('lblwhsfrom', 'Warehouse From') !!}
              <select id="filter_whs_from" name="filter_whs_from" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                @foreach($baan_whs_from->get() as $whs)
                  <option value="{{ $whs->kd_cwar }}">{{ $whs->kd_cwar }} - {{ $whs->nm_dsca }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3">
              {!! Form::label('lblwhsto', 'Warehouse To') !!}
              <select id="filter_whs_to" name="filter_whs_to" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                @foreach($baan_whs_to->get() as $whs)
                  <option value="{{ $whs->kd_cwar }}">{{ $whs->kd_cwar }} - {{ $whs->nm_dsca }}</option>
                @endforeach
              </select>
            </div>
    		  </div>
    		  <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-3">
              {!! Form::label('tgl_awal', 'Periode Awal') !!}
              {!! Form::date('tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Periode Awal', 'id' => 'tgl_awal']) !!}
            </div>
            <div class="col-sm-3">
              {!! Form::label('tgl_akhir', 'Periode Akhir') !!}
              {!! Form::date('tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Periode Akhir', 'id' => 'tgl_akhir']) !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-3">
              {!! Form::label('lblitem', 'Item (F9)') !!}
              <div class="input-group">
                <input type="text" id="item" name="item" class="form-control" placeholder="Item" onkeydown="keyPressedPart(event)" onchange="validatePart()">
                <span class="input-group-btn">
                  <button id="btnpopupitem" name="btnpopupitem" type="button" class="btn btn-info" onclick="popupPart()" data-toggle="modal" data-target="#partModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-5">
              <label name="lblitemname">Nama Item</label>
              <input type="text" id="item_name" name="item_name" class="form-control" placeholder="Nama Item" disabled="">
            </div>
          </div>
          <!-- /.form-group -->
    		  <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lblusername2', ' ') !!}
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
                <th colspan="5" style="text-align:center;">ISSUED</th>
                <th style="text-align:center;">RECEIPT</th>
                <th rowspan="2" style="width: 8%;text-align:center;">Balance</th>
                <th rowspan="2" style="width: 5%;text-align:center;">Remark</th>
              </tr>
              <tr>
                <th style="width: 11%;">WHS From</th>
                <th style="width: 9%;">WHS To</th>
                <th style="width: 15%;">Item</th>
                <th>Deskripsi</th>
                <th style="width: 8%;text-align:center;">QTY</th>
                <th style="width: 8%;text-align:center;">QTY</th>
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
                  <h3 class="box-title"><p id="info-detail">Detail</p></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th rowspan="2" style="width: 1%;text-align:center;">No</th>
                        <th colspan="5" style="text-align:center;">ISSUED</th>
                        <th colspan="5" style="text-align:center;">RECEIPT</th>
                        <th rowspan="2">Satuan</th>
                        <th rowspan="2">Gudang Asal</th>
                        <th rowspan="2">Gudag Tujuan</th>
                      </tr>
                      <tr>
                        <th style="width: 5%;">Tgl</th>
                        <th style="width: 10%;">No PAG</th>
                        <th style="width: 8%;">Qty</th>
                        <th style="width: 5%;">Status</th>
                        <th>User ID</th>
                        <th style="width: 8%;">Qty</th>
                        <th style="width: 11%;">No Trans</th>
                        <th style="width: 5%;">Tgl</th>
                        <th style="width: 5%;">Status</th>
                        <th>User ID</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
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

  <!-- Modal Part -->
  @include('ppc.pag.popup.partModal')
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("filter_whs_from").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function keyPressedPart(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupitem').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("display").focus();
    }
  }

  function popupPart() {
    var myHeading = "<p>Popup Part</p>";
    $("#partModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupBaanMpartAll') }}';
    var lookupPart = $('#lookupPart').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[1, 'asc']],
      columns: [
        { data: 'item', name: 'item'},
        { data: 'desc1', name: 'desc1'},
        { data: 'itemdesc', name: 'itemdesc'},
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupPart tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupPart.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("item").value = value["item"];
            document.getElementById("item_name").value = value["desc1"] + " (" + value["itemdesc"] + ")";
            $('#partModal').modal('hide');
          });
        });
        $('#partModal').on('hidden.bs.modal', function () {
          var item = document.getElementById("item").value.trim();
          if(item === '') {
            document.getElementById("item").value = "";
            document.getElementById("item_name").value = "";
            document.getElementById("item").focus();
          } else {
            document.getElementById("display").focus();
          }
        });
      },
    });
  }

  function validatePart() {
    var item = document.getElementById("item").value.trim();
    if(item !== '') {
      var url = '{{ route('datatables.validasiBaanMpartAll', 'param') }}';
      url = url.replace('param', window.btoa(item));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("item").value = result["item"];
          document.getElementById("item_name").value = result["desc1"] + " (" + result["itemdesc"] + ")";
        } else {
          document.getElementById("item").value = "";
          document.getElementById("item_name").value = "";
          document.getElementById("item").focus();
          swal("Item tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("item").value = "";
      document.getElementById("item_name").value = "";
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
      "order": [[1, 'asc'],[2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('baanpags.dashboard') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'kd_whs_fr', name: 'kd_whs_fr', className: "dt-center"},
        {data: 'kd_whs_to', name: 'kd_whs_to', className: "dt-center"},
        {data: 'item', name: 'item'},
        {data: 'item_name', name: 'item_name'},
        {data: 'qty_kirim', name: 'qty_kirim', className: "dt-right"},
        {data: 'qty_terima', name: 'qty_terima', className: "dt-right"},
        {data: 'balance', name: 'balance', className: "dt-right"},
        {data: 'remark', name: 'remark', className: "dt-center"}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail PAG';
        initTable(window.btoa('-'), window.btoa('-'), window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var kd_whs_fr = tableMaster.cell(index, 1).data();
          var kd_whs_to = tableMaster.cell(index, 2).data();
          var item = tableMaster.cell(index, 3).data();
          var item_name = tableMaster.cell(index, 4).data();
          var info = kd_whs_fr + " # " + kd_whs_to + " # " + item + " # " + item_name;
          document.getElementById("info-detail").innerHTML = 'Detail PAG (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(kd_whs_fr.replace(regex, "")), window.btoa(kd_whs_to.replace(regex, "")), window.btoa(item.replace(regex, "")));
        }
      }
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.whs_from = $('select[name="filter_whs_from"]').val();
      data.whs_to = $('select[name="filter_whs_to"]').val();
      data.item = $('input[name="item"]').val();
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
    });

    var urlDetail = '{{ route('baanpags.detail', ['param','param2','param3','param4','param5']) }}';
    urlDetail = urlDetail.replace('param5', window.btoa("-"));
    urlDetail = urlDetail.replace('param4', window.btoa("-"));
    urlDetail = urlDetail.replace('param3', window.btoa("-"));
    urlDetail = urlDetail.replace('param2', window.btoa($('input[name="tgl_akhir"]').val()));
    urlDetail = urlDetail.replace('param', window.btoa($('input[name="tgl_awal"]').val()));
    var tableDetail = $('#tblDetail').DataTable({
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
      "order": [[1, 'asc'],[2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: urlDetail,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'tgl_pag', name: 'tgl_pag', className: "dt-center"},
        { data: 'no_pag', name: 'no_pag', className: "dt-center"},
        { data: 'qty_kirim', name: 'qty_kirim', className: "dt-right"},
        { data: 'is_status', name: 'is_status', className: "dt-center"},
        { data: 'is_creaby', name: 'is_creaby'},
        { data: 'qty_terima', name: 'qty_terima', className: "dt-right"},
        { data: 'rc_rcno', name: 'rc_rcno', className: "dt-center"},
        { data: 'rc_ardt', name: 'rc_ardt', className: "dt-center"},
        { data: 'rc_status', name: 'rc_status', className: "dt-center"},
        { data: 'rc_creaby', name: 'rc_creaby'},
        { data: 'kd_sat', name: 'kd_sat', className: "none"},
        { data: 'kd_gdg_asal', name: 'kd_gdg_asal', className: "none"},
        { data: 'kd_gdg_tuj', name: 'kd_gdg_tuj', className: "none"}
      ],
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === 'string' ?
          i.replace(/[\$,]/g, '')*1 :
          typeof i === 'number' ?
          i : 0;
        };

        var column = 3;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        // pageTotal = api.column(column, { page: 'current'} ).data().reduce( function (a, b) {
        //   return intVal(a) + intVal(b);
        // },0);
        // Update footer
        // pageTotal = pageTotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
            // 'Total OK: '+ pageTotal + ' ('+ total +')'
            total
            );

        column = 6;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        // pageTotal = api.column(column, { page: 'current'} ).data().reduce( function (a, b) {
        //   return intVal(a) + intVal(b);
        // },0);
        // Update footer
        // pageTotal = pageTotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
            // 'Total OK: '+ pageTotal + ' ('+ total +')'
            total
            );
      }
    });

    function initTable(kd_whs_fr, kd_whs_to, item) {
      var tgl_awal = document.getElementById("tgl_awal_h").value.trim();
      var tgl_akhir = document.getElementById("tgl_akhir_h").value.trim();
      tableDetail.search('').columns().search('').draw();
      var urlDetail = '{{ route('baanpags.detail', ['param','param2','param3','param4','param5']) }}';
      urlDetail = urlDetail.replace('param5', item);
      urlDetail = urlDetail.replace('param4', kd_whs_to);
      urlDetail = urlDetail.replace('param3', kd_whs_fr);
      urlDetail = urlDetail.replace('param2', window.btoa(tgl_akhir));
      urlDetail = urlDetail.replace('param', window.btoa(tgl_awal));
      tableDetail.ajax.url(urlDetail).load();
    }

    $('#display').click( function () {
      document.getElementById("tgl_awal_h").value = $('input[name="tgl_awal"]').val();
      document.getElementById("tgl_akhir_h").value = $('input[name="tgl_akhir"]').val();
      document.getElementById("info-detail").innerHTML = 'Detail PAG';
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('-'), window.btoa('-'), window.btoa('-'));
        }
      });
    });

    // $('#display').click();
  });
</script>
@endsection