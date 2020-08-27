<center>
@if ($model->kd_supp == Auth::user()->kd_bpid && !empty($model->dh_aprov))
	@if (!empty($model->ppctDprPicas()))
		@if (Auth::user()->can(['ppc-picadpr-*']))
			<a class="btn btn-xs bg-black" data-toggle="tooltip" data-placement="top" title="Show PICA DEPR {{ $model->no_dpr }}" href="{{ route("ppctdprpicas.show", base64_encode($model->ppctDprPicas()->id)) }}"><span class='glyphicon glyphicon-transfer'></span></a>
		@endif
	@else
		@if (Auth::user()->can('ppc-picadpr-create'))
			<button id='btncreate' type='button' class='btn btn-xs bg-green' data-toggle='tooltip' data-placement='top' title='Create PICA DEPR {{ $model->no_dpr }}' onclick='createPica("{{ $model->no_dpr }}")'>
				<span class='glyphicon glyphicon-transfer'></span>
			</button>
		@endif
	@endif
	
	{{-- @if (!empty($model->portal_pict))
		<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Download File {{ $model->issue_no }}" href="{{ $download_url }}"><span class="glyphicon glyphicon-download-alt"></span></a>
	@endif --}}
@endif
</center>