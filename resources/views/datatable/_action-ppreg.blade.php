{!! Form::model($model, ['url' => $form_url, 'method' => 'delete', 'class' => $class, 'data-confirm' => $confirm_message, 'id' => $form_id, 'id-table' => $id_table] ) !!}
	<center>
	@if (empty($model->no_pp))
		@if ($model->status_approve === 'F')
			@permission('pp-reg-edit')
				@if ($model->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep)
			    	<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="{{ $edit_url }}"><span class="glyphicon glyphicon-edit"></span></a>
			    @endif
			@endpermission

			@permission('pp-reg-delete')
			    @if ($model->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep)
			    	{{ Form::button('<span class="glyphicon glyphicon-trash"></span>', array('class'=>'btn btn-xs btn-danger', 'type'=>'submit', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Hapus Data')) }}
			    @endif
			@endpermission

		    @if (Auth::user()->can('pp-reg-approve-div'))
		      	@if (substr($model->kd_dept_pembuat, 0, 1) == substr(Auth::user()->masKaryawan()->kode_dep, 0, 1))
			    	<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve Register PP {{ $model->no_reg }}' onclick='approveRegPp("{{ $model->no_reg }}", "D")'>
			        	<span class='glyphicon glyphicon-check'></span>
			      	</button>
			      	{{-- &nbsp;&nbsp; --}}
			      	<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Register PP {{ $model->no_reg }}' onclick='rejectRegPp("{{ $model->no_reg }}")'>
			        	<span class='glyphicon glyphicon-remove'></span>
			      	</button>
			    @endif
			@elseif (Auth::user()->can('pp-reg-approve-prc'))
				<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Register PP {{ $model->no_reg }}' onclick='rejectRegPp("{{ $model->no_reg }}")'>
		        	<span class='glyphicon glyphicon-remove'></span>
		      	</button>
		    @endif
		@elseif ($model->status_approve === 'D')
		    @if (Auth::user()->can('pp-reg-approve-prc'))
		      <a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="{{ $edit_url }}"><span class="glyphicon glyphicon-edit"></span></a>
		      <button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve Register PP {{ $model->no_reg }}' onclick='approveRegPp("{{ $model->no_reg }}", "P")'>
		        <span class='glyphicon glyphicon-check'></span>
		      </button>
		      {{-- &nbsp;&nbsp; --}}
		      <button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Register PP {{ $model->no_reg }}' onclick='rejectRegPp("{{ $model->no_reg }}")'>
		      <span class='glyphicon glyphicon-remove'></span>
		      </button>
		    @endif
		@elseif ($model->status_approve === 'P')
			@if ($model->inXXX()->get()->count() > 0)
			    @permission('pp-reg-edit')
					@if ($model->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep)
				    	<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="{{ $edit_url }}"><span class="glyphicon glyphicon-edit"></span></a>
				    @endif
				@endpermission
			@endif
		@endif
	@endif
	</center>
{!! Form::close()!!}