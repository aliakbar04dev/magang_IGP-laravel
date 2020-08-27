<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active">
    <a href="#fp" aria-controls="fp" role="tab" data-toggle="tab" title="Flow Process">
      4. Flow Process
    </a>
  </li>
  <li role="presentation">
    <a href="#sa" aria-controls="sa" role="tab" data-toggle="tab" title="Supplier Action">
      5. Supplier Action
    </a>
  </li>
  <li role="presentation">
    <a href="#rca" aria-controls="rca" role="tab" data-toggle="tab" title="Rootcause Analyze">
      6. Rootcause Analyze
    </a>
  </li>
  <li role="presentation">
    <a href="#cop" aria-controls="cop" role="tab" data-toggle="tab" title="Countermeasure Of Problem">
      7. COP
    </a>
  </li>
  <li role="presentation">
    <a href="#fpimp" aria-controls="fpimp" role="tab" data-toggle="tab" title="Flow Process After Improvement">
      8. FP After Improvement
    </a>
  </li>
  <li role="presentation">
    <a href="#evaluation" aria-controls="evaluation" role="tab" data-toggle="tab" title="Evaluation">
      9. Evaluation
    </a>
  </li>
  <li role="presentation">
    <a href="#std" aria-controls="std" role="tab" data-toggle="tab" title="Standardization">
      10. Standardization
    </a>
  </li>
  <li role="presentation">
    <a href="#yokotenkai" aria-controls="yokotenkai" role="tab" data-toggle="tab" title="Yokotenkai">
      11. Yokotenkai
    </a>
  </li>
</ul>
<!-- /.tablist -->

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="fp">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-3 {{ $errors->has('no_pica') ? ' has-error' : '' }}">
          {!! Form::label('no_pica', 'No. PICA (*)') !!}
          @if (empty($pica->no_pica))
            {!! Form::text('no_pica', null, ['class'=>'form-control','placeholder' => 'No. PICA (Min. 5 Karakter)', 'minlength' => 5, 'maxlength' => 30, 'required', 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
          @else
            {!! Form::text('no_pica2', $pica->no_pica, ['class'=>'form-control','placeholder' => 'No. PICA', 'required', 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)', 'disabled'=>'']) !!}
            {!! Form::hidden('no_pica', null, ['class'=>'form-control','placeholder' => 'No. PICA', 'minlength' => 5, 'maxlength' => 30, 'required', 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)', 'readonly'=>'readonly']) !!}
          @endif
          {!! Form::hidden('st_submit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_submit']) !!}
          {!! $errors->first('no_pica', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('tgl_pica') ? ' has-error' : '' }}">
          {!! Form::label('tgl_pica', 'Tanggal PICA (*)') !!}
          @if (empty($pica->tgl_pica))
            {!! Form::date('tgl_pica', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl PICA', 'required']) !!}
          @else
            {!! Form::date('tgl_pica', null, ['class'=>'form-control','placeholder' => 'Tgl PICA', 'required', 'disabled'=>'']) !!}
          @endif
          {!! $errors->first('tgl_pica', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-3 {{ $errors->has('issue_no') ? ' has-error' : '' }}">
          {!! Form::label('issue_no', 'No. QPR (*)') !!}
          @if (empty($pica->issue_no))
            {!! Form::text('issue_no2', $issue_no, ['class'=>'form-control','placeholder' => 'No. QPR', 'required', 'disabled'=>'']) !!}
            {!! Form::hidden('issue_no', $issue_no, ['class'=>'form-control','placeholder' => 'No. QPR', 'minlength' => 1, 'maxlength' => 30, 'required', 'readonly'=>'readonly']) !!}
          @else
            {!! Form::text('issue_no2', $pica->issue_no, ['class'=>'form-control','placeholder' => 'No. QPR', 'required', 'disabled'=>'']) !!}
            {!! Form::hidden('issue_no', null, ['class'=>'form-control','placeholder' => 'No. QPR', 'minlength' => 1, 'maxlength' => 30, 'required', 'readonly'=>'readonly']) !!}
          @endif
          {!! $errors->first('issue_no', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-5 {{ $errors->has('fp_pict_general') ? ' has-error' : '' }}">
          {!! Form::label('fp_pict_general', 'General Flow Process (jpeg,png,jpg)') !!}
          {!! Form::file('fp_pict_general', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($pica->fp_pict_general))
            <p>
              <img src="{{ $pica->pict("fp_pict_general") }}" alt="File Not Found" class="img-rounded img-responsive">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'fp_pict_general']) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('fp_pict_general', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-5 {{ $errors->has('fp_pict_detail') ? ' has-error' : '' }}">
          {!! Form::label('fp_pict_detail', 'Detail Flow Process (jpeg,png,jpg)') !!}
          {!! Form::file('fp_pict_detail', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($pica->fp_pict_detail))
            <p>
              <img src="{{ $pica->pict("fp_pict_detail") }}" alt="File Not Found" class="img-rounded img-responsive">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'fp_pict_detail']) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('fp_pict_detail', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="sa">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active">
        <a href="#sa2" aria-controls="sa2" role="tab" data-toggle="tab" title="Supplier Action">
          Supplier Action
        </a>
      </li>
      <li role="presentation">
        <a href="#iop" aria-controls="iop" role="tab" data-toggle="tab" title="Investigasi Of Problem">
          5.A. Investigasi Of Problem
        </a>
      </li>
      <li role="presentation">
        <a href="#ioptm" aria-controls="ioptm" role="tab" data-toggle="tab" title="Interview & Observasi Pengamatan Terhadap Member">
          5.B. Interview & Observasi
        </a>
      </li>
      <li role="presentation">
        <a href="#hp" aria-controls="hp" role="tab" data-toggle="tab" title="Henkaten Process / Changing Point Process">
          5.C. Henkaten Process / Changing Point Process
        </a>
      </li>
    </ul>
    <!-- /.tablist -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="sa2">
        <div class="box-body">
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('sa_pict') ? ' has-error' : '' }}">
              {!! Form::label('sa_pict', 'File Image (jpeg,png,jpg)') !!}
              {!! Form::file('sa_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->sa_pict))
                <p>
                  <img src="{{ $pica->pict("sa_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'sa_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('sa_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.tabpanel -->
      <div role="tabpanel" class="tab-pane" id="iop">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active">
            <a href="#ioptools" aria-controls="ioptools" role="tab" data-toggle="tab">
              <i class="fa fa-pencil-square-o"></i> Machine/Tools
            </a>
          </li>
          <li role="presentation">
            <a href="#iopmat" aria-controls="iopmat" role="tab" data-toggle="tab">
              <i class="fa fa-pencil-square-o"></i> Material
            </a>
          </li>
          <li role="presentation">
            <a href="#iopman" aria-controls="iopman" role="tab" data-toggle="tab">
              <i class="fa fa-pencil-square-o"></i> Man
            </a>
          </li>
          <li role="presentation">
            <a href="#iopmet" aria-controls="iopmet" role="tab" data-toggle="tab">
              <i class="fa fa-pencil-square-o"></i> Methode
            </a>
          </li>
          <li role="presentation">
            <a href="#iopenv" aria-controls="iopenv" role="tab" data-toggle="tab">
              <i class="fa fa-pencil-square-o"></i> Environment
            </a>
          </li>
        </ul>
        <!-- /.tablist -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="ioptools">
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_tools_subject') ? ' has-error' : '' }}">
                  {!! Form::label('iop_tools_subject', 'Subject') !!}
                  {!! Form::textarea('iop_tools_subject', null, ['class'=>'form-control', 'placeholder' => 'Subject', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_tools_subject', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_tools_pc') ? ' has-error' : '' }}">
                  {!! Form::label('iop_tools_pc', 'Point Check') !!}
                  {!! Form::textarea('iop_tools_pc', null, ['class'=>'form-control', 'placeholder' => 'Point Check', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_tools_pc', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_tools_std') ? ' has-error' : '' }}">
                  {!! Form::label('iop_tools_std', 'Standard') !!}
                  {!! Form::textarea('iop_tools_std', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_tools_std', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_tools_act') ? ' has-error' : '' }}">
                  {!! Form::label('iop_tools_act', 'Actual') !!}
                  {!! Form::textarea('iop_tools_act', null, ['class'=>'form-control', 'placeholder' => 'Actual', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_tools_act', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-3 {{ $errors->has('iop_tools_status') ? ' has-error' : '' }}">
                  {!! Form::label('iop_tools_status', 'Status') !!}
                  {!! Form::select('iop_tools_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
                  {!! $errors->first('iop_tools_status', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.tabpanel -->
          <div role="tabpanel" class="tab-pane" id="iopmat">
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_mat_subject') ? ' has-error' : '' }}">
                  {!! Form::label('iop_mat_subject', 'Subject') !!}
                  {!! Form::textarea('iop_mat_subject', null, ['class'=>'form-control', 'placeholder' => 'Subject', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_mat_subject', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_mat_pc') ? ' has-error' : '' }}">
                  {!! Form::label('iop_mat_pc', 'Point Check') !!}
                  {!! Form::textarea('iop_mat_pc', null, ['class'=>'form-control', 'placeholder' => 'Point Check', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_mat_pc', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_mat_std') ? ' has-error' : '' }}">
                  {!! Form::label('iop_mat_std', 'Standard') !!}
                  {!! Form::textarea('iop_mat_std', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_mat_std', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_mat_act') ? ' has-error' : '' }}">
                  {!! Form::label('iop_mat_act', 'Actual') !!}
                  {!! Form::textarea('iop_mat_act', null, ['class'=>'form-control', 'placeholder' => 'Actual', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_mat_act', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-3 {{ $errors->has('iop_mat_status') ? ' has-error' : '' }}">
                  {!! Form::label('iop_mat_status', 'Status') !!}
                  {!! Form::select('iop_mat_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
                  {!! $errors->first('iop_mat_status', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.tabpanel -->
          <div role="tabpanel" class="tab-pane" id="iopman">
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_man_subject') ? ' has-error' : '' }}">
                  {!! Form::label('iop_man_subject', 'Subject') !!}
                  {!! Form::textarea('iop_man_subject', null, ['class'=>'form-control', 'placeholder' => 'Subject', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_man_subject', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_man_pc') ? ' has-error' : '' }}">
                  {!! Form::label('iop_man_pc', 'Point Check') !!}
                  {!! Form::textarea('iop_man_pc', null, ['class'=>'form-control', 'placeholder' => 'Point Check', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_man_pc', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_man_std') ? ' has-error' : '' }}">
                  {!! Form::label('iop_man_std', 'Standard') !!}
                  {!! Form::textarea('iop_man_std', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_man_std', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_man_act') ? ' has-error' : '' }}">
                  {!! Form::label('iop_man_act', 'Actual') !!}
                  {!! Form::textarea('iop_man_act', null, ['class'=>'form-control', 'placeholder' => 'Actual', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_man_act', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-3 {{ $errors->has('iop_man_status') ? ' has-error' : '' }}">
                  {!! Form::label('iop_man_status', 'Status') !!}
                  {!! Form::select('iop_man_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
                  {!! $errors->first('iop_man_status', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.tabpanel -->
          <div role="tabpanel" class="tab-pane" id="iopmet">
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_met_subject') ? ' has-error' : '' }}">
                  {!! Form::label('iop_met_subject', 'Subject') !!}
                  {!! Form::textarea('iop_met_subject', null, ['class'=>'form-control', 'placeholder' => 'Subject', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_met_subject', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_met_pc') ? ' has-error' : '' }}">
                  {!! Form::label('iop_met_pc', 'Point Check') !!}
                  {!! Form::textarea('iop_met_pc', null, ['class'=>'form-control', 'placeholder' => 'Point Check', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_met_pc', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_met_std') ? ' has-error' : '' }}">
                  {!! Form::label('iop_met_std', 'Standard') !!}
                  {!! Form::textarea('iop_met_std', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_met_std', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_met_act') ? ' has-error' : '' }}">
                  {!! Form::label('iop_met_act', 'Actual') !!}
                  {!! Form::textarea('iop_met_act', null, ['class'=>'form-control', 'placeholder' => 'Actual', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_met_act', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-3 {{ $errors->has('iop_met_status') ? ' has-error' : '' }}">
                  {!! Form::label('iop_met_status', 'Status') !!}
                  {!! Form::select('iop_met_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
                  {!! $errors->first('iop_met_status', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.tabpanel -->
          <div role="tabpanel" class="tab-pane" id="iopenv">
            <div class="box-body">
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_env_subject') ? ' has-error' : '' }}">
                  {!! Form::label('iop_env_subject', 'Subject') !!}
                  {!! Form::textarea('iop_env_subject', null, ['class'=>'form-control', 'placeholder' => 'Subject', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_env_subject', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_env_pc') ? ' has-error' : '' }}">
                  {!! Form::label('iop_env_pc', 'Point Check') !!}
                  {!! Form::textarea('iop_env_pc', null, ['class'=>'form-control', 'placeholder' => 'Point Check', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_env_pc', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-5 {{ $errors->has('iop_env_std') ? ' has-error' : '' }}">
                  {!! Form::label('iop_env_std', 'Standard') !!}
                  {!! Form::textarea('iop_env_std', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_env_std', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-sm-5 {{ $errors->has('iop_env_act') ? ' has-error' : '' }}">
                  {!! Form::label('iop_env_act', 'Actual') !!}
                  {!! Form::textarea('iop_env_act', null, ['class'=>'form-control', 'placeholder' => 'Actual', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
                  {!! $errors->first('iop_env_act', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
              <div class="row form-group">
                <div class="col-sm-3 {{ $errors->has('iop_env_status') ? ' has-error' : '' }}">
                  {!! Form::label('iop_env_status', 'Status') !!}
                  {!! Form::select('iop_env_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
                  {!! $errors->first('iop_env_status', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.tabpanel -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.tabpanel -->
      <div role="tabpanel" class="tab-pane" id="ioptm">
        <div class="box-body">
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('ioptm_pict') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_pict', 'Foto MP (jpeg,png,jpg)') !!}
              {!! Form::file('ioptm_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->ioptm_pict))
                <p>
                  <img src="{{ $pica->pict("ioptm_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'ioptm_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('ioptm_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('ioptm_pk') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_pk', 'Product Knowledge') !!}
              {!! Form::textarea('ioptm_pk', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('ioptm_pk', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-3 {{ $errors->has('ioptm_pk_status') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_pk_status', 'Status Product Knowledge') !!}
              {!! Form::select('ioptm_pk_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
              {!! $errors->first('ioptm_pk_status', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('ioptm_qk') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_qk', 'Quality Knowledge') !!}
              {!! Form::textarea('ioptm_qk', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('ioptm_qk', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-3 {{ $errors->has('ioptm_qk_status') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_qk_status', 'Status Quality Knowledge') !!}
              {!! Form::select('ioptm_qk_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
              {!! $errors->first('ioptm_qk_status', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('ioptm_kp') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_kp', 'Kesulitan Proses') !!}
              {!! Form::textarea('ioptm_kp', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('ioptm_kp', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-3 {{ $errors->has('ioptm_kp_status') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_kp_status', 'Status Kesulitan Proses') !!}
              {!! Form::select('ioptm_kp_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
              {!! $errors->first('ioptm_kp_status', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('ioptm_sr') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_sr', 'SCW Rule') !!}
              {!! Form::textarea('ioptm_sr', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('ioptm_sr', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-3 {{ $errors->has('ioptm_sr_status') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_sr_status', 'SCW Rule') !!}
              {!! Form::select('ioptm_sr_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
              {!! $errors->first('ioptm_sr_status', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('ioptm_it') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_it', 'Ijiwaru Test') !!}
              {!! Form::textarea('ioptm_it', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('ioptm_it', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-3 {{ $errors->has('ioptm_it_status') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_it_status', 'Status Ijiwaru Test') !!}
              {!! Form::select('ioptm_it_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
              {!! $errors->first('ioptm_it_status', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('ioptm_jd') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_jd', 'Job Desc') !!}
              {!! Form::textarea('ioptm_jd', null, ['class'=>'form-control', 'placeholder' => 'Standard', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('ioptm_jd', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-3 {{ $errors->has('ioptm_jd_status') ? ' has-error' : '' }}">
              {!! Form::label('ioptm_jd_status', 'Status Job Desc') !!}
              {!! Form::select('ioptm_jd_status', ['O' => 'OK Sesuai Standard', 'P' => 'Potensi Problem', 'N' => 'NG / Tidak Standard'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status']) !!}
              {!! $errors->first('ioptm_jd_status', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.tabpanel -->
      <div role="tabpanel" class="tab-pane" id="hp">
        <div class="box-body">
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('hp_pict') ? ' has-error' : '' }}">
              {!! Form::label('hp_pict', 'File Image (jpeg,png,jpg)') !!}
              {!! Form::file('hp_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->hp_pict))
                <p>
                  <img src="{{ $pica->pict("hp_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'hp_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('hp_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.tabpanel -->
    </div>
    <!-- /.tab-content -->
  </div>
  <div role="tabpanel" class="tab-pane" id="rca">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-5 {{ $errors->has('rca_why_occured') ? ' has-error' : '' }}">
          {!! Form::label('rca_why_occured', 'Why Occured') !!}
          {!! Form::textarea('rca_why_occured', null, ['class'=>'form-control', 'placeholder' => 'Why Occured', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
          {!! $errors->first('rca_why_occured', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-5 {{ $errors->has('rca_why_outflow') ? ' has-error' : '' }}">
          {!! Form::label('rca_why_outflow', 'Why Out Flow') !!}
          {!! Form::textarea('rca_why_outflow', null, ['class'=>'form-control', 'placeholder' => 'Why Out Flow', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
          {!! $errors->first('rca_why_outflow', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-5 {{ $errors->has('rca_pict_occured') ? ' has-error' : '' }}">
          {!! Form::label('rca_pict_occured', 'Ilustration Occured (jpeg,png,jpg)') !!}
          {!! Form::file('rca_pict_occured', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($pica->rca_pict_occured))
            <p>
              <img src="{{ $pica->pict("rca_pict_occured") }}" alt="File Not Found" class="img-rounded img-responsive">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'rca_pict_occured']) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('rca_pict_occured', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-5 {{ $errors->has('rca_pict_outflow') ? ' has-error' : '' }}">
          {!! Form::label('rca_pict_outflow', 'Ilustration Out Flow (jpeg,png,jpg)') !!}
          {!! Form::file('rca_pict_outflow', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($pica->rca_pict_outflow))
            <p>
              <img src="{{ $pica->pict("rca_pict_outflow") }}" alt="File Not Found" class="img-rounded img-responsive">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'rca_pict_outflow']) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('rca_pict_outflow', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-5 {{ $errors->has('rca_root1') ? ' has-error' : '' }}">
          {!! Form::label('rca_root1', 'Root/Primary Causes of Problem (1)') !!}
          {!! Form::textarea('rca_root1', null, ['class'=>'form-control', 'placeholder' => 'Root/Primary Causes of Problem (1)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
          {!! $errors->first('rca_root1', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-5 {{ $errors->has('rca_root2') ? ' has-error' : '' }}">
          {!! Form::label('rca_root2', 'Root/Primary Causes of Problem (2)') !!}
          {!! Form::textarea('rca_root2', null, ['class'=>'form-control', 'placeholder' => 'Root/Primary Causes of Problem (2)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
          {!! $errors->first('rca_root2', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="cop">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active">
        <a href="#coptemp" aria-controls="coptemp" role="tab" data-toggle="tab">
          <i class="fa fa-pencil-square-o"></i> A. Temporary Action
        </a>
      </li>
      <li role="presentation">
        <a href="#copperm" aria-controls="copperm" role="tab" data-toggle="tab">
          <i class="fa fa-pencil-square-o"></i> B. Fix Countermeasure
        </a>
      </li>
    </ul>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="coptemp">
        <div class="box-body">
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action1') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action1', 'Temporary Action (1)') !!}
              {!! Form::textarea('cop_temp_action1', null, ['class'=>'form-control', 'placeholder' => 'Temporary Action (1)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_temp_action1', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_temp_action1_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action1_date', 'Tgl Temp. Action (1)') !!}
              {!! Form::date('cop_temp_action1_date', null, ['class'=>'form-control','placeholder' => 'Tgl Temp. Action (1)']) !!}
              {!! $errors->first('cop_temp_action1_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_temp_action1_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action1_pic', 'PIC Temp. Action (1)') !!}
              {!! Form::text('cop_temp_action1_pic', null, ['class'=>'form-control','placeholder' => 'PIC Temp. Action (1)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_temp_action1_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action1_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action1_pict', 'Ilustration (1) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_temp_action1_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_temp_action1_pict))
                <p>
                  <img src="{{ $pica->pict("cop_temp_action1_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_temp_action1_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_temp_action1_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action2') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action2', 'Temporary Action (2)') !!}
              {!! Form::textarea('cop_temp_action2', null, ['class'=>'form-control', 'placeholder' => 'Temporary Action (2)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_temp_action2', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_temp_action2_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action2_date', 'Tgl Temp. Action (2)') !!}
              {!! Form::date('cop_temp_action2_date', null, ['class'=>'form-control','placeholder' => 'Tgl Temp. Action (2)']) !!}
              {!! $errors->first('cop_temp_action2_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_temp_action2_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action2_pic', 'PIC Temp. Action (2)') !!}
              {!! Form::text('cop_temp_action2_pic', null, ['class'=>'form-control','placeholder' => 'PIC Temp. Action (2)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_temp_action2_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action2_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action2_pict', 'Ilustration (2) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_temp_action2_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_temp_action2_pict))
                <p>
                  <img src="{{ $pica->pict("cop_temp_action2_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_temp_action2_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_temp_action2_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action3') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action3', 'Temporary Action (3)') !!}
              {!! Form::textarea('cop_temp_action3', null, ['class'=>'form-control', 'placeholder' => 'Temporary Action (3)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_temp_action3', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_temp_action3_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action3_date', 'Tgl Temp. Action (3)') !!}
              {!! Form::date('cop_temp_action3_date', null, ['class'=>'form-control','placeholder' => 'Tgl Temp. Action (3)']) !!}
              {!! $errors->first('cop_temp_action3_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_temp_action3_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action3_pic', 'PIC Temp. Action (3)') !!}
              {!! Form::text('cop_temp_action3_pic', null, ['class'=>'form-control','placeholder' => 'PIC Temp. Action (3)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_temp_action3_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action3_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action3_pict', 'Ilustration (3) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_temp_action3_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_temp_action3_pict))
                <p>
                  <img src="{{ $pica->pict("cop_temp_action3_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_temp_action3_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_temp_action3_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action4') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action4', 'Temporary Action (4)') !!}
              {!! Form::textarea('cop_temp_action4', null, ['class'=>'form-control', 'placeholder' => 'Temporary Action (4)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_temp_action4', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_temp_action4_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action4_date', 'Tgl Temp. Action (4)') !!}
              {!! Form::date('cop_temp_action4_date', null, ['class'=>'form-control','placeholder' => 'Tgl Temp. Action (4)']) !!}
              {!! $errors->first('cop_temp_action4_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_temp_action4_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action4_pic', 'PIC Temp. Action (4)') !!}
              {!! Form::text('cop_temp_action4_pic', null, ['class'=>'form-control','placeholder' => 'PIC Temp. Action (4)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_temp_action4_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action4_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action4_pict', 'Ilustration (4) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_temp_action4_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_temp_action4_pict))
                <p>
                  <img src="{{ $pica->pict("cop_temp_action4_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_temp_action4_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_temp_action4_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action5') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action5', 'Temporary Action (5)') !!}
              {!! Form::textarea('cop_temp_action5', null, ['class'=>'form-control', 'placeholder' => 'Temporary Action (5)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_temp_action5', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_temp_action5_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action5_date', 'Tgl Temp. Action (5)') !!}
              {!! Form::date('cop_temp_action5_date', null, ['class'=>'form-control','placeholder' => 'Tgl Temp. Action (5)']) !!}
              {!! $errors->first('cop_temp_action5_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_temp_action5_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action5_pic', 'PIC Temp. Action (5)') !!}
              {!! Form::text('cop_temp_action5_pic', null, ['class'=>'form-control','placeholder' => 'PIC Temp. Action (5)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_temp_action5_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_temp_action5_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_temp_action5_pict', 'Ilustration (5) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_temp_action5_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_temp_action5_pict))
                <p>
                  <img src="{{ $pica->pict("cop_temp_action5_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_temp_action5_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_temp_action5_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.tabpanel -->
      <div role="tabpanel" class="tab-pane" id="copperm">
        <div class="box-body">
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action1') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action1', 'Fix Countermeasure (1)') !!}
              {!! Form::textarea('cop_fix_action1', null, ['class'=>'form-control', 'placeholder' => 'Fix Countermeasure (1)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_fix_action1', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_fix_action1_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action1_date', 'Tgl FC (1)') !!}
              {!! Form::date('cop_fix_action1_date', null, ['class'=>'form-control','placeholder' => 'Tgl Fix Countermeasure (1)']) !!}
              {!! $errors->first('cop_fix_action1_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_fix_action1_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action1_pic', 'PIC FC (1)') !!}
              {!! Form::text('cop_fix_action1_pic', null, ['class'=>'form-control','placeholder' => 'PIC Fix Countermeasure (1)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_fix_action1_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action1_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action1_pict', 'Ilustration (1) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_fix_action1_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_fix_action1_pict))
                <p>
                  <img src="{{ $pica->pict("cop_fix_action1_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_fix_action1_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_fix_action1_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action2') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action2', 'Fix Countermeasure (2)') !!}
              {!! Form::textarea('cop_fix_action2', null, ['class'=>'form-control', 'placeholder' => 'Fix Countermeasure (2)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_fix_action2', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_fix_action2_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action2_date', 'Tgl FC (2)') !!}
              {!! Form::date('cop_fix_action2_date', null, ['class'=>'form-control','placeholder' => 'Tgl Fix Countermeasure (2)']) !!}
              {!! $errors->first('cop_fix_action2_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_fix_action2_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action2_pic', 'PIC FC (2)') !!}
              {!! Form::text('cop_fix_action2_pic', null, ['class'=>'form-control','placeholder' => 'PIC Fix Countermeasure (2)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_fix_action2_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action2_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action2_pict', 'Ilustration (2) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_fix_action2_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_fix_action2_pict))
                <p>
                  <img src="{{ $pica->pict("cop_fix_action2_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_fix_action2_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_fix_action2_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action3') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action3', 'Fix Countermeasure (3)') !!}
              {!! Form::textarea('cop_fix_action3', null, ['class'=>'form-control', 'placeholder' => 'Fix Countermeasure (3)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_fix_action3', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_fix_action3_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action3_date', 'Tgl FC (3)') !!}
              {!! Form::date('cop_fix_action3_date', null, ['class'=>'form-control','placeholder' => 'Tgl Fix Countermeasure (3)']) !!}
              {!! $errors->first('cop_fix_action3_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_fix_action3_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action3_pic', 'PIC FC (3)') !!}
              {!! Form::text('cop_fix_action3_pic', null, ['class'=>'form-control','placeholder' => 'PIC Fix Countermeasure (3)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_fix_action3_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action3_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action3_pict', 'Ilustration (3) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_fix_action3_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_fix_action3_pict))
                <p>
                  <img src="{{ $pica->pict("cop_fix_action3_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_fix_action3_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_fix_action3_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action4') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action4', 'Fix Countermeasure (4)') !!}
              {!! Form::textarea('cop_fix_action4', null, ['class'=>'form-control', 'placeholder' => 'Fix Countermeasure (4)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_fix_action4', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_fix_action4_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action4_date', 'Tgl FC (4)') !!}
              {!! Form::date('cop_fix_action4_date', null, ['class'=>'form-control','placeholder' => 'Tgl Fix Countermeasure (4)']) !!}
              {!! $errors->first('cop_fix_action4_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_fix_action4_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action4_pic', 'PIC FC (4)') !!}
              {!! Form::text('cop_fix_action4_pic', null, ['class'=>'form-control','placeholder' => 'PIC Fix Countermeasure (4)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_fix_action4_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action4_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action4_pict', 'Ilustration (4) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_fix_action4_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_fix_action4_pict))
                <p>
                  <img src="{{ $pica->pict("cop_fix_action4_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_fix_action4_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_fix_action4_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action5') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action5', 'Fix Countermeasure (5)') !!}
              {!! Form::textarea('cop_fix_action5', null, ['class'=>'form-control', 'placeholder' => 'Fix Countermeasure (5)', 'rows' => '3', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
              {!! $errors->first('cop_fix_action5', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2 {{ $errors->has('cop_fix_action5_date') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action5_date', 'Tgl FC (5)') !!}
              {!! Form::date('cop_fix_action5_date', null, ['class'=>'form-control','placeholder' => 'Tgl Fix Countermeasure (5)']) !!}
              {!! $errors->first('cop_fix_action5_date', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-5 {{ $errors->has('cop_fix_action5_pic') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action5_pic', 'PIC FC (5)') !!}
              {!! Form::text('cop_fix_action5_pic', null, ['class'=>'form-control','placeholder' => 'PIC Fix Countermeasure (5)', 'maxlength' => 50, 'style' => 'text-transform:uppercase', 'onchange' => 'autoUpperCase(this)']) !!}
              {!! $errors->first('cop_fix_action5_pic', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
          <div class="row form-group">
            <div class="col-sm-5 {{ $errors->has('cop_fix_action5_pict') ? ' has-error' : '' }}">
              {!! Form::label('cop_fix_action5_pict', 'Ilustration (5) (jpeg,png,jpg)') !!}
              {!! Form::file('cop_fix_action5_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
              @if (!empty($pica->cop_fix_action5_pict))
                <p>
                  <img src="{{ $pica->pict("cop_fix_action5_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
                  <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'cop_fix_action5_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
              @endif
              {!! $errors->first('cop_fix_action5_pict', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.tabpanel -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="fpimp">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-5 {{ $errors->has('fp_improve_pict') ? ' has-error' : '' }}">
          {!! Form::label('fp_improve_pict', 'Flow Process After Improvement (jpeg,png,jpg)') !!}
          {!! Form::file('fp_improve_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($pica->fp_improve_pict))
            <p>
              <img src="{{ $pica->pict("fp_improve_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'fp_improve_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('fp_improve_pict', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="evaluation">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-5 {{ $errors->has('evaluation') ? ' has-error' : '' }}">
          {!! Form::label('evaluation', 'Evaluation') !!}
          {!! Form::textarea('evaluation', null, ['class'=>'form-control', 'placeholder' => 'Evaluation', 'rows' => '7', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
          {!! $errors->first('evaluation', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-5 {{ $errors->has('evaluation_pict') ? ' has-error' : '' }}">
          {!! Form::label('evaluation_pict', 'File Image (jpeg,png,jpg)') !!}
          {!! Form::file('evaluation_pict', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
          @if (!empty($pica->evaluation_pict))
            <p>
              <img src="{{ $pica->pict("evaluation_pict") }}" alt="File Not Found" class="img-rounded img-responsive">
              <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('picas.deleteimage', [base64_encode($pica->id), 'evaluation_pict']) }}"><span class="glyphicon glyphicon-remove"></span></a>
            </p>
          @endif
          {!! $errors->first('evaluation_pict', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="std" class="tab-pane" id="std">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-1 {{ $errors->has('std_sop') ? ' has-error' : '' }}">
          @if (empty($pica->std_sop))
            {!! Form::checkbox('std_sop', 'T', null) !!} SOP
          @else
            @if ($pica->std_sop === "T")
              {!! Form::checkbox('std_sop', 'T', true) !!} SOP
            @else
              {!! Form::checkbox('std_sop', 'T', false) !!} SOP
            @endif
          @endif
          {!! $errors->first('std_sop', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('std_point') ? ' has-error' : '' }}">
          @if (empty($pica->std_point))
            {!! Form::checkbox('std_point', 'T', null) !!} Point Penting
          @else
            @if ($pica->std_point === "T")
              {!! Form::checkbox('std_point', 'T', true) !!} Point Penting
            @else
              {!! Form::checkbox('std_point', 'T', false) !!} Point Penting
            @endif
          @endif
          {!! $errors->first('std_point', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-1 {{ $errors->has('std_wi') ? ' has-error' : '' }}">
          @if (empty($pica->std_wi))
            {!! Form::checkbox('std_wi', 'T', null) !!} WI
          @else
            @if ($pica->std_wi === "T")
              {!! Form::checkbox('std_wi', 'T', true) !!} WI
            @else
              {!! Form::checkbox('std_wi', 'T', false) !!} WI
            @endif
          @endif
          {!! $errors->first('std_wi', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('std_warning') ? ' has-error' : '' }}">
          @if (empty($pica->std_warning))
            {!! Form::checkbox('std_warning', 'T', null) !!} Warning
          @else
            @if ($pica->std_warning === "T")
              {!! Form::checkbox('std_warning', 'T', true) !!} Warning
            @else
              {!! Form::checkbox('std_warning', 'T', false) !!} Warning
            @endif
          @endif
          {!! $errors->first('std_warning', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-1 {{ $errors->has('std_qcpc') ? ' has-error' : '' }}">
          @if (empty($pica->std_qcpc))
            {!! Form::checkbox('std_qcpc', 'T', null) !!} QCPC
          @else
            @if ($pica->std_qcpc === "T")
              {!! Form::checkbox('std_qcpc', 'T', true) !!} QCPC
            @else
              {!! Form::checkbox('std_qcpc', 'T', false) !!} QCPC
            @endif
          @endif
          {!! $errors->first('std_qcpc', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('std_check_sheet') ? ' has-error' : '' }}">
          @if (empty($pica->std_check_sheet))
            {!! Form::checkbox('std_check_sheet', 'T', null) !!} Check Sheet
          @else
            @if ($pica->std_check_sheet === "T")
              {!! Form::checkbox('std_check_sheet', 'T', true) !!} Check Sheet
            @else
              {!! Form::checkbox('std_check_sheet', 'T', false) !!} Check Sheet
            @endif
          @endif
          {!! $errors->first('std_check_sheet', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
      <div class="row form-group">
        <div class="col-sm-1 {{ $errors->has('std_fmea') ? ' has-error' : '' }}">
          @if (empty($pica->std_fmea))
            {!! Form::checkbox('std_fmea', 'T', null) !!} FMEA
          @else
            @if ($pica->std_fmea === "T")
              {!! Form::checkbox('std_fmea', 'T', true) !!} FMEA
            @else
              {!! Form::checkbox('std_fmea', 'T', false) !!} FMEA
            @endif
          @endif
          {!! $errors->first('std_fmea', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2 {{ $errors->has('std_others') ? ' has-error' : '' }}">
          @if (empty($pica->std_others))
            {!! Form::checkbox('std_others', 'T', null) !!} Others
          @else
            @if ($pica->std_others === "T")
              {!! Form::checkbox('std_others', 'T', true) !!} Others
            @else
              {!! Form::checkbox('std_others', 'T', false) !!} Others
            @endif
          @endif
          {!! $errors->first('std_others', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="yokotenkai" class="tab-pane" id="yokotenkai">
    <div class="box-body">
      <div class="row form-group">
        <div class="col-sm-5 {{ $errors->has('yokotenkai') ? ' has-error' : '' }}">
          {!! Form::label('yokotenkai', 'Yokotenkai') !!}
          {!! Form::textarea('yokotenkai', null, ['class'=>'form-control', 'placeholder' => 'Yokotenkai', 'rows' => '7', 'maxlength' => 500, 'style' => 'resize:vertical']) !!}
          {!! $errors->first('yokotenkai', '<p class="help-block">:message</p>') !!}
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
  @if (Auth::user()->can('pica-submit'))
    &nbsp;&nbsp;
    <button id="btn-submit" type="button" class="btn btn-success">Submit PICA</button>
  @endif
  @if (!empty($pica->no_pica))
    &nbsp;&nbsp;
    <button id="btn-delete" type="button" class="btn btn-danger">Delete PICA</button>
  @endif
  &nbsp;&nbsp;
  @if (empty($pica->no_pica))
    <a class="btn btn-primary" href="{{ route('qprs.show', base64_encode($issue_no)) }}">Cancel</a>
  @else
    <a class="btn btn-primary" href="{{ route('picas.index') }}">Cancel</a>
  @endif
  &nbsp;&nbsp;<p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong. Max size file 8 MB', ['style'=>'color:red']) !!}</p>
</div>

@section('scripts')
<script type="text/javascript">
  document.getElementById("no_pica").focus();

  function autoUpperCase(a){
    a.value = a.value.toUpperCase();
  }

  $("#btn-delete").click(function(){
    var no_pica = document.getElementById("no_pica").value;
    if(no_pica !== "") {
      var msg = 'Anda yakin menghapus data ini?';
      var txt = 'No. PICA: ' + no_pica;
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
        var urlRedirect = "{{ route('picas.delete', 'param') }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(no_pica));
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
    var no_pica = document.getElementById("no_pica").value;
    if(no_pica === "") {
      var info = "No. PICA tidak boleh kosong!";
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var msg = 'Anda yakin submit data ini?';
      var txt = 'No. PICA: ' + no_pica;
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
      var no_pica = document.getElementById("no_pica").value;
      var msg = 'Anda yakin save data ini?';
      var txt = 'No. PICA: ' + no_pica;
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