<div class="box-body">
  <div class="row">    
    <div class="col-md-12">  
      <div class="form-group {{ $errors->has('nm_problem') ? ' has-error' : '' }}">
          <div class="col-md-12"> 
              {!! Form::label('nm_problem_after', 'Nama Problem (*)') !!}
              @if(!empty($usulprob))
              {!! Form::text('nm_problem_after', $usulprob->nm_problem, ['class'=>'form-control', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Nama Problem', 'maxlength' => '100', 'required']) !!} {!! $errors->first('nm_problem_after', '<p class="help-block">:message</p>') !!}
              {!! Form::hidden('nm_problem', null, ['class'=>'form-control', 'id'=>'nm_problem','oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Nama Problem', 'maxlength' => '100', 'required']) !!} {!! $errors->first('nm_problem', '<p class="help-block">:message</p>') !!}
             @else
             {!! Form::text('nm_problem', null, ['class'=>'form-control', 'id'=>'nm_problem', 'oninput'=>'let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);','placeholder' => 'Nama Problem', 'maxlength' => '100', 'required']) !!} {!! $errors->first('nm_problem', '<p class="help-block">:message</p>') !!}
              @endif
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
  @if(!empty($usulprob))
  <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  &nbsp;&nbsp;
  @endif
  <a class="btn btn-default" href="{{ route('usulprob.index') }}">Cancel</a>
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">

  //Initialize Select2 Elements
  $(".select2").select2();

  $("#btn-delete").click(function(){
    var nm_problem = document.getElementById("nm_problem").value;
    var msg = 'Anda yakin menghapus nama problem ini?: ' + nm_problem + '?';
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
      var urlRedirect = "{{ route('usulprob.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(nm_problem));
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
