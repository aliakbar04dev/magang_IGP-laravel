<div class="box-body">
  <div class="row">    
    <div class="col-md-6">  
      <div class="form-group {{ $errors->has('kd_mesin') ? ' has-error' : '' }}">
          @if (!empty($mtcmesin->kd_mesin))
          <div class="col-md-4"> 
              {!! Form::label('kd_mesin', 'Kode Mesin (*)') !!}
              {!! Form::text('kd_mesin', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Kode Mesin', 'maxlength' => '20', 'required','readonly']) !!} {!! $errors->first('kd_mesin', '<p class="help-block">:message</p>') !!}
            </div>
          @else
            <div class="col-md-4"> 
                {!! Form::label('kd_mesin', 'Kode Mesin (*)') !!}
                {!! Form::text('kd_mesin', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Kode Mesin', 'maxlength' => '20', 'required']) !!} {!! $errors->first('kd_mesin', '<p class="help-block">:message</p>') !!}
              </div>
          @endif
      </div>
      <div class="form-group {{ $errors->has('nm_mesin') ? ' has-error' : '' }}">
        <div class="col-md-8"> 
          {!! Form::label('nm_mesin', 'Nama Mesin (*)') !!}
          {!! Form::text('nm_mesin', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Nama Mesin', 'maxlength' => '50', 'required']) !!} {!! $errors->first('nm_mesin', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group{{ $errors->has('maker') ? ' has-error' : '' }}">
        <div class="col-md-8">
          {!! Form::label('maker', 'Maker') !!}
          {!! Form::text('maker', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Maker', 'maxlength' => '50']) !!}     
          {!! $errors->first('maker', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group{{ $errors->has('mdl_type') ? ' has-error' : '' }}">
        <div class="col-md-8">
          {!! Form::label('mdl_type', 'Type') !!}
          {!! Form::text('mdl_type', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Type', 'maxlength' => '50']) !!}     
          {!! $errors->first('mdl_type', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group{{ $errors->has('mfd_thn') ? ' has-error' : '' }}">
        <div class="col-md-4">
          {!! Form::label('mfd_thn', 'Tahun') !!}
          {!! Form::number('mfd_thn', null, ['class'=>'form-control']) !!}    
          {!! $errors->first('mfd_thn', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group{{ $errors->has('no_seri') ? ' has-error' : '' }}">
        <div class="col-md-8">
          {!! Form::label('no_seri', 'No Seri') !!}
          {!! Form::text('no_seri', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'No Seri', 'maxlength' => '30']) !!}     
          {!! $errors->first('no_seri', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group {{ $errors->has('st_aktif') ? ' has-error' : '' }}"> 
        <div class="col-md-4">         
          {!! Form::label('st_aktif', 'Status Aktif (*)') !!}
          {!! Form::select('st_aktif', ['T' => 'Aktif', 'F' => 'Non Aktif'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'id' => 'st_aktif', 'required']) !!}
          {!! $errors->first('st_aktif', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group {{ $errors->has('st_me') ? ' has-error' : '' }}"> 
        <div class="col-md-4">         
          {!! Form::label('st_me', 'M/E/F (*)') !!}
          {!! Form::select('st_me', ['M' => 'Mesin', 'E' => 'Equipment','F' => 'Forklif'], null, ['class'=>'form-control select2','placeholder' => 'Pilih M/E/F', 'id' => 'st_me', 'required']) !!}
          {!! $errors->first('st_me', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="form-group">
        <div class="col-sm-4 {{ $errors->has('kd_line') ? ' has-error' : '' }}">
          {!! Form::label('kd_line', 'Line (F9) (*)') !!}
          <div class="input-group">
              {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 5, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line']) !!}
              <span class="input-group-btn">
                <button id="btnpopupline" name="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </span>
          </div>
          {!! $errors->first('kd_line', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-4 {{ $errors->has('nm_line') ? ' has-error' : '' }}">
          {!! Form::label('nm_line', 'Nama Line') !!}
          {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
          {!! $errors->first('nm_line', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-4 {{ $errors->has('kd_plant') ? ' has-error' : '' }}">
          {!! Form::label('kd_plant', 'Nama Plant') !!}
          {!! Form::text('kd_plant', null, ['class'=>'form-control','placeholder' => 'Kode Plant', 'disabled'=>'', 'id' => 'kd_plant']) !!}
          {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="form-group {{ $errors->has('lok_zona') ? ' has-error' : '' }}"> 
        <div class="col-md-4">         
          {!! Form::label('lok_zona', 'Zona (*)') !!}
          {!! Form::select('lok_zona', ['1' => '1', '2' => '2','3' => '3','4'=> '4','5'=> '5',], null, ['class'=>'form-control select2','placeholder' => 'Pilih Zona', 'id' => 'lok_zona', 'required']) !!}
          {!! $errors->first('lok_zona', '<p class="help-block">:message</p>') !!}
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
  @if (empty($kdMesinDel) && !empty($mtcmesin->kd_mesin))
  <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('mtcmesin.index') }}">Cancel</a>
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@include('mtc.mesin.popup.lineModal')
@section('scripts')
<script type="text/javascript">
  document.getElementById("kd_mesin").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    var msg = 'Anda yakin menghapus Mesin: ' + kd_mesin + '?';
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
      var urlRedirect = "{{ route('mtcmesin.delete', 'param') }}";
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

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('st_aktif').focus();
    }
  }

  $(document).ready(function(){
    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    var kode = document.getElementById("kd_line").value.trim();     
    if(kode !== '') {
      validateKdLine();
    }
  });

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupMtcMesin') }}';
    console.log(url);
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
        { data: 'xnm_line', name: 'xnm_line'}, 
        { data: 'xkd_plant', name: 'xkd_plant'}
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
            document.getElementById("kd_plant").value = value["xkd_plant"];
            $('#lineModal').modal('hide');
            validateKdLine();
          });
        });
        //mobile device only uses click action triggered 
        $('#lookupLine tbody').on('click', 'tr', function () {
          var dataArr = [];
            var rows = $(this);
            var rowData = lookupLine.rows(rows).data();
            $.each($(rowData), function (key, value) {
              document.getElementById("kd_line").value = value["xkd_line"];
              document.getElementById("nm_line").value = value["xnm_line"];
              document.getElementById("kd_plant").value = value["xkd_plant"];
              $('#lineModal').modal('hide');
              validateKdLine();
            });
          });
        $('#lineModal').on('hidden.bs.modal', function () {
          var kd_line = document.getElementById("kd_line").value.trim();
          if(kd_line === '') {
            document.getElementById("kd_line").value = "";
            document.getElementById("nm_line").value = "";
            document.getElementById("kd_plant").value = "";
            $('#kd_line').focus();
          } else {
            document.getElementById('st_aktif').focus();
          }
        });
      },
    });

  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      
      var url = '{{ route('datatables.validasiMtcMesin', 'param') }}';
      url = url.replace('param', window.btoa(kd_line));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];
          document.getElementById("kd_plant").value = result["xkd_plant"];
        } else {
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          document.getElementById("kd_plant").value = "";
          document.getElementById("kd_line").focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
      document.getElementById("kd_plant").value = "";
    }
  }
</script>
@endsection
