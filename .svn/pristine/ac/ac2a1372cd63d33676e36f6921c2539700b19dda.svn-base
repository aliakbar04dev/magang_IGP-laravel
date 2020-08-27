@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lalu Lintas - Kasir ke Accounting
        {{-- <small>Lalu Lintas - Kasir ke Accounting</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> FACO - Lalu Lintas</li>
        <li class="active"><i class="fa fa-files-o"></i> Kasir ke Accounting</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <p> 
                @permission(['faco-lalin-ksr-acc'])
                <a class="btn btn-primary" href="{{ route('lalins.createksracc') }}">
                  <span class="fa fa-plus"></span> Serah dari Kasir ke Accounting
                </a>
                @endpermission
              </p>
            </div>
            <!-- /.box-header -->

            <div class="box-body form-horizontal">
              <div class="form-group">
                <div class="col-sm-3">
                  {!! Form::label('tgl_awal', 'Tgl Awal') !!}
                  {!! Form::date('tgl_awal', \Carbon\Carbon::now()->startOfWeek(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl_awal']) !!}
                </div>
                <div class="col-sm-3">
                  {!! Form::label('tgl_akhir', 'Tgl Akhir') !!}
                  {!! Form::date('tgl_akhir', \Carbon\Carbon::now()->endOfWeek()->subDay(2), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'tgl_akhir']) !!}
                </div>
                <div class="col-sm-3">
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
		                <th style="width: 15%;">No. Serah Terima</th>
		                <th style="width: 10%;">Tanggal</th>
                    <th>Keterangan</th>
                    <th>Creaby</th>
		                <th>Modiby</th>
		                <th style="width: 10%;">Action</th>
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
                      <h3 class="box-title"><p id="info-detail">Detail TT / PP</p></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th style="width: 1%;">No</th>
                            <th style="width: 12%;">No. TT / PP</th>
                            <th>Supplier</th>
                            <th style="width: 10%;">Tgl JTempo</th>
                            <th style="width: 5%;">MU</th>
                            <th style="width: 10%;">Nilai DPP</th>
                            <th style="width: 10%;">PPn (IDR)</th>
                            <th style="width: 5%;">Batch</th>
                            <th>PIC Serah</th>
                            <th>PIC Tarik</th>
                            <th style="width: 12%;">ACC ke FIN</th>
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
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){

    var url = '{{ route('lalins.dashboardksracc') }}';
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
      "order": [[2, 'desc'], [1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      	{data: null, name: null},
        {data: 'no_lka', name: 'no_lka', className: "dt-center"},
        {data: 'tgl_lka', name: 'tgl_lka', className: "dt-center"},
        {data: 'ket_lka', name: 'ket_lka'},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
	    ]
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail TT / PP';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var no_serah = tableMaster.cell(index, 1).data();
          document.getElementById("info-detail").innerHTML = 'Detail TT / PP (' + no_serah + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(no_serah.replace(regex, "")));
        }
      }
    });

    var url = '{{ route('lalins.detailksracc', 'param') }}';
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
      "iDisplayLength": 10,
      responsive: true,
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'no_voucher', name: 'no_voucher'},
        {data: 'nm_bpid', name: 'nm_bpid'},
        {data: 'tgl_jtempo', name: 'tgl_jtempo', className: "dt-center"},
        {data: 'ccur', name: 'ccur', className: "dt-center"},
        {data: 'amnt', name: 'amnt', className: "dt-right"},
        {data: 'vath1', name: 'vath1', className: "dt-right"},
        {data: 'no_batch', name: 'no_batch', className: "dt-right"},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'pic_terima', name: 'pic_terima', className: "none"},
        {data: 'no_laf', name: 'no_laf', className: "dt-center"}
      ]
    });

    function initTable(data) {
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('lalins.detailksracc', 'param') }}';
      url = url.replace('param', data);
      tableDetail.ajax.url(url).load();
    }

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
    });

    $('#display').click( function () {
      document.getElementById("info-detail").innerHTML = 'Detail TT / PP';
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('-'));
        }
      });
    });
  });
</script>
@endsection