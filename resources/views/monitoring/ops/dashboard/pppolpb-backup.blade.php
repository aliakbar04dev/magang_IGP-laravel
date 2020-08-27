@extends('monitoring.ops.layouts.app2')

@section('content')
	<BR>
	<div class="container2">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<center><a href="{{ url('/pppolpb') }}"><h4>Monitoring PP - PO - LPB {{ $periode->format('F Y') }}</h4></a></center>
					</div>
					<div class="panel-body">
						<table id="tblMaster" class="table table-bordered" cellspacing="0" width="100%">
	    			    	<thead>
		  			            <tr>
					                <th rowspan="2" style='width: 1%;text-align: center'>Item</th>
					                <th rowspan="2" style='width: 1%;text-align: center'>User</th>
					                <th rowspan="2" style='width: 1%;text-align: center'>QTY PP/Bulan</th>
					                <th rowspan="2" style='width: 1%;text-align: center'>PIC PRC</th>
					                <th rowspan="2" style='width: 1%;text-align: center'>Nama Supplier</th>
					                <th rowspan="2" style='text-align: center'>Item</th>
					                <th rowspan="2" style='width: 1%;text-align: center'>DOK</th>
					                <th colspan="7" style='text-align: center'>{{ $periode2->format('F Y') }}</th>
					                <th colspan="31" style='text-align: center'>{{ $periode->format('F Y') }}</th>
		  			            </tr>
		  			            <tr>
		  			            	@for ($i = 25; $i <= 31; $i++)
		  			            		<th style='width: 1%;text-align: center'>{{ $i }}</th>
		  			            	@endfor
		  			            	@for ($i = 1; $i <= 31; $i++)
		  			            		<th style='width: 1%;text-align: center'>{{ $i }}</th>
		  			            	@endfor
				                </tr>
	    			        </thead>
	    			        <tbody>
	    			        	@foreach ($prctcekpp->prctcekpp1s($periode->format('Ym'))->get() as $data)
		    			        	<tr>
			    			        	<td rowspan="3">{{ $data->ket_item }}</td>
			    			        	<td rowspan="3">{{ $data->nm_user }}</td>
			    			        	<td rowspan="3" style='text-align: center'>{{ numberFormatter(0, 2)->format($data->jml_pp) }}</td>
			    			        	<td rowspan="3">{{ $data->nm_pic }}</td>
			    			        	<td rowspan="3">{{ $data->nm_supplier }}</td>
			    			        	<td rowspan="3">{{ $data->nm_item }}</td>
			    			        	<td>PP</td>
			    			        	@foreach ($prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode2->format('Ym'))->get() as $prctcekpp3)
			    			        		<td style='text-align: center'>
				    			        		@if ($prctcekpp3->pp_std === "T")
				    			        			@if (empty($prctcekpp3->pp_dok))
								                      <img src="{{ asset("images/red_16.png") }}">
								                    @elseif ($prctcekpp3->pp_dok !== "x")
								                    	<img src="{{ asset("images/green_16.png") }}">
								                    @endif
							                    @endif
						                    </td>
			    			        	@endforeach
			    			        	@for ($i = (25+$prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode2->format('Ym'))->get()->count()); $i <= 31; $i++)
			    			        		<td></td>
			  			            	@endfor
			  			            	@foreach ($prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode->format('Ym'))->get() as $prctcekpp3)
			    			        		<td style='text-align: center'>
				    			        		@if ($prctcekpp3->pp_std === "T")
				    			        			@if (empty($prctcekpp3->pp_dok))
								                      <img src="{{ asset("images/red_16.png") }}">
								                    @elseif ($prctcekpp3->pp_dok !== "x")
								                    	<img src="{{ asset("images/green_16.png") }}">
								                    @endif
							                    @endif
						                    </td>
			    			        	@endforeach
			  			            	@for ($i = (1+$prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode->format('Ym'))->get()->count()); $i <= 31; $i++)
			  			            		<td></td>
			  			            	@endfor
			  			            </tr>
			  			            <tr>
			  			            	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			  			            	<td>PO</td>
			    			        	@foreach ($prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode2->format('Ym'))->get() as $prctcekpp3)
			    			        		<td style='text-align: center'>
				    			        		@if ($prctcekpp3->po_std === "T")
				    			        			@if (empty($prctcekpp3->po_dok))
								                      <img src="{{ asset("images/red_16.png") }}">
								                    @elseif ($prctcekpp3->po_dok !== "x")
								                    	<img src="{{ asset("images/green_16.png") }}">
								                    @endif
							                    @endif
						                    </td>
			    			        	@endforeach
			    			        	@for ($i = (25+$prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode2->format('Ym'))->get()->count()); $i <= 31; $i++)
			    			        		<td></td>
			  			            	@endfor
			  			            	@foreach ($prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode->format('Ym'))->get() as $prctcekpp3)
			    			        		<td style='text-align: center'>
				    			        		@if ($prctcekpp3->po_std === "T")
				    			        			@if (empty($prctcekpp3->po_dok))
								                      <img src="{{ asset("images/red_16.png") }}">
								                    @elseif ($prctcekpp3->po_dok !== "x")
								                    	<img src="{{ asset("images/green_16.png") }}">
								                    @endif
							                    @endif
						                    </td>
			    			        	@endforeach
			  			            	@for ($i = (1+$prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode->format('Ym'))->get()->count()); $i <= 31; $i++)
			  			            		<td></td>
			  			            	@endfor
			  			            </tr>
			  			            <tr>
			  			            	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			    			        	<td style="display:none"></td>
			  			            	<td>LPB</td>
			    			        	@foreach ($prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode2->format('Ym'))->get() as $prctcekpp3)
			    			        		<td style='text-align: center'>
				    			        		@if ($prctcekpp3->lpb_std === "T")
				    			        			@if (empty($prctcekpp3->lpb_dok))
								                      <img src="{{ asset("images/red_16.png") }}">
								                    @elseif ($prctcekpp3->lpb_dok !== "x")
								                    	<img src="{{ asset("images/green_16.png") }}">
								                    @endif
							                    @endif
						                    </td>
			    			        	@endforeach
			    			        	@for ($i = (25+$prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode2->format('Ym'))->get()->count()); $i <= 31; $i++)
			    			        		<td></td>
			  			            	@endfor
			  			            	@foreach ($prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode->format('Ym'))->get() as $prctcekpp3)
			    			        		<td style='text-align: center'>
				    			        		@if ($prctcekpp3->lpb_std === "T")
				    			        			@if (empty($prctcekpp3->lpb_dok))
								                      <img src="{{ asset("images/red_16.png") }}">
								                    @elseif ($prctcekpp3->lpb_dok !== "x")
								                    	<img src="{{ asset("images/green_16.png") }}">
								                    @endif
							                    @endif
						                    </td>
			    			        	@endforeach
			  			            	@for ($i = (1+$prctcekpp->prctcekpp3s($periode->format('Ym'), $data->no_cek, $periode->format('Ym'))->get()->count()); $i <= 31; $i++)
			  			            		<td></td>
			  			            	@endfor
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
	$(document).ready(function(){
		var tableMaster = $('#tblMaster').DataTable({
		    "aLengthMenu": [[3, 6, 9, 10, 15, 18, 21, 24, 27, 30, -1], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, "All"]],
      		"iDisplayLength": 15,
       		"displayStart": {{ $displayStart }}, 
		    "responsive": true,
		    //"searching": false,
		    "scrollX": false,
		    //"scrollY": "300px",
		    //"scrollCollapse": true,
		    //"paging": false,
		    //"lengthChange": false,
		    "ordering": false,
		    //"info": true,
		    //"autoWidth": false,
		    columns: [
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: true, searchable: true},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false}
		    ],
	  	});
	});

	//auto refresh
	setTimeout(function() {
	  // location.reload();
	  var displayStart = "{{ $displayStart }}";
	  displayStart = Number(displayStart) + 15;
	  var urlRedirect = "{{ url('/pppolpb/param') }}";
	  urlRedirect = urlRedirect.replace('param', displayStart);
	  window.location.href = urlRedirect;
	}, 180000); //1000 = 1 second
</script>
@endsection