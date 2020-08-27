<!-- Modal -->
	<div class="modal fade" id="batalModal" role="dialog" aria-labelledby="batalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
					<h4 class="modal-title" id="batalModalLabel">Keterangan Batal</h4>
				</div>
				<div class="modal-body">
					<div class="col-sm-12">
					{!! Form::label('st_batal', 'Status') !!}
			            <div class="input-group">
			              {!! Form::select('st_batal', array('F' => '-', 'T' => 'BATAL', 'O' => 'OUTHOUSE'), 'ALL', ['class'=>'form-control']) !!}  
			            </div>
			        </div>
			        <div class="col-sm-12">
				        {!! Form::label('keterangan', 'Keterangan') !!}
				        {!! Form::textarea('keterangan', null, ['class'=>'form-control', 'rows' => 4, 'cols' => 50, 'required']) !!}
				        {!! Form::hidden('no_order', null, ['class'=>'form-control', 'id'=>'no_order']) !!}
				        {!! Form::hidden('no_seri', null, ['class'=>'form-control', 'id'=>'no_seri']) !!}					
		            </div>
		            <div class="col-sm-12">
		            	<br/>
		            	<button id="btnsave" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
						&nbsp;
						<button type="btncancel" class="btn btn-danger" data-dismiss="modal" style="margin-right: 200px;">Cancel</button>
					</div>
			    </div>
			    <div class="modal-footer">
					
				</div>
			</div>

		</div>
	</div>