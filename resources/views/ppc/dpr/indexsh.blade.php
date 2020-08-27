@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        DEPR
        <small>DEPR Approval SH</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PPC - Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> DEPR Approval SH</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body form-horizontal">
              <div class="form-group">
                <div class="col-sm-2">
                  {!! Form::label('kd_site', 'Site') !!}
                  <select size="1" id="kd_site" name="kd_site" class="form-control select2">
                    <option value="ALL" selected="selected">ALL</option>
                    <option value="IGPJ">IGP - JAKARTA</option>
                    <option value="IGPK">IGP - KARAWANG</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('tgl_awal', 'Tanggal Awal') !!}
                  {!! Form::date('tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl_awal']) !!}
                </div>
                <div class="col-sm-2">
                  {!! Form::label('tgl_akhir', 'Tanggal Akhir') !!}
                  {!! Form::date('tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'tgl_akhir']) !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <div class="col-sm-6">
                  {!! Form::label('kd_supp', 'Supplier') !!}
                  <select size="1" id="kd_supp" name="kd_supp" class="form-control select2">
                    @if (strlen(Auth::user()->username) <= 5)
                      <option value="ALL" selected="selected">Semua</option>
                    @endif
                    @foreach ($suppliers->get() as $supplier)
                      <option value={{ $supplier->kd_supp }}>{{ $supplier->nama.' - '.$supplier->kd_supp }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <div class="col-sm-3">
                  {!! Form::label('problem_st', 'Problem Status') !!}
                  {!! Form::select('problem_st', ['ALL' => 'ALL', 'DELAY ARRIVAL TIME' => 'DELAY ARRIVAL TIME', 'SHORTAGE PARTS' => 'SHORTAGE PARTS', 'MISPACKING PARTS' => 'MISPACKING PARTS', 'OTHERS' => 'OTHERS'], 'ALL', ['class'=>'form-control select2', 'id' => 'problem_st']) !!}
                </div>
                <div class="col-sm-2">
                  {!! Form::label('st_ls', 'L/S') !!}
                  {!! Form::select('st_ls', ['ALL' => 'ALL', 'T' => 'YA', 'F' => 'TIDAK'], 'ALL', ['class'=>'form-control select2', 'id' => 'st_ls']) !!}
                </div>
                <div class="col-sm-3">
                  {!! Form::label('status', 'Status DEPR') !!}
                  <select size="1" id="status" name="status" class="form-control select2">
                    <option value="ALL">ALL</option>
                    <option value="1">Belum Submit</option>
                    <option value="2" selected="selected">Sudah Submit</option>
                    <option value="3">Approve Section</option>
                    <option value="4">Reject Section</option>
                    <option value="5">Approve Dept. Head</option>
                    <option value="6">Reject Dept. Head</option>
                    <option value="7">Sudah PICA</option>
                    <option value="8">Close PRC</option>
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
                    <th style="width: 1%;">No</th>
                    <th style="text-align: center;width: 2%;"><input type="checkbox" name="chk-all" id="chk-all" class="icheckbox_square-blue"></th>
                    <th style="width: 15%;">No. DEPR</th>
                    <th style="width: 5%;">Tgl</th>
                    <th style="width: 25%;">Supplier</th>
                    <th style="width: 15%;">Status Problem</th>
                    <th>Problem Tittle</th>
                    <th>Site</th>
                    <th>Problem Others</th>
                    <th>Line Stop</th>
                    <th>Jumlah Menit</th>
                    <th>Keterangan Problem</th>
                    <th>Problem Standard</th>
                    <th>Problem Actual</th>
                    <th>Creaby</th>
                    <th>Submit</th>
                    <th>Approve Section</th>
                    <th>Reject Section</th>
                    <th>Approve Dept. Head</th>
                    <th>Reject Dept. Head</th>
                    <th>No. PICA</th>
                    <th style="width: 5%;">Status</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.box-body -->

            @permission(['ppc-dpr-apr-sh'])
              <div class="box-footer">
                <button id="btnapprove" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Approve SH DEPR">
                  <span class="glyphicon glyphicon-check"></span> Approve SH DEPR
                </button>
                <button id="btnreject" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Reject SH DEPR">
                  <span class="glyphicon glyphicon-remove"></span> Reject SH DEPR
                </button>
              </div>
              <!-- /.box -->
            @endpermission
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

  document.getElementById("kd_site").focus();

  //Initialize Select2 Elements
  $(".select2").select2();
  
  $(document).ready(function(){

    var url = '{{ route('dashboardsh.ppctdprs') }}';
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
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'action2', name: 'action2', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'no_dpr', name: 'no_dpr'},
        {data: 'tgl_dpr', name: 'tgl_dpr'},
        {data: 'kd_bpid', name: 'kd_bpid'},
        {data: 'problem_st', name: 'problem_st'},
        {data: 'problem_title', name: 'problem_title'},
        {data: 'kd_site', name: 'kd_site', className: "none"},
        {data: 'problem_oth', name: 'problem_oth', className: "none"},
        {data: 'st_ls', name: 'st_ls', className: "none"},
        {data: 'jml_ls_menit', name: 'jml_ls_menit', className: "none"},
        {data: 'problem_ket', name: 'problem_ket', className: "none"},
        {data: 'problem_std', name: 'problem_std', className: "none"},
        {data: 'problem_act', name: 'problem_act', className: "none"},
        {data: 'opt_creaby', name: 'opt_creaby', className: "none"},
        {data: 'opt_submit', name: 'opt_submit', className: "none", orderable: false, searchable: false},
        {data: 'sh_aprov', name: 'sh_aprov', className: "none", orderable: false, searchable: false},
        {data: 'sh_reject', name: 'sh_reject', className: "none", orderable: false, searchable: false},
        {data: 'dh_aprov', name: 'dh_aprov', className: "none", orderable: false, searchable: false},
        {data: 'dh_reject', name: 'dh_reject', className: "none", orderable: false, searchable: false},
        {data: 'no_id', name: 'no_id', className: "none", orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.kd_site = $('select[name="kd_site"]').val();
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
      data.kd_supp = $('select[name="kd_supp"]').val();
      data.problem_st = $('select[name="problem_st"]').val();
      data.st_ls = $('select[name="st_ls"]').val();
      data.status = $('select[name="status"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    $("#chk-all").change(function() {
      for($i = 0; $i < tableMaster.rows().count(); $i++) {
        var no = $i + 1;
        var data = tableMaster.cell($i, 1).data();
        var posisi = data.indexOf("chk");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="checkbox" name="', '');
        target = target.replace("<input type='checkbox' name='", '');
        target = target.replace("<input type='checkbox' name=", '');
        target = target.replace('<input name="', '');
        target = target.replace("<input name='", '');
        target = target.replace("<input name=", '');
        target = target +'chk';
        if(document.getElementById(target) != null) {
          document.getElementById(target).checked = this.checked;
        }
      }
    });

    //$('#display').click();

    $('#btnapprove').click( function () {
      var validasi = "F";
      var ids = "-";
      var jmldata = 0;
      var table = $('#tblMaster').DataTable();
      table.search('').columns().search('').draw();

      oTable = $('#tblMaster').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = -1;
      oTable.fnDraw();

      for($i = 0; $i < table.rows().count(); $i++) {
        var no = $i + 1;
        var data = table.cell($i, 1).data();
        var posisi = data.indexOf("chk");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="checkbox" name="', '');
        target = target.replace("<input type='checkbox' name='", '');
        target = target.replace("<input type='checkbox' name=", '');
        target = target.replace('<input name="', '');
        target = target.replace("<input name='", '');
        target = target.replace("<input name=", '');
        target = target +'chk';
        if(document.getElementById(target) != null) {
          var checkedOld = document.getElementById(target).checked;
          data = data.replace(target, 'row-' + no + '-chk');
          data = data.replace(target, 'row-' + no + '-chk');
          table.cell($i, 1).data(data);
          posisi = data.indexOf("chk");
          target = data.substr(0, posisi);
          target = target.replace('<input type="checkbox" name="', '');
          target = target.replace("<input type='checkbox' name='", '');
          target = target.replace("<input type='checkbox' name=", '');
          target = target.replace('<input name="', '');
          target = target.replace("<input name='", '');
          target = target.replace("<input name=", '');
          target = target +'chk';
          document.getElementById(target).checked = checkedOld;
          var checked = document.getElementById(target).checked;
          if(checked == true) {
            var no_dpr = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_dpr;
            } else {
              ids = ids + "#quinza#" + no_dpr;
            }
            jmldata = jmldata + 1;
          }
        }
      }

      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Anda yakin Approve SH DEPR tsb?',
          text: 'Jumlah DEPR: ' + jmldata,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="glyphicon glyphicon-thumbs-up"></i> Yes, Approve!',
          cancelButtonText: '<i class="glyphicon glyphicon-thumbs-down"></i> No, Cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          var token = document.getElementsByName('_token')[0].value.trim();
          var formData = new FormData();
          formData.append('_method', 'POST');
          formData.append('_token', token);
          formData.append('ids', ids);
          formData.append('status_approve', window.btoa('SECTION'));

          var url = "{{ route('ppctdprs.approve')}}";
          $("#loading").show();
          $.ajax({
            type     : 'POST',
            url      : url,
            dataType : 'json',
            data     : formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
              $("#loading").hide();
              if(data.status === 'OK'){
                swal("Approved", data.message, "success");

                oTable = $('#tblMaster').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 5;
                oTable.fnDraw();

                var table = $('#tblMaster').DataTable();
                table.ajax.reload(null, false);
              } else {
                swal("Cancelled", data.message, "error");

                oTable = $('#tblMaster').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 5;
                oTable.fnDraw();
              }
            }, error:function(){ 
              $("#loading").hide();
              swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");

              oTable = $('#tblMaster').dataTable();
              var oSettings = oTable.fnSettings();
              oSettings._iDisplayLength = 5;
              oTable.fnDraw();
            }
          });
        }, function (dismiss) {
          if (dismiss === 'cancel') {
            // 
          }
          oTable = $('#tblMaster').dataTable();
          var oSettings = oTable.fnSettings();
          oSettings._iDisplayLength = 5;
          oTable.fnDraw();
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");

        oTable = $('#tblMaster').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = 5;
        oTable.fnDraw();
      }
    });

    $('#btnreject').click( function () {
      var validasi = "F";
      var ids = "-";
      var jmldata = 0;
      var table = $('#tblMaster').DataTable();
      table.search('').columns().search('').draw();

      oTable = $('#tblMaster').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = -1;
      oTable.fnDraw();

      for($i = 0; $i < table.rows().count(); $i++) {
        var no = $i + 1;
        var data = table.cell($i, 1).data();
        var posisi = data.indexOf("chk");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="checkbox" name="', '');
        target = target.replace("<input type='checkbox' name='", '');
        target = target.replace("<input type='checkbox' name=", '');
        target = target.replace('<input name="', '');
        target = target.replace("<input name='", '');
        target = target.replace("<input name=", '');
        target = target +'chk';
        if(document.getElementById(target) != null) {
          var checkedOld = document.getElementById(target).checked;
          data = data.replace(target, 'row-' + no + '-chk');
          data = data.replace(target, 'row-' + no + '-chk');
          table.cell($i, 1).data(data);
          posisi = data.indexOf("chk");
          target = data.substr(0, posisi);
          target = target.replace('<input type="checkbox" name="', '');
          target = target.replace("<input type='checkbox' name='", '');
          target = target.replace("<input type='checkbox' name=", '');
          target = target.replace('<input name="', '');
          target = target.replace("<input name='", '');
          target = target.replace("<input name=", '');
          target = target +'chk';
          document.getElementById(target).checked = checkedOld;
          var checked = document.getElementById(target).checked;
          if(checked == true) {
            var no_dpr = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_dpr;
            } else {
              ids = ids + "#quinza#" + no_dpr;
            }
            jmldata = jmldata + 1;
          }
        }
      }

      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Anda yakin Reject SH DEPR tsb?',
          text: 'Jumlah DEPR: ' + jmldata,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="glyphicon glyphicon-thumbs-up"></i> Yes, Reject!',
          cancelButtonText: '<i class="glyphicon glyphicon-thumbs-down"></i> No, Cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
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
            var formData = new FormData();
            formData.append('_method', 'POST');
            formData.append('_token', token);
            formData.append('ids', ids);
            formData.append('status_reject', window.btoa('SECTION'));
            formData.append('keterangan_reject', result);

            var url = "{{ route('ppctdprs.reject')}}";
            $("#loading").show();
            $.ajax({
              type     : 'POST',
              url      : url,
              dataType : 'json',
              data     : formData,
              cache: false,
              contentType: false,
              processData: false,
              success:function(data){
                $("#loading").hide();
                if(data.status === 'OK'){
                  swal("Rejected", data.message, "success");

                  oTable = $('#tblMaster').dataTable();
                  var oSettings = oTable.fnSettings();
                  oSettings._iDisplayLength = 5;
                  oTable.fnDraw();

                  var table = $('#tblMaster').DataTable();
                  table.ajax.reload(null, false);
                } else {
                  swal("Cancelled", data.message, "error");

                  oTable = $('#tblMaster').dataTable();
                  var oSettings = oTable.fnSettings();
                  oSettings._iDisplayLength = 5;
                  oTable.fnDraw();
                }
              }, error:function(){ 
                $("#loading").hide();
                swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");

                oTable = $('#tblMaster').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 5;
                oTable.fnDraw();
              }
            });
          }).catch(swal.noop)
        }, function (dismiss) {
          if (dismiss === 'cancel') {
            // 
          }
          oTable = $('#tblMaster').dataTable();
          var oSettings = oTable.fnSettings();
          oSettings._iDisplayLength = 5;
          oTable.fnDraw();
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");

        oTable = $('#tblMaster').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = 5;
        oTable.fnDraw();
      }
    });
  });
</script>
@endsection