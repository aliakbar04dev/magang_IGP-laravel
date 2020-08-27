<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('nm_kategori') ? ' has-error' : '' }}">
        {!! Form::label('nm_kategori', 'Kategori (*)') !!}
        @if (!empty($bgttcrkategor->nm_kategori))
          {!! Form::text('nm_kategori', null, ['class'=>'form-control', 'placeholder' => 'Nama', 'style' => 'text-transform:uppercase', 'required', 'readonly' => 'readonly', 'maxlength' => 30]) !!}
        @else
          {!! Form::text('nm_kategori', null, ['class'=>'form-control', 'placeholder' => 'Nama', 'style' => 'text-transform:uppercase', 'required', 'maxlength' => 30]) !!}
        @endif
        {!! $errors->first('nm_kategori', '<p class="help-block">:message</p>') !!}
      </div>
      <!-- /.form-group -->
      <div class="form-group{{ $errors->has('nm_klasifikasi') ? ' has-error' : '' }}">
        {!! Form::label('nm_klasifikasi', 'Klasifikasi (*)') !!}
        @if (empty($bgttcrkategor->nm_kategori))
          {!! Form::select('nm_klasifikasi[]', App\BgttCrKlasifi::where('st_aktif', 'T')->orderBy('nm_klasifikasi')->pluck('nm_klasifikasi','nm_klasifikasi')->all(), null, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Klasifikasi', 'required', 'id' => 'nm_klasifikasi']) !!}
        @else
          {!! Form::select('nm_klasifikasi[]', App\BgttCrKlasifi::where('st_aktif', 'T')->orderBy('nm_klasifikasi')->pluck('nm_klasifikasi','nm_klasifikasi')->all(), $nm_klasifikasis, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Klasifikasi', 'required', 'id' => 'nm_klasifikasi']) !!}
        @endif
        {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
      </div>
      <!-- /.form-group -->
      <div class="form-group{{ $errors->has('st_aktif') ? ' has-error' : '' }}">
        {!! Form::label('st_aktif', 'Aktif (*)') !!}
        {!! Form::select('st_aktif', ['T' => 'YA', 'F' => 'TIDAK'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status Aktif', 'required']) !!}
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
  @if (!empty($bgttcrkategor->nm_kategori))
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('bgttcrkategors.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">
  document.getElementById("nm_kategori").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var nm_kategori = document.getElementById("nm_kategori").value.trim();
    var msg = 'Anda yakin menghapus Kategori: ' + nm_kategori + '?';
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
      var urlRedirect = "{{ route('bgttcrkategors.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(nm_kategori));
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
