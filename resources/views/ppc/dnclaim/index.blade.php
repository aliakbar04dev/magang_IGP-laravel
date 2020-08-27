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
        <li><i class="fa fa-truck"></i> PPC KIM - TRANSAKSI</li>
        <li class="active"><i class="fa fa-files-o"></i> DN CLAIM TO SUPPLIER</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::hidden('tgl_awal_h', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_awal_h']) !!}
      {!! Form::hidden('tgl_akhir_h', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_akhir_h']) !!}
      {!! Form::hidden('kode_sync', base64_encode('BAAN_MONECLAIM'), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'kode_sync']) !!}
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
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-4">
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
            <div class="col-sm-2">
              {!! Form::label('lblstatus', 'Status Tampil') !!}
              <select id="filter_status" name="filter_status" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                <option value="T">YES</option>
                <option value="F">NO</option>
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
                <th rowspan="2" style="width: 2%;text-align:center;"><input type="checkbox" name="chk-all" id="chk-all" class="icheckbox_square-blue"></th>
                <th colspan="2" style="text-align:center;">WH</th>
                <th rowspan="2" style="width: 10%;text-align:center;">No. DN</th>
                <th rowspan="2" style="width: 10%;text-align:center;">Tgl DN</th>
                <th rowspan="2">Supplier</th>
                <th colspan="3" style="text-align:center;">QTY</th>
                <th rowspan="2">Revisi</th>
                <th rowspan="2">Ket. Revisi</th>
                <th rowspan="2">Tgl Tampil</th>
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
        
        @permission(['ppc-dnclaim-revisi'])
          <div class="box-footer">
            <button id="btntampil" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Tampilkan / Sembunyikan">
              <span class="glyphicon glyphicon-eye-open"></span> Tampilkan / Sembunyikan
            </button>
            &nbsp;&nbsp;
            <button id="btn-sync" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Sinkronisasi (Oracle to PostgreSql)">
              <span class="glyphicon glyphicon-refresh"></span> Sinkronisasi (BAAN to Oracle & PostgreSql)
            </button>
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
                      @permission(['ppc-dnclaim-revisi'])
                        &nbsp;
                        <button id="btnrevisi" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Revisi DN"><span class="glyphicon glyphicon-repeat"></span> Revisi DN</button>
                      @endpermission
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

  $("#btn-sync").click(function(){

    var msg = "Anda yakin Sinkronisasi data MONETARY CLAIM?";
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
      swal({
        title: 'Pilih Tgl Awal & Tanggal Akhir',
        html:
          '<div class="box-body form-horizontal"><div class="form-group"><div class="col-sm-6">{!! Form::label('tgl_awal', 'Tgl Awal') !!}{!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl_awal']) !!}</div><div class="col-sm-6">{!! Form::label('tgl_akhir', 'Tgl Akhir') !!}{!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'tgl_akhir']) !!}</div></div></div>',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#tgl_awal').val() && $('#tgl_akhir').val()) {
              resolve([
                $('#tgl_awal').val(),
                $('#tgl_akhir').val()
              ])
            } else {
              reject('Tgl Awal & Akhir tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var date_awal = new Date(result[0]);
        var tgl_awal;
        if(date_awal.getDate() < 10) {
          tgl_awal = "0" + date_awal.getDate();
        } else {
          tgl_awal = date_awal.getDate();
        }
        var periode_awal;
        if((date_awal.getMonth() + 1) < 10) {
          periode_awal = date_awal.getFullYear() + "0" + (date_awal.getMonth() + 1) + "" + tgl_awal;
        } else {
          periode_awal = date_awal.getFullYear() + "" + (date_awal.getMonth() + 1) + "" + tgl_awal;
        }

        var date_akhir = new Date(result[1]);
        var tgl_akhir;
        if(date_akhir.getDate() < 10) {
          tgl_akhir = "0" + date_akhir.getDate();
        } else {
          tgl_akhir = date_akhir.getDate();
        }
        var periode_akhir;
        if((date_akhir.getMonth() + 1) < 10) {
          periode_akhir = date_akhir.getFullYear() + "0" + (date_akhir.getMonth() + 1) + "" + tgl_akhir;
        } else {
          periode_akhir = date_akhir.getFullYear() + "" + (date_akhir.getMonth() + 1) + "" + tgl_akhir;
        }
        var kode_sync = document.getElementById("kode_sync").value;
        var urlRedirect = "{{ route('syncs.tiga', ['param','param2','param3']) }}";
        urlRedirect = urlRedirect.replace('param3', window.btoa(periode_akhir));
        urlRedirect = urlRedirect.replace('param2', window.btoa(periode_awal));
        urlRedirect = urlRedirect.replace('param', kode_sync);
        window.location.href = urlRedirect;
      }).catch(swal.noop)
    }, function (dismiss) {
      if (dismiss === 'cancel') {
        //
      }
    })
  });

  function keyPressedNoDn(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnodn').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("filter_supplier").focus();
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
            document.getElementById("filter_supplier").focus();
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
          document.getElementById("filter_supplier").focus();
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
      "order": [[5, 'desc'],[4, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('baaniginh008s.dashboard') }}",
      columns: [
        {data: null, name: null, className: "dt-center"}, 
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'kd_whfrom', name: 'kd_whfrom', className: "dt-center"}, 
        {data: 'kd_whto', name: 'kd_whto', className: "dt-center"}, 
        {data: 'kd_pono', name: 'kd_pono', className: "dt-center"}, 
        {data: 'tgl_dn', name: 'tgl_dn', className: "dt-center"}, 
        {data: 'kd_bpid', name: 'kd_bpid'}, 
        {data: 'qty_dn', name: 'qty_dn', className: "dt-right"}, 
        {data: 'qty_sj', name: 'qty_sj', className: "dt-right"}, 
        {data: 'qty_act', name: 'qty_act', className: "dt-right"}, 
        {data: 'no_revisi', name: 'no_revisi', className: "none"}, 
        {data: 'ket_revisi', name: 'ket_revisi', className: "none"},
        {data: 'tgl_tampil', name: 'tgl_tampil', className: "none"}
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
          var kd_pono = tableMaster.cell(index, 4).data();
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
      data.supplier = $('select[name="filter_supplier"]').val();
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
    });

    $('#btntampil').click( function () {

      var validasi = "F";
      var ids = "-";
      var jmldata = 0;
      var table = $('#tblMaster').DataTable();
      table.search('').columns().search('').draw();
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
            var kd_pono = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = kd_pono;
            } else {
              ids = ids + "#quinza#" + kd_pono;
            }
            jmldata = jmldata + 1;
          }
        }
      }

      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Tampilkan / Sembunyikan?',
          text: 'Jumlah Data: ' + jmldata,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="glyphicon glyphicon-eye-open"></i> Tampilkan!',
          cancelButtonText: '<i class="glyphicon glyphicon-eye-close"></i> Sembunyikan!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          
          var token = document.getElementsByName('_token')[0].value.trim();
          var formData = new FormData();
          formData.append('_method', 'POST');
          formData.append('_token', token);
          formData.append('ids', ids);
          formData.append('st_tampil', 'T');

          var url = "{{ route('baaniginh008s.tampil')}}";
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
                swal("Update", data.message, "success");
                var table = $('#tblMaster').DataTable();
                table.ajax.reload(null, false);
                tableMaster.ajax.reload( function ( json ) {
                  if(tableMaster.rows().count() > 0) {
                    $('#tblMaster tbody tr:eq(0)').click(); 
                  } else {
                    initTable(window.btoa('-'));
                  }
                }, false);
              } else {
                swal("Cancelled", data.message, "error");
              }
            }, error:function(){ 
              $("#loading").hide();
              swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
            }
          });
        }, function (dismiss) {
          if (dismiss === 'cancel') {
            var token = document.getElementsByName('_token')[0].value.trim();
            var formData = new FormData();
            formData.append('_method', 'POST');
            formData.append('_token', token);
            formData.append('ids', ids);
            formData.append('st_tampil', 'F');

            var url = "{{ route('baaniginh008s.tampil')}}";
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
                  swal("Update", data.message, "success");
                  var table = $('#tblMaster').DataTable();
                  table.ajax.reload(null, false);
                  tableMaster.ajax.reload( function ( json ) {
                    if(tableMaster.rows().count() > 0) {
                      $('#tblMaster tbody tr:eq(0)').click(); 
                    } else {
                      initTable(window.btoa('-'));
                    }
                  }, false);
                } else {
                  swal("Cancelled", data.message, "error");
                }
              }, error:function(){ 
                $("#loading").hide();
                swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
              }
            });
          }
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");
      }
    });

    $('#btnrevisi').click( function () {
      var index = tableMaster.row('.selected').index();
      if(index == null) {
        swal("Tidak ada data yang dipilih!", "", "warning");
      } else {
        var kd_pono = tableMaster.cell(index, 4).data();
        var msg = 'Anda yakin membuat REVISI untuk No. DN: ' + kd_pono + '?';
        //additional input validations can be done hear
        swal({
          title: msg,
          text: "",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, revisi it!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: true,
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
          }).then(function (resultRevisi) {
            var token = document.getElementsByName('_token')[0].value.trim();

            var formData = new FormData();
            formData.append('_method', 'POST');
            formData.append('_token', token);
            formData.append('kd_pono', window.btoa(kd_pono));
            formData.append('ket_revisi', resultRevisi);

            var url = "{{ route('baaniginh008s.revisi')}}";
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
                  var table = $('#tblMaster').DataTable();
                  table.ajax.reload(null, false);

                  tableMaster.ajax.reload( function ( json ) {
                    if(tableMaster.rows().count() > 0) {
                      var click = '#tblMaster tbody tr:eq(' + index + ')';
                      $(click).click(); 
                    } else {
                      initTable(window.btoa('-'));
                    }
                  }, false);
                } else {
                  swal("Cancelled", data.message, "error");
                }
              }, error:function(){ 
                $("#loading").hide();
                swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
              }
            });
          }).catch(swal.noop)
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
      }
    });
  });
</script>
@endsection