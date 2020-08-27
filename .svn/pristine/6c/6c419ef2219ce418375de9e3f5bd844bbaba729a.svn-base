@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Uniq Code Material Usage
        <small>Uniq Code Material Usage</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-truck"></i> PPC - Data Input - Prod Plan Mach</li>
        <li class="active"><i class="fa fa-files-o"></i> Material Usage</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Uniq Code Material Usage</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-3">
              {!! Form::label('tgl_awal', 'Tgl Produksi Awal') !!}
              {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Produksi Awal', 'id' => 'tgl_awal']) !!}
            </div>
            <div class="col-sm-3">
              {!! Form::label('tgl_akhir', 'Tgl Produksi Akhir') !!}
              {!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Produksi Akhir', 'id' => 'tgl_akhir']) !!}
            </div>
          </div>
          <!-- /.form-group -->
    		  <div class="form-group">
    		    <div class="col-sm-3">
              {!! Form::label('lblwhsfrom', 'Warehouse From') !!}
              <select id="filter_whs_from" name="filter_whs_from" aria-controls="filter_whs_from" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                @foreach($baan_whs_from->get() as $whs)
                  <option value="{{ $whs->kd_cwar }}">{{ $whs->kd_cwar }} - {{ $whs->nm_dsca }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3">
              {!! Form::label('lblwhsto', 'Warehouse To') !!}
              <select id="filter_whs_to" name="filter_whs_to" aria-controls="filter_whs_to" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                @foreach($baan_whs_to->get() as $whs)
                  <option value="{{ $whs->kd_cwar }}">{{ $whs->kd_cwar }} - {{ $whs->nm_dsca }}</option>
                @endforeach
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
                <th style="width: 10%;">Uniq Code</th>
                <th style="width: 10%;">Tgl Prod</th>
                <th style="width: 10%;">WHS From</th>
                <th style="width: 8%;">WHS To</th>
                <th>Line</th>
                <th style="width: 5%;">Cycle</th>
                <th style="width: 10%;">QTY Cycle</th>
                <th>Part No Parent</th>
                <th>Nama Part No Parent</th>
                <th>Qty Supply</th>
                <th>Lot Size</th>
                <th style="width: 5%;">Status</th>
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

@section('scripts')
<script type="text/javascript">

  document.getElementById("tgl_awal").focus();

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
      "iDisplayLength": 5,
      responsive: true,
      "order": [[2, 'asc'],[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('uniqcodematuses.dashboard') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'kd_mu', name: 'kd_mu', className: "dt-center"},
        {data: 'tgl_prod', name: 'tgl_prod', className: "dt-center"},
        {data: 'whs_from', name: 'whs_from', className: "dt-center"},
        {data: 'whs_to', name: 'whs_to', className: "dt-center"},
        {data: 'line_user', name: 'line_user'},
        {data: 'no_cycle', name: 'no_cycle', className: "dt-center"},
        {data: 'qty_cycle', name: 'qty_cycle', className: "dt-right"},
        {data: 'part_no_parent', name: 'part_no_parent', className: "none", orderable: false, searchable: false},
        {data: 'nm_part_no_parent', name: 'nm_part_no_parent', className: "none", orderable: false, searchable: false},
        {data: 'qty_supply', name: 'qty_supply', className: "none", orderable: false, searchable: false},
        {data: 'lot_size', name: 'lot_size', className: "none", orderable: false, searchable: false},
        {data: 'status', name: 'status', className: "dt-center"}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
      data.whs_from = $('select[name="filter_whs_from"]').val();
      data.whs_to = $('select[name="filter_whs_to"]').val();      
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    // $('#display').click();
  });
</script>
@endsection