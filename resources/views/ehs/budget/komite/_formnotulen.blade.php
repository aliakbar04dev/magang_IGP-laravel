<div class="box-body">
	<div class="form-group">
		<div class="col-sm-3 {{ $errors->has('no_komite') ? ' has-error' : '' }}">
			{!! Form::label('no_komite', 'No. Komite') !!}
			{!! Form::text('no_komite', null, ['class'=>'form-control','placeholder' => 'No. Komite', 'disabled'=>'']) !!}
			{!! $errors->first('no_komite', '<p class="help-block">:message</p>') !!}
		</div>
    <div class="col-sm-3 {{ $errors->has('no_rev') ? ' has-error' : '' }}">
      {!! Form::label('no_rev', 'No. Revisi') !!}
      {!! Form::text('no_rev', $bgttkomite1->no_rev, ['class'=>'form-control','placeholder' => 'No. Revisi', 'disabled'=>'']) !!}
      {!! $errors->first('no_rev', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('tgl_komite_act') ? ' has-error' : '' }}">
      {!! Form::label('tgl_komite_act', 'Tanggal Komite') !!}
      {!! Form::text('tgl_komite_act', \Carbon\Carbon::parse($bgttkomite1->tgl_komite_act)->format('d/m/Y H:i'), ['class'=>'form-control', 'placeholder' => 'Tanggal Komite', 'disabled'=>'']) !!}
      {!! $errors->first('tgl_komite_act', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-9 {{ $errors->has('dihadiri') ? ' has-error' : '' }}">
      {!! Form::label('dihadiri', 'Dihadiri (*)') !!}
      @if (empty($bgttkomite1->dihadiri) && empty($bgttkomite1->notulen))
        {!! Form::select('dihadiri[]', \DB::connection('oracle-usrbrgcorp')->table(DB::raw("usrhrcorp.v_mas_karyawan"))->select(DB::raw("npk||'-'||nama as nama, npk"))->whereRaw('tgl_keluar is null')->orderBy('npk')->pluck('nama', 'npk')->all(), $bgttkomite1->support, ['class'=>'form-control select2', 'multiple'=>'multiple', 'data-placeholder' => 'Pilih User', 'id' => 'dihadiri', 'required']) !!}
      @else
        {!! Form::select('dihadiri[]', \DB::connection('oracle-usrbrgcorp')->table(DB::raw("usrhrcorp.v_mas_karyawan"))->select(DB::raw("npk||'-'||nama as nama, npk"))->whereRaw('tgl_keluar is null')->orderBy('npk')->pluck('nama', 'npk')->all(), null, ['class'=>'form-control select2', 'multiple'=>'multiple', 'data-placeholder' => 'Pilih User', 'id' => 'dihadiri', 'required']) !!}
      @endif
      {!! $errors->first('dihadiri', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-9 {{ $errors->has('topik') ? ' has-error' : '' }}">
      {!! Form::label('Topik', 'Topik') !!}
      {!! Form::textarea('topik', null, ['class'=>'form-control', 'placeholder' => 'Topik', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'id' => 'topik', 'disabled'=>'']) !!}
      {!! $errors->first('topik', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->

	<div class="form-group">
		<div class="col-sm-3 {{ $errors->has('npk_presenter_act') ? ' has-error' : '' }}">
      {!! Form::label('npk_presenter_act', 'Presenter (*) (F9)') !!}
      <div class="input-group">
        @if (empty($bgttkomite1->npk_presenter_act) && empty($bgttkomite1->notulen))
          {!! Form::text('npk_presenter_act', $bgttkomite1->npk_presenter, ['class'=>'form-control','placeholder' => 'Presenter', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawan()', 'id' => 'npk_presenter_act', 'required']) !!}
        @else
          {!! Form::text('npk_presenter_act', null, ['class'=>'form-control','placeholder' => 'Presenter', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawan()', 'id' => 'npk_presenter_act', 'required']) !!}
        @endif
        <span class="input-group-btn">
          <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('npk_presenter_act', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-6 {{ $errors->has('nm_presenter_act') ? ' has-error' : '' }}">
      {!! Form::label('nm_presenter_act', 'Nama Presenter') !!}
      @if (empty($bgttkomite1->npk_presenter_act) && empty($bgttkomite1->notulen))
        {!! Form::text('nm_presenter_act', $bgttkomite1->nm_presenter, ['class'=>'form-control','placeholder' => 'Nama Presenter', 'disabled'=>'', 'id' => 'nm_presenter_act']) !!}
      @else
        {!! Form::text('nm_presenter_act', null, ['class'=>'form-control','placeholder' => 'Nama Presenter', 'disabled'=>'', 'id' => 'nm_presenter_act']) !!}
      @endif
      {!! $errors->first('nm_presenter_act', '<p class="help-block">:message</p>') !!}
    </div>
	</div>
	<!-- /.form-group -->

  @if (!empty($bgttkomite1->lok_file))
    <div class="form-group">
      <div class="col-sm-9">
        <div class="box box-primary collapsed-box">
          <div class="box-header with-border">
            <h3 class="box-title" id="boxtitle">File</h3>
            <div class="box-tools pull-right">
              <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('bgttkomite1s.downloadfile', base64_encode($bgttkomite1->no_komite)) }}">
                <span class='glyphicon glyphicon-download-alt'></span>
              </a>
              <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row form-group">
              <div class="col-sm-12">
                <p>
                  <center>
                    <iframe src="{{ $bgttkomite1->file($bgttkomite1->lok_file) }}" width="100%" height="300px"></iframe>
                  </center>
                </p>
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- ./box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
    <!-- /.form-group -->
  @endif
  
  <div class="form-group">
    <div class="col-sm-9 {{ $errors->has('latar_belakang') ? ' has-error' : '' }}">
      {!! Form::label('latar_belakang', 'Latar Belakang (*)') !!}
      {!! Form::textarea('latar_belakang', null, ['class'=>'form-control', 'placeholder' => 'Latar Belakang (Max 1.000 Karakter)', 'rows' => '5', 'maxlength' => 1000, 'style' => 'resize:vertical', 'id' => 'latar_belakang', 'required']) !!}
      {!! $errors->first('latar_belakang', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-9 {{ $errors->has('notulen') ? ' has-error' : '' }}">
      {!! Form::label('notulen', 'Notulen (*)') !!}
      @if (empty($bgttkomite1->notulen))
        {!! Form::textarea('notulen', null, ['class'=>'form-control', 'placeholder' => 'Notulen (Max 5.000 Karakter)', 'rows' => '10', 'maxlength' => 5000, 'style' => 'resize:vertical', 'id' => 'notulen', 'required']) !!}
      @else
        {!! Form::textarea('notulen', $bgttkomite1->notulen_komite, ['class'=>'form-control', 'placeholder' => 'Notulen (Max 5.000 Karakter)', 'rows' => '10', 'maxlength' => 5000, 'style' => 'resize:vertical', 'id' => 'notulen', 'required']) !!}
      @endif
      {!! $errors->first('notulen', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-9 {{ $errors->has('estimasi') ? ' has-error' : '' }}">
      {!! Form::label('estimasi', 'Estimasi (*)') !!}
      {!! Form::textarea('estimasi', null, ['class'=>'form-control', 'placeholder' => 'Estimasi (Max 100 Karakter)', 'rows' => '3', 'maxlength' => 100, 'style' => 'resize:vertical', 'id' => 'estimasi', 'required']) !!}
      {!! $errors->first('estimasi', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('hasil_komite') ? ' has-error' : '' }}">
      {!! Form::label('hasil_komite', 'Hasil Komite (*)') !!}
      {!! Form::select('hasil_komite', ['APPROVE' => 'APPROVE', 'REVISI' => 'REVISI', 'CANCEL' => 'CANCEL'], null, ['class'=>'form-control select2', 'placeholder' => 'Pilih Hasil Komite', 'required', 'id' => 'hasil_komite']) !!}
      {!! $errors->first('hasil_komite', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-body" id="field-detail">
  @foreach ($bgttkomite1->bgttkomite3s()->orderBy("no_seq")->get() as $model)
    <div class="row" id="field_{{ $loop->iteration }}">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title" id="box_{{ $loop->iteration }}">Item to be Follow Up Ke-{{ $loop->iteration }} (No. Seq: {{ $model->no_seq }})</h3>
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
              <div class="col-sm-12">
                <label name="ket_item_{{ $loop->iteration }}">Keterangan (*)</label>
                <input type="hidden" id="no_seq_{{ $loop->iteration }}" name="no_seq_{{ $loop->iteration }}" value="{{ $model->no_seq }}" readonly="readonly">
                <textarea id="ket_item_{{ $loop->iteration }}" name="ket_item_{{ $loop->iteration }}" class="form-control" placeholder="Keterangan" rows="3" maxlength="500" style="resize:vertical">{{ $model->ket_item }}</textarea>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-6">
                <label name="approve1_{{ $loop->iteration }}">Approval 1</label>
                <input type="text" id="approve1_{{ $loop->iteration }}" name="approve1_{{ $loop->iteration }}" class="form-control" placeholder="Approval 1" value="-" disabled="">
              </div>
              <div class="col-sm-6">
                <label name="approve2_{{ $loop->iteration }}">Approval 2</label>
                <input type="text" id="approve2_{{ $loop->iteration }}" name="approve2_{{ $loop->iteration }}" class="form-control" placeholder="Approval 2" value="-" disabled="">
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
  {!! Form::hidden('jml_row', $bgttkomite1->bgttkomite3s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
</div>
<!-- /.box-body -->

<div class="box-body">
  <p class="pull-right">
    <button id="addRow" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Detail"><span class="glyphicon glyphicon-plus"></span> Add Item to be Follow Up</button>
  </p>
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save Notulen Komite', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('bgttkomite1s.allnotulen') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Karyawan -->
@include('budget.komite.popup.karyawanModal')

@section('scripts')
<script type="text/javascript">

	document.getElementById("latar_belakang").focus();

  HTMLTextAreaElement.prototype.getCaretPosition = function () { //return the caret position of the textarea
    return this.selectionStart;
  };
  HTMLTextAreaElement.prototype.setCaretPosition = function (position) { //change the caret position of the textarea
    this.selectionStart = position;
    this.selectionEnd = position;
    this.focus();
  };
  HTMLTextAreaElement.prototype.hasSelection = function () { //if the textarea has selection then return true
    if (this.selectionStart == this.selectionEnd) {
      return false;
    } else {
      return true;
    }
  };
  HTMLTextAreaElement.prototype.getSelectedText = function () { //return the selection text
    return this.value.substring(this.selectionStart, this.selectionEnd);
  };
  HTMLTextAreaElement.prototype.setSelection = function (start, end) { //change the selection area of the textarea
    this.selectionStart = start;
    this.selectionEnd = end;
    this.focus();
  };

  var latar_belakang = document.getElementById("latar_belakang");

  latar_belakang.onkeydown = function(event) {
    //support tab on textarea
    if (event.keyCode == 9) { //tab was pressed
      var newCaretPosition;
      newCaretPosition = latar_belakang.getCaretPosition() + "    ".length;
      latar_belakang.value = latar_belakang.value.substring(0, latar_belakang.getCaretPosition()) + "    " + latar_belakang.value.substring(latar_belakang.getCaretPosition(), latar_belakang.value.length);
      latar_belakang.setCaretPosition(newCaretPosition);
      return false;
    }
    if(event.keyCode == 8){ //backspace
      if (latar_belakang.value.substring(latar_belakang.getCaretPosition() - 4, latar_belakang.getCaretPosition()) == "    ") { //it's a tab space
        var newCaretPosition;
        newCaretPosition = latar_belakang.getCaretPosition() - 3;
        latar_belakang.value = latar_belakang.value.substring(0, latar_belakang.getCaretPosition() - 3) + latar_belakang.value.substring(latar_belakang.getCaretPosition(), latar_belakang.value.length);
        latar_belakang.setCaretPosition(newCaretPosition);
      }
    }
    if(event.keyCode == 37){ //left arrow
      var newCaretPosition;
      if (latar_belakang.value.substring(latar_belakang.getCaretPosition() - 4, latar_belakang.getCaretPosition()) == "    ") { //it's a tab space
        newCaretPosition = latar_belakang.getCaretPosition() - 3;
        latar_belakang.setCaretPosition(newCaretPosition);
      }
    }
    if(event.keyCode == 39){ //right arrow
      var newCaretPosition;
      if (latar_belakang.value.substring(latar_belakang.getCaretPosition() + 4, latar_belakang.getCaretPosition()) == "    ") { //it's a tab space
        newCaretPosition = latar_belakang.getCaretPosition() + 3;
        latar_belakang.setCaretPosition(newCaretPosition);
      }
    } 
  }

  var notulen = document.getElementById("notulen");

  notulen.onkeydown = function(event) {
    //support tab on textarea
    if (event.keyCode == 9) { //tab was pressed
      var newCaretPosition;
      newCaretPosition = notulen.getCaretPosition() + "    ".length;
      notulen.value = notulen.value.substring(0, notulen.getCaretPosition()) + "    " + notulen.value.substring(notulen.getCaretPosition(), notulen.value.length);
      notulen.setCaretPosition(newCaretPosition);
      return false;
    }
    if(event.keyCode == 8){ //backspace
      if (notulen.value.substring(notulen.getCaretPosition() - 4, notulen.getCaretPosition()) == "    ") { //it's a tab space
        var newCaretPosition;
        newCaretPosition = notulen.getCaretPosition() - 3;
        notulen.value = notulen.value.substring(0, notulen.getCaretPosition() - 3) + notulen.value.substring(notulen.getCaretPosition(), notulen.value.length);
        notulen.setCaretPosition(newCaretPosition);
      }
    }
    if(event.keyCode == 37){ //left arrow
      var newCaretPosition;
      if (notulen.value.substring(notulen.getCaretPosition() - 4, notulen.getCaretPosition()) == "    ") { //it's a tab space
        newCaretPosition = notulen.getCaretPosition() - 3;
        notulen.setCaretPosition(newCaretPosition);
      }
    }
    if(event.keyCode == 39){ //right arrow
      var newCaretPosition;
      if (notulen.value.substring(notulen.getCaretPosition() + 4, notulen.getCaretPosition()) == "    ") { //it's a tab space
        newCaretPosition = notulen.getCaretPosition() + 3;
        notulen.setCaretPosition(newCaretPosition);
      }
    } 
  }

  var estimasi = document.getElementById("estimasi");

  estimasi.onkeydown = function(event) {
    //support tab on textarea
    if (event.keyCode == 9) { //tab was pressed
      var newCaretPosition;
      newCaretPosition = estimasi.getCaretPosition() + "    ".length;
      estimasi.value = estimasi.value.substring(0, estimasi.getCaretPosition()) + "    " + estimasi.value.substring(estimasi.getCaretPosition(), estimasi.value.length);
      estimasi.setCaretPosition(newCaretPosition);
      return false;
    }
    if(event.keyCode == 8){ //backspace
      if (estimasi.value.substring(estimasi.getCaretPosition() - 4, estimasi.getCaretPosition()) == "    ") { //it's a tab space
        var newCaretPosition;
        newCaretPosition = estimasi.getCaretPosition() - 3;
        estimasi.value = estimasi.value.substring(0, estimasi.getCaretPosition() - 3) + estimasi.value.substring(estimasi.getCaretPosition(), estimasi.value.length);
        estimasi.setCaretPosition(newCaretPosition);
      }
    }
    if(event.keyCode == 37){ //left arrow
      var newCaretPosition;
      if (estimasi.value.substring(estimasi.getCaretPosition() - 4, estimasi.getCaretPosition()) == "    ") { //it's a tab space
        newCaretPosition = estimasi.getCaretPosition() - 3;
        estimasi.setCaretPosition(newCaretPosition);
      }
    }
    if(event.keyCode == 39){ //right arrow
      var newCaretPosition;
      if (estimasi.value.substring(estimasi.getCaretPosition() + 4, estimasi.getCaretPosition()) == "    ") { //it's a tab space
        newCaretPosition = estimasi.getCaretPosition() + 3;
        estimasi.setCaretPosition(newCaretPosition);
      }
    } 
  }

	//Initialize Select2 Elements
  $(".select2").select2();

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();

      var validasi = "T";
      var msg = "";

      if(validasi !== "T") {
        var info = msg;
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        var valid = 'T';
        var msg = "Anda yakin menyimpan data ini?";
        var txt = "";

        if(valid === 'T') {
          swal({
            title: msg,
            text: txt,
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
            if (dismiss === 'cancel') {
            }
          })
        } else {
          swal(msg, txt, "warning");
        }
      }
    }
  });

  function keyPressedKaryawan(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupkaryawan').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('latar_belakang').focus();
    }
  }

  $(document).ready(function(){
    $("#btnpopupkaryawan").click(function(){
      popupKaryawan();
    });
  });

  function popupKaryawan() {
    var myHeading = "<p>Popup Presenter</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupKaryawans') }}';
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
      processing: true,
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[1, 'asc']],
      columns: [
      { data: 'npk', name: 'npk'},
      { data: 'nama', name: 'nama'},
      { data: 'kd_pt', name: 'kd_pt', className: 'none'},
      { data: 'desc_dep', name: 'desc_dep'},
      { data: 'desc_div', name: 'desc_div'},
      { data: 'email', name: 'email', className: 'none'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKaryawan.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("npk_presenter_act").value = value["npk"];
            document.getElementById("nm_presenter_act").value = value["nama"];
            $('#karyawanModal').modal('hide');
            validateKaryawan();
          });
        });
        $('#karyawanModal').on('hidden.bs.modal', function () {
          var npk_presenter_act = document.getElementById("npk_presenter").value.trim();
          if(npk_presenter_act === '') {
            document.getElementById("npk_presenter_act").value = "";
            document.getElementById("nm_presenter_act").value = "";
            $('#npk_presenter_act').focus();
          } else {
            $('#latar_belakang').focus();
          }
        });
      },
    });
  }

  function validateKaryawan() {
    var npk_presenter_act = document.getElementById("npk_presenter_act").value.trim();
    if(npk_presenter_act !== '') {
      var url = '{{ route('datatables.validasiKaryawan', 'param') }}';
      url = url.replace('param', window.btoa(npk_presenter_act));
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("npk_presenter_act").value = result["npk"];
          document.getElementById("nm_presenter_act").value = result["nama"];
        } else {
          document.getElementById("npk_presenter_act").value = "";
          document.getElementById("nm_presenter_act").value = "";
          document.getElementById("npk_presenter_act").focus();
          swal("Npk Presenter tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("npk_presenter_act").value = "";
      document.getElementById("nm_presenter_act").value = "";
    }
  }

  $("#addRow").click(function(){
    var jml_row = document.getElementById("jml_row").value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row").value = jml_row;
    var no_seq = 'no_seq_'+jml_row;
    var ket_item = 'ket_item_'+jml_row;
    var approve1 = 'approve1_'+jml_row;
    var approve2 = 'approve2_'+jml_row;
    var btndelete = 'btndelete_'+jml_row;
    var id_field = 'field_'+jml_row;
    var id_box = 'box_'+jml_row;

    $("#field-detail").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Item to be Follow Up Ke-'+ jml_row +'</h3>\
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
                <div class="col-sm-12">\
                  <label name="' + ket_item + '">Keterangan (*)</label>\
                  <input type="hidden" id="' + no_seq + '" name="' + no_seq + '" value="0" readonly="readonly">\
                  <textarea id="' + ket_item + '" name="' + ket_item + '" class="form-control" placeholder="Keterangan" rows="3" maxlength="500" style="resize:vertical"></textarea>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-6">\
                  <label name="' + approve1 + '">Approval 1</label>\
                  <input type="text" id="' + approve1 + '" name="' + approve1 + '" class="form-control" placeholder="Approval 1" disabled="">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + approve2 + '">Approval 2</label>\
                  <input type="text" id="' + approve2 + '" name="' + approve2 + '" class="form-control" placeholder="Approval 2" disabled="">\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );
    document.getElementById(ket_item).focus();
  });

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
      var ket_item = "#ket_item_" + $i;
      var ket_item_new = "ket_item_" + ($i-1);
      $(ket_item).attr({"id":ket_item_new, "name":ket_item_new});
      var approve1 = "#approve1_" + $i;
      var approve1_new = "approve1_" + ($i-1);
      $(approve1).attr({"id":approve1_new, "name":approve1_new});
      var approve2 = "#approve2_" + $i;
      var approve2_new = "approve2_" + ($i-1);
      $(approve2).attr({"id":approve2_new, "name":approve2_new});
      var btndelete = "#btndelete_" + $i;
      var btndelete_new = "btndelete_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var id_field = "#field_" + $i;
      var id_field_new = "field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_" + $i;
      var id_box_new = "box_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row").value = jml_row;
  }

  function deleteDetail(ths) {
    var msg = 'Anda yakin menghapus Item to be Follow Up ini?';
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
      var no_seq = document.getElementById("no_seq_" + row).value.trim();
      var no_komite = document.getElementById("no_komite").value.trim();
      if(no_seq === "" || no_seq === "0") {
        changeId(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('bgttkomite1s.deletedetail', ['param','param2']) }}";
        url = url.replace('param2', window.btoa(no_seq));
        url = url.replace('param', window.btoa(no_komite));
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
</script>
@endsection