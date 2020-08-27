<center>
@if ($model->submit_tgl != null && $model->prc_dtaprov == null && $model->prc_dtreject == null)
	@if (Auth::user()->can('ppc-picadpr-apr-prc'))
		<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve PICA DEPR {{ $model->no_dpr }}' onclick='approvePica("{{ $model->no_dpr }}")'>
        	<span class='glyphicon glyphicon-check'></span>
      	</button>
	@endif
	@if (Auth::user()->can('ppc-picadpr-apr-prc'))
		{{-- &nbsp;&nbsp; --}}
		<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject PICA DEPR {{ $model->no_dpr }}' onclick='rejectPica("{{ $model->no_dpr }}")'>
        	<span class='glyphicon glyphicon-remove'></span>
      	</button>
	@endif
@endif
{{-- @if (!empty($print_url))
	<a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print PICA {{ $model->no_dpr }}" href="{{ $print_url }}"><span class="glyphicon glyphicon-print"></span></a>
@endif --}}
</center>