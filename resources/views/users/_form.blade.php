<div class="box-body">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
			    {!! Form::label('username', 'Username (*) (F9)') !!}
				<div class="input-group">
	                {!! Form::text('username', null, ['class'=>'form-control','placeholder' => 'Username', 'onkeydown' => 'keyPressed(event)', 'minlength' => 5, 'maxlength' => 50, 'required', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)']) !!}
	                <span class="input-group-btn">
                  		<button type="button" class="btn btn-info" onclick="showPopupUsername()">
                  			<span class="glyphicon glyphicon-search"></span>
                  		</button>
                	</span>
	            </div>
				{!! $errors->first('username', '<p class="help-block">:message</p>') !!}
				<div hidden>
				    <button id="btnpopupsupplier" type="button" class="btn btn-info" data-toggle="modal" data-target="#supplierModal">
				    <span class="glyphicon glyphicon-search"></span></button>
				    <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
	    			<span class="glyphicon glyphicon-search"></span></button>
				</div>
			</div>
			<!-- /.form-group -->
			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			    {!! Form::label('name', 'Nama (*)') !!}
				{!! Form::text('name', null, ['class'=>'form-control','placeholder' => 'Nama', 'maxlength' => 255, 'required', 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
				{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
			</div>
		    <!-- /.form-group -->
		    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
			    {!! Form::label('email', 'Email (*)') !!}
				{!! Form::email('email', null, ['class'=>'form-control','placeholder' => 'Email', 'maxlength' => 255, 'required', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)']) !!}
				{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
			</div>
			<!-- /.form-group -->
			<div class="form-group{{ $errors->has('rolename') ? ' has-error' : '' }}">
			    {!! Form::label('rolename', 'Role (*)') !!}
				@if (Auth::user()->can(['admin-create', 'admin-edit']))
		            {!! Form::select('rolename[]', App\Role::where('name', '<>', 'su')->orderBy('display_name')->pluck('display_name','name')->all(), null, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Role', 'required']) !!}
		        @elseif (Auth::user()->can(['user-create', 'user-edit']))
					{!! Form::select('rolename[]', App\Role::whereNotIn('name', ['su', 'admin'])->orderBy('display_name')->pluck('display_name','name')->all(), null, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Role', 'required']) !!}
		        @else
		        	{!! Form::select('rolename[]', App\Role::where('id', 0)->orderBy('display_name')->pluck('display_name','name')->all(), null, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Role', 'required']) !!}
		        @endif
				{!! $errors->first('rolename', '<p class="help-block">:message</p>') !!}
			</div>
			<!-- /.form-group -->
		</div>
		<div class="col-md-6">
			<div class="form-group{{ $errors->has('init_supp') ? ' has-error' : '' }}">
			    {!! Form::label('init_supp', 'Init (*)') !!}
				{!! Form::text('init_supp', null, ['class'=>'form-control','placeholder' => 'Init', 'maxlength' => 10, 'required', 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
				{!! $errors->first('init_supp', '<p class="help-block">:message</p>') !!}
			</div>
			<!-- /.form-group -->
			<div class="form-group{{ $errors->has('no_hp') ? ' has-error' : '' }}">
			    {!! Form::label('no_hp', 'No. HP') !!}
				{!! Form::text('no_hp', null, ['class'=>'form-control','placeholder' => 'No. HP', 'maxlength' => 15]) !!}
				{!! $errors->first('no_hp', '<p class="help-block">:message</p>') !!}
			</div>
		    <!-- /.form-group -->
		    <div class="form-group{{ $errors->has('telegram_id') ? ' has-error' : '' }}">
			    {!! Form::label('telegram_id', 'ID Telegram') !!}
				{!! Form::text('telegram_id', null, ['class'=>'form-control','placeholder' => 'ID Telegram', 'maxlength' => 50]) !!}
				{!! $errors->first('telegram_id', '<p class="help-block">:message</p>') !!}
			</div>
		    <!-- /.form-group -->
			<div class="form-group{{ $errors->has('status_active') ? ' has-error' : '' }}">
			    {!! Form::label('status_active', 'Status Active (*)') !!}
				{!! Form::select('status_active', ['T' => 'Yes', 'F' => 'No'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'required']) !!}
				{!! $errors->first('status_active', '<p class="help-block">:message</p>') !!}
			</div>
			<!-- /.form-group -->
		</div>
	</div>
  	<!-- /.row -->
</div>
<!-- /.box-body -->
<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
	&nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('users.index') }}">Cancel</a>
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Supplier -->
@include('users.popup.supplierModal')
<!-- Modal Karyawan -->
@include('users.popup.karyawanModal')

@section('scripts')
<script type="text/javascript">

	document.getElementById("username").focus();

	//Initialize Select2 Elements
    $(".select2").select2();
    // $(".select2").select2({maximumSelectionLength:3}).trigger('selection:update');

    function autoUpperCase(a){
	    a.value = a.value.toUpperCase();
	}

  	function autoLowerCase(a){
    	a.value = a.value.toLowerCase();
  	}

    function keyPressed(e) {
        if(e.keyCode == 120) { //F9
        	showPopupUsername();
        } else if(e.keyCode == 9) { //TAB
	      e.preventDefault();
	      document.getElementById('name').focus();
    	}
        //menghilangkan fungsi default tombol
        //e.preventDefault();
	}

	function showPopupUsername() {
		swal({
	        title: 'Supplier / Karyawan?',
	        text: "",
	        type: 'question',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Supplier',
	        cancelButtonText: 'Karyawan',
	        allowOutsideClick: true,
	        allowEscapeKey: true,
	        allowEnterKey: true,
	        reverseButtons: false,
	        focusCancel: false,
	    }).then(function () {
	        $('#btnpopupsupplier').click();
	    }, function (dismiss) {
	        // dismiss can be 'cancel', 'overlay',
	        // 'close', and 'timer'
	        if (dismiss === 'cancel') {
	          $('#btnpopupkaryawan').click();
	        }
	    })
    }

    $(document).ready(function(){

	    $("#btnpopupsupplier").click(function(){
	     	var myHeading = "<p>Popup Supplier</p>";
     		$("#supplierModalLabel").html(myHeading);
     		//var param = document.getElementById("username").value;
     		var param = "-";
     		var url = '{{ route('datatables.popupSuppliers') }}';
	     	var lookupSupplier = $('#lookupSupplier').DataTable({
	     		processing: true, 
	     		"oLanguage": {
	     			'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
	     		}, 
		        serverSide: true,
		        "pagingType": "numbers",
		        ajax: url,
		        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
		        // "iDisplayLength": 10,
				// responsive: true,
				// "searching": false,
			    // "scrollX": true,
			    // "scrollY": "500px",
			    // "scrollCollapse": true,
			    // "paging": false,
			    // "lengthChange": false,
			    // "ordering": true,
			    // "info": true,
			    // "autoWidth": false,
			    // "order": [],
			    responsive: true,
				"order": [[1, 'asc']],
		        columns: [
		            { data: 'kd_supp', name: 'kd_supp'},
		            { data: 'nama', name: 'nama'},
		            { data: 'email', name: 'email'},
		            { data: 'init_supp', name: 'init_supp'}
		        ],
		        "bDestroy": true,
		        "initComplete": function(settings, json) {
	                $('#lookupSupplier tbody').on( 'dblclick', 'tr', function () {
	                	var dataArr = [];
					    var rows = $(this);
					    var rowData = lookupSupplier.rows(rows).data();
					    $.each($(rowData),function(key,value){
					    	document.getElementById("username").value = value["kd_supp"];
							document.getElementById("name").value = value["nama"];
					        if(value["email"] != '') {
					        	document.getElementById("email").value = value["email"];
					        }
					        if(value["init_supp"] != null) {
					        	document.getElementById("init_supp").value = value["init_supp"];
					        } else {
					        	document.getElementById("init_supp").value = value["kd_supp"];
					        }
					        $('#supplierModal').modal('hide');
					    });
	                });
	                $('#supplierModal').on('hidden.bs.modal', function () {
						var username = document.getElementById("username").value.trim();
						if(username === '') {
							$('#username').focus();
						} else {
							$('#name').focus();
						}
					});
	            },
		    });
	    });

	    $("#btnpopupkaryawan").click(function(){
	     	var myHeading = "<p>Popup Karyawan</p>";
     		$("#karyawanModalLabel").html(myHeading);
     		var url = '{{ route('datatables.popupKaryawans') }}';
	     	var lookupKaryawan = $('#lookupKaryawan').DataTable({
	     		processing: true, 
	     		"oLanguage": {
	     			'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
	     		}, 
		        serverSide: true,
		        "pagingType": "numbers",
		        ajax: url,
		        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
		        // "iDisplayLength": 10,
				// responsive: true,
				// "searching": false,
			    // "scrollX": true,
			    // "scrollY": "500px",
			    // "scrollCollapse": true,
			    // "paging": false,
			    // "lengthChange": false,
			    // "ordering": true,
			    // "info": true,
			    // "autoWidth": false,
			    // "order": [],
			    responsive: true,
				"order": [[1, 'asc']],
		        columns: [
		            { data: 'npk', name: 'npk'},
		            { data: 'nama', name: 'nama'},
		            { data: 'kd_pt', name: 'kd_pt'},
		            { data: 'desc_dep', name: 'desc_dep'},
		            { data: 'desc_div', name: 'desc_div'},
		            { data: 'desc_jab', name: 'desc_jab', className: 'none'},
		            { data: 'email', name: 'email'}, 
		            { data: 'no_hp', name: 'no_hp', className: 'none'}
		        ],
		        "bDestroy": true,
		        "initComplete": function(settings, json) {
	                $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
	                	var dataArr = [];
					    var rows = $(this);
					    var rowData = lookupKaryawan.rows(rows).data();
					    $.each($(rowData),function(key,value){
					    	document.getElementById("username").value = value["npk"];
							document.getElementById("name").value = value["nama"];
					        if(value["email"] != '') {
					        	document.getElementById("email").value = value["email"];
					        }
					        document.getElementById("init_supp").value = value["npk"];
					        if(value["no_hp"] != '') {
					        	document.getElementById("no_hp").value = value["no_hp"];
					        }
					        $('#karyawanModal').modal('hide');
					    });
	                });
	                $('#karyawanModal').on('hidden.bs.modal', function () {
				        var username = document.getElementById("username").value.trim();
					  	if(username === '') {
					      $('#username').focus();
					  	} else {
					  	  $('#name').focus();
					  	}
				    });
	            },
		    });
	    });
	});
</script>
@endsection