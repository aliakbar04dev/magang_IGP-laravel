<div class="box-body">
  <div class="row">    
    <div class="col-md-12">  
      <div class="form-group {{ $errors->has('part_no') ? ' has-error' : '' }}">
        <div class="col-md-4"> 
          {!! Form::label('part_no', 'Kode Part (*)') !!}
          {!! Form::text('part_no', null, ['class'=>'form-control', 'placeholder' => 'Kode Part', 'maxlength' => '40', 'required']) !!} {!! $errors->first('part_no', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group {{ $errors->has('nm_part') ? ' has-error' : '' }}">
        <div class="col-md-6"> 
          {!! Form::label('nm_part', 'Partname') !!}
          {!! Form::text('nm_part', null, ['class'=>'form-control', 'placeholder' => 'partname', 'maxlength' => '150']) !!} {!! $errors->first('nm_part', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group {{ $errors->has('nm_material') ? ' has-error' : '' }}">
        <div class="col-md-6"> 
          {!! Form::label('nm_material', 'Material') !!}
          {!! Form::text('nm_material', null, ['class'=>'form-control', 'placeholder' => 'Material', 'maxlength' => '50']) !!} {!! $errors->first('nm_material', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group {{ $errors->has('kd_kat') ? ' has-error' : '' }}">
        <div class="col-md-2"> 
          {!! Form::label('kd_kat', 'Kategori') !!}
           {!! Form::select('kd_kat', ['IN' => 'IN', 'OUT' => 'OUT'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Kategori', 'id' => 'kd_kat', 'required']) !!}
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-4 {{ $errors->has('kd_model') ? ' has-error' : '' }}">
          {!! Form::label('kd_model', 'Model Name (F9) (*)') !!}
          <div class="input-group">
            {!! Form::text('kd_model', null, ['class'=>'form-control','placeholder' => 'Model Name', 'maxlength' => 40, 'onkeydown' => 'keyPressedKdModel(event)', 'onchange' => 'validateKdModel()', 'required', 'id' => 'kd_model']) !!}
            <span class="input-group-btn">
              <button id="btnpopupmodel" type="button" class="btn btn-info" data-toggle="modal" data-target="#modelModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
          {!! $errors->first('kd_model', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group {{ $errors->has('st_aktif') ? ' has-error' : '' }}"> 
        <div class="col-md-2">         
          {!! Form::label('st_aktif', 'Status Aktif (*)') !!}
          {!! Form::select('st_aktif', ['T' => 'Aktif', 'F' => 'Non Aktif'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'id' => 'st_aktif', 'required']) !!}
          {!! $errors->first('st_aktif', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.row -->
</div>

<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($engtmparts->part_no))
  <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('engtmparts.index') }}">Cancel</a>
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@include('eng.pfc.popup.modelModal')
@section('scripts')
<script type="text/javascript">
  document.getElementById("part_no").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var part_no = document.getElementById("part_no").value.trim();
    var msg = 'Anda yakin menghapus Part: ' + part_no + '?';
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
      var urlRedirect = "{{ route('engtmparts.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(part_no));
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

  $(document).ready(function(){
    $("#btnpopupmodel").click(function(){
      popupKdModel();
    });
  });

  function popupKdModel() {
    var myHeading = "<p>Popup Model</p>";
    $("#modelModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupEngtMmodelsMst') }}';
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
</script>
@endsection
