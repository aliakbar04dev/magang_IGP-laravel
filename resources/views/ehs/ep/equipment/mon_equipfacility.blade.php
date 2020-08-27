@extends('monitoring.mtc.layouts.app3')

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
										<h4>Monitoring Equipment Facility {{ \Carbon\Carbon::createFromFormat('Ym', $tahun."".$bulan)->format('F Y') }}</h4>
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
								<div class="col-sm-2" >
									{!! Form::label('lblusername2', 'Action') !!}
									<button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
								</div>
							</div>
							<!-- /.form-group -->
						</div>
						<div>
							<img src="{{ asset('images/green.png') }}" alt="X"> OK 
							<img src="{{ asset('images/yellow.png') }}" alt="X"> NG 
							<img src="{{ asset('images/red.png') }}" alt="X"> TIDAK DI-CHECK 
							<img src="{{ asset('images/white.png') }}" alt="X"> BELUM DI-CHECK 
						</div>
						<div class="freeze-table">
							<table style="background: black;color: white;" class="table table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr style="background: black;color: white;">
										<th rowspan="3" style='width: 1%;text-align: center;vertical-align: middle;'>No</th>
										<th rowspan='2' style='text-align: center;vertical-align: middle;'>Lokasi</th>
										<th colspan="93" style='text-align: center;vertical-align: middle;'>Tanggal</th>
									</tr>
									
									<tr style="background: black;color: white;">
										
										@for ($i = 1; $i <= 31; $i++)
											<th  style='width: 3%;text-align: center'>{{ $i }}</th>
										@endfor
									</tr>
								</thead>
								<tbody>
									@foreach ($equipment_facility_reps->get() as $data)
										<tr>
											<td style='background: black;color: white;width: 1%;text-align: center'>{{ $loop->iteration }}</td>
											<td style='background: black;color: white;text-align: center'>{{ $data->kd_ot }}</td>
											<td style='text-align: center'>
												@if ($data->t01 != null)
													@if ($data->t01 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','01')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','01')">
													@endif
												@else
													@if ($tahun."".$bulan."01" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."01" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t02 != null)
													@if ($data->t02 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','02')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','02')">
													@endif
												@else
													@if ($tahun."".$bulan."02" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."02" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t03 != null)
													@if ($data->t03 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','03')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','03')">
													@endif
												@else
													@if ($tahun."".$bulan."03" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."03" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t04 != null)
													@if ($data->t04 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','04')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','04')">
													@endif
												@else
													@if ($tahun."".$bulan."04" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."04" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t05 != null)
													@if ($data->t05 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','05')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','05')">
													@endif
												@else
													@if ($tahun."".$bulan."05" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."05" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t06 != null)
													@if ($data->t06 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','06')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','06')">
													@endif
												@else
													@if ($tahun."".$bulan."06" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."06" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t07 != null)
													@if ($data->t07 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','07')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','07')">
													@endif
												@else
													@if ($tahun."".$bulan."07" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."07" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t08 != null)
													@if ($data->t08 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','08')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','08')">
													@endif
												@else
													@if ($tahun."".$bulan."08" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."08" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t09 != null)
													@if ($data->t09 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','09')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','09')">
													@endif
												@else
													@if ($tahun."".$bulan."09" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."09" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t10 != null)
													@if ($data->t10 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','10')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','10')">
													@endif
												@else
													@if ($tahun."".$bulan."10" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."10" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t11 != null)
													@if ($data->t11 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','11')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','11')">
													@endif
												@else
													@if ($tahun."".$bulan."11" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."11" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t12 != null)
													@if ($data->t12 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','12')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','12')">
													@endif
												@else
													@if ($tahun."".$bulan."12" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."12" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t13 != null)
													@if ($data->t13 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','13')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','13')">
													@endif
												@else
													@if ($tahun."".$bulan."13" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."13" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t14 != null)
													@if ($data->t14 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','14')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','14')">
													@endif
												@else
													@if ($tahun."".$bulan."14" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."14" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t15 != null)
													@if ($data->t15 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','15')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','15')">
													@endif
												@else
													@if ($tahun."".$bulan."15" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."15" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t16 != null)
													@if ($data->t16 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','16')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','16')">
													@endif
												@else
													@if ($tahun."".$bulan."16" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."16" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t17 != null)
													@if ($data->t17 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','17')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','17')">
													@endif
												@else
													@if ($tahun."".$bulan."17" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."17" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t18 != null)
													@if ($data->t18 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','18')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','18')">
													@endif
												@else
													@if ($tahun."".$bulan."18" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."18" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t19 != null)
													@if ($data->t19 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','19')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','19')">
													@endif
												@else
													@if ($tahun."".$bulan."19" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."19" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t20 != null)
													@if ($data->t20 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','20')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','20')">
													@endif
												@else
													@if ($tahun."".$bulan."20" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."20" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t21 != null)
													@if ($data->t21 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','21')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','21')">
													@endif
												@else
													@if ($tahun."".$bulan."21" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."21" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t22 != null)
													@if ($data->t22 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','22')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','22')">
													@endif
												@else
													@if ($tahun."".$bulan."22" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."22" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t23 != null)
													@if ($data->t23 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','23')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','23')">
													@endif
												@else
													@if ($tahun."".$bulan."23" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."23" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t24 != null)
													@if ($data->t24 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','24')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','24')">
													@endif
												@else
													@if ($tahun."".$bulan."24" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."24" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
										
											<td style='text-align: center'>
												@if ($data->t25 != null)
													@if ($data->t25 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','25')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','25')">
													@endif
												@else
													@if ($tahun."".$bulan."25" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."25" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t26 != null)
													@if ($data->t26 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','26')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','26')">
													@endif
												@else
													@if ($tahun."".$bulan."26" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."26" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t27 != null)
													@if ($data->t27 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','27')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','27')">
													@endif
												@else
													@if ($tahun."".$bulan."27" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."27" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t28 != null)
													@if ($data->t28 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','28')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','28')">
													@endif
												@else
													@if ($tahun."".$bulan."28" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."28" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t29 != null)
													@if ($data->t29 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','29')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','29')">
													@endif
												@else
													@if ($tahun."".$bulan."29" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."29" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t30 != null)
													@if ($data->t30 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','30')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','30')">
													@endif
												@else
													@if ($tahun."".$bulan."30" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."30" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											
											<td style='text-align: center'>
												@if ($data->t31 != null)
													@if ($data->t31 == "OK")
														<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','31')">
													@else 
														<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_ot }}','31')">
													@endif
												@else
													@if ($tahun."".$bulan."31" < $tgl)
														<img src="{{ asset("images/red_16.png") }}">
													@else
														@if ($tahun."".$bulan."31" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/red_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
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
	</div>
@endsection

@section('scripts')
{{-- https://github.com/yidas/jquery-freeze-table --}}
<script src="{{ asset('js/freeze-table.js') }}"></script>
<script>

	//Initialize Select2 Elements
    $(".select2").select2();

    $(function() {
    	$('.freeze-table').freezeTable({
    		'columnNum' : 2,
    		'columnKeep': true,
    	});
    });

	function popup(kd_ot, tgl)
	{
		var tahun = "{{ $tahun }}";
		var bulan = "{{ $bulan }}";
		var param = tahun + "" + bulan + "" + tgl;
        var urlRedirect = "{{ route('ehsenvreps.detail_equipfacility', ['param','param2']) }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(kd_ot));
        urlRedirect = urlRedirect.replace('param2', window.btoa(param));
        // window.location.href = urlRedirect;
    	window.open(urlRedirect, '_blank');
	}



    $('#display').click( function () {
      var tahun = $('select[name="filter_status_tahun"]').val();
	  var bulan = $('select[name="filter_status_bulan"]').val();
	  var urlRedirect = "{{ route('ehsenvreps.monitoring_ef', ['param','param2']) }}";
	  urlRedirect = urlRedirect.replace('param2', bulan);
	  urlRedirect = urlRedirect.replace('param', tahun);
	  window.location.href = urlRedirect;
    });
</script>
@endsection