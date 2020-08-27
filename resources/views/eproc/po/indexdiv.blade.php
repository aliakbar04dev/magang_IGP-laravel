@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Approval PO Div. Head
        <small>Approval PO Div. Head</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PO</li>
        <li class="active"><i class="fa fa-files-o"></i> Approval PO DIV</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Approval PO Div. Head</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblawal', 'Tgl Awal') !!}
  		      	{!! Form::date('filter_tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_tgl_awal']) !!}
    		    </div>
    		    <div class="col-sm-2">
  		      	{!! Form::label('lblakhir', 'Tgl Akhir') !!}
  		      	{!! Form::date('filter_tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'filter_tgl_akhir']) !!}
    		    </div>
            <div class="col-sm-2">
              {!! Form::label('lblsite', 'Site') !!}
              <select name="filter_site" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                <option value="IGPJ">IGP - JAKARTA</option>
                <option value="IGPK">IGP - KARAWANG</option>
              </select>
            </div>
    		  </div>
    		  <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lbldep', 'Departemen') !!}
              <select name="filter_dep" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                @foreach($deps->get() as $dep)
                  <option value="{{$dep->kd_dep}}">{{$dep->nm_dep}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblstatus', 'Status Approval') !!}
              <select name="filter_status" aria-controls="filter_status" class="form-control select2">
                <option value="ALL">ALL</option>
                <option value="B">Belum</option>
                <option value="PIC">Approve PIC</option>
                <option value="RPIC">Reject PIC</option>
                <option value="SEC">Approve Section</option>
                <option value="RSEC">Reject Section</option>
                <option value="DEP" selected="selected">Approve Dep Head</option>
                <option value="RDEP">Reject Dep Head</option>
                <option value="DIV">Approve Div Head</option>
                <option value="RDIV">Reject Div Head</option>
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
                <th style="width: 10%;">No. PO</th>
                <th style="width: 10%;">Tgl PO</th>
                <th style="width: 25%;">Supplier</th>
                <th style="width: 11%;">Mata Uang</th>
                <th>Ref A</th>
                <th style="width: 8%;">Print</th>
                <th style="width: 10%;">Action</th>
                <th>Revisi</th>
                <th>Pembuat PO</th>
                <th>Jenis PO</th>
                <th>Approve PIC</th>
                <th>Reject PIC</th>
                <th>Approve Section</th>
                <th>Reject Section</th>
                <th>Approve Dep Head</th>
                <th>Reject Dep Head</th>
                <th>Approve Div Head</th>
                <th>Reject Div Head</th>
                <th>Status Tampil</th>
                <th>PIC Print</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->

        @permission('prc-po-apr-div')
          <div class="box-footer">
            <button id="btnapprove" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Approve PO DIV">
              <span class="glyphicon glyphicon-check"></span> Approve PO DIV
            </button>
            <button id="btnreject" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Reject PO DIV">
              <span class="glyphicon glyphicon-remove"></span> Reject PO DIV
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
                  <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 1%;">No</th>
                        <th style="width: 5%;">PONO</th>
                        <th style="width: 10%;">No PP</th>
                        <th style="width: 15%;">Item No</th>
                        <th>Description</th>
                        <th style="width: 10%;">Qty PO</th>
                        <th style="width: 5%;">Satuan</th>
                        <th style="width: 12%;">Harga Unit</th>
                        <th style="width: 12%;">Jumlah</th>
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

  function approve(no_po, status)
  {
    var msg = 'Anda yakin APPROVE No. PO ' + no_po + '?';
    if(status === "SEC") {
      msg = 'Anda yakin APPROVE (Section) No. PO ' + no_po + '?';
    } else if(status === "DEP") {
      msg = 'Anda yakin APPROVE (Dep Head) No. PO ' + no_po + '?';
    } else if(status === "DIV") {
      msg = 'Anda yakin APPROVE (Div Head) No. PO ' + no_po + '?';
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
      if(status === "DEP") {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('baanpo1s.approve')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method        : 'POST',
            // menambah csrf token dari Laravel
            _token         : token,
            no_po          : window.btoa(no_po),
            status_approve : window.btoa(status),
            st_tampil      : window.btoa("X")
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
      } else if(status === "DIV") {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('baanpo1s.approve')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method        : 'POST',
            // menambah csrf token dari Laravel
            _token         : token,
            no_po          : window.btoa(no_po),
            status_approve : window.btoa(status),
            st_tampil      : window.btoa("T")
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
      }
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

  function reject(no_po, status)
  {
    var msg = 'Anda yakin REJECT No. PO ' + no_po + '?';
    if(status === "SEC") {
      msg = 'Anda yakin REJECT (Section) No. PO ' + no_po + '?';
    } else if(status === "DEP") {
      msg = 'Anda yakin REJECT (Dep Head) No. PO ' + no_po + '?';
    } else if(status === "DIV") {
      msg = 'Anda yakin REJECT (Div Head) No. PO ' + no_po + '?';
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
        var url = "{{ route('baanpo1s.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            no_po             : window.btoa(no_po),
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
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('baanpo1s.dashboarddiv') }}",
      columns: [
        {data: null, name: null, className: "dt-center"}, 
        {data: 'action2', name: 'action2', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'no_po', name: 'no_po'},
        {data: 'tgl_po', name: 'tgl_po', className: "dt-center"},
        {data: 'nm_supp', name: 'nm_supp'},
        {data: 'kd_curr', name: 'kd_curr', className: "dt-center"},
        {data: 'refa', name: 'refa'},
        {data: 'status', name: 'status', className: "dt-center", orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false},
        {data: 'no_revisi', name: 'no_revisi', className: "none", orderable: false, searchable: false},
        {data: 'usercreate', name: 'usercreate', className: "none", orderable: false, searchable: false},
        {data: 'jns_po', name: 'jns_po', className: "none", orderable: false, searchable: false},
        {data: 'apr_pic_npk', name: 'apr_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_pic_npk', name: 'rjt_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_sh_npk', name: 'apr_sh_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_sh_npk', name: 'rjt_sh_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_dep_npk', name: 'apr_dep_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_dep_npk', name: 'rjt_dep_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_div_npk', name: 'apr_div_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_div_npk', name: 'rjt_div_npk', className: "none", orderable: false, searchable: false},
        {data: 'st_tampil', name: 'st_tampil', className: "none", orderable: false, searchable: false}, 
        {data: 'print_supp_pic', name: 'print_supp_pic', className: "none", orderable: false, searchable: false}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'Detail PO';
        initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var no_po = tableMaster.cell(index, 2).data();
          document.getElementById("info-detail").innerHTML = 'Detail PO (' + no_po + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable(window.btoa(no_po.replace(regex, "")));
        }
      }
    });

    var url = '{{ route('baanpo1s.detail', ['param','param2']) }}';
    url = url.replace('param2', window.btoa("P"));
    url = url.replace('param', window.btoa("-"));
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
      "order": [[1, 'asc'],[2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'pono_po', name: 'pono_po', className: "dt-center"},
        { data: 'no_pp', name: 'no_pp'},
        { data: 'item_no', name: 'item_no'},
        { data: 'item_name', name: 'item_name'},
        { data: 'qty_po', name: 'qty_po', className: "dt-right"},
        { data: 'unit', name: 'unit', className: "dt-center"},
        { data: 'hrg_unit', name: 'hrg_unit', className: "dt-right"},
        { data: 'jumlah', name: 'jumlah', className: "dt-right"}
      ],
    });

    function initTable(data) {
      tableDetail.search('').columns().search('').draw();
      var url = '{{ route('baanpo1s.detail', ['param','param2']) }}';
      url = url.replace('param2', window.btoa("P"));
      url = url.replace('param', data);
      tableDetail.ajax.url(url).load();
    }

    $(function() {
      $('\
        <div id="filter_cetak" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Print\
          <select size="1" name="filter_cetak" aria-controls="filter_status" \
            class="form-control select2" style="width: 100px;">\
              <option value="ALL" selected="selected">ALL</option>\
              <option value="T">SUDAH</option>\
              <option value="F">BELUM</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.awal = $('input[name="filter_tgl_awal"]').val();
        data.akhir = $('input[name="filter_tgl_akhir"]').val();
        data.kd_site = $('select[name="filter_site"]').val();
        data.kd_dep = $('select[name="filter_dep"]').val();
        data.status = $('select[name="filter_status"]').val();
        data.cetak = $('select[name="filter_cetak"]').val();
      });

      $('select[name="filter_cetak"]').change(function() {
        document.getElementById("info-detail").innerHTML = 'Detail PO';
        tableMaster.ajax.reload( function ( json ) {
          if(tableMaster.rows().count() > 0) {
            $('#tblMaster tbody tr:eq(0)').click(); 
          } else {
            initTable(window.btoa('-'));
          }
        });
      });
    });

    $('#display').click( function () {
      document.getElementById("info-detail").innerHTML = 'Detail PO';
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('-'));
        }
      });
    });

    // $('#display').click();

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
          title: 'Anda yakin Approve PO tsb?',
          text: 'Jumlah PO: ' + jmldata,
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
          formData.append('st_tampil', window.btoa('T'));

          var url = "{{ route('baanpo1s.approvediv')}}";
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
          title: 'Anda yakin Reject PO tsb?',
          text: 'Jumlah PO: ' + jmldata,
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

            var url = "{{ route('baanpo1s.rejectdiv')}}";
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
</script>
@endsection