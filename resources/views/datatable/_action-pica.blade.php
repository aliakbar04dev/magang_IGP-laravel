<center>
@if (strtoupper($model->status) === 'SUBMIT')
	@if (Auth::user()->can('pica-approve'))
		<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve PICA {{ $model->no_pica }}' onclick='approvePica("{{ base64_encode($model->id) }}", "{{ $model->no_pica }}")'>
        	<span class='glyphicon glyphicon-check'></span>
      	</button>
	@endif
	@if (Auth::user()->can('pica-reject'))
		{{-- &nbsp;&nbsp; --}}
		<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject PICA {{ $model->no_pica }}' onclick='rejectPica("{{ base64_encode($model->id) }}", "{{ $model->no_pica }}")'>
        	<span class='glyphicon glyphicon-remove'></span>
      	</button>
	@endif
@elseif(strtoupper($model->status) === 'APPROVE')
	@if (Auth::user()->can('pica-approve'))
		<button id='btnclose' type='button' class='btn btn-xs bg-black' data-toggle='tooltip' data-placement='top' title='Close PICA {{ $model->no_pica }}' onclick='closePica("{{ base64_encode($model->id) }}", "{{ $model->no_pica }}")'>
	    	<span class='glyphicon glyphicon-eye-close'></span>
	  	</button>
	@endif
@elseif(strtoupper($model->status) === 'CLOSE')
	@if (Auth::user()->can('pica-approve'))
		<button id='btnefektif' type='button' class='btn btn-xs bg-purple' data-toggle='tooltip' data-placement='top' title='Efektif PICA {{ $model->no_pica }}' onclick='efektifPica("{{ base64_encode($model->id) }}", "{{ $model->no_pica }}")'>
	    	<span class='glyphicon glyphicon-thumbs-up'></span>
	  	</button>
	@endif
@endif
@if (!empty($print_url))
	<a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print PICA {{ $model->no_pica }}" href="{{ $print_url }}"><span class="glyphicon glyphicon-print"></span></a>
@endif
</center>