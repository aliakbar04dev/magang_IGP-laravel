<div class="box-body" id="field-part">
  <div class="row">    
    <div class="col-md-12">  
  <!-- /.form-group -->
      <div class="form-group">
        <div class="col-sm-8 {{ $errors->has('kd_model') ? ' has-error' : '' }}">
          {!! Form::label('kd_model', 'Model Name (F9) (*)') !!}
          <div class="input-group">
            @if (empty($engtmdlline->kd_model))
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
        <div class="col-sm-1">
          {!! Form::label('addLine', 'Add Line') !!}
          <button id="addLine" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Line"><span class="glyphicon glyphicon-plus"></span> Add Line</button>
        </div>
      </div>

      

      <!-- ./form-group -->
      <div class="form-group {{ $errors->has('st_aktif') ? ' has-error' : '' }}"> 
        <div class="col-md-4">         
          {!! Form::label('st_aktif', 'Status Aktif (*)') !!}
          {!! Form::select('st_aktif', ['T' => 'Aktif', 'F' => 'Non Aktif'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'id' => 'st_aktif', 'required']) !!}
          {!! $errors->first('st_aktif', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      @if (!empty($engtmdlline->kd_model))
        @foreach ($entity->getLines($engtmdlline->kd_model)->get() as $model)
          <div class="form-group" id="line_field_{{ $loop->iteration }}">
            <div class="col-sm-3">
              <label name="kd_line_label_{{ $loop->iteration }}" id="kd_line_label_{{ $loop->iteration }}">Line Ke-{{ $loop->iteration }}</label>
              <div class="input-group">
                <input type="text" id="kd_line_{{ $loop->iteration }}" name="kd_line_{{ $loop->iteration }}" required class="form-control" placeholder="Line " onkeydown="keyPressedKdLine(this, event)" onchange="validateKdLine(this)" maxlength="40" value="{{ $model->kd_line }}" readonly="true">
                <span class="input-group-btn">
                  <button id="line_btnpopupline_{{ $loop->iteration }}" name="line_btnpopupline_{{ $loop->iteration }}" type="button" class="btn btn-info" onclick="popupKdLine(this)" data-toggle="modal" data-target="#lineModal" disabled="">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-5">
              <label name="nm_line_label_{{ $loop->iteration }}" id="nm_line_label_{{ $loop->iteration }}">Nama Line Ke-{{ $loop->iteration }}</label>
              <input type="text" id="nm_line_{{ $loop->iteration }}" name="nm_line_{{ $loop->iteration }}" class="form-control" placeholder="Nama Line" disabled="" value="{{ $model->nm_line }}">
            </div>
            <div class="col-sm-1">
              <label name="line_btndelete_label_{{ $loop->iteration }}" id="line_btndelete_label_{{ $loop->iteration }}">Remove</label>
              <button id="line_btndelete_{{ $loop->iteration }}" name="line_btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
        @endforeach
        {!! Form::hidden('jml_line', $entity->getLines($engtmdlline->kd_model)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_line']) !!}
      @else
        {!! Form::hidden('jml_line', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_line']) !!}
      @endif
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.row -->
</div>

<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($engtmdlline->kd_model))
  <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('engtmdllines.index') }}">Cancel</a>
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@include('eng.master.mdlline.popup.lineModal')
@include('eng.master.mdlline.popup.modelModal')
@section('scripts')
<script type="text/javascript">
  document.getElementById("kd_model").focus();

  //Initialize Select2 Elements
  $(".select2").select2();


  $("#addLine").click(function(){
    var jml_line = document.getElementById("jml_line").value.trim();
    jml_line = Number(jml_line) + 1;
    document.getElementById("jml_line").value = jml_line;
    var kd_line = 'kd_line_'+jml_line;
    var kd_line_label = 'kd_line_label_'+jml_line;
    var nm_line = 'nm_line_'+jml_line;
    var nm_line_label = 'nm_line_label_'+jml_line;
    var btndelete = 'line_btndelete_'+jml_line;
    var btndelete_label = 'line_btndelete_label_'+jml_line;
    var btnpopupline = 'line_btnpopupline_'+jml_line;
    var id_field = 'line_field_'+jml_line;

    $("#field-part").append(
      '<div class="form-group" id="'+id_field+'">\
          <div class="col-sm-3">\
            <label name="' + kd_line_label + '" id="' + kd_line_label + '">Line Ke-'+ jml_line +'</label>\
            <div class="input-group">\
              <input type="text" id="' + kd_line + '" name="' + kd_line + '" required class="form-control" placeholder="Line" onkeydown="keyPressedKdLine(this, event)" onchange="validateKdLine(this)" maxlength="40">\
              <span class="input-group-btn">\
                <button id="' + btnpopupline + '" name="' + btnpopupline + '" type="button" class="btn btn-info" onclick="popupKdLine(this)" data-toggle="modal" data-target="#lineModal">\
                  <span class="glyphicon glyphicon-search"></span>\
                </button>\
              </span>\
            </div>\
          </div>\
          <div class="col-sm-5">\
            <label name="' + nm_line_label + '" id="' + nm_line_label + '">Nama Line Ke-'+ jml_line +'</label>\
            <input type="text" id="' + nm_line + '" name="' + nm_line + '" class="form-control" placeholder="Nama Line" disabled="">\
          </div>\
          <div class="col-sm-1">\
            <label name="' + btndelete_label + '" id="' + btndelete_label + '">Remove</label>\
            <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" onclick="deleteLine(this)">\
              <i class="fa fa-times"></i>\
            </button>\
          </div>\
      </div>'
    );

    document.getElementById(kd_line).focus();
  });



  $("#btn-delete").click(function(){
    var kd_model = document.getElementById("kd_model").value.trim();
    var msg = 'Anda yakin menghapus model: ' + kd_model + '?';
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
      var urlRedirect = "{{ route('engtmdllines.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(kd_model));
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

  function keyPressedKdModel(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupmodel').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('st_aktif').focus();
    }
  }

  function keyPressedKdLine(ths, e) {
    if(e.keyCode == 120) { //F9
      var row = ths.id.replace('kd_line_', '');
      var id_btn = "#line_btnpopupline_" + row;
      $(id_btn).click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("st_aktif").focus();
    }
  }

  $(document).ready(function(){

    $("#btnpopupmodel").click(function(){
      popupKdModel();
    });

    var kode = document.getElementById("kd_model").value.trim();     
    if(kode !== '') {
      validateKdModel();
    }
  });

  function popupKdModel() {
    var myHeading = "<p>Popup Model</p>";
    $("#modelModalLabel").html(myHeading);
    var kd_cust = "-";
    var url = '{{ route('datatables.popupEngtMmodelsMst', 'param') }}';
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
            $('#kd_model').focus();
          } 
        });
      },
    });
  }

  function validateKdModel() {
    var kd_model = document.getElementById("kd_model").value.trim();
    if(kd_model !== '') {
      var url = '{{ route('datatables.validasiEngtMmodelMst', 'param') }}';
      url = url.replace('param', window.btoa(kd_model));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_model").value = result["kd_model"];
        } else {
          document.getElementById("kd_model").value = "";
          document.getElementById("kd_model").focus();
          swal("Model Name tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_model").value = "";
    }
  }


  function popupKdLine(ths) {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupEngtMlinesMst') }}';
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
            var row = ths.id.replace('line_btnpopupline_', '');
            var id_kd_line = "kd_line_" + row;
            var id_nm_line = "nm_line_" + row;
            document.getElementById(id_kd_line).value = value["kd_line"];
            document.getElementById(id_nm_line).value = value["nm_line"];
            $('#lineModal').modal('hide');
            compareKdLine(row);
          });
        });
        $('#lineModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('line_btnpopupline_', '');
          var id_kd_line = "kd_line_" + row;
          var id_nm_line = "nm_line_" + row;
          var kd_line = document.getElementById(id_kd_line).value.trim();
          if(kd_line === '') {
            document.getElementById(id_kd_line).value = "";
            document.getElementById(id_nm_line).value = "";
            document.getElementById(id_kd_line).focus();
          } else {
            document.getElementById("st_aktif").focus();
          }
        });
      },
    });
  }

  function compareKdLine(row){
    var id_kd_line = "kd_line_" + row;
    var id_nm_line = "nm_line_" + row;
    var kd_line = document.getElementById(id_kd_line).value.trim();
    var jml_line = document.getElementById('jml_line').value.trim();
    for (i = 1 ; i <= jml_line ; i++) {
      if (i != row) {
        var kd_line_check = "kd_line_" + i;
        var kd_line_checked = document.getElementById(kd_line_check).value.trim();
        if (kd_line === kd_line_checked && kd_line_checked != '' ){
          document.getElementById(id_kd_line).value = "";
          document.getElementById(id_nm_line).value = "";
          document.getElementById(id_kd_line).focus();
          swal("Line tidak valid!", "Line sudah terdaftar di line ke-"+i+".", "error");
        }
      }
    }
  }


  function validateKdLine(ths) {
    var row = ths.id.replace('kd_line_', '');
    compareKdLine(row);
    var id_kd_line = "kd_line_" + row;
    var id_nm_line = "nm_line_" + row;
    var kd_line = document.getElementById(id_kd_line).value.trim();
    if(kd_line !== '') {
      var url = '{{ route('datatables.validasiEngtMlineMst', 'param') }}';
      url = url.replace('param', window.btoa(kd_line));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById(id_kd_line).value = result["kd_line"];
          document.getElementById(id_nm_line).value = result["nm_line"];
        } else {
          document.getElementById(id_kd_line).value = "";
          document.getElementById(id_nm_line).value = "";
          document.getElementById(id_kd_line).focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById(id_kd_line).value = "";
      document.getElementById(id_nm_line).value = "";
    }
  }

  function deleteLine(ths) {
    var msg = 'Anda yakin menghapus Kode Line ini?';
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
      var row = ths.id.replace('line_btndelete_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var kd_line = document.getElementById("kd_line_" + row).value.trim();
      var kd_model = document.getElementById("kd_model").value.trim();
      if(kd_line === "" || kd_line === "0" || kd_model === "" || kd_model === "0") {
        changeKdLine(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = '{{ route('engtmdllines.deleteLine', ['param','param2']) }}';
        url = url.replace('param', window.btoa(kd_model));
        url = url.replace('param2', window.btoa(kd_line));
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method : 'DELETE',
            _token  : token
          },
          success:function(data){
            if(data.status === 'OK'){
              changeKdLine(row);
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

  function changeKdLine(row) {
    var id_field = "#line_field_" + row;
    $(id_field).remove();

    var jml_line = document.getElementById("jml_line").value.trim();
    jml_line = Number(jml_line);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_line; $i++) {
      var kd_line = '#kd_line_' + $i;
      var kd_line_new = 'kd_line_' + ($i-1);
      $(kd_line).attr({"id":kd_line_new, "name":kd_line_new});
      var kd_line_label = '#kd_line_label_' + $i;
      var kd_line_label_new = 'kd_line_label_' + ($i-1);
      $(kd_line_label).attr({"id":kd_line_label_new, "name":kd_line_label_new});
      var nm_line = '#nm_line_' + $i;
      var nm_line_new = 'nm_line_' + ($i-1);
      $(nm_line).attr({"id":nm_line_new, "name":nm_line_new});
      var nm_line_label = '#nm_line_label_' + $i;
      var nm_line_label_new = 'nm_line_label_' + ($i-1);
      $(nm_line_label).attr({"id":nm_line_label_new, "name":nm_line_label_new});
      var btndelete = '#line_btndelete_' + $i;
      var btndelete_new = 'line_btndelete_' + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var btndelete_label = '#line_btndelete_label_' + $i;
      var btndelete_label_new = 'line_btndelete_label_' + ($i-1);
      $(btndelete_label).attr({"id":btndelete_label_new, "name":btndelete_label_new});
      var btnpopupline = '#line_btnpopupline_' + $i;
      var btnpopupline_new = 'line_btnpopupline_' + ($i-1);
      $(btnpopupline).attr({"id":btnpopupline_new, "name":btnpopupline_new});
      var id_field = "#line_field_" + $i;
      var id_field_new = "line_field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});

      var text = document.getElementById(kd_line_label_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(kd_line_label_new).innerHTML = text;
      text = document.getElementById(nm_line_label_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(nm_line_label_new).innerHTML = text;
    }
    jml_line = jml_line - 1;
    document.getElementById("jml_line").value = jml_line;

  }
</script>
@endsection
