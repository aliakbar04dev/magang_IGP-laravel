<center>
@if (strtoupper($model->status) === 'SUBMIT')
	@if (Auth::user()->can('ehs-wp-approve-prc'))
		<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve PRC WP: {{ $model->no_wp }}' onclick='approveIjinKerja("{{ base64_encode($model->id) }}", "{{ base64_encode($model->no_wp) }}", "{{ base64_encode($model->pic_pp) }}", "{{ base64_encode($model->nm_pic) }}", "PRC")'>
        	<span class='glyphicon glyphicon-check'></span>
      	</button>
	@endif
	@if (Auth::user()->can('ehs-wp-reject-prc'))
		{{-- &nbsp;&nbsp; --}}
		<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject PRC WP: {{ $model->no_wp }}' onclick='rejectIjinKerja("{{ base64_encode($model->id) }}", "{{ base64_encode($model->no_wp) }}", "PRC")'>
        	<span class='glyphicon glyphicon-remove'></span>
      	</button>
	@endif
@elseif (strtoupper($model->status) === 'PRC')
	@if (Auth::user()->can('ehs-wp-approve-user') && $model->pic_pp === Auth::user()->username)
		<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve Project Owner WP: {{ $model->no_wp }}' onclick='approveIjinKerja("{{ base64_encode($model->id) }}", "{{ base64_encode($model->no_wp) }}", "{{ base64_encode($model->pic_pp) }}", "{{ base64_encode($model->nm_pic) }}", "USER")'>
        	<span class='glyphicon glyphicon-check'></span>
      	</button>
	@endif
	@if (Auth::user()->can('ehs-wp-reject-user') && $model->pic_pp === Auth::user()->username)
		{{-- &nbsp;&nbsp; --}}
		<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Project Owner WP: {{ $model->no_wp }}' onclick='rejectIjinKerja("{{ base64_encode($model->id) }}", "{{ base64_encode($model->no_wp) }}", "USER")'>
        	<span class='glyphicon glyphicon-remove'></span>
      	</button>
	@endif
@elseif (strtoupper($model->status) === 'USER')
	@if (Auth::user()->can('ehs-wp-approve-ehs'))
		<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve EHS WP: {{ $model->no_wp }}' onclick='approveIjinKerja("{{ base64_encode($model->id) }}", "{{ base64_encode($model->no_wp) }}", "{{ base64_encode($model->pic_pp) }}", "{{ base64_encode($model->nm_pic) }}", "EHS")'>
        	<span class='glyphicon glyphicon-check'></span>
      	</button>
	@endif
	@if (Auth::user()->can('ehs-wp-reject-ehs'))
		{{-- &nbsp;&nbsp; --}}
		<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject EHS WP: {{ $model->no_wp }}' onclick='rejectIjinKerja("{{ base64_encode($model->id) }}", "{{ base64_encode($model->no_wp) }}", "EHS")'>
        	<span class='glyphicon glyphicon-remove'></span>
      	</button>
	@endif
@endif
@if (!empty($print_url) && (strtoupper($model->status) === 'EHS' || strtoupper($model->status) === 'SCAN_IN' || strtoupper($model->status) === 'SCAN_OUT'))
	<a target="_blank" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Print Ijin Kerja {{ $model->no_wp }}" href="{{ $print_url }}"><span class="glyphicon glyphicon-print"></span></a>
@endif
</center>