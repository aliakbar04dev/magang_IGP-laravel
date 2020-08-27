<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('dtcrea') ? ' has-error' : '' }}">
      {!! Form::label('dtcrea', 'Tanggal (*)') !!}
      @if (empty($mtctlogpkb->dtcrea))
        {!! Form::text('dtcrea', null, ['class' => 'form-control', 'placeholder' => 'Tanggal', 'disabled' => '', 'id' => 'dtcrea']) !!}
      @else
        {!! Form::hidden('id', \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis'), ['class' => 'form-control', 'placeholder' => 'Tanggal', 'disabled' => '', 'id' => 'id']) !!}
        {!! Form::text('dtcrea', \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s'), ['class' => 'form-control', 'placeholder' => 'Tanggal', 'disabled' => '', 'id' => 'dtcrea']) !!}
      @endif
      {!! $errors->first('dtcrea', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-6 {{ $errors->has('creaby') ? ' has-error' : '' }}">
      {!! Form::label('creaby', 'Pembuat (*)') !!}
      @if (empty($mtctlogpkb->creaby))
        {!! Form::text('creaby', Auth::user()->username." - ".Auth::user()->name, ['class' => 'form-control', 'placeholder' => 'Pembuat', 'disabled' => '']) !!}
      @else
        {!! Form::text('creaby', $mtctlogpkb->creaby." - ".$mtctlogpkb->nm_creaby, ['class' => 'form-control', 'placeholder' => 'Pembuat', 'disabled' => '']) !!}
      @endif
      {!! $errors->first('creaby', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_plant') ? ' has-error' : '' }}">
      {!! Form::label('kd_plant', 'Plant (*)') !!}
      {!! Form::select('kd_plant',  $plant->pluck('nm_plant','kd_plant')->all(), null, ['class' => 'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'kd_plant']) !!}
      {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3" {{ $errors->has('kd_item') ? ' has-error' : '' }}">
      {!! Form::label('kd_item', 'Item (*) (F9)') !!}
      <div class="input-group">
        {!! Form::text('kd_item', null, ['class' => 'form-control','placeholder' => 'Item', 'maxlength' => 17, 'onkeydown' => 'keyPressedKdItem(event)', 'onchange' => 'validateKdItem()', 'required', 'id' => 'kd_item']) !!}
        <span class="input-group-btn">
          <button id="btnpopupitem" type="button" class="btn btn-info" data-toggle="modal" data-target="#itemModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>
    <div class="col-sm-6 {{ $errors->has('nm_item') ? ' has-error' : '' }}">
      {!! Form::label('nm_item', 'Nama Item') !!}
      {!! Form::text('nm_item', null, ['class' => 'form-control','placeholder' => 'Nama Item', 'disabled' => '', 'id' => 'nm_item']) !!}
      {!! $errors->first('nm_item', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-6 {{ $errors->has('nm_brg') ? ' has-error' : '' }}">
      {!! Form::label('nm_brg', 'Nama Barang (*)') !!}
      {!! Form::text('nm_brg', null, ['class' => 'form-control','placeholder' => 'Nama Barang', 'maxlength' => '50', 'maxlength' => '50', 'id' => 'nm_brg', 'readonly' => 'readonly']) !!}
      {!! $errors->first('nm_brg', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-6 {{ $errors->has('nm_type') ? ' has-error' : '' }}">
      {!! Form::label('nm_type', 'Nama Type (*)') !!}
      {!! Form::text('nm_type', null, ['class' => 'form-control','placeholder' => 'Nama Type', 'maxlength' => '50', 'maxlength' => '50', 'id' => 'nm_type', 'readonly' => 'readonly']) !!}
      {!! $errors->first('nm_type', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-6 {{ $errors->has('nm_merk') ? ' has-error' : '' }}">
      {!! Form::label('nm_merk', 'Nama Merk (*)') !!}
      {!! Form::text('nm_merk', null, ['class' => 'form-control','placeholder' => 'Nama Merk', 'maxlength' => '50', 'maxlength' => '50', 'id' => 'nm_merk', 'readonly' => 'readonly']) !!}
      {!! $errors->first('nm_merk', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('qty') ? ' has-error' : '' }}">
      {!! Form::label('qty', 'QTY (*)') !!}
      {!! Form::number('qty', null, ['class'=>'form-control', 'placeholder' => 'QTY', 'min' => '0', 'max' => 9999999999, 'step' => '1', 'required']) !!}
      {!! $errors->first('qty', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('kd_sat') ? ' has-error' : '' }}">
      {!! Form::label('kd_sat', 'Satuan') !!}
      {!! Form::select('kd_sat',  $b_satuan->pluck('nama_satuan','kd_sat')->all(), null, ['class' => 'form-control select2', 'placeholder' => 'PILIH SATUAN', 'id' => 'kd_sat']) !!}
      {!! $errors->first('kd_sat', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-6 {{ $errors->has('ket_mesin_line') ? ' has-error' : '' }}">
      {!! Form::label('ket_mesin_line', 'Keterangan') !!}
      {!! Form::textarea('ket_mesin_line', null, ['class' => 'form-control', 'placeholder' => 'Keterangan', 'rows' => '3', 'maxlength' => '50', 'style' => 'resize:vertical']) !!}
      {!! $errors->first('ket_mesin_line', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('dok_ref') ? ' has-error' : '' }}">
      {!! Form::label('dok_ref', 'Dok. Referensi') !!}
      {!! Form::select('dok_ref', ['DM' => 'DAFTAR MASALAH'], null, ['class'=>'form-control select2', 'placeholder' => 'Pilih Dok. Ref', 'id' => 'dok_ref', 'onchange' => 'changeDokRef()']) !!}
      {!! $errors->first('dok_ref', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('no_dok') ? ' has-error' : '' }}">
      {!! Form::label('no_dok', 'No. Referensi (F9) (*)') !!}
      <div class="input-group">
      {!! Form::text('no_dok', null, ['class'=>'form-control','placeholder' => 'No. Referensi', 'maxlength' => 50, 'onkeydown' => 'keyPressedNoDok(event)', 'onchange' => 'validateNoDok()', 'id' => 'no_dok']) !!}
        <span class="input-group-btn">
          <button id="btnpopupnodok" type="button" class="btn btn-info" data-toggle="modal" data-target="#nodokModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('no_dok', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-6 {{ $errors->has('lok_pict') ? ' has-error' : '' }}">
      {!! Form::label('lok_pict', 'Picture (jpeg,png,jpg)') !!}
      {!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
      @if (!empty($mtctlogpkb->lok_pict))
        <p>
          <img src="{{ $mtctlogpkb->lokPict() }}" alt="File Not Found" class="img-rounded img-responsive">
          <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('mtctlogpkbs.deleteimage', base64_encode(\Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis'))) }}"><span class="glyphicon glyphicon-remove"></span></a>
        </p>
      @endif
      {!! $errors->first('lok_pict', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save Data', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($mtctlogpkb->dtcrea))
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('mtctlogpkbs.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Item -->
@include('mtc.logbookpkb.popup.itemModal')
<!-- Modal Referensi -->
@include('mtc.logbookpkb.popup.nodokModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("kd_plant").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function changeDokRef() {
    var dok_ref = document.getElementById("dok_ref").value.trim();
    if(dok_ref != null && dok_ref != "") {
      $('#no_dok').removeAttr('readonly');
      $('#no_dok').attr('required', 'required');
      $('#btnpopupnodok').removeAttr('disabled');
      validateNoDok();
    } else {
      document.getElementById("no_dok").value = "";
      $('#no_dok').attr('readonly', 'readonly');
      $('#no_dok').removeAttr('required');
      $('#btnpopupnodok').attr('disabled', '');
    }
  }

  changeDokRef();

  function changeItem() {
    var kd_item = document.getElementById("kd_item").value.trim();
    if(kd_item !== "-") {
      document.getElementById("nm_brg").value = "";
      document.getElementById("nm_type").value = "";
      document.getElementById("nm_merk").value = "";
      $('#nm_brg').removeAttr('required');
      $('#nm_brg').attr('readonly', 'readonly');
      $('#nm_type').removeAttr('required');
      $('#nm_type').attr('readonly', 'readonly');
      $('#nm_merk').removeAttr('required');
      $('#nm_merk').attr('readonly', 'readonly');
    } else {
      document.getElementById("nm_item").value = "";
      $('#nm_brg').attr('required', 'required');
      $('#nm_brg').removeAttr('readonly');
      $('#nm_type').attr('required', 'required');
      $('#nm_type').removeAttr('readonly');
      $('#nm_merk').attr('required', 'required');
      $('#nm_merk').removeAttr('readonly');
    }
  }

  changeItem();

  $("#btn-delete").click(function(){
    var id = document.getElementById("id").value.trim();
    var dtcrea = document.getElementById("dtcrea").value.trim();
    var msg = 'Anda yakin menghapus data: ' + dtcrea + '?';
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
      var urlRedirect = "{{ route('mtctlogpkbs.delete', 'param') }}";
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

  function changeKdPlant() {
    validateNoDok();
  }

  function keyPressedKdItem(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupitem').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('nm_brg').focus();
    }
  }

  function keyPressedNoDok(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnodok').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('lok_pict').focus();
    }
  }

  $(document).ready(function(){
    $("#btnpopupitem").click(function(){
      popupKdItem();
    });

    $("#btnpopupnodok").click(function(){
      popupNoDok();
    });
  });

  function popupKdItem() {
    var myHeading = "<p>Popup Item</p>";
    $("#itemModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupBaanMpartAll') }}';
    var lookupItem = $('#lookupItem').DataTable({
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
        { data: 'item', name: 'item'},
        { data: 'desc1', name: 'desc1'},
        { data: 'itemdesc', name: 'itemdesc'},
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupItem tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupItem.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_item").value = value["item"];
            document.getElementById("nm_item").value = value["desc1"] + " (" + value["itemdesc"] + ")";
            $('#itemModal').modal('hide');
            changeItem();
          });
        });
        $('#itemModal').on('hidden.bs.modal', function () {
          var kd_item = document.getElementById("kd_item").value.trim();
          if(kd_item === "") {
            document.getElementById("kd_item").value = "";
            document.getElementById("nm_item").value = "";
            document.getElementById("kd_item").focus();
          } else {
            document.getElementById("nm_brg").focus();
          }
          changeItem();
        });
      },
    });
  }

  function validateKdItem() {
    var kd_item = document.getElementById("kd_item").value.trim();
    if(kd_item !== '') {
      if(kd_item !== "-") {
        var url = '{{ route('datatables.validasiBaanMpartAll', 'param') }}';
        url = url.replace('param', window.btoa(kd_item));
        //use ajax to run the check
        $.get(url, function(result){  
          if(result !== 'null'){
            result = JSON.parse(result);
            document.getElementById("kd_item").value = result["item"];
            document.getElementById("nm_item").value = result["desc1"] + " (" + result["itemdesc"] + ")";
          } else {
            document.getElementById("kd_item").value = "";
            document.getElementById("nm_item").value = "";
            document.getElementById("kd_item").focus();
            swal("Item tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
          }
        });
      }
    } else {
      document.getElementById("kd_item").value = "";
      document.getElementById("nm_item").value = "";
    }
    changeItem();
  }

  function popupNoDok() {
    var myHeading = "<p>Popup No. Referensi</p>";
    $("#nodokModalLabel").html(myHeading);
    var dok_ref = document.getElementById("dok_ref").value.trim();
    if(dok_ref === '') {
      dok_ref = "-";
    }
    var kd_plant = document.getElementById('kd_plant').value.trim();
    if(kd_plant === '') {
      kd_plant = "-";
    }
    var url = '{{ route('datatables.popupNoDokLbs', ['param','param2']) }}';
    url = url.replace('param2', window.btoa(kd_plant));
    url = url.replace('param', window.btoa(dok_ref));
    var lookupNoDok = $('#lookupNoDok').DataTable({
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
      "order": [[1, 'desc']],
      columns: [
        { data: 'no_dok', name: 'no_dok'},
        { data: 'tgl_dok', name: 'tgl_dok'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupNoDok tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupNoDok.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_dok").value = value["no_dok"];
            $('#nodokModal').modal('hide');
            validateNoDok();
          });
        });
        $('#nodokModal').on('hidden.bs.modal', function () {
          var no_dok = document.getElementById("no_dok").value.trim();
          if(no_dok === '') {
            $('#no_dok').focus();
          } else {
            $('#lok_pict').focus();
          }
        });
      },
    });
  }

  function validateNoDok() {
    var dok_ref = document.getElementById("dok_ref").value.trim();
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var no_dok = document.getElementById("no_dok").value.trim();
    if(dok_ref !== '' && kd_plant !== '' && no_dok !== '') {
      var url = '{{ route('datatables.validasiNoDokLb', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(no_dok));
      url = url.replace('param2', window.btoa(kd_plant));
      url = url.replace('param', window.btoa(dok_ref));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_dok").value = result["no_dok"];
          document.getElementById("lok_pict").focus();
        } else {
          document.getElementById("no_dok").value = "";
          document.getElementById("no_dok").focus();
          swal("No. Referensi tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_dok").value = "";
    }
  }
</script>
@endsection