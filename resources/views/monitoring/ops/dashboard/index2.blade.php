@extends('monitoring.ops.layouts.app')

@section('content')
	<BR>
	<div class="container2">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">

					<div class="panel-heading">
						<center><h4>Monitoring OPS</h4></center>
					</div>

					<div class="panel-body">
						<table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
	    			    	<thead>
		  			            <tr>
		  			            	<th style="width: 1%;">No</th>
					                <th style="width: 15%;">No. OH</th>
					                <th style="width: 5%;">PRC to Bdg</th>
					                <th style="width: 5%;">App Bdg Dept Head</th>
					                <th style="width: 5%;">App Admin&IT Div Head</th>
					                <th style="width: 5%;">Secretary Received Doc</th>
					                <th style="width: 5%;">App Operational Dir</th>
					                <th style="width: 5%;">App Fin Dir</th>
					                <th style="width: 5%;">App Vice Pres Dir</th>
					                <th style="width: 5%;">App Pres Dir</th>
					                <th style="width: 5%;">Bdg Received Doc</th>
					                <th style="width: 5%;">Bdg to PRC</th>
					                <th style="width: 5%;">PRC Received Doc</th>
		  			            </tr>
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
	      // "searching": false,
	      // "scrollX": true,
	      // "scrollY": "700px",
	      // "scrollCollapse": true,
	      // "paging": false,
	      // "lengthChange": false,
	      // "ordering": true,
	      // "info": true,
	      // "autoWidth": false,
	      "order": [],
	      processing: true, 
	      "oLanguage": {
	      	'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
	      }, 
	      serverSide: true,
	      ajax: "{{ route('dashboard.ops') }}",
	      columns: [
	      	{data: null, name: null},
	        {data: 'no_oh', name: 'no_oh'},
	        {data: 'act_app_prcbgt', name: 'act_app_prcbgt', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_bgtdep', name: 'act_app_bgtdep', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_admdiv', name: 'act_app_admdiv', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_secdok', name: 'act_app_secdok', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_od', name: 'act_app_od', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_fd', name: 'act_app_fd', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_vpd', name: 'act_app_vpd', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_pd', name: 'act_app_pd', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_bgtdok', name: 'act_app_bgtdok', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_bgt', name: 'act_app_bgt', className: "dt-center", orderable: false, searchable: false},
	        {data: 'act_app_prcdok', name: 'act_app_prcdok', className: "dt-center", orderable: false, searchable: false}
		  ]
	    });
	});

    //auto refresh
    setTimeout(function() {
	  location.reload();
	}, 60000); //1000 = 1 second
	</script>
@endsection