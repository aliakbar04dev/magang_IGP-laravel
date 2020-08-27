{!! Form::model($model, ['url' => $form_url, 'method' => 'delete', 'class' => $class, 'data-confirm' => $confirm_message, 'id' => $form_id, 'id-table' => $id_table] ) !!}
	<center>
	@if (empty($disable_delete))
		<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="{{ $edit_url }}"><span class="glyphicon glyphicon-edit"></span></a>
	@else 
		@if ($disable_delete === "T")
			<a class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Input CR Progress" href="{{ $edit_url }}"><span class="glyphicon glyphicon-edit"></span></a>
		@endif
	@endif
	@if (!empty($print_url))
	    <a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Data" href="{{ $print_url }}"><span class="glyphicon glyphicon-print"></span></a>
	@endif
	@if (!empty($download_url))
	    <a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Download Data" href="{{ $download_url }}"><span class="glyphicon glyphicon-download-alt"></span></a>
	@endif
	@if (empty($disable_delete))
    	{{ Form::button('<span class="glyphicon glyphicon-trash"></span>', array('class'=>'btn btn-xs btn-danger', 'type'=>'submit', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Hapus Data')) }}
    @endif
    </center>
{!! Form::close()!!}