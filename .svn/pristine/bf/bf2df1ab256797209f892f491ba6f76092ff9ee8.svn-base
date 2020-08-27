@extends('monitoring.mtc.layouts.app3')

<style>
	.table-scroll {
		position:relative;
		/*max-width:600px;*/
		margin:auto;
		overflow:hidden;
		border:1px solid #000;
	}
	.table-wrap {
		width:100%;
		overflow:auto;
	}
	.table-scroll table {
		width:100%;
		margin:auto;
		border-collapse:separate;
		border-spacing:0;
	}
	.table-scroll th, .table-scroll td {
		padding:5px 10px;
		border:1px solid #000;
		background:#fff;
		white-space:nowrap;
		vertical-align:top;
	}
	.table-scroll thead, .table-scroll tfoot {
		background:#f9f9f9;
	}
	.clone {
		position:absolute;
		top:0;
		left:0;
		pointer-events:none;
	}
	.clone th, .clone td {
		visibility:hidden
	}
	.clone td, .clone th {
		border-color:transparent
	}
	.clone tbody th {
		visibility:visible;
		color:red;
	}
	.clone .fixed-side {
		border:1px solid #000;
		background:#eee;
		visibility:visible;
	}
	.clone thead, .clone tfoot {
		background:transparent;
	}
</style>

@section('content')
	<div class="container3">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<table width="100%">
							<tr>
								<th style='width: 10%;text-align: center'>&nbsp;</th>
								<th style='text-align: center'>
									{{-- <center> --}}
										<h4>Monitoring Laporan Pekerjaan IGP-{{ $plant }} {{ \Carbon\Carbon::createFromFormat('Ym', $tahun."".$bulan)->format('F Y') }}</h4>
									{{-- </center> --}}
								</th>
								<th style='width: 10%;text-align: right;'>
									<button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
										<span class="glyphicon glyphicon-remove"></span>
									</button>
								</th>
							</tr>
						</table>
					</div>

					<div class="panel-body">
						<div class="box-body form-horizontal" id="box-overflow-2">
							<div class="form-group">
								<div class="col-sm-2">
									{!! Form::label('lbltahun', 'Tahun') !!}
									<select id="filter_status_tahun" name="filter_status_tahun" aria-controls="filter_status" class="form-control select2">
										@for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
											@if ($i == $tahun)
												<option value={{ $i }} selected="selected">{{ $i }}</option>
											@else
												<option value={{ $i }}>{{ $i }}</option>
											@endif
										@endfor
									</select>
								</div>
								<div class="col-sm-2">
									{!! Form::label('lblbulan', 'Bulan') !!}
									<select name="filter_status_bulan" aria-controls="filter_status" class="form-control select2">
										<option value="01" @if ("01" == $bulan) selected="selected" @endif>Januari</option>
										<option value="02" @if ("02" == $bulan) selected="selected" @endif>Februari</option>
										<option value="03" @if ("03" == $bulan) selected="selected" @endif>Maret</option>
										<option value="04" @if ("04" == $bulan) selected="selected" @endif>April</option>
										<option value="05" @if ("05" == $bulan) selected="selected" @endif>Mei</option>
										<option value="06" @if ("06" == $bulan) selected="selected" @endif>Juni</option>
										<option value="07" @if ("07" == $bulan) selected="selected" @endif>Juli</option>
										<option value="08" @if ("08" == $bulan) selected="selected" @endif>Agustus</option>
										<option value="09" @if ("09" == $bulan) selected="selected" @endif>September</option>
										<option value="10" @if ("10" == $bulan) selected="selected" @endif>Oktober</option>
										<option value="11" @if ("11" == $bulan) selected="selected" @endif>November</option>
										<option value="12" @if ("12" == $bulan) selected="selected" @endif>Desember</option>
									</select>
								</div>
								<div class="col-sm-2" style="display: none;">
									{!! Form::label('lblusername2', 'Action') !!}
									<button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
								</div>
							</div>
							<!-- /.form-group -->
						</div>
						<div>
							<img src="{{ asset('images/green_16.png') }}" alt="X"> SUDAH ADA LP 
							<img src="{{ asset('images/red_16.png') }}" alt="X"> TIDAK ADA LP 
							<img src="{{ asset('images/white_16.png') }}" alt="X"> BELUM ADA LP 
						</div>
						<div id="table-scroll" class="table-scroll">
							<div class="table-wrap">
								<table id="tblMaster" class="main-table table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th rowspan="2" class="fixed-side" scope="col" style='width: 1%;text-align: center;vertical-align: middle;'>No</th>
											<th rowspan="2" class="fixed-side" scope="col" style='text-align: center;vertical-align: middle;'>Line</th>
											<th colspan="31" scope="col" style='width: 1%;text-align: center;'>Tanggal</th>
										</tr>
										<tr>
											@for ($i = 1; $i <= 31; $i++)
												<th scope="col" style='width: 1%;text-align: center'>
													{{ $i }}
												</th>
											@endfor
										</tr>
									</thead>
									<tbody>
										@foreach ($xmlines->get() as $data)
			  			            		<tr>
			  			            			<td class="fixed-side" style='width: 1%;text-align: center'>{{ $loop->iteration }}</td>
												<td class="fixed-side">
													{{ $data->xkd_line }} - {{ $data->xnm_line }}
												</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->satu))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
									                    @if ($period."01" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->dua))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
									                    @if ($period."02" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->tiga))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."03" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->empat))
				    			        				<img src="{{ asset("images/green_16.png") }}">
				    			        			@else
								                    	@if ($period."04" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->lima))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."05" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->enam))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."06" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->tujuh))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."07" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->delapan))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."08" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->sembilan))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."09" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->sepuluh))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."10" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->sebelas))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."11" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duabelas))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."12" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->tigabelas))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."13" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->empatbelas))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."14" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->limabelas))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."15" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->enambelas))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."16" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->tujuhbelas))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."17" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->delapanbelas))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."18" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->sembilanbelas))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."19" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duapuluh))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."20" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duasatu))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."21" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duadua))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."22" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duatiga))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."23" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duaempat))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."24" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->dualima))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."25" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duaenam))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."26" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duatujuh))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."27" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duadelapan))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."28" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->duasembilan))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."29" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->tigapuluh))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."30" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
				    			        		<td style='text-align: center'>
				    			        			@if (!empty($data->tigasatu))
				    			        				<img src="{{ asset("images/green_16.png") }}">
								                    @else
								                    	@if ($period."31" < $tgl)
									                    	<img src="{{ asset("images/red_16.png") }}">
									                    @else
									                    	<img src="{{ asset("images/white_16.png") }}">
									                    @endif
								                    @endif
				    			        		</td>
					  			            </tr>
			    			        	@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th rowspan="2" class="fixed-side" scope="col" style='width: 1%;text-align: center;vertical-align: middle;'>No</th>
											<th rowspan="2" class="fixed-side" scope="col" style='text-align: center;vertical-align: middle;'>Line</th>
											@for ($i = 1; $i <= 31; $i++)
												<th scope="col" style='width: 1%;text-align: center'>
													{{ $i }}
												</th>
											@endfor
										</tr>
										<tr>
											<th colspan="31" scope="col" style='width: 1%;text-align: center;'>Tanggal</th>
										</tr>
									</tfoot>
								</table>
							  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script>

	//Initialize Select2 Elements
    $(".select2").select2();

	// requires jquery library
	jQuery(document).ready(function() {
		jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
	});

	$('select[name="filter_status_tahun"]').change(function() {
      $('#display').click();
    });
    
    $('select[name="filter_status_bulan"]').change(function() {
      $('#display').click();
    });

    $('#display').click( function () {
    	var kd_plant = "{{ $plant }}";
    	var tahun = $('select[name="filter_status_tahun"]').val();
    	var bulan = $('select[name="filter_status_bulan"]').val();
    	var urlRedirect = "{{ route('smartmtcs.monitoringlp', ['param','param2','param3']) }}";
    	urlRedirect = urlRedirect.replace('param3', bulan);
    	urlRedirect = urlRedirect.replace('param2', tahun);
    	urlRedirect = urlRedirect.replace('param', kd_plant);
    	window.location.href = urlRedirect;
    });
</script>
@endsection