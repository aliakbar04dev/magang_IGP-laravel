<div class="box-body ">
	<div class="form-group">
		<div class="col-md-1">
			{!! Form::label('pt', 'PT (*)') !!}
			@if(empty($tclbr005m->pt))
			{!! Form::text('pt', 'IGP', ['class'=>'form-control','readonly']) !!}
			@else
			{!! Form::text('pt', null, ['class'=>'form-control','readonly']) !!}
			@endif
		</div>
		<div class="col-md-3">
			{!! Form::label('id_no', 'No Serial (*)') !!}
			@if(empty($idNo))
			{!! Form::text('id_no', null, ['class'=>'form-control','required']) !!}
			{!! $errors->first('id_no', '<p class="help-block">:message</p>') !!}
			@else
			{!! Form::text('id_no', $idNo, ['class'=>'form-control','required', 'readonly' => '']) !!}
			{!! $errors->first('id_no', '<p class="help-block">:message</p>') !!}
			@endif
		</div>	
		<div class="col-md-2{{ $errors->has('kd_au') ? ' has-error' : '' }}">
			{!! Form::label('kd_au', 'Jenis (F9) (*)') !!}
			@if(empty($kdAu))  
			<div class="input-group">
				{!! Form::text('kd_au', null, ['class'=>'form-control','placeholder' => 'Jenis','onkeydown' => 'btnpopupJenisClick(event)', 'onchange' => 'validateJenis()','required']) !!} 
				<span class="input-group-btn">
					<button id="btnpopupJenis" type="button" class="btn btn-info" data-toggle="modal" data-target="#jenisModal">
						<label class="glyphicon glyphicon-search"></label>
					</button>
				</span>
			</div>
			@else
			<div class="input-group">
				{!! Form::text('kd_au', $kdAu, ['class'=>'form-control','placeholder' => 'Jenis','onkeydown' => 'btnpopupJenisClick(event)', 'onchange' => 'validateJenis()','required', 'readonly' => '']) !!} 
				<span class="input-group-btn">					
				</span>
			</div>
			@endif   
			{!! $errors->first('kd_au', '<p class="help-block">:message</p>') !!}             
		</div>
		<div class="col-md-4">
			{!! Form::label('nm_au', 'Nama Jenis') !!}      
			{!! Form::text('nm_au', null, ['class'=>'form-control','placeholder' => 'Nama Jenis', 'disabled'=>'']) !!} 
		</div>
		<div class="col-md-2">
			{!! Form::label('kode', 'Tipe (*)') !!}
			<div class="input-group">
				@if(empty($kode))
				{!! Form::select('kode', ['K' => 'KALIBRASI', 'V' => 'VERIFIKASI'], 'K', ['class'=>'form-control select2','placeholder' => 'Pilih Tipe', 'required', 'id' => 'kode']) !!}  
				@else
				{!! Form::select('kode', ['K' => 'KALIBRASI', 'V' => 'VERIFIKASI'], $kode, ['class'=>'form-control select2','placeholder' => 'Pilih Tipe', 'required', 'id' => 'kode', 'readonly'=>'']) !!} 
				@endif          
				{!! $errors->first('kode', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('spec', 'Specification') !!}
			{!! Form::text('spec', null, ['class'=>'form-control']) !!}
			{!! $errors->first('spec', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-4">
			{!! Form::label('toleransi', 'Toleransi') !!}
			{!! Form::text('toleransi', null, ['class'=>'form-control']) !!}
			{!! $errors->first('toleransi', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-2">
			{!! Form::label('res', 'Resolusi') !!}
			{!! Form::text('res', null, ['class'=>'form-control']) !!}
			{!! $errors->first('res', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('satuan_res', 'Satuan Resolusi') !!}
			{!! Form::text('satuan_res', null, ['class'=>'form-control']) !!}
			{!! $errors->first('satuan_res', '<p class="help-block">:message</p>') !!}
		</div>	
		
	</div>
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('maker', 'Merk') !!}
			{!! Form::text('maker', null, ['class'=>'form-control']) !!}
			{!! $errors->first('maker', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-4">
			{!! Form::label('tipe', 'Tipe Alat Ukur') !!}
			{!! Form::text('tipe', null, ['class'=>'form-control']) !!}
			{!! $errors->first('tipe', '<p class="help-block">:message</p>') !!}
		</div>
	</div>	
	<div class="form-group">			
		<div class="col-md-4{{ $errors->has('kd_plant') ? ' has-error' : '' }}">
			{!! Form::label('kd_plant', 'Plant (*)') !!}
			<div class="input-group">
				<select id="kd_plant" name="kd_plant" class="form-control select2">
					<option value="">-</option>         
					@foreach($plants->get() as $kodePlant)
					<option value="{{$kodePlant->kd_plant}}"
						@if (!empty($tclbr005m->kd_plant))
						{{ $kodePlant->kd_plant == $tclbr005m->kd_plant ? 'selected="selected"' : '' }}
						@endif 
						>{{$kodePlant->nm_plant}}</option>      
						@endforeach
					</select>				       
				</div>
			</div>
			<div class="col-md-4{{ $errors->has('kd_line') ? ' has-error' : '' }}">
				{!! Form::label('kd_line', 'Line (F9)') !!}  
				<div class="input-group">
					{!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line','onkeydown' => 'btnpopupLineClick(event)', 'onchange' => 'validateLine()']) !!}     
					<span class="input-group-btn">
						<button id="btnpopupLine" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
							<label class="glyphicon glyphicon-search"></label>
						</button>
					</span>
				</div>
			</div>	
			<div class="col-md-4{{ $errors->has('station') ? ' has-error' : '' }}">
				{!! Form::label('station', 'Station (F9)') !!}  
				<div class="input-group">
					{!! Form::text('station', null, ['class'=>'form-control','placeholder' => 'Station','onkeydown' => 'btnpopupStationClick(event)', 'onchange' => 'validateStation()']) !!}     
					<span class="input-group-btn">
						<button id="btnpopupStation" type="button" class="btn btn-info" data-toggle="modal" data-target="#stationModal">
							<label class="glyphicon glyphicon-search"></label>
						</button>
					</span>
				</div>
			</div>	
		</div>
		<div class="form-group">
			<div class="col-md-2">
				{!! Form::label('kd_group', 'Group') !!}
				<div class="input-group">
					{!! Form::select('kd_group', ['A' => 'JAN', 'B' => 'FEB', 'C' => 'MAR', 'D' => 'APR', 'E' => 'MEI', 'F' => 'JUN', 'G' => 'JUL', 'H' => 'AGU', 'I' => 'SEP', 'J' => 'OKT', 'K' => 'NOV', 'L' => 'DES'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Group', 'id' => 'kd_group']) !!}            
					{!! $errors->first('kd_group', '<p class="help-block">:message</p>') !!}
				</div>
			</div>	
			<div class="col-md-2">
				{!! Form::label('kd_period', 'Periode') !!}
				<div class="input-group">
					{!! Form::select('kd_period', ['1B' => '1 BULAN', '1H' => '1 HARI', '2B' => '2 BULAN', '3B' => '3 BULAN', '4B' => '4 BULAN', '6B' => '6 BULAN', '1T' => '1 TAHUN', '2T' => '2 TAHUN', '3T' => '3 TAHUN', '5T' => '5 TAHUN '], null, ['class'=>'form-control select2','placeholder' => 'Pilih Periode', 'id' => 'kd_period']) !!}            
					{!! $errors->first('kd_period', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
			<div class="col-md-4">
				{!! Form::label('model', 'Model') !!}
				{!! Form::text('model', null, ['class'=>'form-control']) !!}
				{!! $errors->first('model', '<p class="help-block">:message</p>') !!}
			</div>	
			<div class="col-md-4">
				{!! Form::label('keterangan', 'Keterangan') !!}
				{!! Form::text('keterangan', null, ['class'=>'form-control']) !!}
				{!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}
			</div>	
		</div>
		<div class="form-group">
			<div class="col-md-2">
				{!! Form::label('thn_perolehan', 'Tahun') !!}	
				@if(empty($tclbr005m->thn_perolehan))		
				{!! Form::number('thn_perolehan', \Carbon\Carbon::now()->format('Y'), ['class'=>'form-control']) !!}	
				@else
				{!! Form::number('thn_perolehan', null, ['class'=>'form-control']) !!}	
				@endif		
				{!! $errors->first('thn_perolehan', '<p class="help-block">:message</p>') !!}
			</div>	
			<div class="col-md-2">
				{!! Form::label('status_aktif', 'Status Aktif') !!}
				<div class="input-group">
					{!! Form::select('status_aktif', ['T' => 'Aktif', 'F' => 'Non Aktif'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'id' => 'status_aktif']) !!}            
					{!! $errors->first('status_aktif', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
			<div class="col-md-2">
				{!! Form::label('posisi', 'Posisi') !!}
				<div class="input-group">
					{!! Form::select('posisi', ['REGULER' => 'REGULER', 'STOCK' => 'STOCK'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Posisi', 'id' => 'posisi']) !!}            
					{!! $errors->first('posisi', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
			<div class="col-md-2">
				{!! Form::label('prosedur', 'Prosedur') !!}
				{!! Form::text('prosedur', null, ['class'=>'form-control']) !!}         
				{!! $errors->first('prosedur', '<p class="help-block">:message</p>') !!}				
			</div>			
		</div>
		<div class="form-group">
			<div class="col-md-6 {{ $errors->has('lok_pict') ? ' has-error' : '' }}">
				{!! Form::label('lok_pict', 'Picture (jpeg,png,jpg)') !!}
				@if (!empty($tclbr005m->lok_pict))
				{!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
				<p>
					<img src="{{ $image_codes }}" alt="File Not Found" class="img-rounded img-responsive">
					<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('mstalatukurkal.deleteimage', [base64_encode($kode),  base64_encode($kdAu), base64_encode($idNo)]) }}"><span class="glyphicon glyphicon-remove"></span></a>
				</p>
				@else
				{!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
				@endif
				{!! $errors->first('lok_pict', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
		<!-- /.form-group -->
		<div class="form-group">
			<div class="col-md-4">
				<p class="help-block">(*) tidak boleh kosong</p>
				{!! Form::hidden('jml_tbl_detail', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_detail']) !!}
				{!! Form::hidden('jml_tbl_details', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_details']) !!}
				{!! Form::hidden('jml_tbl_detailx', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_detailx']) !!}
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
									<th style="width: 10%;">Titik Ukur</th>
									<th style="width: 88%;"></th>
								</tr>
							</thead>
							<tbody>
								@if (!empty($idNo)) 
								@foreach ($model->tclbr005mDet($idNo)->get() as $mcaltitikUkur)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td><input type='hidden' value="row-{{ $loop->iteration }}-titik_ukur"><input type='text' id="row-{{ $loop->iteration }}-titik_ukur" name="row-{{ $loop->iteration }}-titik_ukur" value='{{ $mcaltitikUkur->titik_ukur }}' size='20' maxlength='20' onchange='validateDuplicate(event)' required><input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value='0' readonly='readonly'></td>
									<td></td>
								</tr>
								@endforeach
								@endif              
							</tbody>
						</table>
					</div>
				</div>	
					<!-- /.box-body -->
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
									<th style="width: 10%;">Titik Ukur</th>
									<th style="width: 88%;"></th>
								</tr>
							</thead>
							<tbody>
								@if (!empty($idNo)) 
								@foreach ($model->tclbr005mDetOut($idNo)->get() as $mcaltitikUkurOut)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td><input type='hidden' value="row-{{ $loop->iteration }}-titik_ukurs"><input type='text' id="row-{{ $loop->iteration }}-titik_ukurs" name="row-{{ $loop->iteration }}-titik_ukurs" value='{{ $mcaltitikUkurOut->titik_ukur }}' size='20' maxlength='20' onchange='validateDuplicateOut(event)' required><input type='hidden' id="row-{{ $loop->iteration }}-ids" name="row-{{ $loop->iteration }}-ids" value='0' readonly='readonly'></td>
									<td></td>
								</tr>
								@endforeach
								@endif              
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->					
				<!-- /.box -->
				</div>
				<!-- /.box -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Detail 3</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<p>
							<button id="addRowx" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Tambah Baris"><span class="glyphicon glyphicon-plus"></span></button>
							&nbsp;&nbsp;
							<button id="removeRowx" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Baris"><span class="glyphicon glyphicon-minus"></span></button>
							&nbsp;&nbsp;
							<button id="removeAllx" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Semua Baris"><span class="glyphicon glyphicon-trash"></span></button>
						</p>
						<table id="tblDetailx" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th style="width: 2%;">No</th>
									<th style="width: 10%;">Titik Ukur</th>
									<th style="width: 88%;"></th>
								</tr>
							</thead>
							<tbody>
								@if (!empty($idNo)) 
								@foreach ($model->tclbr005mDetDep($idNo)->get() as $mcaltitikUkurDep)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td><input type='hidden' value="row-{{ $loop->iteration }}-titik_ukurx"><input type='text' id="row-{{ $loop->iteration }}-titik_ukurx" name="row-{{ $loop->iteration }}-titik_ukurx" value='{{ $mcaltitikUkurDep->titik_ukur }}' size='20' maxlength='20' onchange='validateDuplicateDep(event)' required><input type='hidden' id="row-{{ $loop->iteration }}-idx" name="row-{{ $loop->iteration }}-idx" value='0' readonly='readonly'></td>
									<td></td>
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
		@if (!empty($idNo))
		<button id="btn-delete" type="button" class="btn btn-danger">Delete</button>
		&nbsp;&nbsp;
		@endif
		<a class="btn btn-default" href="{{ route('mstalatukurkal.index') }}">Cancel</a>
	</div>

	<!-- Popup Line Modal -->
	@include('eqa.mstalatukurkal.popup.lineModal')
	<!-- Popup Jenis Modal -->
	@include('eqa.mstalatukurkal.popup.jenisModal')
	<!-- Popup Station Modal -->
	@include('eqa.mstalatukurkal.popup.stationModal')

	@section('scripts')
	<script type="text/javascript">

		document.getElementById("kd_plant").focus();
		function autoUpperCase(a){
			a.value = a.value.toUpperCase();
		} 

		function btnpopupJenisClick(e) {
			  if(e.keyCode == 120) { //F9
			  	$('#btnpopupJenis').click();
			  } else if(e.keyCode == 9) { //TAB
			  	e.preventDefault();
			  	document.getElementById('btnpopupJenis').focus();
			  }
		}

		function btnpopupLineClick(e) {
		      if(e.keyCode == 120) { //F9
		      	$('#btnpopupLine').click();
		      } else if(e.keyCode == 9) { //TAB
		      	e.preventDefault();
		      	document.getElementById('btnpopupLine').focus();
		      }
		}

		function btnpopupStationClick(e) {
		  	if(e.keyCode == 120) {
		  		$('#btnpopupStation').click();
		  	}
			 else if(e.keyCode == 9) { //TAB
			 	e.preventDefault();
			 	document.getElementById('btnpopupStation').focus();
			 }
		}

  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
  	$("#btnpopupLine").click(function(){
  		popupLine();
  	});

  	$("#btnpopupJenis").click(function(){
  		popupJenis();
  	});

  	$("#btnpopupStation").click(function(){
  		popupStation();
  	});

  	$("#btn-delete").click(function(){
  		var id_no = document.getElementById("id_no").value;
  		var kode = document.getElementById("kode").value;
  		var kd_au = document.getElementById("kd_au").value;
  		if(id_no !== "" && kode !== "" && kd_au !== "") {
  			var msg = 'Anda yakin menghapus data ini?';
  			var txt = 'No ID: ' + id_no;
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
  				var urlRedirect = "{{ route('mstalatukurkal.destroy', ['param', 'param1', 'param2']) }}";
  				urlRedirect = urlRedirect.replace('param2', window.btoa(id_no));
  				urlRedirect = urlRedirect.replace('param1', window.btoa(kd_au));
  				urlRedirect = urlRedirect.replace('param', window.btoa(kode));
  				window.location.href = urlRedirect;
  			}, function (dismiss) {

  				if (dismiss === 'cancel') {

  				}
  			})
  		}
  	});

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

  	if(counter > 0)document.getElementById("removeAll").disabled = false;
  	else document.getElementById("removeAll").disabled = true;

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

  	if(counters > 0)document.getElementById("removeAlls").disabled = false;
  	else document.getElementById("removeAlls").disabled = true;

  	$('#tblDetails tbody').on( 'click', 'tr', function () {
  		if ( $(this).hasClass('selected') ) {
  			$(this).removeClass('selected');
  			document.getElementById("removeRows").disabled = true;    
  		} else {
  			tables.$('tr.selected').removeClass('selected');
  			$(this).addClass('selected');
  			document.getElementById("removeRows").disabled = false;
		      //untuk memunculkan gambar
		      var row = tables.row('.selected').index();  
		  }
	});

	//MEMBUAT TABEL DETAIL
  	var tablex = $('#tblDetailx').DataTable({
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
  	document.getElementById("removeRowx").disabled = true;

  	var counterx = tablex.rows().count();
  	document.getElementById("jml_tbl_detailx").value = counterx;

  	if(counterx > 0)document.getElementById("removeAlls").disabled = false;
  	else document.getElementById("removeAlls").disabled = true;

  	$('#tblDetailx tbody').on( 'click', 'tr', function () {
  		if ( $(this).hasClass('selected') ) {
  			$(this).removeClass('selected');
  			document.getElementById("removeRowx").disabled = true;    
  		} else {
  			tablex.$('tr.selected').removeClass('selected');
  			$(this).addClass('selected');
  			document.getElementById("removeRowx").disabled = false;
		      //untuk memunculkan gambar
		      var row = tablex.row('.selected').index();  
		  }
	});

  	$('#addRow').on( 'click', function () {
  		counter = table.rows().count();
  		counter++;	     
  		document.getElementById("jml_tbl_detail").value = counter;
  		var id = 'row-' + counter +'-id';
  		var titik_ukur = 'row-' + counter +'-titik_ukur';
  		table.row.add([
  			counter,
  			"<input type='hidden' value=" + titik_ukur + "><input type='text' id=" + titik_ukur + " name=" + titik_ukur + " size='20' maxlength='20' onchange='validateDuplicate(event)' required><input type='hidden' id=" + id + " name=" + id + " value='0' readonly='readonly'>",
  			" "      
  			]).draw(false);
  	});

  	$('#addRows').on( 'click', function () {
  		counters = tables.rows().count();
  		counters++;	     
  		document.getElementById("jml_tbl_details").value = counters;
  		var id = 'row-' + counters +'-ids';
  		var titik_ukur = 'row-' + counters +'-titik_ukurs';
  		tables.row.add([
  			counters,
  			"<input type='hidden' value=" + titik_ukur + "><input type='text' id=" + titik_ukur + " name=" + titik_ukur + " size='20' maxlength='20' onchange='validateDuplicateOut(event)' required><input type='hidden' id=" + id + " name=" + id + " value='0' readonly='readonly'>",
  			" "      
  			]).draw(false);
	});

	$('#addRowx').on( 'click', function () {
  		counterx = tablex.rows().count();
  		counterx++;	     
  		document.getElementById("jml_tbl_detailx").value = counterx;
  		var id = 'row-' + counterx +'-idx';
  		var titik_ukur = 'row-' + counterx +'-titik_ukurx';
  		tablex.row.add([
  			counterx,
  			"<input type='hidden' value=" + titik_ukur + "><input type='text' id=" + titik_ukur + " name=" + titik_ukur + " size='20' maxlength='20' onchange='validateDuplicateDep(event)' required><input type='hidden' id=" + id + " name=" + id + " value='0' readonly='readonly'>",
  			" "      
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
	        var id_no = document.getElementById("id_no").value;
	        var titik_ukur = document.getElementById(target +'titik_ukur').value.trim();	        
	        
	        if(id_no === '') {
	        	changeId(row);
	        } else {
	        	if(titik_ukur === '') {
	        		changeId(row);
	        	}else{          
	        		swal({
	        			title: "Are you sure?",
	        			text: "Titik Ukur: " + titik_ukur,
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
					          var url = "{{ route('mstalatukurkal.hapus', ['param', 'param1'])}}";
					          url = url.replace('param',  window.btoa(id_no));
					          url = url.replace('param1', window.btoa(titik_ukur));
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
	        var id_no = document.getElementById("id_no").value;
	        var titik_ukur = document.getElementById(target +'titik_ukurs').value.trim();	        
	        
	        if(id_no === '') {
	        	changeIds(row);
	        } else {
	        	if(titik_ukur === '') {
	        		changeIds(row);
	        	}else{          
	        		swal({
	        			title: "Are you sure?",
	        			text: "Titik Ukur: " + titik_ukur,
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
					          var url = "{{ route('mstalatukurkal.hapusout', ['param', 'param1'])}}";
					          url = url.replace('param',  window.btoa(id_no));
					          url = url.replace('param1', window.btoa(titik_ukur));
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

	$('#removeRowx').click( function () {
  		var table = $('#tblDetailx').DataTable();
  		counterx = table.rows().count()-1;
  		document.getElementById("jml_tbl_detailx").value = counterx;
  		var index = table.row('.selected').index();
  		var row = index;
  		if(index == null) {
  			swal("Tidak ada data yang dipilih!", "", "warning");
  		} else {
	        var target = 'row-' + (row+1) + '-';
	        var id = document.getElementById(target +'idx').value.trim();
	        var id_no = document.getElementById("id_no").value;
	        var titik_ukur = document.getElementById(target +'titik_ukurx').value.trim();	        
	        
	        if(id_no === '') {
	        	changeIdx(row);
	        } else {
	        	if(titik_ukur === '') {
	        		changeIdx(row);
	        	}else{          
	        		swal({
	        			title: "Are you sure?",
	        			text: "Titik Ukur: " + titik_ukur,
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
					          var url = "{{ route('mstalatukurkal.hapusdepth', ['param', 'param1'])}}";
					          url = url.replace('param',  window.btoa(id_no));
					          url = url.replace('param1', window.btoa(titik_ukur));
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
					          		changeIdx(row);
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
  		var id_no = document.getElementById("id_no").value;
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
			          var url = "{{ route('mstalatukurkal.hapusdetail', 'param')}}";
			          url = url.replace('param',  window.btoa(id_no));
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
  		var id_no = document.getElementById("id_no").value;
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
			          var url = "{{ route('mstalatukurkal.hapusdetailout', 'param')}}";
			          url = url.replace('param',  window.btoa(id_no));
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

  	$('#removeAllx').click( function () {
  		var id_no = document.getElementById("id_no").value;
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
			          var url = "{{ route('mstalatukurkal.hapusdetaildepth', 'param')}}";
			          url = url.replace('param',  window.btoa(id_no));
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
			          		var table = $('#tblDetailx').DataTable();
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
	//set Nama Jenis
	var kode = document.getElementById("kd_au").value.trim();     
	if(kode !== '') {
		var url = '{{ route('datatables.validasiJenisQc', ['param']) }}';
		url = url.replace('param', window.btoa(kode));
		          //use ajax to run the check
		          $.get(url, function(result){  
		          	if(result !== 'null'){
		          		result = JSON.parse(result);
		          		document.getElementById("kd_au").value = result["kd_au"];
		          		document.getElementById("nm_au").value = result["nm_au"];
		          	} else {
		          		document.getElementById("kd_au").value = "";
		          		document.getElementById("nm_au").value = "";
		          	}
		          });      
		      }

    //POPUP LINE
    function popupLine() {
    	var myHeading = "<p>Popup Line</p>";
    	$("#lineModalLabel").html(myHeading);

    	var url = '{{ route('datatables.popupLineQcMst') }}';
    	var lookupLine = $('#lookupLine').DataTable({
    		processing: true, 
    		"oLanguage": {
    			'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    		}, 
    		serverSide: true,
    		"pagingType": "numbers",
    		ajax: url,
    		"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    		responsive: true,
    		"order": [[0, 'asc']],
    		columns: [
    		{ data: 'line', name: 'line'}
    		],
    		"bDestroy": true,
    		"initComplete": function(settings, json) {
    			$('div.dataTables_filter input').focus();
    			$('#lookupLine tbody').on( 'dblclick', 'tr', function () {
    				var dataArr = [];
    				var rows = $(this);
    				var rowData = lookupLine.rows(rows).data();
    				$.each($(rowData),function(key,value){
    					document.getElementById("kd_line").value = value["line"];
    					$('#lineModal').modal('hide');
    					validateLine();
    				});
    			});
    			$('#lineModal').on('hidden.bs.modal', function () {
    				var kode = document.getElementById("kd_line").value.trim();
    				if(kode === '') {
    					$('#kd_line').focus();
    				} else {
    					$('#station').focus();
    				}
    			});
    		},
    	});     
    }

  	//VALIDASI LINE
  	function validateLine() {
  		var kode = document.getElementById("kd_line").value.trim();     
  		if(kode !== '') {
  			var url = '{{ route('datatables.validasiLineQcMst', ['param']) }}';
  			url = url.replace('param', window.btoa(kode));
	          //use ajax to run the check
	          $.get(url, function(result){  
	          	if(result !== 'null'){
	          		result = JSON.parse(result);
	          		document.getElementById("kd_line").value = result["line"];
	          		document.getElementById("station").focus();
	          	} else {
	          		document.getElementById("kd_line").value = "";
	          		document.getElementById("kd_line").focus();
	          		swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
	          	}
	          });
	      } else {
	      	document.getElementById("kd_line").value = "";
	      }   
	  }

	//POPUP JENIS
	function popupJenis() {
		var myHeading = "<p>Popup Jenis</p>";
		$("#jenisModalLabel").html(myHeading);

		var url = '{{ route('datatables.popupJenisQc') }}';
		var lookupJenis = $('#lookupJenis').DataTable({
			processing: true, 
			"oLanguage": {
				'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
			}, 
			serverSide: true,
			"pagingType": "numbers",
			ajax: url,
			"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
			responsive: true,
			"order": [[0, 'asc']],
			columns: [
			{ data: 'kd_au', name: 'kd_au'},
			{ data: 'nm_au', name: 'nm_au'}
			],
			"bDestroy": true,
			"initComplete": function(settings, json) {
				$('div.dataTables_filter input').focus();
				$('#lookupJenis tbody').on( 'dblclick', 'tr', function () {
					var dataArr = [];
					var rows = $(this);
					var rowData = lookupJenis.rows(rows).data();
					$.each($(rowData),function(key,value){
						document.getElementById("kd_au").value = value["kd_au"];
						document.getElementById("nm_au").value = value["nm_au"];
						$('#jenisModal').modal('hide');
						validateJenis();
					});
				});
				$('#jenisModal').on('hidden.bs.modal', function () {
					var kode = document.getElementById("kd_au").value.trim();
					if(kode === '') {
						$('#kd_au').focus();
					} else {
						$('#status_aktif').focus();
					}
				});
			},
		});     
	}

  	//VALIDASI JENIS
  	function validateJenis() {
  		var kode = document.getElementById("kd_au").value.trim();     
  		if(kode !== '') {
  			var url = '{{ route('datatables.validasiJenisQc', ['param']) }}';
  			url = url.replace('param', window.btoa(kode));
          //use ajax to run the check
          $.get(url, function(result){  
          	if(result !== 'null'){
          		result = JSON.parse(result);
          		document.getElementById("kd_au").value = result["kd_au"];
          		document.getElementById("nm_au").value = result["nm_au"];
          		document.getElementById("status_aktif").focus();
          	} else {
          		document.getElementById("kd_au").value = "";
          		document.getElementById("nm_au").value = "";
          		document.getElementById("kd_au").focus();
          		swal("Jenis tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
          	}
          });
      } else {
      	document.getElementById("kd_au").value = "";
      	document.getElementById("nm_au").value = "";
      }   
    }

  	//POPUP STATION
  	function popupStation() {
  		var myHeading = "<p>Popup Station</p>";
  		$("#stationModalLabel").html(myHeading);

  		var url = '{{ route('datatables.popupStation') }}';
  		var lookupStation = $('#lookupStation').DataTable({
  			processing: true, 
  			"oLanguage": {
  				'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
  			}, 
  			serverSide: true,
  			"pagingType": "numbers",
  			ajax: url,
  			"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
  			responsive: true,
  			"order": [[0, 'asc']],
  			columns: [
  			{ data: 'station', name: 'station'}
  			],
  			"bDestroy": true,
  			"initComplete": function(settings, json) {
  				$('div.dataTables_filter input').focus();
  				$('#lookupStation tbody').on( 'dblclick', 'tr', function () {
  					var dataArr = [];
  					var rows = $(this);
  					var rowData = lookupStation.rows(rows).data();
  					$.each($(rowData),function(key,value){
  						document.getElementById("station").value = value["station"];
  						$('#stationModal').modal('hide');
  						validateStation();
  					});
  				});
  				$('#stationModal').on('hidden.bs.modal', function () {
  					var kode = document.getElementById("station").value.trim();
  					if(kode === '') {
  						$('#station').focus();
  					} else {
  						$('#model').focus();
  					}
  				});
  			},
  		});     
  	}

  	//VALIDASI STATION
	  function validateStation() {
	  		var kode = document.getElementById("station").value.trim();     
	  		if(kode !== '') {
	  			var url = '{{ route('datatables.validasiStation', ['param']) }}';
	  			url = url.replace('param', window.btoa(kode));
	          //use ajax to run the check
	          $.get(url, function(result){  
	          	if(result !== 'null'){
	          		result = JSON.parse(result);
	          		document.getElementById("station").value = result["station"];
	          		document.getElementById("model").focus();
	          	} else {
	          		document.getElementById("station").value = "";
	          		document.getElementById("station").focus();
	          		swal("Station tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
	          	}
	          });
	      } else {
	      	document.getElementById("station").value = "";
	      }   
	  }

	  function validateDuplicate(e){
		  	var id = e.target.id.replace('titik_ukur', '');
		  	var titik_ukur = document.getElementById(e.target.id).value.trim();

		  	if(titik_ukur !== '' ) {
		  		var table = $('#tblDetail').DataTable();
		  		for($i = 0; $i < table.rows().count(); $i++) {
		  			var data = table.cell($i, 1).data();
		  			var posisi = data.indexOf("titik_ukur");
		  			var target = data.substr(0, posisi);
		  			target = target.replace('<input type="hidden" value="', '');
		  			target = target.replace("<input type='hidden' value=", '');
		  			target = target.replace('<input value="', '');
		  			target = target.replace("<input value='", '');
		  			target = target.replace("<input value=", '');
		  			target = target.replace("<input value=", '');

		  			var target_titik_ukur = target +'titik_ukur';
		  			if(e.target.id !== target_titik_ukur) {
		  				var titik_ukur_temp = document.getElementById(target_titik_ukur).value.trim();
		  				if(titik_ukur_temp !== '') {
		  					if(titik_ukur_temp === titik_ukur) {
		  						$i = table.rows().count();
		  						document.getElementById(e.target.id).value = "";
		  						document.getElementById(e.target.id).focus();
		  						swal("Titik Ukur tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");     
		  					}
		  				}
		  			}
		  		}			   
		  	} 
	  }

	  function validateDuplicateOut(e){
		  	var id = e.target.id.replace('titik_ukurs', '');
		  	var titik_ukur = document.getElementById(e.target.id).value.trim();

		  	if(titik_ukur !== '' ) {
		  		var table = $('#tblDetails').DataTable();
		  		for($i = 0; $i < table.rows().count(); $i++) {
		  			var data = table.cell($i, 1).data();
		  			var posisi = data.indexOf("titik_ukurs");
		  			var target = data.substr(0, posisi);
		  			target = target.replace('<input type="hidden" value="', '');
		  			target = target.replace("<input type='hidden' value=", '');
		  			target = target.replace('<input value="', '');
		  			target = target.replace("<input value='", '');
		  			target = target.replace("<input value=", '');
		  			target = target.replace("<input value=", '');

		  			var target_titik_ukur = target +'titik_ukurs';
		  			if(e.target.id !== target_titik_ukur) {
		  				var titik_ukur_temp = document.getElementById(target_titik_ukur).value.trim();
		  				if(titik_ukur_temp !== '') {
		  					if(titik_ukur_temp === titik_ukur) {
		  						$i = table.rows().count();
		  						document.getElementById(e.target.id).value = "";
		  						document.getElementById(e.target.id).focus();
		  						swal("Titik Ukur tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");     
		  					}
		  				}
		  			}
		  		}			   
		  	} 
	  }

	  function validateDuplicateDep(e){
		  	var id = e.target.id.replace('titik_ukurx', '');
		  	var titik_ukur = document.getElementById(e.target.id).value.trim();

		  	if(titik_ukur !== '' ) {
		  		var table = $('#tblDetailx').DataTable();
		  		for($i = 0; $i < table.rows().count(); $i++) {
		  			var data = table.cell($i, 1).data();
		  			var posisi = data.indexOf("titik_ukurx");
		  			var target = data.substr(0, posisi);
		  			target = target.replace('<input type="hidden" value="', '');
		  			target = target.replace("<input type='hidden' value=", '');
		  			target = target.replace('<input value="', '');
		  			target = target.replace("<input value='", '');
		  			target = target.replace("<input value=", '');
		  			target = target.replace("<input value=", '');

		  			var target_titik_ukur = target +'titik_ukurx';
		  			if(e.target.id !== target_titik_ukur) {
		  				var titik_ukur_temp = document.getElementById(target_titik_ukur).value.trim();
		  				if(titik_ukur_temp !== '') {
		  					if(titik_ukur_temp === titik_ukur) {
		  						$i = table.rows().count();
		  						document.getElementById(e.target.id).value = "";
		  						document.getElementById(e.target.id).focus();
		  						swal("Titik Ukur tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");     
		  					}
		  				}
		  			}
		  		}			   
		  	} 
	  }

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
		  		var titik_ukur = "#row-" + $i + "-titik_ukur";
		  		var titik_ukur_new = "row-" + ($i-1) + "-titik_ukur";
		  		$(titik_ukur).attr({"id":titik_ukur_new, "name":titik_ukur_new});     
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
		  		var titik_ukur = "#row-" + $i + "-titik_ukurs";
		  		var titik_ukur_new = "row-" + ($i-1) + "-titik_ukurs";
		  		$(titik_ukur).attr({"id":titik_ukur_new, "name":titik_ukur_new});     
		  	}
			  //set ulang no tabel
			  for($i = 0; $i < table.rows().count(); $i++) {
				table.cell($i, 0).data($i +1);
			  }
			  jml_row = jml_row - 1;
			  document.getElementById("jml_tbl_details").value = jml_row;
	  }

	  function changeIdx(row) {
			var table = $('#tblDetailx').DataTable();
			table.row(row).remove().draw(false);
			var jml_row = document.getElementById("jml_tbl_detailx").value.trim();
			jml_row = Number(jml_row) + 1;
			nextRow = Number(row) + 1;
			for($i = nextRow; $i <= jml_row; $i++) {
				var id = "#row-" + $i + "-idx";
				var id_new = "row-" + ($i-1) + "-idx";
				$(id).attr({"id":id_new, "name":id_new});
				var titik_ukur = "#row-" + $i + "-titik_ukurx";
				var titik_ukur_new = "row-" + ($i-1) + "-titik_ukurx";
				$(titik_ukur).attr({"id":titik_ukur_new, "name":titik_ukur_new});     
			}
			  //set ulang no tabel
			  for($i = 0; $i < table.rows().count(); $i++) {
				table.cell($i, 0).data($i +1);
			  }
			  jml_row = jml_row - 1;
			  document.getElementById("jml_tbl_detailx").value = jml_row;
      }

</script>
@endsection