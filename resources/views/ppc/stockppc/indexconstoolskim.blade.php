@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Inventory Level
			<small>{{ $label }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><i class="fa fa-truck"></i> PPC KIM - Inventory Level</li>
			<li class="active"><i class="fa fa-files-o"></i> {{ $label }}</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		@include('layouts._flash')
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">{{ $label }}</h3> 
			</div>
			<!-- /.box-header -->

			<div class="box-body form-horizontal">
				<div class="form-group">
					<div class="col-sm-4">
						{!! Form::label('lblwhs', 'Warehouse') !!}
            <div class="input-group">
              <select id="filter_whs" name="filter_whs" aria-controls="filter_status" class="form-control select2">
               @foreach($filter_whs->get() as $baan_whs)
               <option value="{{ $baan_whs->kd_cwar }}">{{ $baan_whs->kd_cwar }} - {{ $baan_whs->nm_dsca }}</option>
               @endforeach
             </select>
           </div>
         </div>

         <div class="col-sm-4">
          {!! Form::label('lap_whs', 'Lap WHS') !!}
          <div class="input-group">
            @if($label == 'Consumable')
            {!! Form::select('lap_whs', ['ALL' => 'ALL', '11' => 'CONSUMABLE', '12' => 'FLAMMABLE'], null, ['class'=>'form-control select2', 'id' => 'lap_whs', 'required']) !!} 
            @else
            {!! Form::select('lap_whs', ['ALL' => 'ALL', '1T' => 'TOOLS', '1J' => 'JIG', '17' => 'SPAREPART'], null, ['class'=>'form-control select2', 'lap_whs' => 'pt', 'required']) !!} 
            @endif
          </div>          
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-4">
          {!! Form::label('kategori', 'Kategori') !!}
          <div class="input-group">
            {!! Form::select('kategori', ['PLANT' => 'Plant', 'OFFICE' => 'Office', 'OTHERS' => 'Others'], null, ['class'=>'form-control select2', 'id' => 'kategori', 'required']) !!}
          </div>          
        </div>
        <div class="col-sm-4">
          {!! Form::label('kategori2', 'Kategori 2') !!}
          <div class="input-group">
            {!! Form::select('kategori2', ['REGULER' => 'Reguler', 'PKB' => 'PKB'], null, ['class'=>'form-control select2', 'id' => 'kategori2', 'required']) !!}
          </div>          
        </div>
      </div>
      <!-- /.form-group -->
      <div class="form-group">
        <div class="col-sm-4">
          {!! Form::label('konsinyasi', 'Status Konsinyasi') !!}
          <div class="input-group">
           {!! Form::select('konsinyasi', ['N' => 'Reguler', 'Y' => 'Konsinyasi'], null, ['class'=>'form-control select2', 'id' => 'konsinyasi', 'required']) !!}               
         </div>
       </div>
       <div class="col-sm-4">
        {!! Form::label('lblstatus', 'Status') !!}
        <select id="filter_stok" multiple="multiple" name="filter_stok" aria-controls="filter_status" class="form-control select2">
         <option value="OVER" >OVER</option>
         <option value="NORMAL" >NORMAL</option>
         <option value="WARNING" >WARNING</option>
         <option value="CRITICAL" selected="selected">CRITICAL</option>
       </select>
     </div>
   </div>
   <!-- /.form-group -->
   <div class="form-group">
     <div class="col-sm-2">
      <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>      
    </div>
    <div class="col-sm-2">
      <button id="btnprint" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print Report"><span class="glyphicon glyphicon-print"></span> Print Report</button>  
    </div>  
  </div>
  <div class="form-group">
    <div class="col-sm-2">
      <img src="../../images/blue.png" alt="X" data-toggle="tooltip" data-placement="top" title="OVER">OVER
    </div>
    <div class="col-sm-2">
      <img src="../../images/green.png" alt="X" data-toggle="tooltip" data-placement="top" title="NORMAL">NORMAL
    </div>
    <div class="col-sm-2">
      <img src="../../images/yellow.png" alt="X" data-toggle="tooltip" data-placement="top" title="WARNING">WARNING
    </div>
    <div class="col-sm-2">
      <img src="../../images/red.png" alt="X" data-toggle="tooltip" data-placement="top" title="CRITICAL">CRITICAL
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
     <th style="width: 15%;">Description</th>
     <th style="width: 5%;">Stock Day</th>
     <th style="width: 10%;">Stock</th>
     <th style="width: 8%;">Min</th>
     <th style="width: 5%;">Max</th>
     <th style="width: 10%;">Supplier</th>
     <th style="width: 10%;">Partno</th>              
     <th style="width: 7%;">WHS</th>
     <th style="width: 5%;">Rata2 Usage Bulan</th>
     <th style="width: 5%;">Prod/Day</th>
     <th style="width: 5%;">Status</th>
     <th style="width: 7%;">Location</th>
     <th style="width: 5%;">Ket. CM</th>
     <th style="width: 5%;">Last Sync</th>
     <th style="width: 5%;">Action</th>
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
      <h3 class="box-title">
       <p>
        <label id="info-detail">History</label>
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
    <th style="width: 1%;">No</th>
    <th>Ket. CM</th>
    <th style="width: 15%;">Tanggal</th>
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

<!-- Popup Outstanding Modal -->
@include('ppc.stockppc.popup.outstandingppModal')
<!-- Popup Outstanding Modal -->
@include('ppc.stockppc.popup.outstandingpoModal')

@section('scripts')
<script type="text/javascript">

	document.getElementById("filter_whs").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function updatecm(whse, item, cm)
  {
  	swal({
  		title: 'Input Keterangan CM \n(Warehouse: ' + whse + ', Part No : ' + item + ')',
  		html: 
  		'<textarea id="swal-input" class="form-control" maxlength="100" rows="3" cols="20" placeholder="(Max. 100 Karakter)" style="resize:vertical">' + cm + '</textarea>',
  		showCancelButton: true,
  		preConfirm: function () {
  			return new Promise(function (resolve, reject) {
  				if ($('#swal-input').val()) {
  					if($('#swal-input').val().length > 100) {
  						reject('Keterangan Max 100 Karakter!')
  					} else {
  						resolve([
  							$('#swal-input').val()
  							])
  					}
  				} else {
  					reject('Keterangan tidak boleh kosong!')
  				}
  			})
  		}
  	}).then(function (result) {
  		if(result[0] == null || result[0] == "") {
  			result[0] = "-";
  		}
  		var token = document.getElementsByName('_token')[0].value.trim();
      // save via ajax
      // create data detail dengan ajax
      var url = "{{ route('stockohigps.updatecm')}}";
      $("#loading").show();
      $.ajax({
      	type     : 'POST',
      	url      : url,
      	dataType : 'json',
      	data     : {
      		_method   : 'POST',
          // menambah csrf token dari Laravel
          _token     : token,
          whse       : window.btoa(whse),
          item       : window.btoa(item),
          keterangan : result[0],
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Updated", data.message, "success");
            var table = $('#tblMaster').DataTable();
            table.ajax.reload(null, false);
          } else {
            swal("Cancelled", data.message, "error");
          }
        }, error:function(){ 
          $("#loading").hide();
          swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
        }
      });
    }).catch(swal.noop)
  }

  $(document).ready(function(){

    $('#btnprint').click( function () {
      printPdf();      
    });  

    $('#btn-view-pp').click( function () {
      popupPp(this);
    });

    $('#btn-view-po').click( function () {
      popupPo(this);
    });

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
    "order": [[3, 'asc'],[2, 'asc'], [1, 'asc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: "{{ route('stockohigps.dashboardinventorylevelctkim') }}",
    columns: [
    {data: null, name: null},
    {data: 'nm_item', name: 'nm_item'}, 
    {data: 'stock_day', name: 'stock_day', className: "dt-right"}, 		
    {data: 'qty', name: 'qty', className: "dt-right"},
    {data: 'qty_min', name: 'qty_min', className: "dt-right"},
    {data: 'qty_max', name: 'qty_max', className: "dt-right"},
    {data: 'bpid', name: 'bpid'},
    {data: 'item', name: 'item'},
    {data: 'whse', name: 'whse'},
    {data: 'rata', name: 'rata', className: "dt-right"},
    {data: 'day', name: 'day', className: "dt-right"},
    {data: 'st_stock', name: 'st_stock', className: "dt-center"},          
    {data: 'lokasi', name: 'lokasi'},
    {data: 'cm', name: 'cm', className: "none"},
    {data: 'dtcrea', name: 'dtcrea', className: "none"},
    {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
    ],
  });

  	//show history
    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'History';
        initTable(window.btoa('-'), window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var part_no = tableMaster.cell(index, 2).data();
          var part_name = tableMaster.cell(index, 3).data();
          var whse = tableMaster.cell(index, 4).data();
          var info = "Warehouse: " + whse + ", Part: " + part_no + " - " + part_name;
          document.getElementById("info-detail").innerHTML = 'History (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(whse.replace(regex, "")), window.btoa(part_no.replace(regex, "")));
        }
      }
    });

    var urlDetail = '{{ route('stockohigps.history', ['param', 'param2']) }}';
    urlDetail = urlDetail.replace('param2', "-");
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
    "iDisplayLength": 10,
    responsive: true,
    "order": [[2, 'desc']],
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    ajax: urlDetail,
    columns: [
    {data: null, name: null, className: "dt-center"},
    {data: 'ket_cm', name: 'ket_cm'},
    {data: 'dtcrea', name: 'dtcrea', className: "dt-center"}
    ],
  });

    function initTable(whse, item) {
      var urlDetail = '{{ route('stockohigps.history', ['param', 'param2']) }}';
      urlDetail = urlDetail.replace('param2', item);
      urlDetail = urlDetail.replace('param', whse);
      tableDetail.ajax.url(urlDetail).load();
    }

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.whs = $('select[name="filter_whs"]').val();
      data.stok = $('select[name="filter_stok"]').val();
      data.lap_whs = $('select[name="lap_whs"]').val();
      data.konsinyasi = $('select[name="konsinyasi"]').val();
      data.kategori = $('select[name="kategori"]').val();
      data.kategori2 = $('select[name="kategori2"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload( function ( json ) {
       if(tableMaster.rows().count() > 0) {
        $('#tblMaster tbody tr:eq(0)').click(); 
      } else {
        initTable(window.btoa('-'), window.btoa('-'));
      }
    });
    });
  });

  //CETAK DOKUMEN
  function printPdf(){
    var param = document.getElementById("filter_whs").value.trim();
    var param1 = document.getElementById("kategori").value.trim();
    var param2 = document.getElementById("kategori2").value.trim();
    var param3 = document.getElementById("lap_whs").value.trim();
    var param4 = document.getElementById("konsinyasi").value.trim();
    //var stok = $('#filter_stok').val(); 
    var param5 = $('#filter_stok').val();
    
    var url = '{{ route('stockohigps.print', ['param', 'param1', 'param2', 'param3', 'param4', 'param5']) }}';
    url = url.replace('param', window.btoa(param));
    url = url.replace('param1', window.btoa(param1));
    url = url.replace('param2', window.btoa(param2));
    url = url.replace('param3', window.btoa(param3));
    url = url.replace('param4', window.btoa(param4));
    url = url.replace('param5', window.btoa(param5));
    window.open(url);
  }

  //POPUP PP
  function popupPp(item) {
    var myHeading = "<p>Outstanding Pp</p>";
    $("#outppModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupPp', ['param', 'param2']) }}';
    url = url.replace('param2', window.btoa("IGPK"));
    url = url.replace('param', window.btoa(item));

    var lookupOutpp = $('#lookupOutpp').DataTable({
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
     { data: 'no_pp', name: 'no_pp'},
     { data: 'tgl_pp', name: 'tgl_pp'},
     { data: 'qty_pp', name: 'qty_pp'},
     { data: 'qty_po', name: 'qty_po'}
     ],
     "bDestroy": true,
     "initComplete": function(settings, json) {
      $('div.dataTables_filter input').focus();

    },
  });     
  }

  //POPUP PO
  function popupPo(item) {
    var myHeading = "<p>Outstanding Po</p>";
    $("#outpoModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupPo', ['param', 'param2']) }}';
    url = url.replace('param2', window.btoa("IGPK"));
    url = url.replace('param', window.btoa(item));

    var lookupOutpo = $('#lookupOutpo').DataTable({
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
     { data: 'no_po', name: 'no_po'},
     { data: 'tgl_po', name: 'tgl_po'},
     { data: 'qty_po', name: 'qty_po'},
     { data: 'qty_lpb', name: 'qty_lpb'},
     { data: 'nmsupp', name: 'nmsupp'}
     ],
     "bDestroy": true,
     "initComplete": function(settings, json) {
      $('div.dataTables_filter input').focus();

    },
  });     
  }
</script>
@endsection