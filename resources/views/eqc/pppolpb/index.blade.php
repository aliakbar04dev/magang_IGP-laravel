@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
     <h1>
      Laporan
      <small>Laporan PP PO LPB</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-truck"></i> QC - Laporan</li>
      <li class="active"><i class="fa fa-files-o"></i> Laporan PP PO LPB</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
        @include('layouts._flash')
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Laporan PP PO LPB</h3>
          </div>
          <!-- /.box-header -->
          
           <div class="box-body form-horizontal">
            
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-md-2">
              {!! Form::label('tgl_awal', 'Dari Tanggal :') !!}
              {!! Form::date('tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Order Awal', 'id' => 'tgl_awal']) !!}
            </div>
            <div class="col-md-2">
              {!! Form::label('tgl_akhir', 'Ke :') !!}
              {!! Form::date('tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Order Akhir', 'id' => 'tgl_akhir']) !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-md-2">
              {!! Form::label('lbldisplay', ' ') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
            <div class="col-md-2">
              {!! Form::label('lbldisplays', ' ') !!}
                <button id="btn-print" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print Report PP PO LPB">Print PDF</button>
            </div>
          </div>
          <!-- /.form-group -->
        </div>
      <!-- /.box-body -->

      <div class="box-body">
        <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" style="width:100%">
          <thead >
            <tr>
                <th style="width: 1%;">NO</th>
                <th style="width: 3%;">NO PP</th> 
                <th style="width: 3%;">TGL PP</th> 
                <th style="width: 3%;">REF A</th>
                <th style="width: 3%;">ITEM NO</th>
                <th style="width: 20%;">NAMA ITEM</th>
                <th style="width: 3%;">QTY PP</th>
                <th style="width: 3%;">UNIT</th>
                <th style="width: 10%%">NO PO</th>
                <th style="width: 10%%">NO LPB</th>
                <th style="width: 3%;">BPID</th>
                <th style="width: 3%;">QTY PO</th>
                <th style="width: 3%;">HARGA UNIT</th>
                <th style="width: 3%;">TGL LPB</th>
                <th style="width: 3%;">NO SJ</th>
                <th style="width: 3%;">QTY LPB</th>
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
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    
    var url = '{{ route('pppolpb.dashboard') }}';
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
      "order": [[2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'no_pp', name: 'no_pp'},
        {data: 'tgl_pp', name: 'tgl_pp'},
        {data: 'refa', name: 'refa'},
        {data: 'item_no', name: 'item_no'},
        {data: 'nmitem', name: 'nmitem'},
        {data: 'qty_pp', name: 'qty_pp', searchable: false, orderable: false}, 
        {data: 'unit', name: 'unit'}, 
        {data: 'no_po', name: 'no_po'}, 
        {data: 'no_lpb', name: 'no_lpb'}, 
        {data: 'bpid', name: 'bpid'},  
        {data: 'qty_po', name: 'qty_po', searchable: false, orderable: false}, 
        {data: 'hrg_unit', name: 'hrg_unit'}, 
        {data: 'tgl_lpb', name: 'tgl_lpb'}, 
        {data: 'no_sj', name: 'no_sj'},  
        {data: 'qty_lpb', name: 'qty_lpb'}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
    });
    //firstLoad
    tableMaster.ajax.reload();

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    $('#btn-print').click( function () {
      printPdf();
    });
  });

  //CETAK DOKUMEN
  function printPdf(){
    var param = document.getElementById("tgl_awal").value;
    var param1 = document.getElementById("tgl_akhir").value;

    var urlRedirect = '{{ route('pppolpb.print', ['param', 'param1']) }}';
    urlRedirect = urlRedirect.replace('param', window.btoa(param));
    urlRedirect = urlRedirect.replace('param1', window.btoa(param1));
    window.open(urlRedirect, '_blank');
  }
  
</script>

@endsection