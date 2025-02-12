{!! Form::hidden('mode_pic', $mode_pic, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'mode_pic']) !!}
{!! Form::hidden('mode_approve', "F", ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'mode_approve']) !!}

@if (!empty($tmtcwo1->lok_pict))
  {!! Form::hidden('file_gambar', "T", ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'file_gambar']) !!}
@else
  {!! Form::hidden('file_gambar', "F", ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'file_gambar']) !!}
@endif

<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_wo') ? ' has-error' : '' }}">
      {!! Form::label('no_wo', 'No. LP') !!}
      @if (empty($tmtcwo1->no_wo))
        {!! Form::text('no_wo', null, ['class'=>'form-control','placeholder' => 'No. LP', 'disabled'=>'']) !!}
      @else
        {!! Form::text('no_wo2', $tmtcwo1->no_wo, ['class'=>'form-control','placeholder' => 'No. LP', 'required', 'disabled'=>'']) !!}
        {!! Form::hidden('no_wo', null, ['class'=>'form-control','placeholder' => 'No. LP', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('no_wo', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_wo') ? ' has-error' : '' }}">
      {!! Form::label('tgl_wo', 'Tanggal LP (*)') !!}
      @if (empty($tmtcwo1->tgl_wo))
        {!! Form::date('tgl_wo', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl LP', 'required']) !!}
      @else
        {!! Form::date('tgl_wo', \Carbon\Carbon::parse($tmtcwo1->tgl_wo), ['class'=>'form-control','placeholder' => 'Tgl LP', 'required']) !!}
        {!! Form::hidden('periode_wo', \Carbon\Carbon::parse($tmtcwo1->tgl_wo), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'periode_wo']) !!}
      @endif
      {!! $errors->first('tgl_wo', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('st_close') ? ' has-error' : '' }}">
      {!! Form::label('st_close', 'Status Laporan') !!}
      @if (empty($tmtcwo1->st_close))
        {!! Form::select('st_close', ['F' => 'BELUM SELESAI', 'T' => 'SUDAH SELESAI'], 'T', ['class'=>'form-control select2', 'required']) !!}
      @else
        @if ($mode_pic === "T")
          {!! Form::hidden('st_close', 'T', ['class'=>'form-control', 'required', 'id' => 'st_close']) !!}
          {!! Form::select('st_close2', ['F' => 'BELUM SELESAI', 'T' => 'SUDAH SELESAI'], 'T', ['class'=>'form-control select2', 'required', 'id' => 'st_close2', 'disabled'=>'']) !!}
        @else
          @if ($tmtcwo1->st_close === "T")
            {!! Form::hidden('st_close', $tmtcwo1->st_close, ['class'=>'form-control', 'required', 'id' => 'st_close']) !!}
            {!! Form::select('st_close2', ['F' => 'BELUM SELESAI', 'T' => 'SUDAH SELESAI'], $tmtcwo1->st_close, ['class'=>'form-control select2', 'required', 'id' => 'st_close2', 'disabled'=>'']) !!}
          @else
            {!! Form::select('st_close', ['F' => 'BELUM SELESAI', 'T' => 'SUDAH SELESAI'], null, ['class'=>'form-control select2', 'required']) !!}
          @endif
        @endif
      @endif
      {!! $errors->first('st_close', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('info_kerja') ? ' has-error' : '' }}">
      {!! Form::label('info_kerja', 'Info Kerja (*)') !!}
      @if (empty($tmtcwo1->info_kerja))
        {!! Form::select('info_kerja', ['ANDON' => 'ANDON', 'PMS' => 'PMS', 'CMS' => 'CMS', 'DM' => 'DM', 'PROJECT' => 'PROJECT', 'LANGSUNG' => 'LANGSUNG'], null, ['class'=>'form-control select2', 'id' => 'info_kerja', 'required', 'onchange' => 'changeInfoKerja()']) !!}
      @else
        @if ($tmtcwo1->info_kerja === "PMS" || $tmtcwo1->info_kerja === "CMS" || $tmtcwo1->info_kerja === "DM" || $mode_pic === "T") 
          {!! Form::hidden('info_kerja', $tmtcwo1->info_kerja, ['class'=>'form-control', 'required', 'id' => 'info_kerja']) !!}
          {!! Form::select('info_kerja2', ['ANDON' => 'ANDON', 'PMS' => 'PMS', 'CMS' => 'CMS', 'DM' => 'DM', 'PROJECT' => 'PROJECT', 'LANGSUNG' => 'LANGSUNG'], $tmtcwo1->info_kerja, ['class'=>'form-control select2', 'required', 'id' => 'info_kerja2', 'disabled'=>'']) !!}
        @else 
          {!! Form::select('info_kerja', ['ANDON' => 'ANDON', 'PMS' => 'PMS', 'CMS' => 'CMS', 'DM' => 'DM', 'PROJECT' => 'PROJECT', 'LANGSUNG' => 'LANGSUNG'], null, ['class'=>'form-control select2', 'id' => 'info_kerja', 'required', 'onchange' => 'changeInfoKerja()']) !!}
        @endif 
      @endif
      {!! $errors->first('info_kerja', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('lok_pt') ? ' has-error' : '' }}">
      {!! Form::label('lok_pt', 'Plant (*)') !!}
      @if (empty($tmtcwo1->info_kerja))
        {!! Form::select('lok_pt',  $plant->pluck('nm_plant','kd_plant')->all(), null, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'lok_pt']) !!}
      @else
        @if ($tmtcwo1->info_kerja === "PMS" || $tmtcwo1->info_kerja === "CMS" || $tmtcwo1->info_kerja === "DM" || $mode_pic === "T") 
          {!! Form::hidden('lok_pt', $tmtcwo1->lok_pt, ['class'=>'form-control', 'required', 'id' => 'lok_pt']) !!}
          {!! Form::select('lok_pt2',  $plant->pluck('nm_plant','kd_plant')->all(), $tmtcwo1->lok_pt, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'lok_pt2', 'disabled'=>'']) !!}
        @else 
          {!! Form::select('lok_pt',  $plant->pluck('nm_plant','kd_plant')->all(), null, ['class'=>'form-control select2', 'required', 'onchange' => 'changeKdPlant()', 'id' => 'lok_pt']) !!}
        @endif 
      @endif
      {!! $errors->first('lok_pt', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('shift') ? ' has-error' : '' }}">
      {!! Form::label('shift', 'Shift (*)') !!}
      @if (empty($tmtcwo1->shift))
        @if (\Carbon\Carbon::now()->format('Hi') >= "0000" && \Carbon\Carbon::now()->format('Hi') <= "0730")
          {!! Form::select('shift', ['1' => '1', '2' => '2', '3' => '3'], '1', ['class'=>'form-control select2', 'required']) !!}
        @elseif (\Carbon\Carbon::now()->format('Hi') >= "0731" && \Carbon\Carbon::now()->format('Hi') <= "1630")
          {!! Form::select('shift', ['1' => '1', '2' => '2', '3' => '3'], '2', ['class'=>'form-control select2', 'required']) !!}
        @elseif (\Carbon\Carbon::now()->format('Hi') >= "1631" && \Carbon\Carbon::now()->format('Hi') <= "2359")
          {!! Form::select('shift', ['1' => '1', '2' => '2', '3' => '3'], '3', ['class'=>'form-control select2', 'required']) !!}
        @else 
          {!! Form::select('shift', ['1' => '1', '2' => '2', '3' => '3'], null, ['class'=>'form-control select2', 'required']) !!}
        @endif
      @else 
        {!! Form::select('shift', ['1' => '1', '2' => '2', '3' => '3'], null, ['class'=>'form-control select2', 'required']) !!}
      @endif
      {!! $errors->first('shift', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('kd_line') ? ' has-error' : '' }}">
      {!! Form::label('kd_line', 'Line (F9) (*)') !!}
      <div class="input-group">
        @if (empty($tmtcwo1->info_kerja))
          {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line']) !!}
          <span class="input-group-btn">
            <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          @if ($tmtcwo1->info_kerja === "PMS" || $tmtcwo1->info_kerja === "CMS" || $tmtcwo1->info_kerja === "DM" || $mode_pic === "T") 
            {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line', 'readonly'=>'readonly']) !!}
            <span class="input-group-btn">
              <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal" disabled="">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @else 
            {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'required', 'id' => 'kd_line']) !!}
            <span class="input-group-btn">
              <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @endif 
        @endif
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
        @if (empty($tmtcwo1->info_kerja))
          {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required']) !!}
          <span class="input-group-btn">
            <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          @if ($tmtcwo1->info_kerja === "PMS" || $tmtcwo1->info_kerja === "CMS" || $tmtcwo1->info_kerja === "DM" || $mode_pic === "T") 
            {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required', 'readonly'=>'readonly']) !!}
            <span class="input-group-btn">
              <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal" disabled="">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @else 
            {!! Form::text('kd_mesin', null, ['class'=>'form-control','placeholder' => 'Mesin', 'maxlength' => 20, 'onkeydown' => 'keyPressedKdMesin(event)', 'onchange' => 'validateKdMesin()', 'required']) !!}
            <span class="input-group-btn">
              <button id="btnpopupmesin" type="button" class="btn btn-info" data-toggle="modal" data-target="#mesinModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          @endif 
        @endif
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
    <div class="col-sm-3 {{ $errors->has('uraian_prob') ? ' has-error' : '' }}">
      {!! Form::label('uraian_prob', 'Problem') !!}
      {!! Form::textarea('uraian_prob', null, ['class'=>'form-control', 'placeholder' => 'Problem', 'rows' => '3', 'maxlength'=>'250', 'style' => 'resize:vertical']) !!}
      {!! $errors->first('uraian_prob', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('uraian_penyebab') ? ' has-error' : '' }}">
      {!! Form::label('uraian_penyebab', 'Penyebab') !!}
      {!! Form::textarea('uraian_penyebab', null, ['class'=>'form-control', 'placeholder' => 'Penyebab', 'rows' => '3', 'maxlength'=>'250', 'style' => 'resize:vertical']) !!}
      {!! $errors->first('uraian_penyebab', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('langkah_kerja') ? ' has-error' : '' }}">
      {!! Form::label('langkah_kerja', 'Langkah Kerja') !!}
      {!! Form::textarea('langkah_kerja', null, ['class'=>'form-control', 'placeholder' => 'Langkah Kerja', 'rows' => '3', 'maxlength'=>'2000', 'style' => 'resize:vertical']) !!}
      {!! $errors->first('langkah_kerja', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('est_jamstart') ? ' has-error' : '' }}">
      {!! Form::label('est_jamstart', 'Est. Pengerjaan (Mulai)') !!}
      @if (empty($tmtcwo1->est_jamstart))
        {!! Form::datetimelocal('est_jamstart', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Est. Pengerjaan (Mulai)', 'onchange' => 'changeEst()']) !!}
      @else
        {!! Form::datetimelocal('est_jamstart', \Carbon\Carbon::parse($tmtcwo1->est_jamstart), ['class'=>'form-control','placeholder' => 'Est. Pengerjaan (Mulai)', 'onchange' => 'changeEst()']) !!}
      @endif
      {!! $errors->first('est_jamstart', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('est_jamend') ? ' has-error' : '' }}">
      {!! Form::label('est_jamend', 'Est. Pengerjaan (Selesai)') !!}
      @if (empty($tmtcwo1->est_jamend))
        {!! Form::datetimelocal('est_jamend', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Est. Pengerjaan (Selesai)', 'onchange' => 'changeEst()']) !!}
      @else
        {!! Form::datetimelocal('est_jamend', \Carbon\Carbon::parse($tmtcwo1->est_jamend), ['class'=>'form-control','placeholder' => 'Est. Pengerjaan (Selesai)', 'onchange' => 'changeEst()']) !!}
      @endif
      {!! $errors->first('est_jamend', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('est_durasi') ? ' has-error' : '' }}">
      {!! Form::label('est_durasi', 'Jumlah Menit') !!}
      {!! Form::number('est_durasi', null, ['class'=>'form-control', 'placeholder' => 'Jumlah Menit', 'min'=>'0', 'max'=>'9999999', 'step'=>'1', 'onchange' => 'changeDurasi()']) !!}
      {!! $errors->first('est_durasi', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('line_stop') ? ' has-error' : '' }}">
      {!! Form::label('line_stop', 'Line Stop (Menit) (*)') !!}
      {!! Form::number('line_stop', null, ['class'=>'form-control', 'placeholder' => 'Line Stop (Menit)', 'min'=>'0', 'max'=>'99999', 'step'=>'1', 'required']) !!}
      {!! $errors->first('line_stop', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-5 {{ $errors->has('nm_pelaksana') ? ' has-error' : '' }}">
      {!! Form::label('nm_pelaksana', 'Pelaksana') !!}
      {!! Form::textarea('nm_pelaksana', null, ['class'=>'form-control', 'placeholder' => 'Pelaksana', 'rows' => '3', 'maxlength'=>'500', 'style' => 'resize:vertical']) !!}
      {!! $errors->first('nm_pelaksana', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('catatan') ? ' has-error' : '' }}">
      {!! Form::label('catatan', 'Keterangan') !!}
      {!! Form::textarea('catatan', null, ['class'=>'form-control', 'placeholder' => 'Keterangan', 'rows' => '3', 'maxlength'=>'250', 'style' => 'resize:vertical']) !!}
      {!! $errors->first('catatan', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-2 {{ $errors->has('st_main_item') ? ' has-error' : '' }}">
      {!! Form::label('st_main_item', 'Main Item') !!}
      {!! Form::select('st_main_item', ['F' => 'TIDAK', 'T' => 'YA'], null, ['class'=>'form-control select2', 'onchange' => 'changeStMainItem()']) !!}
      {!! $errors->first('st_main_item', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('no_ic') ? ' has-error' : '' }}">
      {!! Form::label('no_ic', 'No. IC (F9) (*)') !!}
      <div class="input-group">
      {!! Form::text('no_ic', null, ['class'=>'form-control','placeholder' => 'No. IC', 'maxlength' => 22, 'onkeydown' => 'keyPressedNoIc(event)', 'onchange' => 'validateNoIc()', 'id' => 'no_ic']) !!}
        <span class="input-group-btn">
          <button id="btnpopupnoic" name="btnpopupnoic" type="button" class="btn btn-info" data-toggle="modal" data-target="#noicModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('no_ic', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-5 {{ $errors->has('nm_ic') ? ' has-error' : '' }}">
      {!! Form::label('nm_ic', 'Nama IC') !!}
      {!! Form::text('nm_ic', null, ['class'=>'form-control','placeholder' => 'Nama IC', 'disabled'=>'', 'id'=>'nm_ic']) !!}
      {!! $errors->first('nm_ic', '<p class="help-block">:message</p>') !!}
    </div>
    @if (!empty($tmtcwo1->no_ic))
      @if ($tmtcwo1->lastNoPms() != null)
        <div id="div-is" name="div-is" class="col-sm-2">
          {!! Form::label('last_pms', 'Inspection Standard') !!}
          <button id="btnis" name="btnis" type="button" class="btn btn-warning" data-toggle="modal" data-target="#isModal" onclick="popupIs('{{ base64_encode($tmtcwo1->lastNoPms()->no_pms) }}', '{{ base64_encode($tmtcwo1->pictPms()) }}', '{{ base64_encode($tmtcwo1->lastNoPms()->periode_pms) }}')"><span class="glyphicon glyphicon-eye-open"></span> View IS</button>
        </div>
      @else 
        <div id="div-is" name="div-is" class="col-sm-2" style="display: none;">
          {!! Form::label('last_pms', 'Inspection Standard') !!}
          <button id="btnis" name="btnis" type="button" class="btn btn-warning" data-toggle="modal" data-target="#isModal"><span class="glyphicon glyphicon-eye-open"></span> View IS</button>
        </div>
      @endif
    @else 
      <div id="div-is" name="div-is" class="col-sm-2" style="display: none;">
        {!! Form::label('last_pms', 'Inspection Standard') !!}
        <button id="btnis" name="btnis" type="button" class="btn btn-warning" data-toggle="modal" data-target="#isModal"><span class="glyphicon glyphicon-eye-open"></span> View IS</button>
      </div>
    @endif
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_lhp') ? ' has-error' : '' }}">
      {!! Form::label('no_lhp', 'No. LHP (F9)') !!}
      <div class="input-group">
      {!! Form::text('no_lhp', null, ['class'=>'form-control','placeholder' => 'No. LHP', 'maxlength' => 23, 'onkeydown' => 'keyPressedNoLhp(event)', 'onchange' => 'validateNoLhp()', 'id' => 'no_lhp']) !!}
        <span class="input-group-btn">
          <button id="btnpopupnolhp" type="button" class="btn btn-info" data-toggle="modal" data-target="#nolhpModal">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
      {!! $errors->first('no_lhp', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('ls_mulai') ? ' has-error' : '' }}">
      {!! Form::label('ls_mulai', 'LS Mulai') !!}
      @if (empty($tmtcwo1->ls_mulai))
        {!! Form::text('ls_mulai', null, ['class'=>'form-control','placeholder' => 'LS Mulai', 'readonly'=>'readonly', 'id'=>'ls_mulai']) !!}
      @else 
        {!! Form::text('ls_mulai', \Carbon\Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i'), ['class'=>'form-control','placeholder' => 'LS Mulai', 'readonly'=>'readonly', 'id'=>'ls_mulai']) !!}
      @endif
      {!! $errors->first('ls_mulai', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="row form-group">
    <div class="col-sm-5 {{ $errors->has('lok_pict') ? ' has-error' : '' }}">
      {!! Form::label('lok_pict', 'Picture (jpeg,png,jpg) (Jumlah Menit >= 120 harus diisi)') !!}
      @if (!empty($tmtcwo1->lok_pict))
        {!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png', 'id' => 'lok_pict']) !!}
        <p>
          <img src="{{ $tmtcwo1->lokPict() }}" alt="File Not Found" class="img-rounded img-responsive">
          <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('tmtcwo1s.deleteimage', base64_encode($tmtcwo1->no_wo)) }}"><span class="glyphicon glyphicon-remove"></span></a>
        </p>
      @else
        {!! Form::file('lok_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png', 'id' => 'lok_pict']) !!}
      @endif
      {!! $errors->first('lok_pict', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-footer">
  {!! Form::submit('Save LP', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if ($mode_pic === "T")
    &nbsp;&nbsp;
    <button id="btn-approve" type="button" class="btn btn-success">Save & Approve</button>
    &nbsp;&nbsp;
    <button id='btnreject' type='button' class='btn btn-warning' data-toggle='tooltip' data-placement='top' title='Reject LP - PIC {{ $tmtcwo1->no_wo }}' onclick='reject("{{ $tmtcwo1->no_wo }}","PIC")'>
      <span class='glyphicon glyphicon-remove'></span> Reject LP - PIC
    </button>
  @endif
  @if (!empty($tmtcwo1->no_wo))
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Hapus Data</button>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('tmtcwo1s.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong. Max size file 8 MB', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Line -->
@include('mtc.lp.popup.lineModal')
<!-- Modal Mesin -->
@include('mtc.lp.popup.mesinModal')
<!-- Modal No. IC -->
@include('mtc.lp.popup.noicModal')
<!-- Modal No. LHP -->
@include('mtc.lp.popup.nolhpModal')
<!-- Modal IS -->
@include('mtc.lp.popup.isModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("tgl_wo").focus();

  @if (empty($tmtcwo1->no_wo))
    var st_changeinfokerja = "NEW";
  @else 
    @if (empty($tmtcwo1->st_main_item))
      var st_changeinfokerja = "NEW";
    @else 
      var st_changeinfokerja = "OLD";
    @endif
  @endif

  //Initialize Select2 Elements
  $(".select2").select2();

  function changeInfoKerja() {
    var lok_pt = document.getElementById("lok_pt").value;
    if(lok_pt === "1" || lok_pt === "2" || lok_pt === "3") {
      var info_kerja = document.getElementById("info_kerja").value;
      var st_main_item = document.getElementById("st_main_item").value;
      if(info_kerja === "ANDON") {
        $('#st_main_item').children('option').remove();
        $("#st_main_item").append('<option value="T">YA</option>');
      } else {
        $('#st_main_item').children('option').remove();
        $("#st_main_item").append('<option value="F">TIDAK</option>');
        $("#st_main_item").append('<option value="T">YA</option>');
        if(st_changeinfokerja === "NEW") {
          document.getElementById("st_main_item").value = "F";
          st_changeinfokerja = "OLD";
        } else {
          document.getElementById("st_main_item").value = st_main_item;
        }
      }
    } else {
      var st_main_item = document.getElementById("st_main_item").value;
      $('#st_main_item').children('option').remove();
      $("#st_main_item").append('<option value="F">TIDAK</option>');
      $("#st_main_item").append('<option value="T">YA</option>');
      if(st_changeinfokerja === "NEW") {
        document.getElementById("st_main_item").value = "F";
        st_changeinfokerja = "OLD";
      } else {
        document.getElementById("st_main_item").value = st_main_item;
      }
    }
    changeStMainItem();
  }

  function changeStMainItem() {
    var st_main_item = document.getElementById("st_main_item").value;
    if(st_main_item === "T") {
      $('#no_ic').removeAttr('readonly');
      $('#no_ic').attr('required', 'required');
      $('#btnpopupnoic').removeAttr('disabled');
    } else {
      document.getElementById("no_ic").value = "";
      document.getElementById("nm_ic").value = "";
      $('#div-is').removeAttr('style');
      $('#div-is').attr('style', 'display: none;');
      $('#btnis').removeAttr('onclick');
      $('#btnis').removeAttr('data-toggle');
      $('#btnis').removeAttr('data-target');
      $('#no_ic').attr('readonly', 'readonly');
      $('#no_ic').removeAttr('required');
      $('#btnpopupnoic').attr('disabled', '');
    }
  }

  changeInfoKerja();

  $("#btn-delete").click(function(){
    var no_wo = document.getElementById("no_wo").value.trim();
    var msg = 'Anda yakin menghapus No. LP: ' + no_wo + '?';
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
      var urlRedirect = "{{ route('tmtcwo1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_wo));
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

  function reject(no_wo, status)
  {
    var msg = 'Anda yakin REJECT No. LP ' + no_wo + '?';
    if(status === "PIC") {
      msg = 'Anda yakin REJECT (PIC) No. LP ' + no_wo + '?';
    } else if(status === "SH") {
      msg = 'Anda yakin REJECT (Section) No. LP ' + no_wo + '?';
    }
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, reject it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      swal({
        title: 'Input Keterangan Reject',
        input: 'textarea',
        showCancelButton: true,
        inputValidator: function (value) {
          return new Promise(function (resolve, reject) {
            if (value) {
              if(value.length > 200) {
                reject('Keterangan Reject Max 200 Karakter!')
              } else {
                resolve()
              }
            } else {
              reject('Keterangan Reject tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('tmtcwo1s.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            no_wo             : window.btoa(no_wo),
            status_reject     : window.btoa(status),
            keterangan_reject : result,
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('tmtcwo1s.index') }}";
              window.location.href = urlRedirect;
            } else {
              swal("Cancelled", data.message, "error");
            }
          }, error:function(){ 
            $("#loading").hide();
            swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
          }
        });
      }).catch(swal.noop)
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

  $("#btn-approve").click(function(){
    var no_wo = document.getElementById("no_wo").value;
    var tgl_wo = document.getElementById("tgl_wo").value;
    var info_kerja = document.getElementById("info_kerja").value;
    var lok_pt = document.getElementById("lok_pt").value;
    var shift = document.getElementById("shift").value;
    var kd_line = document.getElementById("kd_line").value;
    var kd_mesin = document.getElementById("kd_mesin").value;
    var line_stop = document.getElementById("line_stop").value;

    var validasi_no_ic = "T";
    var st_main_item = document.getElementById("st_main_item").value;
    if(st_main_item === "T") {
      var no_ic = document.getElementById("no_ic").value;
      if(no_ic === "") {
        validasi_no_ic = "";
      }
    }

    if(no_wo === "" || tgl_wo === "" || info_kerja === "" || lok_pt === "" || shift === "" || kd_line === "" || kd_mesin === "" || line_stop === "" || validasi_no_ic === "") {
      var info = "Isi data yang tidak boleh kosong!";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {

      var validasi = "T";
      var msg = "";

      var no_wo = document.getElementById("no_wo").value.trim();
      if(no_wo === '') {
        no_wo = "-";
      } else {
        var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        var tgl_wo_old = document.getElementById("periode_wo").value.trim();
        var date_old = new Date(tgl_wo_old);
        var periode_old = monthNames[date_old.getMonth()] + " " + date_old.getFullYear();

        var tgl_wo_new = document.getElementById("tgl_wo").value.trim();
        var date_new = new Date(tgl_wo_new);
        var periode_new = monthNames[date_new.getMonth()] + " " + date_new.getFullYear();

        if(periode_old.toUpperCase() !== periode_new.toUpperCase()) {
          validasi = "F";
          msg = "Tanggal LP tidak valid! Tanggal harus bulan " + periode_old.toUpperCase();
        }
      }

      if(validasi !== "T") {
        var info = msg;
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        var tgl_wo = document.getElementById("tgl_wo").value.trim();
        var date_tgl_wo = new Date(tgl_wo);
        var bulan_tgl_wo = date_tgl_wo.getMonth() + 1;
        if(bulan_tgl_wo < 10) {
          bulan_tgl_wo = "0" + bulan_tgl_wo;
        }
        var tgl_tgl_wo = date_tgl_wo.getDate();
        if(tgl_tgl_wo < 10) {
          tgl_tgl_wo = "0" + tgl_tgl_wo;
        }
        tgl_wo = date_tgl_wo.getFullYear() + "" + bulan_tgl_wo + "" + date_tgl_wo.getDate();

        var kd_mesin = document.getElementById("kd_mesin").value.trim();
        if(kd_mesin === '') {
          kd_mesin = "-";
        }

        var shift = document.getElementById("shift").value.trim();
        if(shift === '') {
          shift = "-";
        }

        var var_est_jamstart = document.getElementById("est_jamstart").value.trim();
        var var_est_jamend = document.getElementById("est_jamend").value.trim();
        var date_est_jamstart = new Date(var_est_jamstart);
        var date_est_jamend = new Date(var_est_jamend);

        var bulan_est_jamstart = date_est_jamstart.getMonth() + 1;
        if(bulan_est_jamstart < 10) {
          var tgl = date_est_jamstart.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }
          var jam = date_est_jamstart.getHours();
          if(jam < 10) {
            jam = "0" + jam;
          }
          var menit = date_est_jamstart.getMinutes();
          if(menit < 10) {
            menit = "0" + menit;
          }
          var_est_jamstart = date_est_jamstart.getFullYear() + "0" + bulan_est_jamstart + "" + tgl + "" + jam + "" + menit;
        } else {
          var tgl = date_est_jamstart.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }
          var jam = date_est_jamstart.getHours();
          if(jam < 10) {
            jam = "0" + jam;
          }
          var menit = date_est_jamstart.getMinutes();
          if(menit < 10) {
            menit = "0" + menit;
          }
          var_est_jamstart = date_est_jamstart.getFullYear() + "" + bulan_est_jamstart + "" + tgl + "" + jam + "" + menit;
        }

        var bulan_est_jamend = date_est_jamend.getMonth() + 1;
        if(bulan_est_jamend < 10) {
          var tgl = date_est_jamend.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }
          var jam = date_est_jamend.getHours();
          if(jam < 10) {
            jam = "0" + jam;
          }
          var menit = date_est_jamend.getMinutes();
          if(menit < 10) {
            menit = "0" + menit;
          }
          var_est_jamend = date_est_jamend.getFullYear() + "0" + bulan_est_jamend + "" + tgl + "" + jam + "" + menit;
        } else {
          var tgl = date_est_jamend.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }
          var jam = date_est_jamend.getHours();
          if(jam < 10) {
            jam = "0" + jam;
          }
          var menit = date_est_jamend.getMinutes();
          if(menit < 10) {
            menit = "0" + menit;
          }
          var_est_jamend = date_est_jamend.getFullYear() + "" + bulan_est_jamend + "" + tgl + "" + jam + "" + menit;
        }

        var url = '{{ route('tmtcwo1s.validasiDuplicate', ['param','param2','param3','param4','param5','param6']) }}';
        url = url.replace('param6', window.btoa(var_est_jamend));
        url = url.replace('param5', window.btoa(var_est_jamstart));
        url = url.replace('param4', window.btoa(shift));
        url = url.replace('param3', window.btoa(kd_mesin));
        url = url.replace('param2', window.btoa(tgl_wo));
        url = url.replace('param', window.btoa(no_wo));
        //use ajax to run the check
        $.get(url, function(result){  

          var valid = 'T';
          var msg = "Anda yakin menyimpan dan approve data ini?";
          var txt = 'No. LP: ' + no_wo;

          if(result !== 'null'){
            result = JSON.parse(result);
            status = result["status"];
            if(status == "F") {
              valid = "F";
              msg = "Data dengan Kode Mesin, Tgl LP, Shift & Est. Pengerjaan tsb sudah ada!";
              txt = "No. LP: " + result["no_wo"];
            } else {
              msg = "Terdapat LP yang mirip. Anda yakin menyimpan data ini?";
              txt = "No. LP: " + result["no_wo"];
            }
          }
          
          if(valid === 'T') {
            //additional input validations can be done hear
            swal({
              title: msg,
              text: txt,
              type: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, save & approve it!',
              cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
              allowOutsideClick: true,
              allowEscapeKey: true,
              allowEnterKey: true,
              reverseButtons: false,
              focusCancel: true,
            }).then(function () {
              document.getElementById("mode_pic").value = "T";
              document.getElementById("mode_approve").value = "PIC";
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
          } else {
            swal(msg, txt, "warning");
          }
        });
      }
    }
  });

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();

      var validasi = "T";
      var msg = "";

      var no_wo = document.getElementById("no_wo").value.trim();
      if(no_wo === '') {
        no_wo = "-";
      } else {
        var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        var tgl_wo_old = document.getElementById("periode_wo").value.trim();
        var date_old = new Date(tgl_wo_old);
        var periode_old = monthNames[date_old.getMonth()] + " " + date_old.getFullYear();

        var tgl_wo_new = document.getElementById("tgl_wo").value.trim();
        var date_new = new Date(tgl_wo_new);
        var periode_new = monthNames[date_new.getMonth()] + " " + date_new.getFullYear();

        if(periode_old.toUpperCase() !== periode_new.toUpperCase()) {
          validasi = "F";
          msg = "Tanggal LP tidak valid! Tanggal harus bulan " + periode_old.toUpperCase();
        }
      }

      if(validasi !== "T") {
        var info = msg;
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        var tgl_wo = document.getElementById("tgl_wo").value.trim();
        var date_tgl_wo = new Date(tgl_wo);
        var bulan_tgl_wo = date_tgl_wo.getMonth() + 1;
        if(bulan_tgl_wo < 10) {
          bulan_tgl_wo = "0" + bulan_tgl_wo;
        }
        var tgl_tgl_wo = date_tgl_wo.getDate();
        if(tgl_tgl_wo < 10) {
          tgl_tgl_wo = "0" + tgl_tgl_wo;
        }
        tgl_wo = date_tgl_wo.getFullYear() + "" + bulan_tgl_wo + "" + date_tgl_wo.getDate();

        var kd_mesin = document.getElementById("kd_mesin").value.trim();
        if(kd_mesin === '') {
          kd_mesin = "-";
        }

        var shift = document.getElementById("shift").value.trim();
        if(shift === '') {
          shift = "-";
        }

        var var_est_jamstart = document.getElementById("est_jamstart").value.trim();
        var var_est_jamend = document.getElementById("est_jamend").value.trim();
        var date_est_jamstart = new Date(var_est_jamstart);
        var date_est_jamend = new Date(var_est_jamend);

        var bulan_est_jamstart = date_est_jamstart.getMonth() + 1;
        if(bulan_est_jamstart < 10) {
          var tgl = date_est_jamstart.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }
          var jam = date_est_jamstart.getHours();
          if(jam < 10) {
            jam = "0" + jam;
          }
          var menit = date_est_jamstart.getMinutes();
          if(menit < 10) {
            menit = "0" + menit;
          }
          var_est_jamstart = date_est_jamstart.getFullYear() + "0" + bulan_est_jamstart + "" + tgl + "" + jam + "" + menit;
        } else {
          var tgl = date_est_jamstart.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }
          var jam = date_est_jamstart.getHours();
          if(jam < 10) {
            jam = "0" + jam;
          }
          var menit = date_est_jamstart.getMinutes();
          if(menit < 10) {
            menit = "0" + menit;
          }
          var_est_jamstart = date_est_jamstart.getFullYear() + "" + bulan_est_jamstart + "" + tgl + "" + jam + "" + menit;
        }

        var bulan_est_jamend = date_est_jamend.getMonth() + 1;
        if(bulan_est_jamend < 10) {
          var tgl = date_est_jamend.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }
          var jam = date_est_jamend.getHours();
          if(jam < 10) {
            jam = "0" + jam;
          }
          var menit = date_est_jamend.getMinutes();
          if(menit < 10) {
            menit = "0" + menit;
          }
          var_est_jamend = date_est_jamend.getFullYear() + "0" + bulan_est_jamend + "" + tgl + "" + jam + "" + menit;
        } else {
          var tgl = date_est_jamend.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }
          var jam = date_est_jamend.getHours();
          if(jam < 10) {
            jam = "0" + jam;
          }
          var menit = date_est_jamend.getMinutes();
          if(menit < 10) {
            menit = "0" + menit;
          }
          var_est_jamend = date_est_jamend.getFullYear() + "" + bulan_est_jamend + "" + tgl + "" + jam + "" + menit;
        }

        var url = '{{ route('tmtcwo1s.validasiDuplicate', ['param','param2','param3','param4','param5','param6']) }}';
        url = url.replace('param6', window.btoa(var_est_jamend));
        url = url.replace('param5', window.btoa(var_est_jamstart));
        url = url.replace('param4', window.btoa(shift));
        url = url.replace('param3', window.btoa(kd_mesin));
        url = url.replace('param2', window.btoa(tgl_wo));
        url = url.replace('param', window.btoa(no_wo));
        //use ajax to run the check
        $.get(url, function(result){  

          var valid = 'T';
          var msg = "Anda yakin menyimpan data ini?";
          var txt = "";

          if(result !== 'null'){
            result = JSON.parse(result);
            status = result["status"];
            if(status == "F") {
              valid = "F";
              msg = "Data dengan Kode Mesin, Tgl LP, Shift & Est. Pengerjaan tsb sudah ada!";
              txt = "No. LP: " + result["no_wo"];
            } else {
              msg = "Terdapat LP yang mirip. Anda yakin menyimpan data ini?";
              txt = "No. LP: " + result["no_wo"];
            }
          }
          
          if(valid === 'T') {
            var mode_pic = document.getElementById("mode_pic").value;
            var st_close = document.getElementById("st_close").value;
            if(mode_pic === "F" && st_close === "T") {
              txt = 'LP dengan status SUDAH SELESAI tidak bisa diubah lagi.';
            }
            //additional input validations can be done hear
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
          } else {
            swal(msg, txt, "warning");
          }
        });
      }
    }
  });

  function changeEst() {
    var var_est_jamstart = document.getElementById("est_jamstart").value.trim();
    var var_est_jamend = document.getElementById("est_jamend").value.trim();

    if(var_est_jamstart !== "" && var_est_jamend !== "") {
      var date_est_jamstart = new Date(var_est_jamstart);
      var date_est_jamend = new Date(var_est_jamend);
      var selisih = date_est_jamend-date_est_jamstart;
      selisih = Number(selisih);
      selisih = selisih/1000/60;
      if(selisih < 0) {
        selisih = 0;
      }
      document.getElementById("est_durasi").value = selisih;
    } else {
      document.getElementById("est_durasi").value = 0;
    }
    changeDurasi();
  }

  function changeDurasi() {
    var file_gambar = document.getElementById("file_gambar").value.trim();
    if(file_gambar !== "T") {
      var est_durasi = document.getElementById("est_durasi").value.trim();
      if(est_durasi != "") {
        if(est_durasi >= 120) {
          $('#lok_pict').attr('required', 'required');
        } else {
          $('#lok_pict').removeAttr('required');
        }
      } else {
        $('#lok_pict').removeAttr('required');
      }
    }
  }

  changeDurasi();

  function changeKdPlant() {
    changeInfoKerja();
    validateKdLine();
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('kd_mesin').focus();
    }
  }

  function keyPressedKdMesin(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupmesin').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('uraian_prob').focus();
    }
  }

  function keyPressedNoIc(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnoic').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('no_lhp').focus();
    }
  }

  function keyPressedNoLhp(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnolhp').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('lok_pict').focus();
    }
  }

  $(document).ready(function(){

    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    $("#btnpopupmesin").click(function(){
      popupKdMesin();
    });

    $("#btnpopupnoic").click(function(){
      popupNoIc();
    });

    $("#btnpopupnolhp").click(function(){
      popupNoLhp();
    });

    var url = '{{ route('dashboardis2.mtctpmss', 'param') }}';
    url = url.replace('param', window.btoa("0"));
    var tblDetail = $('#tblDetail').DataTable({
      "searching": false,
      "ordering": false,
      "paging": false,
      "scrollX": true,
      "scrollY": "300px",
      "scrollCollapse": true,
      // responsive: true,
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url, 
      columns: [
        // {data: 'no_urut', name: 'no_urut', className: "dt-center", orderable: false, searchable: false},
        {data: 'nm_is', name: 'nm_is', orderable: false, searchable: false},
        {data: 'ketentuan', name: 'ketentuan', orderable: false, searchable: false},
        {data: 'metode', name: 'metode', orderable: false, searchable: false},
        {data: 'alat', name: 'alat', orderable: false, searchable: false},
        {data: 'waktu_menit', name: 'waktu_menit', className: "dt-right", orderable: false, searchable: false},
        {data: 'st_ok_ng', name: 'st_ok_ng', className: "dt-center", orderable: false, searchable: false},
        {data: 'ket_ng', name: 'ket_ng', orderable: false, searchable: false},
        {data: 'lok_pict', name: 'lok_pict', orderable: false, searchable: false}
      ], 
    });
  });

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var lok_pt = document.getElementById('lok_pt').value.trim();
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(lok_pt));
    var lookupLine = $('#lookupLine').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[1, 'asc']],
      columns: [
        { data: 'xkd_line', name: 'xkd_line'},
        { data: 'xnm_line', name: 'xnm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLine.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_line").value = value["xkd_line"];
            document.getElementById("nm_line").value = value["xnm_line"];
            $('#lineModal').modal('hide');
            validateKdLine();
          });
        });
        $('#lineModal').on('hidden.bs.modal', function () {
          var kd_line = document.getElementById("kd_line").value.trim();
          if(kd_line === '') {
            document.getElementById("nm_line").value = "";
            document.getElementById("kd_mesin").value = "";
            document.getElementById("nm_mesin").value = "";
            document.getElementById("no_ic").value = "";
            document.getElementById("nm_ic").value = "";
            $('#div-is').removeAttr('style');
            $('#div-is').attr('style', 'display: none;');
            $('#btnis').removeAttr('onclick');
            $('#btnis').removeAttr('data-toggle');
            $('#btnis').removeAttr('data-target');
            document.getElementById("no_lhp").value = "";
            document.getElementById("ls_mulai").value = "";
            $('#kd_line').focus();
          } else {
            $('#kd_mesin').focus();
          }
        });
      },
    });
  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      var lok_pt = document.getElementById('lok_pt').value.trim();
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(lok_pt));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];
          validateKdMesin();
        } else {
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          document.getElementById("kd_mesin").value = "";
          document.getElementById("nm_mesin").value = "";
          document.getElementById("no_ic").value = "";
          document.getElementById("nm_ic").value = "";
          $('#div-is').removeAttr('style');
          $('#div-is').attr('style', 'display: none;');
          $('#btnis').removeAttr('onclick');
          $('#btnis').removeAttr('data-toggle');
          $('#btnis').removeAttr('data-target');
          document.getElementById("no_lhp").value = "";
          document.getElementById("ls_mulai").value = "";
          document.getElementById("kd_line").focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
      document.getElementById("kd_mesin").value = "";
      document.getElementById("nm_mesin").value = "";
      document.getElementById("no_ic").value = "";
      document.getElementById("nm_ic").value = "";
      $('#div-is').removeAttr('style');
      $('#div-is').attr('style', 'display: none;');
      $('#btnis').removeAttr('onclick');
      $('#btnis').removeAttr('data-toggle');
      $('#btnis').removeAttr('data-target');
      document.getElementById("no_lhp").value = "";
      document.getElementById("ls_mulai").value = "";
    }
  }

  function popupKdMesin() {
    var myHeading = "<p>Popup Mesin</p>";
    $("#mesinModalLabel").html(myHeading);
    var lok_pt = document.getElementById('lok_pt').value.trim();
    if(lok_pt === '') {
      lok_pt = "-";
    }
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var url = '{{ route('datatables.popupMesins', ['param','param2']) }}';
    url = url.replace('param2', window.btoa(kd_line));
    url = url.replace('param', window.btoa(lok_pt));
    var lookupMesin = $('#lookupMesin').DataTable({
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
        { data: 'kd_mesin', name: 'kd_mesin'},
        { data: 'nm_mesin', name: 'nm_mesin'},
        { data: 'kd_line', name: 'kd_line'},
        { data: 'nm_line', name: 'nm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupMesin tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupMesin.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_mesin").value = value["kd_mesin"];
            document.getElementById("nm_mesin").value = value["nm_mesin"];
            document.getElementById("kd_line").value = value["kd_line"];
            document.getElementById("nm_line").value = value["nm_line"];
            $('#mesinModal').modal('hide');
            validateKdMesin();
          });
        });
        $('#mesinModal').on('hidden.bs.modal', function () {
          var kd_mesin = document.getElementById("kd_mesin").value.trim();
          if(kd_mesin === '') {
            document.getElementById("nm_mesin").value = "";
            document.getElementById("no_ic").value = "";
            document.getElementById("nm_ic").value = "";
            $('#div-is').removeAttr('style');
            $('#div-is').attr('style', 'display: none;');
            $('#btnis').removeAttr('onclick');
            $('#btnis').removeAttr('data-toggle');
            $('#btnis').removeAttr('data-target');
            document.getElementById("no_lhp").value = "";
            document.getElementById("ls_mulai").value = "";
            $('#kd_mesin').focus();
          } else {
            $('#uraian_prob').focus();
          }
        });
      },
    });
  }

  function validateKdMesin() {
    var lok_pt = document.getElementById('lok_pt').value.trim();
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var kd_mesin = document.getElementById("kd_mesin").value.trim();
    if(lok_pt !== '' && kd_mesin !== '') {
      var url = '{{ route('datatables.validasiMesin', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(kd_mesin));
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(lok_pt));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          if(result["jml_row"] != null) {
            document.getElementById("kd_mesin").value = "";
            document.getElementById("nm_mesin").value = "";
            document.getElementById("kd_line").value = "";
            document.getElementById("nm_line").value = "";
            document.getElementById("no_ic").value = "";
            document.getElementById("nm_ic").value = "";
            $('#div-is').removeAttr('style');
            $('#div-is').attr('style', 'display: none;');
            $('#btnis').removeAttr('onclick');
            $('#btnis').removeAttr('data-toggle');
            $('#btnis').removeAttr('data-target');
            document.getElementById("no_lhp").value = "";
            document.getElementById("ls_mulai").value = "";
            document.getElementById("kd_mesin").focus();
            swal("Terdapat " + result["jml_row"] + " Line. Pilih dari Popup.", "tekan F9 untuk tampilkan data.", "warning");
          } else {
            document.getElementById("kd_mesin").value = result["kd_mesin"];
            document.getElementById("nm_mesin").value = result["nm_mesin"];
            document.getElementById("kd_line").value = result["kd_line"];
            document.getElementById("nm_line").value = result["nm_line"];
            validateNoIc();
            validateNoLhp();
          }
        } else {
          document.getElementById("kd_mesin").value = "";
          document.getElementById("nm_mesin").value = "";
          document.getElementById("no_ic").value = "";
          document.getElementById("nm_ic").value = "";
          $('#div-is').removeAttr('style');
          $('#div-is').attr('style', 'display: none;');
          $('#btnis').removeAttr('onclick');
          $('#btnis').removeAttr('data-toggle');
          $('#btnis').removeAttr('data-target');
          document.getElementById("no_lhp").value = "";
          document.getElementById("ls_mulai").value = "";
          document.getElementById("kd_mesin").focus();
          swal("Mesin tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_mesin").value = "";
      document.getElementById("nm_mesin").value = "";
      document.getElementById("no_ic").value = "";
      document.getElementById("nm_ic").value = "";
      $('#div-is').removeAttr('style');
      $('#div-is').attr('style', 'display: none;');
      $('#btnis').removeAttr('onclick');
      $('#btnis').removeAttr('data-toggle');
      $('#btnis').removeAttr('data-target');
      document.getElementById("no_lhp").value = "";
      document.getElementById("ls_mulai").value = "";
    }
  }

  function popupNoIc() {
    var myHeading = "<p>Popup No. IC</p>";
    $("#noicModalLabel").html(myHeading);
    var kd_mesin = document.getElementById('kd_mesin').value.trim();
    if(kd_mesin === '') {
      kd_mesin = "-";
    }
    var url = '{{ route('datatables.popupIcLps', 'param') }}';
    url = url.replace('param', window.btoa(kd_mesin));
    var lookupNoIc = $('#lookupNoIc').DataTable({
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
      "order": [[1, 'desc']],
      columns: [
        { data: 'no_ic', name: 'no_ic'},
        { data: 'nm_ic', name: 'nm_ic'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupNoIc tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupNoIc.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_ic").value = value["no_ic"];
            document.getElementById("nm_ic").value = value["nm_ic"];
            $('#noicModal').modal('hide');
            validateNoIc();
          });
        });
        $('#noicModal').on('hidden.bs.modal', function () {
          var no_ic = document.getElementById("no_ic").value.trim();
          if(no_ic === '') {
            document.getElementById("nm_ic").value = "";
            $('#div-is').removeAttr('style');
            $('#div-is').attr('style', 'display: none;');
            $('#btnis').removeAttr('onclick');
            $('#btnis').removeAttr('data-toggle');
            $('#btnis').removeAttr('data-target');
            $('#no_ic').focus();
          } else {
            $('#no_lhp').focus();
          }
        });
      },
    });
  }

  function validateNoIc() {
    var kd_mesin = document.getElementById('kd_mesin').value.trim();
    var no_ic = document.getElementById("no_ic").value.trim();
    if(kd_mesin !== '' && no_ic !== '') {
      var url = '{{ route('datatables.validasiIcLp', ['param', 'param2']) }}';
      url = url.replace('param2', window.btoa(no_ic));
      url = url.replace('param', window.btoa(kd_mesin));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_ic").value = result["no_ic"];
          document.getElementById("nm_ic").value = result["nm_ic"];
          if(result["no_pms"] != "-") {
            $('#div-is').removeAttr('style');
            $('#btnis').attr('onclick', "popupIs('" + window.btoa(result["no_pms"]) + "', '" + window.btoa(result["lok_pict"]) + "', '" + window.btoa(result["periode_pms"]) + "')");
            $('#btnis').attr('data-toggle', 'modal');
            $('#btnis').attr('data-target', '#isModal');
          } else {
            $('#div-is').removeAttr('style');
            $('#div-is').attr('style', 'display: none;');
            $('#btnis').removeAttr('onclick');
            $('#btnis').removeAttr('data-toggle');
            $('#btnis').removeAttr('data-target');
          }
          document.getElementById("no_lhp").focus();
        } else {
          document.getElementById("no_ic").value = "";
          document.getElementById("nm_ic").value = "";
          $('#div-is').removeAttr('style');
          $('#div-is').attr('style', 'display: none;');
          $('#btnis').removeAttr('onclick');
          $('#btnis').removeAttr('data-toggle');
          $('#btnis').removeAttr('data-target');
          document.getElementById("no_ic").focus();
          swal("No. IC tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_ic").value = "";
      document.getElementById("nm_ic").value = "";
      $('#div-is').removeAttr('style');
      $('#div-is').attr('style', 'display: none;');
      $('#btnis').removeAttr('onclick');
      $('#btnis').removeAttr('data-toggle');
      $('#btnis').removeAttr('data-target');
    }
  }

  function popupNoLhp() {
    var myHeading = "<p>Popup No. LHP</p>";
    $("#nolhpModalLabel").html(myHeading);
    var tgl_lp = $('input[name="tgl_wo"]').val();
    var kd_line = document.getElementById('kd_line').value.trim();
    if(kd_line === '') {
      kd_line = "-";
    }
    var kd_mesin = document.getElementById('kd_mesin').value.trim();
    if(kd_mesin === '') {
      kd_mesin = "-";
    }
    var url = '{{ route('datatables.popupLhpLps', ['param','param2','param3']) }}';
    url = url.replace('param3', window.btoa(kd_mesin));
    url = url.replace('param2', window.btoa(kd_line));
    url = url.replace('param', window.btoa(tgl_lp));
    var lookupNoLhp = $('#lookupNoLhp').DataTable({
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
      "order": [[1, 'desc']],
      columns: [
        { data: 'no_doc', name: 'no_doc'},
        { data: 'tgl_doc', name: 'tgl_doc'},
        { data: 'ls_mulai', name: 'ls_mulai'},
        { data: 'ls_selesai', name: 'ls_selesai'},
        { data: 'jml_menit', name: 'jml_menit', className: "dt-right"},
        { data: 'nm_ls', name: 'nm_ls'},
        { data: 'nm_ls_cat', name: 'nm_ls_cat'},
        { data: 'uraian', name: 'uraian'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupNoLhp tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupNoLhp.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_lhp").value = value["no_doc"];
            document.getElementById("ls_mulai").value = value["ls_mulai"];
            $('#nolhpModal').modal('hide');
            validateNoLhp();
          });
        });
        $('#nolhpModal').on('hidden.bs.modal', function () {
          var no_lhp = document.getElementById("no_lhp").value.trim();
          if(no_lhp === '') {
            document.getElementById("ls_mulai").value = "";
            $('#no_lhp').focus();
          } else {
            $('#lok_pict').focus();
          }
        });
      },
    });
  }

  function validateNoLhp() {
    var tgl_lp = $('input[name="tgl_wo"]').val();
    var kd_line = document.getElementById('kd_line').value.trim();
    var kd_mesin = document.getElementById('kd_mesin').value.trim();
    var no_lhp = document.getElementById("no_lhp").value.trim();
    var ls_mulai = document.getElementById("ls_mulai").value.trim();
    if(tgl_lp !== '' && kd_line !== '' && kd_mesin !== '' && no_lhp !== '' && ls_mulai !== '') {
      var url = '{{ route('datatables.validasiLhpLp', ['param', 'param2', 'param3', 'param4', 'param5']) }}';
      url = url.replace('param5', window.btoa(ls_mulai));
      url = url.replace('param4', window.btoa(no_lhp));
      url = url.replace('param3', window.btoa(kd_mesin));
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(tgl_lp));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_lhp").value = result["no_doc"];
          document.getElementById("ls_mulai").value = result["ls_mulai"];
          document.getElementById("lok_pict").focus();
        } else {
          document.getElementById("no_lhp").value = "";
          document.getElementById("ls_mulai").value = "";
          document.getElementById("no_lhp").focus();
          swal("No. LHP tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_lhp").value = "";
      document.getElementById("ls_mulai").value = "";
    }
  }

  function popupIs(no_pms, lok_pict, periode_pms) {
    var myHeading = "<p>Inspection Standard (No. PMS: " + window.atob(no_pms) + ", Tgl PMS: " + window.atob(periode_pms) + ")</p>";
    $("#isModalLabel").html(myHeading);

    if(window.atob(lok_pict) === "-") {
      $("#boxtitle").html("Foto (Tidak ada)");
      $('#lok_pict').attr('alt', "Tidak ada foto");
      $('#lok_pict').attr('src', "");
    } else {
      $("#boxtitle").html("Foto (Ada)");
      $('#lok_pict').attr('alt', "File Not Found");
      $('#lok_pict').attr('src', "data:image/jpg;charset=utf-8;base64," + lok_pict);
    }
    var tableDetail = $('#tblDetail').DataTable();
    var url = '{{ route('dashboardis2.mtctpmss', 'param') }}';
    url = url.replace('param', no_pms);
    tableDetail.ajax.url(url).load();
  }
</script>
@endsection
