<div class="box-body">
	<div class="row">
		<div class="col-md-10">
			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			    {!! Form::label('name', 'Name (*)') !!}
				{!! Form::text('name', null, ['class'=>'form-control','placeholder' => 'Name', 'maxlength' => 255, 'required', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)']) !!}
				{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
			</div>
			<!-- /.form-group -->
			<div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
			    {!! Form::label('display_name', 'Display Name (*)') !!}
				{!! Form::text('display_name', null, ['class'=>'form-control','placeholder' => 'Display Name', 'maxlength' => 255, 'required']) !!}
				{!! $errors->first('display_name', '<p class="help-block">:message</p>') !!}
			</div>
		    <!-- /.form-group -->
		    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
			    {!! Form::label('description', 'Description (*)') !!}
				{!! Form::text('description', null, ['class'=>'form-control','placeholder' => 'Description', 'maxlength' => 255, 'required']) !!}
				{!! $errors->first('description', '<p class="help-block">:message</p>') !!}
			</div>
			<!-- /.form-group -->
			<div class="form-group">
				<p class="help-block">(*) tidak boleh kosong</p>
			</div>
			<!-- /.form-group -->
		</div>
	</div>
  	<!-- /.row -->
</div>
<!-- /.box-body -->
<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
	&nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('permissions.index') }}">Cancel</a>
</div>

@section('scripts')
<script type="text/javascript">
	document.getElementById("name").focus();

	function autoLowerCase(a){
	    a.value = a.value.toLowerCase();
	}
</script>
@endsection