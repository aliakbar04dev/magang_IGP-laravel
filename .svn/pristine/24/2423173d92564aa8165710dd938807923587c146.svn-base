<div class="box-body ">
	<div class="form-group">
		<div class="col-md-4">
			{!! Form::label('no_doc', 'No BPB') !!}
			{!! Form::text('no_doc', null, ['class'=>'form-control','required', 'readonly']) !!}
			{!! $errors->first('no_doc', '<p class="help-block">:message</p>') !!}			
		</div>		
	</div>	
	<div class="form-group">			
		<div class="col-sm-2">
			{!! Form::label('kd_plant', 'Plant (*)') !!}
			<div class="input-group">
			@if (empty($whstconscr01->kd_plant)) 
			{!! Form::select('kd_plant', ['A' => 'KIM-1A', 'B' => 'KIM-1B'], null, ['class'=>'form-control select2','data-placeholder' => 'Pilih Plant', 'required', 'id' => 'kd_plant']) !!}
			@else
			{!! Form::select('kd_plant', ['A' => 'KIM-1A', 'B' => 'KIM-1B'], null, ['class'=>'form-control select2','data-placeholder' => 'Pilih Plant', 'disabled', 'id' => 'kd_plant']) !!}
			@endif
			</div>
			{!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-2">
			{!! Form::label('tgl', 'Tanggal') !!}
			@if (empty($whstconscr01->tgl))
			{!! Form::date('tgl', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => \Carbon\Carbon::now()]) !!}
			@else
			{!! Form::date('tgl', \Carbon\Carbon::parse($whstconscr01->tgl), ['class'=>'form-control']) !!}
			@endif
			{!! $errors->first('tgl', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-2{{ $errors->has('kd_line') ? ' has-error' : '' }}">
			{!! Form::label('kd_line', 'Line (F9)(*)') !!}  
			@if (empty($whstconscr01->kd_line))     
			<div class="input-group">
				{!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line','onkeydown' => 'btnpopupLineClick(event)', 'onchange' => 'validateLine()','required']) !!} 
				<span class="input-group-btn">
					<button id="btnpopupLine" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
						<label class="glyphicon glyphicon-search"></label>
					</button>
				</span>
			</div>
			@else
			{!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line','onkeydown' => 'btnpopupLineClick(event)', 'onchange' => 'validateLine()','readonly']) !!} 
			@endif
			{!! $errors->first('kd_line', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-sm-4">
			{!! Form::label('nm_line', 'Nama Line') !!}      
			{!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'']) !!} 
		</div>
	</div>

	<!-- /.form-group -->
	<div class="form-group">
		<div class="col-md-4">
			<p class="help-block">(*) tidak boleh kosong</p>
			{!! Form::hidden('jml_tbl_detail', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_detail']) !!}
		</div>
	</div>
</div>

<div class="box-body">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Detail</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">            
					@include('datatable._action-addrem')
					<table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="width: 2%;">No</th>
								<th style="width: 15%; text-align: center">Jenis</th>
								<th style="width: 15%; text-align: center">Kode Baan (F9)</th>
								<th style="width: 40%; text-align: center">Nama Barang</th>
								<th style="width: 10%; text-align: center">Kuota</th>
								<th style="width: 10%; text-align: center">Akumulasi</th>
								<th style="width: 10%; text-align: center">Qty BPB</th>
							</tr>
						</thead>
						<tbody>
							@if (!empty($whstconscr01->no_doc)) 
							@foreach ($model->whstConsCr01Det($whstconscr01->no_doc)->get() as $whstconscr02)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td><input type='text' id="row-{{ $loop->iteration }}-jenis" name="row-{{ $loop->iteration }}-jenis" value="{{ $whstconscr02->jenis }}" size="15" readonly></td>
								<td><input type='hidden' value="row-{{ $loop->iteration }}-item"><input type='text' id="row-{{ $loop->iteration }}-item" name="row-{{ $loop->iteration }}-item" value="{{ $whstconscr02->item }}" onkeydown="popupItem(event)" onchange="validateItem(event)" size="20" required><input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value='0' readonly='readonly'></td>
								<td><textarea id="row-{{ $loop->iteration }}-nama_barang" name="row-{{ $loop->iteration }}-nama_barang" cols="50" rows="2" readonly>{{ $model->getNmbrg($whstconscr02->item)}}</textarea></td>
								<td><input type='number' id="row-{{ $loop->iteration }}-kuota" name="row-{{ $loop->iteration }}-kuota" value="{{ $model->getKuota($whstconscr02->item, $whstconscr01->kd_line, $whstconscr01->tgl, $whstconscr01->kd_line, $whstconscr01->kd_site)}}" style="width: 6em" readonly></td>
								<td><input type='number' id="row-{{ $loop->iteration }}-akum" name="row-{{ $loop->iteration }}-akum" value="{{ $model->getAkum($whstconscr02->item, $whstconscr01->kd_line, $whstconscr01->tgl)}}" style="width: 6em" readonly></td>
								<td><input type='number' id="row-{{ $loop->iteration }}-qty" name="row-{{ $loop->iteration }}-qty" value="{{ $whstconscr02->qty }}" style="width: 6em" onchange="validateQty(event)" required></td>
							</tr>
							@endforeach
							@endif            
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</div>

<!-- /.box-body -->
<div class="box-footer">
	{!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
	&nbsp;&nbsp;
	@if (!empty($whstconscr01->no_doc))
	<button id="btn-delete" type="button" class="btn btn-danger">Delete</button>
	@endif
	&nbsp;&nbsp;
	<a class="btn btn-default" href="{{ route('bpbcrconsireg.index') }}">Cancel</a>
</div>

<!-- Popup Cust Modal -->
@include('ppc.bpbcrconsireg.popup.lineModal')
<!-- Popup Item Modal -->
@include('ppc.bpbcrconsireg.popup.itemModal')

@section('scripts')
<script type="text/javascript">

	document.getElementById("tgl").focus();

	function autoUpperCase(a){
		a.value = a.value.toUpperCase();
	}   
  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
  	$("#btnpopupLine").click(function(){
  		popupLine();
  	});

  	var kode = document.getElementById("kd_line").value.trim();     
  	if(kode !== '') {
  		validateLine();
  	}

    //MEMBUAT TABEL DETAIL
    var table = $('#tblDetail').DataTable({
    	"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    	"iDisplayLength": 10,
	      //responsive: true,
	      'searching': false,
	      'ordering': false,
	      "scrollX": "true",
	      "scrollY": "500px",
	      "scrollCollapse": true,
	      "paging": false
	  });
    document.getElementById("removeRow").disabled = true;

    var counter = table.rows().count();
    document.getElementById("jml_tbl_detail").value = counter;

    $('#tblDetail tbody').on( 'click', 'tr', function () {
    	if ( $(this).hasClass('selected') ) {
    		$(this).removeClass('selected');
    		document.getElementById("removeRow").disabled = true;      
    	} else {
    		table.$('tr.selected').removeClass('selected');
    		$(this).addClass('selected');
    		document.getElementById("removeRow").disabled = false;
				      //untuk memunculkan gambar
				      var row = table.row('.selected').index();  
				  }
				});

    $("#btn-delete").click(function(){
    	var no_doc = document.getElementById("no_doc").value;
    	if(no_doc !== "") {
    		var msg = 'Anda yakin menghapus data ini?';
    		var txt = 'Nomor BPB: ' + no_doc;
    		swal({
    			title: msg,
    			text: txt,
    			type: 'warning',
    			showCancelButton: true,
    			confirmButtonColor: '#3085d6',
    			cancelButtonColor: '#d33',
    			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
    			cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
    			allowOutsideClick: true,
    			allowEscapeKey: true,
    			allowEnterKey: true,
    			reverseButtons: false,
    			focusCancel: true,
    		}).then(function () {
    			var urlRedirect = "{{ route('bpbcrconsireg.destroy', 'param') }}";
    			urlRedirect = urlRedirect.replace('param', window.btoa(no_doc));
    			window.location.href = urlRedirect;
    		}, function (dismiss) {

    			if (dismiss === 'cancel') {

    			}
    		})
    	}
    });

    $('#addRow').on( 'click', function () {
    	counter = table.rows().count();
    	counter++;	     
    	document.getElementById("jml_tbl_detail").value = counter;
    	var id = 'row-' + counter +'-id';
    	var item = 'row-' + counter +'-item';
    	var jenis = 'row-' + counter +'-jenis';
    	var nama_barang = 'row-' + counter +'-nama_barang';
    	var kuota = 'row-' + counter +'-kuota';
    	var akum = 'row-' + counter +'-akum';
    	var qty = 'row-' + counter +'-qty';
    	table.row.add([
    		counter,
    		"<input type='text' id=" + jenis + " name=" + jenis + " size='15' readonly>",
    		"<input type='hidden' value=" + item + "><input type='text' id=" + item + " name=" + item + " onkeydown='popupItem(event)' onchange='validateItem(event)' size='20' required><input type='hidden' id=" + id + " name=" + id + " value='0' readonly>",
    		"<textarea id=" + nama_barang + " name=" + nama_barang + " cols='50' rows='2' readonly></textarea>",
    		"<input type='number' id=" + kuota + " name=" + kuota + " style='width: 6em' readonly>",
    		"<input type='number' id=" + akum + " name=" + akum + " style='width: 6em' readonly>",
    		"<input type='number' id=" + qty + " name=" + qty + " style='width: 6em' onchange='validateQty(event)' required>"       
    		]).draw(false);
    });

    $('#removeRow').click( function () {
    	var table = $('#tblDetail').DataTable();
    	counter = table.rows().count()-1;
    	document.getElementById("jml_tbl_detail").value = counter;
    	var index = table.row('.selected').index();
    	var row = index;
    	if(index == null) {
    		swal("Tidak ada data yang dipilih!", "", "warning");
    	} else {
			        //var array = table.rows(index).data().toArray();
			        var data = table.cell(index, 2).data();
			        var posisi = data.indexOf("item");
			        var target = data.substr(0, posisi);
			        target = target.replace('<input type="hidden" value="', '');
			        target = target.replace("<input type='hidden' value=", '');
			        target = target.replace('<input value="', '');
			        target = target.replace("<input value=", '');
			        target = target.replace('<input value="', '');
			        target = target.replace('<input value="', '');
			        //alert();
			        var id = document.getElementById(target +'id').value.trim();
			        var no_doc = document.getElementById("no_doc").value;
			        var item = document.getElementById(target +'item').value.trim();
			        
			        
			        if(no_doc === '') {
			        	changeId(row);
			        } else {
			        	if(item === '') {
			        		changeId(row);
			        	}else{          
			        		swal({
			        			title: "Are you sure?",
			        			text: "Item: " + item,
			        			type: "warning",
			        			showCancelButton: true,
			        			confirmButtonColor: '#3085d6',
			        			cancelButtonColor: '#d33',
			        			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
			        			cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
			        			allowOutsideClick: true,
			        			allowEscapeKey: true,
			        			allowEnterKey: true,
			        			reverseButtons: false,
			        			focusCancel: true,
			        		}).then(function () {
			            //startcode
			            var info = "";
			            var info2 = "";
			            var info3 = "warning";

			          //DELETE DI DATABASE
			          // remove these events;
			          window.onkeydown = null;
			          window.onfocus = null;
			          var token = document.getElementsByName('_token')[0].value.trim();
			          // delete via ajax
			          // hapus data detail dengan ajax
			          var url = "{{ route('bpbcrconsireg.hapus', ['param', 'param1'])}}";
			          url = url.replace('param',  window.btoa(no_doc));
			          url = url.replace('param1', window.btoa(item));
			          $.ajax({
			          	type     : 'POST',
			          	url      : url,
			          	dataType : 'json',
			          	data     : {
			          		_method : 'GET',
			              // menambah csrf token dari Laravel
			              _token  : token
			          },
			          success:function(data){
			          	if(data.status === 'OK'){
			          		changeId(row);
			          		info = "Deleted!";
			          		info2 = data.message;
			          		info3 = "success";
			          		swal(info, info2, info3);
			          	} else {
			          		info = "Cancelled";
			          		info2 = data.message;
			          		info3 = "error";
			          		swal(info, info2, info3);
			          	}
			          }, error:function(){ 
			          	info = "System Error!";
			          	info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
			          	info3 = "error";
			          	swal(info, info2, info3);
			          }
			      });

			      }, function (dismiss) {
			      	if (dismiss === 'cancel') {
			      	}
			      })
			        	}
			        }
			    }
			});

    $('#removeAll').click( function () {
    	var no_doc = document.getElementById("no_doc").value;
    	swal({
    		title: "Are you sure?",
    		text: "Remove All Detail",
    		type: "warning",
    		showCancelButton: true,
    		confirmButtonColor: '#3085d6',
    		cancelButtonColor: '#d33',
    		confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
    		cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
    		allowOutsideClick: true,
    		allowEscapeKey: true,
    		allowEnterKey: true,
    		reverseButtons: false,
    		focusCancel: true,
    	}).then(function () {
		            //startcode
		            var info = "";
		            var info2 = "";
		            var info3 = "warning";

			          //DELETE DI DATABASE
			          // remove these events;
			          window.onkeydown = null;
			          window.onfocus = null;
			          var token = document.getElementsByName('_token')[0].value.trim();
			          // delete via ajax
			          // hapus data detail dengan ajax
			          var url = "{{ route('bpbcrconsireg.hapusdetail', 'param')}}";
			          url = url.replace('param',  window.btoa(no_doc));
			          $.ajax({
			          	type     : 'POST',
			          	url      : url,
			          	dataType : 'json',
			          	data     : {
			          		_method : 'GET',
			              // menambah csrf token dari Laravel
			              _token  : token
			          },
			          success:function(data){
			          	if(data.status === 'OK'){
			          		info = "Deleted!";
			          		info2 = data.message;
			          		info3 = "success";
			          		swal(info, info2, info3);
			          		//clear tabel
			          		var table = $('#tblDetail').DataTable();
			          		table.clear().draw(false);
			          	} else {
			          		info = "Cancelled";
			          		info2 = data.message;
			          		info3 = "error";
			          		swal(info, info2, info3);
			          	}
			          }, error:function(){ 
			          	info = "System Error!";
			          	info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
			          	info3 = "error";
			          	swal(info, info2, info3);
			          }
			      });

			      }, function (dismiss) {
			      	if (dismiss === 'cancel') {
			      	}
			      })		
    });
});

	function btnpopupLineClick(e) {
	    if(e.keyCode == 120) { //F9
	    	$('#btnpopupLine').click();
	    } else if(e.keyCode == 9) { //TAB
	    	e.preventDefault();
	    	document.getElementById('btnpopupLine').focus();
	    }
	}

	//POPUP LINE
	function popupLine() {
		var plant = document.getElementById("kd_plant").value.trim(); 
		var myHeading = "<p>Popup Line</p>";
		$("#lineModalLabel").html(myHeading);
		var url = '{{ route('datatables.popupLineBpbCr', ['param']) }}';
		url = url.replace('param', window.btoa(plant));
		var lookupLine = $('#lookupLine').DataTable({
			processing: true, 
			"oLanguage": {
				'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
			}, 
			serverSide: true,
	          //responsive: true,
	          "scrollX": true,
	          "scrollY": "500px",
	          "scrollCollapse": true,
	          iDisplayLength: 10,
	          pagingType: "simple",
	          ajax: url,
	          columns: [
	          { data: 'kd_ff', name: 'kd_ff'},
	          { data: 'desc_ff', name: 'desc_ff'}
	          ],
	          "bDestroy": true,
	          "initComplete": function(settings, json) {
	          	$('div.dataTables_filter input').focus();
	          	$('#lookupLine tbody').on( 'dblclick', 'tr', function () {
	          		var dataArr = [];
	          		var rows = $(this);
	          		var rowData = lookupLine.rows(rows).data();
	          		$.each($(rowData),function(key,value){
	          			document.getElementById("kd_line").value = value["kd_ff"];
	          			document.getElementById("nm_line").value = value["desc_ff"];
	          			$('#lineModal').modal('hide');
	          			validateLine();
	          		});
	          	});
	          	$('#lineModal').on('hidden.bs.modal', function () {
	          		var kode = document.getElementById("kd_line").value.trim();
	          		if(kode === '') {
	          			$('#kd_line').focus();
	          		} else {
	          			$('#tgl_estimasi').focus();
	          		}
	          	});
	          },
	      });     
	}

	//VALIDASI LINE
	function validateLine() {
		var plant = document.getElementById("kd_plant").value.trim();  
		var kode = document.getElementById("kd_line").value.trim();     
		if(kode !== '') {
			var url = '{{ route('datatables.validasiBpbCr', ['param', 'param1']) }}';
			url = url.replace('param', window.btoa(plant));
			url = url.replace('param1', window.btoa(kode));
	          //use ajax to run the check
	          $.get(url, function(result){  
	          	if(result !== 'null'){
	          		result = JSON.parse(result);
	          		document.getElementById("nm_line").value = result["desc_ff"];
	          	} else {
	          		document.getElementById("kd_line").value = "";
	          		document.getElementById("nm_line").value = "";
	          		document.getElementById("kd_line").focus();
	          		swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
	          	}
	          });
	      } else {
	      	document.getElementById("kd_line").value = "";
	      	document.getElementById("nm_line").value = "";
	      }   
	  }

	//POPUP ITEM
	function popupItem(e) {
		var kd_line = document.getElementById("kd_line").value.trim();
		if(kd_line !== ''){
			if(e.keyCode == 120 || e.keyCode == 13) {			
				var tanggal = document.getElementById("tgl").value.trim(); 
				var myHeading = "<p>Popup Item</p>";
				$("#itemModalLabel").html(myHeading);
				var url = '{{ route('datatables.popupItemBpbCr', ['param','param1','param2']) }}';
				url = url.replace('param', window.btoa('IGPK'));
				url = url.replace('param1', window.btoa(kd_line));
				url = url.replace('param2', window.btoa(tanggal));
					//alert(url);
					$('#itemModal').modal('show');
					var lookupItem = $('#lookupItem').DataTable({
						processing: true, 
						"oLanguage": {
							'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
						}, 
						serverSide: true,
						pagingType: "simple",
						ajax: url,
						columns: [ 
						{ data: 'jenis', name: 'jenis'},
						{ data: 'item', name: 'item'},
						{ data: 'nama', name: 'nama'},
						{ data: 'kuota', name: 'kuota'},
						{ data: 'akumulasi', name: 'akumulasi'}
						],
						"bDestroy": true,
						"initComplete": function(settings, json) {
							$('div.dataTables_filter input').focus();
							$('#lookupItem tbody').on( 'click', 'tr', function () {
								var dataArr = [];
								var rows = $(this);
								var rowData = lookupItem.rows(rows).data();
								$.each($(rowData),function(key,value){
									var id = e.target.id.replace('item', '');
									document.getElementById(e.target.id).value = value["item"];
									document.getElementById(id +'jenis').value = value["jenis"];
									document.getElementById(id +'nama_barang').value = value["nama"];
									document.getElementById(id +'kuota').value = value["kuota"];
									document.getElementById(id +'akum').value = value["akumulasi"];

									$('#itemModal').modal('hide');
									if(validateItemDuplicate(e.target.id)) {
										document.getElementById(id +'item').focus();
									} else {
										document.getElementById(e.target.id).value = "";
										document.getElementById(id +'jenis').value = "";
										document.getElementById(id +'nama_barang').value = "";
										document.getElementById(id +'kuota').value = "";
										document.getElementById(id +'akum').value = "";
										document.getElementById(e.target.id).focus();
										swal("Item tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
									}
								});
							});
							$('#itemModal').on('hidden.bs.modal', function () {
								var item = document.getElementById(e.target.id).value.trim();
								if(item === '') {
									document.getElementById(e.target.id).focus();
								} else {
									var id = e.target.id.replace('item', '');
									document.getElementById(id +'item').focus();
								}
							});
						},
					});
				}
			}else{
				document.getElementById("kd_line").focus();
				swal("Line tidak boleh kosong!", "", "warning");				
			}
		}

	//VALIDASI ITEM
	function validateItem(e){
		var kd_line = document.getElementById("kd_line").value.trim();
		if(kd_line !== ''){
			var tanggal = document.getElementById("tgl").value.trim();
			var id = e.target.id.replace('item', '');    
			var item = document.getElementById(e.target.id).value.trim();
			if(item === '') {
				document.getElementById(e.target.id).value = "";
				document.getElementById(id +'jenis').value = "";
				document.getElementById(id +'nama_barang').value = "";
				document.getElementById(id +'kuota').value = "";
				document.getElementById(id +'akum').value = "";
			}else{
				var url = '{{ route('datatables.validasiItemBpbCr', ['param', 'param1', 'param2', 'param3']) }}';
				url = url.replace('param', window.btoa('IGPK'));
				url = url.replace('param1', window.btoa(kd_line));
				url = url.replace('param2', window.btoa(tanggal));
				url = url.replace('param3', window.btoa(item));
				$.get(url, function(result){  
					if(result !== 'null'){
						result = JSON.parse(result);
						document.getElementById(e.target.id).value = result["item"];
						document.getElementById(id +'jenis').value = result["jenis"];
						document.getElementById(id +'nama_barang').value = result["nama"];
						document.getElementById(id +'kuota').value = result["kuota"];
						document.getElementById(id +'akum').value = result["akumulasi"];

						if(!validateItemDuplicate(e.target.id)) {
							document.getElementById(e.target.id).value = "";
							document.getElementById(id +'jenis').value = "";
							document.getElementById(id +'nama_barang').value = "";
							document.getElementById(id +'kuota').value = "";
							document.getElementById(id +'akum').value = "";
							document.getElementById(e.target.id).focus();
							swal("Item tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
						}
					} else {
						document.getElementById(e.target.id).value = "";
						document.getElementById(id +'jenis').value = "";
						document.getElementById(id +'nama_barang').value = "";
						document.getElementById(id +'kuota').value = "";
						document.getElementById(id +'akum').value = "";
						document.getElementById(e.target.id).focus();
						swal("Item tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
					}
				});
			}
		}else{
			swal("Line tidak boleh kosong!", "", "warning");
			document.getElementById("kd_line").focus();
		}
	}

	//VALIDASI ITEM DUPLICATE
	function validateItemDuplicate(parentId){
		var id = parentId.replace('item', '');
		var item = document.getElementById(parentId).value.trim();

		if(item !== '' ) {
			var table = $('#tblDetail').DataTable();
			var valid = 'T';
			for($i = 0; $i < table.rows().count(); $i++) {
				var data = table.cell($i, 2).data();
				var posisi = data.indexOf("item");
				var target = data.substr(0, posisi);
				target = target.replace('<input type="hidden" value="', '');
				target = target.replace("<input type='hidden' value=", '');
				target = target.replace('<input value="', '');
				target = target.replace("<input value='", '');
				target = target.replace("<input value=", '');
				target = target.replace("<input value=", '');

				var target_item = target +'item';
				if(parentId !== target_item) {
					var item_temp = document.getElementById(target_item).value.trim();
					if(item_temp !== '') {
						if(item_temp === item) {
							valid = 'F';
							$i = table.rows().count();
						}
					}
				}
			}
			if(valid === 'T') {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	function changeId(row) {
		var table = $('#tblDetail').DataTable();
		table.row(row).remove().draw(false);
		var jml_row = document.getElementById("jml_tbl_detail").value.trim();
		jml_row = Number(jml_row) + 1;
		nextRow = Number(row) + 1;
		for($i = nextRow; $i <= jml_row; $i++) {
			var id = "#row-" + $i + "-id";
			var id_new = "row-" + ($i-1) + "-id";
			$(id).attr({"id":id_new, "name":id_new});
			var jenis = "#row-" + $i + "-jenis";
			var jenis_new = "row-" + ($i-1) + "-jenis";
			$(jenis).attr({"id":jenis_new, "name":jenis_new});
			var item = "#row-" + $i + "-item";
			var item_new = "row-" + ($i-1) + "-item";
			$(item).attr({"id":item_new, "name":item_new});
			var nama_barang = "#row-" + $i + "-nama_barang";
			var nama_barang_new = "row-" + ($i-1) + "-nama_barang";
			$(nama_barang).attr({"id":nama_barang_new, "name":nama_barang_new});
			var kuota = "#row-" + $i + "-kuota";
			var kuota_new = "row-" + ($i-1) + "-kuota";
			$(kuota).attr({"id":kuota_new, "name":kuota_new}); 
			var akum = "#row-" + $i + "-akum";
			var akum_new = "row-" + ($i-1) + "-akum";
			$(akum).attr({"id":akum_new, "name":akum_new});
			var qty = "#row-" + $i + "-qty";
			var qty_new = "row-" + ($i-1) + "-qty";
			$(qty).attr({"id":qty_new, "name":qty_new});      
		}
	}

	function validateQty(e) {
		var id = e.target.id.replace('qty', '');    
		var qty = document.getElementById(e.target.id).value.trim();
		var kuota = document.getElementById(id +'kuota').value.trim();
		var akum = document.getElementById(id +'akum').value.trim();
		var cek = kuota+akum;
		if(qty > cek){
			document.getElementById(e.target.id).value = "";
			document.getElementById(e.target.id).focus();
			swal("Qty tidak boleh melebihi kuota-akumulasi!", "", "warning");
		}
	}
</script>
@endsection