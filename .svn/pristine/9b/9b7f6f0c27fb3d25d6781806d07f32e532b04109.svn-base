@extends('monitoring.ops.layouts.app2')

@section('content')
	<BR>
	<div class="container2">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">

					<div class="panel-heading">
						<center><a href="{{ url('/pppolpb2') }}"><h4>Monitoring PP - PO - LPB KONSINYASI {{ $periode->format('F Y') }}</h4></a></center>
					</div>

					<div class="panel-body">
						<table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
	    			    	<thead>
		  			            <th style='width: 1%;text-align: center'>No</th>
				                {{-- <th style='text-align: center'>Item</th>
				                <th style='width: 20%;text-align: center'>Supplier</th> --}}
				                <th style='text-align: center'>Supplier</th>
				                <th style='width: 15%;text-align: center'>PRC</th>
				                <th style='width: 15%;text-align: center'>User</th>
				                <th style='width: 7%;text-align: center'>PP 20-22</th>
				                <th style='width: 7%;text-align: center'>PO 22-23</th>
				                <th style='width: 7%;text-align: center'>LPB 24-27</th>
	    			        </thead>
	    			    </table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		var periode = "{{ $periode->format('Ym') }}";
	    var url = '{{ route('dashboard.pppolpb2', 'param') }}';
	    url = url.replace('param', window.btoa(periode));
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
	      "displayStart": {{ $displayStart }},
	      responsive: true,
	      "order": [],
	      processing: true, 
	      "oLanguage": {
	      	'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
	      }, 
	      serverSide: true,
	      ajax: url,
	      columns: [
	      	{data: null, name: null, className: "dt-center"},
	        // {data: 'nm_item', name: 'nm_item'},
	        {data: 'nm_supp', name: 'nm_supp'},
	        {data: 'nm_pic', name: 'nm_pic'},
	        {data: 'nm_user', name: 'nm_user'},
	        {data: 'pp', name: 'pp', className: "dt-center", orderable: false, searchable: false},
	        {data: 'po', name: 'po', className: "dt-center", orderable: false, searchable: false},
	        {data: 'lpb', name: 'lpb', className: "dt-center", orderable: false, searchable: false}
		  ]
	    });
	});

	$(function() {
      $('\
        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:0px;">\
          <img src="{{ asset('images/red.png') }}" alt="X"> Melewati Batas Tanggal \
          <img src="{{ asset('images/green.png') }}" alt="X"> Sesuai Tanggal \
          <img src="{{ asset('images/greenred.png') }}" alt="X"> Melewati Batas Tanggal Sudah Ada Dokumen \
        </div>\
      ').insertAfter('.dataTables_length');
    });

	//auto refresh
	setTimeout(function() {
	  // location.reload();
	  var displayStart = "{{ $displayStart }}";
	  displayStart = Number(displayStart) + 10;
	  var urlRedirect = "{{ url('/pppolpb2/param') }}";
	  urlRedirect = urlRedirect.replace('param', displayStart);
	  window.location.href = urlRedirect;
	}, 180000); //1000 = 1 second
</script>
@endsection