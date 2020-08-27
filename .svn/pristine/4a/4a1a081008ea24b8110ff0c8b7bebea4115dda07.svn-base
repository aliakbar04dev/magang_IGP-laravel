<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_dm') ? ' has-error' : '' }}">
      {!! Form::label('no_dm', 'No. DM') !!}
      @if (empty($mtctdftmslh->no_dm))
        {!! Form::text('no_wo', null, ['class'=>'form-control','placeholder' => 'No. DM', 'disabled'=>'']) !!}
      @else
        {!! Form::text('no_dm2', $mtctdftmslh->no_dm, ['class'=>'form-control','placeholder' => 'No. DM', 'required', 'disabled'=>'']) !!}
        {!! Form::hidden('no_dm', null, ['class'=>'form-control','placeholder' => 'No. DM', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('no_dm', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('tgl_dm') ? ' has-error' : '' }}">
      {!! Form::label('tgl_dm', 'Tanggal DM (*)') !!}
      @if (empty($mtctdftmslh->tgl_dm))
        {!! Form::date('tgl_dm', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl DM', 'required']) !!}
      @else
        {!! Form::date('tgl_dm', \Carbon\Carbon::parse($mtctdftmslh->tgl_dm), ['class'=>'form-control','placeholder' => 'Tgl DM', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('tgl_dm', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('kd_plant') ? ' has-error' : '' }}">
      {!! Form::label('kd_plant', 'Plant (*)') !!}
      @if (empty($mtctdftmslh->no_pi))
        {!! Form::select('kd_plant',  $plant->pluck('nm_plant','kd_plant')->all(), null, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'kd_plant']) !!}
      @else
        {!! Form::hidden('kd_plant', $mtctdftmslh->kd_plant, ['class'=>'form-control','placeholder' => 'Plant', 'required', 'id' => 'kd_plant']) !!}
        {!! Form::select('kd_plant2',  $plant->pluck('nm_plant','kd_plant')->all(), $mtctdftmslh->kd_plant, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'kd_plant2', 'disabled'=>'']) !!}
      @endif
      {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_line') ? ' has-error' : '' }}">
      {!! Form::label('kd_line', 'Line (F9) (*)') !!}
      <div class="input-group">
        @if (empty($mtctdftmslh->no_pi))
          {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line']) !!}
          <span class="input-group-btn">
            <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line', 'readonly' => 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal" readonly="readonly">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
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
        @if (empty($mtctdftmslh->no_pi))
          {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required']) !!}
          <span class="input-group-btn">
            <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required', 'readonly' => 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal" readonly="readonly">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
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
  <div class="form-group">
    <div class="col-sm-8 {{ $errors->has('ket_prob') ? ' has-error' : '' }}">
      {!! Form::label('ket_prob', 'Problem (*)') !!}
      @if (empty($mtctdftmslh->no_pi))
        {!! Form::textarea('ket_prob', null, ['class'=>'form-control', 'placeholder' => 'Problem', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
      @else
        {!! Form::textarea('ket_prob', null, ['class'=>'form-control', 'placeholder' => 'Problem', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
      @endif
      {!! $errors->first('ket_prob', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-8 {{ $errors->has('lok_pict') ? ' has-error' : '' }}">
      {!! Form::label('lok_pict', 'Picture (jpeg,png,jpg)') !!}
      {!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
      @if (!empty($mtctdftmslh->lok_pict))
        <p>
          <img src="{{ $mtctdftmslh->lokPict() }}" alt="File Not Found" class="img-rounded img-responsive">
          <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('mtctdftmslhplants.deleteimage', base64_encode($mtctdftmslh->no_dm)) }}"><span class="glyphicon glyphicon-remove"></span></a>
        </p>
      @endif
      {!! $errors->first('lok_pict', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save DM', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($mtctdftmslh->no_dm))
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('mtctdftmslhplants.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong. Max size file 8 MB', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Line -->
@include('mtc.lp.popup.lineModal')
<!-- Modal Mesin -->
@include('mtc.lp.popup.mesinModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("tgl_dm").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var no_dm = document.getElementById("no_dm").value.trim();
    var msg = 'Anda yakin menghapus No. DM: ' + no_dm + '?';
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
      var urlRedirect = "{{ route('mtctdftmslhplants.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_dm));
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
      document.getElementById('ket_prob').focus();
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
      // "scrollX": true,
      // "scrollY": "500px",
      // "scrollCollapse": true,
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
            $('#ket_prob').focus();
          }
        });
      },
    });
  }

  function validateKdMesin() {
    var kd_plant = document.getElementById("kd_plant").value.trim();
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
            document.getElementById("ket_prob").focus();
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
</script>
@endsection
