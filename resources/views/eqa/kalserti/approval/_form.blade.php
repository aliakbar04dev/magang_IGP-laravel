<div class="box-body ">
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('no_serti', 'No Sertifikat') !!}
			{!! Form::text('no_serti', null, ['class'=>'form-control', 'placeholder' => 'No Sertifikat', 'required', 'readonly' => '']) !!}
			{!! $errors->first('no_serti', '<p class="help-block">:message</p>') !!}			
		</div>
		<div class="col-md-2">
			{!! Form::label('tgl_serti', 'Tanggal Sertifikat') !!}
			{!! Form::date('tgl_serti', \Carbon\Carbon::parse($mcalserti->tgl_serti), ['class'=>'form-control', 'disabled']) !!}
			{!! $errors->first('tgl_serti', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('no_ws', 'No Worksheet') !!} 
			{!! Form::text('no_ws', null, ['class'=>'form-control', 'placeholder' => 'No Worksheet', 'required', 'readonly' => '']) !!}
			{!! $errors->first('no_ws', '<p class="help-block">:message</p>') !!}			
		</div>		
	</div>
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('no_wdo', 'No Order') !!} 
			{!! Form::text('no_wdo', null, ['class'=>'form-control', 'placeholder' => 'No Order', 'required', 'readonly' => '']) !!}
			{!! $errors->first('no_wdo', '<p class="help-block">:message</p>') !!}			
		</div>	
		<div class="col-md-2">
			{!! Form::label('tgl_kalibrasi', 'Tanggal Kalibrasi') !!}
			{!! Form::date('tgl_kalibrasi', \Carbon\Carbon::parse($mcalserti->tgl_kalibrasi), ['class'=>'form-control', 'disabled']) !!}
			{!! $errors->first('tgl_kalibrasi', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-4">
			{!! Form::label('lab_pelaksana', 'Lab Pelaksana') !!}
			{!! Form::text('lab_pelaksana', 'PT. INTI GANDA PERDANA', ['class'=>'form-control','required', 'readonly' => '']) !!}
			{!! $errors->first('lab_pelaksana', '<p class="help-block">:message</p>') !!}			
		</div>		
	</div>
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('no_seri', 'No Seri') !!}			
			{!! Form::text('no_seri', null, ['class'=>'form-control', 'placeholder' => 'No Seri', 'required', 'readonly' => '']) !!}			
			{!! $errors->first('no_seri', '<p class="help-block">:message</p>') !!}			
		</div>
		<div class="col-md-2">
			{!! Form::label('kd_brg', 'Kode Barang') !!}
			{!! Form::text('kd_brg', null, ['class'=>'form-control', 'placeholder' => 'Kode Barang', 'readonly' => '']) !!}
			{!! $errors->first('kd_brg', '<p class="help-block">:message</p>') !!}			
		</div>
		<div class="col-md-4">
			{!! Form::label('nm_alat', 'Nama Alat') !!}
			{!! Form::text('nm_alat', null, ['class'=>'form-control', 'placeholder' => 'Nama Alat', 'readonly' => '']) !!}
			{!! $errors->first('nm_alat', '<p class="help-block">:message</p>') !!}			
		</div>		
	</div>
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('nm_type', 'Tipe') !!}
			{!! Form::text('nm_type', null, ['class'=>'form-control', 'placeholder' => 'Tipe', 'readonly' => '']) !!}
			{!! $errors->first('nm_type', '<p class="help-block">:message</p>') !!}			
		</div>
		<div class="col-md-2">
			{!! Form::label('nm_merk', 'Merk') !!}
			{!! Form::text('nm_merk', null, ['class'=>'form-control', 'placeholder' => 'Merk', 'readonly' => '']) !!}
			{!! $errors->first('nm_merk', '<p class="help-block">:message</p>') !!}			
		</div>		
	</div>
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('kd_cust', 'Customer') !!}			
			{!! Form::text('kd_cust', null, ['class'=>'form-control', 'placeholder' => 'Customer', 'required', 'readonly' => '']) !!}			
			{!! $errors->first('kd_cust', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-4">
			{!! Form::label('nm_cust', 'Nama Customer') !!}
			{!! Form::text('nm_cust', null, ['class'=>'form-control', 'placeholder' => 'Nama Customer', 'readonly' => '']) !!}
			{!! $errors->first('nm_cust', '<p class="help-block">:message</p>') !!}			
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('alamat', 'Alamat') !!}
			{!! Form::textarea('alamat', null, ['class'=>'form-control', 'placeholder' => 'Alamat', 'rows' => '3', 'maxlength' => 125, 'readonly' => '']) !!}
			{!! $errors->first('alamat', '<p class="help-block">:message</p>') !!}			
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('lain2x', 'Lain-Lain') !!}
			{!! Form::textarea('lain2x', null, ['class'=>'form-control', 'placeholder' => 'Lain-Lain', 'rows' => '3', 'maxlength' => 100, 'readonly']) !!}
			{!! $errors->first('lain2x', '<p class="help-block">:message</p>') !!}			
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('npk_autorisasi', 'PIC Autorisasi') !!}     
			{!! Form::text('npk_autorisasi', $model->getNamaKaryawan($mcalserti->npk_autorisasi), ['class'=>'form-control', 'readonly']) !!}     
			{!! $errors->first('npk_autorisasi', '<p class="help-block">:message</p>') !!}   
		</div>
		<div class="col-md-2">
			{!! Form::label('tgl_autorisasi', 'Tanggal Autorisasi') !!}
			@if (empty($mcalserti->tgl_autorisasi))
			{!! Form::text('tgl_autorisasi', null, ['class'=>'form-control', 'readonly']) !!}
			@else
			{!! Form::text('tgl_autorisasi', \Carbon\Carbon::parse($mcalserti->tgl_autorisasi), ['class'=>'form-control', 'readonly']) !!}
			@endif
			{!! $errors->first('tgl_autorisasi', '<p class="help-block">:message</p>') !!}
		</div>
	</div>		

	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-md-4">
			<p class="help-block">(*) tidak boleh kosong</p>
		</div>
	</div>
</div>

<!-- /.box-body -->
<div class="box-footer">
	@if (empty($mcalserti->npk_autorisasi))
	{!! Form::button('Autorisasi', ['class'=>'btn btn-primary', 'id' => 'btn-approve']) !!}
	@else
	{!! Form::button('Batal Autorisasi', ['class'=>'btn btn-primary', 'id' => 'btn-unlock']) !!}
	@endif
	&nbsp;&nbsp;
	<button id="btn-print" type="button" class="btn btn-primary">Print Setifikat</button>
	&nbsp;&nbsp;
	<a class="btn btn-default" href="{{ route('kalserti.indexapp') }}">Cancel</a>
</div>

@section('scripts')
<script type="text/javascript">

	document.getElementById("btn-print").focus();
  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
  	
  	$("#btn-approve").click(function(){
  		var no_serti = document.getElementById("no_serti").value;
  		if(no_serti !== "") {
  			var msg = 'Anda yakin approve data ini?';
  			var txt = 'Nomor Sertifikat: ' + no_serti;
  			swal({
  				title: msg,
  				text: txt,
  				type: 'warning',
  				showCancelButton: true,
  				confirmButtonColor: '#3085d6',
  				cancelButtonColor: '#d33',
  				confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, Authorize it!',
  				cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
  				allowOutsideClick: true,
  				allowEscapeKey: true,
  				allowEnterKey: true,
  				reverseButtons: false,
  				focusCancel: true,
  			}).then(function () {
  				var urlRedirect = "{{ route('kalserti.approveserti', ['param','param1']) }}";
  				urlRedirect = urlRedirect.replace('param', window.btoa(no_serti));
  				urlRedirect = urlRedirect.replace('param1', window.btoa('approve'));
  				window.location.href = urlRedirect;
  			}, function (dismiss) {
  				if (dismiss === 'cancel') {
  				}
  			})
  		}
  	});

  	$("#btn-unlock").click(function(){
  		var no_serti = document.getElementById("no_serti").value;
  		if(no_serti !== "") {
  			var msg = 'Anda yakin membatalkan autorisasi data ini?';
  			var txt = 'Nomor Sertifikat: ' + no_serti;
  			swal({
  				title: msg,
  				text: txt,
  				type: 'warning',
  				showCancelButton: true,
  				confirmButtonColor: '#3085d6',
  				cancelButtonColor: '#d33',
  				confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes',
  				cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
  				allowOutsideClick: true,
  				allowEscapeKey: true,
  				allowEnterKey: true,
  				reverseButtons: false,
  				focusCancel: true,
  			}).then(function () {
  				var urlRedirect = "{{ route('kalserti.approveserti', ['param','param1']) }}";
  				urlRedirect = urlRedirect.replace('param', window.btoa(no_serti));
  				urlRedirect = urlRedirect.replace('param1', window.btoa('unlock'));
  				window.location.href = urlRedirect;
  			}, function (dismiss) {
  				if (dismiss === 'cancel') {
  				}
  			})
  		}
  	});

  	$("#btn-print").click(function(){
  		printPdf();
  	});

  });

  //CETAK DOKUMEN
  function printPdf(){
  	var param = document.getElementById("no_serti").value.trim();;
  	var param1 = document.getElementById("no_ws").value.trim();

  	var url = '{{ route('kalserti.print', ['param', 'param1']) }}';
  	url = url.replace('param', window.btoa(param));
  	url = url.replace('param1', window.btoa(param1));
  	window.open(url);
  }

</script>
@endsection