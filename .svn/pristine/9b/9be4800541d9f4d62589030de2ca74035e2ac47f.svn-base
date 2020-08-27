<div class="box-body">
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_reg') ? ' has-error' : '' }}">
      {!! Form::label('no_reg', 'No. Register') !!}
      @if (empty($ppReg->no_reg))
        {!! Form::text('no_reg', null, ['class'=>'form-control','placeholder' => 'No. Register', 'disabled'=>'']) !!}
      @else
        {!! Form::text('no_reg2', $ppReg->no_reg, ['class'=>'form-control','placeholder' => 'No. LHP', 'required', 'disabled'=>'']) !!}
        {!! Form::hidden('no_reg', null, ['class'=>'form-control','placeholder' => 'No. Register', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('no_reg', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('tgl_reg') ? ' has-error' : '' }}">
      {!! Form::label('tgl_reg', 'Tanggal Register') !!}
      @if (empty($ppReg->tgl_reg))
        {!! Form::date('tgl_reg', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Register', 'disabled'=>'']) !!}
      @else
        {!! Form::date('tgl_reg', null, ['class'=>'form-control','placeholder' => 'Tgl Register', 'disabled'=>'']) !!}
      @endif
      {!! Form::hidden('jml_tbl_detail', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_tbl_detail']) !!}
      {!! Form::hidden('idtables', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'idtables']) !!}
      {!! $errors->first('tgl_reg', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-sm-1 {{ $errors->has('kd_dept_pembuat') ? ' has-error' : '' }}">
      {!! Form::label('kd_dept_pembuat', 'Dept.') !!}
      @if (empty($ppReg->kd_dept_pembuat))
        {!! Form::text('kd_dept_pembuat2', $mas_karyawan->kode_dep, ['class'=>'form-control','placeholder' => 'Dept.', 'disabled'=>'']) !!}
        {!! Form::hidden('kd_dept_pembuat', $mas_karyawan->kode_dep, ['class'=>'form-control','placeholder' => 'Dept.', 'required', 'readonly'=>'readonly']) !!}
      @else
        {!! Form::text('kd_dept_pembuat2', $ppReg->kd_dept_pembuat, ['class'=>'form-control','placeholder' => 'Dept. Pembuat', 'required', 'disabled'=>'']) !!}
        {!! Form::hidden('kd_dept_pembuat', null, ['class'=>'form-control','placeholder' => 'Dept. Pembuat', 'required', 'readonly'=>'readonly']) !!}
      @endif
      {!! $errors->first('kd_dept_pembuat', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('nm_dept') ? ' has-error' : '' }}">
      {!! Form::label('nm_dept', 'Nama Dept. Pembuat') !!}
      @if (empty($ppReg->kd_dept_pembuat))
        {!! Form::text('nm_dept', $mas_karyawan->desc_dep, ['class'=>'form-control','placeholder' => 'Nama Dept. Pembuat', 'disabled'=>'']) !!}
      @else
        {!! Form::text('nm_dept', $ppReg->nm_dept, ['class'=>'form-control','placeholder' => 'Nama Dept. Pembuat', 'disabled'=>'']) !!}
      @endif
      {!! $errors->first('nm_dept', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('pemakai') ? ' has-error' : '' }}">
      {!! Form::label('pemakai', 'Pemakai (*)') !!}
      @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D')
        {!! Form::textarea('pemakai', null, ['class'=>'form-control', 'placeholder' => 'Pemakai', 'rows' => '3', 'maxlength'=>'200', 'style' => 'text-transform:uppercase;resize:vertical', 'required', 'readonly']) !!}
      @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
        {!! Form::textarea('pemakai', null, ['class'=>'form-control', 'placeholder' => 'Pemakai', 'rows' => '3', 'maxlength'=>'200', 'style' => 'text-transform:uppercase;resize:vertical', 'required', 'readonly']) !!}
      @else
        {!! Form::textarea('pemakai', null, ['class'=>'form-control', 'placeholder' => 'Pemakai', 'rows' => '3', 'maxlength'=>'200', 'style' => 'text-transform:uppercase;resize:vertical', 'required']) !!}
      @endif
      {!! $errors->first('pemakai', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('untuk') ? ' has-error' : '' }}">
      {!! Form::label('untuk', 'Untuk (*)') !!}
      @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D')
        {!! Form::textarea('untuk', null, ['class'=>'form-control', 'placeholder' => 'Untuk', 'rows' => '3', 'maxlength'=>'200', 'style' => 'text-transform:uppercase;resize:vertical', 'required', 'readonly']) !!}
      @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
        {!! Form::textarea('untuk', null, ['class'=>'form-control', 'placeholder' => 'Untuk', 'rows' => '3', 'maxlength'=>'200', 'style' => 'text-transform:uppercase;resize:vertical', 'required', 'readonly']) !!}
      @else
        {!! Form::textarea('untuk', null, ['class'=>'form-control', 'placeholder' => 'Untuk', 'rows' => '3', 'maxlength'=>'200', 'style' => 'text-transform:uppercase;resize:vertical', 'required']) !!}
      @endif
      {!! $errors->first('untuk', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('alasan') ? ' has-error' : '' }}">
      {!! Form::label('alasan', 'Alasan (*)') !!}
      @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D')
        {!! Form::textarea('alasan', null, ['class'=>'form-control', 'placeholder' => 'Alasan', 'rows' => '3', 'maxlength'=>'200', 'style' => 'text-transform:uppercase;resize:vertical', 'required', 'readonly']) !!}
      @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
        {!! Form::textarea('alasan', null, ['class'=>'form-control', 'placeholder' => 'Alasan', 'rows' => '3', 'maxlength'=>'200', 'style' => 'text-transform:uppercase;resize:vertical', 'required', 'readonly']) !!}
      @else
        {!! Form::textarea('alasan', null, ['class'=>'form-control', 'placeholder' => 'Alasan', 'rows' => '3', 'maxlength'=>'200', 'style' => 'text-transform:uppercase;resize:vertical', 'required']) !!}
      @endif
      {!! $errors->first('alasan', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-2 {{ $errors->has('kd_supp') ? ' has-error' : '' }}">
      {!! Form::label('kd_supp', 'Supplier (F9)') !!}
      <div class="input-group">
        @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
          {!! Form::text('kd_supp', null, ['class'=>'form-control','placeholder' => 'Supplier', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdSupp(event)', 'onchange' => 'validateKdSupp()', 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupsupplier" type="button" class="btn btn-info" data-toggle="modal" data-target="#supplierModal" disabled="">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          {!! Form::text('kd_supp', null, ['class'=>'form-control','placeholder' => 'Supplier', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdSupp(event)', 'onchange' => 'validateKdSupp()']) !!}
          <span class="input-group-btn">
            <button id="btnpopupsupplier" type="button" class="btn btn-info" data-toggle="modal" data-target="#supplierModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
      </div>
      {!! $errors->first('kd_supp', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('nm_supp') ? ' has-error' : '' }}">
      {!! Form::label('nm_supp', 'Nama Supplier') !!}
      @if (empty($ppReg->kd_supp))
        {!! Form::text('nm_supp', null, ['class'=>'form-control','placeholder' => 'Nama Supplier', 'disabled'=>'', 'id' => 'nm_supp']) !!}
      @else
        {!! Form::text('nm_supp', $ppReg->namaSupp($ppReg->kd_supp), ['class'=>'form-control','placeholder' => 'Nama Supplier', 'disabled'=>'', 'id' => 'nm_supp']) !!}
      @endif
      {!! $errors->first('nm_supp', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-4 {{ $errors->has('email_supp') ? ' has-error' : '' }}">
      {!! Form::label('email_supp', 'Email Supplier') !!}
      @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
        {!! Form::email('email_supp', null, ['class'=>'form-control','placeholder' => 'Email Supplier', 'maxlength' => 100, 'style' => 'text-transform:lowercase', 'readonly']) !!}
      @else
        {!! Form::email('email_supp', null, ['class'=>'form-control','placeholder' => 'Email Supplier', 'maxlength' => 100, 'style' => 'text-transform:lowercase']) !!}
      @endif
      {!! $errors->first('email_supp', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
  <div class="form-group">
    <div class="col-sm-3 {{ $errors->has('no_ia_ea') ? ' has-error' : '' }}">
      {!! Form::label('no_ia_ea', 'No. IA/EA (F9)') !!}
      <div class="input-group">
        @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D')
          {!! Form::text('no_ia_ea', null, ['class'=>'form-control','placeholder' => 'No. IA/EA', 'maxlength' => 25, 'onkeydown' => 'keyPressedNoIa(event)', 'onchange' => 'validateNoIa()', 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupnoia" type="button" class="btn btn-info" data-toggle="modal" data-target="#noiaModal" disabled="">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
          {!! Form::text('no_ia_ea', null, ['class'=>'form-control','placeholder' => 'No. IA/EA', 'maxlength' => 25, 'onkeydown' => 'keyPressedNoIa(event)', 'onchange' => 'validateNoIa()', 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupnoia" type="button" class="btn btn-info" data-toggle="modal" data-target="#noiaModal" disabled="">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          @if (empty($ppReg->kd_dept_pembuat))
            @if ($mas_karyawan->kode_dep === 'H5' || substr($mas_karyawan->kode_dep, 0, 1) === '9')
              {!! Form::text('no_ia_ea', null, ['class'=>'form-control','placeholder' => 'No. IA/EA', 'maxlength' => 25, 'onkeydown' => 'keyPressedNoIa(event)', 'onchange' => 'validateNoIa()', 'required']) !!}
            @else
              {!! Form::text('no_ia_ea', null, ['class'=>'form-control','placeholder' => 'No. IA/EA', 'maxlength' => 25, 'onkeydown' => 'keyPressedNoIa(event)', 'onchange' => 'validateNoIa()']) !!}
            @endif
          @else
            @if ($ppReg->kd_dept_pembuat === 'H5' || substr($ppReg->kd_dept_pembuat, 0, 1) === '9')
              {!! Form::text('no_ia_ea', null, ['class'=>'form-control','placeholder' => 'No. IA/EA', 'maxlength' => 25, 'onkeydown' => 'keyPressedNoIa(event)', 'onchange' => 'validateNoIa()', 'required']) !!}
            @else
              {!! Form::text('no_ia_ea', null, ['class'=>'form-control','placeholder' => 'No. IA/EA', 'maxlength' => 25, 'onkeydown' => 'keyPressedNoIa(event)', 'onchange' => 'validateNoIa()']) !!}
            @endif
          @endif
          <span class="input-group-btn">
            <button id="btnpopupnoia" type="button" class="btn btn-info" data-toggle="modal" data-target="#noiaModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
      </div>
      {!! $errors->first('no_ia_ea', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('no_ia_ea_revisi') ? ' has-error' : '' }}">
      {!! Form::label('no_ia_ea_revisi', 'No. Revisi IA/EA') !!}
      @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D')
        {!! Form::text('no_ia_ea_revisi', null, ['class'=>'form-control','placeholder' => 'No. Revisi IA/EA', 'maxlength' => 5, 'onchange' => 'validateNoIa()', 'readonly']) !!}
      @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
        {!! Form::text('no_ia_ea_revisi', null, ['class'=>'form-control','placeholder' => 'No. Revisi IA/EA', 'maxlength' => 5, 'onchange' => 'validateNoIa()', 'readonly']) !!}
      @else
        @if (empty($ppReg->kd_dept_pembuat))
          @if ($mas_karyawan->kode_dep === 'H5' || substr($mas_karyawan->kode_dep, 0, 1) === '9')
            {!! Form::text('no_ia_ea_revisi', null, ['class'=>'form-control','placeholder' => 'No. Revisi IA/EA', 'maxlength' => 5, 'onchange' => 'validateNoIa()', 'required']) !!}
          @else
            {!! Form::text('no_ia_ea_revisi', null, ['class'=>'form-control','placeholder' => 'No. Revisi IA/EA', 'maxlength' => 5, 'onchange' => 'validateNoIa()']) !!}
          @endif
        @else
          @if ($ppReg->kd_dept_pembuat === 'H5' || substr($ppReg->kd_dept_pembuat, 0, 1) === '9')
            {!! Form::text('no_ia_ea_revisi', null, ['class'=>'form-control','placeholder' => 'No. Revisi IA/EA', 'maxlength' => 5, 'onchange' => 'validateNoIa()', 'required']) !!}
          @else
            {!! Form::text('no_ia_ea_revisi', null, ['class'=>'form-control','placeholder' => 'No. Revisi IA/EA', 'maxlength' => 5, 'onchange' => 'validateNoIa()']) !!}
          @endif
        @endif
      @endif
      {!! $errors->first('no_ia_ea_revisi', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-2 {{ $errors->has('no_ia_ea_urut') ? ' has-error' : '' }}">
      {!! Form::label('no_ia_ea_urut', 'No. Urut IA/EA (F9)') !!}
      <div class="input-group">
        @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D')
          {!! Form::text('no_ia_ea_urut', null, ['class'=>'form-control','placeholder' => 'No. Urut IA/EA', 'maxlength' => 5, 'onkeydown' => 'keyPressedNoIaUrut(event)', 'onchange' => 'validateNoIaUrut()', 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupnoiaurut" type="button" class="btn btn-info" data-toggle="modal" data-target="#noiaurutModal" disabled="">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
          {!! Form::text('no_ia_ea_urut', null, ['class'=>'form-control','placeholder' => 'No. Urut IA/EA', 'maxlength' => 5, 'onkeydown' => 'keyPressedNoIaUrut(event)', 'onchange' => 'validateNoIaUrut()', 'readonly']) !!}
          <span class="input-group-btn">
            <button id="btnpopupnoiaurut" type="button" class="btn btn-info" data-toggle="modal" data-target="#noiaurutModal" disabled="">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @else
          @if (empty($ppReg->kd_dept_pembuat))
            @if ($mas_karyawan->kode_dep === 'H5' || substr($mas_karyawan->kode_dep, 0, 1) === '9')
              {!! Form::text('no_ia_ea_urut', null, ['class'=>'form-control','placeholder' => 'No. Urut IA/EA', 'maxlength' => 5, 'onkeydown' => 'keyPressedNoIaUrut(event)', 'onchange' => 'validateNoIaUrut()', 'required']) !!}
            @else
              {!! Form::text('no_ia_ea_urut', null, ['class'=>'form-control','placeholder' => 'No. Urut IA/EA', 'maxlength' => 5, 'onkeydown' => 'keyPressedNoIaUrut(event)', 'onchange' => 'validateNoIaUrut()']) !!}
            @endif
          @else
            @if ($ppReg->kd_dept_pembuat === 'H5' || substr($ppReg->kd_dept_pembuat, 0, 1) === '9')
              {!! Form::text('no_ia_ea_urut', null, ['class'=>'form-control','placeholder' => 'No. Urut IA/EA', 'maxlength' => 5, 'onkeydown' => 'keyPressedNoIaUrut(event)', 'onchange' => 'validateNoIaUrut()', 'required']) !!}
            @else
              {!! Form::text('no_ia_ea_urut', null, ['class'=>'form-control','placeholder' => 'No. Urut IA/EA', 'maxlength' => 5, 'onkeydown' => 'keyPressedNoIaUrut(event)', 'onchange' => 'validateNoIaUrut()']) !!}
            @endif
          @endif
          <span class="input-group-btn">
            <button id="btnpopupnoiaurut" type="button" class="btn btn-info" data-toggle="modal" data-target="#noiaurutModal">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        @endif
      </div>
      {!! $errors->first('no_ia_ea_urut', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 {{ $errors->has('desc_ia') ? ' has-error' : '' }}">
      {!! Form::label('desc_ia', 'Desc. IA/EA') !!}
      @if (empty($ppReg->no_ia_ea))
        {!! Form::text('desc_ia', null, ['class'=>'form-control','placeholder' => 'Desc. IA/EA', 'disabled'=>'', 'id' => 'desc_ia']) !!}
      @else
        {!! Form::text('desc_ia', $ppReg->descIaEa($ppReg->no_ia_ea, $ppReg->no_ia_ea_revisi, $ppReg->no_ia_ea_urut), ['class'=>'form-control','placeholder' => 'Desc. IA/EA', 'disabled'=>'', 'id' => 'desc_ia']) !!}
      @endif
      {!! $errors->first('desc_ia', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
  <!-- /.form-group -->
</div>
<!-- /.box-body -->

<div class="box-body">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Detail</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D')
          @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
          @else
            @include('eproc._action')
          @endif
          <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                  <th style="width: 5%;">No</th>
                  <th style="width: 17%;">Kode Barang <font color='red'>(F9)(*)</font></th>
                  @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
                    <th style="width: 20%;">Deskripsi</th>
                    <th>Nama Barang PRC</th>
                  @else
                    <th>Deskripsi</th>
                  @endif
                  <th style='width: 15%;text-align: center'>Qty PP</th>
                </tr>
            </thead>
            <tbody>
              @if (!empty($ppReg->no_reg))
                @foreach ($ppReg->ppRegDetails()->get() as $ppRegDetail)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <input type='hidden' value='row-{{ $loop->iteration }}-kd_brg' class='form-control'>
                      <input type='hidden' id="row-{{ $loop->iteration }}-id" name="row-{{ $loop->iteration }}-id" value="{{ base64_encode($ppRegDetail->id) }}" readonly='readonly' class='form-control'>
                      <input type='hidden' id="row-{{ $loop->iteration }}-desc" name="row-{{ $loop->iteration }}-desc" value="{{ $ppRegDetail->desc }}" readonly='readonly' class='form-control'>
                      @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
                        <input type='hidden' id="row-{{ $loop->iteration }}-nm_brg" name="row-{{ $loop->iteration }}-nm_brg" value="{{ $ppRegDetail->nm_brg }}" readonly='readonly' class='form-control'>
                      @endif
                      <div class='input-group'>
                        <input type='text' id="row-{{ $loop->iteration }}-kd_brg" name="row-{{ $loop->iteration }}-kd_brg" value="{{ $ppRegDetail->kd_brg }}" style='text-transform:uppercase' size='15' maxlength='9' required @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D') readonly='readonly' @elseif ($ppRegDetail->kd_brg !== 'XXX' && $ppReg->status_approve === 'P') readonly='readonly' @else  onkeydown='popupKdBrg(event)' onchange='validateKdBrg(event)' @endif class='form-control'>
                        <span class='input-group-btn'>
                          <button id="row-{{ $loop->iteration }}-btnkdbrg" type='button' class='btn btn-info' @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D') disabled='' @elseif ($ppRegDetail->kd_brg !== 'XXX' && $ppReg->status_approve === 'P') disabled='' @else onclick='popupKdBrg(this.id)' @endif>
                            <span class='glyphicon glyphicon-search'></span>
                          </button>
                        </span>
                      </div>
                    </td>
                    @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
                      <td>
                        <textarea id="row-{{ $loop->iteration }}-nmbrg" name="row-{{ $loop->iteration }}-nmbrg" rows='3' cols='45' maxlength='200' style='text-transform:uppercase;resize:vertical' onchange='validateNmBrg(event)' {{ $ppRegDetail->kd_brg === 'XXX' ? '' : 'disabled' }} @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D') readonly='readonly' @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P') readonly='readonly' @endif class='form-control'>{{ $ppRegDetail->desc }}</textarea>
                      </td>
                      <td>
                        <textarea id="row-{{ $loop->iteration }}-nmbrg2" name="row-{{ $loop->iteration }}-nmbrg2" rows='3' cols='45' maxlength='200' style='text-transform:uppercase;resize:vertical' disabled class='form-control'>{{ $ppRegDetail->nm_brg }}</textarea>
                      </td>
                    @else
                      <td>
                        <textarea id="row-{{ $loop->iteration }}-nmbrg" name="row-{{ $loop->iteration }}-nmbrg" rows='3' cols='90' maxlength='200' style='text-transform:uppercase;resize:vertical' onchange='validateNmBrg(event)' {{ $ppRegDetail->kd_brg === 'XXX' ? '' : 'disabled' }} @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D') readonly='readonly' @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P') readonly='readonly' @endif class='form-control'>{{ $ppRegDetail->desc }}</textarea>
                      </td>
                    @endif
                    <td>
                      <input type='number' id="row-{{ $loop->iteration }}-qty_pp" name="row-{{ $loop->iteration }}-qty_pp" value="{{ $ppRegDetail->qty_pp }}" style='width: 9em' min=0 max=9999999999.999 step='any' @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'D') readonly='readonly' @elseif (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P') readonly='readonly' @endif class='form-control'>
                    </td>
                  </tr>
                @endforeach
              @endif
              @for ($i = 1000; $i < 1001; $i++)
                <tr>
                  <td>{{ $i }}</td>
                  <td>
                    <input type='hidden' value='row-{{ $i }}-kd_brg' class='form-control'>
                    <input type='hidden' id="row-{{ $i }}-id" name="row-{{ $i }}-id" value='0' readonly='readonly' class='form-control'>
                    <input type='hidden' id="row-{{ $i }}-desc" name="row-{{ $i }}-desc" readonly='readonly' class='form-control'>
                    @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
                      <input type='hidden' id="row-{{ $i }}-nm_brg" name="row-{{ $i }}-nm_brg" readonly='readonly' class='form-control'>
                    @endif
                    <div class='input-group'>
                      <input type='text' id="row-{{ $i }}-kd_brg" name="row-{{ $i }}-kd_brg" style='text-transform:uppercase' size='15' maxlength='9' onkeydown='popupKdBrg(event)' onchange='validateKdBrg(event)' required class='form-control'>
                      <span class='input-group-btn'>
                        <button id="row-{{ $i }}-btnkdbrg" type='button' class='btn btn-info' onclick='popupKdBrg(this.id)'>
                          <span class='glyphicon glyphicon-search'></span>
                        </button>
                      </span>
                    </div>
                  </td>
                  @if (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P')
                    <td>
                      <textarea id="row-{{ $i }}-nmbrg" name="row-{{ $i }}-nmbrg" rows='3' cols='45' maxlength='200' style='text-transform:uppercase;resize:vertical' onchange='validateNmBrg(event)' disabled class='form-control'></textarea>
                    </td>
                    <td></td>
                  @else
                    <td>
                      <textarea id="row-{{ $i }}-nmbrg" name="row-{{ $i }}-nmbrg" rows='3' cols='90' maxlength='200' style='text-transform:uppercase;resize:vertical' onchange='validateNmBrg(event)' disabled class='form-control'></textarea>
                    </td>
                  @endif
                  <td>
                    <input type='number' id="row-{{ $i }}-qty_pp" name="row-{{ $i }}-qty_pp" style='width: 9em' min=0 max=9999999999.999 step='any' class='form-control'>
                  </td>
                </tr>
              @endfor
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.box-body -->


<div class="box-footer">
  {!! Form::submit('Save', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  &nbsp;&nbsp;
  <a class="btn btn-default" href="{{ route('ppregs.index') }}">Cancel</a>
    &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Supplier -->
@include('eproc.ppreg.popup.supplierModal')
<!-- Modal IA -->
@include('eproc.ppreg.popup.noiaModal')
<!-- Modal Urut IA -->
@include('eproc.ppreg.popup.noiaurutModal')
<!-- Modal Kode Barang -->
@include('eproc.ppreg.popup.kdbrgModal')

@section('scripts')
<script type="text/javascript">

  document.getElementById("pemakai").focus();
  var changeKdBrg = "{{ (!empty($ppReg->status_approve) && $ppReg->status_approve === 'P') ? 'T' : 'F' }}";

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
      var targets = "-";
      var valid = 'T';
      var table = $('#tblDetail').DataTable();
      for($i = 0; $i < table.rows().count(); $i++) {
        var data = table.cell($i, 1).data();
        var posisi = data.indexOf("kd_brg");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="hidden" value="', '');
        target = target.replace("<input type='hidden' value='", '');
        target = target.replace("<input type='hidden' value=", '');
        target = target.replace('<input value="', '');
        target = target.replace("<input value='", '');
        target = target.replace("<input value=", '');
        
        if(targets === '-') {
          targets = target;
        } else {
          targets = targets + "#quinza#" + target;
        }
      }

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
          document.getElementById("idtables").value = targets;
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

  function keyPressedKdSupp(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupsupplier').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('email_supp').focus();
    }
  }

  function keyPressedNoIa(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnoia').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('no_ia_ea_revisi').focus();
    }
  }

  function keyPressedNoIaUrut(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupnoiaurut').click();
    } else if(e.keyCode == 9) { //TAB
      // e.preventDefault();
      // document.getElementById('no_ia_ea_revisi').focus();
    }
  }

  $(document).ready(function(){

    $("#btnpopupsupplier").click(function(){
      popupKdSupp();
    });

    $("#btnpopupnoia").click(function(){
      popupNoIa();
    });

    $("#btnpopupnoiaurut").click(function(){
      popupNoIaUrut();
    });

    var table = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // 'responsive': true,
      'searching': false,
      "scrollX": true,
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false
    });
 
    if(table.rows().count() == 1) {
      // Automatically remove all row
      table.clear().draw();
    } else {
      table.row(table.rows().count()-1).remove().draw(false);
    }
    
    if(document.getElementById("removeRow") != null) {
      document.getElementById("removeRow").disabled = true;
    }

    var counter = table.rows().count();
    document.getElementById("jml_tbl_detail").value = counter;

    $('#addRow').on( 'click', function () {
      counter++;
      document.getElementById("jml_tbl_detail").value = counter;
      var id = 'row-' + counter +'-id';
      var kd_brg = 'row-' + counter +'-kd_brg';
      var btnkdbrg = 'row-' + counter +'-btnkdbrg';
      var desc = 'row-' + counter +'-desc';
      var nmbrg = 'row-' + counter +'-nmbrg';
      var qty_pp = 'row-' + counter +'-qty_pp';

      table.row.add([
        "",
        "<input type='hidden' value=" + kd_brg + " class='form-control'><input type='hidden' id=" + id + " name=" + id + " value='0' readonly='readonly' class='form-control'><input type='hidden' id=" + desc + " name=" + desc + " readonly='readonly' class='form-control'><div class='input-group'><input type='text' id=" + kd_brg + " name=" + kd_brg + " style='text-transform:uppercase' size='15' maxlength='9' onkeydown='popupKdBrg(event)' onchange='validateKdBrg(event)' required class='form-control'><span class='input-group-btn'><button id=" + btnkdbrg + " type='button' class='btn btn-info' onclick='popupKdBrg(this.id)'><span class='glyphicon glyphicon-search'></span></button></div>",
        "<textarea id=" + nmbrg + " name=" + nmbrg + " rows='3' cols='90' maxlength='200' style='text-transform:uppercase;resize:vertical' onchange='validateNmBrg(event)' disabled class='form-control'></textarea>",
        "<input type='number' id=" + qty_pp + " name=" + qty_pp + " style='width: 9em' min=0 max=9999999999.999 step='any' class='form-control'>"
      ]).draw(false);
    });
    
    $('#tblDetail tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        if(document.getElementById("removeRow") != null) {
          document.getElementById("removeRow").disabled = true;
        }
      } else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(document.getElementById("removeRow") != null) {
          document.getElementById("removeRow").disabled = false;
        }
      }
    });
 
    $('#removeRow').click( function () {
      var index = table.row('.selected').index();
      if(index == null) {
        swal("Tidak ada data yang dipilih!", "", "warning");
      } else {
        //var array = table.rows(index).data().toArray();
        var data = table.cell(index, 1).data();
        var posisi = data.indexOf("kd_brg");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="hidden" value="', '');
        target = target.replace("<input type='hidden' value='", '');
        target = target.replace("<input type='hidden' value=", '');
        target = target.replace('<input value="', '');
        target = target.replace("<input value='", '');
        target = target.replace("<input value=", '');
        var id = document.getElementById(target +'id').value.trim();
        if(id == '0') {
          id = '';
        }
        if(id === '') {
          table.row(index).remove().draw(false);
        } else {
          var kd_brg = document.getElementById(target +'kd_brg').value.trim();
          var desc = document.getElementById(target +'desc').value.trim();
          var msg = 'Anda yakin menghapus Kode Barang: ' + kd_brg + ', Nama Barang: '+ desc;
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
            // remove these events;
            window.onkeydown = null;
            window.onfocus = null;
            var token = document.getElementsByName('_token')[0].value.trim();
            // delete via ajax
            // hapus data detail dengan ajax
            var url = "{{ route('ppregdetails.destroy', 'param')}}";
            url = url.replace('param', id);
            $("#loading").show();
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
                $("#loading").hide();
                if(data.status === 'OK'){
                  swal("Deleted!", data.message, "success");
                  table.row(index).remove().draw(false);
                } else {
                  swal("Cancelled", data.message, "error");
                }
              }, error:function(){ 
                $("#loading").hide();
                swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
              }
            });
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
  });

  function popupKdSupp() {
    var myHeading = "<p>Popup Supplier</p>";
    $("#supplierModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupSuppliers') }}';
    var lookupSupplier = $('#lookupSupplier').DataTable({
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
        { data: 'kd_supp', name: 'kd_supp'},
        { data: 'nama', name: 'nama'},
        { data: 'email', name: 'email'},
        { data: 'init_supp', name: 'init_supp'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupSupplier tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupSupplier.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_supp").value = value["kd_supp"];
            document.getElementById("nm_supp").value = value["nama"];
            if(value["email"] != '') {
              document.getElementById("email_supp").value = value["email"];
            } else {
              document.getElementById("email_supp").value = "";
            }
            $('#supplierModal').modal('hide');
            validateKdSupp();
          });
        });
        $('#supplierModal').on('hidden.bs.modal', function () {
          var kd_supp = document.getElementById("kd_supp").value.trim();
          if(kd_supp === '') {
            document.getElementById("nm_supp").value = "";
            document.getElementById("email_supp").value = "";
            $('#kd_supp').focus();
          } else {
            $('#email_supp').focus();
          }
        });
      },
    });
  }

  function validateKdSupp() {
    var kd_supp = document.getElementById("kd_supp").value.trim();
    if(kd_supp !== '') {
      var url = '{{ route('datatables.validasiSupplier', 'param') }}';
      url = url.replace('param', window.btoa(kd_supp));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_supp").value = result["kd_supp"];
          document.getElementById("nm_supp").value = result["nama"];
          if(result["email"] != '') {
            document.getElementById("email_supp").value = result["email"];
          } else {
            document.getElementById("email_supp").value = "";
          }
          document.getElementById("email_supp").focus();
        } else {
          document.getElementById("kd_supp").value = "";
          document.getElementById("nm_supp").value = "";
          document.getElementById("email_supp").value = "";
          document.getElementById("kd_supp").focus();
          swal("Supplier tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_supp").value = "";
      document.getElementById("nm_supp").value = "";
      document.getElementById("email_supp").value = "";
    }
  }

  function popupNoIa() {
    var myHeading = "<p>Popup No. IA/EA</p>";
    $("#noiaModalLabel").html(myHeading);
    var kd_dept_pembuat = document.getElementById('kd_dept_pembuat').value.trim();
    var url = '{{ route('datatables.popupNoIaPpReg', 'param') }}';
    url = url.replace('param', window.btoa(kd_dept_pembuat));
    var lookupNoia = $('#lookupNoia').DataTable({
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
      "order": [[1, 'desc'],[2, 'desc']],
      columns: [
        { data: 'no_ia_ea', name: 'no_ia_ea'},
        { data: 'tgl_ia_ea', name: 'tgl_ia_ea'},
        { data: 'no_revisi', name: 'no_revisi'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupNoia tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupNoia.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_ia_ea").value = value["no_ia_ea"];
            document.getElementById("no_ia_ea_revisi").value = value["no_revisi"];
            $('#noiaModal').modal('hide');
            validateNoIaUrut();
          });
        });
        $('#noiaModal').on('hidden.bs.modal', function () {
          var no_ia_ea = document.getElementById("no_ia_ea").value.trim();
          if(no_ia_ea === '') {
            document.getElementById("no_ia_ea_revisi").value = "";
            document.getElementById("no_ia_ea_urut").value = "";
            document.getElementById("desc_ia").value = "";
            $('#no_ia_ea').focus();
          } else {
            $('#no_ia_ea_urut').focus();
          }
        });
      },
    });
  }

  function validateNoIa() {
    var no_ia_ea = document.getElementById("no_ia_ea").value.trim();
    if(no_ia_ea !== '') {
      var kd_dept_pembuat = document.getElementById('kd_dept_pembuat').value.trim();
      var no_ia_ea_revisi = document.getElementById("no_ia_ea_revisi").value.trim();
      if(no_ia_ea_revisi === '') {
        no_ia_ea_revisi = "0";
      }
      var url = '{{ route('datatables.validasiNoIaPpReg', ['param','param2','param3']) }}';
      url = url.replace('param3', window.btoa(no_ia_ea_revisi));
      url = url.replace('param2', window.btoa(no_ia_ea));
      url = url.replace('param', window.btoa(kd_dept_pembuat));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_ia_ea").value = result["no_ia_ea"];
          document.getElementById("no_ia_ea_revisi").value = result["no_revisi"];
          validateNoIaUrut();
        } else {
          document.getElementById("no_ia_ea").value = "";
          document.getElementById("no_ia_ea_revisi").value = "";
          document.getElementById("no_ia_ea_urut").value = "";
          document.getElementById("desc_ia").value = "";
          document.getElementById("no_ia_ea").focus();
          swal("No. IA/EA tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_ia_ea").value = "";
      document.getElementById("no_ia_ea_revisi").value = "";
      document.getElementById("no_ia_ea_urut").value = "";
      document.getElementById("desc_ia").value = "";
    }
  }

  function popupNoIaUrut() {
    var myHeading = "<p>Popup No. IA/EA Urut</p>";
    $("#noiaurutModalLabel").html(myHeading);
    var no_ia_ea = document.getElementById('no_ia_ea').value.trim();
    var no_ia_ea_revisi = document.getElementById('no_ia_ea_revisi').value.trim();
    if(no_ia_ea === '') {
      no_ia_ea = "-";
    }
    if(no_ia_ea_revisi === '') {
      no_ia_ea_revisi = "-";
    }
    var url = '{{ route('datatables.popupNoIaPpRegUrut', ['param', 'param2']) }}';
    url = url.replace('param2', window.btoa(no_ia_ea_revisi));
    url = url.replace('param', window.btoa(no_ia_ea));
    var lookupNoiaurut = $('#lookupNoiaurut').DataTable({
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
        { data: 'no_urut', name: 'no_urut'},
        { data: 'desc_ia', name: 'desc_ia'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupNoiaurut tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupNoiaurut.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("no_ia_ea_urut").value = value["no_urut"];
            document.getElementById("desc_ia").value = value["desc_ia"];
            $('#noiaurutModal').modal('hide');
            validateNoIaUrut();
          });
        });
        $('#noiaurutModal').on('hidden.bs.modal', function () {
          var no_ia_ea_urut = document.getElementById("no_ia_ea_urut").value.trim();
          if(no_ia_ea_urut === '') {
            document.getElementById("desc_ia").value = "";
            $('#no_ia_ea_urut').focus();
          } else {
            // $('#no_ia_ea_urut').focus();
          }
        });
      },
    });
  }

  function validateNoIaUrut() {
    var no_ia_ea_urut = document.getElementById("no_ia_ea_urut").value.trim();
    if(no_ia_ea_urut !== '') {
      var no_ia_ea = document.getElementById('no_ia_ea').value.trim();
      var no_ia_ea_revisi = document.getElementById('no_ia_ea_revisi').value.trim();
      if(no_ia_ea === '') {
        no_ia_ea = "-";
      }
      if(no_ia_ea_revisi === '') {
        no_ia_ea_revisi = "-";
      }
      var url = '{{ route('datatables.validasiNoIaPpRegUrut', ['param','param2','param3']) }}';
      url = url.replace('param3', window.btoa(no_ia_ea_urut));
      url = url.replace('param2', window.btoa(no_ia_ea_revisi));
      url = url.replace('param', window.btoa(no_ia_ea));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("no_ia_ea_urut").value = result["no_urut"];
          document.getElementById("desc_ia").value = result["desc_ia"];
        } else {
          document.getElementById("no_ia_ea_urut").value = "";
          document.getElementById("desc_ia").value = "";
          document.getElementById("no_ia_ea_urut").focus();
          swal("No. Urut IA/EA tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("no_ia_ea_urut").value = "";
      document.getElementById("desc_ia").value = "";
    }
  }

  function popupKdBrg(e) {
    var valid = "F";
    var e_target_id = "";
    if((e + "").indexOf("btnkdbrg") >= 0) {
      valid = "T";
      e_target_id = e + "";
      e_target_id = e_target_id.replace('btnkdbrg', 'kd_brg');
    } else if(e.keyCode == 120) {
      valid = "T";
      e_target_id = e.target.id + "";
    }
    if(valid === 'T') {
      var myHeading = "<p>Popup Kode Barang</p>";
      $("#kdbrgModalLabel").html(myHeading);
      var url = '{{ route('datatables.popupVwBarang') }}';
      $('#kdbrgModal').modal('show');
      var lookupKdbrg = $('#lookupKdbrg').DataTable({
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
            { data: 'kd_brg', name: 'kd_brg'},
            { data: 'nama_brg', name: 'nama_brg'},
            { data: 'nama_type', name: 'nama_type'},
            { data: 'nama_merk', name: 'nama_merk'},
            { data: 'kode_kel', name: 'kode_kel'},
            { data: 'nama_kel', name: 'nama_kel'},
            { data: 'kd_sat', name: 'kd_sat'}
        ],
        "bDestroy": true,
        "initComplete": function(settings, json) {
          //$('div.dataTables_filter input').focus();
          $('#lookupKdbrg tbody').on( 'dblclick', 'tr', function () {
            var dataArr = [];
            var rows = $(this);
            var rowData = lookupKdbrg.rows(rows).data();
            $.each($(rowData),function(key,value){
              var id = e_target_id.replace('kd_brg', '');
              document.getElementById(e_target_id).value = value["kd_brg"];
              if(changeKdBrg === "T") {
                if(value["nama_brg"] == null) {
                  value["nama_brg"] = '-';
                }
                if(value["nama_type"] == null) {
                  value["nama_type"] = '-';
                }
                if(value["nama_merk"] == null) {
                  value["nama_merk"] = '-';
                }
                document.getElementById(id +'nm_brg').value = value["nama_brg"] + " # " + value["nama_type"] + " # " + value["nama_merk"];
                document.getElementById(id +'nmbrg2').value = value["nama_brg"] + " # " + value["nama_type"] + " # " + value["nama_merk"];
                $('#kdbrgModal').modal('hide');
                if(validateKdBrgDuplicate(e_target_id)) {
                  document.getElementById(id +'kd_brg').focus();
                } else {
                  document.getElementById(e_target_id).value = "";
                  document.getElementById(id +'nm_brg').value = "";
                  document.getElementById(id +'nmbrg2').value = "";
                  document.getElementById(e_target_id).focus();
                  swal("Kode Barang tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
                }
              } else {
                if(value["nama_brg"] == null) {
                  value["nama_brg"] = '-';
                }
                if(value["nama_type"] == null) {
                  value["nama_type"] = '-';
                }
                if(value["nama_merk"] == null) {
                  value["nama_merk"] = '-';
                }
                document.getElementById(id +'desc').value = value["nama_brg"] + " # " + value["nama_type"] + " # " + value["nama_merk"];
                document.getElementById(id +'nmbrg').value = value["nama_brg"] + " # " + value["nama_type"] + " # " + value["nama_merk"];
                $('#kdbrgModal').modal('hide');
                if(validateKdBrgDuplicate(e_target_id)) {
                  document.getElementById(id +'qty_pp').focus();
                } else {
                  document.getElementById(e_target_id).value = "";
                  document.getElementById(id +'desc').value = "";
                  document.getElementById(id +'nmbrg').value = "";
                  document.getElementById(e_target_id).focus();
                  swal("Kode Barang tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
                }
              }
            });
          });
          $('#kdbrgModal').on('hidden.bs.modal', function () {
            var kd_brg = document.getElementById(e_target_id).value.trim();
            if(changeKdBrg === "F") {
              if(kd_brg === '') {
                document.getElementById(e_target_id).focus();
                var id = e_target_id.replace('kd_brg', '');
                document.getElementById(id +'nmbrg').disabled = true;
              } else if(kd_brg.toUpperCase() === 'XXX') {
                var id = e_target_id.replace('kd_brg', '');
                document.getElementById(id +'nmbrg').disabled = false;
                document.getElementById(id +'nmbrg').focus();
              } else {
                var id = e_target_id.replace('kd_brg', '');
                document.getElementById(id +'nmbrg').disabled = true;
                document.getElementById(id +'qty_pp').focus();
              }
            }
          });
        },
      });
    }
  }

  function validateKdBrg(e) {
    var id = e.target.id.replace('kd_brg', '');
    var kd_brg = document.getElementById(e.target.id).value.trim();
    if(changeKdBrg === "F") {
      if(kd_brg === '') {
        document.getElementById(e.target.id).value = "";
        document.getElementById(id +'desc').value = "";
        document.getElementById(id +'nmbrg').value = "";
        document.getElementById(id +'nmbrg').disabled = true;
        document.getElementById(id +'qty_pp').focus();
      } else if(kd_brg.toUpperCase() === 'XXX') {
        //INPUT DESC MANUAL
        document.getElementById(id +'nmbrg').disabled = false;
        document.getElementById(id +'nmbrg').focus();
      } else {
        document.getElementById(id +'nmbrg').disabled = true;
        var url = '{{ route('datatables.validasiVwBarang', 'param') }}';
        url = url.replace('param', window.btoa(kd_brg));
        $.get(url, function(result){  
          if(result !== 'null'){
            result = JSON.parse(result);
            if(result["nama_brg"] == null) {
              result["nama_brg"] = '-';
            }
            if(result["nama_type"] == null) {
              result["nama_type"] = '-';
            }
            if(result["nama_merk"] == null) {
              result["nama_merk"] = '-';
            }
            document.getElementById(id +'desc').value = result["nama_brg"] + " # " + result["nama_type"] + " # " + result["nama_merk"];
            document.getElementById(id +'nmbrg').value = result["nama_brg"] + " # " + result["nama_type"] + " # " + result["nama_merk"];
            if(!validateKdBrgDuplicate(e.target.id)) {
              document.getElementById(e.target.id).value = "";
              document.getElementById(id +'desc').value = "";
              document.getElementById(id +'nmbrg').value = "";
              document.getElementById(e.target.id).focus();
              swal("Kode Barang tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
            }
          } else {
            document.getElementById(e.target.id).value = "";
            document.getElementById(id +'desc').value = "";
            document.getElementById(id +'nmbrg').value = "";
            document.getElementById(e.target.id).focus();
            swal("Kode Barang tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
          }
        });
      }
    } else {
      if(kd_brg === '') {
        document.getElementById(e.target.id).value = "";
        document.getElementById(id +'nm_brg').value = "";
        document.getElementById(id +'nmbrg2').value = "";
        document.getElementById(id +'kd_brg').focus();
      } else if(kd_brg.toUpperCase() === 'XXX') {
        document.getElementById(id +'nm_brg').value = "";
        document.getElementById(id +'nmbrg2').value = "";
      } else {
        var url = '{{ route('datatables.validasiVwBarang', 'param') }}';
        url = url.replace('param', window.btoa(kd_brg));
        $.get(url, function(result){  
          if(result !== 'null'){
            result = JSON.parse(result);
            if(result["nama_brg"] == null) {
              result["nama_brg"] = '-';
            }
            if(result["nama_type"] == null) {
              result["nama_type"] = '-';
            }
            if(result["nama_merk"] == null) {
              result["nama_merk"] = '-';
            }
            document.getElementById(id +'nm_brg').value = result["nama_brg"] + " # " + result["nama_type"] + " # " + result["nama_merk"];
            document.getElementById(id +'nmbrg2').value = result["nama_brg"] + " # " + result["nama_type"] + " # " + result["nama_merk"];
            if(!validateKdBrgDuplicate(e.target.id)) {
              document.getElementById(e.target.id).value = "";
              document.getElementById(id +'nm_brg').value = "";
              document.getElementById(id +'nmbrg2').value = "";
              document.getElementById(e.target.id).focus();
              swal("Kode Barang tidak boleh ada yang sama!", "Perhatikan inputan anda!", "warning");
            }
          } else {
            document.getElementById(e.target.id).value = "";
            document.getElementById(id +'nm_brg').value = "";
            document.getElementById(id +'nmbrg2').value = "";
            document.getElementById(e.target.id).focus();
            swal("Kode Barang tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
          }
        });
      }
    }
  }

  function validateNmBrg(e) {
    var id = e.target.id.replace('nmbrg', '');
    var nmbrg = document.getElementById(e.target.id).value.trim();
    document.getElementById(id +'desc').value = nmbrg;
  }

  function validateKdBrgDuplicate(parentId) {
    var id = parentId.replace('kd_brg', '');
    var kd_brg = document.getElementById(parentId).value.trim();
    if(kd_brg !== '' && kd_brg.toUpperCase() !== 'XXX') {
      var table = $('#tblDetail').DataTable();
      var valid = 'T';
      for($i = 0; $i < table.rows().count(); $i++) {
        var data = table.cell($i, 1).data();
        var posisi = data.indexOf("kd_brg");
        var target = data.substr(0, posisi);
        target = target.replace('<input type="hidden" value="', '');
        target = target.replace("<input type='hidden' value='", '');
        target = target.replace("<input type='hidden' value=", '');
        target = target.replace('<input value="', '');
        target = target.replace("<input value='", '');
        target = target.replace("<input value=", '');

        var target_kd_brg = target +'kd_brg';
        if(parentId !== target_kd_brg) {
          var kd_brg_temp = document.getElementById(target_kd_brg).value.trim();
          if(kd_brg_temp !== '') {
            if(kd_brg_temp.toUpperCase() === kd_brg.toUpperCase()) {
              valid = 'F';
              $i = table.rows().count();
            }
          }
        }
      }
      if(valid === 'T') {
        return true;
      } else {
        return false;
      }
    } else {
      return true;
    }
  }
</script>
@endsection