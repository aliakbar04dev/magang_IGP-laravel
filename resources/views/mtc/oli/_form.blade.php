<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_isi') ? ' has-error' : '' }}">
      {!! Form::label('no_isi', 'No. Pengisian') !!}
      @if (empty($mtctisioli1->no_isi))
        {!! Form::text('no_isi', null, ['class'=>'form-control','placeholder' => 'No. Pengisian', 'disabled'=>'']) !!}
      @else
        {!! Form::text('no_isi2', $mtctisioli1->no_isi, ['class'=>'form-control','placeholder' => 'No. Pengisian', 'required', 'disabled'=>'']) !!}
        {!! Form::hidden('no_isi', null, ['class'=>'form-control','placeholder' => 'No. Pengisian', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('no_isi', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_isi') ? ' has-error' : '' }}">
      {!! Form::label('tgl_isi', 'Tanggal Isi (*)') !!}
      @if (empty($mtctisioli1->tgl_isi))
        {!! Form::date('tgl_isi', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Isi', 'required']) !!}
      @else
        {!! Form::date('tgl_isi', \Carbon\Carbon::parse($mtctisioli1->tgl_isi), ['class'=>'form-control','placeholder' => 'Tgl Isi', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('tgl_isi', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('kd_plant') ? ' has-error' : '' }}">
      {!! Form::label('kd_plant', 'Plant (*)') !!}
      {!! Form::select('kd_plant',  $plant->pluck('nm_plant','kd_plant')->all(), null, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'kd_plant']) !!}
      {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_line') ? ' has-error' : '' }}">
      {!! Form::label('kd_line', 'Line (F9) (*)') !!}
      <div class="input-group">
        {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line']) !!}
        <span class="input-group-btn">
          <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('kd_line', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_line') ? ' has-error' : '' }}">
      {!! Form::label('nm_line', 'Nama Line') !!}
      {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
      {!! $errors->first('nm_line', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_mesin') ? ' has-error' : '' }}">
      {!! Form::label('kd_mesin', 'Mesin (F9) (*)') !!}
      <div class="input-group">
        {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required']) !!}
        <span class="input-group-btn">
          <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('kd_mesin', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_mesin') ? ' has-error' : '' }}">
      {!! Form::label('nm_mesin', 'Nama Mesin') !!}
      {!! Form::text('nm_mesin', null, ['class'=>'form-control','placeholder' => 'Nama Mesin', 'disabled'=>'', 'id' => 'nm_mesin']) !!}
      {!! $errors->first('nm_mesin', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-body" id="field-detail">
  @if (!empty($mtctisioli1->no_isi))
    @foreach ($mtctisioli1->details()->get() as $model)
      <div class="row" id="field_{{ $loop->iteration }}">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title" id="box_{{ $loop->iteration }}">Oli Ke-{{ $loop->iteration }}</h3>
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
                  <input type="hidden" id="no_seq_{{ $loop->iteration }}" name="no_seq_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($model->no_seq) }}">
                  <label name="item_no_{{ $loop->iteration }}">Part No</label>
                  <div class="input-group">
                    <input type="text" id="item_no_{{ $loop->iteration }}" name="item_no_{{ $loop->iteration }}" required class="form-control" placeholder="Part No" onkeydown="keyPressedPart(this, event)" onchange="validatePart(this)" value="{{ $model->item_no }}">
                    <span class="input-group-btn">
                      <button id="btnpopupitemno_{{ $loop->iteration }}" name="btnpopupitemno_{{ $loop->iteration }}" type="button" class="btn btn-info" onclick="popupPart(this)" data-toggle="modal" data-target="#partModal">
                        <span class="glyphicon glyphicon-search"></span>
                      </button>
                    </span>
                  </div>
                </div>
                <div class="col-sm-7">
                  <label name="item_name_{{ $loop->iteration }}">Deskripsi</label>
                  <input type="text" id="item_name_{{ $loop->iteration }}" name="item_name_{{ $loop->iteration }}" class="form-control" placeholder="Deskripsi" disabled="" value="{{ $model->item_name }}">
                </div>
                <div class="col-sm-2">
                  <label name="qty_isi_{{ $loop->iteration }}">Qty (Liter) (*)</label>
                  <input type="number" id="qty_isi_{{ $loop->iteration }}" name="qty_isi_{{ $loop->iteration }}" required class="form-control" placeholder="Qty (Liter)" min="0.1" step="any" onkeydown="keyPressedQty(this, event)" value="{{ $model->qty_isi }}">
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
    {!! Form::hidden('jml_row', $mtctisioli1->details()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
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
  @if (!empty($mtctisioli1->no_isi))
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('mtctisioli1s.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Line -->
@include('mtc.oli.popup.lineModal')
<!-- Modal Mesin -->
@include('mtc.oli.popup.mesinModal')
<!-- Modal Part -->
@include('mtc.oli.popup.partModal')

@section('scripts')
<script type="text/javascript">
  document.getElementById("tgl_isi").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var no_isi = document.getElementById("no_isi").value.trim();
    var msg = 'Anda yakin menghapus No. Pengisian Oli: ' + no_isi + '?';
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
      var urlRedirect = "{{ route('mtctisioli1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_isi));
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

  function changeKdPlant() {
    validateKdLine();
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('kd_mesin').focus();
    }
  }

  function keyPressedKdMesin(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupmesin').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var jml_row = document.getElementById("jml_row").value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        document.getElementById('item_no_1').focus();
      } else {
        document.getElementById('addRow').focus();
      }
    }
  }

  $(document).ready(function(){

    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    $("#btnpopupmesin").click(function(){
      popupKdMesin();
    });
  });

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(kd_plant));
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
            document.getElementById("kd_mesin").value = "";
            document.getElementById("nm_mesin").value = "";
            $('#kd_line').focus();
          } else {
            $('#kd_mesin').focus();
          }
        });
      },
    });
  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      var kd_plant = document.getElementById('kd_plant').value.trim();
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(kd_plant));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];
          validateKdMesin();
        } else {
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          document.getElementById("kd_mesin").value = "";
          document.getElementById("nm_mesin").value = "";
          document.getElementById("kd_line").focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
      document.getElementById("kd_mesin").value = "";
      document.getElementById("nm_mesin").value = "";
    }
  }

  function popupKdMesin() {
    var myHeading = "<p>Popup Mesin</p>";
    $("#mesinModalLabel").html(myHeading);
    var kd_plant = document.getElementById('kd_plant').value.trim();
    if(kd_plant === '') {
      kd_plant = "-";
    }
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var url = '{{ route('datatables.popupMesins', ['param','param2']) }}';
    url = url.replace('param2', window.btoa(kd_line));
    url = url.replace('param', window.btoa(kd_plant));
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
            document.getElementById("kd_line").value = value["kd_line"];
            document.getElementById("nm_line").value = value["nm_line"];
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
              document.getElementById('item_no_1').focus();
            } else {
              document.getElementById('addRow').focus();
            }
          }
        });
      },
    });
  }

  function validateKdMesin() {
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    if(kd_plant !== '' && kd_mesin !== '') {
      var url = '{{ route('datatables.validasiMesin', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(kd_mesin));
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(kd_plant));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          if(result["jml_row"] != null) {
            document.getElementById("kd_mesin").value = "";
            document.getElementById("nm_mesin").value = "";
            document.getElementById("kd_line").value = "";
            document.getElementById("nm_line").value = "";
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
              document.getElementById('item_no_1').focus();
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
      // "scrollX": true,
      // "scrollY": "500px",
      // "scrollCollapse": true,
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
            var row = ths.id.replace('btnpopupitemno_', '');
            var id_item_no = "item_no_" + row;
            var id_item_name = "item_name_" + row;
            document.getElementById(id_item_no).value = value["item"];
            document.getElementById(id_item_name).value = value["desc1"];
            $('#partModal').modal('hide');
          });
        });
        $('#partModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopupitemno_', '');
          var id_item_no = "item_no_" + row;
          var id_item_name = "item_name_" + row;
          var id_qty_isi = 'qty_isi_'+row;
          var item_no = document.getElementById(id_item_no).value.trim();
          if(item_no === '') {
            document.getElementById(id_item_no).value = "";
            document.getElementById(id_item_name).value = "";
            document.getElementById(id_item_no).focus();
          } else {
            document.getElementById(id_qty_isi).focus();
          }
        });
      },
    });
  }

  function validatePart(ths) {
    var row = ths.id.replace('item_no_', '');
    var id_item_no = "item_no_" + row;
    var id_item_name = "item_name_" + row;
    var item_no = document.getElementById(id_item_no).value.trim();
    if(item_no !== '') {
      var url = '{{ route('datatables.validasiPartPengisianOli', 'param') }}';
      url = url.replace('param', window.btoa(item_no));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById(id_item_no).value = result["item"];
          document.getElementById(id_item_name).value = result["desc1"];
        } else {
          document.getElementById(id_item_no).value = "";
          document.getElementById(id_item_name).value = "";
          document.getElementById(id_item_no).focus();
          swal("Part No tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById(id_item_no).value = "";
      document.getElementById(id_item_name).value = "";
    }
  }

  $("#addRow").click(function(){
    var jml_row = document.getElementById("jml_row").value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row").value = jml_row;

    var no_seq = 'no_seq_'+jml_row;
    var item_no = 'item_no_'+jml_row;
    var item_name = 'item_name_'+jml_row;
    var qty_isi = 'qty_isi_'+jml_row;
    var btndelete = 'btndelete_'+jml_row;
    var id_field = 'field_'+jml_row;
    var id_box = 'box_'+jml_row;
    var btnpopupitemno = 'btnpopupitemno_'+jml_row;

    $("#field-detail").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Oli Ke-'+ jml_row +'</h3>\
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
                  <input type="hidden" id="' + no_seq + '" name="' + no_seq + '" class="form-control" readonly="readonly" value="0">\
                  <label name="' + item_no + '">Part No</label>\
                  <div class="input-group">\
                    <input type="text" id="' + item_no + '" name="' + item_no + '" required class="form-control" placeholder="Part No" onkeydown="keyPressedPart(this, event)" onchange="validatePart(this)">\
                    <span class="input-group-btn">\
                      <button id="' + btnpopupitemno + '" name="' + btnpopupitemno + '" type="button" class="btn btn-info" onclick="popupPart(this)" data-toggle="modal" data-target="#partModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
                <div class="col-sm-7">\
                  <label name="' + item_name + '">Deskripsi</label>\
                  <input type="text" id="' + item_name + '" name="' + item_name + '" class="form-control" placeholder="Deskripsi" disabled="">\
                </div>\
                <div class="col-sm-2">\
                  <label name="' + qty_isi + '">Qty (Liter) (*)</label>\
                  <input type="number" id="' + qty_isi + '" name="' + qty_isi + '" required class="form-control" placeholder="Qty (Liter)" min="0.1" step="any" onkeydown="keyPressedQty(this, event)">\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    document.getElementById(item_no).focus();
  });

  function keyPressedPart(ths, e) {
    if(e.keyCode == 120) { //F9
      var row = ths.id.replace('item_no_', '');
      var id_btn = "#btnpopupitemno_" + row;
      $(id_btn).click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var row = ths.id.replace('item_no_', '');
      row = Number(row);
      var qty_isi = 'qty_isi_'+row;
      document.getElementById(qty_isi).focus();
    }
  }

  function keyPressedQty(ths, e) {
    if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var row = ths.id.replace('qty_isi_', '');
      row = Number(row);
      var jml_row = document.getElementById("jml_row").value.trim();
      jml_row = Number(jml_row);
      if(row < jml_row) {
        row = row + 1;
        var item_no = 'item_no_'+row;
        document.getElementById(item_no).focus();
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
      var no_seq = "no_seq_" + row;
      var no_seq_value = document.getElementById(no_seq).value.trim();
      var no_isi = document.getElementById("no_isi").value.trim();

      if(no_seq_value === "0" || no_seq_value === "") {
        changeId(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('mtctisioli1s.deletedetail', ['param','param2']) }}";
        url = url.replace('param2', no_seq_value);
        url = url.replace('param', window.btoa(no_isi));
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
      var no_seq = "#no_seq_" + $i;
      var no_seq_new = "no_seq_" + ($i-1);
      $(no_seq).attr({"id":no_seq_new, "name":no_seq_new});
      var item_no = "#item_no_" + $i;
      var item_no_new = "item_no_" + ($i-1);
      $(item_no).attr({"id":item_no_new, "name":item_no_new});
      var item_name = "#item_name_" + $i;
      var item_name_new = "item_name_" + ($i-1);
      $(item_name).attr({"id":item_name_new, "name":item_name_new});
      var qty_isi = "#qty_isi_" + $i;
      var qty_isi_new = "qty_isi_" + ($i-1);
      $(qty_isi).attr({"id":qty_isi_new, "name":qty_isi_new});
      var btndelete = "#btndelete_" + $i;
      var btndelete_new = "btndelete_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var id_field = "#field_" + $i;
      var id_field_new = "field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_" + $i;
      var id_box_new = "box_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btnpopupitemno = "#btnpopupitemno_" + $i;
      var btnpopupitemno_new = "btnpopupitemno_" + ($i-1);
      $(btnpopupitemno).attr({"id":btnpopupitemno_new, "name":btnpopupitemno_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row").value = jml_row;
  }
</script>
@endsection
