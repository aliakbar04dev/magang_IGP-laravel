<div class="box-body ">
	<div class="form-group">
		<div class="col-md-1">
			{!! Form::label('pt', 'PT (*)') !!}
			@if(empty($pt))
			{!! Form::text('pt', 'AWI', ['class'=>'form-control','readonly']) !!}
			@else
			{!! Form::text('pt', $pt, ['class'=>'form-control','readonly']) !!}
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
				{!! Form::select('kode', ['K' => 'KALIBRASI', 'V' => 'VERIFIKASI'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Tipe', 'required', 'id' => 'kode']) !!}  
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
		<div class="col-md-4">
			{!! Form::label('res', 'Resolusi') !!}
			{!! Form::text('res', null, ['class'=>'form-control']) !!}
			{!! $errors->first('res', '<p class="help-block">:message</p>') !!}
		</div>	
		
	</div>
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('maker', 'Maker') !!}
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
					{!! $errors->first('tipe', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
			<div class="col-md-2">
				{!! Form::label('posisi', 'Posisi') !!}
				<div class="input-group">
					{!! Form::select('posisi', ['REGULER' => 'REGULER', 'STOCK' => 'STOCK'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Posisi', 'id' => 'posisi']) !!}            
					{!! $errors->first('posisi', '<p class="help-block">:message</p>') !!}
				</div>
			</div>			
		</div>
		<div class="form-group">
			<div class="col-md-6 {{ $errors->has('lok_pict') ? ' has-error' : '' }}">
				{!! Form::label('lok_pict', 'Picture (jpeg,png,jpg)') !!}
				@if (!empty($tclbr005m->lok_pict))
				{!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
				<p>
					<img src="{{ $image_codes }}" alt="File Not Found" class="img-rounded img-responsive">
					<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('mstalatukur.deleteimage', [base64_encode($kode),  base64_encode($kdAu), base64_encode($idNo)]) }}"><span class="glyphicon glyphicon-remove"></span></a>
				</p>
				@else
				{!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
				@endif
				{!! $errors->first('lok_pict', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
		<!-- /.form-group -->
		<div class="form-group">
			<div class="col-md-2{{ $errors->has('remark') ? ' has-error' : '' }}">
				<p class="help-block">(*) tidak boleh kosong</p>
			</div>
		</div>			
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
		{!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
		&nbsp;&nbsp;
		<button id="btn-delete" type="button" class="btn btn-danger">Delete</button>
		&nbsp;&nbsp;
		<a class="btn btn-default" href="{{ route('mstalatukur.index') }}">Cancel</a>
	</div>

	<!-- Popup Line Modal -->
	@include('eqc.mstalatukur.popup.lineModal')
	<!-- Popup Jenis Modal -->
	@include('eqc.mstalatukur.popup.jenisModal')
	<!-- Popup Station Modal -->
	@include('eqc.mstalatukur.popup.stationModal')

	@section('scripts')
	<script type="text/javascript">

		document.getElementById("kd_plant").focus();
		function btnpopupLineClick(e) {
			if(e.keyCode == 120) {
				$('#btnpopupLine').click();
			}
		}

		function btnpopupJenisClick(e) {
			if(e.keyCode == 120) {
				$('#btnpopupJenis').click();
			}
		}  

		function btnpopupStationClick(e) {
			if(e.keyCode == 120) {
				$('#btnpopupStation').click();
			}
		} 

		function autoUpperCase(a){
			a.value = a.value.toUpperCase();
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
  				var urlRedirect = "{{ route('mstalatukur.destroy', ['param', 'param1', 'param2']) }}";
  				urlRedirect = urlRedirect.replace('param2', window.btoa(id_no));
  				urlRedirect = urlRedirect.replace('param1', window.btoa(kd_au));
  				urlRedirect = urlRedirect.replace('param', window.btoa(kode));
  				window.location.href = urlRedirect;
  			}, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
          // swal(
          //   'Cancelled',
          //   'Your imaginary file is safe :)',
          //   'error'
          // )
      }
  })
  		}
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
</script>
@endsection