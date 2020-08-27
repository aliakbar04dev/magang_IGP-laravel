@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        RFQ
        <small>Request For Quotation</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - RFQ</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar RFQ</li>
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
                  @permission(['prc-rfq-create'])
                  <a class="btn btn-primary" href="{{ route('prctrfqs.create') }}">
                    <span class="fa fa-plus"></span> Add RFQ
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
			                <th style="width: 10%;">No. RFQ</th>
                      <th>Rev</th>
                      <th>BPID</th>
                      <th style="width: 12%;">No. SSR</th>
                      <th style="width: 10%;">Part No</th>
                      <th style="width: 15%;">Part Name</th>
                      <th style="width: 5%;">Vol./Month</th>
                      <th style="width: 10%;">Condition</th>
                      <th>Tgl RFQ</th>
                      <th>Tgl Revisi</th>
                      <th>Model</th>
                      <th>Exchange Rate USD</th>
                      <th>Exchange Rate JPY</th>
                      <th>Exchange Rate THB</th>
                      <th>Exchange Rate CNY</th>
                      <th>Exchange Rate KRW</th>
                      <th>Exchange Rate EUR</th>
                      <th>Harga</th>
                      <th>Creaby</th>
                      <th>Modiby</th>
                      <th>Send to Supplier</th>
                      <th>Approve by Supplier</th>
                      <th>Submit by Supplier</th>
                      <th>Approve by PRC</th>
                      <th>Reject by PRC</th>
                      <th>Selected by PRC</th>
                      <th>Closed by PRC</th>
			                <th>Status</th>
			                <th style="width: 5%;">Action</th>
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

  function approveRfq(no_rfq, mode)
  {
    var msg = 'Anda yakin APPROVE No. RFQ: ' + no_rfq + '?';
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
      var url = "{{ route('prctrfqs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          no_rfq         : window.btoa(no_rfq),
          mode           : window.btoa(mode)
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

  function rejectRfq(no_rfq, mode)
  {
    var msg = 'Anda yakin REJECT No. RFQ: ' + no_rfq + '?';
    var txt = '';
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, reject it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      swal({
        title: 'Input Keterangan Reject',
        html:
          '<textarea id="swal-input2" class="form-control" maxlength="100" rows="3" cols="20" placeholder="Keterangan Reject (Max. 100 Karakter)" style="text-transform:uppercase;resize:vertical">',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#swal-input2').val()) {
              if($('#swal-input2').val().length > 100) {
                reject('Keterangan Reject Max 100 Karakter!')
              } else {
                resolve([
                  $('#swal-input2').val()
                ])
              }
            } else {
              reject('Keterangan Reject tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('prctrfqs.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method        : 'POST',
            // menambah csrf token dari Laravel
            _token         : token,
            no_rfq         : window.btoa(no_rfq),
            mode           : window.btoa(mode), 
            keterangan     : window.btoa(result[0]),
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
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
      }).catch(swal.noop)
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

    var url = '{{ route('dashboard.prctrfqs') }}';
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
      "order": [[1, 'desc'],[4, 'asc'],[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      	{data: null, name: null, className: "dt-center"},
        {data: 'no_rfq', name: 'no_rfq', className: "dt-center"},
        {data: 'no_rev', name: 'no_rev', className: "none"},
        {data: 'kd_bpid', name: 'kd_bpid'},
        {data: 'no_ssr', name: 'no_ssr', className: "dt-center"},
        {data: 'part_no', name: 'part_no'},
        {data: 'nm_part', name: 'nm_part'},
        {data: 'vol_month', name: 'vol_month', className: "dt-right"},
        {data: 'nm_proses', name: 'nm_proses'},
        {data: 'tgl_rfq', name: 'tgl_rfq', orderable: false, searchable: false, className: "none"},
        {data: 'tgl_rev', name: 'tgl_rev', orderable: false, searchable: false, className: "none"},
        {data: 'ssr_nm_model', name: 'ssr_nm_model', orderable: false, searchable: false, className: "none"},
        {data: 'ssr_er_usd', name: 'ssr_er_usd', orderable: false, searchable: false, className: "none"},
        {data: 'ssr_er_jpy', name: 'ssr_er_jpy', orderable: false, searchable: false, className: "none"},
        {data: 'ssr_er_thb', name: 'ssr_er_thb', orderable: false, searchable: false, className: "none"},
        {data: 'ssr_er_cny', name: 'ssr_er_cny', orderable: false, searchable: false, className: "none"},
        {data: 'ssr_er_krw', name: 'ssr_er_krw', orderable: false, searchable: false, className: "none"},
        {data: 'ssr_er_eur', name: 'ssr_er_eur', orderable: false, searchable: false, className: "none"},
        {data: 'nil_total', name: 'nil_total', orderable: false, searchable: false, className: "none"},
        {data: 'creaby', name: 'creaby', orderable: false, searchable: false, className: "none"},
        {data: 'modiby', name: 'modiby', orderable: false, searchable: false, className: "none"},
        {data: 'pic_send_supp', name: 'pic_send_supp', orderable: false, searchable: false, className: "none"},
        {data: 'pic_apr_supp', name: 'pic_apr_supp', orderable: false, searchable: false, className: "none"},
        {data: 'pic_supp_submit', name: 'pic_supp_submit', orderable: false, searchable: false, className: "none"},
        {data: 'pic_apr_prc', name: 'pic_apr_prc', className: "none", orderable: false, searchable: false},
        {data: 'pic_rjt_prc', name: 'pic_rjt_prc', className: "none", orderable: false, searchable: false},
        {data: 'pic_pilih', name: 'pic_pilih', orderable: false, searchable: false, className: "none"},
        {data: 'pic_close', name: 'pic_close', orderable: false, searchable: false, className: "none"},
        {data: 'status', name: 'status', orderable: false, searchable: false, className: "none"},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });
  });
</script>
@endsection