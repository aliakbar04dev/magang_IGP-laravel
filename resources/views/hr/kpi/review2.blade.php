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
					                <th style='width: 30%;text-align: center'>Target</th>
					                <th style='width: 8%;text-align: center'>Due Date</th>
					                <th style='width: 8%;text-align: center'>Act Date</th>
					                <th style='width: 5%;text-align: center'>Progress</th>
					                <th style='width: 5%;text-align: center'>Status</th>
		  			            </tr>
	    			        </thead>
	    			        <tbody>
	    			        	@foreach ($hrdtkpi->hrdtKpiActs()->orderBy(DB::raw("kd_item, id"))->get() as $data)
	    			        		@if ($data->jml_target > 0)
			    			        	<tr>
				    			        	<td rowspan="{{ $data->jml_target }}" style='text-align: center'>{{ $data->kd_item }}</td>
				    			        	<td rowspan="{{ $data->jml_target }}">{{ $data->activity }}</td>
				    			        	<td>
				    			        		Q1: 
				    			        		@if (!empty($data->target_q1))
							                        {{ $data->target_q1 }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->tgl_finish_q1))
							                        {{ \Carbon\Carbon::parse($data->tgl_finish_q1)->format('d/m/Y') }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center;{{ $data->status_tgl1 != null ? "color:white" : "color:black" }}' {{ $data->status_tgl1 != null ? "bgcolor=".$data->status_tgl1."" : '' }}>
				    			        		@if (!empty($data->tgl_finish_q1_act))
							                        {{ \Carbon\Carbon::parse($data->tgl_finish_q1_act)->format('d/m/Y') }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->persen_q1))
							                        {{ $data->persen_q1 }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->status_persen1))
							                      <img src="{{ asset("$data->status_persen1") }}">
							                    @endif
				    			        	</td>
				  			            </tr>
				  			            <tr>
				  			            	<td style="display:none"></td>
				    			        	<td style="display:none"></td>
				    			        	<td>
				    			        		Q2: 
				    			        		@if (!empty($data->target_q2))
							                        {{ $data->target_q2 }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->tgl_finish_q2))
							                        {{ \Carbon\Carbon::parse($data->tgl_finish_q2)->format('d/m/Y') }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center;{{ $data->status_tgl2 != null ? "color:white" : "color:black" }}' {{ $data->status_tgl2 != null ? "bgcolor=".$data->status_tgl2."" : '' }}>
				    			        		@if (!empty($data->tgl_finish_q2_act))
							                        {{ \Carbon\Carbon::parse($data->tgl_finish_q2_act)->format('d/m/Y') }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->persen_q2))
							                        {{ $data->persen_q2 }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->status_persen2))
							                      <img src="{{ asset("$data->status_persen2") }}">
							                    @endif
				    			        	</td>
				  			            </tr>
				  			            <tr>
				  			            	<td style="display:none"></td>
				    			        	<td style="display:none"></td>
				    			        	<td>
				    			        		Q3: 
				    			        		@if (!empty($data->target_q3))
							                        {{ $data->target_q3 }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->tgl_finish_q3))
							                        {{ \Carbon\Carbon::parse($data->tgl_finish_q3)->format('d/m/Y') }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center;{{ $data->status_tgl3 != null ? "color:white" : "color:black" }}' {{ $data->status_tgl3 != null ? "bgcolor=".$data->status_tgl3."" : '' }}>
				    			        		@if (!empty($data->tgl_finish_q3_act))
							                        {{ \Carbon\Carbon::parse($data->tgl_finish_q3_act)->format('d/m/Y') }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->persen_q3))
							                        {{ $data->persen_q3 }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->status_persen3))
							                      <img src="{{ asset("$data->status_persen3") }}">
							                    @endif
				    			        	</td>
				  			            </tr>
				  			            <tr>
				  			            	<td style="display:none"></td>
				    			        	<td style="display:none"></td>
				    			        	<td>
				    			        		Q4: 
				    			        		@if (!empty($data->target_q4))
							                        {{ $data->target_q4 }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->tgl_finish_q4))
							                        {{ \Carbon\Carbon::parse($data->tgl_finish_q4)->format('d/m/Y') }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center;{{ $data->status_tgl4 != null ? "color:white" : "color:black" }}' {{ $data->status_tgl4 != null ? "bgcolor=".$data->status_tgl4."" : '' }}>
				    			        		@if (!empty($data->tgl_finish_q4_act))
							                        {{ \Carbon\Carbon::parse($data->tgl_finish_q4_act)->format('d/m/Y') }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->persen_q4))
							                        {{ $data->persen_q4 }}
							                    @endif
				    			        	</td>
				    			        	<td style='text-align: center'>
				    			        		@if (!empty($data->status_persen4))
							                      <img src="{{ asset("$data->status_persen4") }}">
							                    @endif
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

@section('scripts')
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
		    //"paging": false,
		    //"lengthChange": false,
		    //"ordering": true,
		    "order": [],
		    //"info": true,
		    //"autoWidth": false,
		    columns: [
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
</script>
@endsection