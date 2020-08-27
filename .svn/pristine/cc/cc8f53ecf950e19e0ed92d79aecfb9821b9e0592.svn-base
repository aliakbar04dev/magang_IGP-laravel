<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('npk') ? ' has-error' : '' }}">
        {!! Form::label('npk', 'NPK (*) (F9)') !!}
        <div class="input-group">
          {!! Form::text('npk', null, ['class'=>'form-control','placeholder' => 'NPK', 'onkeydown' => 'keyPressed(event)', 'minlength' => 5, 'maxlength' => 5, 'required', 'onchange' => 'validateKaryawan()']) !!}
          <span class="input-group-btn">
            <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
        {!! $errors->first('npk', '<p class="help-block">:message</p>') !!}
      </div>
      <!-- /.form-group -->
      <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
        {!! Form::label('nama', 'Nama') !!}
        {!! Form::text('nama', null, ['class'=>'form-control', 'placeholder' => 'Nama', 'disabled' => '']) !!}
        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
      </div>
      <!-- /.form-group -->
      <div class="form-group{{ $errors->has('bagian') ? ' has-error' : '' }}">
        {!! Form::label('bagian', 'Bagian') !!}
        {!! Form::text('bagian', null, ['class'=>'form-control', 'placeholder' => 'Bagian', 'disabled' => '']) !!}
        {!! $errors->first('bagian', '<p class="help-block">:message</p>') !!}
      </div>
      <!-- /.form-group -->
    </div>
  </div>
    <!-- /.row -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (!empty($ehsmwppic->npk))
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('ehsmwppics.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Karyawan -->
@include('ehs.wp.pic.popup.karyawanModal')

@section('scripts')
<script type="text/javascript">
  document.getElementById("npk").focus();

  $("#btn-delete").click(function(){
    var npk = document.getElementById("npk").value.trim();
    var msg = 'Anda yakin menghapus PIC Ijin Kerja: ' + npk + '?';
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
      var urlRedirect = "{{ route('ehsmwppics.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(npk));
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

  function keyPressed(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupkaryawan').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('btn-save').focus();
    }
  }

  $(document).ready(function(){
    $("#btnpopupkaryawan").click(function(){
      popupKaryawan();
    });
  });

  function popupKaryawan() {
    var myHeading = "<p>Popup Karyawan</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupKaryawanMasterPicWps') }}';
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
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
        { data: 'npk', name: 'npk'},
        { data: 'nama', name: 'nama'},
        { data: 'desc_dep', name: 'desc_dep'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKaryawan.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("npk").value = value["npk"];
            document.getElementById("nama").value = value["nama"];
            document.getElementById("bagian").value = value["desc_dep"];
            $('#karyawanModal').modal('hide');
            validateKaryawan();
          });
        });
        $('#karyawanModal').on('hidden.bs.modal', function () {
          var npk = document.getElementById("npk").value.trim();
          if(npk === '') {
            document.getElementById("nama").value = "";
            document.getElementById("bagian").value = "";
            $('#npk').focus();
          } else {
            document.getElementById('btn-save').focus();
          }
        });
      },
    });
  }

  function validateKaryawan() {
    var npk = document.getElementById('npk').value.trim();
    if(npk !== '') {
      var url = '{{ route('datatables.validasiKaryawanMasterPicWp', 'param') }}';
      url = url.replace('param', window.btoa(npk));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("npk").value = result["npk"];
          document.getElementById("nama").value = result["nama"];
          document.getElementById("bagian").value = result["desc_dep"];
          document.getElementById('btn-save').focus();
        } else {
          document.getElementById("npk").value = "";
          document.getElementById("nama").value = "";
          document.getElementById("bagian").value = "";
          document.getElementById("npk").focus();
          swal("NPK tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("npk").value = "";
      document.getElementById("nama").value = "";
      document.getElementById("bagian").value = "";
    }
  }
</script>
@endsection
