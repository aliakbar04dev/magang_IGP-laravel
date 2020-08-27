{!! Form::hidden('mode', $mode, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'mode']) !!}
{!! Form::hidden('mode_approve', "F", ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'mode_approve']) !!}

<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_dm') ? ' has-error' : '' }}">
      {!! Form::label('no_dm', 'No. DM') !!}
      {!! Form::text('no_dm2', $mtctdftmslh->no_dm, ['class'=>'form-control','placeholder' => 'No. DM', 'required', 'disabled'=>'']) !!}
      {!! Form::hidden('no_dm', null, ['class'=>'form-control','placeholder' => 'No. DM', 'required', 'readonly'=>'readonly']) !!}
      {!! $errors->first('no_dm', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_dm') ? ' has-error' : '' }}">
      {!! Form::label('tgl_dm', 'Tanggal DM (*)') !!}
      {!! Form::date('tgl_dm', \Carbon\Carbon::parse($mtctdftmslh->tgl_dm), ['class'=>'form-control','placeholder' => 'Tgl DM', 'required', 'readonly'=>'readonly']) !!}
      {!! $errors->first('tgl_dm', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('kd_plant') ? ' has-error' : '' }}">
      {!! Form::label('kd_plant', 'Plant (*)') !!}
      {!! Form::hidden('kd_plant', $mtctdftmslh->kd_plant, ['class'=>'form-control','placeholder' => 'Plant', 'required', 'id' => 'kd_plant']) !!}
      {!! Form::select('kd_plant2',  $plant->pluck('nm_plant','kd_plant')->all(), $mtctdftmslh->kd_plant, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'kd_plant2', 'disabled'=>'']) !!}
      {!! $errors->first('kd_plant', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_plan_mulai') ? ' has-error' : '' }}">
      {!! Form::label('tgl_plan_mulai', 'Tgl Plan Pengerjaan (*)') !!}
      {!! Form::date('tgl_plan_mulai', \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_mulai), ['class'=>'form-control','placeholder' => 'Tgl Plan Pengerjaan', 'required', 'readonly'=>'readonly']) !!}
      {!! Form::hidden('tgl_plan_selesai', \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('Ymd'), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_plan_selesai']) !!}
      {!! $errors->first('tgl_plan_mulai', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_plan_cms') ? ' has-error' : '' }}">
      {!! Form::label('tgl_plan_cms', 'Tgl Plan CMS (*)') !!}
      @if (empty($mtctdftmslh->tgl_plan_cms))
      {!! Form::date('tgl_plan_cms', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Plan CMS', 'required']) !!}
      {!! Form::hidden('tgl_plan_cms_temp', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_plan_cms_temp']) !!}
      @else
      {!! Form::date('tgl_plan_cms', \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_cms), ['class'=>'form-control','placeholder' => 'Tgl Plan CMS', 'required']) !!}
      {!! Form::hidden('tgl_plan_cms_temp', \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_cms)->format('Ymd'), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'tgl_plan_cms_temp']) !!}
      @endif
      {!! $errors->first('tgl_plan_cms', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_line') ? ' has-error' : '' }}">
      {!! Form::label('kd_line', 'Line (F9) (*)') !!}
      <div class="input-group">
        {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line', 'readonly' => 'readonly']) !!}
        <span class="input-group-btn">
          <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal" readonly="readonly">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('kd_line', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_line') ? ' has-error' : '' }}">
      {!! Form::label('nm_line', 'Nama Line') !!}
      {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
      {!! $errors->first('nm_line', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_mesin') ? ' has-error' : '' }}">
      {!! Form::label('kd_mesin', 'Mesin (F9) (*)') !!}
      <div class="input-group">
        {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required', 'readonly' => 'readonly']) !!}
        <span class="input-group-btn">
          <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal" readonly="readonly">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('kd_mesin', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_mesin') ? ' has-error' : '' }}">
      {!! Form::label('nm_mesin', 'Nama Mesin') !!}
      {!! Form::text('nm_mesin', null, ['class'=>'form-control','placeholder' => 'Nama Mesin', 'disabled'=>'', 'id' => 'nm_mesin']) !!}
      {!! $errors->first('nm_mesin', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-4 {{ $errors->has('ket_prob') ? ' has-error' : '' }}">
      {!! Form::label('ket_prob', 'Problem (*)') !!}
      @if (empty($mtctdftmslh->no_pi))
        {{-- @if ($mode === "PIC" || $mode === "FM")
          {!! Form::textarea('ket_prob', null, ['class'=>'form-control', 'placeholder' => 'Problem', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
        @else --}}
          {!! Form::textarea('ket_prob', null, ['class'=>'form-control', 'placeholder' => 'Problem', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
        {{-- @endif --}}
      @else
        {!! Form::textarea('ket_prob', null, ['class'=>'form-control', 'placeholder' => 'Problem', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
      @endif
      {!! $errors->first('ket_prob', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('ket_cm') ? ' has-error' : '' }}">
      @if ($mode === "PIC" || $mode === "FM")
        {!! Form::label('ket_cm', 'Counter Measure (*)') !!}
        {!! Form::textarea('ket_cm', null, ['class'=>'form-control', 'placeholder' => 'Counter Measure', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
      @else
        {!! Form::label('ket_cm', 'Counter Measure') !!}
        {!! Form::textarea('ket_cm', null, ['class'=>'form-control', 'placeholder' => 'Counter Measure', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      @endif
      {!! $errors->first('ket_cm', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('ket_sp') ? ' has-error' : '' }}">
      {!! Form::label('ket_sp', 'Spare Part') !!}
      {{-- @if ($mode === "PIC" || $mode === "FM")
        {!! Form::textarea('ket_sp', null, ['class'=>'form-control', 'placeholder' => 'Spare Part', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
      @else --}}
        {!! Form::textarea('ket_sp', null, ['class'=>'form-control', 'placeholder' => 'Spare Part', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      {{-- @endif --}}
      {!! $errors->first('ket_sp', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-4 {{ $errors->has('ket_eva_hasil') ? ' has-error' : '' }}">
      {!! Form::label('ket_eva_hasil', 'Evaluasi Hasil') !!}
      {{-- @if ($mode === "PIC" || $mode === "FM")
        {!! Form::textarea('ket_eva_hasil', null, ['class'=>'form-control', 'placeholder' => 'Evaluasi Hasil', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
      @else --}}
        {!! Form::textarea('ket_eva_hasil', null, ['class'=>'form-control', 'placeholder' => 'Evaluasi Hasil', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      {{-- @endif --}}
      {!! $errors->first('ket_eva_hasil', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('ket_remain') ? ' has-error' : '' }}">
      {!! Form::label('ket_remain', 'Remain') !!}
      {{-- @if ($mode === "PIC" || $mode === "FM")
        {!! Form::textarea('ket_remain', null, ['class'=>'form-control', 'placeholder' => 'Remain', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
      @else --}}
        {!! Form::textarea('ket_remain', null, ['class'=>'form-control', 'placeholder' => 'Remain', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      {{-- @endif --}}
      {!! $errors->first('ket_remain', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('ket_remark') ? ' has-error' : '' }}">
      {!! Form::label('ket_remark', 'Remark') !!}
      {{-- @if ($mode === "PIC" || $mode === "FM")
        {!! Form::textarea('ket_remark', null, ['class'=>'form-control', 'placeholder' => 'Remark', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
      @else --}}
        {!! Form::textarea('ket_remark', null, ['class'=>'form-control', 'placeholder' => 'Remark', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      {{-- @endif --}}
      {!! $errors->first('ket_remark', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-5 {{ $errors->has('lok_pict') ? ' has-error' : '' }}">
      {!! Form::label('lok_pict', 'Picture (jpeg,png,jpg)') !!}
      {!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png', 'disabled' => '', ]) !!}
      @if (!empty($mtctdftmslh->lok_pict))
        <p>
          <img src="{{ $mtctdftmslh->lokPict() }}" alt="File Not Found" class="img-rounded img-responsive">
        </p>
      @endif
      {!! $errors->first('lok_pict', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save CMS', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('mtctdftmslhs.indexcms') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong. Max size file 8 MB', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">

  document.getElementById("tgl_plan_cms").focus();

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      var valid = "T";
      var msg = "";

      var tgl_plan_cms = document.getElementById("tgl_plan_cms").value;
      var date_tgl_plan = new Date(tgl_plan_cms);
      var date_now = new Date();

      var tahun_plan = date_tgl_plan.getFullYear();
      var bulan_plan = date_tgl_plan.getMonth() + 1;
      if(bulan_plan < 10) {
        bulan_plan = "0" + bulan_plan;
      }
      var tgl_plan = date_tgl_plan.getDate();
      if(tgl_plan < 10) {
        tgl_plan = "0" + tgl_plan;
      }
      var tanggal_plan = tahun_plan + "" + bulan_plan + "" + tgl_plan;

      var tahun_now = date_now.getFullYear();
      var bulan_now = date_now.getMonth() + 1;
      if(bulan_now < 10) {
        bulan_now = "0" + bulan_now;
      }
      var tgl_now = date_now.getDate();
      if(tgl_now < 10) {
        tgl_now = "0" + tgl_now;
      }
      var tanggal_now = tahun_now + "" + bulan_now + "" + tgl_now;
      var tanggal_saatini = tgl_now + "-" + bulan_now + "-" + tahun_now;

      if(tanggal_plan <= tanggal_now) {
        var tgl_plan_cms_temp = document.getElementById("tgl_plan_cms_temp").value;
        if(tanggal_plan != tgl_plan_cms_temp) {
          valid = "F";
          msg = "Tgl Plan CMS harus > Tanggal saat ini (" + tanggal_saatini + ")!";
        }
      }

      if(valid !== "T") {
        var info = msg;
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
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

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      // $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('kd_mesin').focus();
    }
  }

  function keyPressedKdMesin(e) {
    if(e.keyCode == 120) { //F9
      // $('#btnpopupmesin').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('ket_prob').focus();
    }
  }
</script>
@endsection
