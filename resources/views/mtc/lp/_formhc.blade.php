<div class="box-body form-horizontal">
  <div class="form-group">
    <div class="col-sm-2 {{ $errors->has('tgl_awal') ? ' has-error' : '' }}">
      {!! Form::label('tgl_awal', 'Tanggal Awal (*)') !!}
      {!! Form::date('tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'required']) !!}
      {!! $errors->first('tgl_awal', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_akhir') ? ' has-error' : '' }}">
      {!! Form::label('tgl_akhir', 'Tanggal Akhir (*)') !!}
      {!! Form::date('tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'required']) !!}
      {!! $errors->first('tgl_akhir', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-2 {{ $errors->has('kd_site') ? ' has-error' : '' }}">
      {!! Form::label('kd_site', 'Site') !!}
      {!! Form::select('kd_site', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], null, ['class'=>'form-control select2', 'onchange' => 'changeKdSite()']) !!}
      {!! $errors->first('kd_site', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('lok_pt') ? ' has-error' : '' }}">
      {!! Form::label('lok_pt', 'Plant') !!}
      {!! Form::select('lok_pt', ['-' => 'ALL', '1' => 'IGP-1', '2' => 'IGP-2', '3' => 'IGP-3', '4' => 'IGP-4'], null, ['class'=>'form-control select2', 'onchange' => 'changeKdPlant()']) !!}
      {!! $errors->first('lok_pt', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-2 {{ $errors->has('kd_line') ? ' has-error' : '' }}">
      {!! Form::label('kd_line', 'Line (F9)') !!}
      <div class="input-group">
        {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()']) !!}
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
    <div class="col-sm-2 {{ $errors->has('kd_mesin') ? ' has-error' : '' }}">
      {!! Form::label('kd_mesin', 'Mesin (F9)') !!}
      <div class="input-group">
        {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()']) !!}
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
  <div class="form-group">
    <div class="col-sm-4 {{ $errors->has('no_wo') ? ' has-error' : '' }}">
      {!! Form::label('no_wo', 'No. LP (F9)') !!}
      <div class="input-group">
        {!! Form::text('no_wo', null, ['class'=>'form-control','placeholder' => 'No. LP', 'maxlength' => 17, 'onkeydown' => 'keyPressedLp(event)', 'onchange' => 'validateLp()']) !!}
        <span class="input-group-btn">
          <button id="btnpopuplp" type="button" class="btn btn-info" data-toggle="modal" data-target="#lpModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('no_wo', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  <button id='btnprint' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Print History Card' onclick='printHistoryCard()'>
    <span class='glyphicon glyphicon-print'></span> Print History Card
  </button>
  &nbsp;&nbsp;
  <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Line -->
@include('mtc.lp.popup.lineModal')
<!-- Modal Mesin -->
@include('mtc.lp.popup.mesinModal')
<!-- Modal LP -->
@include('mtc.lp.popup.lpModal')

@section('scripts')
<script type="text/javascript">
  document.getElementById("tgl_awal").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function printHistoryCard()
  {
    var tgl_awal = document.getElementById("tgl_awal").value;
    var tgl_akhir = document.getElementById("tgl_akhir").value;
    if(tgl_awal == "" || tgl_akhir == "") {
      swal("Tgl Awal & Akhir tidak boleh kosong!", "Perhatikan inputan anda!", "error");
    } else {
      var msg = 'Anda yakin print data ini?';
      var txt = '';
      //additional input validations can be done hear
      swal({
        title: msg,
        text: txt,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, print it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        var kd_site = document.getElementById("kd_site").value;
        if(kd_site == "") {
          kd_site = "-";
        }
        var kd_plant = document.getElementById("lok_pt").value;
        if(kd_plant == "") {
          kd_plant = "-";
        }
        var kd_line = document.getElementById("kd_line").value;
        if(kd_line == "") {
          kd_line = "-";
        }
        var kd_mesin = document.getElementById("kd_mesin").value;
        if(kd_mesin == "") {
          kd_mesin = "-";
        }
        var no_wo = document.getElementById("no_wo").value;
        if(no_wo == "") {
          no_wo = "-";
        }
        var urlRedirect = "{{ route('tmtcwo1s.printhistorycard', ['param','param2','param3','param4','param5','param6','param7']) }}";
        urlRedirect = urlRedirect.replace('param7', window.btoa(no_wo));
        urlRedirect = urlRedirect.replace('param6', window.btoa(kd_mesin));
        urlRedirect = urlRedirect.replace('param5', window.btoa(kd_line));
        urlRedirect = urlRedirect.replace('param4', window.btoa(kd_plant));
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_site));
        urlRedirect = urlRedirect.replace('param2', window.btoa(tgl_akhir));
        urlRedirect = urlRedirect.replace('param', window.btoa(tgl_awal));
        // window.location.href = urlRedirect;
        window.open(urlRedirect, '_blank');
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

  function changeKdSite() {
    var kd_site = document.getElementById("kd_site").value;
    $('#lok_pt').children('option').remove();
    $("#lok_pt").append('<option value="-">ALL</option>');
    if(kd_site === "IGPK") {
      $("#lok_pt").append('<option value="A">KIM-1A</option>');
      $("#lok_pt").append('<option value="B">KIM-1B</option>');
    } else if(kd_site === "IGPJ") {
      $("#lok_pt").append('<option value="1">IGP-1</option>');
      $("#lok_pt").append('<option value="2">IGP-2</option>');
      $("#lok_pt").append('<option value="3">IGP-3</option>');
      $("#lok_pt").append('<option value="4">IGP-4</option>');
    }
    //$('#lok_pt').append(new Option('IGP 1', '1', false, false));
    //$("#lok_pt").empty();
    changeKdPlant();
  }

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
      document.getElementById('no_wo').focus();
    }
  }

  function keyPressedLp(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopuplp').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('btnprint').focus();
    }
  }

  $(document).ready(function(){

    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    $("#btnpopupmesin").click(function(){
      popupKdMesin();
    });

    $("#btnpopuplp").click(function(){
      popupLp();
    });
  });

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var lok_pt = document.getElementById('lok_pt').value.trim();
    if(lok_pt == "-") {
      lok_pt = document.getElementById("kd_site").value.trim();
    }
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(lok_pt));
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
      // "scrollX": true,
      // "scrollY": "500px",
      // "scrollCollapse": true,
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
      var lok_pt = document.getElementById('lok_pt').value.trim();
      if(lok_pt == "-") {
        lok_pt = document.getElementById("kd_site").value.trim();
      }
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(lok_pt));
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
          // document.getElementById("kd_mesin").value = "";
          // document.getElementById("nm_mesin").value = "";
          document.getElementById("kd_line").focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
      // document.getElementById("kd_mesin").value = "";
      // document.getElementById("nm_mesin").value = "";
    }
  }

  function popupKdMesin() {
    var myHeading = "<p>Popup Mesin</p>";
    $("#mesinModalLabel").html(myHeading);
    var lok_pt = document.getElementById('lok_pt').value.trim();
    if(lok_pt == "-") {
      lok_pt = document.getElementById("kd_site").value.trim();
    }
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var url = '{{ route('datatables.popupMesins', ['param','param2']) }}';
    url = url.replace('param2', window.btoa(kd_line));
    url = url.replace('param', window.btoa(lok_pt));
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
            $('#no_wo').focus();
          }
        });
      },
    });
  }

  function validateKdMesin() {
    var lok_pt = document.getElementById('lok_pt').value.trim();
    if(lok_pt == "-") {
      lok_pt = document.getElementById("kd_site").value.trim();
    }
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    if(lok_pt !== '' && kd_mesin !== '') {
      var url = '{{ route('datatables.validasiMesin', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(kd_mesin));
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(lok_pt));
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
            document.getElementById("no_wo").focus();
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

  function popupLp() {
    var myHeading = "<p>Popup LP</p>";
    $("#lpModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupLps') }}';
    var lookupLp = $('#lookupLp').DataTable({
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
      "order": [[1, 'desc'],[0, 'desc']],
      columns: [
        { data: 'no_wo', name: 'no_wo'},
        { data: 'tgl_wo', name: 'tgl_wo'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupLp tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLp.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_wo").value = value["no_wo"];
            $('#lpModal').modal('hide');
            validateLp();
          });
        });
        $('#lpModal').on('hidden.bs.modal', function () {
          var no_wo = document.getElementById("no_wo").value.trim();
          if(no_wo === '') {
            document.getElementById("no_wo").value = "";
            $('#no_wo').focus();
          } else {
            $('#btnprint').focus();
          }
        });
      },
    });
  }

  function validateLp() {
    var no_wo = document.getElementById("no_wo").value.trim();
    if(no_wo !== '') {
      var url = '{{ route('datatables.validasiLp', 'param') }}';
      url = url.replace('param', window.btoa(no_wo));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_wo").value = result["no_wo"];
          document.getElementById("btnprint").focus();
        } else {
          document.getElementById("no_wo").value = "";
          document.getElementById("no_wo").focus();
          swal("No. LP tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_wo").value = "";
    }
  }
</script>
@endsection
