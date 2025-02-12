@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Stock Warehouse
      <small>Stock Warehouse</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-truck"></i> MTC - Laporan</li>
      <li class="active"><i class="fa fa-files-o"></i> Stock Warehouse</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Stock Warehouse</h3>
      </div>
      <!-- /.box-header -->

      <div class="box-body form-horizontal">
        <div class="form-group">
          <div class="col-sm-3">
            {!! Form::label('lblwhs', 'Warehouse') !!}
            <select id="filter_whs" name="filter_whs" aria-controls="filter_status" class="form-control select2">
              <option value="ALL" selected="selected">ALL</option>
              @foreach($baan_whs->get() as $whs)
              <option value="{{ $whs->kd_cwar }}">{{ $whs->kd_cwar }} - {{ $whs->nm_dsca }}</option>
              @endforeach
            </select>
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
          <div class="col-sm-7">
            <label name="lblitemname">Nama Item</label>
            <input type="text" id="item_name" name="item_name" class="form-control" placeholder="Nama Item" disabled="">
          </div>
        </div>
        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-3">
            {!! Form::label('lblmesin', 'Mesin (F9)') !!}
            <div class="input-group">
              <input type="text" id="kd_mesin" name="kd_mesin" class="form-control" placeholder="Mesin" onkeydown="keyPressedKdMesin(event)" onchange="validateKdMesin()">
              <span class="input-group-btn">
                <button id="btnpopupmesin" name="btnpopupmesin" type="button" class="btn btn-info" onclick="popupKdMesin()" data-toggle="modal" data-target="#mesinModal">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </span>
            </div>
          </div>
          <div class="col-sm-7">
            <label name="lblnmmesin">Nama Mesin</label>
            <input type="text" id="nm_mesin" name="nm_mesin" class="form-control" placeholder="Nama Mesin" disabled="">
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
              <th style="width: 1%;">No</th>
              <th style="width: 15%;">Item</th>
              <th>Deskripsi</th>
              <th style="width: 7%;">WHS</th>
              <th style="width: 8%;">QTY</th>
              <th style="width: 12%;">Last Sync</th>
              <th style="width: 10%;">Outstanding</th>
            </tr>
          </thead>
        </table>          
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><p id="info-detail">Mesin</p></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="tblMesin" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th style="width: 20%;">Kode Mesin</th>
                      <th>Item</th>
                      <th style="width: 10%;">QTY</th>
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

<!-- Modal Part -->
@include('mtc.stockwhs.popup.partModal')
<!-- Modal Mesin -->
@include('mtc.stockwhs.popup.mesinModal')
<!-- Popup Outstanding Modal -->
@include('ppc.stockppc.popup.outstandingppModal')
<!-- Popup Outstanding Modal -->
@include('ppc.stockppc.popup.outstandingpoModal')
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("filter_whs").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function keyPressedPart(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupitem').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("kd_mesin").focus();
    }
  }

  function popupPart() {
    var myHeading = "<p>Popup Part</p>";
    $("#partModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupBaanMpart') }}';
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
            document.getElementById("kd_mesin").focus();
          }
        });
      },
    });
  }

  function validatePart() {
    var item = document.getElementById("item").value.trim();
    if(item !== '') {
      var url = '{{ route('datatables.validasiBaanMpart', 'param') }}';
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

  function keyPressedKdMesin(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupmesin').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("display").focus();
    }
  }

  function popupKdMesin() {
    var myHeading = "<p>Popup Mesin</p>";
    $("#mesinModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupMesinAlls') }}';
    var lookupMesin = $('#lookupMesin').DataTable({
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
      { data: 'kd_mesin', name: 'kd_mesin'},
      { data: 'nm_mesin', name: 'nm_mesin'},
      { data: 'kd_line', name: 'kd_line'},
      { data: 'nm_line', name: 'nm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupMesin tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupMesin.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_mesin").value = value["kd_mesin"];
            document.getElementById("nm_mesin").value = value["nm_mesin"];
            $('#mesinModal').modal('hide');
          });
        });
        $('#mesinModal').on('hidden.bs.modal', function () {
          var kd_mesin = document.getElementById("kd_mesin").value.trim();
          if(kd_mesin === '') {
            document.getElementById("nm_mesin").value = "";
            document.getElementById("kd_mesin").focus();
          } else {
            document.getElementById("display").focus();
          }
        });
      },
    });
  }

  function validateKdMesin() {
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    if(kd_mesin !== '') {
      var url = '{{ route('datatables.validasiMesinAlls', 'param') }}';
      url = url.replace('param', window.btoa(kd_mesin));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_mesin").value = result["kd_mesin"];
          document.getElementById("nm_mesin").value = result["nm_mesin"];
          document.getElementById("display").focus();
        } else {
          document.getElementById("kd_mesin").value = "";
          document.getElementById("nm_mesin").value = "";
          document.getElementById("kd_mesin").focus();
          swal("Mesin tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_mesin").value = "";
      document.getElementById("nm_mesin").value = "";
    }
  }

  $(document).ready(function(){

    $('#btn-view-pp').click( function () {
      popupPp(this);
    });

    $('#btn-view-po').click( function () {
      popupPo(this);
    });

    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        // "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[4, 'asc'],[1, 'asc'],[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('stockohigps.dashboard') }}",
      columns: [
        {data: null, name: null},
        {data: 'item', name: 'item'},
        {data: 'item_name', name: 'item_name'},
        {data: 'whse', name: 'whse'},
        {data: 'qty', name: 'qty', className: "dt-right"},
        {data: 'dtcrea', name: 'dtcrea'}, 
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.whs = $('select[name="filter_whs"]').val();
      data.item = $('input[name="item"]').val();
      data.kd_mesin = $('input[name="kd_mesin"]').val();
    });

    var tblMesin = $('#tblMesin').DataTable({
      "columnDefs": [{
        "searchable": false,
        // "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      responsive: true,
      "order": [[1, 'asc'],[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('stockohigps.dashboardmesin') }}",
      columns: [
        {data: null, name: null},
        {data: 'kd_mesin', name: 'kd_mesin'}, 
        {data: 'item_no', name: 'item_no'}, 
        {data: 'nil_qpu', name: 'nil_qpu', className: "dt-right"}
      ],
    });

    $("#tblMesin").on('preXhr.dt', function(e, settings, data) {
      data.kd_mesin = $('input[name="kd_mesin"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
      tblMesin.ajax.reload();
    });

    //$('#display').click();
  });

  //POPUP PP
  function popupPp(item) {
    var myHeading = "<p>Outstanding Pp</p>";
    $("#outppModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupPp', ['param', 'param2']) }}';
    url = url.replace('param2', window.btoa("IGPJ"));
    url = url.replace('param', window.btoa(item));

    var lookupOutpp = $('#lookupOutpp').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[1, 'desc'],[0, 'asc']],
      columns: [
        { data: 'no_pp', name: 'no_pp'},
        { data: 'tgl_pp', name: 'tgl_pp', className: "dt-center"},
        { data: 'qty_pp', name: 'qty_pp', className: "dt-right"},
        { data: 'qty_po', name: 'qty_po', className: "dt-right"}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        $('div.dataTables_filter input').focus();
      },
    });     
  }

  //POPUP PO
  function popupPo(item) {
    var myHeading = "<p>Outstanding Po</p>";
    $("#outpoModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupPo', ['param', 'param2']) }}';
    url = url.replace('param2', window.btoa("IGPJ"));
    url = url.replace('param', window.btoa(item));

    var lookupOutpo = $('#lookupOutpo').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[1, 'desc'],[0, 'asc']],
      columns: [
        { data: 'no_po', name: 'no_po'},
        { data: 'tgl_po', name: 'tgl_po', className: "dt-center"},
        { data: 'qty_po', name: 'qty_po', className: "dt-right"},
        { data: 'qty_lpb', name: 'qty_lpb', className: "dt-right"},
        { data: 'nmsupp', name: 'nmsupp'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        $('div.dataTables_filter input').focus();
      },
    });
  }
</script>
@endsection