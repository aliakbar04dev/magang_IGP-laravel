<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('kd_bpid') ? ' has-error' : '' }}">
        {!! Form::label('kd_bpid', 'BPID (*) (F9)') !!}
        <div class="input-group">
          @if (empty($prctepobpid->kd_bpid))
            {!! Form::text('kd_bpid', null, ['class'=>'form-control','placeholder' => 'BPID', 'onkeydown' => 'keyPressed(event)', 'required', 'onchange' => 'validateSupplier()']) !!}
            <span class="input-group-btn">
              <button id="btnpopupsupplier" type="button" class="btn btn-info" data-toggle="modal" data-target="#supplierModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @else
            {!! Form::text('kd_bpid', null, ['class'=>'form-control','placeholder' => 'BPID', 'onkeydown' => 'keyPressed(event)', 'required', 'onchange' => 'validateSupplier()', 'readonly'=>'readonly']) !!}
            <span class="input-group-btn">
              <button id="btnpopupsupplier" type="button" class="btn btn-info" data-toggle="modal" data-target="#supplierModal" disabled="">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @endif
        </div>
        {!! $errors->first('kd_bpid', '<p class="help-block">:message</p>') !!}
      </div>
      <!-- /.form-group -->
      <div class="form-group{{ $errors->has('nm_bpid') ? ' has-error' : '' }}">
        {!! Form::label('nm_bpid', 'Nama BPID') !!}
        {!! Form::text('nm_bpid', null, ['class'=>'form-control', 'placeholder' => 'Nama BPID', 'disabled' => '']) !!}
        {!! $errors->first('nm_bpid', '<p class="help-block">:message</p>') !!}
      </div>
      <!-- /.form-group -->
      <div class="form-group{{ $errors->has('kd_oth') ? ' has-error' : '' }}">
        {!! Form::label('kd_oth', 'BPID Others (*)') !!}
        @if (empty($prctepobpid->kd_bpid))
          {!! Form::select('kd_oth[]', \DB::table("b_suppliers")->selectRaw("kd_supp, nama||' - '||kd_supp nama")->whereRaw("length(kd_supp) > 6")->orderBy('nama')->pluck('nama','kd_supp')->all(), null, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih BPID Others', 'required', 'id' => 'kd_oth']) !!}
        @else
        {!! Form::select('kd_oth[]', \DB::table("b_suppliers")->selectRaw("kd_supp, nama||' - '||kd_supp nama")->whereRaw("length(kd_supp) > 6")->orderBy('nama')->pluck('nama','kd_supp')->all(), $suppliers, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih BPID Others', 'required', 'id' => 'kd_oth']) !!}
        @endif
        {!! $errors->first('kd_oth', '<p class="help-block">:message</p>') !!}
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
  @if (!empty($prctepobpid->kd_bpid))
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('prctepobpids.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Supplier -->
@include('eproc.rfq.popup.supplierModal')

@section('scripts')
<script type="text/javascript">
  document.getElementById("kd_bpid").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var kd_bpid = document.getElementById("kd_bpid").value.trim();
    var msg = 'Anda yakin menghapus BPID: ' + kd_bpid + '?';
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
      var urlRedirect = "{{ route('prctepobpids.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(kd_bpid));
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
      $('#btnpopupsupplier').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('kd_oth').focus();
    }
  }

  $(document).ready(function(){
    $("#btnpopupsupplier").click(function(){
      popupSupplier();
    });
  });

  function popupSupplier() {
    var myHeading = "<p>Popup BPID</p>";
    $("#supplierModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupSupplierBaans') }}';
    var lookupSupplier = $('#lookupSupplier').DataTable({
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
        { data: 'kd_supp', name: 'kd_supp'},
        { data: 'nama', name: 'nama'},
        { data: 'email', name: 'email'},
        { data: 'init_supp', name: 'init_supp'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupSupplier tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupSupplier.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_bpid").value = value["kd_supp"];
            document.getElementById("nm_bpid").value = value["nama"];
            $('#supplierModal').modal('hide');
            validateSupplier();
          });
        });
        $('#supplierModal').on('hidden.bs.modal', function () {
          var kd_bpid = document.getElementById("kd_bpid").value.trim();
          if(kd_bpid === '') {
            document.getElementById("nm_bpid").value = "";
            $('#kd_bpid').focus();
          } else {
            document.getElementById('kd_oth').focus();
          }
        });
      },
    });
  }

  function validateSupplier() {
    var kd_bpid = document.getElementById('kd_bpid').value.trim();
    if(kd_bpid !== '') {
      var url = '{{ route('datatables.validasiSupplierBaan', 'param') }}';
      url = url.replace('param', window.btoa(kd_bpid));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_bpid").value = result["kd_supp"];
          document.getElementById("nm_bpid").value = result["nama"];
          document.getElementById('kd_oth').focus();
        } else {
          document.getElementById("kd_bpid").value = "";
          document.getElementById("nm_bpid").value = "";
          document.getElementById("kd_bpid").focus();
          swal("BPID tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_bpid").value = "";
      document.getElementById("nm_bpid").value = "";
    }
  }
</script>
@endsection
