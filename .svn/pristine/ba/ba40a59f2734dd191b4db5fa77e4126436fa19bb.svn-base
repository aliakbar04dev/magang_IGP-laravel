@extends('monitoring.ehs.layouts.app')

@section('content')
	<BR>
	<div class="container2">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<center><a href="{{ url('/monitoringwp') }}"><h4>Monitoring Kontraktor IGP</h4></a></center>
					</div>

					<div class="panel-body">
		    		  <label><strong>Tanggal : </strong></label>
		    		  @if (empty($tgl))
				        {!! Form::date('filter_tgl', \Carbon\Carbon::now(), ['placeholder' => 'Tanggal', 'id' => 'filter_tgl', 'onchange' => 'changeTgl()']) !!}
				      @else
				      	{!! Form::date('filter_tgl', \Carbon\Carbon::createFromFormat('Ymd', base64_decode($tgl)), ['placeholder' => 'Tanggal', 'id' => 'filter_tgl', 'onchange' => 'changeTgl()']) !!}
				      @endif
		    		</div>
		    		<!-- /.box-body -->

					<div class="panel-body">
						<table id="tblMaster" class="table table-bordered" cellspacing="0" width="100%">
	    			    	<thead>
		  			            <tr>
		  			            	<th style='width: 1%;text-align: center'>No</th>
					                <th style='text-align: center'>Kontraktor</th>
					                <th style='width: 20%;text-align: center'>Project</th>
					                <th style='width: 1%;text-align: center'>Jenis</th>
					                <th style='width: 15%;text-align: center'>Lokasi</th>
					                <th style='width: 5%;text-align: center'>Site</th>
					                <th style='width: 15%;text-align: center'>PIC</th>
					                <th style='width: 5%;text-align: center'>IN</th>
					                <th style='width: 5%;text-align: center'>OUT</th>
					                <th>No. WP</th>
					                <th>Supplier</th>
					                <th>Site</th>
					                <th>PIC</th>
					                <th>Pelaksanaan</th>
					                <th>Scan IN</th>
					                <th>Scan OUT</th>
		  			            </tr>
	    			        </thead>
	    			        <tbody>
	  			            	@foreach ($ehstwp1s->get() as $data)
  			            			<tr>
  			            				@if($data->scan_sec_out_tgl == null && $data->skrg > $data->batas)
			    			        		<td style='text-align: center;color: white;' bgcolor="red">{{ $loop->iteration }}</td>
			    			        		<td style='color: white;' bgcolor="red">{{ $data->nm_supp }}</td>
			    			        		<td style='color: white;' bgcolor="red">{{ $data->nm_proyek }}</td>
			    			        		<td style='text-align: center;color: white;' bgcolor="red">
			    			        			@if (!empty($data->jns_pekerjaan))
			    			        				@if ($data->jns_pekerjaan === "H")
							                      		<img src="{{ asset("images/red.png") }}">
							                      	@elseif ($data->jns_pekerjaan === "M")
							                      		<img src="{{ asset("images/yellow.png") }}">
						                      		@else
						                      			<img src="{{ asset("images/green.png") }}">
								                    @endif
							                    @endif
			    			        		</td>
			    			        		<td style='color: white;' bgcolor="red">{{ $data->lok_proyek }}</td>
			    			        		<td style='text-align: center;color: white;' bgcolor="red">{{ $data->kd_site }}</td>
			    			        		<td style='color: white;' bgcolor="red">{{ $data->nm_pic }}</td>
			    			        		<td style='text-align: center;color: white;' bgcolor="red">
			    			        			@if ($data->scan_sec_in_tgl != null)
						                      		{{ \Carbon\Carbon::parse($data->scan_sec_in_tgl)->format('H:i') }}
							                    @endif
			    			        		</td>
			    			        		<td style='text-align: center;color: white;' bgcolor="red">
			    			        			@if ($data->scan_sec_out_tgl != null)
						                      		{{ \Carbon\Carbon::parse($data->scan_sec_out_tgl)->format('H:i') }}
							                    @endif
			    			        		</td>
			    			        	@else 
			    			        		<td style='text-align: center'>{{ $loop->iteration }}</td>
			    			        		<td>{{ $data->nm_supp }}</td>
			    			        		<td>{{ $data->nm_proyek }}</td>
			    			        		<td style='text-align: center'>
			    			        			@if (!empty($data->jns_pekerjaan))
			    			        				@if ($data->jns_pekerjaan === "H")
							                      		<img src="{{ asset("images/red.png") }}">
							                      	@elseif ($data->jns_pekerjaan === "M")
							                      		<img src="{{ asset("images/yellow.png") }}">
						                      		@else
						                      			<img src="{{ asset("images/green.png") }}">
								                    @endif
							                    @endif
			    			        		</td>
			    			        		<td>{{ $data->lok_proyek }}</td>
			    			        		<td style='text-align: center'>{{ $data->kd_site }}</td>
			    			        		<td>{{ $data->nm_pic }}</td>
			    			        		<td style='text-align: center'>
			    			        			@if ($data->scan_sec_in_tgl != null)
						                      		{{ \Carbon\Carbon::parse($data->scan_sec_in_tgl)->format('H:i') }}
							                    @endif
			    			        		</td>
			    			        		<td style='text-align: center'>
			    			        			@if ($data->scan_sec_out_tgl != null)
						                      		{{ \Carbon\Carbon::parse($data->scan_sec_out_tgl)->format('H:i') }}
							                    @endif
			    			        		</td>
			    			        	@endif
		    			        		<td>{{ $data->no_wp }}</td>
		    			        		<td>{{ $data->kd_supp }} - {{ $data->nm_supp }}</td>
		    			        		<td style='text-align: center'>
		    			        			@if (substr($data->kd_site,-1) === "J")
					                      		{{ substr($data->kd_site,0,3) }} - JAKARTA
					                      	@elseif ($data->status === "K")
					                      		{{ substr($data->kd_site,0,3) }} - KARAWANG
					                      	@elseif ($data->status === "C")
					                      		{{ substr($data->kd_site,0,3) }} - CIKAMPEK
				                      		@else
				                      			{{ $data->kd_site }}
						                    @endif
		    			        		</td>
		    			        		<td>{{ $data->pic_pp }} - {{ $data->nm_pic }}</td>
		    			        		<td>
		    			        			{{ \Carbon\Carbon::parse($data->tgl_laksana1)->format('d M Y H:i')." s/d ".\Carbon\Carbon::parse($data->tgl_laksana2)->format('d M Y H:i') }}
		    			        		</td>
		    			        		<td>
		    			        			@if ($data->scan_sec_in_tgl != null)
					                      		{{ \Carbon\Carbon::parse($data->scan_sec_in_tgl)->format('d M Y H:i') }}
						                    @endif
		    			        		</td>
		    			        		<td>
		    			        			@if ($data->scan_sec_out_tgl != null)
					                      		{{ \Carbon\Carbon::parse($data->scan_sec_out_tgl)->format('d M Y H:i') }}
						                    @endif
		    			        		</td>
			  			            </tr>
	    			        	@endforeach
	    			        </tbody>
	    			    </table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script>
	
	function changeTgl() {
		var var_tgl = document.getElementById("filter_tgl").value.trim();
		if(var_tgl !== "") {
			var date = new Date(var_tgl);
			var tahun = date.getFullYear();
	      	var bulan = date.getMonth() + 1;
	      	if(bulan < 10) {
	      		bulan = "0" + bulan;
	      	}
	      	var tgl = date.getDate();
	      	if(tgl < 10) {
	      		tgl = "0" + tgl;
	      	}
	      	var param = tahun + "" + bulan + "" + tgl;
	      	var urlRedirect = "{{ url('/monitoringwp/param') }}";
		  	urlRedirect = urlRedirect.replace('param', window.btoa(param));
		  	window.location.href = urlRedirect;
		}
	}

	$(document).ready(function(){
		var tableMaster = $('#tblMaster').DataTable({
			// "columnDefs": [{
			// 	"searchable": false,
			// 	"orderable": false,
			// 	"targets": 0,
			// 	render: function (data, type, row, meta) {
			// 		return meta.row + meta.settings._iDisplayStart + 1;
			// 	}
			// }],
		    "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
		    "iDisplayLength": 10,
		    "displayStart": {{ $displayStart }},
		    "responsive": true,
		    "scrollX": false,
		    "order": [[7, 'asc']],
		    columns: [
		      // {data: null, name: null},
		      {orderable: false, searchable: false},
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: false, searchable: false},
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      // {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: false, searchable: false, className: 'none'}, 
		      {orderable: false, searchable: false, className: 'none'}, 
		      {orderable: false, searchable: false, className: 'none'}, 
		      {orderable: false, searchable: false, className: 'none'}, 
		      {orderable: false, searchable: false, className: 'none'}, 
		      {orderable: false, searchable: false, className: "none"},
		      {orderable: false, searchable: false, className: "none"}
		    ],
	  	});

	  	$(function() {
	      $('\
	        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:0px;">\
	          <img src="{{ asset('images/red.png') }}" alt="X"> High Risk \
	          <img src="{{ asset('images/yellow.png') }}" alt="X"> Medium Risk \
	          <img src="{{ asset('images/green.png') }}" alt="X"> Low Risk \
	        </div>\
	      ').insertAfter('.dataTables_length');
	    });
	});

    //auto refresh
	setTimeout(function() {
	  	var var_tgl = document.getElementById("filter_tgl").value.trim();
		if(var_tgl !== "") {
			var date = new Date(var_tgl);
			var tahun = date.getFullYear();
	      	var bulan = date.getMonth() + 1;
	      	if(bulan < 10) {
	      		bulan = "0" + bulan;
	      	}
	      	var tgl = date.getDate();
	      	if(tgl < 10) {
	      		tgl = "0" + tgl;
	      	}

	      	var param = tahun + "" + bulan + "" + tgl;
	      	var displayStart = "{{ $displayStart }}";
		  	displayStart = Number(displayStart) + 10;


	      	var urlRedirect = "{{ url('/monitoringwp/param/param2') }}";
	      	urlRedirect = urlRedirect.replace('param2', displayStart);
		  	urlRedirect = urlRedirect.replace('param', window.btoa(param));
		  	window.location.href = urlRedirect;
		}
	}, 180000); //1000 = 1 second
</script>
@endsection