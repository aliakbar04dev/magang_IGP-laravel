{!! Form::model($model, ['url' => $form_url, 'method' => 'delete', 'class' => $class, 'data-confirm' => $confirm_message, 'id' => $form_id, 'id-table' => $id_table] ) !!}
	<center>
	@if (Auth::user()->can(['mtc-lp-create','mtc-lp-delete']))
		<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="{{ $edit_url }}"><span class="glyphicon glyphicon-edit"></span></a>
		{{ Form::button('<span class="glyphicon glyphicon-trash"></span>', array('class'=>'btn btn-xs btn-danger', 'type'=>'submit', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Hapus Data')) }}
	@endif
	@if (Auth::user()->can('mtc-apr-logpkb'))
		<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve Kebutuhan Spare Parts Plant: {{ \Carbon\Carbon::parse($model->dtcrea)->format('d/m/Y H:i:s') }}' onclick='approve("{{ \Carbon\Carbon::parse($model->dtcrea)->format('dmYHis') }}", "{{ \Carbon\Carbon::parse($model->dtcrea)->format('d/m/Y H:i:s') }}")'>
			<span class='glyphicon glyphicon-check'></span>
		</button>
	@endif
    </center>
{!! Form::close()!!}