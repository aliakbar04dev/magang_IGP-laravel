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
			@if (empty($qatsas->tgl))
			{!! Form::date('tgl', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('tgl', \Carbon\Carbon::parse($qatsas->tgl), ['class'=>'form-control']) !!}
			@endif
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
			{!! Form::text('part_no', null, ['class'=>'form-control', 'placeholder' => 'Part No', 'required']) !!}			
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
			{!! Form::number('qty', null, ['class'=>'form-control', 'placeholder' => 'Qty', 'required']) !!}			
			{!! $errors->first('qty', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('kd_sat', 'Satuan') !!}
			<div class="input-group">
				{!! Form::select('kd_sat', array('pcs' => 'pcs', 'unit' => 'unit'), 'pcs', ['class'=>'form-control']) !!}
				{!! $errors->first('kd_sat', '<p class="help-block">:message</p>') !!}      
			</div>
		</div>
		<div class="col-md-2">
			{!! Form::label('type_sa', 'Type of SA') !!}
			<div class="input-group">
				{!! Form::select('type_sa', array('YES' => 'YES', 'NO' => 'NO'), 'YES', ['class'=>'form-control']) !!}
				{!! $errors->first('type_sa', '<p class="help-block">:message</p>') !!}      
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('hrg_unit', 'Unit Price') !!}			
			{!! Form::number('hrg_unit', null, ['class'=>'form-control', 'placeholder' => 'Unit Price', 'required']) !!}			
			{!! $errors->first('hrg_unit', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('type_unit', 'Currency') !!}
			<div class="input-group">
				{!! Form::select('type_unit', array('Rp' => 'Rp', '$' => '$'), 'Rp', ['class'=>'form-control']) !!}
				{!! $errors->first('type_unit', '<p class="help-block">:message</p>') !!}      
			</div>
		</div>
		<div class="col-md-3">
			{!! Form::label('due_date', 'Expected Due Date Of Judgement') !!}
			@if (empty($qatsas->due_date))
			{!! Form::date('due_date', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('due_date', \Carbon\Carbon::parse($qatsas->due_date), ['class'=>'form-control']) !!}
			@endif
			{!! $errors->first('due_date', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			{!! Form::label('no_po', 'PO No') !!}			
			{!! Form::text('no_po', null, ['class'=>'form-control', 'placeholder' => 'No PO', 'required']) !!}			
			{!! $errors->first('no_po', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-3">
			{!! Form::label('tgl_kirim', 'Corrected Part Delivery Date') !!}
			@if (empty($qatsas->tgl_kirim))
			{!! Form::date('tgl_kirim', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('tgl_kirim', \Carbon\Carbon::parse($qatsas->tgl_kirim), ['class'=>'form-control']) !!}
			@endif
			{!! $errors->first('tgl_kirim', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			{!! Form::label('part_detail', 'Identification of Part') !!}			
			{!! Form::textarea('part_detail', null, ['class'=>'form-control', 'placeholder' => 'Identification of Part', 'rows' => '4']) !!}			
			{!! $errors->first('part_detail', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-6">
			{!! Form::label('problem', 'Detail Problem') !!}			
			{!! Form::textarea('problem', null, ['class'=>'form-control', 'placeholder' => 'Detail Problem', 'rows' => '4']) !!}			
			{!! $errors->first('problem', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			{!! Form::label('gambar_part', 'Part Picture (jpeg,png,jpg)') !!}
			@if (!empty($qatsas->gambar_part))
			{!! Form::file('gambar_part', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
			<p>
				<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('qatsas.deleteimagepart', base64_encode($qatsas->id)) }}"><span class="glyphicon glyphicon-remove"></span></a>
				<img src="{{ $image_part }}" alt="File Not Found" class="img-rounded img-responsive">				
			</p>
			@else
			{!! Form::file('gambar_part', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
			@endif
			{!! $errors->first('gambar_part', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-6">
			{!! Form::label('gambar_problem', 'Problem Picture (jpeg,png,jpg)') !!}
			@if (!empty($qatsas->gambar_problem))
			{!! Form::file('gambar_problem', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
			<p>
				<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('qatsas.deleteimageproblem', base64_encode($qatsas->id)) }}"><span class="glyphicon glyphicon-remove"></span></a>
				<img src="{{ $image_problem }}" alt="File Not Found" class="img-rounded img-responsive">				
			</p>
			@else
			{!! Form::file('gambar_problem', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
			@endif
			{!! $errors->first('gambar_problem', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			{!! Form::label('corrective_file', 'Corrective Action Taken (pdf)') !!}
			@if (!empty($qatsas->corrective_file))
			{!! Form::file('corrective_file', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.pdf']) !!}
			<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('qatsas.deletecorrectivefile', base64_encode($qatsas->id)) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<a data-toggle="tooltip" data-placement="top" title="Download File" href="{{ $file_corrective }}" download>Download Corrective File</a>			
			@else
			{!! Form::file('corrective_file', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.pdf']) !!}
			@endif
			{!! $errors->first('corrective_file', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-6">
			{!! Form::label('sa_approved_file', 'Approval Special Acceptance (pdf)') !!}
			@if (!empty($qatsas->sa_approved_file))
			{!! Form::file('sa_approved_file', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.pdf']) !!}
			<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('qatsas.deleteapprovedfile', base64_encode($qatsas->id)) }}"><span class="glyphicon glyphicon-remove"></span></a>
			<a data-toggle="tooltip" data-placement="top" title="Download File" href="{{ $file_approved }}" download>Download Approval File</a>
			@else
			{!! Form::file('sa_approved_file', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.pdf']) !!}
			@endif
			{!! $errors->first('sa_approved_file', '<p class="help-block">:message</p>') !!}
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-2">
			{!! Form::label('rev', 'Rev') !!}
			{!! Form::text('rev', '', ['class'=>'form-control', 'placeholder' => 'Rev', 'readonly']) !!}
			{!! $errors->first('rev', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('status', 'Status') !!}			
			{!! Form::text('status', null, ['class'=>'form-control', 'placeholder' => 'Status', 'readonly']) !!}			
			{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('remark', 'Remark') !!}			
			{!! Form::text('remark', null, ['class'=>'form-control', 'placeholder' => 'Remark', 'readonly']) !!}			
			{!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
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
	{!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}  
	&nbsp;&nbsp;	
	<a class="btn btn-default" href="{{ route('kalserti.index') }}">Cancel</a>
</div>

@section('scripts')
<script type="text/javascript">
	document.getElementById("tgl").focus();
</script>
@endsection