<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('kd_cust') ? ' has-error' : '' }}">
        {!! Form::label('kd_cust', 'Kode Customer (*)') !!}
        @if (empty($cekFk)) 
          {!! Form::text('kd_cust', null, ['class'=>'form-control', 'placeholder' => 'Kode Customer', 'maxlength' => '2', 'required']) !!}  
        @else
          {!! Form::text('kd_cust', null, ['class'=>'form-control', 'placeholder' => 'Kode Customer', 'maxlength' => '2', 'required', 'readonly']) !!} 
        @endif 
        {!! $errors->first('kd_cust', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group{{ $errors->has('nm_cust') ? ' has-error' : '' }}">
        {!! Form::label('nm_cust', 'Nama Customer (*)') !!}
        {!! Form::text('nm_cust', null, ['class'=>'form-control', 'placeholder' => 'Nama Customer', 'maxlength' => '60', 'required']) !!}     
        {!! $errors->first('nm_cust', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group{{ $errors->has('kd_bpid') ? ' has-error' : '' }}">
        {!! Form::label('kd_bpid', 'Kode BPID') !!}
        {!! Form::text('kd_bpid', null, ['class'=>'form-control', 'placeholder' => 'Kode BPID', 'maxlength' => '10']) !!}     
        {!! $errors->first('kd_bpid', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group{{ $errors->has('inisial') ? ' has-error' : '' }}">
        {!! Form::label('inisial', 'Inisial') !!}
        {!! Form::text('inisial', null, ['class'=>'form-control', 'placeholder' => 'Inisial', 'maxlength' => '5']) !!}     
        {!! $errors->first('inisial', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
        {!! Form::label('alamat', 'Alamat') !!}
        {!! Form::textarea('alamat', null, ['class'=>'form-control', 'placeholder' => 'Alamat', 'maxlength' => '200', 'rows' => 4]) !!}     
        {!! $errors->first('alamat', '<p class="help-block">:message</p>') !!}
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
  @if (!empty($engtmcusts->kd_cust))
  <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('engtmcusts.index') }}">Cancel</a>
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">
  document.getElementById("kd_cust").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var nm_cust = document.getElementById("nm_cust").value.trim();
    var kd_cust = document.getElementById("kd_cust").value.trim();
    var msg = 'Anda yakin menghapus Customer: ' + nm_cust + '?';
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
      var urlRedirect = "{{ route('engtmcusts.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(kd_cust));
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
