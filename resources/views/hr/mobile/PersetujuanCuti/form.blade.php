@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Persetujuan Cuti 
        <small>Detail Persetujuan Cuti</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('persetujuancuti.daftarpersetujuancuti') }}"><i class="glyphicon glyphicon-book"></i> Persetujuan Cuti</a></li>
        <li class="active"><i class="glyphicon glyphicon-file"></i> Detail Pengajuan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	        	<div class="box box-primary">
	        		<div class="box-header">
	        			
	        		</div>
	        		<!-- /.box-header -->
	        		<!-- Add Forms Data Here-->                   
	        		<div class="box-body"> 
                        <table class="table table-striped table-responsive">
                        	<tbody>
                        		<tr>
                        			<th width="20%">NPK</th>
                        			<td>{!! $employee->npk !!}</td> 
                        		</tr>
                        		<tr>
                        			<th>Nama Karyawan</th>
                        			<td>{!! $employee->nama !!}</td> 
                        		</tr>
                        		<tr>
                        			<th>Tanggal Pengajuan</th>
                        			<td>{!! date("d-m-Y", strtotime($status->tglpengajuan)) !!}</td>
                        		</tr>
                        		<tr>
                        			<th>Bagian</th>
                        			<td>{!! $employee->desc_dep !!} {!! $employee->desc_sie !!}</td> 
								</tr>
								<tr>
                        			<th>No Doc Cuti</th>
                        			<td>{!! $nodoccuti !!}</td> 
                        		</tr>
                        	</tbody>
						</table>

						<div class="clearfix">&nbsp;</div>
						<table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th style="width: 1%;">No</th>
									<th style="width: 5%;">TGL</th>
									<th>KD Cuti</th> 
									<th>Jenis Cuti</th>
								</tr>
							</thead>
						</table> 

					    <div class="clearfix">&nbsp;</div> 
						<center><a class="btn btn-sm btn-primary" href="{{ route('persetujuancuti.daftarpersetujuancuti') }}" id="backButton">Close</a></center>
                  	</div> 
                  	<!-- end Forms-->  
	            </div>
	            <!-- /.box-body --> 
	        </div>
	        <!-- /.box -->
	    </div>
	    <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper --> 
@endsection 
 
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){

	    var tableDetail = $('#tblMaster').DataTable({
	    	"columnDefs": [{
	    		"searchable": false,
	    		"orderable": false,
	    		"targets": 0,
	    		render: function (data, type, row, meta) {
	    			return meta.row + meta.settings._iDisplayStart + 1;
	    		}
	    	}],
	    	"bFilter": false,
	    	"iDisplayLength": 10,
	    	responsive: true, 
	    	"order": [[1, 'asc']],
	    	processing: true, 
	    	"oLanguage": {
	    		'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
	    	}, 
	    	responsive: true,
	    	bPaginate : false,
	    	"lengthChange": false,
	    	ajax: "{{  $datatablesurl }}",
	    	columns: [
		    	{data: null, name: null, orderable: false, searchable: false},  
		    	{data: 'tglcuti', name: 'tglcuti'}, 
		    	{data: 'kd_cuti', name: 'kd_cuti'},
		    	{data: 'ket', name: 'ket'} 
	    	]
	    });
	});
</script>
@endsection 