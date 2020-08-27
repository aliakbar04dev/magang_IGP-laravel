@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        CR Activities [Div]
        <small>CR Activities [Approval Div. Head]</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - TRANSAKSI</li>
        <li class="active"><i class="fa fa-files-o"></i> CR Activities [Div]</li>
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
                  {!! Form::label('filter_tahun', 'Tahun') !!}
                  <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
                  class="form-control select2" onchange="updatePeriode()">
                    @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                      @if ($i == \Carbon\Carbon::now()->format('Y'))
                        <option value={{ $i }} selected="selected">{{ $i }}</option>
                      @else
                        <option value={{ $i }}>{{ $i }}</option>
                      @endif
                    @endfor
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('status_periode', 'Periode') !!}
                  {!! Form::text('status_periode', null, ['class'=>'form-control', 'placeholder' => 'Periode', 'id' => 'status_periode', 'disabled' => '']) !!}
                </div>
                <div class="col-sm-3">
                  {!! Form::label('filter_status', 'Status') !!}
                  {!! Form::select('filter_status', ['ALL' => 'ALL', '1' => 'DRAFT', '2' => 'SUBMIT', '3' => 'APPROVE DEPT', '4' => 'REJECT DEPT', '5' => 'APPROVE DIV', '6' => 'REJECT DIV', '7' => 'APPROVE BUDGET', '8' => 'REJECT BUDGET'], null, ['class'=>'form-control select2', 'id' => 'filter_status']) !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <div class="col-sm-7">
                  {!! Form::label('lbldep', 'Department # Division') !!}
                  <select name="filter_dep" aria-controls="filter_status" class="form-control select2" multiple="multiple">
                    @foreach($vw_dep_budgets->get() as $kode)
                      <option value="{{$kode->kd_dep}}">{{$kode->desc_dep}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lbldisplay', 'Action') !!}
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
                    <th style="width: 5%;">Tahun</th>
                    <th>Rev</th>
                    <th>Activity</th>
                    <th style="width: 10%;">Classification</th>
                    <th style="width: 20%;">CR Categories</th>
                    <th style="width: 10%;">Departemen</th>
                    <th style="width: 15%;">Status</th>
                    <th>Divisi</th>
                    <th>Creaby</th>
                    <th>Modiby</th>
                    <th>Submit</th>
                    <th>Approve Dept</th>
                    <th>Reject Dept</th>
                    <th>Approve Div</th>
                    <th>Reject Div</th>
                    <th>Approve Budget</th>
                    <th>Reject Budget</th>
                    <th>ID</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.box-body -->

            @permission('budget-cr-activities-approve-div')
              <div class="box-footer">
                <button id="btnapprove" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Approve Div. Head">
                  <span class="glyphicon glyphicon-check"></span> Approve Div. Head
                </button>
                <button id="btnreject" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Reject Div. Head">
                  <span class="glyphicon glyphicon-remove"></span> Reject Div. Head
                </button>
              </div>
              <!-- /.box -->
            @endpermission

            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><p id="info-detail">Detail</p></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th rowspan="2" style="width: 5%;">No</th>
                            <th rowspan="2">Bulan</th>
                            <th colspan="2" style="width: 35%;text-align: center">Plan</th>
                            <th colspan="2" style="width: 35%;text-align: center">Actual</th>
                          </tr>
                          <tr>
                            <th style="width: 15%;">Man Power</th>
                            <th style="width: 20%;">Amount</th>
                            <th style="width: 15%;">Man Power</th>
                            <th style="width: 20%;">Amount</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </tfoot>
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
      // "order": [[2, 'desc'],[4, 'asc']],
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('bgttcrregiss.dashboarddiv') }}",
      columns: [
      	{data: null, name: null},
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'thn', name: 'thn', className: "dt-center"},
        {data: 'no_rev', name: 'no_rev', className: "none"},
        {data: 'nm_aktivitas', name: 'nm_aktivitas'},
        {data: 'nm_klasifikasi', name: 'nm_klasifikasi'},
        {data: 'nm_kategori', name: 'nm_kategori'},
        {data: 'kd_dep', name: 'kd_dep'},
        {data: 'status', name: 'status', orderable: false, searchable: false},
        {data: 'kd_div', name: 'kd_div', className: "none", orderable: false, searchable: false},
        {data: 'creaby', name: 'creaby', className: "none", orderable: false, searchable: false},
        {data: 'modiby', name: 'modiby', className: "none", orderable: false, searchable: false},
        {data: 'submit_by', name: 'submit_by', className: "none", orderable: false, searchable: false},
        {data: 'apr_dep_by', name: 'apr_dep_by', className: "none", orderable: false, searchable: false},
        {data: 'rjt_dep_by', name: 'rjt_dep_by', className: "none", orderable: false, searchable: false},
        {data: 'apr_div_by', name: 'apr_div_by', className: "none", orderable: false, searchable: false},
        {data: 'rjt_div_by', name: 'rjt_div_by', className: "none", orderable: false, searchable: false},
        {data: 'apr_bgt_by', name: 'apr_bgt_by', className: "none", orderable: false, searchable: false},
        {data: 'rjt_bgt_by', name: 'rjt_bgt_by', className: "none", orderable: false, searchable: false},
        {data: 'id', name: 'id', className: "none", orderable: false, searchable: false}
      ]
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail';
        initTable(window.btoa('0'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var thn = tableMaster.cell(index, 2).data();
          var nm_aktivitas = tableMaster.cell(index, 4).data();
          var nm_klasifikasi = tableMaster.cell(index, 5).data();
          var nm_kategori = tableMaster.cell(index, 6).data();
          var id_pk = tableMaster.cell(index, 19).data();
          var info = "Activity: " + nm_aktivitas + ", Tahun: " + thn + ", Classification: " + nm_klasifikasi + ", CR Categories: " + nm_kategori;
          document.getElementById("info-detail").innerHTML = 'Detail (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(id_pk));
        }
      }
    });

    var url = '{{ route('bgttcrregiss.detail', 'param') }}';
    url = url.replace('param', window.btoa("0"));
    var tableDetail = $('#tblDetail').DataTable({
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
      // serverSide: true,
      // searching: false, 
      paging: false, 
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'bulan', name: 'bulan'},
        {data: 'jml_mp', name: 'jml_mp', className: "dt-right"},
        {data: 'amount', name: 'amount', className: "dt-right"},
        {data: 'jml_mp_act', name: 'jml_mp_act', className: "dt-right"},
        {data: 'amount_act', name: 'amount_act', className: "dt-right"}
      ], 
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === 'string' ?
          i.replace(/[\$,]/g, '')*1 :
          typeof i === 'number' ?
          i : 0;
        };

        var column = 2;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 3;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 4;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 5;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );
      }
    });

    function initTable(data) {
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('bgttcrregiss.detail', 'param') }}';
      url = url.replace('param', data);
      tableDetail.ajax.url(url).load();
    }

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tahun = $('select[name="filter_tahun"]').val();
      data.status = $('select[name="filter_status"]').val();
      data.kd_dep = $('select[name="filter_dep"]').val();
    });

    $('#display').click( function () {
      document.getElementById("info-detail").innerHTML = 'Detail';
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('0'));
        }
      });
    });

    $("#chk-all").change(function() {
      $("#loading").show();
      var table = $('#tblMaster').DataTable();
      table.search('').columns().search('').draw();

      oTable = $('#tblMaster').dataTable();
      var oSettings = oTable.fnSettings();
      var displaylength = oSettings._iDisplayLength;
      oSettings._iDisplayLength = -1;
      oTable.fnDraw();

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

      oTable = $('#tblMaster').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = displaylength;
      oTable.fnDraw();
      $("#loading").hide();
    });

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
            var no_id = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_id;
            } else {
              ids = ids + "#quinza#" + no_id;
            }
            jmldata = jmldata + 1;
          }
        }
      }

      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Anda yakin Approve Activity tsb?',
          text: 'Jumlah Activity: ' + jmldata,
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
          formData.append('status_approve', window.btoa('DIV'));

          var url = "{{ route('bgttcrregiss.approvediv')}}";
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
                oSettings._iDisplayLength = 10;
                oTable.fnDraw();

                var table = $('#tblMaster').DataTable();
                table.ajax.reload(null, false);
              } else {
                swal("Cancelled", data.message, "error");

                oTable = $('#tblMaster').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 10;
                oTable.fnDraw();
              }
            }, error:function(){ 
              $("#loading").hide();
              swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");

              oTable = $('#tblMaster').dataTable();
              var oSettings = oTable.fnSettings();
              oSettings._iDisplayLength = 10;
              oTable.fnDraw();
            }
          });
        }, function (dismiss) {
          if (dismiss === 'cancel') {
            // 
          }
          oTable = $('#tblMaster').dataTable();
          var oSettings = oTable.fnSettings();
          oSettings._iDisplayLength = 10;
          oTable.fnDraw();
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");

        oTable = $('#tblMaster').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = 10;
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
            var no_id = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_id;
            } else {
              ids = ids + "#quinza#" + no_id;
            }
            jmldata = jmldata + 1;
          }
        }
      }

      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Anda yakin Reject Activity tsb?',
          text: 'Jumlah Activity: ' + jmldata,
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
            formData.append('status_reject', window.btoa('DIV'));
            formData.append('keterangan_reject', result);

            var url = "{{ route('bgttcrregiss.rejectdiv')}}";
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
                  oSettings._iDisplayLength = 10;
                  oTable.fnDraw();

                  var table = $('#tblMaster').DataTable();
                  table.ajax.reload(null, false);
                } else {
                  swal("Cancelled", data.message, "error");

                  oTable = $('#tblMaster').dataTable();
                  var oSettings = oTable.fnSettings();
                  oSettings._iDisplayLength = 10;
                  oTable.fnDraw();
                }
              }, error:function(){ 
                $("#loading").hide();
                swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");

                oTable = $('#tblMaster').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 10;
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
          oSettings._iDisplayLength = 10;
          oTable.fnDraw();
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");

        oTable = $('#tblMaster').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = 10;
        oTable.fnDraw();
      }
    });
  });

  function updatePeriode() {
    var tahun = document.getElementById("filter_tahun").value;
    var periode = "CLOSE";
    document.getElementById("status_periode").value = periode;
    var url = '{{ route('bgttcrregiss.periode', 'param') }}';
    url = url.replace('param', window.btoa(tahun));
    $.get(url, function(result){  
      if(result !== 'null'){
        result = JSON.parse(result);
        if(result["st_budget_plan"] === "T") {
          periode = "OPEN";
        }
        document.getElementById("status_periode").value = periode;
      }
    });
  }

  updatePeriode();
</script>
@endsection