<div class="box-body">		
	<div class="form-group">
		<div class="col-md-2{{ $errors->has('tgl') ? ' has-error' : '' }}">
			{!! Form::label('tgl', 'Tanggal:') !!}
			{!! Form::date('tgl', \Carbon\Carbon::parse($tgl), ['class'=>'form-control','readonly'=>'']) !!}
			{!! $errors->first('tgl', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('kd_cust') ? ' has-error' : '' }}">
			{!! Form::label('kd_cust', 'Customer') !!}
			{!! Form::text('kd_cust', $kdCust, ['class'=>'form-control','readonly'=>'']) !!}
			{!! $errors->first('kd_cust', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-md-2{{ $errors->has('kd_dock') ? ' has-error' : '' }}">
			{!! Form::label('kd_dock', 'Dock:') !!}
			{!! Form::text('kd_dock', $kdDest, ['class'=>'form-control','readonly'=>'']) !!}
			{!! $errors->first('kd_dock', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('no_cycle') ? ' has-error' : '' }}">
			{!! Form::label('no_cycle', 'No Cycle') !!}
			{!! Form::text('no_cycle', $noCycle, ['class'=>'form-control','readonly'=>'']) !!}
			{!! Form::hidden('kd_plant', $kdPlant, ['class'=>'form-control', 'required']) !!}
			{!! $errors->first('no_cycle', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-md-2{{ $errors->has('remark') ? ' has-error' : '' }}">
			{!! Form::label('remark', 'Remark (*)') !!}
			{!! Form::text('remark', null, ['class'=>'form-control','placeholder' => 'Remark', 'maxlength' => 100, 'onchange' => 'autoUpperCase(this)']) !!}
			{!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
		</div>
		@if(!empty($ppctTruck->no_doc))
		<div class="col-md-2{{ $errors->has('jam_in_sec') ? ' has-error' : '' }}">
			{!! Form::label('jam_in_sec', 'Act Jam In IGP (*)') !!}
			{!! Form::time('jam_in_sec', $ppctTruck->jam_in_sec, ['class'=>'form-control']) !!}
			{!! $errors->first('jam_in_sec', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('jam_in_ppc') ? ' has-error' : '' }}">
			{!! Form::label('jam_in_ppc', 'Act Jam In Dock (*)') !!}
			{!! Form::time('jam_in_ppc', $ppctTruck->jam_in_ppc, ['class'=>'form-control']) !!}
			{!! $errors->first('jam_in_ppc', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('jam_out_ppc') ? ' has-error' : '' }}">
			{!! Form::label('jam_out_ppc', 'Act Jam out Dock (*)') !!}
			{!! Form::time('jam_out_ppc', $ppctTruck->jam_out_ppc, ['class'=>'form-control']) !!}
			{!! $errors->first('jam_out_ppc', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('jam_out_sec') ? ' has-error' : '' }}">
			{!! Form::label('jam_out_sec', 'Act Jam Out IGP (*)') !!}
			{!! Form::time('jam_out_sec', $ppctTruck->jam_out_sec, ['class'=>'form-control']) !!}
			{!! Form::hidden('no_doc', $ppctTruck->no_doc, ['class'=>'form-control', 'required']) !!}
			{!! $errors->first('jam_out_sec', '<p class="help-block">:message</p>') !!}
		</div>
		@else
		<div class="col-md-2{{ $errors->has('jam_in_sec') ? ' has-error' : '' }}">
			{!! Form::label('jam_in_sec', 'Act Jam In IGP (*)') !!}
			{!! Form::time('jam_in_sec', null, ['class'=>'form-control']) !!}
			{!! $errors->first('jam_in_sec', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('jam_in_ppc') ? ' has-error' : '' }}">
			{!! Form::label('jam_in_ppc', 'Act Jam In Dock (*)') !!}
			{!! Form::time('jam_in_ppc', null, ['class'=>'form-control']) !!}
			{!! $errors->first('jam_in_ppc', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('jam_out_ppc') ? ' has-error' : '' }}">
			{!! Form::label('jam_out_ppc', 'Act Jam out Dock (*)') !!}
			{!! Form::time('jam_out_ppc', null, ['class'=>'form-control']) !!}
			{!! $errors->first('jam_out_ppc', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2{{ $errors->has('jam_out_sec') ? ' has-error' : '' }}">
			{!! Form::label('jam_out_sec', 'Act Jam Out IGP (*)') !!}
			{!! Form::time('jam_out_sec', null, ['class'=>'form-control']) !!}
			{!! Form::hidden('no_doc', null, ['class'=>'form-control', 'required']) !!}
			{!! $errors->first('jam_out_sec', '<p class="help-block">:message</p>') !!}
		</div>
		@endif

	</div>
	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-md-2{{ $errors->has('remark') ? ' has-error' : '' }}">
			<p class="help-block">(*) tidak boleh kosong</p>
		</div>
	</div>
	<!-- /.form-group -->
</div>
<!-- /.box-body -->
<div class="box-footer">
	{!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
	&nbsp;&nbsp;
	<a class="btn btn-default" href="{{ route('mtruck.index') }}">Cancel</a>
</div>

@section('scripts')
<script type="text/javascript">
	document.getElementById("remark").focus();

	function autoUpperCase(a){
		a.value = a.value.toUpperCase();
	} 
	
</script>
@endsection