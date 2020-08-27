<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active" id="nav_wp">
    <a href="#wp" aria-controls="wp" role="tab" data-toggle="tab" title="Ijin Kerja">
      Ijin Kerja
    </a>
  </li>
  <li role="presentation" id="nav_wp1">
    <a href="#wp1" aria-controls="wp1" role="tab" data-toggle="tab" title="Identitas Proyek">
      A. Identitas Proyek
    </a>
  </li>
  <li role="presentation" id="nav_mp">
    <a href="#mp" aria-controls="mp" role="tab" data-toggle="tab" title="List Member">
      B. List Member
    </a>
  </li>
  <li role="presentation" id="nav_k3">
    <a href="#k3" aria-controls="k3" role="tab" data-toggle="tab" title="Identifikasi Bahaya">
      C. Identifikasi Bahaya
    </a>
  </li>
  <li role="presentation" id="nav_env">
    <a href="#env" aria-controls="env" role="tab" data-toggle="tab" title="Identifikasi Aspek Dampak Lingkungan">
      D. Identifikasi Aspek Dampak Lingkungan
    </a>
  </li>
</ul>
<!-- /.tablist -->

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="wp">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-3 {{ $errors->has('no_wp') ? ' has-error' : '' }}">
          {!! Form::label('no_wp', 'No. Work Permit (*)') !!}
          @if (empty($ehstwp1->no_wp))
            {!! Form::text('no_wp', null, ['class'=>'form-control','placeholder' => 'No. Work Permit', 'disabled'=>'', 'id' => 'no_wp']) !!}
          @else
            {!! Form::text('no_wp2', $ehstwp1->no_wp, ['class'=>'form-control','placeholder' => 'No. Work Permit', 'required', 'disabled'=>'', 'id' => 'no_wp2']) !!}
            {!! Form::hidden('no_wp', null, ['class'=>'form-control','placeholder' => 'No. Work Permit', 'required', 'readonly'=>'readonly', 'id' => 'no_wp']) !!}
          @endif
          {!! Form::hidden('no_rev', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'no_rev']) !!}
          {!! Form::hidden('st_submit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_submit']) !!}
          {!! $errors->first('no_wp', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('tgl_wp') ? ' has-error' : '' }}">
          {!! Form::label('tgl_wp', 'Tgl Work Permit (*)') !!}
          @if (empty($ehstwp1->tgl_wp))
            {!! Form::date('tgl_wp', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Work Permit', 'required']) !!}
          @else
            {!! Form::date('tgl_wp', null, ['class'=>'form-control','placeholder' => 'Tgl Work Permit', 'required', 'readonly'=>'readonly']) !!}
          @endif
          {!! $errors->first('tgl_wp', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('kd_site') ? ' has-error' : '' }}">
          {!! Form::label('kd_site', 'Site (*)') !!}
          {!! Form::select('kd_site', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], null, ['class'=>'form-control select2', 'onchange' => 'changeKdSite()']) !!}
          {!! $errors->first('kd_site', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-2 {{ $errors->has('status_po') ? ' has-error' : '' }}">
          {!! Form::label('status_po', 'Status PO / Non PO') !!}
          {!! Form::select('status_po', ['T' => 'PO', 'F' => 'NON PO'], null, ['class'=>'form-control select2', 'id' => 'status_po', 'onchange' => 'changeStatusPo()']) !!}
          {!! $errors->first('status_po', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-3 {{ $errors->has('no_pp') ? ' has-error' : '' }}">
          {!! Form::label('no_pp', 'No. PP (F9)') !!}
          <div class="input-group">
            {!! Form::text('no_pp', null, ['class'=>'form-control','placeholder' => 'No. PP', 'maxlength' => 13, 'onkeydown' => 'keyPressedNoPp(event)', 'onchange' => 'validateNoPp("T")', 'id' => 'no_pp']) !!}
            <span class="input-group-btn">
              <button id="btnpopupnopp" type="button" class="btn btn-info" data-toggle="modal" data-target="#ppModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
          {!! $errors->first('no_pp', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-3 {{ $errors->has('no_po') ? ' has-error' : '' }}">
          {!! Form::label('no_po', 'No. PO (F9)') !!}
          <div class="input-group">
            {!! Form::text('no_po', null, ['class'=>'form-control','placeholder' => 'No. PO', 'maxlength' => 20, 'onkeydown' => 'keyPressedNoPo(event)', 'onchange' => 'validateNoPo()', 'id' => 'no_po']) !!}
            <span class="input-group-btn">
              <button id="btnpopupnopo" type="button" class="btn btn-info" data-toggle="modal" data-target="#poModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
          {!! $errors->first('no_po', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="wp1">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-4 {{ $errors->has('nm_proyek') ? ' has-error' : '' }}">
          {!! Form::label('nm_proyek', 'Nama Proyek (*)') !!}
          {!! Form::textarea('nm_proyek', null, ['class'=>'form-control', 'placeholder' => 'Nama Proyek', 'rows' => '3', 'maxlength' => 100, 'style' => 'resize:vertical', 'required', 'id' => 'nm_proyek']) !!}
          {!! $errors->first('nm_proyek', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-4 {{ $errors->has('lok_proyek') ? ' has-error' : '' }}">
          {!! Form::label('lok_proyek', 'Lokasi Proyek (*)') !!}
          {!! Form::textarea('lok_proyek', null, ['class'=>'form-control', 'placeholder' => 'Lokasi Proyek', 'rows' => '3', 'maxlength' => 100, 'style' => 'resize:vertical', 'required', 'id' => 'lok_proyek']) !!}
          {!! $errors->first('lok_proyek', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-3 {{ $errors->has('pic_pp') ? ' has-error' : '' }}">
          {!! Form::label('pic_pp', 'PIC (F9) (*)') !!}
          <div class="input-group">
            {!! Form::text('pic_pp', null, ['class'=>'form-control','placeholder' => 'PIC', 'maxlength' => 50, 'onkeydown' => 'keyPressedKaryawan(event)', 'onchange' => 'validateKaryawan()', 'id' => 'pic_pp', 'required']) !!}
            <span class="input-group-btn">
              <button id="btnpopupkaryawan" type="button" class="btn btn-info" data-toggle="modal" data-target="#karyawanModal">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
          {!! $errors->first('pic_pp', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-5 {{ $errors->has('nm_pic') ? ' has-error' : '' }}">
          {!! Form::label('nm_pic', 'Nama PIC') !!}
          {!! Form::text('nm_pic', null, ['class'=>'form-control','placeholder' => 'Nama PIC', 'disabled'=>'', 'id' => 'nm_pic']) !!}
          {!! $errors->first('nm_pic', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-8 {{ $errors->has('bagian_pic') ? ' has-error' : '' }}">
          {!! Form::label('bagian_pic', 'Bagian PIC') !!}
          {!! Form::text('bagian_pic', null, ['class'=>'form-control','placeholder' => 'Bagian PIC', 'disabled'=>'', 'id' => 'bagian_pic']) !!}
          {!! $errors->first('bagian_pic', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-2 {{ $errors->has('tgl_laksana1') ? ' has-error' : '' }}">
          {!! Form::label('tgl_laksana1', 'Tgl Mulai') !!}
          @if (empty($ehstwp1->tgl_laksana1))
            {!! Form::date('tgl_laksana1', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Mulai', 'onchange' => 'changeTglPelaksanaan()', 'id' => 'tgl_laksana1']) !!}
          @else
            {!! Form::date('tgl_laksana1', \Carbon\Carbon::parse($ehstwp1->tgl_laksana1), ['class'=>'form-control','placeholder' => 'Tgl Mulai', 'onchange' => 'changeTglPelaksanaan()', 'id' => 'tgl_laksana1']) !!}
          @endif
          {!! $errors->first('tgl_laksana1', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('jam_laksana1') ? ' has-error' : '' }}">
          {!! Form::label('jam_laksana1', 'Jam Mulai') !!}
          @if (empty($ehstwp1->tgl_laksana1))
            {!! Form::time('jam_laksana1', \Carbon\Carbon::now()->format('H:i'), ['class'=>'form-control','placeholder' => 'Jam Mulai', 'id' => 'jam_laksana1']) !!}
          @else
            {!! Form::time('jam_laksana1', \Carbon\Carbon::parse($ehstwp1->tgl_laksana1)->format('H:i'), ['class'=>'form-control','placeholder' => 'Jam Mulai', 'id' => 'jam_laksana1']) !!}
          @endif
          {!! $errors->first('jam_laksana1', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('tgl_laksana2') ? ' has-error' : '' }}">
          {!! Form::label('tgl_laksana2', 'Tgl Pel. (Selesai)') !!}
          @if (empty($ehstwp1->tgl_laksana2))
            {!! Form::date('tgl_laksana2', \Carbon\Carbon::now()->addDays(30), ['class'=>'form-control','placeholder' => 'Tgl Selesai', 'id' => 'tgl_laksana2', 'disabled'=>'']) !!}
          @else
            {!! Form::date('tgl_laksana2', \Carbon\Carbon::parse($ehstwp1->tgl_laksana2), ['class'=>'form-control','placeholder' => 'Tgl Selesai', 'id' => 'tgl_laksana2', 'disabled'=>'']) !!}
          @endif
          {!! $errors->first('tgl_laksana2', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('jam_laksana2') ? ' has-error' : '' }}">
          {!! Form::label('jam_laksana2', 'Jam Selesai') !!}
          @if (empty($ehstwp1->tgl_laksana2))
            {!! Form::time('jam_laksana2', \Carbon\Carbon::now()->format('H:i'), ['class'=>'form-control','placeholder' => 'Jam Selesai', 'id' => 'jam_laksana2']) !!}
          @else
            {!! Form::time('jam_laksana2', \Carbon\Carbon::parse($ehstwp1->tgl_laksana2)->format('H:i'), ['class'=>'form-control','placeholder' => 'Jam Selesai', 'id' => 'jam_laksana2']) !!}
          @endif
          {!! $errors->first('jam_laksana2', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-2 {{ $errors->has('kat_kerja') ? ' has-error' : '' }}">
          {!! Form::label('kat_kerja', 'Kategori Pekerjaan: ') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('kat_kerja_sfp') ? ' has-error' : '' }}">
          @if (empty($ehstwp1->kat_kerja_sfp))
            {!! Form::checkbox('kat_kerja_sfp', 'T', null, ['id'=>'kat_kerja_sfp', 'class'=>'icheckbox_square-blue']) !!} Safe Work Permit
          @else
            @if ($ehstwp1->kat_kerja_sfp === "T")
              {!! Form::checkbox('kat_kerja_sfp', 'T', true, ['id'=>'kat_kerja_sfp', 'class'=>'icheckbox_square-blue']) !!} Safe Work Permit
            @else
              {!! Form::checkbox('kat_kerja_sfp', 'T', false, ['id'=>'kat_kerja_sfp', 'class'=>'icheckbox_square-blue']) !!} Safe Work Permit
            @endif
          @endif
          {!! $errors->first('kat_kerja_sfp', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('kat_kerja_hwp') ? ' has-error' : '' }}">
          @if (empty($ehstwp1->kat_kerja_hwp))
            {!! Form::checkbox('kat_kerja_hwp', 'T', null, ['id'=>'kat_kerja_hwp', 'class'=>'icheckbox_square-blue']) !!} Hot Work Permit
          @else
            @if ($ehstwp1->kat_kerja_hwp === "T")
              {!! Form::checkbox('kat_kerja_hwp', 'T', true, ['id'=>'kat_kerja_hwp', 'class'=>'icheckbox_square-blue']) !!} Hot Work Permit
            @else
              {!! Form::checkbox('kat_kerja_hwp', 'T', false, ['id'=>'kat_kerja_hwp', 'class'=>'icheckbox_square-blue']) !!} Hot Work Permit
            @endif
          @endif
          {!! $errors->first('kat_kerja_hwp', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('kat_kerja_csp') ? ' has-error' : '' }}">
          @if (empty($ehstwp1->kat_kerja_csp))
            {!! Form::checkbox('kat_kerja_csp', 'T', null, ['id'=>'kat_kerja_csp', 'class'=>'icheckbox_square-blue']) !!} Confined Space Permit
          @else
            @if ($ehstwp1->kat_kerja_csp === "T")
              {!! Form::checkbox('kat_kerja_csp', 'T', true, ['id'=>'kat_kerja_csp', 'class'=>'icheckbox_square-blue']) !!} Confined Space Permit
            @else
              {!! Form::checkbox('kat_kerja_csp', 'T', false, ['id'=>'kat_kerja_csp', 'class'=>'icheckbox_square-blue']) !!} Confined Space Permit
            @endif
          @endif
          {!! $errors->first('kat_kerja_csp', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-2 {{ $errors->has('kat_kerja') ? ' has-error' : '' }}">
          {{-- {!! Form::label('kat_kerja', 'Kategori Pekerjaan: ') !!} --}}
        </div>
        <div class="col-sm-2 {{ $errors->has('kat_kerja_hpp') ? ' has-error' : '' }}">
          @if (empty($ehstwp1->kat_kerja_hpp))
            {!! Form::checkbox('kat_kerja_hpp', 'T', null, ['id'=>'kat_kerja_hpp', 'class'=>'icheckbox_square-blue']) !!} High Place Permit
          @else
            @if ($ehstwp1->kat_kerja_hpp === "T")
              {!! Form::checkbox('kat_kerja_hpp', 'T', true, ['id'=>'kat_kerja_hpp', 'class'=>'icheckbox_square-blue']) !!} High Place Permit
            @else
              {!! Form::checkbox('kat_kerja_hpp', 'T', false, ['id'=>'kat_kerja_hpp', 'class'=>'icheckbox_square-blue']) !!} High Place Permit
            @endif
          @endif
          {!! $errors->first('kat_kerja_hpp', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('kat_kerja_ele') ? ' has-error' : '' }}">
          @if (empty($ehstwp1->kat_kerja_ele))
            {!! Form::checkbox('kat_kerja_ele', 'T', null, ['id'=>'kat_kerja_ele', 'class'=>'icheckbox_square-blue']) !!} Electrical
          @else
            @if ($ehstwp1->kat_kerja_ele === "T")
              {!! Form::checkbox('kat_kerja_ele', 'T', true, ['id'=>'kat_kerja_ele', 'class'=>'icheckbox_square-blue']) !!} Electrical
            @else
              {!! Form::checkbox('kat_kerja_ele', 'T', false, ['id'=>'kat_kerja_ele', 'class'=>'icheckbox_square-blue']) !!} Electrical
            @endif
          @endif
          {!! $errors->first('kat_kerja_ele', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('kat_kerja_oth') ? ' has-error' : '' }}">
          @if (empty($ehstwp1->kat_kerja_oth))
            {!! Form::checkbox('kat_kerja_oth', 'T', null, ['id' => 'kat_kerja_oth', 'class'=>'icheckbox_square-blue', 'onclick' => 'changeOth()']) !!} Others
          @else
            @if ($ehstwp1->kat_kerja_oth === "T")
              {!! Form::checkbox('kat_kerja_oth', 'T', true, ['id' => 'kat_kerja_oth', 'class'=>'icheckbox_square-blue', 'onclick' => 'changeOth()']) !!} Others
            @else
              {!! Form::checkbox('kat_kerja_oth', 'T', false, ['id' => 'kat_kerja_oth', 'class'=>'icheckbox_square-blue', 'onclick' => 'changeOth()']) !!} Others
            @endif
          @endif
          {!! $errors->first('kat_kerja_oth', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-2 {{ $errors->has('kerja_ket') ? ' has-error' : '' }}">
        </div>
        <div class="col-sm-6 {{ $errors->has('kat_kerja_ket') ? ' has-error' : '' }}">
          {!! Form::label('kat_kerja_ket', 'Keterangan Kategori Pekerjaan (*)') !!}
          @if (empty($ehstwp1->kat_kerja_oth))
            {!! Form::textarea('kat_kerja_ket', null, ['class'=>'form-control', 'placeholder' => 'Keterangan Kategori Pekerjaan', 'rows' => '3', 'maxlength' => 50, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
          @else
            @if ($ehstwp1->kat_kerja_oth === "T")
              {!! Form::textarea('kat_kerja_ket', null, ['class'=>'form-control', 'placeholder' => 'Keterangan Kategori Pekerjaan', 'rows' => '3', 'maxlength' => 50, 'style' => 'resize:vertical', 'required']) !!}
            @else
              {!! Form::textarea('kat_kerja_ket', null, ['class'=>'form-control', 'placeholder' => 'Keterangan Kategori Pekerjaan', 'rows' => '3', 'maxlength' => 50, 'style' => 'resize:vertical', 'readonly'=>'readonly']) !!}
            @endif
          @endif
          {!! $errors->first('kat_kerja_ket', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-8 {{ $errors->has('alat_pakai') ? ' has-error' : '' }}">
          {!! Form::label('alat_pakai', 'Alat yang digunakan') !!}
          {!! Form::textarea('alat_pakai', null, ['class'=>'form-control', 'placeholder' => 'Alat yang digunakan', 'rows' => '3', 'maxlength' => 200, 'style' => 'resize:vertical', 'onkeydown' => 'keyPressedAlatPakai(event)', 'id' => 'alat_pakai']) !!}
          {!! $errors->first('alat_pakai', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="mp">
    <div class="box-body" id="field-mp">
      @if (!empty($ehstwp1->no_wp))
          @foreach ($ehstwp1->ehstWp2Mps()->get() as $ehstWp2Mp)
            <div class="row" id="field_mp_{{ $loop->iteration }}">
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title" id="box_mp_{{ $loop->iteration }}">Member Ke-{{ $loop->iteration }}</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                      </button>
                      <button id="btndelete_mp_{{ $loop->iteration }}" name="btndelete_mp_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Member" onclick="deleteMember(this)">
                        <i class="fa fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row form-group">
                      <div class="col-sm-4">
                        <label name="nm_mp_{{ $loop->iteration }}">Nama (*)</label>
                        <div class="input-group">
                          <input type="text" id="nm_mp_{{ $loop->iteration }}" name="nm_mp_{{ $loop->iteration }}" required class="form-control" placeholder="Nama" onkeydown="keyPressedMp(this, event)" maxlength="50" value="{{ $ehstWp2Mp->nm_mp }}">
                          <span class="input-group-btn">
                            <button id="btnpopupmp_{{ $loop->iteration }}" type="button" class="btn btn-info" onclick="popupMp(this)" data-toggle="modal" data-target="#mpModal">
                              <span class="glyphicon glyphicon-search"></span>
                            </button>
                          </span>
                        </div>
                        <input type="hidden" id="ehst_wp2_mp_id_{{ $loop->iteration }}" name="ehst_wp2_mp_id_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($ehstWp2Mp->id) }}">
                        <input type="hidden" id="ehst_wp2_mp_seq_{{ $loop->iteration }}" name="ehst_wp2_mp_seq_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $ehstWp2Mp->no_seq }}">
                      </div>
                      <div class="col-sm-3">
                        <label name="no_id_{{ $loop->iteration }}">No. Identitas</label>
                        <input type="text" id="no_id_{{ $loop->iteration }}" name="no_id_{{ $loop->iteration }}" class="form-control" placeholder="No. Identitas" maxlength="20" value="{{ $ehstWp2Mp->no_id }}">
                      </div>
                      <div class="col-sm-5">
                        <label name="ket_remarks_{{ $loop->iteration }}">Remarks</label>
                        <input type="text" id="ket_remarks_{{ $loop->iteration }}" name="ket_remarks_{{ $loop->iteration }}" class="form-control" placeholder="Remarks" maxlength="50" value="{{ $ehstWp2Mp->ket_remarks }}">
                      </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="row form-group">
                      <div class="col-sm-4">
                        <label name="pict_id_{{ $loop->iteration }}">Foto Identitas (KTP) (*)</label>
                        @if (!empty($ehstWp2Mp->pict_id))
                          <input id="pict_id_{{ $loop->iteration }}" name="pict_id_{{ $loop->iteration }}" type="file" accept=".jpg,.jpeg,.png">
                          <p>
                            <img src="{{ $ehstWp2Mp->pictId() }}" alt="File Not Found" class="img-rounded img-responsive">
                            <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('ehstwp2mps.deleteimage', base64_encode($ehstWp2Mp->id)) }}"><span class="glyphicon glyphicon-remove"></span></a>
                          </p>
                        @else 
                          <input id="pict_id_{{ $loop->iteration }}" name="pict_id_{{ $loop->iteration }}" type="file" accept=".jpg,.jpeg,.png" required>
                        @endif
                      </div>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          @endforeach
          {!! Form::hidden('jml_row_mp', $ehstwp1->ehstWp2Mps()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_mp']) !!}
      @else
        {!! Form::hidden('jml_row_mp', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_mp']) !!}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
        <button id="addRowMp" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Member"><span class="glyphicon glyphicon-plus"></span> Add Member</button>
      </p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="k3">
    <div class="box-body" id="field-k3">
      @if (!empty($ehstwp1->no_wp))
        @foreach ($ehstwp1->ehstWp2K3s()->get() as $ehstWp2K3)
          <div class="row" id="field_k3_{{ $loop->iteration }}">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box_k3_{{ $loop->iteration }}">Identifikasi Bahaya Ke-{{ $loop->iteration }}</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button id="btndelete_k3_{{ $loop->iteration }}" name="btndelete_k3_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Identifikasi Bahaya" onclick="deleteK3(this)">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-3">
                      <label name="ket_aktifitas_{{ $loop->iteration }}">Aktifitas / Produk / Jasa (*)</label>
                      <textarea id="ket_aktifitas_{{ $loop->iteration }}" name="ket_aktifitas_{{ $loop->iteration }}" required class="form-control" placeholder="Aktifitas / Produk / Jasa" rows="3" maxlength="100" style="resize:vertical">{{ $ehstWp2K3->ket_aktifitas }}</textarea>
                      <input type="hidden" id="ehst_wp2_k3_id_{{ $loop->iteration }}" name="ehst_wp2_k3_id_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($ehstWp2K3->id) }}">
                      <input type="hidden" id="ehst_wp2_k3_seq_{{ $loop->iteration }}" name="ehst_wp2_k3_seq_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $ehstWp2K3->no_seq }}">
                    </div>
                    <div class="col-sm-3">
                      <label name="ib_potensi_{{ $loop->iteration }}">Potensi Bahaya</label>
                      <div class="input-group">
                        <textarea id="ib_potensi_{{ $loop->iteration }}" name="ib_potensi_{{ $loop->iteration }}" required class="form-control" placeholder="Potensi Bahaya" rows="3" maxlength="200" style="resize:vertical">{{ $ehstWp2K3->ib_potensi }}</textarea>
                        <span class="input-group-btn">
                          <button id="btnpopuppotensi_{{ $loop->iteration }}" name="btnpopuppotensi_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Potensi" onclick="popupPotensi(this)" data-toggle="modal" data-target="#tcehs024mModal">
                            <span class="glyphicon glyphicon-search"></span>
                          </button>
                        </span>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <label name="ib_resiko_{{ $loop->iteration }}">Resiko</label>
                      <div class="input-group">
                        <textarea id="ib_resiko_{{ $loop->iteration }}" name="ib_resiko_{{ $loop->iteration }}" required class="form-control" placeholder="Resiko" rows="3" maxlength="200" style="resize:vertical">{{ $ehstWp2K3->ib_resiko }}</textarea>
                        <span class="input-group-btn">
                          <button id="btnpopupresiko_{{ $loop->iteration }}" name="btnpopupresiko_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Resiko" onclick="popupResiko(this)" data-toggle="modal" data-target="#tcehs025mModal">
                            <span class="glyphicon glyphicon-search"></span>
                          </button>
                        </span>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <label name="pencegahan_{{ $loop->iteration }}">Tindakan Pencegahan</label>
                      <div class="input-group">
                        <textarea id="pencegahan_{{ $loop->iteration }}" name="pencegahan_{{ $loop->iteration }}" required class="form-control" placeholder="Tindakan Pencegahan" rows="3" maxlength="200" style="resize:vertical">{{ $ehstWp2K3->pencegahan }}</textarea>
                        <span class="input-group-btn">
                          <button id="btnpopuppencegahan_{{ $loop->iteration }}" name="btnpopuppencegahan_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Pencegahan" onclick="popupPencegahan(this)" data-toggle="modal" data-target="#tcehs026mModal">
                            <span class="glyphicon glyphicon-search"></span>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        @endforeach
        {!! Form::hidden('jml_row_k3', $ehstwp1->ehstWp2K3s()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_k3']) !!}
      @else
        {!! Form::hidden('jml_row_k3', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_k3']) !!}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
        <button id="addRowK3" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Identifikasi Bahaya"><span class="glyphicon glyphicon-plus"></span> Add Identifikasi Bahaya</button>
      </p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="env">
    <div class="box-body" id="field-env">
      @if (!empty($ehstwp1->no_wp))
        @foreach ($ehstwp1->ehstWp2Envs()->get() as $ehstWp2Env)
          <div class="row" id="field_env_{{ $loop->iteration }}">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box_env_{{ $loop->iteration }}">Identifikasi Aspek Dampak Lingkungan Ke-{{ $loop->iteration }}</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button id="btndelete_env_{{ $loop->iteration }}" name="btndelete_env_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Identifikasi Aspek Dampak Lingkungan" onclick="deleteEnv(this)">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-3">
                      <label name="ket_aktifitas_env_{{ $loop->iteration }}">Aktifitas / Produk / Jasa (*)</label>
                      <textarea id="ket_aktifitas_env_{{ $loop->iteration }}" name="ket_aktifitas_env_{{ $loop->iteration }}" required class="form-control" placeholder="Aktifitas / Produk / Jasa" rows="3" maxlength="100" style="resize:vertical">{{ $ehstWp2Env->ket_aktifitas }}</textarea>
                      <input type="hidden" id="ehst_wp2_env_id_{{ $loop->iteration }}" name="ehst_wp2_env_id_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ base64_encode($ehstWp2Env->id) }}">
                      <input type="hidden" id="ehst_wp2_env_seq_{{ $loop->iteration }}" name="ehst_wp2_env_seq_{{ $loop->iteration }}" class="form-control" readonly="readonly" value="{{ $ehstWp2Env->no_seq }}">
                    </div>
                    <div class="col-sm-3">
                      <label name="ket_aspek_{{ $loop->iteration }}">Aspek Dampak</label>
                      <div class="input-group">
                        <textarea id="ket_aspek_{{ $loop->iteration }}" name="ket_aspek_{{ $loop->iteration }}" required class="form-control" placeholder="Aspek Dampak" rows="3" maxlength="200" style="resize:vertical">{{ $ehstWp2Env->ket_aspek }}</textarea>
                        <span class="input-group-btn">
                          <button id="btnpopupaspek_{{ $loop->iteration }}" name="btnpopupaspek_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Aspek" onclick="popupAspek(this)" data-toggle="modal" data-target="#tcehs023mModal">
                            <span class="glyphicon glyphicon-search"></span>
                          </button>
                        </span>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <label name="ket_dampak_{{ $loop->iteration }}">Dampak Lingkungan</label>
                      <div class="input-group">
                        <textarea id="ket_dampak_{{ $loop->iteration }}" name="ket_dampak_{{ $loop->iteration }}" required class="form-control" placeholder="Dampak Lingkungan" rows="3" maxlength="200" style="resize:vertical">{{ $ehstWp2Env->ket_dampak }}</textarea>
                        <span class="input-group-btn">
                          <button id="btnpopupdampak_{{ $loop->iteration }}" name="btnpopupdampak_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Dampak" onclick="popupDampak(this)" data-toggle="modal" data-target="#tcehs021mModal">
                            <span class="glyphicon glyphicon-search"></span>
                          </button>
                        </span>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <label name="pencegahan_env_{{ $loop->iteration }}">Tindakan Pencegahan</label>
                      <div class="input-group">
                        <textarea id="pencegahan_env_{{ $loop->iteration }}" name="pencegahan_env_{{ $loop->iteration }}" required class="form-control" placeholder="Tindakan Pencegahan" rows="3" maxlength="200" style="resize:vertical">{{ $ehstWp2Env->pencegahan }}</textarea>
                        <span class="input-group-btn">
                          <button id="btnpopupkendali_{{ $loop->iteration }}" name="btnpopupkendali_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih Kendali" onclick="popupKendali(this)" data-toggle="modal" data-target="#tcehs022mModal">
                            <span class="glyphicon glyphicon-search"></span>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        @endforeach
        {!! Form::hidden('jml_row_env', $ehstwp1->ehstWp2Envs()->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_env']) !!}
      @else
        {!! Form::hidden('jml_row_env', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_env']) !!}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
        <button id="addRowEnv" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Identifikasi Aspek Dampak Lingkungan"><span class="glyphicon glyphicon-plus"></span> Add Identifikasi Aspek Dampak Lingkungan</button>
      </p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
</div>
<!-- /.tab-content -->

<div class="box-footer">
  {!! Form::submit('Save as Draft', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @if (!empty($ehstwp1->no_wp))
    &nbsp;&nbsp;
    <button id="btn-submit" type="button" class="btn btn-success">Submit WP</button>
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Delete WP</button>
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-primary" href="{{ route('ehstwp1s.index') }}">Cancel</a>
  &nbsp;&nbsp;
  <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal PP -->
@include('ehs.popup.ppModal')
<!-- Modal PO -->
@include('ehs.popup.poModal')
<!-- Modal Karyawan -->
@include('ehs.popup.karyawanModal')
<!-- Modal MP -->
@include('ehs.popup.mpModal')
<!-- Modal Potensi -->
@include('ehs.popup.tcehs024mModal')
<!-- Modal Resiko -->
@include('ehs.popup.tcehs025mModal')
<!-- Modal Pencegahan -->
@include('ehs.popup.tcehs026mModal')
<!-- Modal Aspek -->
@include('ehs.popup.tcehs023mModal')
<!-- Modal Dampak -->
@include('ehs.popup.tcehs021mModal')
<!-- Modal Kendali -->
@include('ehs.popup.tcehs022mModal')

@section('scripts')
<script type="text/javascript">
  document.getElementById("no_pp").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function changeStatusPo() {
    var status_po = document.getElementById("status_po").value;
    if(status_po === "T") {
      $('#no_pp').removeAttr('readonly');
      $('#no_po').removeAttr('readonly');
    } else {
      document.getElementById("no_pp").value = "";
      document.getElementById("no_po").value = "";
      $('#no_pp').attr('readonly', 'readonly');
      $('#no_po').attr('readonly', 'readonly');
    }
  }

  changeStatusPo();

  function validasiSize() {
    $("input[name^='pict_id_']").bind('change', function() {
      let filesize = this.files[0].size // On older browsers this can return NULL.
      let filesizeMB = (filesize / (1024*1024)).toFixed(2);
      if(filesizeMB > 8) {
        var info = "Size File tidak boleh > 8 MB";
        swal(info, "Perhatikan inputan anda!", "warning");
        this.value = null;
      }
    });
  }

  validasiSize();

  $("#btn-delete").click(function(){
    var no_wp = document.getElementById("no_wp").value;
    var no_rev = document.getElementById("no_rev").value;
    if(no_wp !== "" && no_rev !== "") {
      var msg = 'Anda yakin menghapus data ini?';
      var txt = 'No. WP: ' + no_wp + ', No. Rev: ' + no_rev;
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
        var urlRedirect = "{{ route('ehstwp1s.delete', ['param', 'param2']) }}";
        urlRedirect = urlRedirect.replace('param2', window.btoa(no_rev));
        urlRedirect = urlRedirect.replace('param', window.btoa(no_wp));
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
    var no_wp = document.getElementById("no_wp").value;
    var tgl_wp = document.getElementById("tgl_wp").value;
    var no_pp = document.getElementById("no_pp").value;
    var nm_proyek = document.getElementById("nm_proyek").value;
    var lok_proyek = document.getElementById("lok_proyek").value;
    var pic_pp = document.getElementById("pic_pp").value;
    var valid_kat_kerja = "T";
    var kat_kerja_oth = document.getElementById("kat_kerja_oth").checked;
    if(kat_kerja_oth == true) {
      var kat_kerja_ket = document.getElementById("kat_kerja_ket").value;
      if(kat_kerja_ket === "") {
        valid_kat_kerja = "F";
      }
    }

    var jml_row_mp = document.getElementById("jml_row_mp").value.trim();
    if(jml_row_mp === "") {
      jml_row_mp = 0;
    } else {
      jml_row_mp = Number(jml_row_mp);
    }
    var jml_row_k3 = document.getElementById("jml_row_k3").value.trim();
    if(jml_row_k3 === "") {
      jml_row_k3 = 0;
    } else {
      jml_row_k3 = Number(jml_row_k3);
    }
    var jml_row_env = document.getElementById("jml_row_env").value.trim();
    if(jml_row_env === "") {
      jml_row_env = 0;
    } else {
      jml_row_env = Number(jml_row_env);
    }

    var status_po = document.getElementById("status_po").value;
    if(status_po !== "T") {
      no_pp = "-";
    }
    
    if(no_wp === "" || tgl_wp === "" || no_pp === "" || nm_proyek === "" || lok_proyek === "" || pic_pp === "" || valid_kat_kerja === "F") {
      var info = "Isi data yang tidak boleh kosong! (No. PP, Nama Proyek, Lokasi Proyek, PIC, & Keterangan Kategori Pekerjaan)";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else if(jml_row_mp < 1 || jml_row_k3 < 1 || jml_row_env < 1) {
      var info = "Data B. List Member, C. Identifikasi Bahaya, & D. Identifikasi Aspek Dampak Lingkungan tidak boleh kosong!";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var valid_tgl = "T";
      var tgl_laksana1 = document.getElementById("tgl_laksana1").value.trim();
      var tgl_laksana2 = document.getElementById("tgl_laksana2").value.trim();

      if(tgl_laksana1 !== "" && tgl_laksana2 !== "") {
        var date_laksana1 = new Date(tgl_laksana1);
        var date_laksana2 = new Date(tgl_laksana2);
        var selisih = date_laksana2-date_laksana1;
        selisih = Number(selisih);
        selisih = selisih/1000/60;
        if(selisih < 0) {
          valid_tgl = "F";
        }
      }
      if(valid_tgl === "F") {
        var info = "Tgl Pelaksanaan (Selesai) tidak boleh < Tgl Pelaksanaan (Mulai)";
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        var msg = 'Anda yakin submit data ini? Data yang tidak lengkap tidak akan diproses.';
        var txt = 'No. WP: ' + no_wp;
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
    }
  });

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      //additional input validations can be done hear
      var valid_tgl = "T";
      var tgl_laksana1 = document.getElementById("tgl_laksana1").value.trim();
      var tgl_laksana2 = document.getElementById("tgl_laksana2").value.trim();

      if(tgl_laksana1 !== "" && tgl_laksana2 !== "") {
        var date_laksana1 = new Date(tgl_laksana1);
        var date_laksana2 = new Date(tgl_laksana2);
        var selisih = date_laksana2-date_laksana1;
        selisih = Number(selisih);
        selisih = selisih/1000/60;
        if(selisih < 0) {
          valid_tgl = "F";
        }
      }
      if(valid_tgl === "F") {
        var info = "Tgl Pelaksanaan (Selesai) tidak boleh < Tgl Pelaksanaan (Mulai)";
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        var no_wp = document.getElementById("no_wp").value;
        var msg = 'Anda yakin save data ini?';
        if(no_wp === "") {
          var txt = '';
        } else {
          var txt = 'No. WP: ' + no_wp;
        }
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
    }
  });

  function keyPressedNoPp(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnopp').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('no_po').focus();
    }
  }

  function keyPressedNoPo(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnopo').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      $("#wp").removeClass("active"); // add class to the one we clicked 
      $("#wp1").addClass("active");
      $("#nav_wp").removeClass("active"); // add class to the one we clicked 
      $("#nav_wp1").addClass("active");
      document.getElementById('nm_proyek').focus();
    }
  }

  function keyPressedAlatPakai(e) {
    if(e.keyCode == 9) { //TAB
      e.preventDefault();
      $("#wp1").removeClass("active"); // add class to the one we clicked 
      $("#mp").addClass("active");
      $("#nav_wp1").removeClass("active"); // add class to the one we clicked 
      $("#nav_mp").addClass("active");
      var jml_row = document.getElementById("jml_row_mp").value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        document.getElementById('nm_mp_1').focus();
      }
    }
  }

  function keyPressedMp(ths, e) {
    if(e.keyCode == 120) { //F9
      var row = ths.id.replace('nm_mp_', '');
      var btnid = "#btnpopupmp_" + row;
      $(btnid).click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      var row = ths.id.replace('nm_mp_', '');
      document.getElementById("no_id_" + row).focus();
    }
  }

  function keyPressedKaryawan(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupkaryawan').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('tgl_laksana1').focus();
    }
  }

  $(document).ready(function(){
    $("#btnpopupnopp").click(function(){
      popupNoPp();
    });

    $("#btnpopupnopo").click(function(){
      popupNoPo();
    });

    $("#btnpopupkaryawan").click(function(){
      popupKaryawan();
    });
  });

  function changeKdSite() {
    var kd_site = document.getElementById("kd_site").value;
    validateNoPp("F");
  }

  function popupNoPp() {
    var myHeading = "<p>Popup PP</p>";
    $("#ppModalLabel").html(myHeading);
    var kd_site = document.getElementById("kd_site").value;
    var url = '{{ route('datatables.popupPpBaans', 'param') }}';
    url = url.replace('param', window.btoa(kd_site));
    var lookupPp = $('#lookupPp').DataTable({
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
      "order": [[1, 'desc'],[0, 'desc']],
      columns: [
        { data: 'no_pp', name: 'no_pp'},
        { data: 'tgl_pp', name: 'tgl_pp'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupPp tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupPp.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_pp").value = value["no_pp"];
            $('#ppModal').modal('hide');
            validateNoPp("T");
          });
        });
        $('#ppModal').on('hidden.bs.modal', function () {
          var no_pp = document.getElementById("no_pp").value.trim();
          if(no_pp === '') {
            document.getElementById("no_po").value = "";
            $('#no_pp').focus();
          } else {
            $('#no_po').focus();
          }
        });
      },
    });
  }

  function validateNoPp(warning) {
    var no_pp = document.getElementById("no_pp").value.trim();
    if(no_pp !== '') {
      var kd_site = document.getElementById("kd_site").value;
      var url = '{{ route('datatables.validasiPpBaan', ['param', 'param2']) }}';
      url = url.replace('param2', window.btoa(no_pp));
      url = url.replace('param', window.btoa(kd_site));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_pp").value = result["no_pp"];
          validateNoPpDuplicate(warning);
          validateNoPo();
        } else {
          document.getElementById("no_pp").value = "";
          document.getElementById("no_po").value = "";
          document.getElementById("no_pp").focus();
          if(warning === "T") {
            swal("No. PP tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
          }
        }
      });
    } else {
      document.getElementById("no_pp").value = "";
      document.getElementById("no_po").value = "";
    }
  }

  function validateNoPpDuplicate(warning) {
    var no_pp = document.getElementById("no_pp").value.trim();
    if(no_pp !== '') {
      var no_wp = document.getElementById("no_wp").value.trim();
      if(no_wp === "") {
        no_wp = "-";
      }
      var url = '{{ route('datatables.validasiPpWp', ['param', 'param2']) }}';
      url = url.replace('param2', window.btoa(no_pp));
      url = url.replace('param', window.btoa(no_wp));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_pp").value = "";
          document.getElementById("no_po").value = "";
          document.getElementById("no_pp").focus();
          if(warning === "T") {
            swal("No. PP tidak valid! Sudah digunakan di WP: " + result["no_wp"], "Perhatikan inputan anda! 1 PP hanya untuk 1 WP.", "error");
          }
        }
      });
    } else {
      document.getElementById("no_pp").value = "";
      document.getElementById("no_po").value = "";
    }
  }

  function popupNoPo() {
    var myHeading = "<p>Popup PO</p>";
    $("#poModalLabel").html(myHeading);
    var no_pp = document.getElementById('no_pp').value.trim();
    if(no_pp === '') {
      no_pp = "-";
    }
    var url = '{{ route('datatables.popupPoBaans', 'param') }}';
    url = url.replace('param', window.btoa(no_pp));
    var lookupPo = $('#lookupPo').DataTable({
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
      "order": [[1, 'desc'],[0, 'desc']],
      columns: [
        { data: 'no_po', name: 'no_po'},
        { data: 'tgl_po', name: 'tgl_po'},
        { data: 'no_pp', name: 'no_pp'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupPo tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupPo.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_po").value = value["no_po"];
            document.getElementById("no_pp").value = value["no_pp"];
            $('#poModal').modal('hide');
            validateNoPo();
          });
        });
        $('#poModal').on('hidden.bs.modal', function () {
          var no_po = document.getElementById("no_po").value.trim();
          if(no_po === '') {
            $('#no_po').focus();
          } else {
            $("#wp").removeClass("active"); // add class to the one we clicked 
            $("#wp1").addClass("active");
            $("#nav_wp").removeClass("active"); // add class to the one we clicked 
            $("#nav_wp1").addClass("active");
            document.getElementById('nm_proyek').focus();
          }
        });
      },
    });
  }

  function validateNoPo() {
    var no_pp = document.getElementById('no_pp').value.trim();
    var no_po = document.getElementById("no_po").value.trim();
    if(no_pp !== '' && no_po !== '') {
      var url = '{{ route('datatables.validasiPoBaan', ['param', 'param2']) }}';
      url = url.replace('param2', window.btoa(no_po));
      url = url.replace('param', window.btoa(no_pp));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_po").value = result["no_po"];
          $("#wp").removeClass("active"); // add class to the one we clicked 
          $("#wp1").addClass("active");
          $("#nav_wp").removeClass("active"); // add class to the one we clicked 
          $("#nav_wp1").addClass("active");
          document.getElementById('nm_proyek').focus();
        } else {
          document.getElementById("no_po").value = "";
          $("#wp1").removeClass("active");
          $("#wp").addClass("active");
          $("#nav_wp1").removeClass("active");
          $("#nav_wp").addClass("active");
          document.getElementById("no_po").focus();
          swal("No. PO tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_po").value = "";
    }
  }

  function popupKaryawan() {
    var myHeading = "<p>Popup PIC</p>";
    $("#karyawanModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupKaryawanPicWps') }}';
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
        { data: 'kd_pt', name: 'kd_pt'},
        { data: 'desc_dep', name: 'desc_dep'},
        { data: 'desc_div', name: 'desc_div'},
        { data: 'email', name: 'email'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupKaryawan tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupKaryawan.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("pic_pp").value = value["npk"];
            document.getElementById("nm_pic").value = value["nama"];
            document.getElementById("bagian_pic").value = value["desc_div"] + " - " + value["desc_dep"];
            $('#karyawanModal').modal('hide');
            validateKaryawan();
          });
        });
        $('#karyawanModal').on('hidden.bs.modal', function () {
          var pic_pp = document.getElementById("pic_pp").value.trim();
          if(pic_pp === '') {
            document.getElementById("pic_pp").value = "";
            document.getElementById("nm_pic").value = "";
            document.getElementById("bagian_pic").value = "";
            $('#pic_pp').focus();
          } else {
            $('#tgl_laksana1').focus();
          }
        });
      },
    });
  }

  function validateKaryawan() {
    var pic_pp = document.getElementById("pic_pp").value.trim();
    if(pic_pp !== '') {
      var url = '{{ route('datatables.validasiKaryawanPicWp', 'param') }}';
      url = url.replace('param', window.btoa(pic_pp));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("pic_pp").value = result["npk"];
          document.getElementById("nm_pic").value = result["nama"];
          document.getElementById("bagian_pic").value = result["desc_div"] + " - " + result["desc_dep"];
        } else {
          document.getElementById("pic_pp").value = "";
          document.getElementById("nm_pic").value = "";
          document.getElementById("bagian_pic").value = "";
          document.getElementById("pic_pp").focus();
          swal("PIC tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("pic_pp").value = "";
      document.getElementById("nm_pic").value = "";
      document.getElementById("bagian_pic").value = "";
    }
  }

  function changeOth() {
    var kat_kerja_oth = document.getElementById("kat_kerja_oth").checked;
    if(kat_kerja_oth == true) {
      $('#kat_kerja_ket').attr('required', 'required');
      $('#kat_kerja_ket').removeAttr('readonly');
    } else {
      document.getElementById("kat_kerja_ket").value = "";
      $('#kat_kerja_ket').removeAttr('required');
      $('#kat_kerja_ket').attr('readonly', 'readonly');
    }
  }

  function changeTglPelaksanaan() {
    var tgl_laksana1 = document.getElementById("tgl_laksana1").value.trim();
    if(tgl_laksana1 !== "") {
      var date_laksana1 = new Date(tgl_laksana1);
      date_laksana1.setDate(date_laksana1.getDate() + 30);

      var tahun = date_laksana1.getFullYear();
      var bulan = date_laksana1.getMonth() + 1;
      if(bulan < 10) {
        bulan = "0" + bulan;
      }
      var tgl = date_laksana1.getDate();
      if(tgl < 10) {
        tgl = "0" + tgl;
      }
      document.getElementById("tgl_laksana2").value = tahun + "-" + bulan + "-" + tgl;

      var jam_laksana1 = document.getElementById("jam_laksana1").value.trim();
      var jam_laksana2 = document.getElementById("jam_laksana2").value.trim();
    }
  }

  function popupMp(ths) {
    var myHeading = "<p>Popup List Member</p>";
    $("#mpModalLabel").html(myHeading);
    var kd_supp = '{{ Auth::user()->kd_supp }}'
    var url = '{{ route('datatables.popupEhsWpMp', 'param') }}';
    url = url.replace('param', window.btoa(kd_supp));
    var lookupMp = $('#lookupMp').DataTable({
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
      "order": [[0, 'asc']],
      columns: [
        { data: 'nm_mp', name: 'nm_mp'},
        { data: 'no_id', name: 'no_id'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupMp tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupMp.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopupmp_', '');
            var nm_mp = "nm_mp_" + row;
            var no_id = "no_id_" + row;
            document.getElementById(nm_mp).value = value["nm_mp"];
            document.getElementById(no_id).value = value["no_id"];
            $('#mpModal').modal('hide');
            document.getElementById(no_id).focus();
          });
        });
        $('#mpModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopupmp_', '');
          var nm_mp = "nm_mp_" + row;
          var no_id = "no_id_" + row;
          var nm_mp_value = document.getElementById(nm_mp).value.trim();
          if(nm_mp_value === '') {
            document.getElementById(nm_mp).value = "";
            document.getElementById(nm_mp).focus();
          } else {
            document.getElementById(no_id).focus();
          }
        });
      },
    });
  }

  function popupPotensi(ths) {
    var myHeading = "<p>Popup Potensi Bahaya</p>";
    $("#tcehs024mModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupPotensi') }}';
    var lookupTcehs024m = $('#lookupTcehs024m').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
        { data: 'kd_bahaya', name: 'kd_bahaya'},
        { data: 'nm_bahaya', name: 'nm_bahaya'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupTcehs024m tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupTcehs024m.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopuppotensi_', '');
            var ib_potensi = "ib_potensi_" + row;
            var ib_resiko = "ib_resiko_" + row;
            var potensi_value = document.getElementById(ib_potensi).value.trim();
            if(potensi_value === "") {
              document.getElementById(ib_potensi).value = value["nm_bahaya"] + ".";
            } else {
              document.getElementById(ib_potensi).value += "\n" + value["nm_bahaya"] + ".";
            }
            $('#tcehs024mModal').modal('hide');
            document.getElementById(ib_resiko).focus();
          });
        });
        $('#tcehs024mModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopuppotensi_', '');
          var ib_potensi = "ib_potensi_" + row;
          var ib_resiko = "ib_resiko_" + row;
          var potensi_value = document.getElementById(ib_potensi).value.trim();
          if(potensi_value === '') {
            document.getElementById(ib_potensi).value = "";
            document.getElementById(ib_potensi).focus();
          } else {
            document.getElementById(ib_resiko).focus();
          }
        });
      },
    });
  }

  function popupResiko(ths) {
    var myHeading = "<p>Popup Tingkat Resiko</p>";
    $("#tcehs025mModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupResiko') }}';
    var lookupTcehs025m = $('#lookupTcehs025m').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
        { data: 'kd_resiko', name: 'kd_resiko'},
        { data: 'nm_resiko', name: 'nm_resiko'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupTcehs025m tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupTcehs025m.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopupresiko_', '');
            var ib_resiko = "ib_resiko_" + row;
            var pencegahan = "pencegahan_" + row;
            var resiko_value = document.getElementById(ib_resiko).value.trim();
            if(resiko_value === "") {
              document.getElementById(ib_resiko).value = value["nm_resiko"] + ".";
            } else {
              document.getElementById(ib_resiko).value += "\n" + value["nm_resiko"] + ".";
            }
            $('#tcehs025mModal').modal('hide');
            document.getElementById(pencegahan).focus();
          });
        });
        $('#tcehs025mModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopupresiko_', '');
          var ib_resiko = "ib_resiko_" + row;
          var pencegahan = "pencegahan_" + row;
          var resiko_value = document.getElementById(ib_resiko).value.trim();
          if(resiko_value === '') {
            document.getElementById(ib_resiko).value = "";
            document.getElementById(ib_resiko).focus();
          } else {
            document.getElementById(pencegahan).focus();
          }
        });
      },
    });
  }

  function popupPencegahan(ths) {
    var myHeading = "<p>Popup Tindakan Pencegahan</p>";
    $("#tcehs026mModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupPencegahan') }}';
    var lookupTcehs026m = $('#lookupTcehs026m').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
        { data: 'kd_kendali', name: 'kd_kendali'},
        { data: 'nm_kendali', name: 'nm_kendali'},
        { data: 'nm_kel', name: 'nm_kel'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupTcehs026m tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupTcehs026m.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopuppencegahan_', '');
            var pencegahan = "pencegahan_" + row;
            var pencegahan_value = document.getElementById(pencegahan).value.trim();
            if(pencegahan_value === "") {
              document.getElementById(pencegahan).value = value["nm_kendali"] + ".";
            } else {
              document.getElementById(pencegahan).value += "\n" + value["nm_kendali"] + ".";
            }
            $('#tcehs026mModal').modal('hide');
            document.getElementById(ths.id).focus();
          });
        });
        $('#tcehs026mModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopuppencegahan_', '');
          var pencegahan = "pencegahan_" + row;
          var pencegahan_value = document.getElementById(pencegahan).value.trim();
          if(pencegahan_value === '') {
            document.getElementById(pencegahan).value = "";
            document.getElementById(pencegahan).focus();
          } else {
            document.getElementById(ths.id).focus();
          }
        });
      },
    });
  }

  function popupAspek(ths) {
    var myHeading = "<p>Popup Aspek</p>";
    $("#tcehs023mModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupAspek') }}';
    var lookupTcehs023m = $('#lookupTcehs023m').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
        { data: 'kd_aspek', name: 'kd_aspek'},
        { data: 'nm_aspek', name: 'nm_aspek'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupTcehs023m tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupTcehs023m.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopupaspek_', '');
            var ket_aspek = "ket_aspek_" + row;
            var ket_dampak = "ket_dampak_" + row;
            var ket_aspek_value = document.getElementById(ket_aspek).value.trim();
            if(ket_aspek_value === "") {
              document.getElementById(ket_aspek).value = value["nm_aspek"] + ".";
            } else {
              document.getElementById(ket_aspek).value += "\n" + value["nm_aspek"] + ".";
            }
            $('#tcehs023mModal').modal('hide');
            document.getElementById(ket_dampak).focus();
          });
        });
        $('#tcehs023mModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopupaspek_', '');
          var ket_aspek = "ket_aspek_" + row;
          var ket_dampak = "ket_dampak_" + row;
          var ket_aspek_value = document.getElementById(ket_aspek).value.trim();
          if(ket_aspek_value === '') {
            document.getElementById(ket_aspek).value = "";
            document.getElementById(ket_aspek).focus();
          } else {
            document.getElementById(ket_dampak).focus();
          }
        });
      },
    });
  }

  function popupDampak(ths) {
    var myHeading = "<p>Popup Dampak</p>";
    $("#tcehs021mModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupDampak') }}';
    var lookupTcehs021m = $('#lookupTcehs021m').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
        { data: 'kd_dampak', name: 'kd_dampak'},
        { data: 'nm_dampak', name: 'nm_dampak'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupTcehs021m tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupTcehs021m.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopupdampak_', '');
            var ket_dampak = "ket_dampak_" + row;
            var pencegahan_env = "pencegahan_env_" + row;
            var ket_dampak_value = document.getElementById(ket_dampak).value.trim();
            if(ket_dampak_value === "") {
              document.getElementById(ket_dampak).value = value["nm_dampak"] + ".";
            } else {
              document.getElementById(ket_dampak).value += "\n" + value["nm_dampak"] + ".";
            }
            $('#tcehs021mModal').modal('hide');
            document.getElementById(pencegahan_env).focus();
          });
        });
        $('#tcehs021mModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopupdampak_', '');
          var ket_dampak = "ket_dampak_" + row;
          var pencegahan_env = "pencegahan_env_" + row;
          var ket_dampak_value = document.getElementById(ket_dampak).value.trim();
          if(ket_dampak_value === "") {
            document.getElementById(ket_dampak).value = "";
            document.getElementById(ket_dampak).focus();
          } else {
            document.getElementById(pencegahan_env).focus();
          }
        });
      },
    });
  }

  function popupKendali(ths) {
    var myHeading = "<p>Popup Tindakan Pencegahan</p>";
    $("#tcehs022mModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupKendali') }}';
    var lookupTcehs022m = $('#lookupTcehs022m').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
        { data: 'kd_kendali', name: 'kd_kendali'},
        { data: 'nm_kendali', name: 'nm_kendali'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupTcehs022m tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupTcehs022m.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopupkendali_', '');
            var pencegahan_env = "pencegahan_env_" + row;
            var pencegahan_env_value = document.getElementById(pencegahan_env).value.trim();
            if(pencegahan_env_value === "") {
              document.getElementById(pencegahan_env).value = value["nm_kendali"] + ".";
            } else {
              document.getElementById(pencegahan_env).value += "\n" + value["nm_kendali"] + ".";
            }
            $('#tcehs022mModal').modal('hide');
            document.getElementById(ths.id).focus();
          });
        });
        $('#tcehs022mModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopupkendali_', '');
          var pencegahan_env = "pencegahan_env_" + row;
          var pencegahan_env_value = document.getElementById(pencegahan_env).value.trim();
          if(pencegahan_env_value === "") {
            document.getElementById(pencegahan_env).value = "";
            document.getElementById(pencegahan_env).focus();
          } else {
            document.getElementById(ths.id).focus();
          }
        });
      },
    });
  }

  $("#addRowMp").click(function(){
    var jml_row = document.getElementById("jml_row_mp").value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row_mp").value = jml_row;

    var id_field = 'field_mp_'+jml_row;
    var id_box = 'box_mp_'+jml_row;
    var btndelete = 'btndelete_mp_'+jml_row;
    var nm_mp = 'nm_mp_'+jml_row;
    var btnpopupmp = 'btnpopupmp_'+jml_row;
    var ehst_wp2_mp_id = 'ehst_wp2_mp_id_'+jml_row;
    var ehst_wp2_mp_seq = 'ehst_wp2_mp_seq_'+jml_row;
    var no_id = 'no_id_'+jml_row;
    var ket_remarks = 'ket_remarks_'+jml_row;
    var pict_id = 'pict_id_'+jml_row;

    $("#field-mp").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Member Ke-'+ jml_row +'</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Member" onclick="deleteMember(this)">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-4">\
                  <label name="' + nm_mp + '">Nama (*)</label>\
                  <div class="input-group">\
                    <input type="text" id="' + nm_mp + '" name="' + nm_mp + '" required class="form-control" placeholder="Nama" onkeydown="keyPressedMp(this, event)" maxlength="50">\
                    <span class="input-group-btn">\
                      <button id="' + btnpopupmp + '" type="button" class="btn btn-info" onclick="popupMp(this)" data-toggle="modal" data-target="#mpModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                  <input type="hidden" id="' + ehst_wp2_mp_id + '" name="' + ehst_wp2_mp_id + '" class="form-control" value="0" readonly="readonly">\
                  <input type="hidden" id="' + ehst_wp2_mp_seq + '" name="' + ehst_wp2_mp_seq + '" class="form-control" value="0" readonly="readonly">\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + no_id + '">No. Identitas</label>\
                  <input type="text" id="' + no_id + '" name="' + no_id + '" class="form-control" placeholder="No. Identitas" maxlength="20">\
                </div>\
                <div class="col-sm-5">\
                  <label name="' + ket_remarks + '">Remarks</label>\
                  <input type="text" id="' + ket_remarks + '" name="' + ket_remarks + '" class="form-control" placeholder="Remarks" maxlength="50">\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-4">\
                  <label name="' + pict_id + '">Foto Identitas (KTP) (*)</label>\
                  <input id="' + pict_id + '" name="' + pict_id + '" type="file" accept=".jpg,.jpeg,.png" required>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    validasiSize();
    document.getElementById(nm_mp).focus();
  });

  function deleteMember(ths) {
    var msg = 'Anda yakin menghapus Member ini?';
    swal({
      title: msg,
      text: "",
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
      //startcode
      var row = ths.id.replace('btndelete_mp_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var ehst_wp2_mp_id = "ehst_wp2_mp_id_" + row;
      var ehst_wp2_mp_id_value = document.getElementById(ehst_wp2_mp_id).value.trim();

      if(ehst_wp2_mp_id_value === "0" || ehst_wp2_mp_id_value === "") {
        changeIdMp(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('ehstwp2mps.destroy', 'param') }}";
        url = url.replace('param', ehst_wp2_mp_id_value);
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method : 'DELETE',
            // menambah csrf token dari Laravel
            _token  : token
          },
          success:function(data){
            if(data.status === 'OK'){
              changeIdMp(row);
              info = "Deleted!";
              info2 = data.message;
              info3 = "success";
              swal(info, info2, info3);
            } else {
              info = "Cancelled";
              info2 = data.message;
              info3 = "error";
              swal(info, info2, info3);
            }
          }, error:function(){ 
            info = "System Error!";
            info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
            info3 = "error";
            swal(info, info2, info3);
          }
        });
        //END DELETE DI DATABASE
      }
      //finishcode
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

  function changeIdMp(row) {
    var id_div = "#field_mp_" + row;
    $(id_div).remove();
    var jml_row = document.getElementById("jml_row_mp").value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var id_field = "#field_mp_" + $i;
      var id_field_new = "field_mp_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_mp_" + $i;
      var id_box_new = "box_mp_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btndelete = "#btndelete_mp_" + $i;
      var btndelete_new = "btndelete_mp_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var nm_mp = "#nm_mp_" + $i;
      var nm_mp_new = "nm_mp_" + ($i-1);
      $(nm_mp).attr({"id":nm_mp_new, "name":nm_mp_new});
      var btnpopupmp = "#btnpopupmp_" + $i;
      var btnpopupmp_new = "btnpopupmp_" + ($i-1);
      $(btnpopupmp).attr({"id":btnpopupmp_new, "name":btnpopupmp_new});
      var ehst_wp2_mp_id = "#ehst_wp2_mp_id_" + $i;
      var ehst_wp2_mp_id_new = "ehst_wp2_mp_id_" + ($i-1);
      $(ehst_wp2_mp_id).attr({"id":ehst_wp2_mp_id_new, "name":ehst_wp2_mp_id_new});
      var ehst_wp2_mp_seq = "#ehst_wp2_mp_seq_" + $i;
      var ehst_wp2_mp_seq_new = "ehst_wp2_mp_seq_" + ($i-1);
      $(ehst_wp2_mp_seq).attr({"id":ehst_wp2_mp_seq_new, "name":ehst_wp2_mp_seq_new});
      var no_id = "#no_id_" + $i;
      var no_id_new = "no_id_" + ($i-1);
      $(no_id).attr({"id":no_id_new, "name":no_id_new});
      var ket_remarks = "#ket_remarks_" + $i;
      var ket_remarks_new = "ket_remarks_" + ($i-1);
      $(ket_remarks).attr({"id":ket_remarks_new, "name":ket_remarks_new});
      var pict_id = "#pict_id_" + $i;
      var pict_id_new = "pict_id_" + ($i-1);
      $(pict_id).attr({"id":pict_id_new, "name":pict_id_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row_mp").value = jml_row;
  }

  $("#addRowK3").click(function(){
    var jml_row = document.getElementById("jml_row_k3").value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row_k3").value = jml_row;

    var id_field = 'field_k3_'+jml_row;
    var id_box = 'box_k3_'+jml_row;
    var btndelete = 'btndelete_k3_'+jml_row;
    var ket_aktifitas = 'ket_aktifitas_'+jml_row;
    var ehst_wp2_k3_id = 'ehst_wp2_k3_id_'+jml_row;
    var ehst_wp2_k3_seq = 'ehst_wp2_k3_seq_'+jml_row;
    var ib_potensi = 'ib_potensi_'+jml_row;
    var btnpopuppotensi = 'btnpopuppotensi_'+jml_row;
    var ib_resiko = 'ib_resiko_'+jml_row;
    var btnpopupresiko = 'btnpopupresiko_'+jml_row;
    var pencegahan = 'pencegahan_'+jml_row;
    var btnpopuppencegahan = 'btnpopuppencegahan_'+jml_row;

    $("#field-k3").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Identifikasi Bahaya Ke-'+ jml_row +'</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Identifikasi Bahaya" onclick="deleteK3(this)">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + ket_aktifitas + '">Aktifitas / Produk / Jasa (*)</label>\
                  <textarea id="' + ket_aktifitas + '" name="' + ket_aktifitas + '" required class="form-control" placeholder="Aktifitas / Produk / Jasa" rows="3" maxlength="100" style="resize:vertical"></textarea>\
                  <input type="hidden" id="' + ehst_wp2_k3_id + '" name="' + ehst_wp2_k3_id + '" class="form-control" readonly="readonly" value="0">\
                  <input type="hidden" id="' + ehst_wp2_k3_seq + '" name="' + ehst_wp2_k3_seq + '" class="form-control" readonly="readonly" value="0">\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + ib_potensi + '">Potensi Bahaya</label>\
                  <div class="input-group">\
                    <textarea id="' + ib_potensi + '" name="' + ib_potensi + '" required class="form-control" placeholder="Potensi Bahaya" rows="3" maxlength="200" style="resize:vertical"></textarea>\
                    <span class="input-group-btn">\
                      <button id="' + btnpopuppotensi + '" name="' + btnpopuppotensi + '" type="button" class="btn btn-info" title="Pilih Potensi" onclick="popupPotensi(this)" data-toggle="modal" data-target="#tcehs024mModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + ib_resiko + '">Resiko</label>\
                  <div class="input-group">\
                    <textarea id="' + ib_resiko + '" name="' + ib_resiko + '" required class="form-control" placeholder="Resiko" rows="3" maxlength="200" style="resize:vertical"></textarea>\
                    <span class="input-group-btn">\
                      <button id="' + btnpopupresiko + '" name="' + btnpopupresiko + '" type="button" class="btn btn-info" title="Pilih Resiko" onclick="popupResiko(this)" data-toggle="modal" data-target="#tcehs025mModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + pencegahan + '">Tindakan Pencegahan</label>\
                  <div class="input-group">\
                    <textarea id="' + pencegahan + '" name="' + pencegahan + '" required class="form-control" placeholder="Tindakan Pencegahan" rows="3" maxlength="200" style="resize:vertical"></textarea>\
                    <span class="input-group-btn">\
                      <button id="' + btnpopuppencegahan + '" name="' + btnpopuppencegahan + '" type="button" class="btn btn-info" title="Pilih Pencegahan" onclick="popupPencegahan(this)" data-toggle="modal" data-target="#tcehs026mModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    document.getElementById(ket_aktifitas).focus();
  });

  function deleteK3(ths) {
    var msg = 'Anda yakin menghapus Identifikasi Bahaya ini?';
    swal({
      title: msg,
      text: "",
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
      //startcode
      var row = ths.id.replace('btndelete_k3_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var ehst_wp2_k3_id = "ehst_wp2_k3_id_" + row;
      var ehst_wp2_k3_id_value = document.getElementById(ehst_wp2_k3_id).value.trim();

      if(ehst_wp2_k3_id_value === "0" || ehst_wp2_k3_id_value === "") {
        changeIdK3(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('ehstwp2k3s.destroy', 'param') }}";
        url = url.replace('param', ehst_wp2_k3_id_value);
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method : 'DELETE',
            // menambah csrf token dari Laravel
            _token  : token
          },
          success:function(data){
            if(data.status === 'OK'){
              changeIdK3(row);
              info = "Deleted!";
              info2 = data.message;
              info3 = "success";
              swal(info, info2, info3);
            } else {
              info = "Cancelled";
              info2 = data.message;
              info3 = "error";
              swal(info, info2, info3);
            }
          }, error:function(){ 
            info = "System Error!";
            info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
            info3 = "error";
            swal(info, info2, info3);
          }
        });
        //END DELETE DI DATABASE
      }
      //finishcode
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

  function changeIdK3(row) {
    var id_div = "#field_k3_" + row;
    $(id_div).remove();
    var jml_row = document.getElementById("jml_row_k3").value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var id_field = "#field_k3_" + $i;
      var id_field_new = "field_k3_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_k3_" + $i;
      var id_box_new = "box_k3_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btndelete = "#btndelete_k3_" + $i;
      var btndelete_new = "btndelete_k3_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var ket_aktifitas = "#ket_aktifitas_" + $i;
      var ket_aktifitas_new = "ket_aktifitas_" + ($i-1);
      $(ket_aktifitas).attr({"id":ket_aktifitas_new, "name":ket_aktifitas_new});
      var ehst_wp2_k3_id = "#ehst_wp2_k3_id_" + $i;
      var ehst_wp2_k3_id_new = "ehst_wp2_k3_id_" + ($i-1);
      $(ehst_wp2_k3_id).attr({"id":ehst_wp2_k3_id_new, "name":ehst_wp2_k3_id_new});
      var ehst_wp2_k3_seq = "#ehst_wp2_k3_seq_" + $i;
      var ehst_wp2_k3_seq_new = "ehst_wp2_k3_seq_" + ($i-1);
      $(ehst_wp2_k3_seq).attr({"id":ehst_wp2_k3_seq_new, "name":ehst_wp2_k3_seq_new});
      var ib_potensi = "#ib_potensi_" + $i;
      var ib_potensi_new = "ib_potensi_" + ($i-1);
      $(ib_potensi).attr({"id":ib_potensi_new, "name":ib_potensi_new});
      var btnpopuppotensi = "#btnpopuppotensi_" + $i;
      var btnpopuppotensi_new = "btnpopuppotensi_" + ($i-1);
      $(btnpopuppotensi).attr({"id":btnpopuppotensi_new, "name":btnpopuppotensi_new});
      var ib_resiko = "#ib_resiko_" + $i;
      var ib_resiko_new = "ib_resiko_" + ($i-1);
      $(ib_resiko).attr({"id":ib_resiko_new, "name":ib_resiko_new});
      var btnpopupresiko = "#btnpopupresiko_" + $i;
      var btnpopupresiko_new = "btnpopupresiko_" + ($i-1);
      $(btnpopupresiko).attr({"id":btnpopupresiko_new, "name":btnpopupresiko_new});
      var pencegahan = "#pencegahan_" + $i;
      var pencegahan_new = "pencegahan_" + ($i-1);
      $(pencegahan).attr({"id":pencegahan_new, "name":pencegahan_new});
      var btnpopuppencegahan = "#btnpopuppencegahan_" + $i;
      var btnpopuppencegahan_new = "btnpopuppencegahan_" + ($i-1);
      $(btnpopuppencegahan).attr({"id":btnpopuppencegahan_new, "name":btnpopuppencegahan_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row_k3").value = jml_row;
  }

  $("#addRowEnv").click(function(){
    var jml_row = document.getElementById("jml_row_env").value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row_env").value = jml_row;

    var id_field = 'field_env_'+jml_row;
    var id_box = 'box_env_'+jml_row;
    var btndelete = 'btndelete_env_'+jml_row;
    var ket_aktifitas_env = 'ket_aktifitas_env_'+jml_row;
    var ehst_wp2_env_id = 'ehst_wp2_env_id_'+jml_row;
    var ehst_wp2_env_seq = 'ehst_wp2_env_seq_'+jml_row;
    var ket_aspek = 'ket_aspek_'+jml_row;
    var btnpopupaspek = 'btnpopupaspek_'+jml_row;
    var ket_dampak = 'ket_dampak_'+jml_row;
    var btnpopupdampak = 'btnpopupdampak_'+jml_row;
    var pencegahan_env = 'pencegahan_env_'+jml_row;
    var btnpopupkendali = 'btnpopupkendali_'+jml_row;

    $("#field-env").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Identifikasi Aspek Dampak Lingkungan Ke-'+ jml_row +'</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndelete + '" name="' + btndelete + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Identifikasi Aspek Dampak Lingkungan" onclick="deleteEnv(this)">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + ket_aktifitas_env + '">Aktifitas / Produk / Jasa (*)</label>\
                  <textarea id="' + ket_aktifitas_env + '" name="' + ket_aktifitas_env + '" required class="form-control" placeholder="Aktifitas / Produk / Jasa" rows="3" maxlength="100" style="resize:vertical"></textarea>\
                  <input type="hidden" id="' + ehst_wp2_env_id + '" name="' + ehst_wp2_env_id + '" class="form-control" readonly="readonly" value="0">\
                  <input type="hidden" id="' + ehst_wp2_env_seq + '" name="' + ehst_wp2_env_seq + '" class="form-control" readonly="readonly" value="0">\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + ket_aspek + '">Aspek Dampak</label>\
                  <div class="input-group">\
                    <textarea id="' + ket_aspek + '" name="' + ket_aspek + '" required class="form-control" placeholder="Aspek Dampak" rows="3" maxlength="200" style="resize:vertical"></textarea>\
                    <span class="input-group-btn">\
                      <button id="' + btnpopupaspek + '" name="' + btnpopupaspek + '" type="button" class="btn btn-info" title="Pilih Aspek" onclick="popupAspek(this)" data-toggle="modal" data-target="#tcehs023mModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + ket_dampak + '">Dampak Lingkungan</label>\
                  <div class="input-group">\
                    <textarea id="' + ket_dampak + '" name="' + ket_dampak + '" required class="form-control" placeholder="Dampak Lingkungan" rows="3" maxlength="200" style="resize:vertical"></textarea>\
                    <span class="input-group-btn">\
                      <button id="' + btnpopupdampak + '" name="' + btnpopupdampak + '" type="button" class="btn btn-info" title="Pilih Dampak" onclick="popupDampak(this)" data-toggle="modal" data-target="#tcehs021mModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
                <div class="col-sm-3">\
                  <label name="' + pencegahan_env + '">Tindakan Pencegahan</label>\
                  <div class="input-group">\
                    <textarea id="' + pencegahan_env + '" name="' + pencegahan_env + '" required class="form-control" placeholder="Tindakan Pencegahan" rows="3" maxlength="200" style="resize:vertical"></textarea>\
                    <span class="input-group-btn">\
                      <button id="' + btnpopupkendali + '" name="' + btnpopupkendali + '" type="button" class="btn btn-info" title="Pilih Kendali" onclick="popupKendali(this)" data-toggle="modal" data-target="#tcehs022mModal">\
                        <span class="glyphicon glyphicon-search"></span>\
                      </button>\
                    </span>\
                  </div>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    document.getElementById(ket_aktifitas_env).focus();
  });

  function deleteEnv(ths) {
    var msg = 'Anda yakin menghapus Identifikasi Aspek Dampak Lingkungan ini?';
    swal({
      title: msg,
      text: "",
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
      //startcode
      var row = ths.id.replace('btndelete_env_', '');
      var info = "";
      var info2 = "";
      var info3 = "warning";
      var ehst_wp2_env_id = "ehst_wp2_env_id_" + row;
      var ehst_wp2_env_id_value = document.getElementById(ehst_wp2_env_id).value.trim();

      if(ehst_wp2_env_id_value === "0" || ehst_wp2_env_id_value === "") {
        changeIdEnv(row);
      } else {
        //DELETE DI DATABASE
        // remove these events;
        window.onkeydown = null;
        window.onfocus = null;
        var token = document.getElementsByName('_token')[0].value.trim();
        // delete via ajax
        // hapus data detail dengan ajax
        var url = "{{ route('ehstwp2envs.destroy', 'param') }}";
        url = url.replace('param', ehst_wp2_env_id_value);
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method : 'DELETE',
            // menambah csrf token dari Laravel
            _token  : token
          },
          success:function(data){
            if(data.status === 'OK'){
              changeIdEnv(row);
              info = "Deleted!";
              info2 = data.message;
              info3 = "success";
              swal(info, info2, info3);
            } else {
              info = "Cancelled";
              info2 = data.message;
              info3 = "error";
              swal(info, info2, info3);
            }
          }, error:function(){ 
            info = "System Error!";
            info2 = "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.";
            info3 = "error";
            swal(info, info2, info3);
          }
        });
        //END DELETE DI DATABASE
      }
      //finishcode
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

  function changeIdEnv(row) {
    var id_div = "#field_env_" + row;
    $(id_div).remove();
    var jml_row = document.getElementById("jml_row_env").value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var id_field = "#field_env_" + $i;
      var id_field_new = "field_env_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_env_" + $i;
      var id_box_new = "box_env_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var btndelete = "#btndelete_env_" + $i;
      var btndelete_new = "btndelete_env_" + ($i-1);
      $(btndelete).attr({"id":btndelete_new, "name":btndelete_new});
      var ket_aktifitas_env = "#ket_aktifitas_env_" + $i;
      var ket_aktifitas_env_new = "ket_aktifitas_env_" + ($i-1);
      $(ket_aktifitas_env).attr({"id":ket_aktifitas_env_new, "name":ket_aktifitas_env_new});
      var ehst_wp2_env_id = "#ehst_wp2_env_id_" + $i;
      var ehst_wp2_env_id_new = "ehst_wp2_env_id_" + ($i-1);
      $(ehst_wp2_env_id).attr({"id":ehst_wp2_env_id_new, "name":ehst_wp2_env_id_new});
      var ehst_wp2_env_seq = "#ehst_wp2_env_seq_" + $i;
      var ehst_wp2_env_seq_new = "ehst_wp2_env_seq_" + ($i-1);
      $(ehst_wp2_env_seq).attr({"id":ehst_wp2_env_seq_new, "name":ehst_wp2_env_seq_new});
      var ket_aspek = "#ket_aspek_" + $i;
      var ket_aspek_new = "ket_aspek_" + ($i-1);
      $(ket_aspek).attr({"id":ket_aspek_new, "name":ket_aspek_new});
      var btnpopupaspek = "#btnpopupaspek_" + $i;
      var btnpopupaspek_new = "btnpopupaspek_" + ($i-1);
      $(btnpopupaspek).attr({"id":btnpopupaspek_new, "name":btnpopupaspek_new});
      var ket_dampak = "#ket_dampak_" + $i;
      var ket_dampak_new = "ket_dampak_" + ($i-1);
      $(ket_dampak).attr({"id":ket_dampak_new, "name":ket_dampak_new});
      var btnpopupdampak = "#btnpopupdampak_" + $i;
      var btnpopupdampak_new = "btnpopupdampak_" + ($i-1);
      $(btnpopupdampak).attr({"id":btnpopupdampak_new, "name":btnpopupdampak_new});
      var pencegahan_env = "#pencegahan_env_" + $i;
      var pencegahan_env_new = "pencegahan_env_" + ($i-1);
      $(pencegahan_env).attr({"id":pencegahan_env_new, "name":pencegahan_env_new});
      var btnpopupkendali = "#btnpopupkendali_" + $i;
      var btnpopupkendali_new = "btnpopupkendali_" + ($i-1);
      $(btnpopupkendali).attr({"id":btnpopupkendali_new, "name":btnpopupkendali_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row_env").value = jml_row;
  }
</script>
@endsection