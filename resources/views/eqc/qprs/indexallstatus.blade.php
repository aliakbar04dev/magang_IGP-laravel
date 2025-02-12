@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        QPR
        <small>Daftar QPR</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-exchange"></i> QPR</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
            <div class="col-sm-3">
              {!! Form::label('lblstatus', 'Status') !!}
              <select id="filter_status_status" name="filter_status_status" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" @if($status === "ALL") selected="selected" @endif>ALL</option>
                <option value="2" @if($status === "2") selected="selected" @endif>BELUM APPROVE SUPPLIER</option>
                <option value="4" @if($status === "4") selected="selected" @endif>APPROVE SUPPLIER</option>
                <option value="5" @if($status === "5") selected="selected" @endif>REJECT SUPPLIER</option>
                <option value="7" @if($status === "7") selected="selected" @endif>BELUM DIRESPON</option>
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblusername2', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
    		  </div>
    		  <!-- /.form-group -->
    		</div>
    		<!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 1%;">No.</th>
                <th style="width: 10%;">No. QPR</th>
                <th style="width: 8%;">Tgl</th>
                <th style="width: 20%;">Supplier</th>
                <th style="width: 13%;">Part No</th>
                <th>Part Name</th>
                <th>Problem</th>
                <th style="width: 15%;">No. PICA</th>
                <th>Plant</th>
                <th>Submit to Portal</th>
                <th>Approve Section Head</th>
                <th>Reject Section Head</th>
                <th>Received</th>
                <th>Rejected</th>
                <th>Ket. Reject</th>
                {{-- <th>File</th> --}}
                <th style="width: 10%;">Action</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  //Initialize Select2 Elements
  $(".select2").select2();

  function approveQpr(issue_no, mode)
  {
    var msg = 'Anda yakin APPROVE No. QPR: ' + issue_no + '?';
    if(mode === "SH2") {
      msg = 'Anda yakin APPROVE Complain Supplier untuk No. QPR: ' + issue_no + '?';
    }
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
      var url = "{{ route('qprs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          issue_no       : window.btoa(issue_no),
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

  function rejectQpr(issue_no, mode)
  {
    var msg = 'Anda yakin REJECT No. QPR: ' + issue_no + '?';
    if(mode === "SH2") {
      msg = 'Anda yakin REJECT Complain Supplier untuk No. QPR: ' + issue_no + '?';
    }
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
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
          '<textarea id="swal-input2" class="form-control" maxlength="500" rows="3" cols="20" placeholder="Keterangan Reject (Max. 500 Karakter)" style="text-transform:uppercase;resize:vertical">',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#swal-input2').val()) {
              if($('#swal-input2').val().length > 500) {
                reject('Keterangan Reject Max 500 Karakter!')
              } else {
                resolve([
                  "O",
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
        var url = "{{ route('qprs.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            issue_no          : window.btoa(issue_no),
            mode              : window.btoa(mode),
            keterangan        : result[1],
            st_reject         : window.btoa(result[0])
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

  function complainQpr(issue_no, mode, status_reject, portal_ket_reject)
  {
    portal_ket_reject = window.atob(portal_ket_reject);
    var msg = 'Terdapat Complain untuk No. QPR: ' + issue_no + ' dgn keterangan sbb: ';
    var html = '<textarea id="portal_ket_reject" class="form-control" maxlength="500" rows="3" cols="20" placeholder="Keterangan Complain" style="text-transform:uppercase;resize:vertical" readonly="readonly">' + status_reject + ' - ' + portal_ket_reject + '</textarea>';
    //additional input validations can be done hear
    swal({
      title: msg,
      html: html,
      type: 'warning',
      showCloseButton: true,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Approve Complain!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> Reject Complain!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var token = document.getElementsByName('_token')[0].value.trim();
      // save via ajax
      // create data detail dengan ajax
      var url = "{{ route('qprs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          issue_no       : window.btoa(issue_no),
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
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('qprs.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            issue_no          : window.btoa(issue_no),
            mode              : window.btoa(mode),
            keterangan        : "-",
            st_reject         : window.btoa("-")
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
      }
    })
  }

  $(document).ready(function(){
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
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[ 2, 'asc' ], [ 1, 'asc' ]],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboardbystatus.qprs') }}",
      columns: [
        {data: null, name: null},
        {data: 'issue_no', name: 'issue_no'},
        {data: 'issue_date', name: 'issue_date'},
        {data: 'kd_supp', name: 'kd_supp'},
        {data: 'part_no', name: 'part_no'},
        {data: 'nm_part', name: 'nm_part', className: "none"},
        {data: 'problem', name: 'problem'},
        {data: 'no_pica', name: 'no_pica', orderable: false},
        {data: 'plant', name: 'plant', className: "none"},
        {data: 'portal_submit', name: 'portal_submit', className: "none"},
        {data: 'portal_sh_pic', name: 'portal_sh_pic', className: "none"},
        {data: 'portal_sh_pic_reject', name: 'portal_sh_pic_reject', className: "none"},
        {data: 'portal_approve', name: 'portal_approve', className: "none"},
        {data: 'portal_reject', name: 'portal_reject', className: "none"},
        {data: 'portal_ket_reject', name: 'portal_ket_reject', className: "none"},
        // , {data: 'portal_pict', name: 'portal_pict', className: "none", orderable: false, searchable: false}
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.status = $('select[name="filter_status_status"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    $('#display').click();
  });
</script>
@endsection