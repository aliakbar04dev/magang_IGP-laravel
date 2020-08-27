@extends('layouts.app')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        TRANSAKSI
        <small>Daftar Karyawan Mengajukan Cuti</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-lock"></i> Persetujuan Cuti</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	        	<div class="box box-primary">
		            <div class="box-body">
							<select autocomplete="off" class="form-control" style="width:150px;float:left;margin: 0px 12px 10px 0px;" id="table-dropdown">           
									<option value="0">Belum diproses</option>
									<option value="2">Ditolak</option>
									<option value="1">Disetujui</option>
									<option value="">Semua</option>
									</select></button>
									<button class="btn btn-success" style="margin-left:10px" id="refreshdata"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
		            	<table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
		            		<thead>
		            			<tr>
									<th style="width:20px">Aksi</th>
		            				<th >Nama</th>  
		            				<th >Status</th>  
									<th >Tgl Cuti</th>  
									<th >No. Cuti</th>  
		            			</tr>
		            		</thead>
		            	</table>
		            </div>
		            <!-- /.box-body -->
		        </div>
		        <!-- /.box -->
	        </div>
	        <!-- /.col -->
	    </div>
	    <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  @include('hr.mobile.PersetujuanCuti.popupModal')
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
		$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		cache: false,
		headers: { "cache-control": "no-cache" },
	});

		tampil()
		
	});

	function tampil(){
			var tableDetail = $('#tblMaster').DataTable({
	      //"aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
	      "iDisplayLength": 10,
	      responsive: {
            details: {
                type: 'column',
                target: 3
            }
        },
		
		"order": [
          [3, 'desc']
        ],
		columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:  []
        }],
	      processing: true,
		  serverSide:true, 
	      destroy: true, 
	      searching: true, 
		//   "deferRender": true,
	      "oLanguage": {
	      	'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
	      }, 
	      ajax: "{{ route('persetujuancuti.listpersetujuancuti') }}",
	      columns: [
			{data: 'pilih', name: 'pilih',searchable:false},
	        {data: 'nama', name: 'nama'},
			{data: 'status', name: 'status'}, 
	        {data: 'tglcuti', name: 'tglcuti',sortable:false,searchable:false},
			{data: 'no_cuti', name: 'no_cuti'},
			
	      ],
		//   "dom": 'rtip'
	    });

		$('#table-dropdown').ready(function(){
			tableDetail.column(2).search('0').draw();   
    });   
        $('#table-dropdown').on('change', function(){
			// tableDetail.ajax.reload();
		  tableDetail.column(2).search(this.value).draw();   
    });  

	$("#refreshdata").on("click", function (event) {
          tableDetail.ajax.reload();
    });
		}

		

	function Approve()
		{ 
			swal({ 
				text: "Apakah anda yakin menyetujui pengajuan cuti ini?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Simpan !',
				cancelButtonText: 'Tidak, Batalkan!',
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				buttonsStyling: true
			}).then(function() {
    			var data = $("#formApprove").serialize(); 

				$.ajax({
					type: "post",
					url: '{{ route('persetujuancuti.approve') }}',
					data: data,
					dataType: "json",
					success: function(data) {
					if(data['pesan'] == 'Sukses'){
						swal({
							title: "Cuti Berhasil Disetujui",
							text: data['msg'],
							type: "success"
						}).then(function() {
							tampil()
							  $('#popupModal').modal('hide');
						});
					}else{
						swal('Warning!', 'Gagal!', 'error');
					}
					
					},
					error: function(error) {
						swal('Warning!', 'Gagal!', 'error');
						}
					});
				
			}, function(dismiss) { 
				if (dismiss === 'cancel') {
					swal('Cancelled', 'Dibatalkan', 'error');
				}
			}) 
		}

		function showPopupModal(no_cuti){
			$('#backButton').on('click', function () {
				$('#popupModal').modal('hide');
			})
			// var no_cuti = $('#btnInfoNocuti'+npk).val();
			
			var myHeading = "<p>Popup Detail Pengajuan Cuti</p>";
			$("#popupModalLabel1").html(myHeading);
			var url = '{{route("persetujuancuti.listpengajuancuti",['+no_cuti+'])}}';
			var tblDetailMaster = $('#tblDetailMaster').DataTable({
				processing: true,
				"oLanguage": {
				'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
				},
				"columnDefs": [{
					"searchable": false,
					"orderable": false,
					"targets": 0,
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				}],
				"pagingType": "numbers",
				scrollY:'200px',
				paging:false,
				ajax: {
				url: url,
				type: 'GET',
				data: {
				no_cuti:no_cuti
				}},
				"lengthChange": false,
				"aLengthMenu": [
				[5, 10, 25, 50, 75, 100, -1],
				[5, 10, 25, 50, 75, 100, "All"]
				],
				responsive: true,
				searching:true,
				columns: [{data: null, name: null, orderable: false, searchable: false},  
		    	{data: 'tglcuti', name: 'tglcuti'}, 
		    	{data: 'kd_cuti', name: 'kd_cuti'},
		    	{data: 'ket', name: 'ket'} 
				],
				"bDestroy": true,
				"initComplete": function (settings, json) {
				},
			});

			$.ajax({
				type: "get",
				url: '{{ route("persetujuancuti.viewdetails") }}',
				data: {
					no_cuti:no_cuti
				},
				dataType: "json",
				success: function(data) {
					$('#npkDetail').html(data['npk'])
					$('#namaDetail').html(data['nama'])
					$('#tglDetail').html(data['tglpengajuan'])
					$('#bagDetail').html(data['desc_dep']+' '+ data['desc_sie'])
					$('#nodocDetail').html(data['nodoccuti'])
					$('#no_cuti_approve').val(data['nodoccuti'])
					$('#no_cuti_decline').val(data['nodoccuti'])
					$('#sisaCutiTahunan').html(data['ct_akhir']+' (Saat ini)')
					$('#sisaCutiBesar').html(data['cb_akhir']+' (Saat ini)')
					$('#namaAtasanDetail').html(data['namaatasan'])
					if(data['statusUbah'] == '0'){
						$('#ubahStatus').show();
					}else{
						$('#ubahStatus').hide();
					}

				
				},
				error: function(error) {
					//   swal('Warning!', ' ', 'error');
					}
				});
		}



		function Decline()
		{ 
			swal({ 
				text: "Apakah anda yakin menolak pengajuan cuti ini?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Simpan !',
				cancelButtonText: 'Tidak, Batalkan!',
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				buttonsStyling: true
			}).then(function() {
    			var data = $("#formDecline").serialize();

				$.ajax({
					type: "post",
					url: '{{ route('persetujuancuti.decline') }}',
					data: data,
					dataType: "json",
					success: function(data) {
					if(data['pesan'] == 'Sukses'){
						swal({
							title: "Cuti Berhasil Ditolak",
							text: data['msg'],
							type: "success"
						}).then(function() {
							tampil()
							$('#popupModal').modal('hide');
						});
					}else{
						swal('Warning!', 'Gagal!', 'error');
					}
					
					},
					error: function(error) {
						swal('Warning!', 'Belum Ada data cuti, mohon tambahkan data dengan klik add. pastikan sudah mendapat persetujuan atasan anda baru anda mengambil cuti.', 'error');
						}
					});
				
			}, function(dismiss) { 
				if (dismiss === 'cancel') {
					swal('Cancelled', 'Dibatalkan', 'error');
				}
			}) 
		}

	
</script>
@endsection