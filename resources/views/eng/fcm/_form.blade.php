{!! Form::hidden('st_submit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_submit']) !!}
{!! Form::hidden('engt_tpfc2_id', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'engt_tpfc2_id']) !!}
<div class="box-body" id="field-fcm1">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('reg_no_doc') ? ' has-error' : '' }}">
      {!! Form::label('reg_no_doc', 'Registrasi Doc') !!}
      {!! Form::text('reg_no_doc', null, ['class'=>'form-control','placeholder' => 'Registrasi Doc', 'disabled'=>'', 'id' => 'reg_no_doc']) !!}
      {!! $errors->first('reg_no_doc', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('') ? ' has-error' : '' }}">
      {!! Form::label('no_op', 'No. OP') !!}
      {!! Form::text('no_op', null, ['class'=>'form-control','placeholder' => 'No. OP', 'disabled'=>'', 'id' => 'no_op']) !!}
      {!! $errors->first('no_op', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('') ? ' has-error' : '' }}">
      {!! Form::label('kd_mesin', 'M/C Code # Type # Name') !!}
      {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'M/C Code # Type # Name', 'disabled'=>'', 'id' => 'kd_mesin']) !!}
      {!! $errors->first('kd_mesin', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-5 {{ $errors->has('pict_dim_position') ? ' has-error' : '' }}">
      {!! Form::label('pict_dim_position', 'Dimension Position (jpeg,png,jpg)') !!}
      {!! Form::file('pict_dim_position', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
      {!! $errors->first('pict_dim_position', '<p class="help-block">:message</p>') !!}
    </div>
    @if (!empty($engtfcm1->pict_dim_position))
      <div class="col-sm-7">
        <div class="box box-primary {{ $engtfcm1->pict_dim_position != null ? 'collapsed-box' : ''}}">
          <div class="box-header with-border">
            <h3 class="box-title" id="boxtitle">Dimension Position</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button id="btndeletefile" name="btndeletefile" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus File Dimension Position" onclick="deleteFile()">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row form-group">
              <div class="col-sm-12">
                <p>
                  <img src="{{ $engtfcm1->pict($engtfcm1->pict_dim_position) }}" alt="File Not Found" class="img-rounded img-responsive">
                </p>
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- ./box-body -->
        </div>
        <!-- /.box -->
      </div>
    @endif
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-body" id="field-detail-fcm2">
  @foreach ($engtfcm1->engtFcm2s()->orderBy("no_urut")->get() as $model)
    <div class="row" id="fieldfcm2_{{ $loop->iteration }}">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title" id="boxfcm2_{{ $loop->iteration }}">Data Ke-{{ $loop->iteration }}</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
              <button id="btndeletefcm2_{{ $loop->iteration }}" name="btndeletefcm2_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="deleteFcm2(this)">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row form-group">
              <div class="col-sm-1">
                <input type="hidden" id="engt_fcm2_id_{{ $loop->iteration }}" name="engt_fcm2_id_{{ $loop->iteration }}" value="{{ base64_encode($model->id) }}" readonly="readonly">
                <input type="hidden" id="engt_fcm1_id_{{ $loop->iteration }}" name="engt_fcm1_id_{{ $loop->iteration }}" value="{{ base64_encode($model->engt_fcm1_id) }}" readonly="readonly">
                <label name="no_urut_{{ $loop->iteration }}">No. (*)</label>
                <input type="number" id="no_urut_{{ $loop->iteration }}" name="no_urut_{{ $loop->iteration }}" required class="form-control" placeholder="No." min="1" max="9999" style="text-align:right;" step="1" value="{{ $model->no_urut }}">
              </div>
              <div class="col-sm-3">
                <label name="dim_st_{{ $loop->iteration }}">Dimension Status</label>
                {!! Form::select('dim_st_'.$loop->iteration, ['GEOMETRY' => 'GEOMETRY', 'LINEAR' => 'LINEAR', 'VISUAL' => 'VISUAL'], $model->dim_st, ['class'=>'form-control select2', 'id' => 'dim_st_'.$loop->iteration, 'placeholder' => 'Pilih Dimension Status']) !!}
              </div>
              <div class="col-sm-5">
                <label name="pros_req_{{ $loop->iteration }}">Process Requirement</label>
                <input type="text" id="pros_req_{{ $loop->iteration }}" name="pros_req_{{ $loop->iteration }}" class="form-control" placeholder="Process Requirement" maxlength="50" value="{{ $model->pros_req }}">
              </div>
              <div class="col-sm-3">
                <label name="std_{{ $loop->iteration }}">Standard</label>
                <input type="text" id="std_{{ $loop->iteration }}" name="std_{{ $loop->iteration }}" class="form-control" placeholder="Standard" maxlength="30" value="{{ $model->std }}">
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.box-body -->
          <div class="box-body">
            <p class="pull-right">
              <button id="btnaddfcm2_{{ $loop->iteration }}" name="btnaddfcm2_{{ $loop->iteration }}" type="button" class="btn btn-success" onclick="addFcm3(this)"><span class="glyphicon glyphicon-plus"></span> Detail Data Ke-{{ $loop->iteration }}</button>
              <button id="btnaddfcm2_popup_{{ $loop->iteration }}" name="btnaddfcm2_popup_{{ $loop->iteration }}" type="button" class="btn btn-success" data-toggle="modal" data-target="#fcm3Modal" onclick="popupFcm3(this)" style="display: none;"></button>
            </p>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  @endforeach
  {!! Form::hidden('jml_row_fcm2', $engtfcm1->engtFcm2s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_fcm2']) !!}
</div>

<!-- /.box-body -->
<div class="box-body">
  <p class="pull-right">
    <button id="addRow2" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Data"><span class="glyphicon glyphicon-plus"></span> Add Data</button>
  </p>
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save FCM', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('engtfcm1s.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<div class="box-body" id="field-fcm3">
  <!-- Modal FCM3 -->
  @include('eng.fcm.popup.fcm3Modal')
</div>

@section('scripts')
<script type="text/javascript">

  // document.getElementById("reg_no_doc").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("input[name^='pict_dim_position']").bind('change', function() {
    let filesize = this.files[0].size // On older browsers this can return NULL.
    let filesizeMB = (filesize / (1024*1024)).toFixed(2);
    if(filesizeMB > 8) {
      var info = "Size File tidak boleh > 8 MB";
      swal(info, "Perhatikan inputan anda!", "warning");
      this.value = null;
    }
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

  function deleteFile() {
    var msg = 'Anda yakin menghapus File Dimension Position?';
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
      var id = "{{ $engtfcm1->id }}";
      var urlRedirect = "{{ route('engtfcm1s.deletefile', 'param') }}";
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
  }

  $("#addRow2").click(function(){
    var id_row = "jml_row_fcm2";
    var jml_row = document.getElementById(id_row).value.trim();
    jml_row = Number(jml_row) + 1;

    var engt_fcm2_id = 'engt_fcm2_id_'+jml_row;
    var engt_fcm1_id = 'engt_fcm1_id_'+jml_row;
    var no_urut = 'no_urut_'+jml_row;
    var dim_st = 'dim_st_'+jml_row;
    var pros_req = 'pros_req_'+jml_row;
    var std = 'std_'+jml_row;
    var btndelete = 'btndeletefcm2_'+jml_row;
    var id_field = 'fieldfcm2_'+jml_row;
    var id_box = 'boxfcm2_'+jml_row;

    var value_urut = 0;
    for($i = 1; $i < jml_row; $i++) {
      var value_urut_temp = document.getElementById("no_urut_" + $i).value;
      if(value_urut_temp != "") {
        value_urut_temp = Number(value_urut_temp);
        if(value_urut_temp > value_urut) {
          value_urut = value_urut_temp;
        }
      }
    }

    value_urut = value_urut + 10;

    $("#field-detail-fcm2").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Data Ke-'+ jml_row +'</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="deleteFcm2(this)">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-1">\
                  <input type="hidden" id="' + engt_fcm2_id + '" name="' + engt_fcm2_id + '" value="0" readonly="readonly">\
                  <input type="hidden" id="' + engt_fcm1_id + '" name="' + engt_fcm1_id + '" value="0" readonly="readonly">\
                  <label name="' + no_urut + '">No. (*)</label>\
                  <input type="number" id="' + no_urut + '" name="' + no_urut + '" required class="form-control" placeholder="No." min="1" max="9999" style="text-align:right;" step="1" value="'+value_urut+'">\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + dim_st + '">Dimension Status</label>\
                  <select id="' + dim_st + '" name="' + dim_st + '" class="form-control select2">\
                    <option value="">Pilih Dimension Status</option>\
                    <option value="GEOMETRY">GEOMETRY</option>\
                    <option value="LINEAR">LINEAR</option>\
                    <option value="VISUAL">VISUAL</option>\
                  </select>\
                </div>\
                <div class="col-sm-5">\
                  <label name="' + pros_req + '">Process Requirement</label>\
                  <input type="text" id="' + pros_req + '" name="' + pros_req + '" class="form-control" placeholder="Process Requirement" maxlength="50">\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + std + '">Standard</label>\
                  <input type="text" id="' + std + '" name="' + std + '" class="form-control" placeholder="Standard" maxlength="30">\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    document.getElementById(id_row).value = jml_row;
    $(".select2").select2();
    document.getElementById(no_urut).focus();
  });

  function changeIdFcm2(row) {

    var id_div = "#fieldfcm2_" + row;
    $(id_div).remove();

    var id_row = "jml_row_fcm2";
    var jml_row = document.getElementById(id_row).value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;

    for($i = nextRow; $i <= jml_row; $i++) {

      var engt_fcm2_id = "#engt_fcm2_id_" + $i;
      var engt_fcm2_id_new = "engt_fcm2_id_" + ($i-1);
      $(engt_fcm2_id).attr({"id":engt_fcm2_id_new, "name":engt_fcm2_id_new});
      var engt_fcm1_id = "#engt_fcm1_id_" + $i;
      var engt_fcm1_id_new = "engt_fcm1_id_" + ($i-1);
      $(engt_fcm1_id).attr({"id":engt_fcm1_id_new, "name":engt_fcm1_id_new});
      var no_urut = "#no_urut_" + $i;
      var no_urut_new = "no_urut_" + ($i-1);
      $(no_urut).attr({"id":no_urut_new, "name":no_urut_new});
      var dim_st = "#dim_st_" + $i;
      var dim_st_new = "dim_st_" + ($i-1);
      $(dim_st).attr({"id":dim_st_new, "name":dim_st_new});
      var pros_req = "#pros_req_" + $i;
      var pros_req_new = "pros_req_" + ($i-1);
      $(pros_req).attr({"id":pros_req_new, "name":pros_req_new});
      var std = "#std_" + $i;
      var std_new = "std_" + ($i-1);
      $(std).attr({"id":std_new, "name":std_new});
      var btndelete = "#btndeletefcm2_" + $i;
      var btndelete_new = "btndeletefcm2_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});

      var engt_fcm2_id = document.getElementById(engt_fcm2_id_new).value.trim();
      if(engt_fcm2_id !== "" && engt_fcm2_id !== "0") {
        var btnadd = "#btnaddfcm2_" + $i;
        var btnadd_new = "btnaddfcm2_" + ($i-1);
        $(btnadd).attr({"id":btnadd_new, "name":btnadd_new});
        var textAdd = document.getElementById(btnadd_new).innerHTML;
        textAdd = textAdd.replace($i, ($i-1));
        document.getElementById(btnadd_new).innerHTML = textAdd;
        var btnaddpopup = "#btnaddfcm2_popup_" + $i;
        var btnaddpopup_new = "btnaddfcm2_popup_" + ($i-1);
        $(btnaddpopup).attr({"id":btnaddpopup_new, "name":btnaddpopup_new});
      }

      var id_field = "#fieldfcm2_" + $i;
      var id_field_new = "fieldfcm2_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#boxfcm2_" + $i;
      var id_box_new = "boxfcm2_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById(id_row).value = jml_row;
  }

  function deleteFcm2(ths) {
    var msg = 'Anda yakin menghapus Data ini?';
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
      var row = ths.id.replace('btndeletefcm2_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var engt_fcm2_id = document.getElementById("engt_fcm2_id_" + row).value.trim();
      if(engt_fcm2_id === "" || engt_fcm2_id === "0") {
        changeIdFcm2(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('engtfcm1s.deletefcm2', 'param') }}";
        url = url.replace('param', engt_fcm2_id);
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
              changeIdFcm2(row);
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

  function addFcm3(ths) {
    var row = ths.id.replace('btnaddfcm2_', '');
    var engt_tpfc2_id = document.getElementById("engt_tpfc2_id").value.trim();
    var engt_fcm2_id = document.getElementById("engt_fcm2_id_" + row).value.trim();
    var btnaddpopup = "#btnaddfcm2_popup_" + row;
    $(btnaddpopup).click();
  }

  function popupFcm3(ths) {
    var row = ths.id.replace('btnaddfcm2_popup_', '');
    var engt_tpfc2_id = document.getElementById("engt_tpfc2_id").value.trim();
    var engt_fcm2_id = document.getElementById("engt_fcm2_id_" + row).value.trim();
    var no_urut = document.getElementById("no_urut_" + row).value.trim();

    var myHeading = "<p>FCM 3 (No. Urut: " + no_urut + ")</p>";
    $("#fcm3ModalLabel").html(myHeading);
    $('#engt_fcm2_id').attr('value', engt_fcm2_id);
    
    if(engt_fcm2_id === "" || engt_fcm2_id == null) {
      engt_fcm2_id = window.btoa("0");
    } 
    var tableDetail = $('#tblDetail').DataTable();
    var url = '{{ route('engtfcm1s.dashboardfcm3', 'param') }}';
    url = url.replace('param', engt_fcm2_id);
    tableDetail.ajax.url(url).load( function ( json ) {
      for($i = 1; $i <= 5; $i++) {
        addTdFcm3(row);
      }
      document.getElementById("fcm3_tolerance_1").focus();
    });

    $('#fcm3Modal').on('hidden.bs.modal', function () {
      
    });
  }

  function addTdFcm3(row) {
    var table = $('#tblDetail').DataTable();
    counter = table.rows().count();
    counter++;

    var engt_fcm2_id = document.getElementById("engt_fcm2_id_" + row).value.trim();

    var engt_fcm3_id = 'engt_fcm3_id_' + counter;
    var engt_fcm3_fcm2_id = 'engt_fcm3_fcm2_id_' + counter;
    var fcm3_tolerance = 'fcm3_tolerance_' + counter;
    var fcm3_dim_note_st = 'fcm3_dim_note_st_' + counter;
    var btndeletefcm3 = 'btndeletefcm3_' + counter;

    var data = [];
    data['tolerance'] = "<input type='hidden' id='"+engt_fcm3_id+"' name='"+engt_fcm3_id+"' value='0' readonly='readonly'><input type='hidden' id='"+engt_fcm3_fcm2_id+"' name='"+engt_fcm3_fcm2_id+"' value='"+engt_fcm2_id+"' readonly='readonly'><input type='text' id='"+fcm3_tolerance+"' name='"+fcm3_tolerance+"' maxlength='50' class='form-control' size='40'>";
    data['dim_note_st'] = "<input type='text' id='"+fcm3_dim_note_st+"' name='"+fcm3_dim_note_st+"' maxlength='50' class='form-control' size='40'>";
    @for ($i = 1; $i <= $engttpfc2s->orderBy("no_op")->get()->count(); $i++)
      var st_pros = 'fcm3_st_pros_{{ $i }}_' + counter;
      data['st_pros_{{ $i }}'] = "<input type='text' id='"+st_pros+"' name='"+st_pros+"' maxlength='1' class='form-control' size='1'>";
    @endfor
    data['action'] = "<center><button id='"+btndeletefcm3+"' name='"+btndeletefcm3+"' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Hapus Data' onclick='deleteFcm3(this)'><span class='glyphicon glyphicon-remove'></span></button></center>";

    table.row.add(data).draw(false);
    document.getElementById("jml_row_fcm3").value = counter;
    document.getElementById("jml_st_pros").value = {{ $engttpfc2s->orderBy("no_op")->get()->count() }};
  }

  $(document).ready(function(){
    var url = '{{ route('engtfcm1s.dashboardfcm3', 'param') }}';
    url = url.replace('param', window.btoa("0"));
    var tblDetail = $('#tblDetail').DataTable({
      "searching": false,
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
      serverSide: true,
      ajax: url, 
      columns: [
        {data: 'tolerance', name: 'tolerance', orderable: false, searchable: false},
        {data: 'dim_note_st', name: 'dim_note_st', orderable: false, searchable: false},
        @for ($i = 1; $i <= $engttpfc2s->orderBy("no_op")->get()->count(); $i++)
          {data: 'st_pros_{{ $i }}', name: 'st_pros_{{ $i }}', orderable: false, searchable: false},
        @endfor
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ], 
    });
  });

  $("#btn-simpan-fcm3").click(function(event) {
    event.preventDefault();
    
    var table = $('#tblDetail').DataTable();
    counter = table.rows().count();
    document.getElementById("jml_row_fcm3").value = counter;
    document.getElementById("jml_st_pros").value = {{ $engttpfc2s->orderBy("no_op")->get()->count() }};
    document.getElementById("st_submit").value = "FCM3";

    // Serialize the entire form:
    var data = new FormData(this.form);

    var msg = "Anda yakin simpan data ini?";
    var txt = "";
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, save it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      $.ajax({
      type: "post",
      url: "{{ route('engtfcm1s.update', base64_encode($engtfcm1->id)) }}",
      // dataType: "json",
      data: data,
      processData: false,
      contentType: false,
      success: function(data){
        if(data.status === 'OK'){
          info = "Saved!";
          info2 = data.message;
          info3 = "success";
          swal(info, info2, info3);
          $('#fcm3Modal').modal('hide');
        } else {
          info = "ERROR";
          info2 = data.message;
          info3 = "error";
          swal(info, info2, info3);
        }
      }, error: function(data){
        info = "System Error!";
        info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
        info3 = "error";
        swal(info, info2, info3);
      }
    });
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

  function deleteFcm3(ths) {
    var msg = 'Anda yakin menghapus Data ini?';
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
      var row = ths.id.replace('btndeletefcm3_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var engt_fcm3_id = document.getElementById("engt_fcm3_id_" + row).value.trim();
      if(engt_fcm3_id === "" || engt_fcm3_id === "0") {
        document.getElementById("fcm3_tolerance_" + row).value = null;
        document.getElementById("fcm3_dim_note_st_" + row).value = null;
        @for ($i = 1; $i <= $engttpfc2s->orderBy("no_op")->get()->count(); $i++)
          var st_pros = 'fcm3_st_pros_{{ $i }}_' + row;
          document.getElementById(st_pros).value = null;
        @endfor
        document.getElementById("fcm3_tolerance_" + row).focus();
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('engtfcm1s.deletefcm3', 'param') }}";
        url = url.replace('param', engt_fcm3_id);
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
              document.getElementById("engt_fcm3_id_" + row).value = "0";
              document.getElementById("fcm3_tolerance_" + row).value = null;
              document.getElementById("fcm3_dim_note_st_" + row).value = null;
              @for ($i = 1; $i <= $engttpfc2s->orderBy("no_op")->get()->count(); $i++)
              var st_pros = 'fcm3_st_pros_{{ $i }}_' + row;
              document.getElementById(st_pros).value = null;
              @endfor
              document.getElementById("fcm3_tolerance_" + row).focus();
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