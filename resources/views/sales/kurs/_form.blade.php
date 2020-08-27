<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_mesin') ? ' has-error' : '' }}">
      {!! Form::label('kd_mesin', 'Mesin (F9) (*)') !!}
      <div class="input-group">
      @if (!empty($mtctmoiling->kd_mesin))
        {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required', 'readonly' => 'readonly']) !!}
        <span class="input-group-btn">
          <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal" disabled="">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      @else
        {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required']) !!}
        <span class="input-group-btn">
          <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      @endif
      </div>
      {!! $errors->first('kd_mesin', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-6 {{ $errors->has('nm_mesin') ? ' has-error' : '' }}">
      {!! Form::label('nm_mesin', 'Nama Mesin') !!}
      {!! Form::text('nm_mesin', null, ['class'=>'form-control','placeholder' => 'Nama Mesin', 'disabled'=>'', 'id' => 'nm_mesin']) !!}
      {!! $errors->first('nm_mesin', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->
<div class="box-body" id="field-detail">
  @if (!empty($mtctmoiling->kd_mesin))
    @foreach ($mtctmoilings->get() as $model)
      <div class="row" id="field_{{ $loop->iteration }}">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title" id="box_{{ $loop->iteration }}">Part Ke-{{ $loop->iteration }} ({{ $model->kd_brg }})</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button id="btndelete_{{ $loop->iteration }}" name="btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Part" onclick="deleteDetail(this)">
                  <i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-3">
                  <label name="kd_brg_{{ $loop->iteration }}">Part No</label>
                  <div class="input-group">
                    <input type="hidden" id="kodebarang_{{ $loop->iteration }}" name="kodebarang_{{ $loop->iteration }}" value="{{ $model->kd_brg }}" readonly="readonly">
                    <input type="text" id="kd_brg_{{ $loop->iteration }}" name="kd_brg_{{ $loop->iteration }}" required class="form-control" placeholder="Part No" onkeydown="keyPressedPart(this, event)" onchange="validatePart(this)" required value="{{ $model->kd_brg }}" readonly="readonly">
                    <span class="input-group-btn">
                      <button id="btnpopupkdbrg_{{ $loop->iteration }}" name="btnpopupkdbrg_{{ $loop->iteration }}" type="button" class="btn btn-info" onclick="popupPart(this)" data-toggle="modal" data-target="#partModal" disabled="">
                        <span class="glyphicon glyphicon-search"></span>
                      </button>
                    </span>
                  </div>
                </div>
                <div class="col-sm-7">
                  <label name="nm_brg_{{ $loop->iteration }}">Deskripsi</label>
                  <input type="text" id="nm_brg_{{ $loop->iteration }}" name="nm_brg_{{ $loop->iteration }}" class="form-control" placeholder="Deskripsi" disabled="" value="{{ $model->nm_brg }}">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-sm-5">
                  <label name="nm_alias_{{ $loop->iteration }}">Nama Alias</label>
                  <input type="text" id="nm_alias_{{ $loop->iteration }}" name="nm_alias_{{ $loop->iteration }}" class="form-control" placeholder="Nama Alias" maxlength="50" value="{{ $model->nm_alias }}">
                </div>
                <div class="col-sm-3">
                  <label name="jns_oli_{{ $loop->iteration }}">Jenis Oli</label>
                  <select size="1" id="jns_oli_{{ $loop->iteration }}" name="jns_oli_{{ $loop->iteration }}" class="form-control select2" required>
                    <option value="HIDROLIK" @if ($model->jns_oli === "HIDROLIK") selected="selected" @endif>HIDROLIK</option>
                    <option value="LUBRIKASI" @if ($model->jns_oli === "LUBRIKASI") selected="selected" @endif>LUBRIKASI</option>
                    <option value="SPINDLE" @if ($model->jns_oli === "SPINDLE") selected="selected" @endif>SPINDLE</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label name="st_aktif_{{ $loop->iteration }}">Status Aktif</label>
                  <select size="1" id="st_aktif_{{ $loop->iteration }}" name="st_aktif_{{ $loop->iteration }}" class="form-control select2" onkeydown="keyPressedStatus(this, event)">
                    <option value="T" @if ($model->st_aktif === "T") selected="selected" @endif>AKTIF</option>
                    <option value="F" @if ($model->st_aktif === "F") selected="selected" @endif>NON AKTIF</option>
                  </select>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    @endforeach
    {!! Form::hidden('jml_row', $mtctmoilings->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
  @else
    {!! Form::hidden('jml_row', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
  @endif
</div>
<!-- /.box-body -->
<div class="box-body">
  <p class="pull-right">
    <button id="addRow" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Detail"><span class="glyphicon glyphicon-plus"></span> Add Detail</button>
  </p>
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($mtctmoiling->kd_mesin))
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('mtctmoilings.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Mesin -->
@include('mtc.oli.popup.mesinModal')
<!-- Modal Part -->
@include('mtc.oli.popup.partModal')

@section('scripts')
<script type="text/javascript">
  document.getElementById("kd_mesin").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    var msg = 'Anda yakin menghapus Setting Jenis Oli/Mesin: ' + kd_mesin + '?';
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
      var urlRedirect = "{{ route('mtctmoilings.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(kd_mesin));
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
      var valid = 'T';
      if(valid === 'T') {
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

  function keyPressedKdMesin(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupmesin').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var jml_row = document.getElementById("jml_row").value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        document.getElementById('kd_mesin_1').focus();
      } else {
        document.getElementById('addRow').focus();
      }
    }
  }

  $(document).ready(function(){
    $("#btnpopupmesin").click(function(){
      popupKdMesin();
    });
  });

  function popupKdMesin() {
    var myHeading = "<p>Popup Mesin</p>";
    $("#mesinModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupMesinSettingOlis') }}';
    var lookupMesin = $('#lookupMesin').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[1, 'asc']],
      columns: [
        { data: 'kd_mesin', name: 'kd_mesin'},
        { data: 'nm_mesin', name: 'nm_mesin'},
        { data: 'kd_line', name: 'kd_line'},
        { data: 'nm_line', name: 'nm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupMesin tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupMesin.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_mesin").value = value["kd_mesin"];
            document.getElementById("nm_mesin").value = value["nm_mesin"];
            $('#mesinModal').modal('hide');
            validateKdMesin();
          });
        });
        $('#mesinModal').on('hidden.bs.modal', function () {
          var kd_mesin = document.getElementById("kd_mesin").value.trim();
          if(kd_mesin === '') {
            document.getElementById("nm_mesin").value = "";
            $('#kd_mesin').focus();
          } else {
            var jml_row = document.getElementById("jml_row").value.trim();
            jml_row = Number(jml_row);
            if(jml_row > 0) {
              document.getElementById('kd_mesin_1').focus();
            } else {
              document.getElementById('addRow').focus();
            }
          }
        });
      },
    });
  }

  function validateKdMesin() {
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    if(kd_mesin !== '') {
      var url = '{{ route('datatables.validasiSettingOlis', 'param') }}';
      url = url.replace('param', window.btoa(kd_mesin));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          if(result["jml_row"] != null) {
            document.getElementById("kd_mesin").value = "";
            document.getElementById("nm_mesin").value = "";
            document.getElementById("kd_mesin").focus();
            swal("Terdapat " + result["jml_row"] + " Line. Pilih dari Popup.", "tekan F9 untuk tampilkan data.", "warning");
          } else {
            document.getElementById("kd_mesin").value = result["kd_mesin"];
            document.getElementById("nm_mesin").value = result["nm_mesin"];
            document.getElementById("kd_line").value = result["kd_line"];
            document.getElementById("nm_line").value = result["nm_line"];
            var jml_row = document.getElementById("jml_row").value.trim();
            jml_row = Number(jml_row);
            if(jml_row > 0) {
              document.getElementById('kd_mesin_1').focus();
            } else {
              document.getElementById('addRow').focus();
            }
          }
        } else {
          document.getElementById("kd_mesin").value = "";
          document.getElementById("nm_mesin").value = "";
          document.getElementById("kd_mesin").focus();
          swal("Mesin tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_mesin").value = "";
      document.getElementById("nm_mesin").value = "";
    }
  }

  function popupPart(ths) {
    var myHeading = "<p>Popup Part</p>";
    $("#partModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupPartPengisianOli') }}';
    var lookupPart = $('#lookupPart').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[1, 'asc']],
      columns: [
        { data: 'item', name: 'item'},
        { data: 'desc1', name: 'desc1'},
        { data: 'itemdesc', name: 'itemdesc'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupPart tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupPart.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopupkdbrg_', '');
            var id_kd_brg = "kd_brg_" + row;
            var id_nm_brg = "nm_brg_" + row;
            document.getElementById(id_kd_brg).value = value["item"];
            document.getElementById(id_nm_brg).value = value["desc1"];
            $('#partModal').modal('hide');
          });
        });
        $('#partModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopupkdbrg_', '');
          var id_kd_brg = "kd_brg_" + row;
          var id_nm_brg = "nm_brg_" + row;
          var id_nm_alias = 'nm_alias_'+row;
          var kd_brg = document.getElementById(id_kd_brg).value.trim();
          if(kd_brg === '') {
            document.getElementById(id_kd_brg).value = "";
            document.getElementById(id_nm_brg).value = "";
            document.getElementById(id_kd_brg).focus();
          } else {
            document.getElementById(id_nm_alias).focus();
          }
        });
      },
    });
  }

  function validatePart(ths) {
    var row = ths.id.replace('kd_brg_', '');
    var id_kd_brg = "kd_brg_" + row;
    var id_nm_brg = "nm_brg_" + row;
    var kd_brg = document.getElementById(id_kd_brg).value.trim();
    if(kd_brg !== '') {
      var url = '{{ route('datatables.validasiPartPengisianOli', 'param') }}';
      url = url.replace('param', window.btoa(kd_brg));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById(id_kd_brg).value = result["item"];
          document.getElementById(id_nm_brg).value = result["desc1"];
        } else {
          document.getElementById(id_kd_brg).value = "";
          document.getElementById(id_nm_brg).value = "";
          document.getElementById(id_kd_brg).focus();
          swal("Part No tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById(id_kd_brg).value = "";
      document.getElementById(id_nm_brg).value = "";
    }
  }

  $("#addRow").click(function(){
    var jml_row = document.getElementById("jml_row").value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row").value = jml_row;

    var kodebarang = 'kodebarang_'+jml_row;
    var kd_brg = 'kd_brg_'+jml_row;
    var nm_brg = 'nm_brg_'+jml_row;
    var nm_alias = 'nm_alias_'+jml_row;
    var jns_oli = 'jns_oli_'+jml_row;
    var st_aktif = 'st_aktif_'+jml_row;
    var btndelete = 'btndelete_'+jml_row;
    var id_field = 'field_'+jml_row;
    var id_box = 'box_'+jml_row;
    var btnpopupkdbrg = 'btnpopupkdbrg_'+jml_row;

    $("#field-detail").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Part Ke-'+ jml_row +'</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Part" onclick="deleteDetail(this)">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + kd_brg + '">Part No</label>\
                  <div class="input-group">\
                    <input type="hidden" id="' + kodebarang + '" name="' + kodebarang + '" value="0" readonly="readonly">\
                    <input type="text" id="' + kd_brg + '" name="' + kd_brg + '" required class="form-control" placeholder="Part No" onkeydown="keyPressedPart(this, event)" onchange="validatePart(this)" required>\
                    <span class="input-group-btn">\
                      <button id="' + btnpopupkdbrg + '" name="' + btnpopupkdbrg + '" type="button" class="btn btn-info" onclick="popupPart(this)" data-toggle="modal" data-target="#partModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
                <div class="col-sm-7">\
                  <label name="' + nm_brg + '">Deskripsi</label>\
                  <input type="text" id="' + nm_brg + '" name="' + nm_brg + '" class="form-control" placeholder="Deskripsi" disabled="">\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-5">\
                  <label name="' + nm_alias + '">Nama Alias</label>\
                  <input type="text" id="' + nm_alias + '" name="' + nm_alias + '" class="form-control" placeholder="Nama Alias" maxlength="50">\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + jns_oli + '">Jenis Oli</label>\
                  <select size="1" id="' + jns_oli + '" name="' + jns_oli + '" class="form-control select2" required>\
                    <option value="HIDROLIK">HIDROLIK</option>\
                    <option value="LUBRIKASI">LUBRIKASI</option>\
                    <option value="SPINDLE">SPINDLE</option>\
                  </select>\
                </div>\
                <div class="col-sm-2">\
                  <label name="' + st_aktif + '">Status Aktif</label>\
                  <select size="1" id="' + st_aktif + '" name="' + st_aktif + '" class="form-control select2" onkeydown="keyPressedStatus(this, event)">\
                    <option value="T">AKTIF</option>\
                    <option value="F">NON AKTIF</option>\
                  </select>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );
    document.getElementById(kd_brg).focus();
  });

  function keyPressedPart(ths, e) {
    if(e.keyCode == 120) { //F9
      var row = ths.id.replace('kd_brg_', '');
      var id_btn = "#btnpopupkdbrg_" + row;
      $(id_btn).click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var row = ths.id.replace('kd_brg_', '');
      row = Number(row);
      var nm_alias = 'nm_alias_'+row;
      document.getElementById(nm_alias).focus();
    }
  }

  function keyPressedStatus(ths, e) {
    if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var row = ths.id.replace('st_aktif_', '');
      row = Number(row);
      var jml_row = document.getElementById("jml_row").value.trim();
      jml_row = Number(jml_row);
      if(row < jml_row) {
        row = row + 1;
        var kd_brg = 'kd_brg_'+row;
        document.getElementById(kd_brg).focus();
      } else {
        document.getElementById('addRow').focus();
      }
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
      var kodebarang = document.getElementById("kodebarang_" + row).value.trim();
      var kd_brg = document.getElementById("kd_brg_" + row).value.trim();
      var kd_mesin = document.getElementById("kd_mesin").value.trim();
      if(kodebarang === "" || kodebarang === "0") {
        changeId(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('mtctmoilings.deletedetail', ['param','param2']) }}";
        url = url.replace('param2', window.btoa(kd_brg));
        url = url.replace('param', window.btoa(kd_mesin));
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
    var id_div = "#field_" + row;
    $(id_div).remove();
    var jml_row = document.getElementById("jml_row").value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var kodebarang = "#kodebarang_" + $i;
      var kodebarang_new = "kodebarang_" + ($i-1);
      $(kodebarang).attr({"id":kodebarang_new, "name":kodebarang_new});
      var kd_brg = "#kd_brg_" + $i;
      var kd_brg_new = "kd_brg_" + ($i-1);
      $(kd_brg).attr({"id":kd_brg_new, "name":kd_brg_new});
      var nm_brg = "#nm_brg_" + $i;
      var nm_brg_new = "nm_brg_" + ($i-1);
      $(nm_brg).attr({"id":nm_brg_new, "name":nm_brg_new});
      var nm_alias = "#nm_alias_" + $i;
      var nm_alias_new = "nm_alias_" + ($i-1);
      $(nm_alias).attr({"id":nm_alias_new, "name":nm_alias_new});
      var jns_oli = "#jns_oli_" + $i;
      var jns_oli_new = "jns_oli_" + ($i-1);
      $(jns_oli).attr({"id":jns_oli_new, "name":jns_oli_new});
      var st_aktif = "#st_aktif_" + $i;
      var st_aktif_new = "st_aktif_" + ($i-1);
      $(st_aktif).attr({"id":st_aktif_new, "name":st_aktif_new});
      var btndelete = "#btndelete_" + $i;
      var btndelete_new = "btndelete_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var id_field = "#field_" + $i;
      var id_field_new = "field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_" + $i;
      var id_box_new = "box_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btnpopupkdbrg = "#btnpopupkdbrg_" + $i;
      var btnpopupkdbrg_new = "btnpopupkdbrg_" + ($i-1);
      $(btnpopupkdbrg).attr({"id":btnpopupkdbrg_new, "name":btnpopupkdbrg_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row").value = jml_row;
  }
</script>
@endsection
