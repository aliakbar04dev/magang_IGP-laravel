<div class="box-body">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group{{ $errors->has('thn_period') ? ' has-error' : '' }}">
        {!! Form::label('thn_period', 'Tahun Periode (*)') !!}
        @if (!empty($bgttcrrate->thn_period))
          {!! Form::text('thn_period', null, ['class'=>'form-control', 'placeholder' => 'Tahun Periode', 'readonly' => 'readonly']) !!}
        @else
          <select id="thn_period" name="thn_period" aria-controls="filter_status" 
          class="form-control select2">
            @for ($i = \Carbon\Carbon::now()->format('Y')+5; $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
              @if ($i == \Carbon\Carbon::now()->format('Y'))
                <option value={{ $i }} selected="selected">{{ $i }}</option>
              @else
                <option value={{ $i }}>{{ $i }}</option>
              @endif
            @endfor
          </select>
        @endif
        {!! $errors->first('thn_period', '<p class="help-block">:message</p>') !!}
      </div>
      <!-- /.form-group -->
      <div class="form-group{{ $errors->has('rate_mp') ? ' has-error' : '' }}">
        {!! Form::label('rate_mp', 'Rate MP (*)') !!}
        {!! Form::number('rate_mp', null, ['class'=>'form-control', 'placeholder' => 'Rate MP', 'min'=>'0', 'max'=>999999999999999999.99999, 'step'=>'any', 'required', 'style' => 'text-align:right']) !!}
        {!! $errors->first('rate_mp', '<p class="help-block">:message</p>') !!}
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
  @if (!empty($bgttcrrate->thn_period))
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('bgttcrrates.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">
  @if (!empty($bgttcrrate->thn_period))
    document.getElementById("rate_mp").focus();
  @else 
    document.getElementById("thn_period").focus();
  @endif

  $("#btn-delete").click(function(){
    var thn_period = document.getElementById("thn_period").value.trim();
    var msg = 'Anda yakin menghapus Master Rate MP Tahun Periode: ' + thn_period + '?';
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
      var urlRedirect = "{{ route('bgttcrrates.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(thn_period));
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
