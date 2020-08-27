<div class="box-body">
	<div class="form-group" style="display:none;">
		<div class="col-md-2{{ $errors->has('no_serial') ? ' has-error' : '' }}">
			{!! Form::label('no_serial', 'No Serial:') !!}
			{!! Form::text('no_serial', $noSerial, ['class'=>'form-control','readonly'=>'']) !!}
			{!! $errors->first('no_serial', '<p class="help-block">:message</p>') !!}
		</div>	
		<div class="col-md-2{{ $errors->has('kd_plant') ? ' has-error' : '' }}">
			{!! Form::label('kd_plant', 'Kode Plant:') !!}
			{!! Form::text('kd_plant', $kdPlant, ['class'=>'form-control','readonly'=>'']) !!}
			{!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
		</div>
	</div>		
	<div class="form-group">
		<div class="col-md-2{{ $errors->has('no_order') ? ' has-error' : '' }}">
			{!! Form::label('no_order', 'No Order:') !!}
			{!! Form::text('no_order', null, ['class'=>'form-control']) !!}
			{!! $errors->first('no_order', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('tgl_update') ? ' has-error' : '' }}">
			{!! Form::label('tgl_update', 'Tgl Order:') !!}
			@if (empty($tglUpdate))
			{!! Form::date('tgl_update', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('tgl_update', \Carbon\Carbon::parse($tglUpdate), ['class'=>'form-control','readonly'=>'']) !!}
			@endif
			{!! $errors->first('tgl_update', '<p class="help-block">:message</p>') !!}
		</div>		
	</div>	
	<div class="form-group">
		<div class="col-md-2{{ $errors->has('no_sertifikat') ? ' has-error' : '' }}">
			{!! Form::label('no_sertifikat', 'No Sertifikat:') !!}
			{!! Form::text('no_sertifikat', null, ['class'=>'form-control']) !!}
			{!! $errors->first('no_sertifikat', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('st_ok') ? ' has-error' : '' }}">
			{!! Form::label('st_ok', 'Status OK:') !!}
			@if (empty($tclbr001t->st_ok))
			{!! Form::select('st_ok', array('1' => 'OK', '2' => 'REJECT', '3' => 'REPAIR', '4' => 'ACCEPT'), null, ['class'=>'form-control']) !!}
			@else 
				@if ($tclbr001t->st_ok == "1")
				{!! Form::select('st_ok', array('1' => 'OK', '2' => 'REJECT', '3' => 'REPAIR', '4' => 'ACCEPT'), '1', ['class'=>'form-control']) !!}
				@elseif ($tclbr001t->st_ok == "2")
				{!! Form::select('st_ok', array('1' => 'OK', '2' => 'REJECT', '3' => 'REPAIR', '4' => 'ACCEPT'), '2', ['class'=>'form-control']) !!}
				@elseif ($tclbr001t->st_ok == "3")
				{!! Form::select('st_ok', array('1' => 'OK', '2' => 'REJECT', '3' => 'REPAIR', '4' => 'ACCEPT'), '3', ['class'=>'form-control']) !!}
				@else
				{!! Form::select('st_ok', array('1' => 'OK', '2' => 'REJECT', '3' => 'REPAIR', '4' => 'ACCEPT'), '4', ['class'=>'form-control']) !!}
				@endif
			@endif
			
			{!! $errors->first('st_ok', '<p class="help-block">:message</p>') !!}
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-2{{ $errors->has('tgl_next_kal') ? ' has-error' : '' }}">
			{!! Form::label('tgl_next_kal', 'Tgl Next Kalibrasi:') !!}
			@if (empty($tclbr001t->tgl_next_kal))
			{!! Form::date('tgl_next_kal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('tgl_next_kal', \Carbon\Carbon::parse($tclbr001t->tgl_next_kal), ['class'=>'form-control','readonly'=>'']) !!}
			@endif
			{!! $errors->first('tgl_next_kal', '<p class="help-block">:message</p>') !!}
		</div>		
	</div>	
	<div class="form-group">
		<div class="col-md-3{{ $errors->has('nm_ket_update') ? ' has-error' : '' }}">
			{!! Form::label('nm_ket_update', 'Keterangan:') !!}
			{!! Form::textarea('nm_ket_update', null, ['class'=>'form-control']) !!}			
			{!! $errors->first('nm_ket_update', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-1">
			{!! Form::label('st_kal', 'Kalibrasi:') !!}
			@if (empty($tclbr001t->st_kal))
			{!! Form::checkbox('st_kal', 'F', null) !!}
			@else 
			@if ($tclbr001t->st_kal == "T")
			{!! Form::checkbox('st_kal', 'T', true) !!}
			@else
			{!! Form::checkbox('st_kal', 'F', false) !!}
			@endif
			@endif
		</div>		
	</div>	
</div>
<!-- /.box-body -->
<div class="box-footer">
	{!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
	&nbsp;&nbsp;
	<a class="btn btn-default" href="{{ route('histalatukur.index') }}">Cancel</a>
</div>

@section('scripts')
<script type="text/javascript">
	document.getElementById("remark").focus();

	function autoLowerCase(a){
		a.value = a.value.toLowerCase();
	}
</script>
@endsection