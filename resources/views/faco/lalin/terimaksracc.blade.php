@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lalu Lintas
        <small>Terima Kasir ke Accounting</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> FACO - Lalu Lintas</li>
        <li><a href="{{ route('lalins.indexksracc') }}"><i class="fa fa-files-o"></i> Kasir ke Accounting</a></li>
        <li class="active">Terima {{ $data->no_lka }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Terima Kasir ke Accounting</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. Serah Terima</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $data->no_lka }}</td>
                    <td style="width: 8%;"><b>Tanggal</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ \Carbon\Carbon::parse($data->tgl_lka)->format('d/m/Y') }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Keterangan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $data->ket_lka }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $data->creaby }} - {{ Auth::user()->namaByNpk($data->creaby) }} - {{ \Carbon\Carbon::parse($data->dtcrea)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @if (!empty($data->dtmodi))
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $data->modiby }} - {{ Auth::user()->namaByNpk($data->modiby) }} - {{ \Carbon\Carbon::parse($data->dtmodi)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail TT / PP</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $data->no_lka }}">
              <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th style="text-align: center;width: 2%;"><input type="checkbox" name="chk-all" id="chk-all" class="icheckbox_square-blue"></th>
                    <th style="width: 12%;">No. TT / PP</th>
                    <th>Supplier</th>
                    <th style="width: 10%;">Tgl JTempo</th>
                    <th style="width: 5%;">MU</th>
                    <th style="width: 10%;">Nilai DPP</th>
                    <th style="width: 10%;">PPn (IDR)</th>
                    <th style="width: 5%;">Batch</th>
                    <th>PIC Serah</th>
                    <th>PIC Tarik</th>
                    <th>ACC ke FIN</th>
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

      <div class="box-footer">
        @if (Auth::user()->can('faco-lalin-ksr-acc-approve'))
          <button id="btnupdate" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Update Data">
            <span class="glyphicon glyphicon-check"></span> Update Data
          </button>
          &nbsp;&nbsp;
        @endif
        <a class="btn bg-black" href="{{ route('lalins.indexksracc') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Daftar Kasir ke Accounting">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){
    var no_lka = $('#field').data("field-id");
    var url = '{{ route('lalins.detailksracc', 'param') }}';
    url = url.replace('param', window.btoa(no_lka));
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
      // "order": [[2, 'asc']],
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'action_terima', name: 'action_delete', className: "dt-center", orderable: false, searchable: false}, 
        {data: 'no_voucher', name: 'no_voucher'},
        {data: 'nm_bpid', name: 'nm_bpid'},
        {data: 'tgl_jtempo', name: 'tgl_jtempo', className: "dt-center"},
        {data: 'ccur', name: 'ccur', className: "dt-center"},
        {data: 'amnt', name: 'amnt', className: "dt-right"},
        {data: 'vath1', name: 'vath1', className: "dt-right"},
        {data: 'no_batch', name: 'no_batch', className: "dt-right"},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'pic_terima', name: 'pic_terima', className: "none", orderable: false, searchable: false},
        {data: 'no_laf', name: 'no_laf', className: "none"}
      ]
    });

    $('#btnupdate').click( function () {
      var validasi = "T";
      var ids = "-";
      var jmldata = 0;
      var table = $('#tblDetail').DataTable();
      table.search('').columns().search('').draw();

      oTable = $('#tblDetail').dataTable();
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
            var no_voucher = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_voucher;
            } else {
              ids = ids + "#quinza#" + no_voucher;
            }
            jmldata = jmldata + 1;
          }
        }
      }

      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Anda yakin Update Data tsb?',
          text: 'Jumlah Voucher diterima: ' + jmldata,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="glyphicon glyphicon-thumbs-up"></i> Yes, Update!',
          cancelButtonText: '<i class="glyphicon glyphicon-thumbs-down"></i> No, Cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          var token = document.getElementsByName('_token')[0].value.trim();
          var formData = new FormData();
          formData.append('_method', 'PUT');
          formData.append('_token', token);
          formData.append('ids', ids);
          formData.append('st_serah', 'LKA');

          var no_lka = $('#field').data("field-id");
          var url = "{{ route('lalins.update', 'param')}}";
          url = url.replace('param', window.btoa(no_lka));
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
                swal("Updated", data.message, "success");

                oTable = $('#tblDetail').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 10;
                oTable.fnDraw();

                var table = $('#tblDetail').DataTable();
                table.ajax.reload(null, false);
              } else {
                swal("Cancelled", data.message, "error");

                oTable = $('#tblDetail').dataTable();
                var oSettings = oTable.fnSettings();
                oSettings._iDisplayLength = 10;
                oTable.fnDraw();
              }
            }, error:function(){ 
              $("#loading").hide();
              swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");

              oTable = $('#tblDetail').dataTable();
              var oSettings = oTable.fnSettings();
              oSettings._iDisplayLength = 10;
              oTable.fnDraw();
            }
          });
        }, function (dismiss) {
          if (dismiss === 'cancel') {
            // 
          }
          oTable = $('#tblDetail').dataTable();
          var oSettings = oTable.fnSettings();
          oSettings._iDisplayLength = 10;
          oTable.fnDraw();
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");
        oTable = $('#tblDetail').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = 10;
        oTable.fnDraw();
      }
    });
  });

  $("#chk-all").change(function() {
    var tableDetail = $('#tblDetail').DataTable();
    for($i = 0; $i < tableDetail.rows().count(); $i++) {
      var no = $i + 1;
      var data = tableDetail.cell($i, 1).data();
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
</script>
@endsection