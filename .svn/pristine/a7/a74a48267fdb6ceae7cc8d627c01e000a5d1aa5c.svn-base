<center>
@if ($model->kd_supp == Auth::user()->kd_supp && !empty($model->portal_sh_tgl))
	@if (!empty($model->pica()))
		@if (Auth::user()->can(['pica-*']))
			<a class="btn btn-xs bg-black" data-toggle="tooltip" data-placement="top" title="Show PICA {{ $model->pica()->no_pica }}" href="{{ route("picas.show", base64_encode($model->pica()->id)) }}"><span class='glyphicon glyphicon-transfer'></span></a>
		@endif
	@else
		@if (empty($model->portal_tgl_reject))
			@if (empty($model->portal_tgl_terima))
				@if (Auth::user()->can('qpr-approve'))
					<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve QPR {{ $model->issue_no }}' onclick='approveQpr("{{ $model->issue_no }}", "SP")'>
			        	<span class='glyphicon glyphicon-check'></span>
			      	</button>
				@endif
				@if (Auth::user()->can('qpr-reject'))
					{{-- &nbsp;&nbsp; --}}
					<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Complain QPR {{ $model->issue_no }}' onclick='rejectQpr("{{ $model->issue_no }}", "SP")'>
			        	<span class='glyphicon glyphicon-remove'></span>
			      	</button>
				@endif
			@else
				@if (Auth::user()->can('pica-create'))
					<button id='btncreate' type='button' class='btn btn-xs bg-navy' data-toggle='tooltip' data-placement='top' title='Create PICA {{ $model->issue_no }}' onclick='createPica("{{ $model->issue_no }}")'>
			        	<span class='glyphicon glyphicon-transfer'></span>
			      	</button>
				@endif
				@if (Auth::user()->can('qpr-reject'))
					<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Complain QPR {{ $model->issue_no }}' onclick='rejectQpr("{{ $model->issue_no }}", "SP")'>
			        	<span class='glyphicon glyphicon-remove'></span>
			      	</button>
			    @endif
			@endif
		@elseif ($model->portal_apr_reject === "F")
			@if (empty($model->portal_tgl_terima))
				@if (Auth::user()->can('qpr-approve'))
					<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve QPR {{ $model->issue_no }}' onclick='approveQpr("{{ $model->issue_no }}", "SP")'>
			        	<span class='glyphicon glyphicon-check'></span>
			      	</button>
				@endif
			@else
				@if (Auth::user()->can('pica-create'))
					<button id='btncreate' type='button' class='btn btn-xs bg-navy' data-toggle='tooltip' data-placement='top' title='Create PICA {{ $model->issue_no }}' onclick='createPica("{{ $model->issue_no }}")'>
			        	<span class='glyphicon glyphicon-transfer'></span>
			      	</button>
				@endif
			@endif
		@endif
	@endif
	
	@if (!empty($model->portal_pict))
		<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Download File {{ $model->issue_no }}" href="{{ $download_url }}"><span class="glyphicon glyphicon-download-alt"></span></a>
	@endif
@endif
</center>