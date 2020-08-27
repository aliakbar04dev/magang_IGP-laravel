<div class="box-body">
  <div class="row form-group">
    <div class="col-md-2 {{ $errors->has('kd_supp') ? ' has-error' : '' }}">
      {!! Form::label('kd_supp', 'Kode Supplier (*) (F9)') !!}
      <div class="input-group">
        {!! Form::text('kd_supp', null, ['class'=>'form-control','placeholder' => 'Kode Supplier', 'onkeydown' => 'keyPressed(event)', 'maxlength' => 10, 'required', 'onchange' => 'validateSupplier()']) !!}
        <span class="input-group-btn">
          <button id="btnpopupsupplier" type="button" class="btn btn-info" data-toggle="modal" data-target="#supplierModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('kd_supp', '<p class="help-block">:message</p>') !!}
    </div>
    <!-- /.form-group -->
    <div class="col-md-6 {{ $errors->has('nm_supp') ? ' has-error' : '' }}">
      {!! Form::label('nm_supp', 'Nama Supplier') !!}
      {!! Form::text('nm_supp', null, ['class'=>'form-control', 'placeholder' => 'Nama Supplier', 'disabled' => '']) !!}
      {!! $errors->first('nm_supp', '<p class="help-block">:message</p>') !!}
    </div>
    <!-- /.form-group -->
  </div>
  <!-- /.row -->
  <div class="row form-group">
    <div class="col-md-8 {{ $errors->has('email_1') ? ' has-error' : '' }}">
      {!! Form::label('email_1', 'Email Level 1 (*) (Pisahkan alamat email dengan koma)') !!}
      {!! Form::text('email_1', null, ['class'=>'form-control','placeholder' => 'Email Level 1', 'maxlength' => 500, 'required', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)']) !!}
      {!! $errors->first('email_1', '<p class="help-block">:message</p>') !!}
    </div>
    <!-- /.form-group -->
  </div>
  <!-- /.row -->
  <div class="row form-group">
    <div class="col-md-8 {{ $errors->has('email_2') ? ' has-error' : '' }}">
      {!! Form::label('email_2', 'Email Level 2 (*) (Pisahkan alamat email dengan koma)') !!}
      {!! Form::text('email_2', null, ['class'=>'form-control','placeholder' => 'Email Level 2', 'maxlength' => 500, 'required', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)']) !!}
      {!! $errors->first('email_2', '<p class="help-block">:message</p>') !!}
    </div>
    <!-- /.form-group -->
  </div>
  <!-- /.row -->
  <div class="row form-group">
    <div class="col-md-8 {{ $errors->has('email_3') ? ' has-error' : '' }}">
      {!! Form::label('email_3', 'Email Level 3 (*) (Pisahkan alamat email dengan koma)') !!}
      {!! Form::text('email_3', null, ['class'=>'form-control','placeholder' => 'Email Level 3', 'maxlength' => 500, 'required', 'style' => 'text-transform:lowercase', 'onchange' => 'autoLowerCase(this)']) !!}
      {!! $errors->first('email_3', '<p class="help-block">:message</p>') !!}
    </div>
    <!-- /.form-group -->
  </div>
  <!-- /.row -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('qpremails.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Supplier -->
@include('eqc.emails.popup.supplierModal')

@section('scripts')
<script type="text/javascript">
  document.getElementById("kd_supp").focus();

  function autoLowerCase(a){
    a.value = a.value.toLowerCase();
  }

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
      document.getElementById('email_1').focus();
    }
  }

  $(document).ready(function(){
    $("#btnpopupsupplier").click(function(){
      popupSupplier();
    });
  });

  function popupSupplier() {
    var myHeading = "<p>Popup Supplier</p>";
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
            document.getElementById("kd_supp").value = value["kd_supp"];
            document.getElementById("nm_supp").value = value["nama"];
            var email_1 = document.getElementById("email_1").value.trim();
            if(email_1 === '') {
              if(value["email"] != '') {
                document.getElementById("email_1").value = value["email"];
              }
            }
            $('#supplierModal').modal('hide');
            validateSupplier();
          });
        });
        $('#supplierModal').on('hidden.bs.modal', function () {
          var kd_supp = document.getElementById("kd_supp").value.trim();
          if(kd_supp === '') {
            document.getElementById("nm_supp").value = "";
            $('#kd_supp').focus();
          } else {
            document.getElementById('email_1').focus();
          }
        });
      },
    });
  }

  function validateSupplier() {
    var kd_supp = document.getElementById("kd_supp").value.trim();
    if(kd_supp !== '') {
      var url = '{{ route('datatables.validasiSupplierBaan', 'param') }}';
      url = url.replace('param', window.btoa(kd_supp));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_supp").value = result["kd_supp"];
          document.getElementById("nm_supp").value = result["nama"];
          document.getElementById('email_1').focus();
        } else {
          document.getElementById("kd_supp").value = "";
          document.getElementById("nm_supp").value = "";
          document.getElementById("kd_supp").focus();
          swal("Kode Supplier tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_supp").value = "";
      document.getElementById("nm_supp").value = "";
    }
  }
</script>
@endsection
