<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('kd_plant') ? ' has-error' : '' }}">
        {!! Form::label('kd_plant', 'Plant (*)') !!}
        <div class="input-group">
          <select id="kd_plant" name="kd_plant" class="form-control select2">
            @foreach($plants->get() as $kodePlant)
            <option value="{{$kodePlant->kd_plant}}"
              @if(!empty($engtmlines->kd_plant))  
              {{ $kodePlant->kd_plant == $engtmlines->kd_plant ? 'selected="selected"' : '' }}
              @endif
              >{{$kodePlant->nm_plant}}</option>      
              @endforeach
            </select>       
          </div>
          {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group{{ $errors->has('kd_line') ? ' has-error' : '' }}">
          {!! Form::label('kd_line', 'Kode Line (*)') !!}
          @if (empty($cekFk)) 
            {!! Form::text('kd_line', null, ['class'=>'form-control', 'placeholder' => 'Kode Line', 'maxlength' => '5', 'required']) !!} 
          @else
            {!! Form::text('kd_line', null, ['class'=>'form-control', 'placeholder' => 'Kode Line', 'maxlength' => '5', 'required', 'readonly']) !!} 
          @endif  
          {!! $errors->first('kd_line', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group{{ $errors->has('nm_line') ? ' has-error' : '' }}">
          {!! Form::label('nm_line', 'Nama Line (*)') !!}
          {!! Form::text('nm_line', null, ['class'=>'form-control', 'placeholder' => 'Nama Line', 'maxlength' => '100', 'required']) !!}     
          {!! $errors->first('nm_line', '<p class="help-block">:message</p>') !!}
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
    @if (!empty($engtmlines->kd_line))
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
    @endif
    <a class="btn btn-default" href="{{ route('engtmlines.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
  </div>

  @section('scripts')
  <script type="text/javascript">
    document.getElementById("kd_plant").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var nm_line = document.getElementById("nm_line").value.trim();
    var kd_line = document.getElementById("kd_line").value.trim();
    var msg = 'Anda yakin menghapus Line: ' + nm_line + '?';
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
      var urlRedirect = "{{ route('engtmlines.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(kd_line));
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
