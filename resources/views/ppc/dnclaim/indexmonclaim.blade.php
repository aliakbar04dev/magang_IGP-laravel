@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Monetary Claim Calculation
        <small>Monetary Claim Calculation</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-truck"></i> PPC KIM - TRANSAKSI</li>
        <li class="active"><i class="fa fa-files-o"></i> Monetary Claim Calculation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::open(['url' => route('baaniginh008s.calculation'),
      'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'id'=>'form_id']) !!}
        {!! Form::hidden('param_tahun', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_tahun']) !!}
        {!! Form::hidden('param_bulan', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_bulan']) !!}
        {!! Form::hidden('param_kd_supp', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_kd_supp']) !!}
        {!! Form::hidden('jml_row', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
        {!! Form::hidden('status', "-", ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'status']) !!}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Monetary Claim Calculation</h3>
          </div>
          <!-- /.box-header -->
          
      		<div class="box-body form-horizontal">
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
                {!! Form::label('lbldisplay', 'Action') !!}
                <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
              </div>
              <div class="col-sm-2">
                {!! Form::label('lblcalculation', 'Action') !!}
                <button id="calculation" type="button" class="form-control btn btn-success" data-toggle="tooltip" data-placement="top" title="Calculation">Calculation</button>
              </div>
            </div>
            <!-- /.form-group -->
      		</div>
      		<!-- /.box-body -->

          <div class="box-body">
            <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width: 5%;">No</th>
                  <th style="width: 10%;">BPID</th>
                  <th>Nama BPID</th>
                  <th style="width: 15%;">QTY</th>
                  <th style="width: 20%;">Jumlah Harga</th>
                </tr>
              </thead>
            </table>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            {!! Form::submit('Update Harga Unit', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
          </div>

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
                          <th rowspan="2" style="width: 1%;">No.</th>
                          <th rowspan="2" style="width: 10%;">No. DN</th>
                          <th rowspan="2" style="width: 10%;">Tgl DN</th>
                          <th rowspan="2" style="width: 15%;">Part No</th>
                          <th rowspan="2">Part Name</th>
                          <th colspan="3" style="text-align:center;">QTY</th>
                          <th rowspan="2" style="width: 10%;">Harga Unit</th>
                          <th rowspan="2" style="width: 15%;">Jumlah</th>
                        </tr>
                        <tr>
                          <th style="width: 5%;">DN</th>
                          <th style="width: 5%;">ACT</th>
                          <th style="width: 5%;">Outstand</th>
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
      {!! Form::close() !!}
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("filter_bulan").focus();
  document.getElementById("btn-save").disabled = true;

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-save").click(function(event) {
    event.preventDefault();

    var tableMaster = $('#tblMaster').DataTable();
    var index = tableMaster.row('.selected').index();
    var regex = /(<([^>]+)>)/ig;
    document.getElementById("param_kd_supp").value = (tableMaster.cell(index, 1).data()).replace(regex, "");
    
    var tableDetail = $('#tblDetail').DataTable();
    tableDetail.search('').columns().search('').draw();

    oTable = $('#tblDetail').dataTable();
    var oSettings = oTable.fnSettings();
    oSettings._iDisplayLength = -1;
    oTable.fnDraw();

    // Serialize the entire form:
    var data = new FormData(this.form);

    var msg = "Anda yakin update data ini?";
    var txt = "";
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, update it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      $.ajax({
      type: "post",
      url: "{{ route('baaniginh008s.calculation') }}",
      // dataType: "json",
      data: data,
      processData: false,
      contentType: false,
      success: function(data){
        if(data.status === 'OK'){
          info = "Saved!";
          info2 = data.message;
          info3 = "success";
          swal(info, info2, info3);
          
          oTable = $('#tblDetail').dataTable();
          var oSettings = oTable.fnSettings();
          oSettings._iDisplayLength = 5;
          oTable.fnDraw();

          // document.getElementById("status").value = "D";
          
          tableMaster.ajax.reload( function ( json ) {
            document.getElementById("jml_row").value = tableMaster.rows().count();
            if(tableMaster.rows().count() > 0) {
              $('#tblMaster tbody tr:eq(' + index + ')').click(); 
            } else {
              initTable(window.btoa("1970"), window.btoa("01"), window.btoa("-"), window.btoa("-"));
            }

            var jml_row = document.getElementById("jml_row").value.trim();
            jml_row = Number(jml_row);
            if(jml_row > 0) {
              document.getElementById("btn-save").disabled = false;
            } else {
              document.getElementById("btn-save").disabled = true;
            }
          });
        } else {
          info = "ERROR";
          info2 = data.message;
          info3 = "error";
          swal(info, info2, info3);

          oTable = $('#tblDetail').dataTable();
          var oSettings = oTable.fnSettings();
          oSettings._iDisplayLength = 5;
          oTable.fnDraw();
        }
      }, error: function(data){
        info = "System Error!";
        info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
        info3 = "error";
        swal(info, info2, info3);

        oTable = $('#tblDetail').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = 5;
        oTable.fnDraw();
      }
    });
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
      oTable = $('#tblDetail').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = 5;
      oTable.fnDraw();
    })
  });

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
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('baaniginh008s.dashboardmonclaimcalculation') }}",
      columns: [
        {data: null, name: null, className: "dt-center"}, 
        {data: 'kd_bpid', name: 'kd_bpid', className: "dt-center"}, 
        {data: 'nm_bpid', name: 'nm_bpid'}, 
        {data: 'qty_outstand', name: 'qty_outstand', className: "dt-right"}, 
        {data: 'jumlah', name: 'jumlah', className: "dt-right"}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail';
        initTable(window.btoa("1970"), window.btoa("01"), window.btoa("-"), window.btoa("-"));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {

          var param_tahun = document.getElementById("param_tahun").value.trim();
          var param_bulan = document.getElementById("param_bulan").value.trim();
          var index = tableMaster.row('.selected').index();
          var kd_bpid = tableMaster.cell(index, 1).data();
          var nm_bpid = tableMaster.cell(index, 2).data();

          var info = "Tahun: " + param_tahun + ", Bulan: " + param_bulan + ", BPID: " + kd_bpid + " - " + nm_bpid;

          var status = document.getElementById("status").value.trim();
          if(status == "") {
            status = "-";
          }

          document.getElementById("info-detail").innerHTML = 'Detail (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(param_tahun.replace(regex, "")), window.btoa(param_bulan.replace(regex, "")), window.btoa(kd_bpid.replace(regex, "")), window.btoa(status));
        }
      }
    });

    var urlDetail = '{{ route('baaniginh008s.detailmonclaimcalculation', ['param', 'param2', 'param3', 'param4']) }}';
    urlDetail = urlDetail.replace('param4', window.btoa("-"));
    urlDetail = urlDetail.replace('param3', window.btoa("-"));
    urlDetail = urlDetail.replace('param2', window.btoa("01"))
    urlDetail = urlDetail.replace('param', window.btoa("1970"))
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
      // serverSide: true,
      ajax: urlDetail,
      columns: [
        {data: null, name: null, className: "dt-center"}, 
        {data: 'kd_pono', name: 'kd_pono', className: "dt-center"},
        {data: 'tgl_dn', name: 'tgl_dn', className: "dt-center"},
        {data: 'kd_item', name: 'kd_item'}, 
        {data: 'item_name', name: 'item_name'}, 
        {data: 'qty_dn', name: 'qty_dn', className: "dt-right"}, 
        {data: 'qty_act', name: 'qty_act', className: "dt-right"}, 
        {data: 'qty_outstand', name: 'qty_outstand', className: "dt-right"}, 
        {data: 'hrg_unit', name: 'hrg_unit', className: "dt-right"}, 
        {data: 'jumlah', name: 'jumlah', className: "dt-right"}
      ],
    });

    function initTable(tahun, bulan, kd_bpid, status) {
      var urlDetail = '{{ route('baaniginh008s.detailmonclaimcalculation', ['param', 'param2', 'param3', 'param4']) }}';
      urlDetail = urlDetail.replace('param4', status);
      urlDetail = urlDetail.replace('param3', kd_bpid);
      urlDetail = urlDetail.replace('param2', bulan)
      urlDetail = urlDetail.replace('param', tahun)
      tableDetail.ajax.url(urlDetail).load();
    }

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tahun = $('select[name="filter_tahun"]').val();
      data.bulan = $('select[name="filter_bulan"]').val();
      data.supplier = $('select[name="filter_supplier"]').val();
    });

    $('#display').click( function () {
      document.getElementById("param_tahun").value = $('select[name="filter_tahun"]').val();
      document.getElementById("param_bulan").value = $('select[name="filter_bulan"]').val();
      document.getElementById("status").value = "D";

      tableMaster.ajax.reload( function ( json ) {
        document.getElementById("jml_row").value = 0;
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa("1970"), window.btoa("01"), window.btoa("-"), window.btoa("-"));
        }

        var jml_row = document.getElementById("jml_row").value.trim();
        jml_row = Number(jml_row);
        if(jml_row > 0) {
          document.getElementById("btn-save").disabled = false;
        } else {
          document.getElementById("btn-save").disabled = true;
        }
      });
    });

    $('#calculation').click( function () {
      document.getElementById("param_tahun").value = $('select[name="filter_tahun"]').val();
      document.getElementById("param_bulan").value = $('select[name="filter_bulan"]').val();
      document.getElementById("status").value = "C";

      tableMaster.ajax.reload( function ( json ) {
        document.getElementById("jml_row").value = tableMaster.rows().count();
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa("1970"), window.btoa("01"), window.btoa("-"), window.btoa("-"));
        }

        var jml_row = document.getElementById("jml_row").value.trim();
        jml_row = Number(jml_row);
        if(jml_row > 0) {
          document.getElementById("btn-save").disabled = false;
        } else {
          document.getElementById("btn-save").disabled = true;
        }
      });
    });

    // $('#display').click();
  });

  function updateJumlah(e) {
    var id = e.target.id.replace('hrg_unit', '');

    var qty_outstand = document.getElementById(id +'qty_outstand').value.trim();
    qty_outstand = Number(qty_outstand);
    var hrg_unit = document.getElementById(id +'hrg_unit').value.trim();
    hrg_unit = Number(hrg_unit);
    
    var jumlah = qty_outstand * hrg_unit;
    document.getElementById(id +'jumlah').value = jumlah;
  }
</script>
@endsection