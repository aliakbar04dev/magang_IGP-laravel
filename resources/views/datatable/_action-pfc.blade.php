{!! Form::model($model, ['url' => $form_url, 'method' => 'delete', 'class' => $class, 'data-confirm' => $confirm_message, 'id' => $form_id, 'id-table' => $id_table] ) !!}
	<center>
	<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="{{ $edit_url }}"><span class="glyphicon glyphicon-edit"></span></a>
	<button id='btnprint' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Print PFC' onclick='printPfc("{{ base64_encode($model->id) }}")'>
    	<span class='glyphicon glyphicon-print'></span>
  	</button>
	@if (!empty($download_url))
	    <a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Download Data" href="{{ $download_url }}"><span class="glyphicon glyphicon-download-alt"></span></a>
	@endif
	@if (empty($disable_delete))
    	{{ Form::button('<span class="glyphicon glyphicon-trash"></span>', array('class'=>'btn btn-xs btn-danger', 'type'=>'submit', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Hapus Data')) }}
    @endif
    </center>
{!! Form::close()!!}