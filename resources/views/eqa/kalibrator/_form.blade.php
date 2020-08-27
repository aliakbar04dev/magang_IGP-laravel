<div class="box-body ">
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('nomor', 'No Sertifikat (*)') !!}
			{!! Form::text('nomor', null, ['class'=>'form-control','required']) !!}
			{!! $errors->first('nomor', '<p class="help-block">:message</p>') !!}			
		</div>
		<div class="col-md-2">
			{!! Form::label('tanggal', 'Tanggal') !!}
			@if (empty($mcalkalibrator->tanggal))
			{!! Form::date('tanggal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('tanggal', \Carbon\Carbon::parse($mcalkalibrator->tanggal), ['class'=>'form-control']) !!}
			@endif
			{!! $errors->first('tanggal', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('no_order', 'No order (*)') !!}
			{!! Form::text('no_order', null, ['class'=>'form-control','required']) !!}
			{!! $errors->first('no_order', '<p class="help-block">:message</p>') !!}			
		</div>	
		<div class="col-md-4">
			{!! Form::label('nama_alat', 'Nama Kalibrator') !!}
			{!! Form::text('nama_alat', null, ['class'=>'form-control']) !!}
			{!! $errors->first('nama_alat', '<p class="help-block">:message</p>') !!}
		</div>
	</div>	
	<div class="form-group">			
		<div class="col-md-2">
			{!! Form::label('merk', 'Merk') !!}
			{!! Form::text('merk', null, ['class'=>'form-control']) !!}
			{!! $errors->first('merk', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('type', 'Tipe') !!}
			{!! Form::text('type', null, ['class'=>'form-control']) !!}
			{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-2">
			{!! Form::label('kapasitas', 'Kapasitas') !!}
			{!! Form::text('kapasitas', null, ['class'=>'form-control']) !!}
			{!! $errors->first('kapasitas', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-2">
			{!! Form::label('kecermatan', 'Kecermatan') !!}
			{!! Form::text('kecermatan', null, ['class'=>'form-control']) !!}
			{!! $errors->first('kecermatan', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-4">
			{!! Form::label('no_seri', 'No Seri (*)') !!}
			{!! Form::text('no_seri', null, ['class'=>'form-control',' required']) !!}
			{!! $errors->first('no_seri', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">		
		<div class="col-md-2">
			{!! Form::label('tgl_terima', 'Tanggal Terima') !!}
			@if (empty($mcalkalibrator->tgl_terima))
			{!! Form::date('tgl_terima', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('tgl_terima', \Carbon\Carbon::parse($mcalkalibrator->tgl_terima), ['class'=>'form-control']) !!}
			@endif
			{!! $errors->first('tgl_terima', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-2">
			{!! Form::label('tgl_kalibrasi', 'Tanggal kalibrasi') !!}
			@if (empty($mcalkalibrator->tgl_kalibrasi))
			{!! Form::date('tgl_kalibrasi', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('tgl_kalibrasi', \Carbon\Carbon::parse($mcalkalibrator->tgl_kalibrasi), ['class'=>'form-control']) !!}
			@endif
			{!! $errors->first('tgl_kalibrasi', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-2">
			{!! Form::label('prosedur', 'Prosedur') !!}
			{!! Form::text('prosedur', null, ['class'=>'form-control']) !!}
			{!! $errors->first('prosedur', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('tertelusur', 'Tertelusur') !!}
			{!! Form::text('tertelusur', null, ['class'=>'form-control']) !!}
			{!! $errors->first('tertelusur', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('temperatur', 'Temperatur') !!}
			{!! Form::text('temperatur', null, ['class'=>'form-control']) !!}
			{!! $errors->first('temperatur', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-2">
			{!! Form::label('kelembapan', 'Kelembapan') !!}
			{!! Form::text('kelembapan', null, ['class'=>'form-control']) !!}
			{!! $errors->first('kelembapan', '<p class="help-block">:message</p>') !!}
		</div>	
	</div>
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('pemilik', 'Pemilik') !!}
			{!! Form::text('pemilik', null, ['class'=>'form-control']) !!}
			{!! $errors->first('pemilik', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-4">
			{!! Form::label('alamat', 'Alamat') !!}
			{!! Form::textarea('alamat', null, ['class'=>'form-control', 'rows' => 4]) !!}
			{!! $errors->first('alamat', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-4">
			{!! Form::label('catatan', 'Catatan') !!}
			{!! Form::textarea('catatan', null, ['class'=>'form-control', 'rows' => 4]) !!}
			{!! $errors->first('catatan', '<p class="help-block">:message</p>') !!}
		</div>
	</div>	
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-md-4">
			<p class="help-block">(*) tidak boleh kosong</p>
			{!! Form::hidden('jml_tbl_detail', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_detail']) !!}
			{!! Form::hidden('jml_tbl_details', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_details']) !!}
		</div>
	</div>
</div>

<div class="box-body">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Detail 1</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">            
					@include('datatable._action-addrem')
					<table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="width: 2%;">No</th>
								<th style="width: 20%; text-align: center">Titik Ukur <br> (mm)</th>
								<th style="width: 20%; text-align: center">Koreksi <br> Arah Naik (μm)</th>
								<th style="width: 20%; text-align: center">Koreksi <br> Arah Turun (μm)</th>
								<th style="width: 20%; text-align: center">U95% = ±μm <br> (k=2.00)</th>
								<th style="width: 20%; text-align: center">Nomor <br> Identitas</th>
							</tr>
						</thead>
						<tbody>
							@if (!empty($mcalkalibrator->nomor)) 
							@foreach ($model->mcalkalibratorDet($mcalkalibrator->nomor)->get() as $mcalkalibratordet)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td><input type='hidden' value="row-{{ $loop->iteration }}-standar"><input type='text' id="row-{{ $loop->iteration }}-standar" name="row-{{ $loop->iteration }}-standar" value="{{ $mcalkalibratordet->standar }}" required><input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value='0' readonly='readonly'></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-arah_naik" name="row-{{ $loop->iteration }}-arah_naik" value="{{ $mcalkalibratordet->arah_naik }}"></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-arah_turun" name="row-{{ $loop->iteration }}-arah_turun" value="{{ $mcalkalibratordet->arah_turun }}"></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-toleransi" name="row-{{ $loop->iteration }}-toleransi" value="{{ $mcalkalibratordet->toleransi }}"></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-no_identitas" name="row-{{ $loop->iteration }}-no_identitas" value="{{ $mcalkalibratordet->no_identitas }}"></td>
							</tr>
							@endforeach
							@endif            
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Detail 2</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">            
					<p>
						<button id="addRows" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Tambah Baris"><span class="glyphicon glyphicon-plus"></span></button>
						&nbsp;&nbsp;
						<button id="removeRows" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Baris"><span class="glyphicon glyphicon-minus"></span></button>
						&nbsp;&nbsp;
						<button id="removeAlls" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Semua Baris"><span class="glyphicon glyphicon-trash"></span></button>
					</p>
					<table id="tblDetails" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="width: 2%;">No</th>
								<th style="width: 20%; text-align: center">Titik Ukur <br> (mm)</th>
								<th style="width: 20%; text-align: center">Koreksi <br> Arah Naik (μm)</th>
								<th style="width: 20%; text-align: center">Koreksi <br> Arah Turun (μm)</th>
								<th style="width: 20%; text-align: center">U95% = ±μm <br> (k=2.00)</th>
								<th style="width: 20%; text-align: center">Nomor <br> Identitas</th>
							</tr>
						</thead>
						<tbody>
							@if (!empty($mcalkalibrator->nomor)) 
							@foreach ($model->mcalkalibratorDetOut($mcalkalibrator->nomor)->get() as $mcalkalibratordetout)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td><input type='text' id="row-{{ $loop->iteration }}-standars" name="row-{{ $loop->iteration }}-standars" value="{{ $mcalkalibratordetout->standar }}" required><input type='hidden' id="row-{{ $loop->iteration }}-ids" name="row-{{ $loop->iteration }}-ids" value='0' readonly='readonly'></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-arah_naiks" name="row-{{ $loop->iteration }}-arah_naiks" value="{{ $mcalkalibratordetout->arah_naik }}"></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-arah_turuns" name="row-{{ $loop->iteration }}-arah_turuns" value="{{ $mcalkalibratordetout->arah_turun }}"></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-toleransis" name="row-{{ $loop->iteration }}-toleransis" value="{{ $mcalkalibratordetout->toleransi }}"></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-no_identitass" name="row-{{ $loop->iteration }}-no_identitass" value="{{ $mcalkalibratordetout->no_identitas }}"></td>
							</tr>
							@endforeach
							@endif            
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</div>

<!-- /.box-body -->
<div class="box-footer">
	{!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
	&nbsp;&nbsp;
	@if (!empty($mcalkalibrator->nomor))
	<button id="btn-delete" type="button" class="btn btn-danger">Delete</button>
	@endif
	&nbsp;&nbsp;
	<a class="btn btn-default" href="{{ route('kalibrator.index') }}">Cancel</a>
</div>

@section('scripts')
<script type="text/javascript">

	document.getElementById("nomor").focus();
	function autoUpperCase(a){
		a.value = a.value.toUpperCase();
	} 
	
  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
  	//MEMBUAT TABEL DETAIL
  	var table = $('#tblDetail').DataTable({
  		"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
  		"iDisplayLength": 10,
	      'searching': false,
	      'ordering': false,
	      "scrollX": "true",
	      "scrollY": "500px",
	      "scrollCollapse": true,
	      "paging": false
	 });
  	document.getElementById("removeRow").disabled = true;

  	var counter = table.rows().count();
  	document.getElementById("jml_tbl_detail").value = counter;

  	$('#tblDetail tbody').on( 'click', 'tr', function () {
  		if ( $(this).hasClass('selected') ) {
  			$(this).removeClass('selected');
  			document.getElementById("removeRow").disabled = true;      
  		} else {
  			table.$('tr.selected').removeClass('selected');
  			$(this).addClass('selected');
  			document.getElementById("removeRow").disabled = false;
			      //untuk memunculkan gambar
			      var row = table.row('.selected').index();  
			  }
	});

  	//MEMBUAT TABEL DETAIL
  	  var tables = $('#tblDetails').DataTable({
	  		"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
	  		"iDisplayLength": 10,
		      //responsive: true,
		      'searching': false,
		      'ordering': false,
		      "scrollX": "true",
		      "scrollY": "500px",
		      "scrollCollapse": true,
		      "paging": false
	  });
	  document.getElementById("removeRows").disabled = true;

	  var counters = tables.rows().count();
	  document.getElementById("jml_tbl_details").value = counters;

	$('#tblDetails tbody').on( 'click', 'tr', function () {
	  	if ( $(this).hasClass('selected') ) {
	  		$(this).removeClass('selected');
	  		document.getElementById("removeRows").disabled = true;      
	  	} else {
  		tables.$('tr.selected').removeClass('selected');
  		$(this).addClass('selected');
  		document.getElementById("removeRows").disabled = false;
		      var rows = tables.row('.selected').index();  
		}
	});

  	$("#btn-delete").click(function(){
  		var nomor = document.getElementById("nomor").value;
  		if(nomor !== "") {
  			var msg = 'Anda yakin menghapus data ini?';
  			var txt = 'Nomor Sertifikat: ' + nomor;
  			swal({
  				title: msg,
  				text: txt,
  				type: 'warning',
  				showCancelButton: true,
  				confirmButtonColor: '#3085d6',
  				cancelButtonColor: '#d33',
  				confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
  				cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
  				allowOutsideClick: true,
  				allowEscapeKey: true,
  				allowEnterKey: true,
  				reverseButtons: false,
  				focusCancel: true,
  			}).then(function () {
  				var urlRedirect = "{{ route('kalibrator.destroy', 'param') }}";
  				urlRedirect = urlRedirect.replace('param', window.btoa(nomor));
  				window.location.href = urlRedirect;
  			}, function (dismiss) {

  				if (dismiss === 'cancel') {

  				}
  			})
  		}
  	});

  	$('#addRow').on( 'click', function () {
  		counter = table.rows().count();
  		counter++;	     
  		document.getElementById("jml_tbl_detail").value = counter;
  		var id = 'row-' + counter +'-id';
  		var standar = 'row-' + counter +'-standar';
  		var arah_naik = 'row-' + counter +'-arah_naik';
  		var arah_turun = 'row-' + counter +'-arah_turun';
  		var toleransi = 'row-' + counter +'-toleransi';
  		var no_identitas = 'row-' + counter +'-no_identitas';
  		table.row.add([
  			counter,
  			"<input type='hidden' value=" + standar + "><input type='text' id=" + standar + " name=" + standar + " required><input type='hidden' id=" + id + " name=" + id + " value='0' readonly='readonly'>",
  			"<input type='text' id=" + arah_naik + " name=" + arah_naik + " required>",
  			"<input type='text' id=" + arah_turun + " name=" + arah_turun + " required>",
  			"<input type='text' id=" + toleransi + " name=" + toleransi + " required>",
  			"<input type='text' id=" + no_identitas + " name=" + no_identitas + ">"       
  			]).draw(false);
  	});

  	$('#addRows').on( 'click', function () {
		counters = tables.rows().count();
		counters++;	     
		document.getElementById("jml_tbl_details").value = counters;
		var ids = 'row-' + counters +'-ids';
		var standars = 'row-' + counters +'-standars';
		var arah_naiks = 'row-' + counters +'-arah_naiks';
		var arah_turuns = 'row-' + counters +'-arah_turuns';
		var toleransis = 'row-' + counters +'-toleransis';
		var no_identitass = 'row-' + counters +'-no_identitass';
		tables.row.add([
			counters,
			"<input type='text' id=" + standars + " name=" + standars + " required><input type='hidden' id=" + ids + " name=" + ids + " value='0' readonly='readonly'>",
			"<input type='text' id=" + arah_naiks + " name=" + arah_naiks + " required>",
			"<input type='text' id=" + arah_turuns + " name=" + arah_turuns + " required>",
			"<input type='text' id=" + toleransis + " name=" + toleransis + " required>",
			"<input type='text' id=" + no_identitass + " name=" + no_identitass + ">"       
			]).draw(false);
  	});

  	$('#removeRow').click( function () {
  		var table = $('#tblDetail').DataTable();
  		counter = table.rows().count()-1;
  		document.getElementById("jml_tbl_detail").value = counter;
  		var index = table.row('.selected').index();
  		var row = index;
  		if(index == null) {
  			swal("Tidak ada data yang dipilih!", "", "warning");
  		} else {
			        var target = 'row-' + (row+1) + '-';			        
			        var id = document.getElementById(target +'id').value.trim();
			        var nomor = document.getElementById("nomor").value;
			        var standar = document.getElementById(target +'standar').value.trim();
			        
			        
			        if(nomor === '') {
			        	changeId(row);
			        } else {
			        	if(standar === '') {
			        		changeId(row);
			        	}else{          
			        		swal({
			        			title: "Are you sure?",
			        			text: "Standar: " + standar,
			        			type: "warning",
			        			showCancelButton: true,
			        			confirmButtonColor: '#3085d6',
			        			cancelButtonColor: '#d33',
			        			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
			        			cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
			        			allowOutsideClick: true,
			        			allowEscapeKey: true,
			        			allowEnterKey: true,
			        			reverseButtons: false,
			        			focusCancel: true,
			        		}).then(function () {
			            //startcode
			            var info = "";
			            var info2 = "";
			            var info3 = "warning";

			          //DELETE DI DATABASE
			          // remove these events;
			          window.onkeydown = null;
			          window.onfocus = null;
			          var token = document.getElementsByName('_token')[0].value.trim();
			          // delete via ajax
			          // hapus data detail dengan ajax
			          var url = "{{ route('kalibrator.hapus', ['param', 'param1'])}}";
			          url = url.replace('param',  window.btoa(nomor));
			          url = url.replace('param1', window.btoa(standar));
			          $.ajax({
			          	type     : 'POST',
			          	url      : url,
			          	dataType : 'json',
			          	data     : {
			          		_method : 'GET',
			              // menambah csrf token dari Laravel
			              _token  : token
			          },
			          success:function(data){
			          	if(data.status === 'OK'){
			          		changeId(row);
			          		info = "Deleted!";
			          		info2 = data.message;
			          		info3 = "success";
			          		swal(info, info2, info3);
			          	} else {
			          		info = "Cancelled";
			          		info2 = data.message;
			          		info3 = "error";
			          		swal(info, info2, info3);
			          	}
			          }, error:function(){ 
			          	info = "System Error!";
			          	info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
			          	info3 = "error";
			          	swal(info, info2, info3);
			          }
			      });

			      }, function (dismiss) {
			      	if (dismiss === 'cancel') {
			      	}
			      })
			        	}
			        }
			    }
			});

  	$('#removeRows').click( function () {
  		var table = $('#tblDetails').DataTable();
  		counters = table.rows().count()-1;
  		document.getElementById("jml_tbl_details").value = counters;
  		var index = table.row('.selected').index();
  		var row = index;
  		if(index == null) {
  			swal("Tidak ada data yang dipilih!", "", "warning");
  		} else {
			        var target = 'row-' + (row+1) + '-';
			        target = target.replace('<input type="hidden" value="', '');
			        target = target.replace("<input type='hidden' value=", '');
			        target = target.replace('<input value="', '');
			        target = target.replace("<input value=", '');
			        target = target.replace('<input value="', '');
			        target = target.replace('<input value="', '');
			        
			        var id = document.getElementById(target +'ids').value.trim();
			        var nomor = document.getElementById("nomor").value;
			        var standar = document.getElementById(target +'standars').value.trim();
			        
			        
			        if(nomor === '') {
			        	changeIds(row);
			        } else {
			        	if(standar === '') {
			        		changeIds(row);
			        	}else{          
			        		swal({
			        			title: "Are you sure?",
			        			text: "Standar: " + standar,
			        			type: "warning",
			        			showCancelButton: true,
			        			confirmButtonColor: '#3085d6',
			        			cancelButtonColor: '#d33',
			        			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
			        			cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
			        			allowOutsideClick: true,
			        			allowEscapeKey: true,
			        			allowEnterKey: true,
			        			reverseButtons: false,
			        			focusCancel: true,
			        		}).then(function () {
			            //startcode
			            var info = "";
			            var info2 = "";
			            var info3 = "warning";

			          //DELETE DI DATABASE
			          // remove these events;
			          window.onkeydown = null;
			          window.onfocus = null;
			          var token = document.getElementsByName('_token')[0].value.trim();
			          // delete via ajax
			          // hapus data detail dengan ajax
			          var url = "{{ route('kalibrator.hapusout', ['param', 'param1'])}}";
			          url = url.replace('param',  window.btoa(nomor));
			          url = url.replace('param1', window.btoa(standar));
			          $.ajax({
			          	type     : 'POST',
			          	url      : url,
			          	dataType : 'json',
			          	data     : {
			          		_method : 'GET',
			              // menambah csrf token dari Laravel
			              _token  : token
			          },
			          success:function(data){
			          	if(data.status === 'OK'){
			          		changeIds(row);
			          		info = "Deleted!";
			          		info2 = data.message;
			          		info3 = "success";
			          		swal(info, info2, info3);
			          	} else {
			          		info = "Cancelled";
			          		info2 = data.message;
			          		info3 = "error";
			          		swal(info, info2, info3);
			          	}
			          }, error:function(){ 
			          	info = "System Error!";
			          	info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
			          	info3 = "error";
			          	swal(info, info2, info3);
			          }
			      });

			      }, function (dismiss) {
			      	if (dismiss === 'cancel') {
			      	}
			      })
			        	}
			        }
			    }
			});

  	$('#removeAll').click( function () {
  		var nomor = document.getElementById("nomor").value;
  		swal({
  			title: "Are you sure?",
  			text: "Remove All Detail",
  			type: "warning",
  			showCancelButton: true,
  			confirmButtonColor: '#3085d6',
  			cancelButtonColor: '#d33',
  			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
  			cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
  			allowOutsideClick: true,
  			allowEscapeKey: true,
  			allowEnterKey: true,
  			reverseButtons: false,
  			focusCancel: true,
  		}).then(function () {
		            //startcode
		            var info = "";
		            var info2 = "";
		            var info3 = "warning";

			          //DELETE DI DATABASE
			          // remove these events;
			          window.onkeydown = null;
			          window.onfocus = null;
			          var token = document.getElementsByName('_token')[0].value.trim();
			          // delete via ajax
			          // hapus data detail dengan ajax
			          var url = "{{ route('kalibrator.hapusdetail', 'param')}}";
			          url = url.replace('param',  window.btoa(nomor));
			          $.ajax({
			          	type     : 'POST',
			          	url      : url,
			          	dataType : 'json',
			          	data     : {
			          		_method : 'GET',
			              // menambah csrf token dari Laravel
			              _token  : token
			          },
			          success:function(data){
			          	if(data.status === 'OK'){
			          		info = "Deleted!";
			          		info2 = data.message;
			          		info3 = "success";
			          		swal(info, info2, info3);
			          		//clear tabel
			          		var table = $('#tblDetail').DataTable();
			          		table.clear().draw(false);
			          	} else {
			          		info = "Cancelled";
			          		info2 = data.message;
			          		info3 = "error";
			          		swal(info, info2, info3);
			          	}
			          }, error:function(){ 
			          	info = "System Error!";
			          	info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
			          	info3 = "error";
			          	swal(info, info2, info3);
			          }
			      });

			      }, function (dismiss) {
			      	if (dismiss === 'cancel') {
			      	}
			      })		
  	});

  	$('#removeAlls').click( function () {
  		var nomor = document.getElementById("nomor").value;
  		swal({
  			title: "Are you sure?",
  			text: "Remove All Detail",
  			type: "warning",
  			showCancelButton: true,
  			confirmButtonColor: '#3085d6',
  			cancelButtonColor: '#d33',
  			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
  			cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
  			allowOutsideClick: true,
  			allowEscapeKey: true,
  			allowEnterKey: true,
  			reverseButtons: false,
  			focusCancel: true,
  		}).then(function () {
		            //startcode
		            var info = "";
		            var info2 = "";
		            var info3 = "warning";

			          //DELETE DI DATABASE
			          // remove these events;
			          window.onkeydown = null;
			          window.onfocus = null;
			          var token = document.getElementsByName('_token')[0].value.trim();
			          // delete via ajax
			          // hapus data detail dengan ajax
			          var url = "{{ route('kalibrator.hapusdetailout', 'param')}}";
			          url = url.replace('param',  window.btoa(nomor));
			          $.ajax({
			          	type     : 'POST',
			          	url      : url,
			          	dataType : 'json',
			          	data     : {
			          		_method : 'GET',
			              // menambah csrf token dari Laravel
			              _token  : token
			          },
			          success:function(data){
			          	if(data.status === 'OK'){
			          		info = "Deleted!";
			          		info2 = data.message;
			          		info3 = "success";
			          		swal(info, info2, info3);
			          		//clear tabel
			          		var table = $('#tblDetails').DataTable();
			          		table.clear().draw(false);
			          	} else {
			          		info = "Cancelled";
			          		info2 = data.message;
			          		info3 = "error";
			          		swal(info, info2, info3);
			          	}
			          }, error:function(){ 
			          	info = "System Error!";
			          	info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
			          	info3 = "error";
			          	swal(info, info2, info3);
			          }
			      });

			      }, function (dismiss) {
			      	if (dismiss === 'cancel') {
			      	}
			      })		
  	});

  });


	function changeId(row) {
		var table = $('#tblDetail').DataTable();
		table.row(row).remove().draw(false);
		var jml_row = document.getElementById("jml_tbl_detail").value.trim();
		jml_row = Number(jml_row) + 1;
		nextRow = Number(row) + 1;
		for($i = nextRow; $i <= jml_row; $i++) {
			var id = "#row-" + $i + "-id";
			var id_new = "row-" + ($i-1) + "-id";
			$(id).attr({"id":id_new, "name":id_new});
			var standar = "#row-" + $i + "-standar";
			var standar_new = "row-" + ($i-1) + "-standar";
			$(standar).attr({"id":standar_new, "name":standar_new});
			var arah_naik = "#row-" + $i + "-arah_naik";
			var arah_naik_new = "row-" + ($i-1) + "-arah_naik";
			$(arah_naik).attr({"id":arah_naik_new, "name":arah_naik_new});
			var arah_turun = "#row-" + $i + "-arah_turun";
			var arah_turun_new = "row-" + ($i-1) + "-arah_turun";
			$(arah_turun).attr({"id":arah_turun_new, "name":arah_turun_new});
			var toleransi = "#row-" + $i + "-toleransi";
			var toleransi_new = "row-" + ($i-1) + "-toleransi";
			$(toleransi).attr({"id":toleransi_new, "name":toleransi_new}); 
			var no_identitas = "#row-" + $i + "-no_identitas";
			var no_identitas_new = "row-" + ($i-1) + "-no_identitas";
			$(no_identitas).attr({"id":no_identitas_new, "name":no_identitas_new});      
		}
		  //set ulang no tabel
		  for($i = 0; $i < table.rows().count(); $i++) {
		  	table.cell($i, 0).data($i +1);
		  }
		  jml_row = jml_row - 1;
		  document.getElementById("jml_tbl_detail").value = jml_row;
	}

	function changeIds(row) {
		var table = $('#tblDetails').DataTable();
		table.row(row).remove().draw(false);
		var jml_row = document.getElementById("jml_tbl_details").value.trim();
		jml_row = Number(jml_row) + 1;
		nextRow = Number(row) + 1;
		for($i = nextRow; $i <= jml_row; $i++) {
			var id = "#row-" + $i + "-ids";
			var id_new = "row-" + ($i-1) + "-ids";
			$(id).attr({"id":id_new, "name":id_new});
			var standar = "#row-" + $i + "-standars";
			var standar_new = "row-" + ($i-1) + "-standars";
			$(standar).attr({"id":standar_new, "name":standar_new});
			var arah_naik = "#row-" + $i + "-arah_naiks";
			var arah_naik_new = "row-" + ($i-1) + "-arah_naiks";
			$(arah_naik).attr({"id":arah_naik_new, "name":arah_naik_new});
			var arah_turun = "#row-" + $i + "-arah_turuns";
			var arah_turun_new = "row-" + ($i-1) + "-arah_turuns";
			$(arah_turun).attr({"id":arah_turun_new, "name":arah_turun_new});
			var toleransi = "#row-" + $i + "-toleransis";
			var toleransi_new = "row-" + ($i-1) + "-toleransis";
			$(toleransi).attr({"id":toleransi_new, "name":toleransi_new}); 
			var no_identitas = "#row-" + $i + "-no_identitass";
			var no_identitas_new = "row-" + ($i-1) + "-no_identitass";
			$(no_identitas).attr({"id":no_identitas_new, "name":no_identitas_new});      
		}
		  //set ulang no tabel
		  for($i = 0; $i < table.rows().count(); $i++) {
		  	table.cell($i, 0).data($i +1);
		  }
		  jml_row = jml_row - 1;
		  document.getElementById("jml_tbl_details").value = jml_row;
	}
</script>
@endsection