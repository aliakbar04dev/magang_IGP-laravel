<div class="box-body ">
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('no_doc', 'No SA') !!}
			{!! Form::text('no_doc', null, ['class'=>'form-control', 'placeholder' => 'SA No', 'required', 'readonly' => '']) !!}
			{!! Form::hidden('id', null, ['class'=>'form-control', 'id'=>'id']) !!}
			{!! $errors->first('no_doc', '<p class="help-block">:message</p>') !!}			
		</div>
		<div class="col-md-2">
			{!! Form::label('tgl', 'Date') !!}
			{!! Form::date('tgl', \Carbon\Carbon::parse($qatsas->tgl), ['class'=>'form-control', 'readonly']) !!}
			{!! $errors->first('tgl', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('kd_bpid', 'Supplier') !!}
			@if (empty($qatsas->kd_bpid))			
			{!! Form::text('kd_bpid', $supplier, ['class'=>'form-control', 'placeholder' => 'Supplier', 'required', 'readonly' => '']) !!}
			@else
			{!! Form::text('kd_bpid', null, ['class'=>'form-control', 'placeholder' => 'Supplier', 'required', 'readonly' => '']) !!}
			@endif			
			{!! $errors->first('kd_bpid', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-4">
			{!! Form::label('nm_bpid', 'Supplier Name') !!}
			@if (empty($qatsas->kd_bpid))			
			{!! Form::text('nm_bpid', $nm_supp, ['class'=>'form-control', 'placeholder' => 'Nama Supplier', 'readonly' => '']) !!}
			@else
			{!! Form::text('nm_bpid', $model->getNamaSupplier($qatsas->kd_bpid), ['class'=>'form-control', 'placeholder' => 'Nama Supplier', 'readonly' => '']) !!}
			@endif			
			{!! $errors->first('nm_bpid', '<p class="help-block">:message</p>') !!}			
		</div>	
	</div>
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('part_no', 'Part No') !!}			
			{!! Form::text('part_no', null, ['class'=>'form-control', 'placeholder' => 'Part No', 'required', 'readonly']) !!}			
			{!! $errors->first('part_no', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-4">
			{!! Form::label('part_name', 'Partname') !!}
			{!! Form::text('part_name', null, ['class'=>'form-control', 'placeholder' => 'Partname', 'readonly' => '']) !!}
			{!! $errors->first('part_name', '<p class="help-block">:message</p>') !!}			
		</div>
		<div class="col-md-3">
			{!! Form::label('part_model', 'Model') !!}
			{!! Form::text('part_model', null, ['class'=>'form-control', 'placeholder' => 'Model', 'readonly' => '']) !!}
			{!! $errors->first('part_model', '<p class="help-block">:message</p>') !!}			
		</div>
		<div class="col-md-3">
			{!! Form::label('part_brand', 'Brand') !!}
			{!! Form::text('part_brand', null, ['class'=>'form-control', 'placeholder' => 'Brand', 'readonly' => '']) !!}
			{!! $errors->first('part_brand', '<p class="help-block">:message</p>') !!}			
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('qty', 'Qty') !!}			
			{!! Form::number('qty', null, ['class'=>'form-control', 'placeholder' => 'Qty', 'required', 'readonly']) !!}			
			{!! $errors->first('qty', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('kd_sat', 'Satuan') !!}
			<div class="input-group">
				{!! Form::select('kd_sat', array('pcs' => 'pcs', 'unit' => 'unit'), 'pcs', ['class'=>'form-control', 'disabled']) !!}
				{!! $errors->first('kd_sat', '<p class="help-block">:message</p>') !!}      
			</div>
		</div>
		<div class="col-md-2">
			{!! Form::label('type_sa', 'Type of SA') !!}
			<div class="input-group">
				{!! Form::select('type_sa', array('YES' => 'YES', 'NO' => 'NO'), 'YES', ['class'=>'form-control', 'disabled']) !!}
				{!! $errors->first('type_sa', '<p class="help-block">:message</p>') !!}      
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('hrg_unit', 'Unit Price') !!}			
			{!! Form::number('hrg_unit', null, ['class'=>'form-control', 'placeholder' => 'Unit Price', 'required', 'readonly']) !!}			
			{!! $errors->first('hrg_unit', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('type_unit', 'Currency') !!}
			<div class="input-group">
				{!! Form::select('type_unit', array('Rp' => 'Rp', '$' => '$'), 'Rp', ['class'=>'form-control', 'disabled']) !!}
				{!! $errors->first('type_unit', '<p class="help-block">:message</p>') !!}      
			</div>
		</div>
		<div class="col-md-3">
			{!! Form::label('due_date', 'Expected Due Date Of Judgement') !!}
			{!! Form::date('due_date', \Carbon\Carbon::parse($qatsas->due_date), ['class'=>'form-control', 'readonly']) !!}
			{!! $errors->first('due_date', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			{!! Form::label('no_po', 'PO No') !!}			
			{!! Form::text('no_po', null, ['class'=>'form-control', 'placeholder' => 'No PO', 'required', 'readonly']) !!}			
			{!! $errors->first('no_po', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-3">
			{!! Form::label('tgl_kirim', 'Corrected Part Delivery Date') !!}
			{!! Form::date('tgl_kirim', \Carbon\Carbon::parse($qatsas->tgl_kirim), ['class'=>'form-control', 'readonly']) !!}
			{!! $errors->first('tgl_kirim', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			{!! Form::label('part_detail', 'Identification of Part') !!}			
			{!! Form::textarea('part_detail', null, ['class'=>'form-control', 'placeholder' => 'Identification of Part', 'rows' => '4', 'readonly']) !!}			
			{!! $errors->first('part_detail', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-6">
			{!! Form::label('problem', 'Detail Problem') !!}			
			{!! Form::textarea('problem', null, ['class'=>'form-control', 'placeholder' => 'Detail Problem', 'rows' => '4', 'readonly']) !!}
			{!! $errors->first('problem', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			{!! Form::label('gambar_part', 'Part Picture (jpeg,png,jpg)') !!}
			<img src="{{ $image_part }}" alt="File Not Found" class="img-rounded img-responsive" width="300px" height="150px">				
			{!! $errors->first('gambar_part', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-6">
			{!! Form::label('gambar_problem', 'Problem Picture (jpeg,png,jpg)') !!}
			<img src="{{ $image_problem }}" alt="File Not Found" class="img-rounded img-responsive" width="300px" height="150px">				
			{!! $errors->first('gambar_problem', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			{!! Form::label('corrective_file', 'Corrective Action Taken (pdf)') !!}
			<p>
				<u>
					<a data-toggle="tooltip" data-placement="top" title="Download File" href="{{ $file_corrective }}" download>Download Corrective File</a>
				</u>
			</p>	
			{!! $errors->first('corrective_file', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-6">
			{!! Form::label('sa_approved_file', 'Approval Special Acceptance (pdf)') !!}
			<p>
				<u>
					<a data-toggle="tooltip" data-placement="top" title="Download File" href="{{ $file_approved }}" download>Download Approval File</a>
				</u>
			</p>
			{!! $errors->first('sa_approved_file', '<p class="help-block">:message</p>') !!}
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('rev', 'Rev') !!}			
			{!! Form::text('rev', null, ['class'=>'form-control', 'placeholder' => 'Rev', 'readonly']) !!}
			{!! $errors->first('rev', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('dt_submit', 'Submit Date') !!}
			@if (empty($qatsas->dt_submit))
			{!! Form::text('dt_submit', null, ['class'=>'form-control', 'readonly']) !!}
			@else
			{!! Form::text('dt_submit', \Carbon\Carbon::parse($qatsas->dt_submit), ['class'=>'form-control', 'readonly']) !!}
			@endif
			{!! $errors->first('dt_submit', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('remark', 'Remark') !!}			
			{!! Form::text('remark', null, ['class'=>'form-control', 'placeholder' => 'Remark', 'readonly']) !!}			
			{!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-6">
			{!! Form::label('ket_reject', 'Keterangan Reject') !!}			
			{!! Form::textarea('ket_reject', null, ['class'=>'form-control', 'placeholder' => 'Keterangan Reject', 'rows' => '4']) !!}
			{!! $errors->first('ket_reject', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('npk_approved', 'PIC Approve') !!}     
			{!! Form::text('npk_approved', $model->getNamaKaryawan($qatsas->npk_approved), ['class'=>'form-control', 'readonly']) !!}     
			{!! $errors->first('npk_approved', '<p class="help-block">:message</p>') !!}   
		</div>
		<div class="col-md-2">
			{!! Form::label('dt_approved', 'Approve Date') !!}
			@if (empty($qatsas->dt_approved))
			{!! Form::text('dt_approved', null, ['class'=>'form-control', 'readonly']) !!}
			@else
			{!! Form::text('dt_approved', \Carbon\Carbon::parse($qatsas->dt_approved), ['class'=>'form-control', 'readonly']) !!}
			@endif
			{!! $errors->first('dt_approved', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-4">
			{!! Form::label('npk_reject', 'PIC Reject') !!}     
			{!! Form::text('npk_reject', $model->getNamaKaryawan($qatsas->npk_reject), ['class'=>'form-control', 'readonly']) !!}     
			{!! $errors->first('npk_reject', '<p class="help-block">:message</p>') !!}   
		</div>
		<div class="col-md-2">
			{!! Form::label('dt_reject', 'Reject Date') !!}
			@if (empty($qatsas->dt_reject))
			{!! Form::text('dt_reject', null, ['class'=>'form-control', 'readonly']) !!}
			@else
			{!! Form::text('dt_reject', \Carbon\Carbon::parse($qatsas->dt_reject), ['class'=>'form-control', 'readonly']) !!}
			@endif
			{!! $errors->first('dt_reject', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div>

<!-- /.box-body -->
<div class="box-footer">
	{!! Form::button('Approve', ['class'=>'btn btn-primary', 'id' => 'btn-approve']) !!}
	&nbsp;&nbsp;
	{!! Form::button('Reject', ['class'=>'btn btn-danger', 'id' => 'btn-reject']) !!}
	&nbsp;&nbsp;
	<button id="btn-print" type="button" class="btn btn-primary">Print</button>
	&nbsp;&nbsp;
	<a class="btn btn-default" href="{{ route('qatsas.indexapp') }}">Cancel</a>
</div>

@section('scripts')
<script type="text/javascript">

  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){

  	$("#btn-approve").click(function(){
  		approve('approve');
  	});

  	$("#btn-reject").click(function(){
  		approve('reject');
  	});
  	
  	$("#btn-print").click(function(){
  		printPdf();
  	});

  });

  //CETAK DOKUMEN
  function printPdf(){
	  	var param = document.getElementById("no_doc").value.trim();
	  	var param1 = document.getElementById("tgl").value.trim();

	  	var url = '{{ route('kalserti.print', ['param', 'param1']) }}';
	  	url = url.replace('param', window.btoa(param));
	  	url = url.replace('param1', window.btoa(param1));
	  	window.open(url);
  }

  function approve(status){
	  	var id = document.getElementById("id").value;
	  	var no_doc = document.getElementById("no_doc").value;
	  	var ket_reject = document.getElementById("ket_reject").value;
	  	if(ket_reject == ""){
	  		ket_reject = '-';
	  	}
	  		if(no_doc !== "") {
	  			var msg = 'Anda yakin '+status+' data ini?';
	  			var txt = 'Nomor SA: ' + no_doc;
	  			swal({
	  				title: msg,
	  				text: txt,
	  				type: 'warning',
	  				showCancelButton: true,
	  				confirmButtonColor: '#3085d6',
	  				cancelButtonColor: '#d33',
	  				confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, '+status+' it!',
	  				cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
	  				allowOutsideClick: true,
	  				allowEscapeKey: true,
	  				allowEnterKey: true,
	  				reverseButtons: false,
	  				focusCancel: true,
	  			}).then(function () {
	  				var urlRedirect = "{{ route('qatsas.approvesa', ['param','param1','param2']) }}";
	  				urlRedirect = urlRedirect.replace('param', window.btoa(id));
	  				urlRedirect = urlRedirect.replace('param1', window.btoa(status));
	  				urlRedirect = urlRedirect.replace('param2', window.btoa(ket_reject));
	  				window.location.href = urlRedirect;
	  			}, function (dismiss) {
	  				if (dismiss === 'cancel') {
	  				}
	  			})
	  		}
  }

</script>
@endsection