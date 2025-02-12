<div class="box-body ">
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('nomor', 'No Sertifikat (*)') !!}
			{!! Form::text('nomor', null, ['class'=>'form-control','required']) !!}
			{!! $errors->first('nomor', '<p class="help-block">:message</p>') !!}			
		</div>
		<div class="col-md-2">
			{!! Form::label('tanggal', 'Tanggal Kalibrasi') !!}
			@if (empty($mcaltemphumi->tanggal))
			{!! Form::date('tanggal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('tanggal', \Carbon\Carbon::parse($mcaltemphumi->tanggal), ['class'=>'form-control']) !!}
			@endif
			{!! $errors->first('tanggal', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('lokasi', 'Lokasi Kalibrasi') !!}
			{!! Form::text('lokasi', null, ['class'=>'form-control','required']) !!}
			{!! $errors->first('lokasi', '<p class="help-block">:message</p>') !!}			
		</div>			
	</div>	
	<div class="form-group">			
		<div class="col-md-4">
			{!! Form::label('kondisi', 'Kondisi Lingkungan') !!}
			{!! Form::text('kondisi', null, ['class'=>'form-control']) !!}
			{!! $errors->first('kondisi', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-4">
			{!! Form::label('jenis', 'No Seri') !!}
			{!! Form::select('jenis', ['TH01' => 'TH01', 'TH02' => 'TH02', 'TH03' => 'TH03'], null, ['class'=>'form-control select2','placeholder' => 'Pilih No Seri', 'required', 'id' => 'jenis']) !!} 
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
					<h3 class="box-title">Detail Temperature</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">            
					@include('datatable._action-addrem')
					<table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="width: 2%;">No</th>
								<th style="width: 20%; text-align: center">Standard Reading<br> (°C)</th>
								<th style="width: 20%; text-align: center">Instrument <br> (°C)</th>
								<th style="width: 20%; text-align: center">Correction <br> (°C)</th>
								<th style="width: 20%; text-align: center">Uncertainty <br> ±(°C)</th>
							</tr>
						</thead>
						<tbody>
							@if (!empty($mcaltemphumi->nomor)) 
							@foreach ($model->mcaltempDet($mcaltemphumi->nomor)->get() as $mcalsuhu)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td><input type='hidden' value="row-{{ $loop->iteration }}-standard"><input type='text' id="row-{{ $loop->iteration }}-standard" name="row-{{ $loop->iteration }}-standard" value="{{ $mcalsuhu->standard }}" required><input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value='0' readonly='readonly'></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-instrument" name="row-{{ $loop->iteration }}-instrument" value="{{ $mcalsuhu->instrument }}"></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-correction" name="row-{{ $loop->iteration }}-correction" value="{{ $mcalsuhu->correction }}"></td>
								<td><input type='text' id="row-{{ $loop->iteration }}-uncertainty" name="row-{{ $loop->iteration }}-uncertainty" value="{{ $mcalsuhu->uncertainty }}"></td>
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
					<h3 class="box-title">Detail Humidity</h3>
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
								<th style="width: 20%; text-align: center">Standard Reading<br> (%RH)</th>
								<th style="width: 20%; text-align: center">Instrument <br> (%RH)</th>
								<th style="width: 20%; text-align: center">Correction <br> (%RH)</th>
								<th style="width: 20%; text-align: center">Uncertainty <br> ±(%RH)</th>
							</tr>
						</thead>
						<tbody>
							@if (!empty($mcaltemphumi->nomor)) 
								@foreach ($model->mcalhumDet($mcaltemphumi->nomor)->get() as $mcalhumi)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td><input type='hidden' value="row-{{ $loop->iteration }}-standards"><input type='text' id="row-{{ $loop->iteration }}-standards" name="row-{{ $loop->iteration }}-standards" value="{{ $mcalhumi->standard }}" required><input type='hidden' id="row-{{ $loop->iteration }}-ids" name="row-{{ $loop->iteration }}-ids" value='0' readonly='readonly'></td>
									<td><input type='text' id="row-{{ $loop->iteration }}-instruments" name="row-{{ $loop->iteration }}-instruments" value="{{ $mcalhumi->instrument }}"></td>
									<td><input type='text' id="row-{{ $loop->iteration }}-corrections" name="row-{{ $loop->iteration }}-corrections" value="{{ $mcalhumi->correction }}"></td>
									<td><input type='text' id="row-{{ $loop->iteration }}-uncertaintys" name="row-{{ $loop->iteration }}-uncertaintys" value="{{ $mcalhumi->uncertainty }}"></td>
								</tr>
								@endforeach
							@endif 						              
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</div>

<!-- /.box-body -->
<div class="box-footer">
	{!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
	&nbsp;&nbsp;
	@if (!empty($mcaltemphumi->nomor))
	<button id="btn-delete" type="button" class="btn btn-danger">Delete</button>
	&nbsp;&nbsp;
	@endif
	<a class="btn btn-default" href="{{ route('klbrtemp.index') }}">Cancel</a>
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
		      //responsive: true,
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
			      //untuk memunculkan gambar
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
		  			var urlRedirect = "{{ route('klbrtemp.destroy', 'param') }}";
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
		  	var standard = 'row-' + counter +'-standard';
		  	var instrument = 'row-' + counter +'-instrument';
		  	var correction = 'row-' + counter +'-correction';
		  	var uncertainty = 'row-' + counter +'-uncertainty';
		  	table.row.add([
		  		counter,
		  		"<input type='text' id=" + standard + " name=" + standard + " required><input type='hidden' id=" + id + " name=" + id + " value='0' readonly='readonly'>",
		  		"<input type='text' id=" + instrument + " name=" + instrument + " required>",
		  		"<input type='text' id=" + correction + " name=" + correction + " required>",
		  		"<input type='text' id=" + uncertainty + " name=" + uncertainty + " required>"      
		  		]).draw(false);
	  });

	  $('#addRows').on( 'click', function () {
	  		counters = tables.rows().count();
		  	counters++;	     
		  	document.getElementById("jml_tbl_details").value = counters;
		  	var ids = 'row-' + counters +'-ids';
		  	var standards = 'row-' + counters +'-standards';
		  	var instruments = 'row-' + counters +'-instruments';
		  	var corrections = 'row-' + counters +'-corrections';
		  	var uncertaintys = 'row-' + counters +'-uncertaintys';
		  	tables.row.add([
		  		counters,
		  		"<input type='text' id=" + standards + " name=" + standards + " required><input type='hidden' id=" + ids + " name=" + ids + " value='0' readonly='readonly'>",
		  		"<input type='text' id=" + instruments + " name=" + instruments + " required>",
		  		"<input type='text' id=" + corrections + " name=" + corrections + " required>",
		  		"<input type='text' id=" + uncertaintys + " name=" + uncertaintys + " required>"      
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
			        var standard = document.getElementById(target +'standard').value.trim();
			        
			        
			        if(nomor === '') {
			        	changeId(row);
			        } else {
			        	if(standard === '') {
			        		changeId(row);
			        	}else{          
			        		swal({
			        			title: "Are you sure?",
			        			text: "Standard: " + standard,
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
			          var url = "{{ route('klbrtemp.hapus', ['param', 'param1'])}}";
			          url = url.replace('param',  window.btoa(nomor));
			          url = url.replace('param1', window.btoa(standard));
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
			        var id = document.getElementById(target +'ids').value.trim();
			        var nomor = document.getElementById("nomor").value;
			        var standard = document.getElementById(target +'standards').value.trim();
			        
			        
			        if(nomor === '') {
			        	changeIds(row);
			        } else {
			        	if(standard === '') {
			        		changeIds(row);
			        	}else{          
			        		swal({
			        			title: "Are you sure?",
			        			text: "Standard: " + standard,
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
			          var url = "{{ route('klbrtemp.hapusdet', ['param', 'param1'])}}";
			          url = url.replace('param',  window.btoa(nomor));
			          url = url.replace('param1', window.btoa(standard));
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
			          var url = "{{ route('klbrtemp.hapusdetail', 'param')}}";
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
			          var url = "{{ route('klbrtemp.hapusdetaildet', 'param')}}";
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
			var standard = "#row-" + $i + "-standard";
			var standard_new = "row-" + ($i-1) + "-standard";
			$(standard).attr({"id":standard_new, "name":standard_new});
			var instrument = "#row-" + $i + "-instrument";
			var instrument_new = "row-" + ($i-1) + "-instrument";
			$(instrument).attr({"id":instrument_new, "name":instrument_new});
			var correction = "#row-" + $i + "-correction";
			var correction_new = "row-" + ($i-1) + "-correction";
			$(correction).attr({"id":correction_new, "name":correction_new});
			var uncertainty = "#row-" + $i + "-uncertainty";
			var uncertainty_new = "row-" + ($i-1) + "-uncertainty";
			$(uncertainty).attr({"id":uncertainty_new, "name":uncertainty_new});       
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
			var standard = "#row-" + $i + "-standards";
			var standard_new = "row-" + ($i-1) + "-standards";
			$(standard).attr({"id":standard_new, "name":standard_new});
			var instrument = "#row-" + $i + "-instruments";
			var instrument_new = "row-" + ($i-1) + "-instruments";
			$(instrument).attr({"id":instrument_new, "name":instrument_new});
			var correction = "#row-" + $i + "-corrections";
			var correction_new = "row-" + ($i-1) + "-corrections";
			$(correction).attr({"id":correction_new, "name":correction_new});
			var uncertainty = "#row-" + $i + "-uncertaintys";
			var uncertainty_new = "row-" + ($i-1) + "-uncertaintys";
			$(uncertainty).attr({"id":uncertainty_new, "name":uncertainty_new});       
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