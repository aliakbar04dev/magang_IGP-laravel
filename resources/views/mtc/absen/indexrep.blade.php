@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Report Absensi Maintenance
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="{{ route('mtctabsensis.indexrep') }}"><i class="fa fa-files-o"></i>PROCUREMENT - Report - Report Absensi Maintenance</a></li>
			<li class="active">Report Absensi Maintenance</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		@include('layouts._flash')
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Cetak Report Absensi Maintenance</h3>
			</div>
			<!-- /.box-header -->

			<!-- form start -->
			{!! Form::open(['url' => route('mtctabsensis.indexrep'),
			'method' => 'post', 'files'=>'true', 'role'=>'form', 'id'=>'form_id']) !!}
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="fp">
					<div class="box-body form-horizontal">
						<div class="form-group">
							<div class="col-sm-2">
								{!! Form::label('tahun', 'Tahun') !!}
								<div class="input-group">
									@if (isset($tahun))
									{!! Form::number('tahun', $tahun, ['class'=>'form-control']) !!}
									@else
									{!! Form::number('tahun', Carbon\Carbon::now()->year, ['class'=>'form-control']) !!}
									@endif
									{!! $errors->first('tahun', '<p class="help-block">:message</p>') !!}
								</div>
							</div>
							<div class="col-sm-2">
								{!! Form::label('bulan', 'Bulan') !!}
								<div class="input-group">
									@if (isset($bulan))
									{!! Form::selectMonth('bulan', $bulan, ['class'=>'form-control']) !!}
									@else
									{!! Form::selectMonth('bulan', Carbon\Carbon::now()->month, ['class'=>'form-control']) !!}
									@endif									
									{!! $errors->first('bulan', '<p class="help-block">:message</p>') !!}       
								</div>            
							</div>							
						</div>
						<!-- /.form-group -->
						<div class="form-group">
							<div class="col-sm-2">
								{!! Form::label('kd_plant', 'Plant') !!}
								<div class="input-group">
									<select size="1" id="kd_plant" name="kd_plant" class="form-control select2">                  
										@if (isset($kd_plant))
										<option value="ALL">Pilih Plant</option>
										@foreach($plant->get() as $kode)
										<option value="{{ $kode->kd_plant }}" @if ($kode->kd_plant == $kd_plant) selected="selected" @endif>{{ $kode->nm_plant }}</option>
										@endforeach
										@else 
										<option value="ALL" selected="selected">Pilih Plant</option>
										@foreach($plant->get() as $kode)
										<option value="{{ $kode->kd_plant }}">{{ $kode->nm_plant }}</option>
										@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								{!! Form::label('lok_zona', 'Zona') !!}
								<div class="input-group">
									<select size="1" id="lok_zona" name="lok_zona" class="form-control select2">                  
										@if (isset($zona))
										<option value="ALL">Pilih Zona</option>
										<option value="0" @if ("0" == $zona) selected="selected" @endif>0</option>
										<option value="1" @if ("1" == $zona) selected="selected" @endif>1</option>
										<option value="2" @if ("2" == $zona) selected="selected" @endif>2</option>
										<option value="3" @if ("3" == $zona) selected="selected" @endif>3</option>
										@else 
										<option value="ALL" selected="selected">Pilih Zona</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										@endif
									</select>
								</div>
							</div>              
						</div>
						<!-- /.form-group -->
						<div class="form-group">
							<div class="col-md-12">
								<br>
								{!! Form::button('Proses Report Absensi', ['class'=>'btn btn-primary', 'id' => 'btn-proses']) !!}&nbsp;&nbsp;{!! Form::button('Print Report Absensi', ['class'=>'btn btn-primary', 'id' => 'btn-print']) !!}

							</div>
						</div>
					</div>
				</div>
			</div>
			@section('scripts')
			<script type="text/javascript">
				document.getElementById("tahun").focus();

				$(document).ready(function(){
					$('#btn-print').click( function () {
						printPdf();
					});
					$('#btn-proses').click( function () {
						prosesAbsen();
					});
				});

			  //CETAK DOKUMEN
			  function printPdf(){
			  	var param = document.getElementById("tahun").value;
			  	var param1 = document.getElementById("bulan").value;
			  	var param2 = document.getElementById("kd_plant").value;
			  	var param3 = document.getElementById("lok_zona").value;
			  	var textBulan = document.getElementById("bulan");
			  	var param4 = textBulan.options[textBulan.selectedIndex].text;
			  	var textPlant = document.getElementById("kd_plant");
			  	var param5 = textPlant.options[textPlant.selectedIndex].text;
			  	if(param1 < 10) {
           			param1 = "0" + param1;
         		}
			  	if(param2 ==='ALL' || param3 ==='ALL'){
			  		swal("Plant dan Zona harus dipilih!", "Perhatikan inputan anda!", "warning");
			  	}else{
			  		var url = '{{ route('mtctabsensis.print', ['param', 'param1', 'param2', 'param3', 'param4', 'param5']) }}';
			  		url = url.replace('param', window.btoa(param));
			  		url = url.replace('param1', window.btoa(param1));
			  		url = url.replace('param2', window.btoa(param2));
			  		url = url.replace('param3', window.btoa(param3));
			  		url = url.replace('param4', window.btoa(param4));
			  		url = url.replace('param5', window.btoa(param5));
			  		window.open(url);
			  	}
			  }

			  //CETAK DOKUMEN
			  function prosesAbsen(){
			  	var param = document.getElementById("tahun").value;
			  	var param1 = document.getElementById("bulan").value;
			  	var param2 = document.getElementById("kd_plant").value;
			  	var param3 = document.getElementById("lok_zona").value;
			  	if(param1 < 10) {
           			param1 = "0" + param1;
         		}
			  	if(param2 ==='ALL' || param3 ==='ALL'){
			  		swal("Plant dan Zona harus dipilih!", "Perhatikan inputan anda!", "warning");
			  	}else{
			  		var url = '{{ route('mtctabsensis.prosesabsen', ['param', 'param1', 'param2', 'param3']) }}';
			  		url = url.replace('param', window.btoa(param));
			  		url = url.replace('param1', window.btoa(param1));
			  		url = url.replace('param2', window.btoa(param2));
			  		url = url.replace('param3', window.btoa(param3));
			  		window.location.href = url;
			  	}
			  }
			</script>
			@endsection
			{!! Form::close() !!}
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection