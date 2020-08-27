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
										<h4>Monitoring LCH Alat Angkut {{ \Carbon\Carbon::createFromFormat('Ym', $tahun."".$bulan)->format('F Y') }}</h4>
									{{-- </center> --}}
								</th>
								<th style='width: 10%;text-align: right;'>
									<a href="{{ route('smartmtcs.dashboardmtc2') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Home">
										<span class="glyphicon glyphicon-home"></span>
									</a>
									&nbsp;&nbsp;
									<button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Close" onclick="window.open('', '_self', ''); window.close();">
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
							<img src="{{ asset('images/green.png') }}" alt="X"> UNIT OK 
							<img src="{{ asset('images/yellow.png') }}" alt="X"> ADA ITEM NG 
							<img src="{{ asset('images/red.png') }}" alt="X"> RUSAK / OVER HOULE 
							<img src="{{ asset('images/blue.png') }}" alt="X"> OFF 
							<img src="{{ asset('images/black.png') }}" alt="X"> TIDAK DI-CHECK 
							<img src="{{ asset('images/white.png') }}" alt="X"> BELUM DI-CHECK 
						</div>
						<div class="freeze-table">
							<table class="table table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr style="background: #DCDCDC;color: black;">
										<th rowspan="3" style='width: 1%;text-align: center;vertical-align: middle;'>No</th>
										<th style='min-width:65px;text-align: center'>Tgl</th>
										@for ($i = 1; $i <= 31; $i++)
											@if($sch[$i-1] == "L")
												<th colspan="3" style='background: red;color: white;width: 3%;text-align: center'>
													{{ $i }}
												</th>
											@else 
												<th colspan="3" style='width: 3%;text-align: center'>
													{{ $i }}
												</th>
											@endif
										@endfor
									</tr>
									<tr style="background: #DCDCDC;color: black;">
										<th style='text-align: center'>Shift</th>
										@for ($i = 1; $i <= 31; $i++)
											@for ($x = 1; $x <= 3; $x++)
												<th style='width: 1%;text-align: center'>{{ $x }}</th>
											@endfor
										@endfor
									</tr>
									<tr style="background: #DCDCDC;color: black;">
										<th style='text-align: center'>Kode</th>
										<th colspan="93">&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($mtct_lch_forklif_reps->get() as $data)
										<tr>
											<th style='background: #DCDCDC;color: black;width: 1%;text-align: center'>{{ $loop->iteration }}</th>
											<th style='background: #DCDCDC;color: black;text-align: center'>{{ $data->kd_forklif }}</th>
											<td style='text-align: center'>
												@if (substr($data->t01_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','1')">
												@elseif (substr($data->t01_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','1')">
												@elseif (substr($data->t01_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','1')">
												@elseif (substr($data->t01_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','1')">
												@else
													@if ($tahun."".$bulan."01" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."01" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t01_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','2')">
												@elseif (substr($data->t01_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','2')">
												@elseif (substr($data->t01_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','2')">
												@elseif (substr($data->t01_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','2')">
												@else
													@if ($tahun."".$bulan."01" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."01" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t01_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','3')">
												@elseif (substr($data->t01_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','3')">
												@elseif (substr($data->t01_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','3')">
												@elseif (substr($data->t01_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','01','3')">
												@else
													@if ($tahun."".$bulan."01" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."01" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t02_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','1')">
												@elseif (substr($data->t02_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','1')">
												@elseif (substr($data->t02_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','1')">
												@elseif (substr($data->t02_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','1')">
												@else
													@if ($tahun."".$bulan."02" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."02" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t02_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','2')">
												@elseif (substr($data->t02_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','2')">
												@elseif (substr($data->t02_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','2')">
												@elseif (substr($data->t02_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','2')">
												@else
													@if ($tahun."".$bulan."02" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."02" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t02_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','3')">
												@elseif (substr($data->t02_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','3')">
												@elseif (substr($data->t02_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','3')">
												@elseif (substr($data->t02_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','02','3')">
												@else
													@if ($tahun."".$bulan."02" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."02" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t03_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','1')">
												@elseif (substr($data->t03_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','1')">
												@elseif (substr($data->t03_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','1')">
												@elseif (substr($data->t03_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','1')">
												@else
													@if ($tahun."".$bulan."03" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."03" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t03_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','2')">
												@elseif (substr($data->t03_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','2')">
												@elseif (substr($data->t03_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','2')">
												@elseif (substr($data->t03_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','2')">
												@else
													@if ($tahun."".$bulan."03" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."03" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t03_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','3')">
												@elseif (substr($data->t03_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','3')">
												@elseif (substr($data->t03_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','3')">
												@elseif (substr($data->t03_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','03','3')">
												@else
													@if ($tahun."".$bulan."03" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."03" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t04_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','1')">
												@elseif (substr($data->t04_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','1')">
												@elseif (substr($data->t04_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','1')">
												@elseif (substr($data->t04_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','1')">
												@else
													@if ($tahun."".$bulan."04" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."04" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t04_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','2')">
												@elseif (substr($data->t04_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','2')">
												@elseif (substr($data->t04_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','2')">
												@elseif (substr($data->t04_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','2')">
												@else
													@if ($tahun."".$bulan."04" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."04" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t04_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','3')">
												@elseif (substr($data->t04_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','3')">
												@elseif (substr($data->t04_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','3')">
												@elseif (substr($data->t04_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','04','3')">
												@else
													@if ($tahun."".$bulan."04" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."04" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t05_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','1')">
												@elseif (substr($data->t05_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','1')">
												@elseif (substr($data->t05_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','1')">
												@elseif (substr($data->t05_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','1')">
												@else
													@if ($tahun."".$bulan."05" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."05" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t05_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','2')">
												@elseif (substr($data->t05_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','2')">
												@elseif (substr($data->t05_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','2')">
												@elseif (substr($data->t05_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','2')">
												@else
													@if ($tahun."".$bulan."05" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."05" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t05_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','3')">
												@elseif (substr($data->t05_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','3')">
												@elseif (substr($data->t05_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','3')">
												@elseif (substr($data->t05_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','05','3')">
												@else
													@if ($tahun."".$bulan."05" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."05" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t06_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','1')">
												@elseif (substr($data->t06_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','1')">
												@elseif (substr($data->t06_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','1')">
												@elseif (substr($data->t06_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','1')">
												@else
													@if ($tahun."".$bulan."06" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."06" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t06_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','2')">
												@elseif (substr($data->t06_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','2')">
												@elseif (substr($data->t06_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','2')">
												@elseif (substr($data->t06_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','2')">
												@else
													@if ($tahun."".$bulan."06" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."06" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t06_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','3')">
												@elseif (substr($data->t06_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','3')">
												@elseif (substr($data->t06_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','3')">
												@elseif (substr($data->t06_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','06','3')">
												@else
													@if ($tahun."".$bulan."06" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."06" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t07_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','1')">
												@elseif (substr($data->t07_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','1')">
												@elseif (substr($data->t07_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','1')">
												@elseif (substr($data->t07_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','1')">
												@else
													@if ($tahun."".$bulan."07" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."07" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t07_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','2')">
												@elseif (substr($data->t07_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','2')">
												@elseif (substr($data->t07_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','2')">
												@elseif (substr($data->t07_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','2')">
												@else
													@if ($tahun."".$bulan."07" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."07" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t07_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','3')">
												@elseif (substr($data->t07_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','3')">
												@elseif (substr($data->t07_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','3')">
												@elseif (substr($data->t07_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','07','3')">
												@else
													@if ($tahun."".$bulan."07" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."07" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t08_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','1')">
												@elseif (substr($data->t08_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','1')">
												@elseif (substr($data->t08_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','1')">
												@elseif (substr($data->t08_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','1')">
												@else
													@if ($tahun."".$bulan."08" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."08" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t08_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','2')">
												@elseif (substr($data->t08_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','2')">
												@elseif (substr($data->t08_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','2')">
												@elseif (substr($data->t08_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','2')">
												@else
													@if ($tahun."".$bulan."08" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."08" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t08_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','3')">
												@elseif (substr($data->t08_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','3')">
												@elseif (substr($data->t08_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','3')">
												@elseif (substr($data->t08_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','08','3')">
												@else
													@if ($tahun."".$bulan."08" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."08" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t09_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','1')">
												@elseif (substr($data->t09_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','1')">
												@elseif (substr($data->t09_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','1')">
												@elseif (substr($data->t09_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','1')">
												@else
													@if ($tahun."".$bulan."09" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."09" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t09_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','2')">
												@elseif (substr($data->t09_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','2')">
												@elseif (substr($data->t09_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','2')">
												@elseif (substr($data->t09_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','2')">
												@else
													@if ($tahun."".$bulan."09" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."09" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t09_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','3')">
												@elseif (substr($data->t09_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','3')">
												@elseif (substr($data->t09_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','3')">
												@elseif (substr($data->t09_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','09','3')">
												@else
													@if ($tahun."".$bulan."09" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."09" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t10_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','1')">
												@elseif (substr($data->t10_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','1')">
												@elseif (substr($data->t10_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','1')">
												@elseif (substr($data->t10_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','1')">
												@else
													@if ($tahun."".$bulan."10" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."10" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t10_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','2')">
												@elseif (substr($data->t10_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','2')">
												@elseif (substr($data->t10_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','2')">
												@elseif (substr($data->t10_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','2')">
												@else
													@if ($tahun."".$bulan."10" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."10" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t10_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','3')">
												@elseif (substr($data->t10_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','3')">
												@elseif (substr($data->t10_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','3')">
												@elseif (substr($data->t10_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','10','3')">
												@else
													@if ($tahun."".$bulan."10" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."10" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t11_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','1')">
												@elseif (substr($data->t11_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','1')">
												@elseif (substr($data->t11_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','1')">
												@elseif (substr($data->t11_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','1')">
												@else
													@if ($tahun."".$bulan."11" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."11" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t11_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','2')">
												@elseif (substr($data->t11_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','2')">
												@elseif (substr($data->t11_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','2')">
												@elseif (substr($data->t11_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','2')">
												@else
													@if ($tahun."".$bulan."11" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."11" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t11_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','3')">
												@elseif (substr($data->t11_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','3')">
												@elseif (substr($data->t11_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','3')">
												@elseif (substr($data->t11_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','11','3')">
												@else
													@if ($tahun."".$bulan."11" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."11" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t12_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','1')">
												@elseif (substr($data->t12_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','1')">
												@elseif (substr($data->t12_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','1')">
												@elseif (substr($data->t12_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','1')">
												@else
													@if ($tahun."".$bulan."12" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."12" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t12_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','2')">
												@elseif (substr($data->t12_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','2')">
												@elseif (substr($data->t12_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','2')">
												@elseif (substr($data->t12_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','2')">
												@else
													@if ($tahun."".$bulan."12" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."12" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t12_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','3')">
												@elseif (substr($data->t12_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','3')">
												@elseif (substr($data->t12_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','3')">
												@elseif (substr($data->t12_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','12','3')">
												@else
													@if ($tahun."".$bulan."12" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."12" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t13_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','1')">
												@elseif (substr($data->t13_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','1')">
												@elseif (substr($data->t13_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','1')">
												@elseif (substr($data->t13_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','1')">
												@else
													@if ($tahun."".$bulan."13" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."13" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t13_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','2')">
												@elseif (substr($data->t13_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','2')">
												@elseif (substr($data->t13_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','2')">
												@elseif (substr($data->t13_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','2')">
												@else
													@if ($tahun."".$bulan."13" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."13" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t13_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','3')">
												@elseif (substr($data->t13_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','3')">
												@elseif (substr($data->t13_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','3')">
												@elseif (substr($data->t13_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','13','3')">
												@else
													@if ($tahun."".$bulan."13" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."13" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t14_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','1')">
												@elseif (substr($data->t14_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','1')">
												@elseif (substr($data->t14_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','1')">
												@elseif (substr($data->t14_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','1')">
												@else
													@if ($tahun."".$bulan."14" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."14" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t14_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','2')">
												@elseif (substr($data->t14_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','2')">
												@elseif (substr($data->t14_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','2')">
												@elseif (substr($data->t14_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','2')">
												@else
													@if ($tahun."".$bulan."14" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."14" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t14_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','3')">
												@elseif (substr($data->t14_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','3')">
												@elseif (substr($data->t14_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','3')">
												@elseif (substr($data->t14_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','14','3')">
												@else
													@if ($tahun."".$bulan."14" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."14" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t15_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','1')">
												@elseif (substr($data->t15_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','1')">
												@elseif (substr($data->t15_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','1')">
												@elseif (substr($data->t15_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','1')">
												@else
													@if ($tahun."".$bulan."15" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."15" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t15_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','2')">
												@elseif (substr($data->t15_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','2')">
												@elseif (substr($data->t15_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','2')">
												@elseif (substr($data->t15_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','2')">
												@else
													@if ($tahun."".$bulan."15" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."15" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t15_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','3')">
												@elseif (substr($data->t15_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','3')">
												@elseif (substr($data->t15_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','3')">
												@elseif (substr($data->t15_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','15','3')">
												@else
													@if ($tahun."".$bulan."15" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."15" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t16_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','1')">
												@elseif (substr($data->t16_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','1')">
												@elseif (substr($data->t16_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','1')">
												@elseif (substr($data->t16_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','1')">
												@else
													@if ($tahun."".$bulan."16" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."16" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t16_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','2')">
												@elseif (substr($data->t16_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','2')">
												@elseif (substr($data->t16_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','2')">
												@elseif (substr($data->t16_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','2')">
												@else
													@if ($tahun."".$bulan."16" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."16" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t16_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','3')">
												@elseif (substr($data->t16_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','3')">
												@elseif (substr($data->t16_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','3')">
												@elseif (substr($data->t16_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','16','3')">
												@else
													@if ($tahun."".$bulan."16" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."16" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t17_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','1')">
												@elseif (substr($data->t17_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','1')">
												@elseif (substr($data->t17_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','1')">
												@elseif (substr($data->t17_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','1')">
												@else
													@if ($tahun."".$bulan."17" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."17" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t17_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','2')">
												@elseif (substr($data->t17_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','2')">
												@elseif (substr($data->t17_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','2')">
												@elseif (substr($data->t17_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','2')">
												@else
													@if ($tahun."".$bulan."17" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."17" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t17_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','3')">
												@elseif (substr($data->t17_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','3')">
												@elseif (substr($data->t17_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','3')">
												@elseif (substr($data->t17_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','17','3')">
												@else
													@if ($tahun."".$bulan."17" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."17" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t18_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','1')">
												@elseif (substr($data->t18_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','1')">
												@elseif (substr($data->t18_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','1')">
												@elseif (substr($data->t18_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','1')">
												@else
													@if ($tahun."".$bulan."18" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."18" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t18_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','2')">
												@elseif (substr($data->t18_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','2')">
												@elseif (substr($data->t18_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','2')">
												@elseif (substr($data->t18_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','2')">
												@else
													@if ($tahun."".$bulan."18" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."18" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t18_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','3')">
												@elseif (substr($data->t18_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','3')">
												@elseif (substr($data->t18_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','3')">
												@elseif (substr($data->t18_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','18','3')">
												@else
													@if ($tahun."".$bulan."18" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."18" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t19_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','1')">
												@elseif (substr($data->t19_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','1')">
												@elseif (substr($data->t19_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','1')">
												@elseif (substr($data->t19_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','1')">
												@else
													@if ($tahun."".$bulan."19" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."19" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t19_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','2')">
												@elseif (substr($data->t19_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','2')">
												@elseif (substr($data->t19_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','2')">
												@elseif (substr($data->t19_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','2')">
												@else
													@if ($tahun."".$bulan."19" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."19" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t19_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','3')">
												@elseif (substr($data->t19_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','3')">
												@elseif (substr($data->t19_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','3')">
												@elseif (substr($data->t19_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','19','3')">
												@else
													@if ($tahun."".$bulan."19" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."19" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t20_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','1')">
												@elseif (substr($data->t20_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','1')">
												@elseif (substr($data->t20_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','1')">
												@elseif (substr($data->t20_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','1')">
												@else
													@if ($tahun."".$bulan."20" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."20" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t20_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','2')">
												@elseif (substr($data->t20_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','2')">
												@elseif (substr($data->t20_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','2')">
												@elseif (substr($data->t20_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','2')">
												@else
													@if ($tahun."".$bulan."20" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."20" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t20_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','3')">
												@elseif (substr($data->t20_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','3')">
												@elseif (substr($data->t20_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','3')">
												@elseif (substr($data->t20_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','20','3')">
												@else
													@if ($tahun."".$bulan."20" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."20" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t21_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','1')">
												@elseif (substr($data->t21_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','1')">
												@elseif (substr($data->t21_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','1')">
												@elseif (substr($data->t21_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','1')">
												@else
													@if ($tahun."".$bulan."21" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."21" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t21_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','2')">
												@elseif (substr($data->t21_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','2')">
												@elseif (substr($data->t21_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','2')">
												@elseif (substr($data->t21_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','2')">
												@else
													@if ($tahun."".$bulan."21" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."21" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t21_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','3')">
												@elseif (substr($data->t21_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','3')">
												@elseif (substr($data->t21_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','3')">
												@elseif (substr($data->t21_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','21','3')">
												@else
													@if ($tahun."".$bulan."21" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."21" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t22_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','1')">
												@elseif (substr($data->t22_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','1')">
												@elseif (substr($data->t22_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','1')">
												@elseif (substr($data->t22_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','1')">
												@else
													@if ($tahun."".$bulan."22" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."22" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t22_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','2')">
												@elseif (substr($data->t22_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','2')">
												@elseif (substr($data->t22_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','2')">
												@elseif (substr($data->t22_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','2')">
												@else
													@if ($tahun."".$bulan."22" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."22" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t22_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','3')">
												@elseif (substr($data->t22_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','3')">
												@elseif (substr($data->t22_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','3')">
												@elseif (substr($data->t22_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','22','3')">
												@else
													@if ($tahun."".$bulan."22" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."22" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t23_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','1')">
												@elseif (substr($data->t23_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','1')">
												@elseif (substr($data->t23_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','1')">
												@elseif (substr($data->t23_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','1')">
												@else
													@if ($tahun."".$bulan."23" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."23" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t23_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','2')">
												@elseif (substr($data->t23_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','2')">
												@elseif (substr($data->t23_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','2')">
												@elseif (substr($data->t23_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','2')">
												@else
													@if ($tahun."".$bulan."23" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."23" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t23_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','3')">
												@elseif (substr($data->t23_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','3')">
												@elseif (substr($data->t23_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','3')">
												@elseif (substr($data->t23_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','23','3')">
												@else
													@if ($tahun."".$bulan."23" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."23" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t24_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','1')">
												@elseif (substr($data->t24_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','1')">
												@elseif (substr($data->t24_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','1')">
												@elseif (substr($data->t24_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','1')">
												@else
													@if ($tahun."".$bulan."24" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."24" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t24_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','2')">
												@elseif (substr($data->t24_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','2')">
												@elseif (substr($data->t24_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','2')">
												@elseif (substr($data->t24_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','2')">
												@else
													@if ($tahun."".$bulan."24" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."24" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t24_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','3')">
												@elseif (substr($data->t24_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','3')">
												@elseif (substr($data->t24_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','3')">
												@elseif (substr($data->t24_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','24','3')">
												@else
													@if ($tahun."".$bulan."24" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."24" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t25_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','1')">
												@elseif (substr($data->t25_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','1')">
												@elseif (substr($data->t25_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','1')">
												@elseif (substr($data->t25_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','1')">
												@else
													@if ($tahun."".$bulan."25" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."25" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t25_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','2')">
												@elseif (substr($data->t25_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','2')">
												@elseif (substr($data->t25_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','2')">
												@elseif (substr($data->t25_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','2')">
												@else
													@if ($tahun."".$bulan."25" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."25" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t25_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','3')">
												@elseif (substr($data->t25_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','3')">
												@elseif (substr($data->t25_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','3')">
												@elseif (substr($data->t25_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','25','3')">
												@else
													@if ($tahun."".$bulan."25" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."25" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t26_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','1')">
												@elseif (substr($data->t26_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','1')">
												@elseif (substr($data->t26_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','1')">
												@elseif (substr($data->t26_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','1')">
												@else
													@if ($tahun."".$bulan."26" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."26" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t26_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','2')">
												@elseif (substr($data->t26_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','2')">
												@elseif (substr($data->t26_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','2')">
												@elseif (substr($data->t26_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','2')">
												@else
													@if ($tahun."".$bulan."26" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."26" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t26_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','3')">
												@elseif (substr($data->t26_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','3')">
												@elseif (substr($data->t26_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','3')">
												@elseif (substr($data->t26_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','26','3')">
												@else
													@if ($tahun."".$bulan."26" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."26" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t27_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','1')">
												@elseif (substr($data->t27_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','1')">
												@elseif (substr($data->t27_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','1')">
												@elseif (substr($data->t27_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','1')">
												@else
													@if ($tahun."".$bulan."27" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."27" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t27_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','2')">
												@elseif (substr($data->t27_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','2')">
												@elseif (substr($data->t27_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','2')">
												@elseif (substr($data->t27_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','2')">
												@else
													@if ($tahun."".$bulan."27" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."27" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t27_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','3')">
												@elseif (substr($data->t27_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','3')">
												@elseif (substr($data->t27_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','3')">
												@elseif (substr($data->t27_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','27','3')">
												@else
													@if ($tahun."".$bulan."27" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."27" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t28_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','1')">
												@elseif (substr($data->t28_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','1')">
												@elseif (substr($data->t28_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','1')">
												@elseif (substr($data->t28_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','1')">
												@else
													@if ($tahun."".$bulan."28" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."28" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t28_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','2')">
												@elseif (substr($data->t28_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','2')">
												@elseif (substr($data->t28_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','2')">
												@elseif (substr($data->t28_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','2')">
												@else
													@if ($tahun."".$bulan."28" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."28" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t28_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','3')">
												@elseif (substr($data->t28_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','3')">
												@elseif (substr($data->t28_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','3')">
												@elseif (substr($data->t28_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','28','3')">
												@else
													@if ($tahun."".$bulan."28" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."28" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t29_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','1')">
												@elseif (substr($data->t29_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','1')">
												@elseif (substr($data->t29_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','1')">
												@elseif (substr($data->t29_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','1')">
												@else
													@if ($tahun."".$bulan."29" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."29" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t29_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','2')">
												@elseif (substr($data->t29_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','2')">
												@elseif (substr($data->t29_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','2')">
												@elseif (substr($data->t29_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','2')">
												@else
													@if ($tahun."".$bulan."29" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."29" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t29_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','3')">
												@elseif (substr($data->t29_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','3')">
												@elseif (substr($data->t29_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','3')">
												@elseif (substr($data->t29_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','29','3')">
												@else
													@if ($tahun."".$bulan."29" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."29" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t30_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','1')">
												@elseif (substr($data->t30_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','1')">
												@elseif (substr($data->t30_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','1')">
												@elseif (substr($data->t30_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','1')">
												@else
													@if ($tahun."".$bulan."30" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."30" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t30_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','2')">
												@elseif (substr($data->t30_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','2')">
												@elseif (substr($data->t30_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','2')">
												@elseif (substr($data->t30_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','2')">
												@else
													@if ($tahun."".$bulan."30" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."30" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t30_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','3')">
												@elseif (substr($data->t30_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','3')">
												@elseif (substr($data->t30_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','3')">
												@elseif (substr($data->t30_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','30','3')">
												@else
													@if ($tahun."".$bulan."30" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."30" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t31_1,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','1')">
												@elseif (substr($data->t31_1,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','1')">
												@elseif (substr($data->t31_1,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','1')">
												@elseif (substr($data->t31_1,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','1')">
												@else
													@if ($tahun."".$bulan."31" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."31" == $tgl && $jam >= "0731")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t31_2,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','2')">
												@elseif (substr($data->t31_2,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','2')">
												@elseif (substr($data->t31_2,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','2')">
												@elseif (substr($data->t31_2,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','2')">
												@else
													@if ($tahun."".$bulan."31" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."31" == $tgl && $jam >= "1631")
															<img src="{{ asset("images/black_16.png") }}">
														@else
															<img src="{{ asset("images/white_16.png") }}">
														@endif
													@endif
												@endif
											</td>
											<td style='text-align: center'>
												@if (substr($data->t31_3,1,1) === "H")
													<img src="{{ asset("images/green_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','3')">
												@elseif (substr($data->t31_3,1,1) === "K")
													<img src="{{ asset("images/yellow_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','3')">
												@elseif (substr($data->t31_3,1,1) === "M")
													<img src="{{ asset("images/red_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','3')">
												@elseif (substr($data->t31_3,1,1) === "B")
													<img src="{{ asset("images/blue_16.png") }}" ondblclick="popup('{{ $data->kd_forklif }}','31','3')">
												@else
													@if ($tahun."".$bulan."31" < $tgl)
														<img src="{{ asset("images/black_16.png") }}">
													@else
														@if ($tahun."".$bulan."31" >= $tgl)
															<img src="{{ asset("images/white_16.png") }}">
														@else
															<img src="{{ asset("images/black_16.png") }}">
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
var urlParams = new URLSearchParams(window.location.search);
// let smartmtc = urlParams.has('type'); 
console.log(urlParams.has('type'))
if(urlParams.has('type')){
  var x = document.getElementById("btn-close");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
	//Initialize Select2 Elements
    $(".select2").select2();

    $(function() {
    	$('.freeze-table').freezeTable({
    		'columnNum' : 2,
    		'columnKeep': true,
    	});
    });

	function popup(kd_forklif, tgl, shift)
	{
		var tahun = "{{ $tahun }}";
		var bulan = "{{ $bulan }}";
		var param = tahun + "" + bulan + "" + tgl;
        var urlRedirect = "{{ route('smartmtcs.detaillch', ['param','param2','param3']) }}";
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_forklif));
        urlRedirect = urlRedirect.replace('param2', window.btoa(shift));
        urlRedirect = urlRedirect.replace('param', window.btoa(param));
        // window.location.href = urlRedirect;
    	window.open(urlRedirect, '_blank');
	}

	$('select[name="filter_status_tahun"]').change(function() {
      $('#display').click();
    });
    
    $('select[name="filter_status_bulan"]').change(function() {
      $('#display').click();
    });

    $('#display').click( function () {
      var tahun = $('select[name="filter_status_tahun"]').val();
	  var bulan = $('select[name="filter_status_bulan"]').val();
	  var urlRedirect = "{{ route('smartmtcs.monitoringlch', ['param','param2']) }}";
	  urlRedirect = urlRedirect.replace('param2', bulan);
	  urlRedirect = urlRedirect.replace('param', tahun);
	  window.location.href = urlRedirect;
    });
</script>
@endsection