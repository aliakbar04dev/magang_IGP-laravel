@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kebutuhan Spare Parts Plant
        <small>Kebutuhan Spare Parts Plant</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Kebutuhan Spare Parts Plant</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              <div class="box-header">
                <p> 
                  @permission(['mtc-lp-create'])
                  <a class="btn btn-primary" href="{{ route('mtctlogpkbs.create') }}">
                    <span class="fa fa-plus"></span> Add Kebutuhan Spare Parts Plant
                  </a>
                  @endpermission
                </p>
              </div>
              <!-- /.box-header -->
	            <div class="box-body">
	              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
    			        <thead>
  			            <tr>
  			            	<th style="width: 1%;">No</th>
			                <th style="width: 10%;">Tanggal</th>
			                <th style="width: 15%;">Pembuat</th>
                      <th style="width: 15%;">Item</th>
                      <th>Deskripsi</th>
			                <th style="width: 5%;">QTY</th>
			                <th style="width: 15%;">Keterangan</th>
                      <th>Satuan</th>
                      <th>Dok. Ref</th>
                      <th>No. Referensi</th>
                      <th>Approve</th>
                      <th>No. PP</th>
			                <th style="width: 10%;">Action</th>
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
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  function approve(id, dtcrea)
  {
    var msg = 'Anda yakin Approve data: ' + dtcrea + '?';
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var token = document.getElementsByName('_token')[0].value.trim();
      // save via ajax
      // create data detail dengan ajax
      var url = "{{ route('mtctlogpkbs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          id             : window.btoa(id)
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var table = $('#tblMaster').DataTable();
            table.ajax.reload(null, false);
          } else {
            swal("Cancelled", data.message, "error");
          }
        }, error:function(){ 
          $("#loading").hide();
          swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
        }
      });
    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        // swal(
        //   'Cancelled',
        //   'Your imaginary file is safe :)',
        //   'error'
        // )
      }
    })
  }

  $(document).ready(function(){

    var url = '{{ route('dashboard.mtctlogpkbs') }}';
   	var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
	    render: function (data, type, row, meta) {
	        return meta.row + meta.settings._iDisplayStart + 1;
	    }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      	{data: null, name: null},
        {data: 'dtcrea', name: 'dtcrea', className: "dt-center"},
        {data: 'creaby', name: 'creaby'},
        {data: 'kd_item', name: 'kd_item'},
        {data: 'deskripsi', name: 'deskripsi'},
        {data: 'qty', name: 'qty', className: "dt-right"},
        {data: 'ket_mesin_line', name: 'ket_mesin_line'},
        {data: 'kd_sat', name: 'kd_sat', className: "none"},
        {data: 'dok_ref', name: 'dok_ref', className: "none", orderable: false, searchable: false},
        {data: 'no_dok', name: 'no_dok', className: "none"},
        {data: 'tgl_cek', name: 'tgl_cek', className: "none", orderable: false, searchable: false},
        {data: 'no_pp', name: 'no_pp', className: "none", orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });

    $(function() {
      $('\
        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Plant\
          <select size="1" name="filter_status" aria-controls="filter_status" \
            class="form-control select2" style="width: 100px;">\
              <option value="ALL" selected="selected">All</option>\
              @foreach($plant->get() as $kode)\
                <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>\
              @endforeach\
            </select>\
          </label>\
        </div>\
        <div id="filter_status_apr" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Approve\
          <select size="1" name="filter_status_apr" aria-controls="filter_status_apr" \
            class="form-control select2" style="width: 150px;">\
              <option value="ALL" selected="selected">ALL</option>\
              <option value="F">Belum Approve</option>\
              <option value="T">Sudah Approve</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.status = $('select[name="filter_status"]').val();
        data.status_apr = $('select[name="filter_status_apr"]').val();
      });

      $('select[name="filter_status"]').change(function() {
        tableMaster.ajax.reload();
      });

      $('select[name="filter_status_apr"]').change(function() {
        tableMaster.ajax.reload();
      });
    });
  });
</script>
@endsection