@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PICA
        <small>Daftar PICA</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-exchange"></i> PICA</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblawal', 'Tgl Awal') !!}
              {!! Form::date('filter_status_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_status_awal']) !!}
    		    </div>
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblakhir', 'Tgl Akhir') !!}
  		      	{!! Form::date('filter_status_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'filter_status_akhir']) !!}
    		    </div>
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblstatus', 'Status') !!}
  		      	<select name="filter_status_status" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                <option value="D">DRAFT</option>
                <option value="FS">SUBMIT</option>
                <option value="RS">RE-SUBMIT</option>
                <option value="A">APPROVE</option>
                <option value="R">REJECT</option>
                <option value="C">CLOSE</option>
                <option value="E">EFEKTIF</option>
  	          </select>
    		    </div>
    		  </div>
    		  <!-- /.form-group -->
    		  <div class="form-group">
    		    <div class="col-sm-4">
  		      	{!! Form::label('lblsupplier', 'Supplier') !!}
  		      	<select name="filter_status_supplier" aria-controls="filter_status" class="form-control select2">
              	@if (strlen(Auth::user()->username) <= 5)
              		<option value="ALL" selected="selected">Semua</option>
  			        @endif
  			        @foreach ($suppliers->get() as $supplier)
		            	<option value={{ $supplier->kd_supp }}>{{ $supplier->nama.' - '.$supplier->kd_supp }}</option>
  		          @endforeach
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
                <th style="width: 3%;">No.</th>
                <th style="width: 15%;">No. PICA</th>
                <th style="width: 5%;">No. Revisi</th>
                <th style="width: 8%;">Tanggal</th>
                <th>Supplier</th>
                <th style="width: 10%;">No. QPR</th>
                <th style="width: 5%;">Status</th>
                <th>Submitted</th>
                <th>Approved</th>
                <th>Rejected</th>
                <th>Ket. Reject</th>
                <th>Closed</th>
                <th>Effectived</th>
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

  function efektifPica(id, no_pica)
  {
    var msg = 'Anda yakin mengubah status PICA ini menjadi Efektif?';
    var txt = 'No. PICA: ' + no_pica;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, change it!',
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
      var url = "{{ route('picas.efektif')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method      : 'POST',
          // menambah csrf token dari Laravel
          _token       : token,
          no_pica      : window.btoa(no_pica),
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Effectived", data.message, "success");
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

  function closePica(id, no_pica)
  {
    var msg = 'Anda yakin CLOSE data ini?';
    var txt = 'No. PICA: ' + no_pica;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, close it!',
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
      var url = "{{ route('picas.close')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method      : 'POST',
          // menambah csrf token dari Laravel
          _token       : token,
          no_pica      : window.btoa(no_pica),
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Closed", data.message, "success");
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

  function approvePica(id, no_pica)
  {
    var msg = 'Anda yakin APPROVE data ini?';
    var txt = 'No. PICA: ' + no_pica;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
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
      var url = "{{ route('picas.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method      : 'POST',
          // menambah csrf token dari Laravel
          _token       : token,
          no_pica      : window.btoa(no_pica),
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

  function rejectPica(id, no_pica)
  {
    var msg = 'Anda yakin REJECT data ini?';
    var txt = 'No. PICA: ' + no_pica;
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
          '<select class="form-control select2" required="required" id="swal-input1" name="swal-input1"><option selected="selected" value="">Pilih Status</option><option value="S">Request Supplier</option><option value="O">Others</option></select><BR>' +
          '<textarea id="swal-input2" class="form-control" maxlength="500" rows="3" cols="20" placeholder="Keterangan Reject (Max. 500 Karakter)" style="text-transform:uppercase;resize:vertical">',
        preConfirm: function () {
          return new Promise(function (resolve, reject) {
            if ($('#swal-input1').val()) {
              if ($('#swal-input2').val()) {
                if($('#swal-input2').val().length > 500) {
                  reject('Keterangan Reject Max 500 Karakter!')
                } else {
                  resolve([
                    $('#swal-input1').val(),
                    $('#swal-input2').val()
                  ])
                }
              } else {
                reject('Keterangan Reject tidak boleh kosong!')
              }
            } else {
              reject('Status Reject tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('picas.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method      : 'POST',
            // menambah csrf token dari Laravel
            _token       : token,
            no_pica      : window.btoa(no_pica),
            keterangan   : result[1],
            reject_st    : window.btoa(result[0]),
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
      "order": [3, 'desc'],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboardall.picas') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'no_pica', name: 'no_pica'},
        {data: 'no_revisi', name: 'no_revisi', className: "dt-center"},
        {data: 'tgl_pica', name: 'tgl_pica', className: "dt-center"},
        {data: 'kd_supp', name: 'kd_supp'},
        {data: 'issue_no', name: 'issue_no'},
        {data: 'status', name: 'status', className: "dt-center"},
        {data: 'portal_submit', name: 'portal_submit', className: "none"},
        {data: 'portal_approve', name: 'portal_approve', className: "none"},
        {data: 'portal_reject', name: 'portal_reject', className: "none"},
        {data: 'reject_ket', name: 'reject_ket', className: "none"},
        {data: 'portal_close', name: 'portal_close', className: "none"},
        {data: 'portal_efektif', name: 'portal_efektif', className: "none"},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.awal = $('input[name="filter_status_awal"]').val();
      data.akhir = $('input[name="filter_status_akhir"]').val();
      data.status = $('select[name="filter_status_status"]').val();
      data.supplier = $('select[name="filter_status_supplier"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    $('#display').click();
  });
</script>
@endsection