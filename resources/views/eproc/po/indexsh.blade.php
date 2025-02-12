@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Approval PO Section Head
        <small>Approval PO Section Head</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PO</li>
        <li class="active"><i class="fa fa-files-o"></i> Approval PO SH</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Approval PO Section Head</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblawal', 'Tgl Awal') !!}
  		      	{!! Form::date('filter_tgl_awal', \Carbon\Carbon::now()->subMonth("2")->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_tgl_awal']) !!}
    		    </div>
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblakhir', 'Tgl Akhir') !!}
  		      	{!! Form::date('filter_tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'filter_tgl_akhir']) !!}
    		    </div>
            <div class="col-sm-2">
              {!! Form::label('lblsite', 'Site') !!}
              <select name="filter_site" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                <option value="IGPJ">IGP - JAKARTA</option>
                <option value="IGPK">IGP - KARAWANG</option>
              </select>
            </div>
    		  </div>
    		  <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lbldep', 'Departemen') !!}
              <select name="filter_dep" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                @foreach($deps->get() as $dep)
                  <option value="{{$dep->kd_dep}}">{{$dep->nm_dep}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblstatus', 'Status Approval') !!}
              <select name="filter_status" aria-controls="filter_status" class="form-control select2">
                <option value="ALL">ALL</option>
                <option value="PIC" selected="selected">Approve PIC</option>
                <option value="SEC">Approve Section</option>
                <option value="RSEC">Reject Section</option>
                <option value="DEP">Approve Dep Head</option>
                <option value="RDEP">Reject Dep Head</option>
                <option value="DIV">Approve Div Head</option>
                <option value="RDIV">Reject Div Head</option>
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblusername2', 'Action') !!}
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
                <th style="width: 10%;">No. PO</th>
                <th style="width: 10%;">Tgl PO</th>
                <th style="width: 25%;">Supplier</th>
                <th style="width: 11%;">Mata Uang</th>
                <th>Ref A</th>
                <th style="width: 8%;">Print</th>
                <th style="width: 10%;">Action</th>
                <th>Revisi</th>
                <th>Pembuat PO</th>
                <th>Jenis PO</th>
                <th>Approve PIC</th>
                <th>Reject PIC</th>
                <th>Approve Section</th>
                <th>Reject Section</th>
                <th>Approve Dep Head</th>
                <th>Reject Dep Head</th>
                <th>Approve Div Head</th>
                <th>Reject Div Head</th>
                <th>Status Tampil</th>
                <th>PIC Print</th>
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
                        <th style="width: 1%;">No</th>
                        <th style="width: 5%;">PONO</th>
                        <th style="width: 10%;">No PP</th>
                        <th style="width: 15%;">Item No</th>
                        <th>Description</th>
                        <th style="width: 10%;">Qty PO</th>
                        <th style="width: 5%;">Satuan</th>
                        <th style="width: 12%;">Harga Unit</th>
                        <th style="width: 12%;">Jumlah</th>
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
                  <h3 class="box-title"><p id="info-detail2">History</p></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="tblHistory" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 1%;">No</th>
                        <th style="width: 10%;">No. PO</th>
                        <th style="width: 10%;">Tgl PO</th>
                        <th style="width: 12%;">Tgl Kirim</th>
                        <th>Supplier</th>
                        <th style="width: 5%;">MU</th>
                        <th style="width: 12%;">Harga Unit</th>
                        <th style="width: 10%;">QTY PO</th>
                        <th style="width: 10%;">QTY LPB</th>
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
@endsection

@section('scripts')
<script type="text/javascript">

  //Initialize Select2 Elements
  $(".select2").select2();

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
      "order": [[2, 'asc'],[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('baanpo1s.dashboardsh') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'no_po', name: 'no_po'},
        {data: 'tgl_po', name: 'tgl_po', className: "dt-center"},
        {data: 'nm_supp', name: 'nm_supp'},
        {data: 'kd_curr', name: 'kd_curr', className: "dt-center"},
        {data: 'refa', name: 'refa'},
        {data: 'status', name: 'status', className: "dt-center", orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false},
        {data: 'no_revisi', name: 'no_revisi', className: "none", orderable: false, searchable: false},
        {data: 'usercreate', name: 'usercreate', className: "none", orderable: false, searchable: false},
        {data: 'jns_po', name: 'jns_po', className: "none", orderable: false, searchable: false},
        {data: 'apr_pic_npk', name: 'apr_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_pic_npk', name: 'rjt_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_sh_npk', name: 'apr_sh_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_sh_npk', name: 'rjt_sh_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_dep_npk', name: 'apr_dep_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_dep_npk', name: 'rjt_dep_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_div_npk', name: 'apr_div_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_div_npk', name: 'rjt_div_npk', className: "none", orderable: false, searchable: false},
        {data: 'st_tampil', name: 'st_tampil', className: "none", orderable: false, searchable: false}, 
        {data: 'print_supp_pic', name: 'print_supp_pic', className: "none", orderable: false, searchable: false}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail PO';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var no_po = tableMaster.cell(index, 1).data();
          document.getElementById("info-detail").innerHTML = 'Detail PO (' + no_po + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(no_po.replace(regex, "")));
        }
      }
    });

    var url = '{{ route('baanpo1s.detail', ['param','param2']) }}';
    url = url.replace('param2', window.btoa("P"));
    url = url.replace('param', window.btoa("-"));
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
      "order": [[1, 'asc'],[2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'pono_po', name: 'pono_po', className: "dt-center"},
        { data: 'no_pp', name: 'no_pp'},
        { data: 'item_no', name: 'item_no'},
        { data: 'item_name', name: 'item_name'},
        { data: 'qty_po', name: 'qty_po', className: "dt-right"},
        { data: 'unit', name: 'unit', className: "dt-center"},
        { data: 'hrg_unit', name: 'hrg_unit', className: "dt-right"},
        { data: 'jumlah', name: 'jumlah', className: "dt-right"}
      ],
    });

    $('#tblDetail tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail2").innerHTML = 'History Harga';
        initTable2(window.btoa('-'), window.btoa('01/01/1970'));
      } else {
        tableDetail.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableDetail.rows().count() > 0) {
          var index_master = tableMaster.row('.selected').index();
          var tgl_po = tableMaster.cell(index_master, 2).data();
          var index = tableDetail.row('.selected').index();
          var item_no = tableDetail.cell(index, 3).data();
          var item_name = tableDetail.cell(index, 4).data();
          var info = item_no + " - " + item_name;
          document.getElementById("info-detail2").innerHTML = 'History Harga (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable2(window.btoa(item_no.replace(regex, "")), window.btoa(tgl_po));
        }
      }
    });

    var urlHistory = '{{ route('baanpo1s.history', ['param','param2']) }}';
    urlHistory = urlHistory.replace('param2', window.btoa("01/01/1970"));
    urlHistory = urlHistory.replace('param', window.btoa("-"));
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
      "order": [[2, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: urlHistory,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'no_po', name: 'no_po', className: "dt-center"},
        { data: 'tgl_po', name: 'tgl_po', className: "dt-center"},
        { data: 'ddat', name: 'ddat', className: "dt-center"},
        { data: 'supplier', name: 'supplier'},
        { data: 'kd_curr', name: 'kd_curr', className: "dt-center"},
        { data: 'hrg_unit', name: 'hrg_unit', className: "dt-right"}, 
        { data: 'qty_po', name: 'qty_po', className: "dt-right"}, 
        { data: 'qty_lpb', name: 'qty_lpb', className: "dt-right"}
      ],
    });

    function initTable(data) {
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('baanpo1s.detail', ['param','param2']) }}';
      url = url.replace('param2', window.btoa("P"));
      url = url.replace('param', data);

      document.getElementById("info-detail2").innerHTML = 'History Harga';
      tableDetail.ajax.url(url).load( function ( json ) {
        if(tableDetail.rows().count() > 0) {
          $('#tblDetail tbody tr:eq(0)').click(); 
        } else {
          initTable2(window.btoa('-'), window.btoa('01/01/1970'));
        }
      });
    }

    function initTable2(item_no, tgl_po) {
      tableHistory.search('').columns().search('').draw();
      var url = '{{ route('baanpo1s.history', ['param', 'param2']) }}';
      url = url.replace('param2', tgl_po);
      url = url.replace('param', item_no);
      tableHistory.ajax.url(url).load();
    }

    $(function() {
      $('\
        <div id="filter_cetak" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Print\
          <select size="1" name="filter_cetak" aria-controls="filter_status" \
            class="form-control select2" style="width: 100px;">\
              <option value="ALL" selected="selected">ALL</option>\
              <option value="T">SUDAH</option>\
              <option value="F">BELUM</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.awal = $('input[name="filter_tgl_awal"]').val();
        data.akhir = $('input[name="filter_tgl_akhir"]').val();
        data.kd_site = $('select[name="filter_site"]').val();
        data.kd_dep = $('select[name="filter_dep"]').val();
        data.status = $('select[name="filter_status"]').val();
        data.cetak = $('select[name="filter_cetak"]').val();
      });

      $('select[name="filter_cetak"]').change(function() {
        document.getElementById("info-detail").innerHTML = 'Detail PO';
        tableMaster.ajax.reload( function ( json ) {
          if(tableMaster.rows().count() > 0) {
            $('#tblMaster tbody tr:eq(0)').click(); 
          } else {
            initTable(window.btoa('-'));
          }
        });
      });
    });

    $('#display').click( function () {
      document.getElementById("info-detail").innerHTML = 'Detail PO';
      document.getElementById("info-detail2").innerHTML = 'History Harga';
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('-'));
        }
      });
    });

    $('#display').click();
  });
</script>
@endsection