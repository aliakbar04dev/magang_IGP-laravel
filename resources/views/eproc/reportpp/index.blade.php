@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Monitoring PP BAAN
        <small>Monitoring PP BAAN</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - REPORT - PP</li>
        <li class="active"><i class="fa fa-files-o"></i> Monitoring PP</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
      	<div class="box box-primary">
	        <div class="box-header with-border">
	          <h3 class="box-title">FILTER</h3>
	        </div>
	        <!-- /.box-header -->
	        <div class="box-body form-horizontal">
	        	<div class="form-group">
	        		<div class="col-sm-3">
	        			{!! Form::label('lblawal', 'Tgl Awal') !!}
	        			{!! Form::date('periode_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'periode_awal']) !!}
	        		</div>
	        		<div class="col-sm-3">
	        			{!! Form::label('lblakhir', 'Tgl Akhir') !!}
	        			{!! Form::date('periode_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'periode_akhir']) !!}
	        		</div>
	        	</div>
	        	<!-- /.form-group -->
	        	<div class="form-group">
	        		<div class="col-sm-6">
	        			{!! Form::label('lbldep', 'Departemen') !!}
	        			<select name="filter_dep" aria-controls="filter_status" class="form-control select2">
	        				<option value="ALL" selected="selected">ALL</option>
	        				@foreach($deps->get() as $dep)
	        					<option value="{{ $dep->kodedep }}">{{ $dep->kodedep }} - {{ $dep->namadep }}</option>
	        				@endforeach
	        			</select>
	        		</div>
	        		<div class="col-sm-2">
	        			{!! Form::label('lblusername2', 'Action') !!}
	        			<button id="btn-print" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print Report PP">Print Report PP</button>
	        		</div>
	        	</div>
	        	<!-- /.form-group -->
			</div>
			<!-- /.box-body -->
	  	</div>
	  	<!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
	document.getElementById("periode_awal").focus();
	//Initialize Select2 Elements
	$(".select2").select2();

	$(document).ready(function(){
		$('#btn-print').click( function () {
			printPdf();
		});
	});

	//CETAK DOKUMEN
	function printPdf(){
		var param = document.getElementById("periode_awal").value;
		var param1 = document.getElementById("periode_akhir").value;
		var param2 = $('select[name="filter_dep"]').val();

		var urlRedirect = '{{ route('reportpp.print', ['param', 'param1', 'param2']) }}';
		urlRedirect = urlRedirect.replace('param2', window.btoa(param2));
		urlRedirect = urlRedirect.replace('param1', window.btoa(param1));
		urlRedirect = urlRedirect.replace('param', window.btoa(param));
		window.open(urlRedirect, '_blank');
	}
</script>
@endsection