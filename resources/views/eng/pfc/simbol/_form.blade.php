<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('ket') ? ' has-error' : '' }}">
        {!! Form::label('ket', 'Keterangan (*)') !!}
        {!! Form::text('ket', null, ['class'=>'form-control', 'placeholder' => 'Keterangan', 'maxlength' => '50', 'required']) !!}
        @if (!empty($engtmsimbol->id))
          {!! Form::hidden('id', base64_encode($engtmsimbol->id), ['class'=>'form-control','readonly'=>'readonly', 'id' => 'id']) !!}
        @endif
        {!! $errors->first('ket', '<p class="help-block">:message</p>') !!}
      </div>
      <!-- /.form-group -->
      <div class="form-group{{ $errors->has('lokfile') ? ' has-error' : '' }}">
        {!! Form::label('lokfile', 'File (jpeg,png,jpg)') !!}
          {!! Form::file('lokfile', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($lokfile))
            <p>
              <img src="{{ $lokfile }}" alt="File Not Found" class="img-rounded img-responsive">
            </p>
          @endif
          {!! $errors->first('lokfile', '<p class="help-block">:message</p>') !!}
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
  @if (!empty($engtmsimbol->id))
    @if ($engtmsimbol->cek != "T")
      <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
      &nbsp;&nbsp;
    @endif
  @endif
  <a class="btn btn-default" href="{{ route('engtmsimbols.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">
  document.getElementById("ket").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var ket = document.getElementById("ket").value.trim();
    var id = document.getElementById("id").value.trim();
    var msg = 'Anda yakin menghapus Simbol: ' + ket + '?';
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
      var urlRedirect = "{{ route('engtmsimbols.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', id);
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
