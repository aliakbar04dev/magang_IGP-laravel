<div class="box-body">
  <div class="row">    
    <div class="col-md-6">  
      <div class="form-group {{ $errors->has('no_ic') ? ' has-error' : '' }}">
          <div class="col-md-4"> 
              {!! Form::hidden('no_ic', null, ['class'=>'form-control', "id"=>"no_ic",'placeholder' => 'Kode Item Pengecekan', 'maxlength' => '20', 'required','readonly']) !!} {!! $errors->first('no_ic', '<p class="help-block">:message</p>') !!}
          </div>
      </div>
      @if(!empty($kdItemCek))
      <div class="form-group {{ $errors->has('nm_ic') ? ' has-error' : '' }}">
        <div class="col-md-8"> 
          {!! Form::label('nm_ic', 'Nama Item (*)') !!}
          {!! Form::text('nm_ic', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Nama Item', 'maxlength' => '50', 'required','readonly']) !!} {!! $errors->first('nm_masicheck', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      @else
      <div class="form-group {{ $errors->has('nm_ic') ? ' has-error' : '' }}">
        <div class="col-md-8"> 
          {!! Form::label('nm_ic', 'Nama Item (*)') !!}
          {!! Form::text('nm_ic', null, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Nama Item', 'maxlength' => '50', 'required']) !!} {!! $errors->first('nm_masicheck', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      @endif
      
      <div class="form-group {{ $errors->has('st_aktif') ? ' has-error' : '' }}"> 
        <div class="col-md-4">         
          {!! Form::label('st_aktif', 'Status Aktif (*)') !!}
          {!! Form::select('st_aktif', ['T' => 'Aktif', 'F' => 'Non Aktif'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'id' => 'st_aktif', 'required']) !!}
          {!! $errors->first('st_aktif', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.row -->
</div>

<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  @if (empty($kdItemCek) && !empty($mtcmasicheck->no_ic))
  <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('mtcmasicheck.index') }}">Cancel</a>
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@include('mtc.masicheck.popup.lineModal')
@section('scripts')
<script type="text/javascript">
  // document.getElementById("no_ic").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var no_ic = document.getElementById("no_ic").value.trim();
    var msg = 'Anda yakin menghapus Item Pengecekan ini: ' + no_ic + '?';
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
      var urlRedirect = "{{ route('mtcmasicheck.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_ic));
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
