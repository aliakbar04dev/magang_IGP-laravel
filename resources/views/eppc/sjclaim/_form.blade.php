<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_sj') ? ' has-error' : '' }}">
      {!! Form::hidden('no_certi', null, ['class' => 'form-control', 'placeholder' => 'No. Certi', 'readonly' => 'readonly', 'id' => 'no_certi']) !!}
      {!! Form::hidden('items', null, ['class' => 'form-control', 'placeholder' => 'Item', 'readonly' => 'readonly', 'id' => 'items']) !!}
      {!! Form::hidden('st_submit', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'st_submit']) !!}
      {!! Form::label('no_sj', 'No. Surat Jalan (*)') !!}
      {!! Form::text('no_sj', null, ['class' => 'form-control', 'placeholder' => 'No. Surat Jalan', 'maxlength' => '50', 'required', 'onchange' => 'validateNoSj()']) !!}
      {!! $errors->first('no_sj', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_sj') ? ' has-error' : '' }}">
      {!! Form::label('tgl_sj', 'Tanggal SJ (*)') !!}
      @if (empty($model->tgl_sj))
        {!! Form::date('tgl_sj', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Tanggal SJ', 'required']) !!}
      @else
        {!! Form::date('tgl_sj', \Carbon\Carbon::parse($model->tgl_sj), ['class' => 'form-control','placeholder' => 'Tanggal SJ', 'required']) !!}
      @endif
      {!! $errors->first('tgl_sj', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3">
      {!! Form::label('lblnodn', 'No. DN (F9) (*)') !!}
      @if (!empty($model->no_certi))
        @if($model->ppctDnclaimSj2s()->get()->count() > 0)
          <div class="input-group">
            {!! Form::text('no_dn', null, ['class' => 'form-control', 'placeholder' => 'No. DN', 'onkeydown' => 'keyPressedNoDn(event)', 'maxlength' => 10, 'required', 'onchange' => 'validateNoDn()', 'id' => 'no_dn', 'readonly' => 'readonly']) !!}
            <span class="input-group-btn">
              <button id="btnpopupnodn" name="btnpopupnodn" type="button" class="btn btn-info" onclick="popupNoDn()" data-toggle="modal" data-target="#dnModal" disabled="">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
        @else 
          <div class="input-group">
            {!! Form::text('no_dn', null, ['class' => 'form-control', 'placeholder' => 'No. DN', 'onkeydown' => 'keyPressedNoDn(event)', 'maxlength' => 10, 'required', 'onchange' => 'validateNoDn()', 'id' => 'no_dn']) !!}
            <span class="input-group-btn">
              <button id="btnpopupnodn" name="btnpopupnodn" type="button" class="btn btn-info" onclick="popupNoDn()" data-toggle="modal" data-target="#dnModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
        @endif
      @else 
        <div class="input-group">
          {!! Form::text('no_dn', null, ['class' => 'form-control', 'placeholder' => 'No. DN', 'onkeydown' => 'keyPressedNoDn(event)', 'maxlength' => 10, 'required', 'onchange' => 'validateNoDn()', 'id' => 'no_dn']) !!}
          <span class="input-group-btn">
            <button id="btnpopupnodn" name="btnpopupnodn" type="button" class="btn btn-info" onclick="popupNoDn()" data-toggle="modal" data-target="#dnModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
      @endif
    </div>
    <div class="col-sm-2">
      {!! Form::label('lblgenerate', 'Generate Item DN') !!}
      <button id="btn-generate" type="button" class="form-control btn btn-warning" data-placement="top" title="Generate Item DN" data-toggle="modal" data-target="#generateModal">Generate Item DN</button>
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

@if (isset($model))
{!! Form::hidden('jml_row', $model->ppctDnclaimSj2s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}

<div class="box-body">
  <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th rowspan="2" style="width: 5%;">No. POS</th>
        <th rowspan="2" style="width: 15%;">Item</th>
        <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Deskripsi</th>
        <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Keterangan</th>
        <th colspan="3" style="text-align:center;">QTY</th>
        <th rowspan="2" style="width: 1%;">Action</th>
      </tr>
      <tr>
        <th style="width: 10%;">DN</th>
        <th style="width: 10%;">Kirim IGP</th>
        <th style="width: 10%;">SJ</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($model->ppctDnclaimSj2s()->get() as $data)
        <tr>
          <td style="text-align: center;">
            <input type="hidden" id="row-{{ $loop->iteration }}-no_pos" name="row-{{ $loop->iteration }}-no_pos" class="form-control" readonly="readonly" value="{{ $data->no_pos }}">
            {{ $data->no_pos }}
          </td>
          <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
            {{ $data->kd_item }}
          </td>
          <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
            {{ $data->item_name }}
          </td>
          <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
            {{ $data->nm_trket }}
          </td>
          <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
            <input type='number' id="row-{{ $loop->iteration }}-qty_dn" name="row-{{ $loop->iteration }}-qty_dn" class="form-control" value="{{ numberFormatterForm(0, 2)->format($data->qty_dn) }}" style='width: 7em' disabled="">
          </td>
          <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
            <input type='number' id="row-{{ $loop->iteration }}-qty_kirim" name="row-{{ $loop->iteration }}-qty_kirim" class="form-control" value="{{ numberFormatterForm(0, 2)->format($data->qty_kirim) }}" style='width: 7em' disabled="">
          </td>
          <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
            <input type='number' id="row-{{ $loop->iteration }}-qty_sj" name="row-{{ $loop->iteration }}-qty_sj" class="form-control" value="{{ numberFormatterForm(0, 2)->format($data->qty_sj) }}" style='width: 7em' min=1 max={{ $data->qty_dn-$data->qty_kirim+$data->qty_sj }} step='any'>
          </td>
          <td style="text-align: center;">
            <button id="btndelete_{{ $loop->iteration }}" name="btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Item" onclick="deleteDetail(this)">
              <i class="fa fa-times"></i>
            </button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<!-- /.box-body -->
@else 
{!! Form::hidden('jml_row', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
@endif


<div class="box-footer">
  {!! Form::submit('Save as Draft', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($model->no_certi))
    &nbsp;&nbsp;
    <button id="btn-submit" type="button" class="btn btn-success">Save & Submit</button>
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('ppctdnclaimsj1s.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong. Max size file 8 MB', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal DN -->
@include('eppc.sjclaim.popup.dnModal')
@include('eppc.sjclaim.popup.generateModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("no_sj").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var no_certi = document.getElementById("no_certi").value.trim();
    var no_sj = document.getElementById("no_sj").value.trim();
    var msg = 'Anda yakin menghapus No. Surat Jalan Claim: ' + no_sj + '?';
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
      var urlRedirect = "{{ route('ppctdnclaimsj1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_certi));
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
          document.getElementById("st_submit").value = "F";
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

  $("#btn-submit").click(function(){
    var no_certi = document.getElementById("no_certi").value.trim();
    var no_sj = document.getElementById("no_sj").value.trim();
    var tgl_sj = document.getElementById("tgl_sj").value;
    var no_dn = document.getElementById("no_dn").value.trim();

    if(no_certi === "" || no_sj === "" || tgl_sj === "" || no_dn === "") {
      var info = "Isi data yang tidak boleh kosong!";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var msg = 'Anda yakin submit data ini?';
      var txt = 'No. Surat Jalan Claim: ' + no_sj;
      swal({
        title: msg,
        text: txt,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, submit it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        document.getElementById("st_submit").value = "T";
        document.getElementById("form_id").submit();
      }, function (dismiss) {
        if (dismiss === 'cancel') {
        }
      })
    }
  });

  $("#btn-generate").click(function(){
    var no_dn = document.getElementById("no_dn").value.trim();
    if(no_dn == "") {
      no_dn = "-";
    }
    var no_certi = document.getElementById("no_certi").value.trim();
    if(no_certi == "") {
      no_certi = "-";
    }
    var kd_supp = "{{ Auth::user()->kd_supp }}";
    var myHeading = "<p>List Item DN (No. DN: " + no_dn +")</p>";
    $("#generateModalLabel").html(myHeading);
    // $('#no_pms').attr('value', no_pms);
    var tableDetail = $('#tblDetail').DataTable();
    var url = '{{ route('ppctdnclaimsj1s.generate', ['param', 'param2', 'param3']) }}';
    url = url.replace('param3', window.btoa(kd_supp));
    url = url.replace('param2', window.btoa(no_dn));
    url = url.replace('param', window.btoa(no_certi));
    tableDetail.ajax.url(url).load();
    $('#generateModal').on('hidden.bs.modal', function () {
      
    });
  });

  $("#btn-pilih").click(function(){
    var no_sj = document.getElementById("no_sj").value.trim();
    var tgl_sj = document.getElementById("tgl_sj").value;
    var no_dn = document.getElementById("no_dn").value.trim();

    if(no_sj === "" || tgl_sj === "" || no_dn === "") {
      var info = "No. Surat Jalan & Tanggal Surat Jalan tidak boleh kosong!";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var validasi = "F";
      var ids = "-";
      var jmldata = 0;
      var tableDetail = $('#tblDetail').DataTable();
      tableDetail.search('').columns().search('').draw();
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
            var no_pos = document.getElementById(target).value.trim();
            validasi = "T";
            if(ids === '-') {
              ids = no_pos;
            } else {
              ids = ids + "#quinza#" + no_pos;
            }
            jmldata = jmldata + 1;
          }
        }
      }

      if(validasi === "T") {
        //additional input validations can be done hear
        swal({
          title: 'Anda yakin Generate Data tsb?',
          text: 'Jumlah Item: ' + jmldata,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="glyphicon glyphicon-thumbs-up"></i> Yes, Generate!',
          cancelButtonText: '<i class="glyphicon glyphicon-thumbs-down"></i> No, Cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          document.getElementById("items").value = ids;
          document.getElementById("st_submit").value = "G";
          document.getElementById("form_id").submit();
        }, function (dismiss) {
          if (dismiss === 'cancel') {
            // 
          }
        })
      } else {
        swal("Tidak ada data yang dipilih!", "", "warning");
      }
    }
  });

  function keyPressedNoDn(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnodn').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("btn-generate").focus();
    }
  }

  $(document).ready(function(){
    var table = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // 'responsive': true,
      "ordering": false, 
      'searching': false,
      "scrollX": true,
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false
    });

    var url = '{{ route('ppctdnclaimsj1s.generate', ['param', 'param2', 'param3']) }}';
    url = url.replace('param3', window.btoa("-"));
    url = url.replace('param2', window.btoa("-"));
    url = url.replace('param', window.btoa("-"));
    var tblDetail = $('#tblDetail').DataTable({
      // "searching": false,
      "ordering": false,
      "paging": false,
      "scrollX": true,
      "scrollY": "300px",
      "scrollCollapse": true,
      // responsive: true,
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: url, 
      columns: [
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false},
        {data: 'no_pos', name: 'no_pos', className: "dt-center", orderable: false},
        {data: 'kd_item', name: 'kd_item', orderable: false},
        {data: 'item_name', name: 'item_name', orderable: false},
        {data: 'nm_trket', name: 'nm_trket', orderable: false},
        {data: 'qty_dn', name: 'qty_dn', className: "dt-right", orderable: false}
      ], 
    });
  });

  function validateNoSj() {
    var no_sj = document.getElementById("no_sj").value.trim();
    if(no_sj !== '') {
      var no_certi = document.getElementById("no_certi").value.trim();
      if(no_certi === "") {
        no_certi = "-";
      }

      var url = '{{ route('ppctdnclaimsj1s.validasiNoSj', ['param', 'param2']) }}';
      url = url.replace('param2', window.btoa(no_sj));
      url = url.replace('param', window.btoa(no_certi));
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          var result_no_certi = result["no_certi"];
          var result_no_sj = result["no_sj"];
          document.getElementById("no_sj").value = "";
          document.getElementById("no_sj").focus();
          // var info = 'No. Surat Jalan sudah digunakan di No. Certificate ' + result_no_certi;
          var info = 'No. Surat Jalan sudah digunakan!';
          swal("No. Surat Jalan tidak valid!", info, "error");
        }
      });
    } else {
      document.getElementById("no_sj").value = "";
    }
  }

  function popupNoDn() {
    var myHeading = "<p>Popup No. DN</p>";
    $("#dnModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupNoDnSjClaim') }}';
    var lookupDn = $('#lookupDn').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[2, 'desc'], [1, 'desc']],
      columns: [
        { data: 'kd_pono', name: 'kd_pono'}, 
        { data: 'tgl_dn', name: 'tgl_dn'}, 
        { data: 'qty_dn', name: 'qty_dn', className: "dt-right"}, 
        { data: 'qty_kirim', name: 'qty_kirim', className: "dt-right"}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupDn tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupDn.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_dn").value = value["kd_pono"];
            $('#dnModal').modal('hide');
          });
        });
        $('#dnModal').on('hidden.bs.modal', function () {
          var no_dn = document.getElementById("no_dn").value.trim();
          if(no_dn === '') {
            document.getElementById("no_dn").value = "";
            document.getElementById("no_dn").focus();
          } else {
            document.getElementById("btn-generate").focus();
          }
        });
      },
    });
  }

  function validateNoDn() {
    var no_dn = document.getElementById("no_dn").value.trim();
    if(no_dn !== '') {
      var url = '{{ route('datatables.validasiNoDnSjClaim', 'param') }}';
      url = url.replace('param', window.btoa(no_dn));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_dn").value = result["kd_pono"];
          document.getElementById("btn-generate").focus();
        } else {
          document.getElementById("no_dn").value = "";
          document.getElementById("no_dn").focus();
          swal("No. DN tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_dn").value = "";
    }
  }

  function deleteDetail(ths) {
    var msg = 'Anda yakin menghapus Part ini?';
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
      var row = ths.id.replace('btndelete_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var no_certi = document.getElementById("no_certi").value.trim();
      var no_dn = document.getElementById("no_dn").value.trim();
      var no_pos = document.getElementById("row-" + row + "-no_pos").value.trim();
      if(no_pos === "") {
        changeId(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('ppctdnclaimsj1s.deletedetail', ['param','param2','param3']) }}";
        url = url.replace('param3', window.btoa(no_pos));
        url = url.replace('param2', window.btoa(no_dn));
        url = url.replace('param', window.btoa(no_certi));
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
              changeId(row);
              info = "Deleted!";
              info2 = data.message;
              info3 = "success";
              swal(info, info2, info3);
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
      }
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

  function changeId(row) {
    var table = $('#tblMaster').DataTable();
    table.row(row-1).remove().draw(false);
    var jml_row = document.getElementById("jml_row").value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var no_pos = "#row-" + $i + "-no_pos";
      var no_pos_new = "row-" + ($i-1) + "-no_pos";
      $(no_pos).attr({"id":no_pos_new, "name":no_pos_new});
      var qty_dn = "#row-" + $i + "-qty_dn";
      var qty_dn_new = "row-" + ($i-1) + "-qty_dn";
      $(qty_dn).attr({"id":qty_dn_new, "name":qty_dn_new});
      var qty_kirim = "#row-" + $i + "-qty_kirim";
      var qty_kirim_new = "row-" + ($i-1) + "-qty_kirim";
      $(qty_kirim).attr({"id":qty_kirim_new, "name":qty_kirim_new});
      var qty_sj = "#row-" + $i + "-qty_sj";
      var qty_sj_new = "row-" + ($i-1) + "-qty_sj";
      $(qty_sj).attr({"id":qty_sj_new, "name":qty_sj_new});
      var btndelete = "#btndelete_" + $i;
      var btndelete_new = "btndelete_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row").value = jml_row;
  }
</script>
@endsection