<div class="box-body ">
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('kode_kons', 'Kode Konstanta') !!}
			{!! Form::text('kode_kons', null, ['class'=>'form-control','required', 'readonly']) !!}
			{!! $errors->first('kode_kons', '<p class="help-block">:message</p>') !!}					
		</div>
		<div class="col-sm-2">
			{!! Form::label('fungsi', 'Fungsi') !!}
			<div class="input-group">
				@if (empty($mcalkonstanta->fungsi))	
				{!! Form::select('fungsi', ['-' => '-', 'INSIDE' => 'INSIDE', 'OUTSIDE' => 'OUTSIDE'], null, ['class'=>'form-control select2','data-placeholder' => 'Pilih Fungsi', 'required', 'id' => 'fungsi']) !!}
				@else
				{!! Form::select('fungsi', ['-' => '-', 'INSIDE' => 'INSIDE', 'OUTSIDE' => 'OUTSIDE'], null, ['class'=>'form-control select2','data-placeholder' => 'Pilih Fungsi', 'required', 'id' => 'fungsi', 'disabled']) !!}
				@endif	
			</div>		
			{!! $errors->first('fungsi', '<p class="help-block">:message</p>') !!}
		</div>		
	</div>	
	<div class="form-group">
		<div class="col-sm-2">
			{!! Form::label('kd_au', 'Jenis (F9) (*)') !!}
			@if (empty($mcalkonstanta->kd_au))  
			<div class="input-group">
				{!! Form::text('kd_au', null, ['class'=>'form-control','placeholder' => 'Jenis','onkeydown' => 'btnpopupJenisClick(event)', 'onchange' => 'validateJenis()', 'required']) !!} 
				<span class="input-group-btn">
					<button id="btnpopupJenis" type="button" class="btn btn-info" data-toggle="modal" data-target="#jenisModal">
						<label class="glyphicon glyphicon-search"></label>
					</button>
				</span>
			</div> 
			@else
			{!! Form::text('kd_au', null, ['class'=>'form-control','placeholder' => 'Jenis', 'disabled']) !!} 
			@endif  
			{!! $errors->first('kd_au', '<p class="help-block">:message</p>') !!}             
		</div>
		<div class="col-sm-4">
			{!! Form::label('nm_au', 'Nama Jenis') !!}      
			{!! Form::text('nm_au', null, ['class'=>'form-control','placeholder' => 'Nama Jenis', 'disabled'=>'']) !!} 
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('rentang', 'Rentang Ukur (*)') !!}
			{!! Form::text('rentang', null, ['class'=>'form-control', 'required']) !!}
			{!! $errors->first('rentang', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-2">
			{!! Form::label('resolusi', 'Resolusi (*)') !!}
			{!! Form::text('resolusi', null, ['class'=>'form-control', 'required']) !!}
			{!! $errors->first('resolusi', '<p class="help-block">:message</p>') !!}
		</div>
	</div>	
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-md-4">
			<p class="help-block">(*) tidak boleh kosong</p>
		</div>
	</div>
</div>

<div class="box-body">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Detail</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">            
					<table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="width: 2%;">No</th>
								<th style="width: 15%; text-align: center">Komponen</th>
								<th style="width: 25%; text-align: center">Rumus U</th>
								<th style="width: 25%; text-align: center">Rumus Pembagi</th>
								<th style="width: 25%; text-align: center">Rumus Vi</th>
							</tr>
						</thead>
						<tbody>
							@if (!empty($mcalkonstanta->kode_kons)) 
							@foreach ($model->mcalkonstantaDet($mcalkonstanta->kode_kons)->get() as $mcalkonstantadet)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td><input type='hidden' value="row-{{ $loop->iteration }}-kode_komp"><input type='hidden' id="row-{{ $loop->iteration }}-kode_komp" name="row-{{ $loop->iteration }}-kode_komp" value="{{ $mcalkonstantadet->kode_komp }}" required><input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value='0' readonly='readonly'>
									<input type='text' id="row-{{ $loop->iteration }}-nm_komp" name="row-{{ $loop->iteration }}-nm_komp" value="{{ $model->getNamaKomponen($mcalkonstantadet->kode_komp)}}" size="30" disabled></td>
									<td><input type='text' id="row-{{ $loop->iteration }}-rumus_u" name="row-{{ $loop->iteration }}-rumus_u" value="{{ $mcalkonstantadet->rumus_u }}" size="30"></td>
									<td><input type='text' id="row-{{ $loop->iteration }}-rumus_pembagi" name="row-{{ $loop->iteration }}-rumus_pembagi" value="{{ $mcalkonstantadet->rumus_pembagi }}" size="30"></td>
									<td><input type='text' id="row-{{ $loop->iteration }}-rumus_vi" name="row-{{ $loop->iteration }}-rumus_vi" value="{{ $mcalkonstantadet->rumus_vi }}" size="30"></td>
								</tr>
								@endforeach
								@else
								@foreach ($model->mcalkomponenDet()->get() as $mcalkomponen)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td><input type='hidden' value="row-{{ $loop->iteration }}-kode_komp"><input type='hidden' id="row-{{ $loop->iteration }}-kode_komp" name="row-{{ $loop->iteration }}-kode_komp" value="{{ $mcalkomponen->kode_komp }}" required><input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value='0' readonly='readonly'>
										<input type='text' id="row-{{ $loop->iteration }}-nm_komp" name="row-{{ $loop->iteration }}-nm_komp" value="{{ $mcalkomponen->komponen}}" size="30" disabled></td>
										<td><input type='text' id="row-{{ $loop->iteration }}-rumus_u" name="row-{{ $loop->iteration }}-rumus_u" size="30"></td>
										<td><input type='text' id="row-{{ $loop->iteration }}-rumus_pembagi" name="row-{{ $loop->iteration }}-rumus_pembagi" size="30"></td>
										<td><input type='text' id="row-{{ $loop->iteration }}-rumus_vi" name="row-{{ $loop->iteration }}-rumus_vi" size="30"></td>
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
			@if (!empty($mcalkonstanta->kode_kons))
			<button id="btn-delete" type="button" class="btn btn-danger">Delete</button>
			&nbsp;&nbsp;			
			@endif
			<a class="btn btn-default" href="{{ route('konstanta.index') }}">Cancel</a>
		</div>

		<!-- Popup Jenis Modal -->
		@include('eqa.konstanta.popup.jenisModal')

		@section('scripts')
		<script type="text/javascript">

			document.getElementById("kode_kons").focus();
			
	  //Initialize Select2 Elements
	  $(".select2").select2();

	  $(document).ready(function(){
	  	$("#btnpopupJenis").click(function(){
	  		popupJenis();
	  	}); 

	  	var kode = document.getElementById("kd_au").value.trim();     
	  	if(kode !== '') {
	  		validateJenis();
	  	}
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
	  	
	  	$("#btn-delete").click(function(){
	  		var kode_kons = document.getElementById("kode_kons").value;
	  		if(kode_kons !== "") {
	  			var msg = 'Anda yakin menghapus data ini?';
	  			var txt = 'Konstanta: ' + kode_kons;
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
	  				var urlRedirect = "{{ route('konstanta.destroy', 'param') }}";
	  				urlRedirect = urlRedirect.replace('param', window.btoa(kode_kons));
	  				window.location.href = urlRedirect;
	  			}, function (dismiss) {

	  				if (dismiss === 'cancel') {

	  				}
	  			})
	  		}
	  	});

	  });

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
		 					$('#rentang').focus();
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
		            		document.getElementById("rentang").focus();
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

		    function btnpopupJenisClick(e) {
		      if(e.keyCode == 120) { //F9
		      	$('#btnpopupJenis').click();
		      } else if(e.keyCode == 9) { //TAB
		      	e.preventDefault();
		      	document.getElementById('btnpopupJenis').focus();
		      }
		  }
		</script>
		@endsection