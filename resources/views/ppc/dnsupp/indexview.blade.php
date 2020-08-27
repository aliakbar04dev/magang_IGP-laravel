@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        DN Supplier
        <small>DN Supplier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-truck"></i> PPC - TRANSAKSI</li>
        <li class="active"><i class="fa fa-files-o"></i> DN Supplier</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::hidden('tgl_awal_h', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_awal_h']) !!}
      {!! Form::hidden('tgl_akhir_h', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_akhir_h']) !!}
      {!! Form::hidden('kode_sync', base64_encode('BAAN_DN'), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kode_sync']) !!}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">DN Supplier</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lblsite', 'Site') !!}
              <select id="filter_site" name="filter_site" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                <option value="IGPJ">IGP - JAKARTA</option>
                <option value="IGPK">IGP - KARAWANG</option>
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('tgl_awal', 'Tgl Kirim Awal') !!}
              {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Kirim Awal', 'id' => 'tgl_awal']) !!}
            </div>
            <div class="col-sm-2">
              {!! Form::label('tgl_akhir', 'Tgl Kirim Akhir') !!}
              {!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Kirim Akhir', 'id' => 'tgl_akhir']) !!}
            </div>
    		  </div>
    		  <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-6">
              {!! Form::label('lblsupplier', 'Supplier') !!}
              <select name="filter_supplier" name="filter_supplier" aria-controls="filter_status" class="form-control select2">
                @if (strlen(Auth::user()->username) <= 5)
                  <option value="ALL" selected="selected">ALL</option>
                @endif
                @foreach ($suppliers->get() as $supplier)
                  <option value={{ $supplier->kd_supp }}>{{ $supplier->nama.' - '.$supplier->kd_supp }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lblnopo', 'No. PO (F9)') !!}
              <div class="input-group">
                <input type="text" id="no_po" name="no_po" class="form-control" placeholder="No. PO" onkeydown="keyPressedNoPo(event)" onchange="validateNoPo()">
                <span class="input-group-btn">
                  <button id="btnpopupnopo" name="btnpopupnopo" type="button" class="btn btn-info" onclick="popupNoPo()" data-toggle="modal" data-target="#poModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblnodn', 'No. DN (F9)') !!}
              <div class="input-group">
                <input type="text" id="no_dn" name="no_dn" class="form-control" placeholder="No. DN" onkeydown="keyPressedNoDn(event)" onchange="validateNoDn()">
                <span class="input-group-btn">
                  <button id="btnpopupnodn" name="btnpopupnodn" type="button" class="btn btn-info" onclick="popupNoDn()" data-toggle="modal" data-target="#dnModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblstatus', 'Status') !!}
              <select id="filter_status" name="filter_status" aria-controls="filter_status" class="form-control select2">
                <option value="ALL">ALL</option>
                <option value="F" selected="selected">OPEN</option>
                <option value="T">CLOSE</option>
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
                <th style="width: 1%;text-align:center;">No</th>
                <th style="text-align: center;width: 2%;"><input type="checkbox" name="chk-all" id="chk-all" class="icheckbox_square-blue"></th>
                <th style="width: 10%;text-align:center;">No. DN</th>
                <th style="width: 5%;text-align:center;">Revisi</th>
                <th style="width: 5%;text-align:center;">Jenis</th>
                <th style="width: 10%;text-align:center;">No. PO</th>
                <th style="width: 11%;text-align:center;">Tgl Order</th>
                <th style="width: 10%;text-align:center;">Tgl Kirim</th>
                <th style="width: 5%;text-align:center;">Cycle</th>
                <th>Supplier</th>
                <th>Status</th>
                <th>Ket. Revisi</th>
                <th>PIC Cetak</th>
                <th>Tgl Cetak</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->

        @permission(['ppc-dnsupp-revisi', 'ppc-dnsupp-download'])
          <div class="box-footer">
            @permission(['ppc-dnsupp-revisi'])
              <button id="btnrevisi" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Revisi DN">
                <span class="glyphicon glyphicon-repeat"></span> Revisi DN
              </button>
              &nbsp;&nbsp;
            @endpermission
            @permission(['ppc-dnsupp-download'])
              <button id="download-dn" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Download DN">
                <span class="glyphicon glyphicon-download-alt"></span> DN
              </button>
              &nbsp;&nbsp;
              <button id="download-kanban" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Download Kanban">
                <span class="glyphicon glyphicon-download-alt"></span> Kanban
              </button>
            @endpermission
          </div>
          <!-- /.box -->
        @endpermission

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
                        <th style="width: 1%;">No</th>
                        <th style="width: 15%;">Item</th>
                        <th>Deskripsi</th>
                        <th style="width: 13%;">QTY / Kanban</th>
                        <th style="width: 12%;">Jml Kanban</th>
                        <th style="width: 10%;">QTY DN</th>
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

        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">
                    <p>
                      <label id="info-detail2">History</label>
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
                  <table id="tblHistory" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 1%;">No</th>
                        <th style="width: 15%;">Username</th>
                        <th>Nama</th>
                        <th style="width: 15%;">Action</th>
                        <th>Keterangan</th>
                        <th style="width: 15%;">IP</th>
                        <th style="width: 10%;">Tanggal</th>
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

  <!-- Modal PO -->
  @include('ppc.dnsupp.popup.poModal')
  <!-- Modal DN -->
  @include('ppc.dnsupp.popup.dnModal')
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("filter_site").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function keyPressedNoPo(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnopo').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("no_dn").focus();
    }
  }

  function popupNoPo() {
    var myHeading = "<p>Popup No. PO</p>";
    $("#poModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupNoPoDnSupp', ['param','param2','param3']) }}';
    url = url.replace('param3', window.btoa($('select[name="filter_site"]').val()));
    url = url.replace('param2', window.btoa($('input[name="tgl_akhir"]').val()));
    url = url.replace('param', window.btoa($('input[name="tgl_awal"]').val()));
    var lookupPo = $('#lookupPo').DataTable({
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
        { data: 'no_po', name: 'no_po'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupPo tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupPo.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_po").value = value["no_po"];
            $('#poModal').modal('hide');
          });
        });
        $('#poModal').on('hidden.bs.modal', function () {
          var no_po = document.getElementById("no_po").value.trim();
          if(no_po === '') {
            document.getElementById("no_po").value = "";
            document.getElementById("no_po").focus();
          } else {
            document.getElementById("no_dn").focus();
          }
        });
      },
    });
  }

  function validateNoPo() {
    var no_po = document.getElementById("no_po").value.trim();
    if(no_po !== '') {
      var url = '{{ route('datatables.validasiNoPoDnSupp', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(no_po));
      url = url.replace('param', window.btoa($('select[name="filter_site"]').val()));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_po").value = result["no_po"];
        } else {
          document.getElementById("no_po").value = "";
          document.getElementById("no_po").focus();
          swal("No. PO tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_po").value = "";
    }
  }

  function keyPressedNoDn(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnodn').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("filter_status").focus();
    }
  }

  function popupNoDn() {
    var myHeading = "<p>Popup No. DN</p>";
    $("#dnModalLabel").html(myHeading);
    var no_po = document.getElementById("no_po").value.trim();
    if(no_po === '') {
      no_po = "-";
    }
    var url = '{{ route('datatables.popupNoDnDnSupp', ['param','param2','param3','param4']) }}';
    url = url.replace('param4', window.btoa(no_po));
    url = url.replace('param3', window.btoa($('select[name="filter_site"]').val()));
    url = url.replace('param2', window.btoa($('input[name="tgl_akhir"]').val()));
    url = url.replace('param', window.btoa($('input[name="tgl_awal"]').val()));

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
        { data: 'no_dn', name: 'no_dn'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupDn tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupDn.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_dn").value = value["no_dn"];
            $('#dnModal').modal('hide');
          });
        });
        $('#dnModal').on('hidden.bs.modal', function () {
          var no_dn = document.getElementById("no_dn").value.trim();
          if(no_dn === '') {
            document.getElementById("no_dn").value = "";
            document.getElementById("no_dn").focus();
          } else {
            document.getElementById("filter_status").focus();
          }
        });
      },
    });
  }

  function validateNoDn() {
    var no_dn = document.getElementById("no_dn").value.trim();
    if(no_dn !== '') {
      var url = '{{ route('datatables.validasiNoDnDnSupp', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(no_dn));
      url = url.replace('param', window.btoa($('select[name="filter_site"]').val()));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_dn").value = result["no_dn"];
          document.getElementById("filter_status").focus();
        } else {
          document.getElementById("no_dn").value = "";
          document.getElementById("no_dn").focus();
          swal("No. DN tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_dn").value = "";
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
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('dashboardview.baandnsupps') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'no_dn', name: 'no_dn', className: "dt-center"},
        {data: 'no_revisi', name: 'no_revisi', className: "dt-center"},
        {data: 'jns_dn', name: 'jns_dn', className: "dt-center"},
        {data: 'no_po', name: 'no_po', className: "dt-center"},
        {data: 'tgl_order', name: 'tgl_order', className: "dt-center"},
        {data: 'tgl_kirim', name: 'tgl_kirim', className: "dt-center"},
        {data: 'no_cycle', name: 'no_cycle', className: "dt-center"},
        {data: 'kd_bpid', name: 'kd_bpid'},
        {data: 'st_close', name: 'st_close', className: "none", orderable: false, searchable: false},
        {data: 'ket_revisi', name: 'ket_revisi', className: "none"}, 
        {data: 'pic_cetak', name: 'pic_cetak', className: "none", orderable: false, searchable: false}, 
        {data: 'tgl_cetak', name: 'tgl_cetak', className: "none", orderable: false, searchable: false}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail DN';
        document.getElementById("info-detail2").innerHTML = 'History DN';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var no_dn = tableMaster.cell(index, 2).data();
          document.getElementById("info-detail").innerHTML = 'Detail DN (' + no_dn + ')';
          document.getElementById("info-detail2").innerHTML = 'History DN (' + no_dn + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(no_dn.replace(regex, "")));
        }
      }
    });

    var urlDetail = '{{ route('baandnsupps.detail', 'param') }}';
    urlDetail = urlDetail.replace('param', "-");
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
      "iDisplayLength": 5,
      responsive: true,
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: urlDetail,
      columns: [
        {data: null, name: null},
        {data: 'item', name: 'item'},
        {data: 'item_name', name: 'item_name'}, 
        {data: 'qty_per_kanban', name: 'qty_per_kanban', className: "dt-right"}, 
        {data: 'qty_kanban', name: 'qty_kanban', className: "dt-right"}, 
        {data: 'qty_dn', name: 'qty_dn', className: "dt-right"}
      ],
    });

    var url2 = '{{ route('baandnsupps.history', 'param') }}';
    url2 = url2.replace('param', "-");
    var tableHistory = $('#tblHistory').DataTable({
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
      "order": [[6, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url2,
      columns: [
        {data: null, name: null},
        {data: 'username', name: 'username'},
        {data: 'name', name: 'name', className: "none"},
        {data: 'action', name: 'action'},
        {data: 'keterangan', name: 'keterangan'},
        {data: 'ip', name: 'ip'},
        {data: 'tgl', name: 'tgl'}
      ],
    });

    function initTable(data) {
      var urlDetail = '{{ route('baandnsupps.detail', 'param') }}';
      urlDetail = urlDetail.replace('param', data);
      tableDetail.ajax.url(urlDetail).load();

      var url2 = '{{ route('baandnsupps.history', 'param') }}';
      url2 = url2.replace('param', data);
      tableHistory.ajax.url(url2).load();
    }

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
      data.site = $('select[name="filter_site"]').val();
      data.supplier = $('select[name="filter_supplier"]').val();
      data.no_po = $('input[name="no_po"]').val();
      data.no_dn = $('input[name="no_dn"]').val();
      data.status = $('select[name="filter_status"]').val();
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

    $("#chk-all").change(function() {
      $("#loading").show();
      for($i = 0; $i < tableMaster.rows().count(); $i++) {
        var no = $i + 1;
        var data = tableMaster.cell($i, 1).data();
        var posisi = data.indexOf("chk");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="checkbox" name="', '');
        target = target.replace("<input type='checkbox' name='", '');
        target = target.replace("<input type='checkbox' name=", '');
        target = target.replace('<input name="', '');
        target = target.replace("<input name='", '');
        target = target.replace("<input name=", '');
        target = target +'chk';
        if(document.getElementById(target) != null) {
          document.getElementById(target).checked = this.checked;
        }
      }
      $("#loading").hide();
    });

    $("#download-dn").click(function(){
      $("#loading").show();
      var validasi = "F";
      var ids = "-";
      var jmldata = 0;
      var table = $('#tblMaster').DataTable();
      table.search('').columns().search('').draw();

      oTable = $('#tblMaster').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = -1;
      oTable.fnDraw();

      for($i = 0; $i < table.rows().count(); $i++) {
        var no = $i + 1;
        var data = table.cell($i, 1).data();
        var posisi = data.indexOf("chk");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="checkbox" name="', '');
        target = target.replace("<input type='checkbox' name='", '');
        target = target.replace("<input type='checkbox' name=", '');
        target = target.replace('<input name="', '');
        target = target.replace("<input name='", '');
        target = target.replace("<input name=", '');
        target = target +'chk';
        if(document.getElementById(target) != null) {
          var checkedOld = document.getElementById(target).checked;
          data = data.replace(target, 'row-' + no + '-chk');
          data = data.replace(target, 'row-' + no + '-chk');
          table.cell($i, 1).data(data);
          posisi = data.indexOf("chk");
          target = data.substr(0, posisi);
          target = target.replace('<input type="checkbox" name="', '');
          target = target.replace("<input type='checkbox' name='", '');
          target = target.replace("<input type='checkbox' name=", '');
          target = target.replace('<input name="', '');
          target = target.replace("<input name='", '');
          target = target.replace("<input name=", '');
          target = target +'chk';
          document.getElementById(target).checked = checkedOld;
          var checked = document.getElementById(target).checked;
          if(checked == true) {
            var no_dn = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_dn;
            } else {
              ids = ids + "#quinza#" + no_dn;
            }
            jmldata = jmldata + 1;
          }
        }
      }
      $("#loading").hide();
      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Anda yakin Download DN tsb?',
          text: 'Jumlah DN: ' + jmldata,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="glyphicon glyphicon-thumbs-up"></i> Yes, Download!',
          cancelButtonText: '<i class="glyphicon glyphicon-thumbs-down"></i> No, Cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          if(jmldata == 1) {

            oTable = $('#tblMaster').dataTable();
            var oSettings = oTable.fnSettings();
            oSettings._iDisplayLength = 5;
            oTable.fnDraw();
            
            var no_dn = ids;
            var regex = /(<([^>]+)>)/ig;
            var urlRedirect = '{{ route('baandnsupps.print', ['param','param2']) }}';
            urlRedirect = urlRedirect.replace('param2', window.btoa("DN"));
            urlRedirect = urlRedirect.replace('param', window.btoa(no_dn.replace(regex, "")));
            window.open(urlRedirect, '_blank');
          } else {
            var token = document.getElementsByName('_token')[0].value.trim();
            var formData = new FormData();
            formData.append('_method', 'POST');
            formData.append('_token', token);
            formData.append('ids', ids);
            formData.append('status_print', window.btoa("DN"));

            var url = "{{ route('baandnsupps.printonline')}}";
            $("#loading").show();
            $.ajax({
              type     : 'POST',
              url      : url,
              dataType : 'json',
              data     : formData,
              cache: false,
              contentType: false,
              processData: false,
              success:function(data){
                $("#loading").hide();
                if(data.status === 'OK'){
                  oTable = $('#tblMaster').dataTable();
                  var oSettings = oTable.fnSettings();
                  oSettings._iDisplayLength = 5;
                  oTable.fnDraw();

                  if(data.param != "") {
                    var urlRedirect = "{{ route('baandnsupps.printdownload', ['param1','param2','param3']) }}";
                    urlRedirect = urlRedirect.replace('param3', window.btoa(data.param3));
                    urlRedirect = urlRedirect.replace('param2', window.btoa(data.param0));
                    urlRedirect = urlRedirect.replace('param1', window.btoa(data.param));
                    // window.location.href = urlRedirect;
                    window.open(urlRedirect, '_blank');
                  }
                  if(data.param1 != "") {
                    var urlRedirect = "{{ route('baandnsupps.printdownload', ['param1','param2','param3']) }}";
                    urlRedirect = urlRedirect.replace('param3', window.btoa(data.param3));
                    urlRedirect = urlRedirect.replace('param2', window.btoa(data.param2));
                    urlRedirect = urlRedirect.replace('param1', window.btoa(data.param1));
                    // window.location.href = urlRedirect;
                    window.open(urlRedirect, '_blank');
                  }
                } else {
                  swal("Cancelled", data.message, "error");

                  oTable = $('#tblMaster').dataTable();
                  var oSettings = oTable.fnSettings();
                  oSettings._iDisplayLength = 5;
                  oTable.fnDraw();
                }
              }, error:function(){ 
                $("#loading").hide();
                swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");

                oTable = $('#tblMaster').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 5;
                oTable.fnDraw();
              }
            });
          }
        }, function (dismiss) {
          if (dismiss === 'cancel') {
            // 
          }
          oTable = $('#tblMaster').dataTable();
          var oSettings = oTable.fnSettings();
          oSettings._iDisplayLength = 5;
          oTable.fnDraw();
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");

        oTable = $('#tblMaster').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = 5;
        oTable.fnDraw();
      }
    });

    $("#download-kanban").click(function(){
      $("#loading").show();
      var validasi = "F";
      var ids = "-";
      var jmldata = 0;
      var table = $('#tblMaster').DataTable();
      table.search('').columns().search('').draw();

      oTable = $('#tblMaster').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = -1;
      oTable.fnDraw();

      for($i = 0; $i < table.rows().count(); $i++) {
        var no = $i + 1;
        var data = table.cell($i, 1).data();
        var posisi = data.indexOf("chk");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="checkbox" name="', '');
        target = target.replace("<input type='checkbox' name='", '');
        target = target.replace("<input type='checkbox' name=", '');
        target = target.replace('<input name="', '');
        target = target.replace("<input name='", '');
        target = target.replace("<input name=", '');
        target = target +'chk';
        if(document.getElementById(target) != null) {
          var checkedOld = document.getElementById(target).checked;
          data = data.replace(target, 'row-' + no + '-chk');
          data = data.replace(target, 'row-' + no + '-chk');
          table.cell($i, 1).data(data);
          posisi = data.indexOf("chk");
          target = data.substr(0, posisi);
          target = target.replace('<input type="checkbox" name="', '');
          target = target.replace("<input type='checkbox' name='", '');
          target = target.replace("<input type='checkbox' name=", '');
          target = target.replace('<input name="', '');
          target = target.replace("<input name='", '');
          target = target.replace("<input name=", '');
          target = target +'chk';
          document.getElementById(target).checked = checkedOld;
          var checked = document.getElementById(target).checked;
          if(checked == true) {
            var no_dn = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_dn;
            } else {
              ids = ids + "#quinza#" + no_dn;
            }
            jmldata = jmldata + 1;
          }
        }
      }
      $("#loading").hide();
      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Anda yakin Download KANBAN tsb?',
          text: 'Jumlah KANBAN: ' + jmldata,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="glyphicon glyphicon-thumbs-up"></i> Yes, Download!',
          cancelButtonText: '<i class="glyphicon glyphicon-thumbs-down"></i> No, Cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          if(jmldata == 1) {

            oTable = $('#tblMaster').dataTable();
            var oSettings = oTable.fnSettings();
            oSettings._iDisplayLength = 5;
            oTable.fnDraw();

            var no_dn = ids;
            var regex = /(<([^>]+)>)/ig;
            var urlRedirect = '{{ route('baandnsupps.print', ['param','param2']) }}';
            urlRedirect = urlRedirect.replace('param2', window.btoa("KANBAN"));
            urlRedirect = urlRedirect.replace('param', window.btoa(no_dn.replace(regex, "")));
            window.open(urlRedirect, '_blank');
          } else {
            var token = document.getElementsByName('_token')[0].value.trim();
            var formData = new FormData();
            formData.append('_method', 'POST');
            formData.append('_token', token);
            formData.append('ids', ids);
            formData.append('status_print', window.btoa("KANBAN"));

            var url = "{{ route('baandnsupps.printonline')}}";
            $("#loading").show();
            $.ajax({
              type     : 'POST',
              url      : url,
              dataType : 'json',
              data     : formData,
              cache: false,
              contentType: false,
              processData: false,
              success:function(data){
                $("#loading").hide();
                if(data.status === 'OK'){
                  oTable = $('#tblMaster').dataTable();
                  var oSettings = oTable.fnSettings();
                  oSettings._iDisplayLength = 5;
                  oTable.fnDraw();

                  var urlRedirect = "{{ route('baandnsupps.printdownload', ['param1','param2','param3']) }}";
                  urlRedirect = urlRedirect.replace('param3', window.btoa(data.param3));
                  urlRedirect = urlRedirect.replace('param2', window.btoa(data.param2));
                  urlRedirect = urlRedirect.replace('param1', window.btoa(data.param1));
                  // window.location.href = urlRedirect;
                  window.open(urlRedirect, '_blank');
                } else {
                  swal("Cancelled", data.message, "error");

                  oTable = $('#tblMaster').dataTable();
                  var oSettings = oTable.fnSettings();
                  oSettings._iDisplayLength = 5;
                  oTable.fnDraw();
                }
              }, error:function(){ 
                $("#loading").hide();
                swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");

                oTable = $('#tblMaster').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 5;
                oTable.fnDraw();
              }
            });
          }
        }, function (dismiss) {
          if (dismiss === 'cancel') {
            // 
          }
          oTable = $('#tblMaster').dataTable();
          var oSettings = oTable.fnSettings();
          oSettings._iDisplayLength = 5;
          oTable.fnDraw();
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");

        oTable = $('#tblMaster').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = 5;
        oTable.fnDraw();
      }
    });

    $('#btnrevisi').click( function () {
      $("#loading").show();
      var validasi = "F";
      var ids = "-";
      var jmldata = 0;
      var table = $('#tblMaster').DataTable();
      table.search('').columns().search('').draw();

      oTable = $('#tblMaster').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = -1;
      oTable.fnDraw();

      for($i = 0; $i < table.rows().count(); $i++) {
        var no = $i + 1;
        var data = table.cell($i, 1).data();
        var posisi = data.indexOf("chk");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="checkbox" name="', '');
        target = target.replace("<input type='checkbox' name='", '');
        target = target.replace("<input type='checkbox' name=", '');
        target = target.replace('<input name="', '');
        target = target.replace("<input name='", '');
        target = target.replace("<input name=", '');
        target = target +'chk';
        if(document.getElementById(target) != null) {
          var checkedOld = document.getElementById(target).checked;
          data = data.replace(target, 'row-' + no + '-chk');
          data = data.replace(target, 'row-' + no + '-chk');
          table.cell($i, 1).data(data);
          posisi = data.indexOf("chk");
          target = data.substr(0, posisi);
          target = target.replace('<input type="checkbox" name="', '');
          target = target.replace("<input type='checkbox' name='", '');
          target = target.replace("<input type='checkbox' name=", '');
          target = target.replace('<input name="', '');
          target = target.replace("<input name='", '');
          target = target.replace("<input name=", '');
          target = target +'chk';
          document.getElementById(target).checked = checkedOld;
          var checked = document.getElementById(target).checked;
          if(checked == true) {
            var no_dn = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_dn;
            } else {
              ids = ids + "#quinza#" + no_dn;
            }
            jmldata = jmldata + 1;
          }
        }
      }
      $("#loading").hide();
      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Anda yakin REVISI DN tsb?',
          text: 'Jumlah DN: ' + jmldata,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="glyphicon glyphicon-thumbs-up"></i> Yes, Revisi!',
          cancelButtonText: '<i class="glyphicon glyphicon-thumbs-down"></i> No, Cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          swal({
            title: 'Input Keterangan Revisi',
            input: 'textarea',
            showCancelButton: true,
            inputValidator: function (value) {
              return new Promise(function (resolve, reject) {
                if (value) {
                  if(value.length > 500) {
                    reject('Keterangan Revisi Max 500 Karakter!')
                  } else {
                    resolve()
                  }
                } else {
                  reject('Keterangan Revisi tidak boleh kosong!')
                }
              })
            }
          }).then(function (result) {
            var token = document.getElementsByName('_token')[0].value.trim();
            var formData = new FormData();
            formData.append('_method', 'POST');
            formData.append('_token', token);
            formData.append('ids', ids);
            formData.append('keterangan_revisi', result);

            var url = "{{ route('baandnsupps.revisi')}}";
            $("#loading").show();
            $.ajax({
              type     : 'POST',
              url      : url,
              dataType : 'json',
              data     : formData,
              cache: false,
              contentType: false,
              processData: false,
              success:function(data){
                $("#loading").hide();
                if(data.status === 'OK'){
                  swal("Revised", data.message, "success");

                  oTable = $('#tblMaster').dataTable();
                  var oSettings = oTable.fnSettings();
                  oSettings._iDisplayLength = 5;
                  oTable.fnDraw();

                  var table = $('#tblMaster').DataTable();
                  table.ajax.reload(null, false);
                } else {
                  swal("Cancelled", data.message, "error");

                  oTable = $('#tblMaster').dataTable();
                  var oSettings = oTable.fnSettings();
                  oSettings._iDisplayLength = 5;
                  oTable.fnDraw();
                }
              }, error:function(){ 
                $("#loading").hide();
                swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");

                oTable = $('#tblMaster').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 5;
                oTable.fnDraw();
              }
            });
          }).catch(swal.noop)
        }, function (dismiss) {
          if (dismiss === 'cancel') {
            // 
          }
          oTable = $('#tblMaster').dataTable();
          var oSettings = oTable.fnSettings();
          oSettings._iDisplayLength = 5;
          oTable.fnDraw();
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");

        oTable = $('#tblMaster').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = 5;
        oTable.fnDraw();
      }
    });
  });
</script>
@endsection