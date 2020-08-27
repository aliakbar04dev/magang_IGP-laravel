<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('kd_site') ? ' has-error' : '' }}">
        {!! Form::label('kd_site', 'Site (*)') !!}
        {!! Form::select('kd_site', ['IGPJ' => 'IGP Plant Jakarta', 'IGPK' => 'IGP Plant Karawang'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Site', 'id' => 'kd_site', 'required']) !!}
        {!! $errors->first('kd_site', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group{{ $errors->has('kd_plant') ? ' has-error' : '' }}">
        {!! Form::label('kd_plant', 'Kode Plant (*)') !!}
        @if(empty($cekFk))
        {!! Form::text('kd_plant', null, ['class'=>'form-control', 'placeholder' => 'Kode Plant', 'maxlength' => '1', 'required']) !!} 
        @else
        {!! Form::text('kd_plant', null, ['class'=>'form-control', 'placeholder' => 'Kode Plant', 'maxlength' => '1', 'required', 'readonly']) !!} 
        @endif
        {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group{{ $errors->has('nm_plant') ? ' has-error' : '' }}">
        {!! Form::label('nm_plant', 'Nama Plant (*)') !!}
        {!! Form::text('nm_plant', null, ['class'=>'form-control', 'placeholder' => 'Nama Plant', 'maxlength' => '50', 'required']) !!}     
        {!! $errors->first('nm_plant', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group{{ $errors->has('st_aktif') ? ' has-error' : '' }}">
        {!! Form::label('st_aktif', 'Status Aktif (*)') !!}
        {!! Form::select('st_aktif', ['T' => 'Aktif', 'F' => 'Non Aktif'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'id' => 'st_aktif', 'required']) !!}
        {!! $errors->first('st_aktif', '<p class="help-block">:message</p>') !!}
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
  @if (!empty($engtmplants->kd_plant))
  <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('engtmplants.index') }}">Cancel</a>
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">
  document.getElementById("kd_site").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var nm_plant = document.getElementById("nm_plant").value.trim();
    var kd_plant = document.getElementById("kd_plant").value.trim();
    var msg = 'Anda yakin menghapus Plant: ' + nm_plant + '?';
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
      var urlRedirect = "{{ route('engtmplants.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(kd_plant));
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
</script>
@endsection
