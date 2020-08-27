@extends('hr.kpi.layouts.app2')

@section('content')
	<BR>
	<div class="container2">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<center><a href="{{ route('hrdtkpis.review', base64_encode($hrdtkpi->id)) }}"><h4>Review KPI Division {{ $hrdtkpi->desc_div }} Tahun: {{ $hrdtkpi->tahun }}</h4></a></center>
					</div>
					<div class="panel-body">
						<table id="tblMaster" class="table table-bordered" cellspacing="0" width="100%">
	    			    	<thead>
		  			            <tr>
					                <th style='width: 1%;text-align: center'>Item</th>
					                <th style='text-align: center'>Activity</th>
					                <th style='width: 15%;text-align: center'>Q1<BR>Jan-Mar</th>
					                <th style='width: 15%;text-align: center'>Q2<BR>Apr-Jun</th>
					                <th style='width: 15%;text-align: center'>Q3<BR>Jul-Sep</th>
					                <th style='width: 15%;text-align: center'>Q4<BR>Oct-Dec</th>
		  			            </tr>
	    			        </thead>
	    			        <tbody>
	    			        	@foreach ($hrdtkpi->hrdtKpiActs()->orderBy(DB::raw("kd_item, id"))->get() as $data)
	    			        		@if ($data->jml_target > 0)
	    			        			<tr>
	    			        				<th rowspan="{{ $data->jml_target+1 }}" style='text-align: center'>{{ $data->kd_item }}</th>
	    			        				<th colspan="5">Activity: {{ $data->activity }}</th>
	    			        				<td style="display: none;"></td>
 											<td style="display: none;"></td>
 											<td style="display: none;"></td>
 											<td style="display: none;"></td>
	    			        			</tr>
			    			        	<tr>
			    			        		<td style="display: none;"></td>
				    			        	<td>
				    			        		@if (!empty($data->target_q1))
							                        {{ $data->target_q1 }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		<div data-toggle="tooltip" data-placement="top" data-html="true" title="{{ $data->tooltip_1 }}" class="w3-light-grey w3-round-xlarge">
				    			        			<div class="w3-container w3-padding-xsmall w3-{{ $data->warna_persen1 }} w3-center w3-round-xlarge" style="width:{{ $data->persen_q1 }}%">
				    			        				{{ $data->persen_q1 }}%
				    			        			</div>
				    			        		</div>
				    			        	</td>
				    			        	<td></td>
				    			        	<td></td>
				    			        	<td></td>
				  			            </tr>
				  			            <tr>
				  			            	<td style="display:none"></td>
				    			        	<td>
				    			        		@if (!empty($data->target_q2))
							                        {{ $data->target_q2 }}
							                    @endif
				    			        	</td>
				    			        	<td></td>
				    			        	<td style='text-align: center'>
				    			        		<div data-toggle="tooltip" data-placement="top" data-html="true" title="{{ $data->tooltip_2 }}" class="w3-light-grey w3-round-xlarge">
				    			        			<div class="w3-container w3-padding-xsmall w3-{{ $data->warna_persen2 }} w3-center w3-round-xlarge" style="width:{{ $data->persen_q2 }}%">
				    			        				{{ $data->persen_q2 }}%
				    			        			</div>
				    			        		</div>
				    			        	</td>
				    			        	<td></td>
				    			        	<td></td>
				  			            </tr>
				  			            <tr>
				  			            	<td style="display:none"></td>
				    			        	<td>
				    			        		@if (!empty($data->target_q3))
							                        {{ $data->target_q3 }}
							                    @endif
				    			        	</td>
				    			        	<td></td>
				    			        	<td></td>
				    			        	<td style='text-align: center'>
				    			        		<div data-toggle="tooltip" data-placement="top" data-html="true" title="{{ $data->tooltip_3 }}" class="w3-light-grey w3-round-xlarge">
				    			        			<div class="w3-container w3-padding-xsmall w3-{{ $data->warna_persen3 }} w3-center w3-round-xlarge" style="width:{{ $data->persen_q3 }}%">
				    			        				{{ $data->persen_q3 }}%
				    			        			</div>
				    			        		</div>
				    			        	</td>
				    			        	<td></td>
				  			            </tr>
				  			            <tr>
				  			            	<td style="display:none"></td>
				    			        	<td> 
				    			        		@if (!empty($data->target_q4))
							                        {{ $data->target_q4 }}
							                    @endif
				    			        	</td>
				    			        	<td></td>
				    			        	<td></td>
				    			        	<td></td>
				    			        	<td style='text-align: center'>
				    			        		<div data-toggle="tooltip" data-placement="top" data-html="true" title="{{ $data->tooltip_4 }}" class="w3-light-grey w3-round-xlarge">
				    			        			<div class="w3-container w3-padding-xsmall w3-{{ $data->warna_persen4 }} w3-center w3-round-xlarge" style="width:{{ $data->persen_q4 }}%">
				    			        				{{ $data->persen_q4 }}%
				    			        			</div>
				    			        		</div>
				    			        	</td>
				  			            </tr>
				  			        @endif
			  			        @endforeach
	    			        </tbody>
	    			    </table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

{{-- @section('scripts')
<script>
	$(document).ready(function(){
		var tableMaster = $('#tblMaster').DataTable({
		    "aLengthMenu": [[4, 8, 12, 16, 20, 24, 28, 32, 36, 40, -1], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, "All"]],
      		"iDisplayLength": 12,
		    "responsive": true,
		    "searching": false,
		    "scrollX": false,
		    //"scrollY": "300px",
		    //"scrollCollapse": true,
		    "paging": false,
		    "lengthChange": false,
		    //"ordering": true,
		    "order": [],
		    //"info": true,
		    //"autoWidth": false,
		    columns: [
		      // {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false},
		      {orderable: false, searchable: false}
		    ],
	  	});
	});
</script>
@endsection --}}