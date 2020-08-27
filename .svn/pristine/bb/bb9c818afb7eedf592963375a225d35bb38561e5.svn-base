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
        <li><i class="fa fa-truck"></i> PPC - Laporan</li>
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
                <option value="ALL">ALL</option>
                <option value="IGPJ" selected="selected">IGP - JAKARTA</option>
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
                <th rowspan="2" style="width: 1%;text-align:center;">No</th>
                <th rowspan="2" style="width: 10%;">Supplier</th>
                <th rowspan="2">Nama Supplier</th>
                <th rowspan="2" style="width: 8%;">No. PO</th>
                <th rowspan="2" style="width: 13%;">Item</th>
                <th rowspan="2">Deskripsi</th>
                <th rowspan="2" style="width: 8%;">No. DN</th>
                <th rowspan="2" style="width: 5%;">Tgl Kirim</th>
                <th colspan="3" style="text-align:center;">QTY</th>
                <th rowspan="2" style="width: 5%;">No. RE</th>
                <th rowspan="2" style="width: 5%;">No. SJ</th>
                <th rowspan="2">Tgl Order</th>
                <th rowspan="2">Status</th>
              </tr>
              <tr>
                <th style="width: 5%;">DN</th>
                <th style="width: 5%;">RE</th>
                <th style="width: 5%;">BLC</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
        
        @if (Auth::user()->can('ppc-dnsupp-revisi'))
          <div class="box-footer">
            <button id="btn-sync" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Sinkronisasi (Oracle to PostgreSql)"><span class="glyphicon glyphicon-refresh"></span> Sinkronisasi (BAAN to Oracle & PostgreSql)</button>
          </div>
          <!-- /.box -->
        @endif
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

  $("#btn-sync").click(function(){

    var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    var date_awal = new Date($('input[name="tgl_awal"]').val());
    var tgl_awal;
    if(date_awal.getDate() < 10) {
      tgl_awal = "0" + date_awal.getDate();
    } else {
      tgl_awal = date_awal.getDate();
    }
    var periode_awal_name = tgl_awal + " " + monthNames[date_awal.getMonth()] + " " + date_awal.getFullYear();
    var periode_awal;
    if((date_awal.getMonth() + 1) < 10) {
      periode_awal = date_awal.getFullYear() + "0" + (date_awal.getMonth() + 1) + "" + tgl_awal;
    } else {
      periode_awal = date_awal.getFullYear() + "" + (date_awal.getMonth() + 1) + "" + tgl_awal;
    }

    var date_akhir = new Date($('input[name="tgl_akhir"]').val());
    var tgl_akhir;
    if(date_akhir.getDate() < 10) {
      tgl_akhir = "0" + date_akhir.getDate();
    } else {
      tgl_akhir = date_akhir.getDate();
    }
    var periode_akhir_name = tgl_akhir + " " + monthNames[date_akhir.getMonth()] + " " + date_akhir.getFullYear();
    var periode_akhir;
    if((date_akhir.getMonth() + 1) < 10) {
      periode_akhir = date_akhir.getFullYear() + "0" + (date_akhir.getMonth() + 1) + "" + tgl_akhir;
    } else {
      periode_akhir = date_akhir.getFullYear() + "" + (date_akhir.getMonth() + 1) + "" + tgl_akhir;
    }

    if(periode_awal != periode_akhir) {
      swal("Tgl Awal harus sama dengan Tgl Akhir!", "Perhatikan inputan anda!", "error");
    } else {
      var msg = "Anda yakin Sinkronisasi data DN Tgl: " + periode_awal_name + " s/d " + periode_akhir_name + "?";
      var txt = "";
      swal({
        title: msg,
        text: txt,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, sync it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        var kode_sync = document.getElementById("kode_sync").value;
        var urlRedirect = "{{ route('syncs.tiga', ['param','param2','param3']) }}";
        urlRedirect = urlRedirect.replace('param3', window.btoa(periode_akhir));
        urlRedirect = urlRedirect.replace('param2', window.btoa(periode_awal));
        urlRedirect = urlRedirect.replace('param', kode_sync);
        window.location.href = urlRedirect;
      }, function (dismiss) {
        if (dismiss === 'cancel') {
          //
        }
      })
    }
  });

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
    var url = '{{ route('datatables.popupNoPoDnSupp', ['param','param2','param3','param4']) }}';
    url = url.replace('param4', window.btoa("O"));
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
      var url = '{{ route('datatables.validasiNoPoDnSupp', ['param','param2','param3']) }}';
      url = url.replace('param3', window.btoa("O"));
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
    var url = '{{ route('datatables.popupNoDnDnSupp', ['param','param2','param3','param4','param5']) }}';
    url = url.replace('param5', window.btoa("O"));
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
      var url = '{{ route('datatables.validasiNoDnDnSupp', ['param','param2','param3']) }}';
      url = url.replace('param3', window.btoa("O"));
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
      "iDisplayLength": 10,
      responsive: true,
      "order": [[1, 'asc'],[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('baandnsupps.dashboard') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'kd_bpid', name: 'kd_bpid'},
        {data: 'nm_bpid', name: 'nm_bpid', className: "none"},
        {data: 'no_po', name: 'no_po'},
        {data: 'item', name: 'item'},
        {data: 'item_name', name: 'item_name'},
        {data: 'no_dn', name: 'no_dn'},
        {data: 'tgl_kirim', name: 'tgl_kirim', className: "dt-center"},
        {data: 'qty_dn', name: 'qty_dn', className: "dt-right"},
        {data: 'qty_re', name: 'qty_re', className: "dt-right"},
        {data: 'qty_blc', name: 'qty_blc', className: "dt-right"},
        {data: 'no_re', name: 'no_re'},
        {data: 'no_sj', name: 'no_sj'}, 
        {data: 'tgl_order', name: 'tgl_order', className: "none", orderable: false, searchable: false}, 
        {data: 'st_close', name: 'st_close', className: "none", orderable: false, searchable: false}
      ],
    });

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