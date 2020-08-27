{!! Form::hidden('no_dpr', $no_dpr, ['class'=>'form-control','placeholder' => 'No. DEPR', 'minlength' => 1, 'maxlength' => 20, 'required', 'readonly'=>'readonly', 'id' => 'no_dpr']) !!}
{!! Form::hidden('st_submit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_submit']) !!}
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active">
    <a href="#pc" aria-controls="pc" role="tab" data-toggle="tab" title="Problem Cause">
      I. Problem Cause
    </a>
  </li>
  <li role="presentation">
    <a href="#ta" aria-controls="ta" role="tab" data-toggle="tab" title="Temporary Action">
      II. Temporary Action
    </a>
  </li>
  <li role="presentation">
    <a href="#cm" aria-controls="cm" role="tab" data-toggle="tab" title="Countermeasure">
      III. Countermeasure
    </a>
  </li>
  <li role="presentation">
    <a href="#is" aria-controls="is" role="tab" data-toggle="tab" title="Improvement Suggestion">
      IV. Improvement Suggestion
    </a>
  </li>
  <li role="presentation">
    <a href="#oth" aria-controls="oth" role="tab" data-toggle="tab" title="Others">
      V. Others
    </a>
  </li>
</ul>
<!-- /.tablist -->

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="pc">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('pc_man') ? ' has-error' : '' }}">
          {!! Form::label('pc_man', 'Man (*)') !!}
          {!! Form::textarea('pc_man', null, ['class'=>'form-control', 'placeholder' => 'Man', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('pc_man', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-6 {{ $errors->has('pc_material') ? ' has-error' : '' }}">
          {!! Form::label('pc_material', 'Material (*)') !!}
          {!! Form::textarea('pc_material', null, ['class'=>'form-control', 'placeholder' => 'Material', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('pc_material', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('pc_machine') ? ' has-error' : '' }}">
          {!! Form::label('pc_machine', 'Machine (*)') !!}
          {!! Form::textarea('pc_machine', null, ['class'=>'form-control', 'placeholder' => 'Machine', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('pc_machine', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-6 {{ $errors->has('pc_metode') ? ' has-error' : '' }}">
          {!! Form::label('pc_metode', 'Methode (*)') !!}
          {!! Form::textarea('pc_metode', null, ['class'=>'form-control', 'placeholder' => 'Methode', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('pc_metode', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('pc_environ') ? ' has-error' : '' }}">
          {!! Form::label('pc_environ', 'Environment (*)') !!}
          {!! Form::textarea('pc_environ', null, ['class'=>'form-control', 'placeholder' => 'Environment', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('pc_environ', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="ta">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('ta_ket') ? ' has-error' : '' }}">
          {!! Form::label('ta_ket', 'Temporary Action (*)') !!}
          {!! Form::textarea('ta_ket', null, ['class'=>'form-control', 'placeholder' => 'Temporary Action', 'rows' => '5', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('ta_ket', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-6 {{ $errors->has('ta_pict') ? ' has-error' : '' }}">
          {!! Form::label('ta_pict', 'File Image (jpeg,png,jpg)') !!}
          {!! Form::file('ta_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($ppctdprpica->ta_pict))
            <p>
              <img src="{{ $ppctdprpica->taPict() }}" alt="File Not Found" class="img-rounded img-responsive">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('ppctdprpicas.deleteimage', [base64_encode($ppctdprpica->id), 'ta_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('ta_pict', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="cm">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('cm_ket') ? ' has-error' : '' }}">
          {!! Form::label('cm_ket', 'Countermeasure (*)') !!}
          {!! Form::textarea('cm_ket', null, ['class'=>'form-control', 'placeholder' => 'Countermeasure', 'rows' => '5', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('cm_ket', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-6 {{ $errors->has('cm_pict') ? ' has-error' : '' }}">
          {!! Form::label('cm_pict', 'File Image (jpeg,png,jpg)') !!}
          {!! Form::file('cm_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($ppctdprpica->cm_pict))
            <p>
              <img src="{{ $ppctdprpica->cmPict() }}" alt="File Not Found" class="img-rounded img-responsive">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('ppctdprpicas.deleteimage', [base64_encode($ppctdprpica->id), 'cm_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('cm_pict', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="is">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('is_man') ? ' has-error' : '' }}">
          {!! Form::label('is_man', 'Man (*)') !!}
          {!! Form::textarea('is_man', null, ['class'=>'form-control', 'placeholder' => 'Man', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('is_man', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-6 {{ $errors->has('is_material') ? ' has-error' : '' }}">
          {!! Form::label('is_material', 'Material (*)') !!}
          {!! Form::textarea('is_material', null, ['class'=>'form-control', 'placeholder' => 'Material', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('is_material', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('is_machine') ? ' has-error' : '' }}">
          {!! Form::label('is_machine', 'Machine (*)') !!}
          {!! Form::textarea('is_machine', null, ['class'=>'form-control', 'placeholder' => 'Machine', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('is_machine', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-6 {{ $errors->has('is_metode') ? ' has-error' : '' }}">
          {!! Form::label('is_metode', 'Methode (*)') !!}
          {!! Form::textarea('is_metode', null, ['class'=>'form-control', 'placeholder' => 'Methode', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('is_metode', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('is_environ') ? ' has-error' : '' }}">
          {!! Form::label('is_environ', 'Environment (*)') !!}
          {!! Form::textarea('is_environ', null, ['class'=>'form-control', 'placeholder' => 'Environment', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('is_environ', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="oth">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('rem_ket') ? ' has-error' : '' }}">
          {!! Form::label('rem_ket', 'Remarks (*)') !!}
          {!! Form::textarea('rem_ket', null, ['class'=>'form-control', 'placeholder' => 'Remarks', 'rows' => '5', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('rem_ket', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-6 {{ $errors->has('rem_pict') ? ' has-error' : '' }}">
          {!! Form::label('rem_pict', 'File Image (jpeg,png,jpg)') !!}
          {!! Form::file('rem_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($ppctdprpica->rem_pict))
            <p>
              <img src="{{ $ppctdprpica->remPict() }}" alt="File Not Found" class="img-rounded img-responsive">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('ppctdprpicas.deleteimage', [base64_encode($ppctdprpica->id), 'rem_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('rem_pict', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-6 {{ $errors->has('com_ket') ? ' has-error' : '' }}">
          {!! Form::label('com_ket', 'Comment (*)') !!}
          {!! Form::textarea('com_ket', null, ['class'=>'form-control', 'placeholder' => 'Comment', 'rows' => '5', 'maxlength' => 500, 'style' => 'resize:vertical', 'required']) !!}
          {!! $errors->first('com_ket', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
</div>
<!-- /.tab-content -->

<div class="box-footer">
  {!! Form::submit('Save as Draft', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($ppctdprpica->id))
    &nbsp;&nbsp;
    <button id="btn-submit" type="button" class="btn btn-success">Submit PICA DEPR</button>
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Delete PICA DEPR</button>
  @endif
  &nbsp;&nbsp;
  @if (empty($ppctdprpica->id))
    <a class="btn btn-primary" href="{{ route('ppctdprs.showall', base64_encode($no_dpr)) }}">Cancel</a>
  @else
    <a class="btn btn-primary" href="{{ route('ppctdprpicas.index') }}">Cancel</a>
  @endif
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong. Max size file 8 MB', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">
  document.getElementById("pc_man").focus();

  $("input[name='ta_pict']").bind('change', function() {
    let filesize = this.files[0].size // On older browsers this can return NULL.
    let filesizeMB = (filesize / (1024*1024)).toFixed(2);
    if(filesizeMB > 8) {
      var info = "Size File tidak boleh > 8 MB";
      swal(info, "Perhatikan inputan anda!", "warning");
      this.value = null;
    }
  });

  $("input[name='cm_pict']").bind('change', function() {
    let filesize = this.files[0].size // On older browsers this can return NULL.
    let filesizeMB = (filesize / (1024*1024)).toFixed(2);
    if(filesizeMB > 8) {
      var info = "Size File tidak boleh > 8 MB";
      swal(info, "Perhatikan inputan anda!", "warning");
      this.value = null;
    }
  });

  $("input[name='rem_pict']").bind('change', function() {
    let filesize = this.files[0].size // On older browsers this can return NULL.
    let filesizeMB = (filesize / (1024*1024)).toFixed(2);
    if(filesizeMB > 8) {
      var info = "Size File tidak boleh > 8 MB";
      swal(info, "Perhatikan inputan anda!", "warning");
      this.value = null;
    }
  });

  $("#btn-delete").click(function(){
    var no_dpr = document.getElementById("no_dpr").value;
    if(no_dpr !== "") {
      var msg = 'Anda yakin menghapus data ini?';
      var txt = 'No. PICA DEPR: ' + no_dpr;
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
        var urlRedirect = "{{ route('ppctdprpicas.delete', 'param') }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(no_dpr));
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
    }
  });

  $("#btn-submit").click(function(){
    var no_dpr = document.getElementById("no_dpr").value;
    if(no_dpr === "") {
      var info = "No. PICA DEPR tidak boleh kosong!";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var msg = 'Anda yakin submit data ini?';
      var txt = 'No. PICA DEPR: ' + no_dpr;
      swal({
        title: msg,
        text: txt,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, submit it!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: true,
        reverseButtons: false,
        focusCancel: true,
      }).then(function () {
        document.getElementById("st_submit").value = "T";
        document.getElementById("form_id").submit();
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
  });

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      //additional input validations can be done hear
      var no_dpr = document.getElementById("no_dpr").value;
      var msg = 'Anda yakin save data ini?';
      var txt = 'No. PICA DEPR: ' + no_dpr;
      swal({
        title: msg,
        text: txt,
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
        //document.getElementById("idtables").value = targets;
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
  });
</script>
@endsection