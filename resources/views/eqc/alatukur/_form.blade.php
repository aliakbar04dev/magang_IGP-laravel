<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="fp">
		<div class="box-body">
			<div class="form-group">
				<div class="col-md-12 {{ $errors->has('bulan') ? ' has-error' : '' }}">
					<div class="col-md-2">
						{!! Form::label('bulan', 'Bulan') !!}
						{!! Form::selectMonth('bulan', Carbon\Carbon::now()->month, ['class'=>'form-control']) !!}
						{!! $errors->first('bulan', '<p class="help-block">:message</p>') !!}				
					</div>
					<div class="col-md-2">
						{!! Form::label('tahun', 'Tahun') !!}
						{!! Form::number('tahun', Carbon\Carbon::now()->year, ['class'=>'form-control']) !!}
						{!! $errors->first('tahun', '<p class="help-block">:message</p>') !!}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 {{ $errors->has('periode') ? ' has-error' : '' }}">
					<div class="col-md-2">
						{!! Form::label('periode_awal', 'Periode Awal') !!}
						{!! Form::date('periode_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Periode Awal']) !!}
						{!! $errors->first('periode_awal', '<p class="help-block">:message</p>') !!}
					</div>
					<div class="col-md-2">
						{!! Form::label('periode_akhir', 'Periode Akhir') !!}
						{!! Form::date('periode_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Periode Akhir']) !!}
						{!! $errors->first('periode_akhir', '<p class="help-block">:message</p>') !!}
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-12 {{ $errors->has('tipe') ? ' has-error' : '' }}">
					<div class="col-md-2">
						{!! Form::label('tipe', 'Tipe') !!}
						{!! Form::select('tipe', array('K' => 'Kalibrasi', 'V' => 'Verifikasi'), 'K', ['class'=>'form-control']) !!}
						{!! $errors->first('tipe', '<p class="help-block">:message</p>') !!}
					</div>
					<div class="col-md-2">
						{!! Form::label('plant', 'Plant') !!}
						{!! Form::select('plant', array('1' => 'IGP-1', '2' => 'IGP-2', '3' => 'IGP-3', '4' => 'IGP-4', 'A' => 'KIM-1A', 'B' => 'KIM-1B'), '1', ['class'=>'form-control']) !!}
						{!! $errors->first('plant', '<p class="help-block">:message</p>') !!}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 {{ $errors->has('line') ? ' has-error' : '' }}">
					<div class="col-md-2">
						{!! Form::label('line', 'Line (F9)') !!}  
						<div class="input-group">
							{!! Form::text('line', null, ['class'=>'form-control','placeholder' => 'Line','onkeydown' => 'btnpopupLineClick(event)', 'onchange' => 'validateLine()']) !!}     
							<span class="input-group-btn">
								<button id="btnpopupLine" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
									<label class="glyphicon glyphicon-search"></label>
								</button>
							</span>
						</div>   
						{!! $errors->first('line', '<p class="help-block">:message</p>') !!}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 {{ $errors->has('prepared') ? ' has-error' : '' }}">
					<div class="col-md-2">
						{!! Form::label('prepared', 'Prepared') !!}
						{!! Form::text('prepared', null, ['class'=>'form-control','placeholder' => 'Prepared']) !!}     
						{!! $errors->first('prepared', '<p class="help-block">:message</p>') !!}
					</div>
					<div class="col-md-2">
						{!! Form::label('approved', 'Approved') !!}
						{!! Form::text('approved', null, ['class'=>'form-control','placeholder' => 'Approved']) !!}     
						{!! $errors->first('approved', '<p class="help-block">:message</p>') !!}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12">
					<div class="col-md-6">
						<br>
						{!! Form::button('Print Calibration Schedule', ['class'=>'btn btn-primary', 'id' => 'btn-print-calibration']) !!}
						&nbsp;&nbsp;
						{!! Form::button('Print Actual Calibration', ['class'=>'btn btn-primary', 'id' => 'btn-print-actual']) !!}
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Popup Line Modal -->
@include('eqc.alatukur.popup.lineModal')

@section('scripts')
<script type="text/javascript">
	document.getElementById("bulan").focus();

	function btnpopupLineClick(e) {
		if(e.keyCode == 120) {
			$('#btnpopupLine').click();
		}
	}

	$(document).ready(function(){
		$("#btnpopupLine").click(function(){
			popupLine();
		});

		$('#btn-print-calibration').click( function () {
			swal({
				title: "Cetak",
				text: "Apakah anda ingin mencetak dengan data outstanding ?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: "Yes",
				cancelButtonText: "No",
				allowOutsideClick: true,
				allowEscapeKey: true,
				allowEnterKey: true,
				reverseButtons: false,
				focusCancel: true,
			}).then(function () {
				printPdf('CalibrationSchedule');
			}, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	printPdf('CalibrationScheduleNo');	
        }
    })
			
		});	

		$('#btn-print-actual').click( function () {
			swal({
				title: "Cetak",
				text: "Apakah anda ingin mencetak laporan actual Calibration vs Schedule ?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: "Yes",
				cancelButtonText: "No",
				allowOutsideClick: true,
				allowEscapeKey: true,
				allowEnterKey: true,
				reverseButtons: false,
				focusCancel: true,
			}).then(function () {
				printPdf('ActualCalibrationYa');
			}, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	printPdf('ActualCalibrationNo');	
        }
    })

		});
	});

   //POPUP LINE
   function popupLine() {
   	var myHeading = "<p>Popup Line</p>";
   	$("#lineModalLabel").html(myHeading);

   	var url = '{{ route('datatables.popupLineQc') }}';
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
          { data: 'kd_line', name: 'kd_line'}
          ],
          "bDestroy": true,
          "initComplete": function(settings, json) {
          	$('div.dataTables_filter input').focus();
          	$('#lookupLine tbody').on( 'dblclick', 'tr', function () {
          		var dataArr = [];
          		var rows = $(this);
          		var rowData = lookupLine.rows(rows).data();
          		$.each($(rowData),function(key,value){
          			document.getElementById("line").value = value["kd_line"];
          			$('#lineModal').modal('hide');
          			validateLine();
          		});
          	});
          	$('#lineModal').on('hidden.bs.modal', function () {
          		var kode = document.getElementById("line").value.trim();
          		if(kode === '') {
          			$('#line').focus();
          		} else {
          			$('#btn-print-calibration').focus();
          		}
          	});
          },
      });   	
   }

  //VALIDASI LINE
  function validateLine() {
  	var kode = document.getElementById("line").value.trim();     
  	if(kode !== '') {
  		var url = '{{ route('datatables.validasiLineQc', ['param']) }}';
  		url = url.replace('param', window.btoa(kode));
          //use ajax to run the check
          $.get(url, function(result){  
          	if(result !== 'null'){
          		result = JSON.parse(result);
          		document.getElementById("line").value = result["kd_line"];
          		document.getElementById("btn-print-calibration").focus();
          	} else {
          		document.getElementById("line").value = "";
          		document.getElementById("line").focus();
          		swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
          	}
          });
      } else {
      	document.getElementById("line").value = "";
      }   
  }

  //CETAK DOKUMEN
  function printPdf(jenisReport){
  	var param = document.getElementById("tahun").value;
  	var param1 = document.getElementById("bulan").value;
  	param1 = parseInt(param1);
  	if(param1 < 10){
  		param1="0"+param1;
  	}
  	var param2 = document.getElementById("tipe").value;
  	var param3 = document.getElementById("plant").value;
  	var param4 = String(param1) + String(param);
  	var param5 = document.getElementById("prepared").value;
  	if(param5 === '') {
  		param5 = "-";
  	}
  	var param6 = document.getElementById("approved").value;
  	if(param6 === '') {
  		param6 = "-";
  	}
  	var param7 = jenisReport;

  	var url = '{{ route('alatukur.print', ['param', 'param1', 'param2', 'param3', 'param4', 'param5', 'param6', 'param7']) }}';
  	url = url.replace('param', window.btoa(param));
  	url = url.replace('param1', window.btoa(param1));
  	url = url.replace('param2', window.btoa(param2));
  	url = url.replace('param3', window.btoa(param3));
  	url = url.replace('param4', window.btoa(param4));
  	url = url.replace('param5', window.btoa(param5));
  	url = url.replace('param6', window.btoa(param6));
  	url = url.replace('param7', window.btoa(param7));
  	window.open(url);
  }
</script>
@endsection