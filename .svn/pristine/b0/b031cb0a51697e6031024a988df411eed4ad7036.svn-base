@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Pekerjaan
        <small>Daftar Laporan Pekerjaan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Laporan Pekerjaan</li>
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
                  <a class="btn btn-primary" href="{{ route('tmtcwo1s.create') }}">
                    <span class="fa fa-plus"></span> Add Laporan Pekerjaan
                  </a>
                  &nbsp;&nbsp;
                  @endpermission
                  <a class="btn btn-primary" href="{{ route('tmtcwo1s.historycard') }}">
                    <span class="fa fa-print"></span> History Card
                  </a>
                  &nbsp;&nbsp;
                  <a class="btn btn-primary" href="{{ route('tmtcwo1s.all') }}">
                    <span class="fa fa-print"></span> Laporan LP
                  </a>
                  &nbsp;&nbsp;
                  <a class="btn btn-primary" href="{{ route('mtctpmss.index') }}">
                    <span class="fa fa-book"></span> Daily Activity Zone
                  </a>
                </p>
              </div>
              <!-- /.box-header -->

              <div class="box-body form-horizontal">
                <div class="form-group">
                  <div class="col-sm-2">
                    {!! Form::label('tgl_awal', 'Tanggal Awal') !!}
                    {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl_awal']) !!}
                  </div>
                  <div class="col-sm-2">
                    {!! Form::label('tgl_akhir', 'Tanggal Akhir') !!}
                    {!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'tgl_akhir']) !!}
                  </div>
                  <div class="col-sm-2">
                    {!! Form::label('lok_pt', 'Plant') !!}
                    <select size="1" id="lok_pt" name="lok_pt" class="form-control select2" onchange="changeKdPlant()">
                      <option value="-" selected="selected">ALL</option>
                      @foreach($plant->get() as $kode)
                        <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <div class="col-sm-2">
                    {!! Form::label('kd_line', 'Line (F9)') !!}
                    <div class="input-group">
                      {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'id' => 'kd_line']) !!}
                      <span class="input-group-btn">
                        <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                          <span class="glyphicon glyphicon-search"></span>
                        </button>
                      </span>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    {!! Form::label('nm_line', 'Nama Line') !!}
                    {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
                  </div>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <div class="col-sm-2">
                    {!! Form::label('filter_status', 'Status') !!}
                    {!! Form::select('filter_status', ['ALL' => 'ALL', 'F' => 'Belum Selesai', 'T' => 'Sudah Selesai', 'PIC' => 'Approve PIC', 'SH' => 'Approve Section', 'RJT' => 'Reject'], null, ['class'=>'form-control select2', 'id' => 'filter_status']) !!}
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
  			            	<th style="width: 1%;">No</th>
			                <th style="width: 15%;">No. LP</th>
			                <th style="width: 5%;">Tgl</th>
                      <th style="width: 13%;">Pembuat</th>
                      <th style="width: 18%;">Line</th>
			                <th style="width: 20%;">Mesin</th>
			                <th>Problem</th>
                      <th>Penyebab</th>
                      <th>Info Kerja</th>
                      <th>Site</th>
                      <th>Plant</th>
                      <th>Main Item</th>
                      <th>IC</th>
                      <th>No. LHP</th>
                      <th>LS Mulai</th>
                      <th>No. PMS</th>
                      <th>No. DM</th>
			                <th>Status</th>
                      <th>Creaby</th>
                      <th>Modiby</th>
                      <th>Approve PIC</th>
                      <th>Approve Section</th>
                      <th>Reject</th>
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

      <!-- Modal Line -->
      @include('mtc.lp.popup.lineModal')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("tgl_awal").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function approve(no_wo, status)
  {
    var msg = 'Anda yakin APPROVE No. LP ' + no_wo + '?';
    if(status === "PIC") {
      msg = 'Anda yakin APPROVE (PIC) No. LP ' + no_wo + '?';
    } else if(status === "SH") {
      msg = 'Anda yakin APPROVE (Section) No. LP ' + no_wo + '?';
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
      var url = "{{ route('tmtcwo1s.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          no_wo          : window.btoa(no_wo),
          status_approve : window.btoa(status)
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

  function reject(no_wo, status)
  {
    var msg = 'Anda yakin REJECT No. LP ' + no_wo + '?';
    if(status === "PIC") {
      msg = 'Anda yakin REJECT (PIC) No. LP ' + no_wo + '?';
    } else if(status === "SH") {
      msg = 'Anda yakin REJECT (Section) No. LP ' + no_wo + '?';
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
        input: 'textarea',
        showCancelButton: true,
        inputValidator: function (value) {
          return new Promise(function (resolve, reject) {
            if (value) {
              if(value.length > 200) {
                reject('Keterangan Reject Max 200 Karakter!')
              } else {
                resolve()
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
        var url = "{{ route('tmtcwo1s.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            no_wo             : window.btoa(no_wo),
            status_reject     : window.btoa(status),
            keterangan_reject : result,
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

  function changeKdPlant() {
    validateKdLine();
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('filter_status').focus();
    }
  }

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var lok_pt = document.getElementById('lok_pt').value.trim();
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(lok_pt));
    var lookupLine = $('#lookupLine').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      // "scrollX": true,
      // "scrollY": "500px",
      // "scrollCollapse": true,
      "order": [[1, 'asc']],
      columns: [
        { data: 'xkd_line', name: 'xkd_line'},
        { data: 'xnm_line', name: 'xnm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLine.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_line").value = value["xkd_line"];
            document.getElementById("nm_line").value = value["xnm_line"];
            $('#lineModal').modal('hide');
            validateKdLine();
          });
        });
        $('#lineModal').on('hidden.bs.modal', function () {
          var kd_line = document.getElementById("kd_line").value.trim();
          if(kd_line === '') {
            document.getElementById("nm_line").value = "";
            $('#kd_line').focus();
          } else {
            $('#filter_status').focus();
          }
        });
      },
    });
  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      var lok_pt = document.getElementById('lok_pt').value.trim();
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(lok_pt));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];
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

  $(document).ready(function(){

    $("#btnpopupline").click(function(){
      popupKdLine();
    });

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
      "order": [[2, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboard.tmtcwo1s') }}",
      columns: [
      	{data: null, name: null},
        {data: 'no_wo', name: 'no_wo'},
        {data: 'tgl_wo', name: 'tgl_wo'},
        {data: 'creaby', name: 'creaby'},
        {data: 'line', name: 'line'},
        {data: 'mesin', name: 'mesin'},
        {data: 'uraian_prob', name: 'uraian_prob'},
        {data: 'uraian_penyebab', name: 'uraian_penyebab', className: "none"},
        {data: 'info_kerja', name: 'info_kerja', className: "none"},
        {data: 'kd_site', name: 'kd_site', className: "none"},
        {data: 'lok_pt', name: 'lok_pt', className: "none"},
        {data: 'st_main_item', name: 'st_main_item', className: "none", orderable: false, searchable: false},
        {data: 'no_ic', name: 'no_ic', className: "none", orderable: false, searchable: false},
        {data: 'no_lhp', name: 'no_lhp', className: "none"},
        {data: 'ls_mulai', name: 'ls_mulai', className: "none", orderable: false, searchable: false},
        {data: 'no_pms', name: 'no_pms', className: "none"},
        {data: 'no_dm', name: 'no_dm', className: "none"},
        {data: 'st_close', name: 'st_close', className: "none", orderable: false, searchable: false},
        {data: 'dtcrea', name: 'dtcrea', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'apr_pic_npk', name: 'apr_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_sh_npk', name: 'apr_sh_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_npk', name: 'rjt_npk', className: "none", orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
      data.lok_pt = $('select[name="lok_pt"]').val();
      data.kd_line = $('input[name="kd_line"]').val();
      data.status = $('select[name="filter_status"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    //$('#display').click();
  });
</script>
@endsection