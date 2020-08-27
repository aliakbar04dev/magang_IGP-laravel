<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_laf') ? ' has-error' : '' }}">
      {!! Form::hidden('st_serah', "LAF", ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_serah']) !!}
      {!! Form::hidden('vouchers', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'vouchers']) !!}
      {!! Form::label('no_laf', 'No. Serah Terima (*)') !!}
      {!! Form::text('no_laf', null, ['class' => 'form-control', 'placeholder' => 'No. Serah Terima', 'readonly' => 'readonly']) !!}
      {!! $errors->first('no_laf', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('tgl_laf') ? ' has-error' : '' }}">
      {!! Form::label('tgl_laf', 'Tanggal Serah (*)') !!}
      @if (empty($model->tgl_laf))
        {!! Form::date('tgl_laf', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Tanggal Serah', 'disabled' => '']) !!}
      @else
        {!! Form::date('tgl_laf', \Carbon\Carbon::parse($model->tgl_laf), ['class' => 'form-control','placeholder' => 'Tanggal Serah', 'disabled' => '']) !!}
      @endif
      {!! $errors->first('tgl_laf', '<p class="help-block">:message</p>') !!}
    </div>
    @if (!empty($model->no_laf))
      <div class="col-sm-4">
        {!! Form::label('info', 'Total Serah ke Finance/Total Voucher Dari Kasir') !!}
        {!! Form::text('info', $info, ['class' => 'form-control', 'placeholder' => 'Total Serah ke Finance/Total Voucher Dari Kasir', 'disabled' => '']) !!}
      </div>
    @endif
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-6 {{ $errors->has('ket_laf') ? ' has-error' : '' }}">
      {!! Form::label('ket_laf', 'Keterangan') !!}
      @if (empty($model->no_laf))
        {!! Form::text('ket_laf', 'ACCOUNTING KE FINANCE', ['class' => 'form-control', 'placeholder' => 'Keterangan', 'maxlength' => 50]) !!}
      @else
        @if($jml_tarik > 0)
          {!! Form::text('ket_laf', null, ['class' => 'form-control', 'placeholder' => 'Keterangan', 'maxlength' => 50, 'readonly' => 'readonly']) !!}
        @else 
          {!! Form::text('ket_laf', null, ['class' => 'form-control', 'placeholder' => 'Keterangan', 'maxlength' => 50]) !!}
        @endif
      @endif
      {!! $errors->first('ket_laf', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2">
      {!! Form::label('lblserah', 'Serah T/T atau P/P') !!}
      <button id="btn-serah" type="button" class="form-control btn btn-warning" data-placement="top" title="Serah T/T atau P/P" data-toggle="modal" data-target="#serahModal">Serah T/T atau P/P</button>
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-body">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><p id="info-detail">Detail TT / PP</p></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="tblVoucher" class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 1%;">No</th>
                <th style="width: 12%;">No. TT / PP</th>
                <th>Supplier</th>
                <th style="width: 10%;">Tgl JTempo</th>
                <th style="width: 5%;">MU</th>
                <th style="width: 10%;">Nilai DPP</th>
                <th style="width: 10%;">PPn (IDR)</th>
                <th style="width: 5%;">Batch</th>
                <th>PIC Serah</th>
                <th>PIC Tarik</th>
                <th>KASIR ke ACC</th>
                <th>FIN ke KASIR</th>
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
</div>
<!-- /.box-body -->

<div class="box-footer">
  @if (!empty($model->no_laf))
    @if($jml_tarik > 0)
      {!! Form::submit('Save Data', ['class'=>'btn btn-primary', 'id' => 'btn-save', 'disabled' => '']) !!}
      &nbsp;&nbsp;
      <button id="btn-delete" type="button" class="btn btn-danger" disabled="">Hapus Data</button>
    @else 
      {!! Form::submit('Save Data', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
      &nbsp;&nbsp;
      <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    @endif
  @else 
    {!! Form::submit('Save Data', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @endif
  &nbsp;&nbsp;
  <a class="btn bg-black" href="{{ route('lalins.indexaccfin') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong.', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal T/T P/P -->
@include('faco.lalin.popup.serahModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("ket_laf").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var no_laf = document.getElementById("no_laf").value.trim();
    var msg = 'Anda yakin menghapus No. Serah Terima: ' + no_laf + '?';
    var txt = '';
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('lalins.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_laf));
      window.location.href = urlRedirect;
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
  });

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      var valid = "T";
      var msg = "";
      if(valid !== "T") {
        var info = msg;
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        //additional input validations can be done hear
        swal({
          title: 'Are you sure?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, save it!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          document.getElementById("vouchers").value = "";
          document.getElementById("st_serah").value = "LAF";
          $(e.currentTarget).trigger(e.type, { 'send': true });
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
    }
  });

  $("#btn-serah").click(function(){
    var myHeading = "<p>List No T/T atau P/P</p>";
    $("#serahModalLabel").html(myHeading);
    // $('div.dataTables_filter input').focus();
    var tableDetail = $('#tblDetail').DataTable();
    var url = '{{ route('lalins.popupserahaccfin') }}';
    tableDetail.ajax.url(url).load();
    $('#serahModal').on('hidden.bs.modal', function () {
      
    });
  });

  $("#btn-pilih").click(function(){
    var validasi = "F";
    var no_batch = "";
    
    var tableVoucher = $('#tblVoucher').DataTable();
    if(tableVoucher.rows().count() > 0) {
      var no_batch_temp = tableVoucher.cell(0, 7).data();
      no_batch_temp = no_batch_temp.replace(',', '');
      no_batch = no_batch_temp;
    }

    var ids = "-";
    var jmldata = 0;
    var tableDetail = $('#tblDetail').DataTable();
    tableDetail.search('').columns().search('').draw();
    for($i = 0; $i < tableDetail.rows().count(); $i++) {
      var no = $i + 1;
      var data = tableDetail.cell($i, 0).data();
      var no_batch_temp = tableDetail.cell($i, 1).data();
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
        tableDetail.cell($i, 0).data(data);
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
          if(no_batch === "") {
            no_batch = no_batch_temp;
          }
          if(no_batch === no_batch_temp) {
            var no_tt = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_tt;
            } else {
              ids = ids + "#quinza#" + no_tt;
            }
            jmldata = jmldata + 1;
          } else {
            validasi = "X";
            $i = tableDetail.rows().count();
          }
        }
      }
    }

    if(validasi === "T") {
      var no_laf = document.getElementById("no_laf").value.trim();
      if(no_laf == "") {
        no_laf = "-";
      }
      var st_serah = "LAF";

      var url = '{{ route('lalins.validasiNoTtPp', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(no_laf));
      url = url.replace('param2', window.btoa(st_serah));
      url = url.replace('param', window.btoa(no_batch));
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          validasi = "Y";
          msg = "No. Batch " + no_batch + " sudah diserah pada No. Serah " + result["no_serah"] + ". Silahkan input di No. Serah tsb.";
          swal(msg, "Perhatikan inputan anda!", "warning");
        } else {
          //additional input validations can be done hear
          swal({
            title: 'Anda yakin Serah Data tsb?',
            text: 'Jumlah T/T atau P/P: ' + jmldata,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="glyphicon glyphicon-thumbs-up"></i> Yes!',
            cancelButtonText: '<i class="glyphicon glyphicon-thumbs-down"></i> No, Cancel!',
            allowOutsideClick: true,
            allowEscapeKey: true,
            allowEnterKey: true,
            reverseButtons: false,
            focusCancel: false,
          }).then(function () {
            document.getElementById("vouchers").value = ids;
            document.getElementById("st_serah").value = "LAF";
            document.getElementById("form_id").submit();
          }, function (dismiss) {
            if (dismiss === 'cancel') {
              // 
            }
          })
        }
      });
    } else if(validasi === "X") {
      swal("No. Batch tidak boleh ada yang berbeda.", "Perhatikan inputan anda!", "warning");
    } else {
      swal("Tidak ada data yang dipilih!", "", "warning");
    }
  });

  $("#chk-all").change(function() {
    var tableDetail = $('#tblDetail').DataTable();
    for($i = 0; $i < tableDetail.rows().count(); $i++) {
      var no = $i + 1;
      var data = tableDetail.cell($i, 0).data();
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

  $(document).ready(function(){
    var no_laf = document.getElementById("no_laf").value.trim();
    if(no_laf == "") {
      no_laf = "-";
    }
    var url = '{{ route('lalins.detailaccfin', 'param') }}';
    url = url.replace('param', window.btoa(no_laf));
    var tableVoucher = $('#tblVoucher').DataTable({
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
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'no_voucher', name: 'no_voucher'},
        {data: 'nm_bpid', name: 'nm_bpid'},
        {data: 'tgl_jtempo', name: 'tgl_jtempo', className: "dt-center"},
        {data: 'ccur', name: 'ccur', className: "dt-center"},
        {data: 'amnt', name: 'amnt', className: "dt-right"},
        {data: 'vath1', name: 'vath1', className: "dt-right"},
        {data: 'no_batch', name: 'no_batch', className: "dt-right"},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'pic_terima', name: 'pic_terima', className: "none", orderable: false, searchable: false},
        {data: 'no_lka', name: 'no_lka', className: "none"}, 
        {data: 'no_lfk', name: 'no_lfk', className: "none"},
        {data: 'action_delete', name: 'action_delete', className: "dt-center", orderable: false, searchable: false}
      ]
    });

    var url = '{{ route('lalins.popupserahaccfin', '-') }}';
    var tblDetail = $('#tblDetail').DataTable({
      // "searching": false,
      // "ordering": false,
      "paging": false,
      "scrollX": true,
      "scrollY": "300px",
      "scrollCollapse": true,
      // responsive: true,
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      "order": [[1, 'asc']],
      // serverSide: true,
      ajax: url, 
      columns: [
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false},
        {data: 'no_batch', name: 'no_batch', className: "dt-center"},
        {data: 'no_tt', name: 'no_tt'},
        {data: 'tgl_jtempo', name: 'tgl_jtempo', className: "dt-center"},
        {data: 'supplier', name: 'supplier'},
        {data: 'tgl_dok', name: 'tgl_dok', className: "dt-center"},
        {data: 'ccur', name: 'ccur', className: "dt-center"},
        {data: 'amnt', name: 'amnt', className: "dt-right"}, 
        {data: 'vath1', name: 'vath1', className: "dt-right"}
      ], 
    });
  });

  function deleteDetail(no_laf, no_voucher) {
    var msg = 'Anda yakin menghapus T/T atau P/P: ' + no_voucher + '?';
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      //startcode
      //DELETE DI DATABASE
      // remove these events;
      window.onkeydown = null;
      window.onfocus = null;
      var token = document.getElementsByName('_token')[0].value.trim();
      // delete via ajax
      // hapus data detail dengan ajax
      var url = "{{ route('lalins.deletedetail', ['param','param2']) }}";
      url = url.replace('param2', window.btoa(no_voucher));
      url = url.replace('param', window.btoa(no_laf));
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method : 'DELETE',
          // menambah csrf token dari Laravel
          _token  : token
        },
        success:function(data){
          if(data.status === 'OK'){
            info = "Deleted!";
            info2 = data.message;
            info3 = "success";
            swal(info, info2, info3);
            var tableVoucher = $('#tblVoucher').DataTable();
            tableVoucher.ajax.reload(null, false);
          } else {
            info = "Cancelled";
            info2 = data.message;
            info3 = "error";
            swal(info, info2, info3);
          }
        }, error:function(){ 
          info = "System Error!";
          info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
          info3 = "error";
          swal(info, info2, info3);
        }
      });
      //END DELETE DI DATABASE
      //finishcode
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
</script>
@endsection