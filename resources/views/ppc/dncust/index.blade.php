@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      OutStd. DN Customer
      <small>OutStd. DN Customer</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-truck"></i> PPC - Laporan</li>
      <li class="active"><i class="fa fa-files-o"></i> OutStd. DN Customer</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    {!! Form::hidden('tgl_awal_h', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_awal_h']) !!}
    {!! Form::hidden('tgl_akhir_h', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_akhir_h']) !!}
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">OutStd. DN Customer</h3>
      </div>
      <!-- /.box-header -->

      <div class="box-body form-horizontal">
        <div class="form-group">
          <div class="col-sm-4">
            {!! Form::label('lblcustomer', 'Customer') !!}
            <select id="filter_customer" name="filter_customer" aria-controls="filter_status" class="form-control select2" onchange="changeCustomer()">
              @if (strlen(Auth::user()->username) <= 5)
              <option value="ALL" selected="selected">ALL</option>
              @endif
              @foreach ($customers->get() as $customer)
              <option value={{ $customer->ship_to }}>{{ $customer->nama.' - '.$customer->ship_to }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
           {!! Form::label('tujuan', 'Tujuan (F9)') !!}  
           <div class="input-group">
            {!! Form::text('tujuan', null, ['class'=>'form-control','placeholder' => 'Tujuan','onkeydown' => 'btnpopupTujuanClick(event)', 'onchange' => 'validateTujuan()']) !!} 
            <span class="input-group-btn">
              <button id="btnpopupTujuan" type="button" class="btn btn-info" data-toggle="modal" data-target="#tujuanModal">
                <label class="glyphicon glyphicon-search"></label>
              </button>
            </span>
          </div>   
          {!! $errors->first('tujuan', '<p class="help-block">:message</p>') !!}             
        </div>
        <div class="col-md-4">
          {!! Form::label('namaTujuan', 'Nama Tujuan') !!}      
          {!! Form::text('namaTujuan', null, ['class'=>'form-control','placeholder' => 'Nama Tujuan', 'disabled'=>'']) !!} 
        </div>  
      </div>
      <!-- /.form-group -->
      <div class="form-group">
        <div class="col-sm-2">
          {!! Form::label('tgl_awal', 'Dari Tanggal :') !!}
          {!! Form::date('tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Order Awal', 'id' => 'tgl_awal']) !!}
        </div>
        <div class="col-sm-2">
          {!! Form::label('tgl_akhir', 'Ke :') !!}
          {!! Form::date('tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Order Akhir', 'id' => 'tgl_akhir']) !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="form-group">
        <div class="col-sm-2">
          {!! Form::label('lbldisplay', ' ') !!}
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
            {{-- <th rowspan="2" style="width: 25%;">Customer</th> --}}
            {{-- <th rowspan="2" style="width: 10%;">Docking</th> --}}
            <th rowspan="2" style="width: 15%;">PN Baan</th>
            <th rowspan="2" style="width: 10%;">PN Cust</th>
            <th rowspan="2">Deskripsi</th>
            <th rowspan="2" style="width: 10%;">Docking</th>
            <th rowspan="2" style="width: 10%;">Cycle</th>
            <th rowspan="2" style="width: 10%;">Jam Kirim</th>
            <th rowspan="2" style="width: 10%;">Tgl Kirim</th>
            <th colspan="3" style="text-align:center;">QTY</th>
            <th rowspan="2">No DN</th>
          </tr>
          <tr>
            <th style="width: 5%;">DN</th>
            <th style="width: 5%;">Kirim</th>
            <th style="width: 5%;">Sisa</th>
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

@endsection
<!-- Popup Tujuan Modal -->
@include('ppc.dsfin.popup.tujuanModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("filter_customer").focus();

  function btnpopupTujuanClick(e) {
    if(e.keyCode == 120) {
      $('#btnpopupTujuan').click();
    }
  }
  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
    $("#btnpopupTujuan").click(function(){
      var cust = document.getElementById("filter_customer").value.trim();     
      if(cust !== '') {
        popupTujuan(cust);
      }
    });

    var groupColumn = 0;
    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        //"targets": 0,
        "targets": groupColumn,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      //"order": [[1, 'asc'],[2, 'asc']],
      "order": [[ groupColumn, 'asc' ]],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('baandncusts.dashboard') }}",
      columns: [
        //{data: null, name: null, className: "dt-center"},
        {data: 'kd_ship_to', name: 'kd_ship_to'},
        {data: 'item_no', name: 'item_no'},
        {data: 'nm_marking', name: 'nm_marking'},
        {data: 'partname', name: 'partname'},
        {data: 'kd_dock', name: 'kd_dock'},
        {data: 'no_cycle', name: 'no_cycle'},
        {data: 'jam', name: 'jam'}, 
        {data: 'tgl_kirim', name: 'tgl_kirim', className: "dt-center"},
        {data: 'qty_dn', name: 'qty_dn', className: "dt-right"},
        {data: 'qty_ds', name: 'qty_ds', className: "dt-right"},
        {data: 'sisa', name: 'sisa', className: "dt-right"},
        {data: 'no_dn', name: 'no_dn', className: "none", orderable: false, searchable: false}, 
        ],
        "drawCallback": function ( settings ) {
          var api = this.api();
          var rows = api.rows( {page:'current'} ).nodes();
          var last=null;

          api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
            if ( last !== group ) {
              $(rows).eq( i ).before(
                '<tr class="group"><td colspan="11">'+group+'</td></tr>'
                );

              last = group;
            }
          } );
        }
      });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
      data.customer = $('select[name="filter_customer"]').val();
      data.tujuan = $('input[name="tujuan"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    $('#tblMaster tbody').on( 'click', 'tr.group', function () {
      var currentOrder = table.order()[0];
      if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
        table.order( [ groupColumn, 'desc' ] ).draw();
      }
      else {
        table.order( [ groupColumn, 'asc' ] ).draw();
      }
    } );

    // $('#display').click();
  });

    //POPUP TUJUAN
    function popupTujuan(cust) {
      var myHeading = "<p>Popup Tujuan</p>";
      $("#tujuanModalLabel").html(myHeading);

      var url = '{{ route('datatables.popupTujuan', ['param']) }}';
      url = url.replace('param', window.btoa(cust));

      var lookupTujuan = $('#lookupTujuan').DataTable({
        processing: true, 
        "oLanguage": {
          'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        }, 
        serverSide: true,
        "pagingType": "numbers",
        ajax: url,
        "aLengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
        responsive: true,
        columns: [
        { data: 'tujuan', name: 'tujuan'},
        { data: 'nama', name: 'nama'}
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
          $('div.dataTables_filter input').focus();
          $('#lookupTujuan tbody').on( 'dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupTujuan.rows(rows).data();
            $.each($(rowData),function(key,value){
              document.getElementById("tujuan").value = value["tujuan"];
              document.getElementById("namaTujuan").value = value["nama"];
              $('#tujuanModal').modal('hide');
              validateTujuan();
            });
          });
          $('#tujuanModal').on('hidden.bs.modal', function () {
            var kode = document.getElementById("tujuan").value.trim();
            if(kode === '') {
              $('#tujuan').focus();
            } else {
              $('#tujuan').focus();
            }
          });        
        },
      });
    }
    
    function changeCustomer() {
      document.getElementById("tujuan").value = "";
      document.getElementById("namaTujuan").value = "";
    }
  </script>
  @endsection