<center>
@if (strlen(Auth::user()->username) == 5)
	@if ($model->tgl_supp_submit != null && $model->tgl_rjt_prc == null && $model->tgl_close == null)
		@if ($model->tgl_apr_prc != null)
			<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject RFQ {{ $model->no_rfq }}' onclick='rejectRfq("{{ $model->no_rfq }}", "PRC")'>
	        	<span class='glyphicon glyphicon-remove'></span>
	      	</button>
		@else 
			@if (Auth::user()->can('prc-rfq-create'))
				<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve RFQ {{ $model->no_rfq }}' onclick='approveRfq("{{ $model->no_rfq }}", "PRC")'>
		        	<span class='glyphicon glyphicon-check'></span>
		      	</button>
		      	{{-- &nbsp;&nbsp; --}}
				<button id='btnreject' type='button' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='top' title='Reject RFQ {{ $model->no_rfq }}' onclick='rejectRfq("{{ $model->no_rfq }}", "PRC")'>
		        	<span class='glyphicon glyphicon-remove'></span>
		      	</button>
			@endif
		@endif
	@endif
@else 
	@if ($model->kd_bpid == Auth::user()->kd_supp && $model->tgl_supp_submit == null && $model->tgl_apr_prc == null && $model->tgl_rjt_prc == null && $model->tgl_close == null)
		@if (empty($model->tgl_apr_supp))
			@if (Auth::user()->can('prc-rfq-create'))
				<button id='btnapprove' type='button' class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='top' title='Approve RFQ {{ $model->no_rfq }}' onclick='approveRfq("{{ $model->no_rfq }}", "SP")'>
		        	<span class='glyphicon glyphicon-check'></span>
		      	</button>
			@endif
		@else
			@if (Auth::user()->can('prc-rfq-create'))
				<a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Ubah Data" href="{{ route('prctrfqs.edit', base64_encode($model->no_rfq)) }}">
					<span class="glyphicon glyphicon-edit"></span>
				</a>
			@endif
		@endif
	@endif
@endif
</center>