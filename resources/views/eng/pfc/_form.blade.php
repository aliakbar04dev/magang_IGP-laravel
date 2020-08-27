{!! Form::hidden('st_submit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_submit']) !!}
<div class="box-body" id="field-part">
  <div class="form-group">
    <div class="col-sm-3">
      {!! Form::label('reg_doc_type', 'Doc Type (*)') !!}
      {!! Form::select('reg_doc_type', ['STRICTLY CONFIDENTIAL' => 'STRICTLY CONFIDENTIAL', 'HIGHLY CONFIDENTIAL' => 'HIGHLY CONFIDENTIAL', 'CONFIDENTIAL' => 'CONFIDENTIAL', 'INTERNAL' => 'INTERNAL', 'UNRESTRICTED DATA OR PUBLIC' => 'UNRESTRICTED DATA OR PUBLIC'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Doc Type', 'required', 'id' => 'reg_doc_type']) !!}
    </div>
    <div class="col-sm-3">
      {!! Form::label('st_pfc', 'Status (*)') !!}
      {!! Form::select('st_pfc', ['PROTOTYPE' => 'PROTOTYPE', 'PRELAUNCH' => 'PRELAUNCH', 'PRODUCTION' => 'PRODUCTION'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'required', 'id' => 'st_pfc']) !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_cust') ? ' has-error' : '' }}">
      {!! Form::label('kd_cust', 'Customer (F9) (*)') !!}
      <div class="input-group">
        @if (empty($engttpfc1->id))
          {!! Form::text('kd_cust', null, ['class'=>'form-control','placeholder' => 'Customer', 'maxlength' => 2, 'onkeydown' => 'keyPressedKdCust(event)', 'onchange' => 'validateKdCust()', 'required', 'id' => 'kd_cust']) !!}
          <span class="input-group-btn">
            <button id="btnpopupcustomer" type="button" class="btn btn-info" data-toggle="modal" data-target="#customerModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          {!! Form::text('kd_cust', null, ['class'=>'form-control','placeholder' => 'Customer', 'maxlength' => 2, 'onkeydown' => 'keyPressedKdCust(event)', 'onchange' => 'validateKdCust()', 'required', 'id' => 'kd_cust', 'readonly' => 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupcustomer" type="button" class="btn btn-info" data-toggle="modal" data-target="#customerModal" disabled="">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
      </div>
      {!! $errors->first('kd_cust', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_cust') ? ' has-error' : '' }}">
      {!! Form::label('nm_cust', 'Nama Customer') !!}
      {!! Form::text('nm_cust', null, ['class'=>'form-control','placeholder' => 'Nama Customer', 'disabled'=>'', 'id' => 'nm_cust']) !!}
      {!! $errors->first('nm_cust', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-8 {{ $errors->has('kd_model') ? ' has-error' : '' }}">
      {!! Form::label('kd_model', 'Model Name (F9) (*)') !!}
      <div class="input-group">
        @if (empty($engttpfc1->id))
          {!! Form::text('kd_model', null, ['class'=>'form-control','placeholder' => 'Model Name', 'maxlength' => 40, 'onkeydown' => 'keyPressedKdModel(event)', 'onchange' => 'validateKdModel()', 'required', 'id' => 'kd_model']) !!}
          <span class="input-group-btn">
            <button id="btnpopupmodel" type="button" class="btn btn-info" data-toggle="modal" data-target="#modelModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          {!! Form::text('kd_model', null, ['class'=>'form-control','placeholder' => 'Model Name', 'maxlength' => 40, 'onkeydown' => 'keyPressedKdModel(event)', 'onchange' => 'validateKdModel()', 'required', 'id' => 'kd_model', 'readonly' => 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupmodel" type="button" class="btn btn-info" data-toggle="modal" data-target="#modelModal" disabled="">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
      </div>
      {!! $errors->first('kd_model', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_line') ? ' has-error' : '' }}">
      {!! Form::label('kd_line', 'Line (F9) (*)') !!}
      <div class="input-group">
        @if (empty($engttpfc1->id))
          {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 5, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line']) !!}
          <span class="input-group-btn">
            <button id="btnpopupline" name="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          @if($engttpfc1->engtTpfc2s()->get()->count() > 0)
            {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 5, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line', 'readonly' => 'readonly']) !!}
            <span class="input-group-btn">
              <button id="btnpopupline" name="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal" disabled="">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @else 
            {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 5, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line']) !!}
            <span class="input-group-btn">
              <button id="btnpopupline" name="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @endif
        @endif
      </div>
      {!! $errors->first('kd_line', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_line') ? ' has-error' : '' }}">
      {!! Form::label('nm_line', 'Nama Line') !!}
      {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
      {!! $errors->first('nm_line', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2">
      {!! Form::label('addPart', 'Add Part No') !!}
      <button id="addPart" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Part No"><span class="glyphicon glyphicon-plus"></span> Add Part No</button>
    </div>
  </div>
  <!-- /.form-group -->
  @if (!empty($engttpfc1->id))
    @foreach ($engttpfc1->engtTpfc3s()->orderBy("id")->get() as $model)
      <div class="form-group" id="part_field_{{ $loop->iteration }}">
        <div class="col-sm-3">
          <input type="hidden" id="part_engt_tpfc3_id_{{ $loop->iteration }}" name="part_engt_tpfc3_id_{{ $loop->iteration }}" value="{{ base64_encode($model->id) }}" readonly="readonly">
          <input type="hidden" id="part_engt_tpfc1_id_{{ $loop->iteration }}" name="part_engt_tpfc1_id_{{ $loop->iteration }}" value="{{ base64_encode($model->engt_tpfc1_id) }}" readonly="readonly">
          <label name="part_no_label_{{ $loop->iteration }}" id="part_no_label_{{ $loop->iteration }}">Part No Ke-{{ $loop->iteration }}</label>
          <div class="input-group">
            <input type="text" id="part_no_{{ $loop->iteration }}" name="part_no_{{ $loop->iteration }}" required class="form-control" placeholder="Part No" onkeydown="keyPressedPartNo(this, event)" onchange="validatePartNo(this)" maxlength="40" value="{{ $model->part_no }}">
            <span class="input-group-btn">
              <button id="part_btnpopuppart_{{ $loop->iteration }}" name="part_btnpopuppart_{{ $loop->iteration }}" type="button" class="btn btn-info" onclick="popupPartNo(this)" data-toggle="modal" data-target="#partModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
        </div>
        <div class="col-sm-5">
          <label name="nm_part_label_{{ $loop->iteration }}" id="nm_part_label_{{ $loop->iteration }}">Part Name Ke-{{ $loop->iteration }}</label>
          <input type="text" id="nm_part_{{ $loop->iteration }}" name="nm_part_{{ $loop->iteration }}" class="form-control" placeholder="Part Name" disabled="" value="{{ $model->nm_part }}">
        </div>
        <div class="col-sm-1">
          <label name="part_btndelete_label_{{ $loop->iteration }}" id="part_btndelete_label_{{ $loop->iteration }}">Remove</label>
          <button id="part_btndelete_{{ $loop->iteration }}" name="part_btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" onclick="deletePart(this)">
            <i class="fa fa-times"></i>
          </button>
        </div>
      </div>
    @endforeach
    {!! Form::hidden('jml_part', $engttpfc1->engtTpfc3s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_part']) !!}
  @else
    {!! Form::hidden('jml_part', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_part']) !!}
  @endif
</div>
<!-- /.box-body -->

<div class="box-body" id="field-detail">
  @if (!empty($engttpfc1->id))
    @foreach ($engttpfc1->engtTpfc2s()->orderBy("no_urut")->get() as $model)
      <div class="row" id="field_{{ $loop->iteration }}">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title" id="box_{{ $loop->iteration }}">Detail Ke-{{ $loop->iteration }}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button id="btndelete_{{ $loop->iteration }}" name="btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Detail" onclick="deleteDetail(this)">
                  <i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-1">
                  <input type="hidden" id="engt_tpfc2_id_{{ $loop->iteration }}" name="engt_tpfc2_id_{{ $loop->iteration }}" value="{{ base64_encode($model->id) }}" readonly="readonly">
                  <input type="hidden" id="engt_tpfc1_id_{{ $loop->iteration }}" name="engt_tpfc1_id_{{ $loop->iteration }}" value="{{ base64_encode($model->engt_tpfc1_id) }}" readonly="readonly">
                  <label name="no_urut_{{ $loop->iteration }}">No. (*)</label>
                  <input type="number" id="no_urut_{{ $loop->iteration }}" name="no_urut_{{ $loop->iteration }}" required class="form-control" placeholder="No." min="1" max="9999" style="text-align:right;" step="1" value="{{ $model->no_urut }}">
                </div>
                <div class="col-sm-1">
                  <label name="no_op_{{ $loop->iteration }}">No. OP</label>
                  <input type="number" id="no_op_{{ $loop->iteration }}" name="no_op_{{ $loop->iteration }}" class="form-control" placeholder="No. OP" min="1" max="9999" style="text-align:right;" step="1" value="{{ $model->no_op }}">
                </div>
                <div class="col-sm-3">
                  <label name="kd_mesin_{{ $loop->iteration }}">M/C Code (*)</label>                  
                  <div class="input-group">
                    <input type="text" id="kd_mesin_{{ $loop->iteration }}" name="kd_mesin_{{ $loop->iteration }}" required class="form-control" placeholder="M/C Code" onkeydown="keyPressedMesin(this, event)" onchange="validateMesin(this)" maxlength="20" value="{{ $model->kd_mesin }}">
                    <span class="input-group-btn">
                      <button id="btnpopupmesin_{{ $loop->iteration }}" name="btnpopupmesin_{{ $loop->iteration }}" type="button" class="btn btn-info" onclick="popupMesin(this)" data-toggle="modal" data-target="#mesinModal">
                        <span class="glyphicon glyphicon-search"></span>
                      </button>
                    </span>
                  </div>
                </div>
                <div class="col-sm-3">
                  <label name="nm_proses_{{ $loop->iteration }}">Machine Type</label>
                  <input type="text" id="nm_proses_{{ $loop->iteration }}" name="nm_proses_{{ $loop->iteration }}" class="form-control" placeholder="Machine Type" disabled="" value="{{ $model->nm_proses }}">
                </div>
                <div class="col-sm-4">
                  <label name="nm_mesin_{{ $loop->iteration }}">Machine Name</label>
                  <input type="text" id="nm_mesin_{{ $loop->iteration }}" name="nm_mesin_{{ $loop->iteration }}" class="form-control" placeholder="Machine Name" disabled="" value="{{ $model->nm_mesin }}">
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-4">
                  <label name="engt_msimbol_id_{{ $loop->iteration }}">Flow Process (*)</label>
                  <select id="engt_msimbol_id_{{ $loop->iteration }}" name="engt_msimbol_id_{{ $loop->iteration }}" class="form-control select2" required>
                    <option value="">PILIH FLOW PROCESS</option>
                    @foreach($engt_msimbols->get() as $engt_msimbol)
                      <option value="{{$engt_msimbol->id}}" @if($engt_msimbol->id == $model->engt_msimbol_id) selected="selected" @endif>{{$engt_msimbol->ket}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-4">
                  <label name="nm_pros_{{ $loop->iteration }}">Process Name</label>
                  <textarea id="nm_pros_{{ $loop->iteration }}" name="nm_pros_{{ $loop->iteration }}" class="form-control" placeholder="Process Name" rows="3" maxlength="300" style="resize:vertical">{{ $model->nm_pros }}</textarea>
                </div>
                <div class="col-sm-4">
                  <label name="pros_draw_pict_{{ $loop->iteration }}">Ilustration Process</label>
                  @if (!empty($model->pros_draw_pict))
                    <input id="pros_draw_pict_{{ $loop->iteration }}" name="pros_draw_pict_{{ $loop->iteration }}" type="file" accept=".jpg,.jpeg,.png">
                    <p>
                      <img src="{{ $engttpfc1->pict($model, "pros_draw_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                      <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('engttpfc1s.deleteimage', [base64_encode($model->id), 'pros_draw_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                    </p>
                  @else 
                    <input id="pros_draw_pict_{{ $loop->iteration }}" name="pros_draw_pict_{{ $loop->iteration }}" type="file" accept=".jpg,.jpeg,.png">
                  @endif
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-2">
                  <label name="nil_ct_{{ $loop->iteration }}">CT</label>
                  <input type="number" id="nil_ct_{{ $loop->iteration }}" name="nil_ct_{{ $loop->iteration }}" class="form-control" placeholder="CT" min="0" max="9999" style="text-align:right;" step="1" value="{{ $model->nil_ct }}">
                </div>
                <div class="col-sm-2">
                  <label name="st_mesin_{{ $loop->iteration }}">Machine (*)</label>
                  {!! Form::select('st_mesin_'.$loop->iteration, ['NO USE' => 'NO USE', 'EXISTING' => 'EXISTING', 'NEW' => 'NEW'], $model->st_mesin, ['class'=>'form-control select2', 'id' => 'st_mesin_'.$loop->iteration, 'placeholder' => 'PILIH MACHINE']) !!}
                </div>
                <div class="col-sm-2">
                  <label name="st_tool_{{ $loop->iteration }}">Tooling (*)</label>
                  {!! Form::select('st_tool_'.$loop->iteration, ['NO USE' => 'NO USE', 'EXISTING' => 'EXISTING', 'NEW' => 'NEW'], $model->st_tool, ['class'=>'form-control select2', 'id' => 'st_tool_'.$loop->iteration, 'placeholder' => 'PILIH TOOLING']) !!}
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    @endforeach
    {!! Form::hidden('jml_row', $engttpfc1->engtTpfc2s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
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
  {!! Form::submit('Save PFC', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($engttpfc1->id))
    @if (Auth::user()->can('eng-pfc-submit'))
      &nbsp;&nbsp;
      <button id="btn-submit" type="button" class="btn btn-success">Save & Submit PFC</button>
    @endif
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('engttpfc1s.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@include('eng.pfc.popup.customerModal')
@include('eng.pfc.popup.lineModal')
@include('eng.pfc.popup.modelModal')
@include('eng.pfc.popup.partModal')
@include('eng.pfc.popup.mesinModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("reg_doc_type").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var kd_cust = document.getElementById("kd_cust").value.trim();
    var nm_cust = document.getElementById("nm_cust").value.trim();
    var kd_model = document.getElementById("kd_model").value.trim();
    var kd_line = document.getElementById("kd_line").value.trim();
    var nm_line = document.getElementById("nm_line").value.trim();
    var id = "0";
    @if(isset($engttpfc1))
      id = "{{ $engttpfc1->id }}";
    @endif
    var info = "Customer: " + kd_cust + " - " + nm_cust + ", Model: " + kd_model + ", Model: " + kd_line + " - " + nm_line;
    var msg = 'Anda yakin menghapus PFC ' + info + '?';
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
      var urlRedirect = "{{ route('engttpfc1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(id));
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
    var msg = "Anda yakin submit PFC ini?";
    var txt = "";
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
  });

  function keyPressedKdCust(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupcustomer').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('kd_model').focus();
    }
  }

  function keyPressedKdModel(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupmodel').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('kd_line').focus();
    }
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('addPart').focus();
    }
  }

  function generateImgSelect2() {
    $("select[name^='engt_msimbol_id_']").select2({
      templateResult: formatOptions
    });
  }

  function formatOptions (state) {
    if (!state.id) { 
      return state.text; 
    }

    var simbols = [];
    @foreach($engt_msimbols->get() as $engt_msimbol) 
      simbols[{{ $engt_msimbol->id }}] = "{{ $simbols[$engt_msimbol->id] }}";
    @endforeach

    var $state = $(
      '<span ><img sytle="display: inline-block;" src="'+ simbols[state.id] +'" /> ' + state.text + '</span>'
      );
    return $state;
  }

  $(document).ready(function(){
    $("#btnpopupcustomer").click(function(){
      popupKdCust();
    });

    $("#btnpopupmodel").click(function(){
      popupKdModel();
    });

    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    generateImgSelect2();
  });

  function popupKdCust() {
    var myHeading = "<p>Popup Customer</p>";
    $("#customerModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupEngtMcusts') }}';
    var lookupCustomer = $('#lookupCustomer').DataTable({
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
        { data: 'kd_cust', name: 'kd_cust'},
        { data: 'nm_cust', name: 'nm_cust'}, 
        { data: 'inisial', name: 'inisial'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupCustomer tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupCustomer.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_cust").value = value["kd_cust"];
            document.getElementById("nm_cust").value = value["nm_cust"];
            $('#customerModal').modal('hide');
            validateKdCust();
          });
        });
        $('#customerModal').on('hidden.bs.modal', function () {
          var kd_cust = document.getElementById("kd_cust").value.trim();
          if(kd_cust === '') {
            document.getElementById("kd_cust").value = "";
            document.getElementById("nm_cust").value = "";
            document.getElementById("kd_model").value = "";
            document.getElementById("kd_line").value = "";
            document.getElementById("nm_line").value = "";
            clearPart();
            $('#kd_cust').focus();
          } else {
            $('#kd_model').focus();
          }
        });
      },
    });
  }

  function validateKdCust() {
    var kd_cust = document.getElementById("kd_cust").value.trim();
    if(kd_cust !== '') {
      var url = '{{ route('datatables.validasiEngtMcust', 'param') }}';
      url = url.replace('param', window.btoa(kd_cust));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_cust").value = result["kd_cust"];
          document.getElementById("nm_cust").value = result["nm_cust"];
          validateKdModel();
        } else {
          document.getElementById("kd_cust").value = "";
          document.getElementById("nm_cust").value = "";
          document.getElementById("kd_model").value = "";
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          clearPart();
          document.getElementById("kd_cust").focus();
          swal("Customer tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_cust").value = "";
      document.getElementById("nm_cust").value = "";
      document.getElementById("kd_model").value = "";
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
      clearPart();
    }
  }

  function popupKdModel() {
    var myHeading = "<p>Popup Model</p>";
    $("#modelModalLabel").html(myHeading);
    var kd_cust = document.getElementById("kd_cust").value.trim();
    if(kd_cust === "") {
      kd_cust = "-";
    }
    var url = '{{ route('datatables.popupEngtMmodels', 'param') }}';
    url = url.replace('param', window.btoa(kd_cust));
    var lookupModel = $('#lookupModel').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
        { data: 'kd_model', name: 'kd_model'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupModel tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupModel.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_model").value = value["kd_model"];
            $('#modelModal').modal('hide');
            validateKdModel();
          });
        });
        $('#modelModal').on('hidden.bs.modal', function () {
          var kd_model = document.getElementById("kd_model").value.trim();
          if(kd_model === '') {
            document.getElementById("kd_model").value = "";
            document.getElementById("kd_line").value = "";
            document.getElementById("nm_line").value = "";
            clearPart();
            $('#kd_model').focus();
          } else {
            $('#kd_line').focus();
          }
        });
      },
    });
  }

  function validateKdModel() {
    var kd_model = document.getElementById("kd_model").value.trim();
    if(kd_model !== '') {
      var kd_cust = document.getElementById("kd_cust").value.trim();
      if(kd_cust === "") {
        kd_cust = "-";
      }
      var url = '{{ route('datatables.validasiEngtMmodel', ['param', 'param2']) }}';
      url = url.replace('param2', window.btoa(kd_model));
      url = url.replace('param', window.btoa(kd_cust));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_model").value = result["kd_model"];
          validateKdLine();
          clearPart();
        } else {
          document.getElementById("kd_model").value = "";
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          clearPart();
          document.getElementById("kd_model").focus();
          swal("Model Name tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_model").value = "";
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
      clearPart();
    }
  }

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var kd_cust = document.getElementById("kd_cust").value.trim();
    if(kd_cust === "") {
      kd_cust = "-";
    }
    var kd_model = document.getElementById("kd_model").value.trim();
    if(kd_model === "") {
      kd_model = "-";
    }
    var url = '{{ route('datatables.popupEngtMlines', ['param','param2']) }}';
    url = url.replace('param2', window.btoa(kd_model));
    url = url.replace('param', window.btoa(kd_cust));
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
        { data: 'kd_line', name: 'kd_line'},
        { data: 'nm_line', name: 'nm_line'}, 
        { data: 'kd_plant', name: 'kd_plant'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLine.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_line").value = value["kd_line"];
            document.getElementById("nm_line").value = value["nm_line"];
            $('#lineModal').modal('hide');
            validateKdLine();
          });
        });
        $('#lineModal').on('hidden.bs.modal', function () {
          var kd_line = document.getElementById("kd_line").value.trim();
          if(kd_line === '') {
            document.getElementById("kd_line").value = "";
            document.getElementById("nm_line").value = "";
            $('#kd_line').focus();
          } else {
            document.getElementById('addPart').focus();
          }
        });
      },
    });
  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      var kd_cust = document.getElementById("kd_cust").value.trim();
      if(kd_cust === "") {
        kd_cust = "-";
      }
      var kd_model = document.getElementById("kd_model").value.trim();
      if(kd_model === "") {
        kd_model = "-";
      }
      var url = '{{ route('datatables.validasiEngtMline', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(kd_line));
      url = url.replace('param2', window.btoa(kd_model));
      url = url.replace('param', window.btoa(kd_cust));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["kd_line"];
          document.getElementById("nm_line").value = result["nm_line"];
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

  function validasiSize() {
    $("input[name^='_pict_']").bind('change', function() {
      let filesize = this.files[0].size // On older browsers this can return NULL.
      let filesizeMB = (filesize / (1024*1024)).toFixed(2);
      if(filesizeMB > 8) {
        var info = "Size File tidak boleh > 8 MB";
        swal(info, "Perhatikan inputan anda!", "warning");
        this.value = null;
      }
    });
  }

  validasiSize();

  function keyPressedPartNo(ths, e) {
    if(e.keyCode == 120) { //F9
      var row = ths.id.replace('part_no__', '');
      var id_btn = "#part_btnpopuppart_" + row;
      $(id_btn).click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("addRow").focus();
    }
  }

  function popupPartNo(ths) {
    var myHeading = "<p>Popup Part</p>";
    $("#partModalLabel").html(myHeading);
    var kd_model = document.getElementById("kd_model").value.trim();
    if(kd_model === "") {
      kd_model = "-";
    }
    var url = '{{ route('datatables.popupEngtMparts', 'param') }}';
    url = url.replace('param', window.btoa(kd_model));
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
        { data: 'part_no', name: 'part_no'}, 
        { data: 'nm_part', name: 'nm_part'}, 
        { data: 'nm_material', name: 'nm_material'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupPart tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupPart.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('part_btnpopuppart_', '');
            var id_part_no = "part_no_" + row;
            var id_nm_part = "nm_part_" + row;
            document.getElementById(id_part_no).value = value["part_no"];
            document.getElementById(id_nm_part).value = value["nm_part"];
            $('#partModal').modal('hide');
          });
        });
        $('#partModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('part_btnpopuppart_', '');
          var id_part_no = "part_no_" + row;
          var id_nm_part = "nm_part_" + row;
          var part_no = document.getElementById(id_part_no).value.trim();
          if(part_no === '') {
            document.getElementById(id_part_no).value = "";
            document.getElementById(id_nm_part).value = "";
            document.getElementById(id_part_no).focus();
          } else {
            document.getElementById("addRow").focus();
          }
        });
      },
    });
  }

  function validatePartNo(ths) {
    var row = ths.id.replace('part_no_', '');
    var id_part_no = "part_no_" + row;
    var id_nm_part = "nm_part_" + row;
    var part_no = document.getElementById(id_part_no).value.trim();
    if(part_no !== '') {
      var kd_model = document.getElementById("kd_model").value.trim();
      if(kd_model === "") {
        kd_model = "-";
      }
      var url = '{{ route('datatables.validasiEngtMpart', ['param', 'param2']) }}';
      url = url.replace('param2', window.btoa(part_no));
      url = url.replace('param', window.btoa(kd_model));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById(id_part_no).value = result["part_no"];
          document.getElementById(id_nm_part).value = result["nm_part"];
        } else {
          document.getElementById(id_part_no).value = "";
          document.getElementById(id_nm_part).value = "";
          document.getElementById(id_part_no).focus();
          swal("Part No tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById(id_part_no).value = "";
      document.getElementById(id_nm_part).value = "";
    }
  }

  function keyPressedMesin(ths, e) {
    if(e.keyCode == 120) { //F9
      var row = ths.id.replace('kd_mesin_', '');
      var id_btn = "#btnpopupmesin_" + row;
      $(id_btn).click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var row = ths.id.replace('kd_mesin_', '');
      row = Number(row);
      var engt_msimbol_id = 'engt_msimbol_id_'+row;
      document.getElementById(engt_msimbol_id).focus();
    }
  }

  function popupMesin(ths) {
    var myHeading = "<p>Popup Mesin</p>";
    $("#mesinModalLabel").html(myHeading);
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line === "") {
      kd_line = "-";
    }
    var url = '{{ route('datatables.popupEngtMmesins', 'param') }}';
    url = url.replace('param', window.btoa(kd_line));
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
        { data: 'nm_maker', name: 'nm_maker'}, 
        { data: 'mdl_type', name: 'mdl_type'}, 
        { data: 'nm_proses', name: 'nm_proses'}, 
        { data: 'thn_buat', name: 'thn_buat'}, 
        { data: 'no_asset', name: 'no_asset'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupMesin tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupMesin.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopupmesin_', '');
            var id_kd_mesin = "kd_mesin_" + row;
            var id_nm_proses = "nm_proses_" + row;
            var id_nm_mesin = "nm_mesin_" + row;
            document.getElementById(id_kd_mesin).value = value["kd_mesin"];
            document.getElementById(id_nm_proses).value = value["nm_proses"];
            document.getElementById(id_nm_mesin).value = value["nm_mesin"];
            $('#mesinModal').modal('hide');
          });
        });
        $('#mesinModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopupmesin_', '');
          var id_kd_mesin = "kd_mesin_" + row;
          var id_nm_proses = "nm_proses_" + row;
          var id_nm_mesin = "nm_mesin_" + row;
          var id_engt_msimbol_id = "engt_msimbol_id_" + row;
          var kd_mesin = document.getElementById(id_kd_mesin).value.trim();
          if(kd_mesin === '') {
            document.getElementById(id_kd_mesin).value = "";
            document.getElementById(id_nm_proses).value = "";
            document.getElementById(id_nm_mesin).value = "";
            document.getElementById(id_kd_mesin).focus();
          } else {
            document.getElementById(id_engt_msimbol_id).focus();
          }
        });
      },
    });
  }

  function validateMesin(ths) {
    var row = ths.id.replace('kd_mesin_', '');
    var id_kd_mesin = "kd_mesin_" + row;
    var id_nm_proses = "nm_proses_" + row;
    var id_nm_mesin = "nm_mesin_" + row;
    var kd_mesin = document.getElementById(id_kd_mesin).value.trim();
    if(kd_mesin !== '') {
      var kd_line = document.getElementById("kd_line").value.trim();
      if(kd_line === "") {
        kd_line = "-";
      }
      var url = '{{ route('datatables.validasiEngtMmesin', ['param', 'param2']) }}';
      url = url.replace('param2', window.btoa(kd_mesin));
      url = url.replace('param', window.btoa(kd_line));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById(id_kd_mesin).value = result["kd_mesin"];
          document.getElementById(id_nm_proses).value = result["nm_proses"];
          document.getElementById(id_nm_mesin).value = result["nm_mesin"];
        } else {
          document.getElementById(id_kd_mesin).value = "";
          document.getElementById(id_nm_proses).value = "";
          document.getElementById(id_nm_mesin).value = "";
          document.getElementById(id_kd_mesin).focus();
          swal("M/C Code tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById(id_kd_mesin).value = "";
      document.getElementById(id_nm_proses).value = "";
      document.getElementById(id_nm_mesin).value = "";
    }
  }

  $("#addPart").click(function(){
    var jml_part = document.getElementById("jml_part").value.trim();
    jml_part = Number(jml_part) + 1;
    document.getElementById("jml_part").value = jml_part;
    var engt_tpfc3_id = 'part_engt_tpfc3_id_'+jml_part;
    var engt_tpfc1_id = 'part_engt_tpfc1_id_'+jml_part;
    var part_no = 'part_no_'+jml_part;
    var part_no_label = 'part_no_label_'+jml_part;
    var nm_part = 'nm_part_'+jml_part;
    var nm_part_label = 'nm_part_label_'+jml_part;
    var btndelete = 'part_btndelete_'+jml_part;
    var btndelete_label = 'part_btndelete_label_'+jml_part;
    var btnpopuppart = 'part_btnpopuppart_'+jml_part;
    var id_field = 'part_field_'+jml_part;

    $("#field-part").append(
      '<div class="form-group" id="'+id_field+'">\
          <div class="col-sm-3">\
            <input type="hidden" id="' + engt_tpfc3_id + '" name="' + engt_tpfc3_id + '" value="0" readonly="readonly">\
            <input type="hidden" id="' + engt_tpfc1_id + '" name="' + engt_tpfc1_id + '" value="0" readonly="readonly">\
            <label name="' + part_no_label + '" id="' + part_no_label + '">Part No Ke-'+ jml_part +'</label>\
            <div class="input-group">\
              <input type="text" id="' + part_no + '" name="' + part_no + '" required class="form-control" placeholder="Part No" onkeydown="keyPressedPartNo(this, event)" onchange="validatePartNo(this)" maxlength="40">\
              <span class="input-group-btn">\
                <button id="' + btnpopuppart + '" name="' + btnpopuppart + '" type="button" class="btn btn-info" onclick="popupPartNo(this)" data-toggle="modal" data-target="#partModal">\
                  <span class="glyphicon glyphicon-search"></span>\
                </button>\
              </span>\
            </div>\
          </div>\
          <div class="col-sm-5">\
            <label name="' + nm_part_label + '" id="' + nm_part_label + '">Part Name Ke-'+ jml_part +'</label>\
            <input type="text" id="' + nm_part + '" name="' + nm_part + '" class="form-control" placeholder="Part Name" disabled="">\
          </div>\
          <div class="col-sm-1">\
            <label name="' + btndelete_label + '" id="' + btndelete_label + '">Remove</label>\
            <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" onclick="deletePart(this)">\
              <i class="fa fa-times"></i>\
            </button>\
          </div>\
      </div>'
    );
    
    $('#kd_cust').removeAttr('readonly');
    $('#kd_cust').attr('readonly', 'readonly');
    $('#btnpopupcustomer').removeAttr('disabled');
    $('#btnpopupcustomer').attr('disabled', '');

    $('#kd_model').removeAttr('readonly');
    $('#kd_model').attr('readonly', 'readonly');
    $('#btnpopupmodel').removeAttr('disabled');
    $('#btnpopupmodel').attr('disabled', '');
    
    document.getElementById(part_no).focus();
  });

  function changeIdPart(row) {
    var id_field = "#part_field_" + row;
    $(id_field).remove();

    // var engt_tpfc3_id = '#part_engt_tpfc3_id_'+row;
    // $(engt_tpfc3_id).remove();
    // var engt_tpfc1_id = '#part_engt_tpfc1_id_'+row;
    // $(engt_tpfc1_id).remove();
    // var part_no = '#part_no_'+row;
    // $(part_no).remove();
    // var part_no_label = '#part_no_label_'+row;
    // $(part_no_label).remove();
    // var nm_part = '#nm_part_'+row;
    // $(nm_part).remove();
    // var nm_part_label = '#nm_part_label_'+row;
    // $(nm_part_label).remove();
    // var btndelete = '#part_btndelete_'+row;
    // $(btndelete).remove();
    // var btndelete_label = '#part_btndelete_label_'+row;
    // $(btndelete_label).remove();
    // var btnpopuppart = '#part_btnpopuppart_'+row;
    // $(btnpopuppart).remove();
    
    var jml_part = document.getElementById("jml_part").value.trim();
    jml_part = Number(jml_part);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_part; $i++) {
      var engt_tpfc3_id = '#part_engt_tpfc3_id_' + $i;
      var engt_tpfc3_id_new = 'part_engt_tpfc3_id_' + ($i-1);
      $(engt_tpfc3_id).attr({"id":engt_tpfc3_id_new, "name":engt_tpfc3_id_new});
      var engt_tpfc1_id = '#part_engt_tpfc1_id_' + $i;
      var engt_tpfc1_id_new = 'part_engt_tpfc1_id_' + ($i-1);
      $(engt_tpfc1_id).attr({"id":engt_tpfc1_id_new, "name":engt_tpfc1_id_new});
      var part_no = '#part_no_' + $i;
      var part_no_new = 'part_no_' + ($i-1);
      $(part_no).attr({"id":part_no_new, "name":part_no_new});
      var part_no_label = '#part_no_label_' + $i;
      var part_no_label_new = 'part_no_label_' + ($i-1);
      $(part_no_label).attr({"id":part_no_label_new, "name":part_no_label_new});
      var nm_part = '#nm_part_' + $i;
      var nm_part_new = 'nm_part_' + ($i-1);
      $(nm_part).attr({"id":nm_part_new, "name":nm_part_new});
      var nm_part_label = '#nm_part_label_' + $i;
      var nm_part_label_new = 'nm_part_label_' + ($i-1);
      $(nm_part_label).attr({"id":nm_part_label_new, "name":nm_part_label_new});
      var btndelete = '#part_btndelete_' + $i;
      var btndelete_new = 'part_btndelete_' + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var btndelete_label = '#part_btndelete_label_' + $i;
      var btndelete_label_new = 'part_btndelete_label_' + ($i-1);
      $(btndelete_label).attr({"id":btndelete_label_new, "name":btndelete_label_new});
      var btnpopuppart = '#part_btnpopuppart_' + $i;
      var btnpopuppart_new = 'part_btnpopuppart_' + ($i-1);
      $(btnpopuppart).attr({"id":btnpopuppart_new, "name":btnpopuppart_new});
      var id_field = "#part_field_" + $i;
      var id_field_new = "part_field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});

      var text = document.getElementById(part_no_label_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(part_no_label_new).innerHTML = text;
      text = document.getElementById(nm_part_label_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(nm_part_label_new).innerHTML = text;
    }
    jml_part = jml_part - 1;
    document.getElementById("jml_part").value = jml_part;

    @if (empty($engttpfc1->id))
      if(jml_part < 1) {
        $('#kd_cust').removeAttr('readonly');
        $('#btnpopupcustomer').removeAttr('disabled');
        $('#kd_model').removeAttr('readonly');
        $('#btnpopupmodel').removeAttr('disabled');
      }
    @endif
  }

  function deletePart(ths) {
    var msg = 'Anda yakin menghapus Part No ini?';
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
      var row = ths.id.replace('part_btndelete_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var engt_tpfc3_id = document.getElementById("part_engt_tpfc3_id_" + row).value.trim();
      if(engt_tpfc3_id === "" || engt_tpfc3_id === "0") {
        changeIdPart(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('engttpfc1s.deletepart', 'param') }}";
        url = url.replace('param', engt_tpfc3_id);
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
              changeIdPart(row);
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

  function clearPart() {
    var jml_part = document.getElementById("jml_part").value.trim();
    jml_part = Number(jml_part);
    for($i = 1; $i <= jml_part; $i++) {
      var engt_tpfc3_id = 'part_engt_tpfc3_id_' + $i;
      var engt_tpfc1_id = 'part_engt_tpfc1_id_' + $i;
      var part_no = 'part_no_' + $i;
      var nm_part = 'nm_part_' + $i;
      document.getElementById(engt_tpfc3_id).value = "0";
      document.getElementById(engt_tpfc1_id).value = "0";
      document.getElementById(part_no).value = "";
      document.getElementById(nm_part).value = "";
    }
  }

  $("#addRow").click(function(){
    var jml_row = document.getElementById("jml_row").value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row").value = jml_row;
    var engt_tpfc2_id = 'engt_tpfc2_id_'+jml_row;
    var engt_tpfc1_id = 'engt_tpfc1_id_'+jml_row;
    var no_urut = 'no_urut_'+jml_row;
    var no_op = 'no_op_'+jml_row;
    var kd_mesin = 'kd_mesin_'+jml_row;
    var nm_proses = 'nm_proses_'+jml_row;
    var nm_mesin = 'nm_mesin_'+jml_row;
    var engt_msimbol_id = 'engt_msimbol_id_'+jml_row;
    var nm_pros = 'nm_pros_'+jml_row;
    var pros_draw_pict = 'pros_draw_pict_'+jml_row;
    var nil_ct = 'nil_ct_'+jml_row;
    var st_mesin = 'st_mesin_'+jml_row;
    var st_tool = 'st_tool_'+jml_row;
    var btndelete = 'btndelete_'+jml_row;
    var id_field = 'field_'+jml_row;
    var id_box = 'box_'+jml_row;
    var btnpopupmesin = 'btnpopupmesin_'+jml_row;

    var value_urut = 0;
    var value_op = 0;
    for($i = 1; $i < jml_row; $i++) {
      var value_urut_temp = document.getElementById("no_urut_" + $i).value;
      if(value_urut_temp != "") {
        value_urut_temp = Number(value_urut_temp);
        if(value_urut_temp > value_urut) {
          value_urut = value_urut_temp;
        }
      }

      var value_op_temp = document.getElementById("no_op_" + $i).value;
      if(value_op_temp != "") {
        value_op_temp = Number(value_op_temp);
        if(value_op_temp > value_op) {
          value_op = value_op_temp;
        }
      }
    }

    value_urut = value_urut + 10;
    value_op = value_op + 10;

    $("#field-detail").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Detail Ke-'+ jml_row +'</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Detail" onclick="deleteDetail(this)">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-1">\
                  <input type="hidden" id="' + engt_tpfc2_id + '" name="' + engt_tpfc2_id + '" value="0" readonly="readonly">\
                  <input type="hidden" id="' + engt_tpfc1_id + '" name="' + engt_tpfc1_id + '" value="0" readonly="readonly">\
                  <label name="' + no_urut + '">No. (*)</label>\
                  <input type="number" id="' + no_urut + '" name="' + no_urut + '" required class="form-control" placeholder="No." min="1" max="9999" style="text-align:right;" step="1" value="'+value_urut+'">\
                </div>\
                <div class="col-sm-1">\
                  <label name="' + no_op + '">No. OP</label>\
                  <input type="number" id="' + no_op + '" name="' + no_op + '" class="form-control" placeholder="No. OP" min="1" max="9999" style="text-align:right;" step="1" value="'+value_op+'">\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + kd_mesin + '">M/C Code (*)</label>\
                  <div class="input-group">\
                    <input type="text" id="' + kd_mesin + '" name="' + kd_mesin + '" required class="form-control" placeholder="M/C Code" onkeydown="keyPressedMesin(this, event)" onchange="validateMesin(this)" maxlength="20">\
                    <span class="input-group-btn">\
                      <button id="' + btnpopupmesin + '" name="' + btnpopupmesin + '" type="button" class="btn btn-info" onclick="popupMesin(this)" data-toggle="modal" data-target="#mesinModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + nm_proses + '">Machine Type</label>\
                  <input type="text" id="' + nm_proses + '" name="' + nm_proses + '" class="form-control" placeholder="Machine Type" disabled="">\
                </div>\
                <div class="col-sm-4">\
                  <label name="' + nm_mesin + '">Machine Name</label>\
                  <input type="text" id="' + nm_mesin + '" name="' + nm_mesin + '" class="form-control" placeholder="Machine Name" disabled="">\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-4">\
                  <label name="' + engt_msimbol_id + '">Flow Process (*)</label>\
                  <select id="' + engt_msimbol_id + '" name="' + engt_msimbol_id + '" class="form-control select2" required>\
                    <option value="">PILIH FLOW PROCESS</option>\
                    @foreach($engt_msimbols->get() as $engt_msimbol)\
                      <option value="{{$engt_msimbol->id}}">{{$engt_msimbol->ket}}</option>\
                    @endforeach\
                  </select>\
                </div>\
                <div class="col-sm-4">\
                  <label name="' + nm_pros + '">Process Name</label>\
                  <textarea id="' + nm_pros + '" name="' + nm_pros + '" class="form-control" placeholder="Process Name" rows="3" maxlength="300" style="resize:vertical"></textarea>\
                </div>\
                <div class="col-sm-4">\
                  <label name="' + pros_draw_pict + '">Ilustration Process</label>\
                  <input id="' + pros_draw_pict + '" name="' + pros_draw_pict + '" type="file" accept=".jpg,.jpeg,.png">\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-2">\
                  <label name="' + nil_ct + '">CT</label>\
                  <input type="number" id="' + nil_ct + '" name="' + nil_ct + '" class="form-control" placeholder="CT" min="0" max="9999" style="text-align:right;" step="1">\
                </div>\
                <div class="col-sm-2">\
                  <label name="' + st_mesin + '">Machine (*)</label>\
                  <select id="' + st_mesin + '" name="' + st_mesin + '" class="form-control select2" required>\
                    <option value="">PILIH MACHINE</option>\
                    <option value="NO USE">NO USE</option>\
                    <option value="EXISTING">EXISTING</option>\
                    <option value="NEW">NEW</option>\
                  </select>\
                </div>\
                <div class="col-sm-2">\
                  <label name="' + st_tool + '">Tooling (*)</label>\
                  <select id="' + st_tool + '" name="' + st_tool + '" class="form-control select2" required>\
                    <option value="">PILIH TOOLING</option>\
                    <option value="NO USE">NO USE</option>\
                    <option value="EXISTING">EXISTING</option>\
                    <option value="NEW">NEW</option>\
                  </select>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );
    
    $('#kd_line').removeAttr('readonly');
    $('#kd_line').attr('readonly', 'readonly');
    $('#btnpopupline').removeAttr('disabled');
    $('#btnpopupline').attr('disabled', '');
    
    $(".select2").select2();
    validasiSize();
    generateImgSelect2();
    document.getElementById(no_urut).focus();
  });

  function changeId(row) {
    var id_div = "#field_" + row;
    $(id_div).remove();
    var jml_row = document.getElementById("jml_row").value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var engt_tpfc2_id = "#engt_tpfc2_id_" + $i;
      var engt_tpfc2_id_new = "engt_tpfc2_id_" + ($i-1);
      $(engt_tpfc2_id).attr({"id":engt_tpfc2_id_new, "name":engt_tpfc2_id_new});
      var engt_tpfc1_id = "#engt_tpfc1_id_" + $i;
      var engt_tpfc1_id_new = "engt_tpfc1_id_" + ($i-1);
      $(engt_tpfc1_id).attr({"id":engt_tpfc1_id_new, "name":engt_tpfc1_id_new});
      var no_urut = "#no_urut_" + $i;
      var no_urut_new = "no_urut_" + ($i-1);
      $(no_urut).attr({"id":no_urut_new, "name":no_urut_new});
      var no_op = "#no_op_" + $i;
      var no_op_new = "no_op_" + ($i-1);
      $(no_op).attr({"id":no_op_new, "name":no_op_new});
      var kd_mesin = "#kd_mesin_" + $i;
      var kd_mesin_new = "kd_mesin_" + ($i-1);
      $(kd_mesin).attr({"id":kd_mesin_new, "name":kd_mesin_new});
      var nm_proses = "#nm_proses_" + $i;
      var nm_proses_new = "nm_proses_" + ($i-1);
      $(nm_proses).attr({"id":nm_proses_new, "name":nm_proses_new});
      var nm_mesin = "#nm_mesin_" + $i;
      var nm_mesin_new = "nm_mesin_" + ($i-1);
      $(nm_mesin).attr({"id":nm_mesin_new, "name":nm_mesin_new});
      var engt_msimbol_id = "#engt_msimbol_id_" + $i;
      var engt_msimbol_id_new = "engt_msimbol_id_" + ($i-1);
      $(engt_msimbol_id).attr({"id":engt_msimbol_id_new, "name":engt_msimbol_id_new});
      var nm_pros = "#nm_pros_" + $i;
      var nm_pros_new = "nm_pros_" + ($i-1);
      $(nm_pros).attr({"id":nm_pros_new, "name":nm_pros_new});
      var pros_draw_pict = "#pros_draw_pict_" + $i;
      var pros_draw_pict_new = "pros_draw_pict_" + ($i-1);
      $(pros_draw_pict).attr({"id":pros_draw_pict_new, "name":pros_draw_pict_new});
      var nil_ct = "#nil_ct_" + $i;
      var nil_ct_new = "nil_ct_" + ($i-1);
      $(nil_ct).attr({"id":nil_ct_new, "name":nil_ct_new});
      var st_mesin = "#st_mesin_" + $i;
      var st_mesin_new = "st_mesin_" + ($i-1);
      $(st_mesin).attr({"id":st_mesin_new, "name":st_mesin_new});
      var st_tool = "#st_tool_" + $i;
      var st_tool_new = "st_tool_" + ($i-1);
      $(st_tool).attr({"id":st_tool_new, "name":st_tool_new});
      var btndelete = "#btndelete_" + $i;
      var btndelete_new = "btndelete_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var id_field = "#field_" + $i;
      var id_field_new = "field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_" + $i;
      var id_box_new = "box_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btnpopupmesin = "#btnpopupmesin_" + $i;
      var btnpopupmesin_new = "btnpopupmesin_" + ($i-1);
      $(btnpopupmesin).attr({"id":btnpopupmesin_new, "name":btnpopupmesin_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row").value = jml_row;

    if(jml_row < 1) {
      $('#kd_line').removeAttr('readonly');
      $('#btnpopupline').removeAttr('disabled');
    }
  }

  function deleteDetail(ths) {
    var msg = 'Anda yakin menghapus Data Detail ini?';
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
      var engt_tpfc2_id = document.getElementById("engt_tpfc2_id_" + row).value.trim();
      if(engt_tpfc2_id === "" || engt_tpfc2_id === "0") {
        changeId(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('engttpfc1s.deletedetail', 'param') }}";
        url = url.replace('param', engt_tpfc2_id);
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