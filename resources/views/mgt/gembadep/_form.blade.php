{!! Form::hidden('mode_cm', $mode_cm, ['class'=>'form-control','placeholder' => 'Mode', 'required', 'readonly'=>'readonly', 'id' => 'mode_cm']) !!}
<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_gemba') ? ' has-error' : '' }}">
      {!! Form::label('no_gemba', 'No. Gemba') !!}
      @if ($mode_cm === "T")
        {!! Form::text('no_gemba', null, ['class'=>'form-control','placeholder' => 'No. Genba', 'disabled'=>'']) !!}
      @else 
        @if (empty($mgmtgembadep->no_gemba))
          {!! Form::text('no_gemba', null, ['class'=>'form-control','placeholder' => 'No. Genba', 'disabled'=>'']) !!}
        @else
          {!! Form::text('no_gemba2', $mgmtgembadep->no_gemba, ['class'=>'form-control','placeholder' => 'No. Gemba', 'required', 'disabled'=>'']) !!}
          {!! Form::hidden('no_gemba', null, ['class'=>'form-control','placeholder' => 'No. Genba', 'required', 'readonly'=>'readonly']) !!}
        @endif
      @endif
      {!! $errors->first('no_gemba', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_gemba') ? ' has-error' : '' }}">
      {!! Form::label('tgl_gemba', 'Tanggal Genba (*)') !!}
      @if ($mode_cm === "T")
        {!! Form::date('tgl_gemba', \Carbon\Carbon::parse($mgmtgembadep->tgl_gemba), ['class'=>'form-control','placeholder' => 'Tgl Genba', 'required', 'readonly'=>'readonly']) !!}
      @else 
        @if (empty($mgmtgembadep->tgl_gemba))
          {!! Form::date('tgl_gemba', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Genba', 'required']) !!}
        @else
          {!! Form::date('tgl_gemba', \Carbon\Carbon::parse($mgmtgembadep->tgl_gemba), ['class'=>'form-control','placeholder' => 'Tgl Genba', 'required', 'readonly'=>'readonly']) !!}
        @endif
      @endif
      {!! $errors->first('tgl_gemba', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-5 {{ $errors->has('kd_site') ? ' has-error' : '' }}">
      {!! Form::label('kd_site', 'Site (*)') !!}
      @if ($mode_cm === "T")
        {!! Form::text('nm_site', null, ['class'=>'form-control','placeholder' => 'Site', 'disabled'=>'', 'id' => 'nm_site']) !!}
        {!! Form::hidden('kd_site', null, ['class'=>'form-control','placeholder' => 'Kode Site', 'required', 'id' => 'kd_site', 'readonly'=>'readonly']) !!}
      @else 
        @if (!empty($mgmtgembadep->kd_site))
          @if (Auth::user()->can('mgt-gembadep-site'))
            {!! Form::select('kd_site', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], null, ['class'=>'form-control select2', 'onchange' => 'changeKdSite()', 'id' => 'kd_site']) !!}
          @else 
            {!! Form::select('kd_site2', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], $mgmtgembadep->kd_site, ['class'=>'form-control select2', 'onchange' => 'changeKdSite()', 'id' => 'kd_site2', 'disabled' => '']) !!}
            {!! Form::hidden('kd_site', $mgmtgembadep->kd_site, ['class'=>'form-control','placeholder' => 'Kode Site', 'required', 'id' => 'kd_site', 'readonly'=>'readonly']) !!}
          @endif
        @else 
          @if (Auth::user()->can('mgt-gembadep-site'))
            {!! Form::select('kd_site', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], null, ['class'=>'form-control select2', 'onchange' => 'changeKdSite()', 'id' => 'kd_site']) !!}
          @else 
            {!! Form::select('kd_site2', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], Auth::user()->masKaryawan()->kode_site, ['class'=>'form-control select2', 'onchange' => 'changeKdSite()', 'id' => 'kd_site2', 'disabled' => '']) !!}
            {!! Form::hidden('kd_site', Auth::user()->masKaryawan()->kode_site, ['class'=>'form-control','placeholder' => 'Kode Site', 'required', 'id' => 'kd_site', 'readonly'=>'readonly']) !!}
          @endif
        @endif
      @endif
      {!! $errors->first('kd_site', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-5 {{ $errors->has('pict_gemba') ? ' has-error' : '' }}">
      {!! Form::label('pict_gemba', 'Picture (jpeg,png,jpg)') !!}
      @if ($mode_cm === "T")
        @if (!empty($mgmtgembadep->pict_gemba))
          <p>
            <img src="{{ $mgmtgembadep->pictGemba() }}" alt="File Not Found" class="img-rounded img-responsive" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100px;">
          </p>
        @endif
      @else 
        {!! Form::file('pict_gemba', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
        @if (!empty($mgmtgembadep->pict_gemba))
          <p>
            <img src="{{ $mgmtgembadep->pictGemba() }}" alt="File Not Found" class="img-rounded img-responsive" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100px;">
            <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('mgmtgembadeps.deleteimage', [base64_encode($mgmtgembadep->no_gemba), base64_encode("GEMBA")]) }}"><span class="glyphicon glyphicon-remove"></span></a>
          </p>
        @endif
      @endif
      {!! $errors->first('pict_gemba', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-5 {{ $errors->has('det_gemba') ? ' has-error' : '' }}">
      {!! Form::label('det_gemba', 'Detail Genba (*)') !!}
      @if ($mode_cm === "T")
        {!! Form::textarea('det_gemba', null, ['class'=>'form-control', 'placeholder' => 'Detail Genba', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required', 'readonly' => 'readonly']) !!}
      @else 
        {!! Form::textarea('det_gemba', null, ['class'=>'form-control', 'placeholder' => 'Detail Genba', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'required']) !!}
      @endif
      {!! $errors->first('det_gemba', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-2 {{ $errors->has('kd_area') ? ' has-error' : '' }}">
      {!! Form::label('kd_area', 'Area Genba (*)') !!}
      @if ($mode_cm === "T")
        {!! Form::text('kd_area', null, ['class'=>'form-control','placeholder' => 'Area Genba', 'readonly'=> 'readonly', 'id' => 'kd_area']) !!}
      @else 
        @if (!empty($mgmtgembadep->kd_site))
          @if ($mgmtgembadep->kd_site === "IGPJ")
            {!! Form::select('kd_area', ['IGP-1' => 'IGP-1', 'IGP-2' => 'IGP-2', 'IGP-2,5' => 'IGP-2,5', 'IGP-3' => 'IGP-3', 'IGP-3,5' => 'IGP-3,5', 'IGP-4' => 'IGP-4', 'OTHERS' => 'OTHERS'], null, ['class'=>'form-control select2', 'placeholder' => 'Pilih Area Genba', 'required']) !!}
          @else 
            {!! Form::select('kd_area', ['KIM-1A' => 'KIM-1A', 'KIM-1B' => 'KIM-1B', 'OTHERS' => 'OTHERS'], null, ['class'=>'form-control select2', 'placeholder' => 'Pilih Area Genba', 'required']) !!}
          @endif
        @else 
          @if (Auth::user()->masKaryawan()->kode_site === "IGPJ")
            {!! Form::select('kd_area', ['IGP-1' => 'IGP-1', 'IGP-2' => 'IGP-2', 'IGP-2,5' => 'IGP-2,5', 'IGP-3' => 'IGP-3', 'IGP-3,5' => 'IGP-3,5', 'IGP-4' => 'IGP-4', 'OTHERS' => 'OTHERS'], null, ['class'=>'form-control select2', 'placeholder' => 'Pilih Area Genba', 'required']) !!}
          @else 
            {!! Form::select('kd_area', ['KIM-1A' => 'KIM-1A', 'KIM-1B' => 'KIM-1B', 'OTHERS' => 'OTHERS'], null, ['class'=>'form-control select2', 'placeholder' => 'Pilih Area Genba', 'required']) !!}
          @endif
        @endif
      @endif
      {!! $errors->first('kd_area', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('lokasi') ? ' has-error' : '' }}">
      {!! Form::label('lokasi', 'Lokasi Genba') !!}
      @if ($mode_cm === "T")
        {!! Form::text('lokasi', null, ['class'=>'form-control', 'placeholder' => 'Lokasi Genba', 'maxlength' => '50', 'readonly'=> 'readonly']) !!}
      @else 
        {!! Form::text('lokasi', null, ['class'=>'form-control', 'placeholder' => 'Lokasi Genba', 'maxlength' => '50']) !!}
      @endif
      {!! $errors->first('lokasi', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-5 {{ $errors->has('npk_pic') ? ' has-error' : '' }}">
      {!! Form::label('npk_pic', 'PIC Genba (*)') !!}
      @if ($mode_cm === "T")
        {!! Form::text('nm_pic', $mgmtgembadep->npk_pic." - ".$mgmtgembadep->nm_pic, ['class'=>'form-control','placeholder' => 'PIC Genba', 'disabled'=>'', 'id' => 'nm_pic']) !!}
        {!! Form::hidden('npk_pic', null, ['class'=>'form-control','placeholder' => 'PIC Genba', 'required', 'id' => 'npk_pic', 'readonly'=>'readonly']) !!}
      @else 
        @if (!empty($mgmtgembadep->kd_site))
          @if ($mgmtgembadep->kd_site === "IGPJ")
            {!! Form::select('npk_pic', \DB::table("mgmt_pics")->selectRaw("npk, npk||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_pics.npk limit 1),'-') nm_pic")->where('st_aktif', 'T')->where('st_dep', 'T')->where('kd_site', 'IGPJ')->orderBy('npk')->pluck('nm_pic','npk')->all(), null, ['class'=>'form-control select2', 'placeholder' => 'Pilih PIC Genba', 'onchange' => 'changePic()', 'required']) !!}
          @else 
            {!! Form::select('npk_pic', \DB::table("mgmt_pics")->selectRaw("npk, npk||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_pics.npk limit 1),'-') nm_pic")->where('st_aktif', 'T')->where('st_dep', 'T')->where('kd_site', 'IGPK')->orderBy('npk')->pluck('nm_pic','npk')->all(), null, ['class'=>'form-control select2', 'placeholder' => 'Pilih PIC Genba', 'onchange' => 'changePic()', 'required']) !!}
          @endif
        @else 
          @if (Auth::user()->masKaryawan()->kode_site === "IGPJ")
            {!! Form::select('npk_pic', \DB::table("mgmt_pics")->selectRaw("npk, npk||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_pics.npk limit 1),'-') nm_pic")->where('st_aktif', 'T')->where('st_dep', 'T')->where('kd_site', 'IGPJ')->orderBy('npk')->pluck('nm_pic','npk')->all(), null, ['class'=>'form-control select2', 'placeholder' => 'Pilih PIC Genba', 'onchange' => 'changePic()', 'required']) !!}
          @else 
            {!! Form::select('npk_pic', \DB::table("mgmt_pics")->selectRaw("npk, npk||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_pics.npk limit 1),'-') nm_pic")->where('st_aktif', 'T')->where('st_dep', 'T')->where('kd_site', 'IGPK')->orderBy('npk')->pluck('nm_pic','npk')->all(), null, ['class'=>'form-control select2', 'placeholder' => 'Pilih PIC Genba', 'onchange' => 'changePic()', 'required']) !!}
          @endif
        @endif
      @endif
      {!! $errors->first('npk_pic', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-2 {{ $errors->has('npk_pic_sub') ? ' has-error' : '' }}">
      {!! Form::label('npk_pic_sub', 'Sub PIC (F9)') !!}
      <div class="input-group">
        @if (!empty($mgmtgembadep->no_gemba))
          @if ($mode_cm === "T" && $mgmtgembadep->npk_pic !== Auth::user()->username)
            {!! Form::text('npk_pic_sub', null, ['class'=>'form-control','placeholder' => 'Sub PIC', 'onkeydown' => 'keyPressed(event)', 'onchange' => 'validateSubPic()', 'readonly'=>'readonly']) !!}
            <span class="input-group-btn">
              <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal" disabled="">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @else 
            {!! Form::text('npk_pic_sub', null, ['class'=>'form-control','placeholder' => 'Sub PIC', 'onkeydown' => 'keyPressed(event)', 'onchange' => 'validateSubPic()']) !!}
            <span class="input-group-btn">
              <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @endif
        @else 
          {!! Form::text('npk_pic_sub', null, ['class'=>'form-control','placeholder' => 'Sub PIC', 'onkeydown' => 'keyPressed(event)', 'onchange' => 'validateSubPic()']) !!}
          <span class="input-group-btn">
            <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
      </div>
      {!! $errors->first('npk_pic_sub', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('nm_pic_sub') ? ' has-error' : '' }}">
      {!! Form::label('nm_pic_sub', 'Nama Sub PIC') !!}
      {!! Form::text('nm_pic_sub', null, ['class'=>'form-control', 'placeholder' => 'Nama Sub PIC', 'disabled' => '']) !!}
      {!! $errors->first('nm_pic_sub', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  @if (!empty($mgmtgembadep->no_gemba))
    @if ($mode_cm === "T")
      <div class="form-group">
        <div class="col-sm-5 {{ $errors->has('cm_ket') ? ' has-error' : '' }}">
          {!! Form::label('cm_ket', 'Countermeasure (*)') !!}
          {!! Form::textarea('cm_ket', null, ['class'=>'form-control', 'placeholder' => 'Countermeasure', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
          {!! $errors->first('cm_ket', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-5 {{ $errors->has('cm_pict') ? ' has-error' : '' }}">
          {!! Form::label('cm_pict', 'CM Picture (jpeg,png,jpg)') !!}
          {!! Form::file('cm_pict', ['class'=>'form-control', 'style' => 'resize:vertical','required', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($mgmtgembadep->cm_pict))
            <p>
              <img src="{{ $mgmtgembadep->cmPict() }}" alt="File Not Found" class="img-rounded img-responsive" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100px;">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('mgmtgembadeps.deleteimage', [base64_encode($mgmtgembadep->no_gemba), base64_encode("CM")]) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('cm_pict', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    @else 
      <div class="form-group">
        <div class="col-sm-5 {{ $errors->has('cm_ket') ? ' has-error' : '' }}">
          {!! Form::label('cm_ket', 'Countermeasure') !!}
          {!! Form::textarea('cm_ket', null, ['class'=>'form-control', 'placeholder' => 'Countermeasure', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical', 'readonly' => 'readonly']) !!}
          {!! $errors->first('cm_ket', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-5 {{ $errors->has('cm_pict') ? ' has-error' : '' }}">
          {!! Form::label('cm_pict', 'CM Picture (jpeg,png,jpg)') !!}
          @if (!empty($mgmtgembadep->cm_pict))
            <p>
              <img src="{{ $mgmtgembadep->cmPict() }}" alt="File Not Found" class="img-rounded img-responsive" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100px;">
            </p>
          @endif
          {!! $errors->first('cm_pict', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-2 {{ $errors->has('st_gemba') ? ' has-error' : '' }}">
          {!! Form::label('st_gemba', 'Status Close') !!}
          {!! Form::select('st_gemba', ['F' => 'NO', 'T' => 'YES'], null, ['class'=>'form-control select2']) !!}
          {!! $errors->first('st_gemba', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    @endif
  @endif
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save Genba DEP', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($mgmtgembadep->no_gemba) && $mode_cm === "F")
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
    &nbsp;&nbsp;
    <a class="btn btn-success" href="{{ route('mgmtgembadeps.create') }}">
      <span class="fa fa-plus"></span> Add Genba DEP
    </a>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('mgmtgembadeps.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong. Max size file 8 MB', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Karyawan -->
@include('mgt.popup.karyawanModal')

@section('scripts')
<script type="text/javascript">

  var mode_cm = "{{ $mode_cm }}";

  if(mode_cm === "T") {
    document.getElementById("cm_ket").focus();
  } else {
    document.getElementById("tgl_gemba").focus();
  }

  //Initialize Select2 Elements
  $(".select2").select2();

  function changeKdSite() {
    var kd_site = document.getElementById("kd_site").value;
    $('#kd_area').children('option').remove();
    $('#npk_pic').children('option').remove();
    $('#kd_area').append('<option value="">Pilih Area Genba</option>');
    $("#npk_pic").append('<option value="">Pilih PIC Genba</option>');
    if(kd_site === "IGPK") {
      $("#kd_area").append('<option value="KIM-1A">KIM-1A</option>');
      $("#kd_area").append('<option value="KIM-1B">KIM-1B</option>');
      @foreach(\DB::table("mgmt_pics")->selectRaw("npk, npk||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_pics.npk limit 1),'-') nm_pic")->where('st_aktif', 'T')->where('st_dep', 'T')->where('kd_site', 'IGPK')->orderBy('npk')->get() as $mgmt_pic)  
        $("#npk_pic").append('<option value="{{ $mgmt_pic->npk }}">{{ $mgmt_pic->nm_pic }}</option>');
      @endforeach
    } else if(kd_site === "IGPJ") {
      $("#kd_area").append('<option value="IGP-1">IGP-1</option>');
      $("#kd_area").append('<option value="IGP-2">IGP-2</option>');
      $("#kd_area").append('<option value="IGP-2,5">IGP-2,5</option>');
      $("#kd_area").append('<option value="IGP-3">IGP-3</option>');
      $("#kd_area").append('<option value="IGP-3,5">IGP-3,5</option>');
      $("#kd_area").append('<option value="IGP-4">IGP-4</option>');
      @foreach(\DB::table("mgmt_pics")->selectRaw("npk, npk||' - '||coalesce((select v.nama from v_mas_karyawan v where v.npk = mgmt_pics.npk limit 1),'-') nm_pic")->where('st_aktif', 'T')->where('st_dep', 'T')->where('kd_site', 'IGPJ')->orderBy('npk')->get() as $mgmt_pic)  
        $("#npk_pic").append('<option value="{{ $mgmt_pic->npk }}">{{ $mgmt_pic->nm_pic }}</option>');
      @endforeach
    }
    $("#kd_area").append('<option value="OTHERS">OTHERS</option>');
    //$('#kd_area').append(new Option('IGP 1', '1', false, false));
    //$("#kd_area").empty();
    changePic();
  }

  function changePic() {
    validateSubPic();
  }

  $("#btn-delete").click(function(){
    var no_gemba = document.getElementById("no_gemba").value.trim();
    var msg = 'Anda yakin menghapus No. Genba: ' + no_gemba + '?';
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
      var urlRedirect = "{{ route('mgmtgembadeps.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_gemba));
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
      var valid = "T";
      var msg = "";

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

  function keyPressed(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupkaryawan').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      if(mode_cm === "T") {
        document.getElementById('cm_ket').focus();
      } else {
        document.getElementById("btn-save").focus();
      }
    }
  }

  $(document).ready(function(){
    $("#btnpopupkaryawan").click(function(){
      popupKaryawan();
    });
  });

  function popupKaryawan() {
    var myHeading = "<p>Popup Karyawan</p>";
    $("#karyawanModalLabel").html(myHeading);
    var npk_pic = document.getElementById('npk_pic').value.trim();
    if(npk_pic == "") {
      npk_pic = "-";
    }
    var url = '{{ route('datatables.popupKaryawanGenbaDeps', 'param') }}';
    url = url.replace('param', window.btoa(npk_pic));
    var lookupKaryawan = $('#lookupKaryawan').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      // "scrollX": true,
      // "scrollY": "500px",
      // "scrollCollapse": true,
      "order": [[1, 'asc']],
      columns: [
        { data: 'npk', name: 'npk'},
        { data: 'nama', name: 'nama'},
        { data: 'desc_dep', name: 'desc_dep'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKaryawan.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("npk_pic_sub").value = value["npk"];
            document.getElementById("nm_pic_sub").value = value["nama"];
            $('#karyawanModal').modal('hide');
            validateSubPic();
          });
        });
        $('#karyawanModal').on('hidden.bs.modal', function () {
          var npk_pic_sub = document.getElementById("npk_pic_sub").value.trim();
          if(npk_pic_sub === '') {
            document.getElementById("nm_pic_sub").value = "";
            $('#npk_pic_sub').focus();
          } else {
            if(mode_cm === "T") {
              document.getElementById('cm_ket').focus();
            } else {
              document.getElementById("btn-save").focus();
            }
          }
        });
      },
    });
  }

  function validateSubPic() {
    var npk_pic = document.getElementById('npk_pic').value.trim();
    var npk_pic_sub = document.getElementById('npk_pic_sub').value.trim();
    if(npk_pic !== '' && npk_pic_sub !== '') {
      var url = '{{ route('datatables.validasiKaryawanGenbaDep', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(npk_pic_sub));
      url = url.replace('param', window.btoa(npk_pic));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("npk_pic_sub").value = result["npk"];
          document.getElementById("nm_pic_sub").value = result["nama"];
          if(mode_cm === "T") {
            document.getElementById('cm_ket').focus();
          } else {
            document.getElementById("btn-save").focus();
          }
        } else {
          document.getElementById("npk_pic_sub").value = "";
          document.getElementById("nm_pic_sub").value = "";
          document.getElementById("npk_pic_sub").focus();
          swal("NPK Sub PIC tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("npk_pic_sub").value = "";
      document.getElementById("nm_pic_sub").value = "";
    }
  }
</script>
@endsection
