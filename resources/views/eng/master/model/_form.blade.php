<div class="box-body" id="field-part">
  <div class="row">    
    <div class="col-md-12">  
      <div class="form-group {{ $errors->has('kd_model') ? ' has-error' : '' }}">
        <div class="col-md-4"> 
          {!! Form::label('kd_model', 'Kode Model (*)') !!}
        @if (empty($cekFk)) 
          {!! Form::text('kd_model', null, ['class'=>'form-control', 'placeholder' => 'Kode Model', 'maxlength' => '40', 'required']) !!} 
        @else
          {!! Form::text('kd_model', null, ['class'=>'form-control', 'placeholder' => 'Kode Model', 'maxlength' => '40', 'required', 'readonly']) !!}
        @endif  
          {!! $errors->first('kd_model', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2">
          {!! Form::label('addCust', 'Add Cust') !!}
          <button id="addCust" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Customer"><span class="glyphicon glyphicon-plus"></span> Add Customer</button>
        </div>
      </div>
      <div class="form-group {{ $errors->has('st_aktif') ? ' has-error' : '' }}"> 
        <div class="col-md-4">         
          {!! Form::label('st_aktif', 'Status Aktif (*)') !!}
          {!! Form::select('st_aktif', ['T' => 'Aktif', 'F' => 'Non Aktif'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'id' => 'st_aktif', 'required']) !!}
          {!! $errors->first('st_aktif', '<p class="help-block">:message</p>') !!}
        </div>
      </div>


      @if (!empty($engtmmodels->kd_model))
        @foreach ($entity->getCusts($engtmmodels->kd_model)->get() as $model)
          <div class="form-group" id="cust_field_{{ $loop->iteration }}">
            <div class="col-sm-3">
              <label name="kd_cust_label_{{ $loop->iteration }}" id="kd_cust_label_{{ $loop->iteration }}">Customer Ke-{{ $loop->iteration }}</label>
              <div class="input-group">
                <input type="text" id="kd_cust_{{ $loop->iteration }}" name="kd_cust_{{ $loop->iteration }}" required class="form-control" placeholder="Customer " onkeydown="keyPressedKdCust(this, event)" onchange="validateKdCust(this)" maxlength="40" value="{{ $model->kd_cust }}" readonly="true">
                <span class="input-group-btn">
                  <button id="cust_btnpopupcust_{{ $loop->iteration }}" name="cust_btnpopupcust_{{ $loop->iteration }}" type="button" class="btn btn-info" onclick="popupKdCust(this)" data-toggle="modal" data-target="#customerModal" disabled="">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-5">
              <label name="nm_cust_label_{{ $loop->iteration }}" id="nm_cust_label_{{ $loop->iteration }}">Nama Customer Ke-{{ $loop->iteration }}</label>
              <input type="text" id="nm_cust_{{ $loop->iteration }}" name="nm_cust_{{ $loop->iteration }}" class="form-control" placeholder="Nama Cust" disabled="" value="{{ $model->nm_cust }}">
            </div>
            <div class="col-sm-1">
              <label name="cust_btndelete_label_{{ $loop->iteration }}" id="cust_btndelete_label_{{ $loop->iteration }}">Remove</label>
              <button id="cust_btndelete_{{ $loop->iteration }}" name="cust_btndelete_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" onclick="deleteCust(this)">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
        @endforeach
        {!! Form::hidden('jml_cust', $entity->getCusts($engtmmodels->kd_model)->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_cust']) !!}
      @else
        {!! Form::hidden('jml_cust', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_cust']) !!}
      @endif
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.row -->
</div>

<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($engtmmodels->kd_model))
  <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('engtmmodels.index') }}">Cancel</a>
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@include('eng.pfc.popup.customerModal')
@section('scripts')
<script type="text/javascript">
  document.getElementById("kd_model").focus();

  //Initialize Select2 Elements
  $(".select2").select2();



  $("#addCust").click(function(){
    var jml_cust = document.getElementById("jml_cust").value.trim();
    jml_cust = Number(jml_cust) + 1;
    document.getElementById("jml_cust").value = jml_cust;
    var kd_cust = 'kd_cust_'+jml_cust;
    var kd_cust_label = 'kd_cust_label_'+jml_cust;
    var nm_cust = 'nm_cust_'+jml_cust;
    var nm_cust_label = 'nm_cust_label_'+jml_cust;
    var btndelete = 'cust_btndelete_'+jml_cust;
    var btndelete_label = 'cust_btndelete_label_'+jml_cust;
    var btnpopupcust = 'cust_btnpopupcust_'+jml_cust;
    var id_field = 'cust_field_'+jml_cust;

    $("#field-part").append(
      '<div class="form-group" id="'+id_field+'">\
          <div class="col-sm-3">\
            <label name="' + kd_cust_label + '" id="' + kd_cust_label + '">Customer Ke-'+ jml_cust +'</label>\
            <div class="input-group">\
              <input type="text" id="' + kd_cust + '" name="' + kd_cust + '" required class="form-control" placeholder="Customer" onkeydown="keyPressedKdCust(this, event)" onchange="validateKdCust(this)" maxlength="40">\
              <span class="input-group-btn">\
                <button id="' + btnpopupcust + '" name="' + btnpopupcust + '" type="button" class="btn btn-info" onclick="popupKdCust(this)" data-toggle="modal" data-target="#customerModal">\
                  <span class="glyphicon glyphicon-search"></span>\
                </button>\
              </span>\
            </div>\
          </div>\
          <div class="col-sm-5">\
            <label name="' + nm_cust_label + '" id="' + nm_cust_label + '">Nama Customer Ke-'+ jml_cust +'</label>\
            <input type="text" id="' + nm_cust + '" name="' + nm_cust + '" class="form-control" placeholder="Nama Customer" disabled="">\
          </div>\
          <div class="col-sm-1">\
            <label name="' + btndelete_label + '" id="' + btndelete_label + '">Remove</label>\
            <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" onclick="deleteCust(this)">\
              <i class="fa fa-times"></i>\
            </button>\
          </div>\
      </div>'
    );

    document.getElementById(kd_cust).focus();
  });

  $("#btn-delete").click(function(){
    var kd_model = document.getElementById("kd_model").value.trim();
    var msg = 'Anda yakin menghapus Model: ' + kd_model + '?';
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
      var urlRedirect = "{{ route('engtmmodels.delete', 'param') }}";
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

  function keyPressedKdCust(ths, e) {
    if(e.keyCode == 120) { //F9
      var row = ths.id.replace('kd_cust_', '');
      var id_btn = "#cust_btnpopupcust_" + row;
      $(id_btn).click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById("st_aktif").focus();
    }
  }

  $(document).ready(function(){

  });

  function popupKdCust(ths) {
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
            var row = ths.id.replace('cust_btnpopupcust_', '');
            var id_kd_cust = "kd_cust_" + row;
            var id_nm_cust = "nm_cust_" + row;
            document.getElementById(id_kd_cust).value = value["kd_cust"];
            document.getElementById(id_nm_cust).value = value["nm_cust"];
            $('#customerModal').modal('hide');
            compareKdCust(row);
          });
        });
        $('#customerModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('cust_btnpopupcust_', '');
          var id_kd_cust = "kd_cust_" + row;
          var id_nm_cust = "nm_cust_" + row;
          var kd_cust = document.getElementById(id_kd_cust).value.trim();
          if(kd_cust === '') {
            document.getElementById(id_kd_cust).value = "";
            document.getElementById(id_nm_cust).value = "";
            document.getElementById(id_kd_cust).focus();
          } else {
            document.getElementById("st_aktif").focus();
          }
        });
      },
    });
  }


  function validateKdCust(ths) {
    var row = ths.id.replace('kd_cust_', '');
    compareKdCust(row);
    var id_kd_cust = "kd_cust_" + row;
    var id_nm_cust = "nm_cust_" + row;
    var kd_cust = document.getElementById(id_kd_cust).value.trim();
    if(kd_cust !== '') {
      var url = '{{ route('datatables.validasiEngtMcust', 'param') }}';
      url = url.replace('param', window.btoa(kd_cust));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById(id_kd_cust).value = result["kd_cust"];
          document.getElementById(id_nm_cust).value = result["nm_cust"];
        } else {
          document.getElementById(id_kd_cust).value = "";
          document.getElementById(id_nm_cust).value = "";
          document.getElementById(id_kd_cust).focus();
          swal("Customer tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById(id_kd_cust).value = "";
      document.getElementById(id_nm_cust).value = "";
    }
  }

  function compareKdCust(row){
    var id_kd_cust = "kd_cust_" + row;
    var id_nm_cust = "nm_cust_" + row;
    var kd_cust = document.getElementById(id_kd_cust).value.trim();
    var jml_cust = document.getElementById('jml_cust').value.trim();
    for (i = 1 ; i <= jml_cust ; i++) {
      if (i != row) {
        var kd_cust_check = "kd_cust_" + i;
        var kd_cust_checked = document.getElementById(kd_cust_check).value.trim();
        if (kd_cust === kd_cust_checked && kd_cust_checked != '' ){
          document.getElementById(id_kd_cust).value = "";
          document.getElementById(id_nm_cust).value = "";
          document.getElementById(id_kd_cust).focus();
          swal("Customer tidak valid!", "Customer sudah terdaftar di line ke-"+i+".", "error");
        }
      }
    }
  }


  function deleteCust(ths) {
    var msg = 'Anda yakin menghapus Kode Customer ini?';
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
      var row = ths.id.replace('cust_btndelete_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var kd_cust = document.getElementById("kd_cust_" + row).value.trim();
      var kd_model = document.getElementById("kd_model").value.trim();
      if(kd_cust === "" || kd_cust === "0" || kd_model === "" || kd_model === "0") {
        changeKdCust(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = '{{ route('engtmmodels.deleteCust', ['param','param2']) }}';
        url = url.replace('param', window.btoa(kd_model));
        url = url.replace('param2', window.btoa(kd_cust));
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
              changeKdCust(row);
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

  function changeKdCust(row) {
    var id_field = "#cust_field_" + row;
    $(id_field).remove();

    var jml_cust = document.getElementById("jml_cust").value.trim();
    jml_cust = Number(jml_cust);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_cust; $i++) {
      var kd_cust = '#kd_cust_' + $i;
      var kd_cust_new = 'kd_cust_' + ($i-1);
      $(kd_cust).attr({"id":kd_cust_new, "name":kd_cust_new});
      var kd_cust_label = '#kd_cust_label_' + $i;
      var kd_cust_label_new = 'kd_cust_label_' + ($i-1);
      $(kd_cust_label).attr({"id":kd_cust_label_new, "name":kd_cust_label_new});
      var nm_cust = '#nm_cust_' + $i;
      var nm_cust_new = 'nm_cust_' + ($i-1);
      $(nm_cust).attr({"id":nm_cust_new, "name":nm_cust_new});
      var nm_cust_label = '#nm_cust_label_' + $i;
      var nm_cust_label_new = 'nm_cust_label_' + ($i-1);
      $(nm_cust_label).attr({"id":nm_cust_label_new, "name":nm_cust_label_new});
      var btndelete = '#cust_btndelete_' + $i;
      var btndelete_new = 'cust_btndelete_' + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var btndelete_label = '#cust_btndelete_label_' + $i;
      var btndelete_label_new = 'cust_btndelete_label_' + ($i-1);
      $(btndelete_label).attr({"id":btndelete_label_new, "name":btndelete_label_new});
      var btnpopupcust = '#cust_btnpopupcust_' + $i;
      var btnpopupcust_new = 'cust_btnpopupcust_' + ($i-1);
      $(btnpopupcust).attr({"id":btnpopupcust_new, "name":btnpopupcust_new});
      var id_field = "#cust_field_" + $i;
      var id_field_new = "cust_field_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});

      var text = document.getElementById(kd_cust_label_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(kd_cust_label_new).innerHTML = text;
      text = document.getElementById(nm_cust_label_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(nm_cust_label_new).innerHTML = text;
    }
    jml_cust = jml_cust - 1;
    document.getElementById("jml_cust").value = jml_cust;

  }
</script>
@endsection
