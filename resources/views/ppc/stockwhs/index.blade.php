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
        <li><i class="fa fa-truck"></i> PPC - Laporan</li>
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
                <th style="width: 15%;">Last Sync</th>
                <th>Lokasi</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal Part -->
  @include('ppc.stockwhs.popup.partModal')
  <!-- Modal Mesin -->
  @include('ppc.stockwhs.popup.mesinModal')
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
            document.getElementById("kd_mesin").focus();
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
      "order": [[1, 'asc'],[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('stockohigps.dashboardppc') }}",
      columns: [
        {data: null, name: null},
        {data: 'item', name: 'item'},
        {data: 'item_name', name: 'item_name'},
        {data: 'whse', name: 'whse'},
        {data: 'qty', name: 'qty', className: "dt-right"},
        {data: 'dtcrea', name: 'dtcrea'}, 
        {data: 'lokasi', name: 'lokasi', className: "none"}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.whs = $('select[name="filter_whs"]').val();
      data.item = $('input[name="item"]').val();
      data.kd_mesin = $('input[name="kd_mesin"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    //$('#display').click();
  });
</script>
@endsection