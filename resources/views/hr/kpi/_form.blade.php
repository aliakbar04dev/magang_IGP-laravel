{!! Form::hidden('st_submit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_submit']) !!}
{!! Form::hidden('st_input', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'st_input']) !!}
<div class="box-body">
  <table class="table table-striped" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td style="width: 10%;"><b>Company Plan</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td style="width: 20%;">
          @if (!empty($hrdtkpi->id))
            <a target="_blank" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Show Activity {{ $hrdtkpi->tahun }}" href="{{ route('hrdtkpis.downloadcp', base64_encode($hrdtkpi->tahun)) }}"><span class="glyphicon glyphicon-download-alt"></span> Show Activity</a>
            {!! Form::hidden('year', $hrdtkpi->tahun, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'year']) !!}
            {!! Form::hidden('id', base64_encode($hrdtkpi->id), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'id']) !!}
          @else 
            <a target="_blank" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Show Activity {{ $year }}" href="{{ route('hrdtkpis.downloadcp', base64_encode($year)) }}"><span class="glyphicon glyphicon-download-alt"></span> Show Activity</a>
            {!! Form::hidden('year', $year, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'year']) !!}
            {!! Form::hidden('id', base64_encode("0"), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'id']) !!}
          @endif
        </td>
        <td style="width: 5%;"><b>Superior</b></td>
        <td style="width: 1%;"><b>:</b></td>
        <td>
          @if (!empty($hrdtkpi->id))
            {{ $hrdtkpi->npk_atasan." - ".$hrdtkpi->namaByNpk($hrdtkpi->npk_atasan) }}
          @else 
            {{ \Auth::user()->masKaryawan()->npk_atasan." - ".\Auth::user()->namaByNpk(\Auth::user()->masKaryawan()->npk_atasan) }}
          @endif
        </td>
      </tr>
      @if (!empty($hrdtkpi->id))
        <tr>
          <td style="width: 10%;"><b>Revisi</b></td>
          <td style="width: 1%;"><b>:</b></td>
          <td style="width: 20%;">
            @if ($hrdtkpi->hrdtKpiRejects()->get()->count() > 0)
              {{ $hrdtkpi->revisi }}
              @foreach ($hrdtkpi->hrdtKpiRejects()->get() as $hrdtkpireject)
                @if (Auth::user()->can(['hrd-kpi-view','hrd-kpi-create','hrd-kpi-delete','hrd-kpi-submit']))
                  {{ "&nbsp;-&nbsp;&nbsp;" }}<a target="_blank" href="{{ route('hrdtkpis.showrevisi', base64_encode($hrdtkpireject->id)) }}" data-toggle="tooltip" data-placement="top" title="Show History KPI Division No. Revisi {{ $hrdtkpireject->revisi }}">{{ $hrdtkpireject->revisi }}</a>
                @else
                  {{ "&nbsp;-&nbsp;&nbsp;".$hrdtkpireject->revisi }}
                @endif
              @endforeach
            @else
              {{ $hrdtkpi->revisi }}
            @endif
          </td>
          <td style="width: 5%;"><b>Status</b></td>
          <td style="width: 1%;"><b>:</b></td>
          <td>{{ $hrdtkpi->status }}</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>
<!-- /.box-body -->

<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active" id="nav_fp">
    <a href="#fp" aria-controls="fp" role="tab" data-toggle="tab" title="Financial Performance">
      I. Financial Performance
    </a>
  </li>
  <li role="presentation" id="nav_cs">
    <a href="#cs" aria-controls="cs" role="tab" data-toggle="tab" title="Customer">
      II. Customer
    </a>
  </li>
  <li role="presentation" id="nav_ip">
    <a href="#ip" aria-controls="ip" role="tab" data-toggle="tab" title="Internal Process">
      III. Internal Process
    </a>
  </li>
  <li role="presentation" id="nav_lg">
    <a href="#lg" aria-controls="lg" role="tab" data-toggle="tab" title="Learning & Growth">
      IV. Learning & Growth
    </a>
  </li>
  <li role="presentation" id="nav_cr">
    <a href="#cr" aria-controls="cr" role="tab" data-toggle="tab" title="Compliance Reporting">
      V. Compliance Reporting
    </a>
  </li>
</ul>
<!-- /.tablist -->

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="fp">
    <div class="box-body" id="field-fp">
      @if (!empty($hrdtkpi->id))
        @foreach ($hrdtkpi->hrdtKpiActByItem("FP")->get() as $model)
          <div class="row" id="field_fp_{{ $loop->iteration }}">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box_fp_{{ $loop->iteration }}">Financial Performance - Activity ({{ $loop->iteration }}) (*)</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                      <button id="btndeleteactivity_fp_{{ $loop->iteration }}" name="btndeleteactivity_fp_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'fp')">
                        <i class="fa fa-times"></i>
                      </button>
                    @else 
                      <button id="btndeleteactivity_fp_{{ $loop->iteration }}" name="btndeleteactivity_fp_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'fp')" disabled="">
                        <i class="fa fa-times"></i>
                      </button>
                    @endif
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-11 {{ $errors->has('kpi_ref_desc_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('kpi_ref_desc_fp_'.$loop->iteration, 'KPI Reference (Klik tombol Search) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('kpi_ref_desc_fp_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_fp_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @else 
                        {!! Form::textarea('kpi_ref_desc_fp_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_fp_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @endif
                      {!! Form::hidden('kpi_ref_fp_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_fp_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                      {!! $errors->first('kpi_ref_desc_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-1 pull-left">
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        <button id="btnpopupkpiref_fp_{{ $loop->iteration }}" name="btnpopupkpiref_fp_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'fp')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>
                      @else 
                        <button id="btnpopupkpiref_fp_{{ $loop->iteration }}" name="btnpopupkpiref_fp_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'fp')" data-toggle="modal" data-target="#refModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-12 {{ $errors->has('activity_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('activity_fp_'.$loop->iteration, 'Activity (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('activity_fp_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_fp_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::textarea('activity_fp_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_fp_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! Form::hidden('hrdtkpi_fp_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_fp_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                      {!! $errors->first('activity_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->

                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                      <a href="#q1_fp_{{ $loop->iteration }}" aria-controls="q1_fp_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q1
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q2_fp_{{ $loop->iteration }}" aria-controls="q2_fp_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q2
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q3_fp_{{ $loop->iteration }}" aria-controls="q3_fp_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q3
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q4_fp_{{ $loop->iteration }}" aria-controls="q4_fp_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q4
                      </a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="q1_fp_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q1_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q1_fp_'.$loop->iteration, 'Q1 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q1_fp_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_fp_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q1_fp_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q1_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q1_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q1_fp_'.$loop->iteration, 'Due Date Q1') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q1_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q1_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q1_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q1_act_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q1_act_fp_'.$loop->iteration, 'Q1 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q1_act_fp_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q1_act_fp_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q1_act_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q1_fp_'.$loop->iteration, 'Act Date Q1') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q1_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_fp_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q1_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q1_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q1_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q1_fp_'.$loop->iteration, 'Q1 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q1_fp_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q1_fp_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q1_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-6 {{ $errors->has('problem_q1_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('problem_q1_fp_'.$loop->iteration, 'Q1 Problem') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('problem_q1_fp_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('problem_q1_fp_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('problem_q1_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q2_fp_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q2_fp_'.$loop->iteration, 'Q2 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q2_fp_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_fp_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q2_fp_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q2_fp_'.$loop->iteration, 'Due Date Q2') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q2_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q2_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q2_act_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q2_act_fp_'.$loop->iteration, 'Q2 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q2_act_fp_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q2_act_fp_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q2_act_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q2_fp_'.$loop->iteration, 'Act Date Q2') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q2_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_fp_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q2_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q2_fp_'.$loop->iteration, 'Q2 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q2_fp_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q2_fp_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q3_fp_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q3_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q3_fp_'.$loop->iteration, 'Q3 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q3_fp_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_fp_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q3_fp_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q3_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q3_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q3_fp_'.$loop->iteration, 'Due Date Q3') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q3_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q3_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q3_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q3_act_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q3_act_fp_'.$loop->iteration, 'Q3 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q3_act_fp_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q3_act_fp_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q3_act_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q3_fp_'.$loop->iteration, 'Act Date Q3') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q3_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_fp_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q3_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q3_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q3_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q3_fp_'.$loop->iteration, 'Q3 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q3_fp_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q3_fp_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q3_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q4_fp_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q4_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q4_fp_'.$loop->iteration, 'Q4 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q4_fp_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_fp_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q4_fp_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q4_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q4_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q4_fp_'.$loop->iteration, 'Due Date Q4') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q4_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q4_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q4_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q4_act_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q4_act_fp_'.$loop->iteration, 'Q4 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q4_act_fp_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q4_act_fp_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q4_act_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q4_fp_'.$loop->iteration, 'Act Date Q4') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q4_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_fp_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q4_fp_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q4_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q4_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q4_fp_'.$loop->iteration, 'Q4 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q4_fp_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_fp_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q4_fp_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_fp_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q4_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                  </div>
                  <!-- /.tab-content -->
                  <hr class="box box-primary">
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('weight_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('weight_fp_'.$loop->iteration, 'Weight (%) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::number('weight_fp_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_fp_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::number('weight_fp_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_fp_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! $errors->first('weight_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen_fp_'.$loop->iteration, 'Department in Charge') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen_fp_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_fp_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen_fp_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_fp_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('total_weight_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('total_weight_fp_'.$loop->iteration, 'Summary Weight (%)') !!}
                      {!! Form::number('total_weight_fp_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_fp_'.$loop->iteration]) !!}
                      {!! $errors->first('total_weight_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen2_fp_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen2_fp_'.$loop->iteration, 'Need Support Others Department') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen2_fp_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_fp_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen2_fp_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_fp_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen2_fp_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
        {!! Form::hidden('jml_row_fp', $hrdtkpi->hrdtKpiActByItem("FP")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_fp']) !!}
      @else
        {!! Form::hidden('jml_row_fp', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_fp']) !!}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
        @if (!empty($hrdtkpi->id))
          @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
            <button id="addRowFp" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Financial Performance"><span class="glyphicon glyphicon-plus"></span> Add Activity Financial Performance</button>
            &nbsp;&nbsp;
          @endif
        @else
          <button id="addRowFp" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Financial Performance"><span class="glyphicon glyphicon-plus"></span> Add Activity Financial Performance</button>
          &nbsp;&nbsp;
        @endif
        <button id="nextRowFp" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Customer"><span class="glyphicon glyphicon-arrow-right"></span> Next to Customer</button>
      </p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="cs">
    <div class="box-body" id="field-cs">
      @if (!empty($hrdtkpi->id))
        @foreach ($hrdtkpi->hrdtKpiActByItem("CS")->get() as $model)
          <div class="row" id="field_cs_{{ $loop->iteration }}">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box_cs_{{ $loop->iteration }}">Customer - Activity ({{ $loop->iteration }}) (*)</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                      <button id="btndeleteactivity_cs_{{ $loop->iteration }}" name="btndeleteactivity_cs_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'cs')">
                        <i class="fa fa-times"></i>
                      </button>
                    @else 
                      <button id="btndeleteactivity_cs_{{ $loop->iteration }}" name="btndeleteactivity_cs_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'cs')" disabled="">
                        <i class="fa fa-times"></i>
                      </button>
                    @endif
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-11 {{ $errors->has('kpi_ref_desc_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('kpi_ref_desc_cs_'.$loop->iteration, 'KPI Reference (Klik tombol Search) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('kpi_ref_desc_cs_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_cs_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @else 
                        {!! Form::textarea('kpi_ref_desc_cs_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_cs_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @endif
                      {!! Form::hidden('kpi_ref_cs_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_cs_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                      {!! $errors->first('kpi_ref_desc_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-1 pull-left">
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        <button id="btnpopupkpiref_cs_{{ $loop->iteration }}" name="btnpopupkpiref_cs_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'cs')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>
                      @else 
                        <button id="btnpopupkpiref_cs_{{ $loop->iteration }}" name="btnpopupkpiref_cs_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'cs')" data-toggle="modal" data-target="#refModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-12 {{ $errors->has('activity_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('activity_cs_'.$loop->iteration, 'Activity (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('activity_cs_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_cs_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::textarea('activity_cs_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_cs_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! Form::hidden('hrdtkpi_cs_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_cs_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                      {!! $errors->first('activity_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->

                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                      <a href="#q1_cs_{{ $loop->iteration }}" aria-controls="q1_cs_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q1
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q2_cs_{{ $loop->iteration }}" aria-controls="q2_cs_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q2
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q3_cs_{{ $loop->iteration }}" aria-controls="q3_cs_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q3
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q4_cs_{{ $loop->iteration }}" aria-controls="q4_cs_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q4
                      </a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="q1_cs_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q1_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q1_cs_'.$loop->iteration, 'Q1 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q1_cs_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_cs_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q1_cs_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q1_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q1_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q1_cs_'.$loop->iteration, 'Due Date Q1') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q1_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q1_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q1_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q1_act_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q1_act_cs_'.$loop->iteration, 'Q1 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q1_act_cs_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q1_act_cs_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q1_act_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q1_cs_'.$loop->iteration, 'Act Date Q1') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q1_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_cs_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q1_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q1_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q1_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q1_cs_'.$loop->iteration, 'Q1 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q1_cs_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q1_cs_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q1_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-6 {{ $errors->has('problem_q1_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('problem_q1_cs_'.$loop->iteration, 'Q1 Problem') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('problem_q1_cs_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('problem_q1_cs_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('problem_q1_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q2_cs_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q2_cs_'.$loop->iteration, 'Q2 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q2_cs_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_cs_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q2_cs_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q2_cs_'.$loop->iteration, 'Due Date Q2') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q2_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q2_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q2_act_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q2_act_cs_'.$loop->iteration, 'Q2 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q2_act_cs_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q2_act_cs_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q2_act_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q2_cs_'.$loop->iteration, 'Act Date Q2') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q2_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_cs_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q2_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q2_cs_'.$loop->iteration, 'Q2 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q2_cs_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q2_cs_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q3_cs_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q3_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q3_cs_'.$loop->iteration, 'Q3 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q3_cs_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_cs_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q3_cs_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q3_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q3_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q3_cs_'.$loop->iteration, 'Due Date Q3') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q3_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q3_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q3_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q3_act_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q3_act_cs_'.$loop->iteration, 'Q3 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q3_act_cs_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q3_act_cs_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q3_act_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q3_cs_'.$loop->iteration, 'Act Date Q3') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q3_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_cs_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q3_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q3_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q3_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q3_cs_'.$loop->iteration, 'Q3 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q3_cs_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q3_cs_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q3_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q4_cs_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q4_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q4_cs_'.$loop->iteration, 'Q4 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q4_cs_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_cs_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q4_cs_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q4_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q4_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q4_cs_'.$loop->iteration, 'Due Date Q4') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q4_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q4_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q4_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q4_act_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q4_act_cs_'.$loop->iteration, 'Q4 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q4_act_cs_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q4_act_cs_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q4_act_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q4_cs_'.$loop->iteration, 'Act Date Q4') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q4_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_cs_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q4_cs_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q4_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q4_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q4_cs_'.$loop->iteration, 'Q4 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q4_cs_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_cs_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q4_cs_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_cs_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q4_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                  </div>
                  <!-- /.tab-content -->
                  <hr class="box box-primary">
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('weight_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('weight_cs_'.$loop->iteration, 'Weight (%) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::number('weight_cs_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_cs_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::number('weight_cs_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_cs_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! $errors->first('weight_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen_cs_'.$loop->iteration, 'Department in Charge') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen_cs_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_cs_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen_cs_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_cs_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('total_weight_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('total_weight_cs_'.$loop->iteration, 'Summary Weight (%)') !!}
                      {!! Form::number('total_weight_cs_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_cs_'.$loop->iteration]) !!}
                      {!! $errors->first('total_weight_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen2_cs_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen2_cs_'.$loop->iteration, 'Need Support Others Department') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen2_cs_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_cs_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen2_cs_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_cs_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen2_cs_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
        {!! Form::hidden('jml_row_cs', $hrdtkpi->hrdtKpiActByItem("CS")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_cs']) !!}
      @else
        {!! Form::hidden('jml_row_cs', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_cs']) !!}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
        @if (!empty($hrdtkpi->id))
          @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
            <button id="addRowCs" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Customer"><span class="glyphicon glyphicon-plus"></span> Add Activity Customer</button>
            &nbsp;&nbsp;
          @endif
        @else
          <button id="addRowCs" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Customer"><span class="glyphicon glyphicon-plus"></span> Add Activity Customer</button>
          &nbsp;&nbsp;
        @endif
        <button id="nextRowCs" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Internal Process"><span class="glyphicon glyphicon-arrow-right"></span> Next to Internal Process</button>
      </p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="ip">
    <div class="box-body" id="field-ip">
      @if (!empty($hrdtkpi->id))
        @foreach ($hrdtkpi->hrdtKpiActByItem("IP")->get() as $model)
          <div class="row" id="field_ip_{{ $loop->iteration }}">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box_ip_{{ $loop->iteration }}">Internal Process - Activity ({{ $loop->iteration }}) (*)</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                      <button id="btndeleteactivity_ip_{{ $loop->iteration }}" name="btndeleteactivity_ip_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'ip')">
                        <i class="fa fa-times"></i>
                      </button>
                    @else 
                      <button id="btndeleteactivity_ip_{{ $loop->iteration }}" name="btndeleteactivity_ip_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'ip')" disabled="">
                        <i class="fa fa-times"></i>
                      </button>
                    @endif
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-11 {{ $errors->has('kpi_ref_desc_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('kpi_ref_desc_ip_'.$loop->iteration, 'KPI Reference (Klik tombol Search) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('kpi_ref_desc_ip_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_ip_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @else 
                        {!! Form::textarea('kpi_ref_desc_ip_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_ip_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @endif
                      {!! Form::hidden('kpi_ref_ip_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_ip_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                      {!! $errors->first('kpi_ref_desc_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-1 pull-left">
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        <button id="btnpopupkpiref_ip_{{ $loop->iteration }}" name="btnpopupkpiref_ip_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'ip')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>
                      @else 
                        <button id="btnpopupkpiref_ip_{{ $loop->iteration }}" name="btnpopupkpiref_ip_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'ip')" data-toggle="modal" data-target="#refModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-12 {{ $errors->has('activity_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('activity_ip_'.$loop->iteration, 'Activity (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('activity_ip_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_ip_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::textarea('activity_ip_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_ip_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! Form::hidden('hrdtkpi_ip_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_ip_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                      {!! $errors->first('activity_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->

                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                      <a href="#q1_ip_{{ $loop->iteration }}" aria-controls="q1_ip_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q1
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q2_ip_{{ $loop->iteration }}" aria-controls="q2_ip_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q2
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q3_ip_{{ $loop->iteration }}" aria-controls="q3_ip_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q3
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q4_ip_{{ $loop->iteration }}" aria-controls="q4_ip_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q4
                      </a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="q1_ip_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q1_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q1_ip_'.$loop->iteration, 'Q1 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q1_ip_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_ip_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q1_ip_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q1_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q1_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q1_ip_'.$loop->iteration, 'Due Date Q1') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q1_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q1_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q1_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q1_act_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q1_act_ip_'.$loop->iteration, 'Q1 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q1_act_ip_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q1_act_ip_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q1_act_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q1_ip_'.$loop->iteration, 'Act Date Q1') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q1_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_ip_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q1_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q1_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q1_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q1_ip_'.$loop->iteration, 'Q1 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q1_ip_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q1_ip_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q1_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-6 {{ $errors->has('problem_q1_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('problem_q1_ip_'.$loop->iteration, 'Q1 Problem') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('problem_q1_ip_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('problem_q1_ip_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('problem_q1_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q2_ip_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q2_ip_'.$loop->iteration, 'Q2 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q2_ip_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_ip_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q2_ip_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q2_ip_'.$loop->iteration, 'Due Date Q2') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q2_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q2_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q2_act_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q2_act_ip_'.$loop->iteration, 'Q2 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q2_act_ip_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q2_act_ip_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q2_act_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q2_ip_'.$loop->iteration, 'Act Date Q2') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q2_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_ip_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q2_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q2_ip_'.$loop->iteration, 'Q2 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q2_ip_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q2_ip_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q3_ip_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q3_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q3_ip_'.$loop->iteration, 'Q3 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q3_ip_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_ip_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q3_ip_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q3_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q3_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q3_ip_'.$loop->iteration, 'Due Date Q3') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q3_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q3_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q3_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q3_act_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q3_act_ip_'.$loop->iteration, 'Q3 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q3_act_ip_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q3_act_ip_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q3_act_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q3_ip_'.$loop->iteration, 'Act Date Q3') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q3_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_ip_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q3_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q3_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q3_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q3_ip_'.$loop->iteration, 'Q3 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q3_ip_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q3_ip_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q3_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q4_ip_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q4_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q4_ip_'.$loop->iteration, 'Q4 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q4_ip_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_ip_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q4_ip_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q4_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q4_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q4_ip_'.$loop->iteration, 'Due Date Q4') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q4_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q4_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q4_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q4_act_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q4_act_ip_'.$loop->iteration, 'Q4 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q4_act_ip_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q4_act_ip_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q4_act_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q4_ip_'.$loop->iteration, 'Act Date Q4') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q4_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_ip_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q4_ip_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q4_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q4_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q4_ip_'.$loop->iteration, 'Q4 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q4_ip_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_ip_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q4_ip_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_ip_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q4_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                  </div>
                  <!-- /.tab-content -->
                  <hr class="box box-primary">
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('weight_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('weight_ip_'.$loop->iteration, 'Weight (%) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::number('weight_ip_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_ip_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::number('weight_ip_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_ip_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! $errors->first('weight_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen_ip_'.$loop->iteration, 'Department in Charge') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen_ip_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_ip_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen_ip_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_ip_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('total_weight_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('total_weight_ip_'.$loop->iteration, 'Summary Weight (%)') !!}
                      {!! Form::number('total_weight_ip_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_ip_'.$loop->iteration]) !!}
                      {!! $errors->first('total_weight_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen2_ip_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen2_ip_'.$loop->iteration, 'Need Support Others Department') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen2_ip_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_ip_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen2_ip_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_ip_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen2_ip_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
        {!! Form::hidden('jml_row_ip', $hrdtkpi->hrdtKpiActByItem("IP")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_ip']) !!}
      @else
        {!! Form::hidden('jml_row_ip', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_ip']) !!}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
        @if (!empty($hrdtkpi->id))
          @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
            <button id="addRowIp" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Internal Process"><span class="glyphicon glyphicon-plus"></span> Add Activity Internal Process</button>
            &nbsp;&nbsp;
          @endif
        @else
          <button id="addRowIp" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Internal Process"><span class="glyphicon glyphicon-plus"></span> Add Activity Internal Process</button>
          &nbsp;&nbsp;
        @endif
        <button id="nextRowIp" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Learning & Growth"><span class="glyphicon glyphicon-arrow-right"></span> Next to Learning & Growth</button>
      </p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="lg">
    <div class="box-body" id="field-lg">
      @if (!empty($hrdtkpi->id))
        @foreach ($hrdtkpi->hrdtKpiActByItem("LG")->get() as $model)
          <div class="row" id="field_lg_{{ $loop->iteration }}">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box_lg_{{ $loop->iteration }}">Learning & Growth - Activity ({{ $loop->iteration }}) (*)</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                      <button id="btndeleteactivity_lg_{{ $loop->iteration }}" name="btndeleteactivity_lg_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'lg')">
                        <i class="fa fa-times"></i>
                      </button>
                    @else 
                      <button id="btndeleteactivity_lg_{{ $loop->iteration }}" name="btndeleteactivity_lg_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'lg')" disabled="">
                        <i class="fa fa-times"></i>
                      </button>
                    @endif
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-11 {{ $errors->has('kpi_ref_desc_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('kpi_ref_desc_lg_'.$loop->iteration, 'KPI Reference (Klik tombol Search) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('kpi_ref_desc_lg_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_lg_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @else 
                        {!! Form::textarea('kpi_ref_desc_lg_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_lg_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @endif
                      {!! Form::hidden('kpi_ref_lg_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_lg_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                      {!! $errors->first('kpi_ref_desc_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-1 pull-left">
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        <button id="btnpopupkpiref_lg_{{ $loop->iteration }}" name="btnpopupkpiref_lg_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'lg')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>
                      @else 
                        <button id="btnpopupkpiref_lg_{{ $loop->iteration }}" name="btnpopupkpiref_lg_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'lg')" data-toggle="modal" data-target="#refModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-12 {{ $errors->has('activity_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('activity_lg_'.$loop->iteration, 'Activity (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('activity_lg_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_lg_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::textarea('activity_lg_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_lg_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! Form::hidden('hrdtkpi_lg_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_lg_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                      {!! $errors->first('activity_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->

                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                      <a href="#q1_lg_{{ $loop->iteration }}" aria-controls="q1_lg_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q1
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q2_lg_{{ $loop->iteration }}" aria-controls="q2_lg_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q2
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q3_lg_{{ $loop->iteration }}" aria-controls="q3_lg_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q3
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q4_lg_{{ $loop->iteration }}" aria-controls="q4_lg_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q4
                      </a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="q1_lg_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q1_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q1_lg_'.$loop->iteration, 'Q1 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q1_lg_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_lg_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q1_lg_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q1_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q1_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q1_lg_'.$loop->iteration, 'Due Date Q1') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q1_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q1_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q1_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q1_act_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q1_act_lg_'.$loop->iteration, 'Q1 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q1_act_lg_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q1_act_lg_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q1_act_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q1_lg_'.$loop->iteration, 'Act Date Q1') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q1_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_lg_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q1_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q1_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q1_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q1_lg_'.$loop->iteration, 'Q1 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q1_lg_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q1_lg_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q1_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-6 {{ $errors->has('problem_q1_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('problem_q1_lg_'.$loop->iteration, 'Q1 Problem') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('problem_q1_lg_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('problem_q1_lg_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('problem_q1_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q2_lg_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q2_lg_'.$loop->iteration, 'Q2 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q2_lg_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_lg_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q2_lg_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q2_lg_'.$loop->iteration, 'Due Date Q2') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q2_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q2_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q2_act_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q2_act_lg_'.$loop->iteration, 'Q2 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q2_act_lg_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q2_act_lg_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q2_act_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q2_lg_'.$loop->iteration, 'Act Date Q2') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q2_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_lg_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q2_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q2_lg_'.$loop->iteration, 'Q2 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q2_lg_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q2_lg_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q3_lg_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q3_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q3_lg_'.$loop->iteration, 'Q3 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q3_lg_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_lg_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q3_lg_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q3_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q3_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q3_lg_'.$loop->iteration, 'Due Date Q3') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q3_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q3_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q3_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q3_act_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q3_act_lg_'.$loop->iteration, 'Q3 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q3_act_lg_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q3_act_lg_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q3_act_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q3_lg_'.$loop->iteration, 'Act Date Q3') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q3_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_lg_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q3_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q3_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q3_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q3_lg_'.$loop->iteration, 'Q3 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q3_lg_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q3_lg_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q3_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q4_lg_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q4_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q4_lg_'.$loop->iteration, 'Q4 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q4_lg_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_lg_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q4_lg_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q4_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q4_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q4_lg_'.$loop->iteration, 'Due Date Q4') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q4_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q4_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q4_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q4_act_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q4_act_lg_'.$loop->iteration, 'Q4 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q4_act_lg_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q4_act_lg_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q4_act_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q4_lg_'.$loop->iteration, 'Act Date Q4') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q4_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_lg_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q4_lg_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q4_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q4_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q4_lg_'.$loop->iteration, 'Q4 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q4_lg_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_lg_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q4_lg_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_lg_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q4_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                  </div>
                  <!-- /.tab-content -->
                  <hr class="box box-primary">
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('weight_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('weight_lg_'.$loop->iteration, 'Weight (%) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::number('weight_lg_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_lg_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::number('weight_lg_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_lg_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! $errors->first('weight_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen_lg_'.$loop->iteration, 'Department in Charge') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen_lg_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_lg_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen_lg_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_lg_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('total_weight_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('total_weight_lg_'.$loop->iteration, 'Summary Weight (%)') !!}
                      {!! Form::number('total_weight_lg_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_lg_'.$loop->iteration]) !!}
                      {!! $errors->first('total_weight_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen2_lg_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen2_lg_'.$loop->iteration, 'Need Support Others Department') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen2_lg_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_lg_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen2_lg_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_lg_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen2_lg_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
        {!! Form::hidden('jml_row_lg', $hrdtkpi->hrdtKpiActByItem("LG")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_lg']) !!}
      @else
        {!! Form::hidden('jml_row_lg', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_lg']) !!}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
        @if (!empty($hrdtkpi->id))
          @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
            <button id="addRowLg" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Learning & Growth"><span class="glyphicon glyphicon-plus"></span> Add Activity Learning & Growth</button>
            &nbsp;&nbsp;
          @endif
        @else
          <button id="addRowLg" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Learning & Growth"><span class="glyphicon glyphicon-plus"></span> Add Activity Learning & Growth</button>
          &nbsp;&nbsp;
        @endif
        <button id="nextRowLg" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Next to Compliance Reporting"><span class="glyphicon glyphicon-arrow-right"></span> Next to Compliance Reporting</button>
      </p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
  <div role="tabpanel" class="tab-pane" id="cr">
    <div class="box-body" id="field-cr">
      @if (!empty($hrdtkpi->id))
        @foreach ($hrdtkpi->hrdtKpiActByItem("CR")->get() as $model)
          <div class="row" id="field_cr_{{ $loop->iteration }}">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title" id="box_cr_{{ $loop->iteration }}">Compliance Reporting - Activity ({{ $loop->iteration }}) (*)</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                      <button id="btndeleteactivity_cr_{{ $loop->iteration }}" name="btndeleteactivity_cr_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'cr')">
                        <i class="fa fa-times"></i>
                      </button>
                    @else 
                      <button id="btndeleteactivity_cr_{{ $loop->iteration }}" name="btndeleteactivity_cr_{{ $loop->iteration }}" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,'cr')" disabled="">
                        <i class="fa fa-times"></i>
                      </button>
                    @endif
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row form-group">
                    <div class="col-sm-11 {{ $errors->has('kpi_ref_desc_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('kpi_ref_desc_cr_'.$loop->iteration, 'KPI Reference (Klik tombol Search) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('kpi_ref_desc_cr_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_cr_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @else 
                        {!! Form::textarea('kpi_ref_desc_cr_'.$loop->iteration, $model->kpi_ref_desc, ['class'=>'form-control', 'placeholder' => 'KPI Reference (Klik tombol Search)', 'rows' => '5', 'style' => 'resize:vertical', 'id' => 'kpi_ref_desc_cr_'.$loop->iteration, 'disabled' => '', 'required']) !!}
                      @endif
                      {!! Form::hidden('kpi_ref_cr_'.$loop->iteration, base64_encode($model->kpi_ref), ['class'=>'form-control', 'id' => 'kpi_ref_cr_'.$loop->iteration, 'readonly'=>'readonly', 'required']) !!}
                      {!! $errors->first('kpi_ref_desc_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-1 pull-left">
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        <button id="btnpopupkpiref_cr_{{ $loop->iteration }}" name="btnpopupkpiref_cr_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'cr')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>
                      @else 
                        <button id="btnpopupkpiref_cr_{{ $loop->iteration }}" name="btnpopupkpiref_cr_{{ $loop->iteration }}" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,'cr')" data-toggle="modal" data-target="#refModal" disabled=""><span class="glyphicon glyphicon-search"></span></button>
                      @endif
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-12 {{ $errors->has('activity_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('activity_cr_'.$loop->iteration, 'Activity (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::textarea('activity_cr_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_cr_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::textarea('activity_cr_'.$loop->iteration, $model->activity, ['class'=>'form-control', 'placeholder' => 'Activity', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'activity_cr_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! Form::hidden('hrdtkpi_cr_id_'.$loop->iteration, base64_encode($model->id), ['class'=>'form-control', 'id' => 'hrdtkpi_cr_id_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                      {!! $errors->first('activity_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->

                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                      <a href="#q1_cr_{{ $loop->iteration }}" aria-controls="q1_cr_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q1
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q2_cr_{{ $loop->iteration }}" aria-controls="q2_cr_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q2
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q3_cr_{{ $loop->iteration }}" aria-controls="q3_cr_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q3
                      </a>
                    </li>
                    <li role="presentation">
                      <a href="#q4_cr_{{ $loop->iteration }}" aria-controls="q4_cr_{{ $loop->iteration }}" role="tab" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> Q4
                      </a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="q1_cr_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q1_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q1_cr_'.$loop->iteration, 'Q1 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q1_cr_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_cr_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q1_cr_'.$loop->iteration, $model->target_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q1_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q1_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q1_cr_'.$loop->iteration, 'Due Date Q1') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q1_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q1_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q1', 'id' => 'tgl_start_q1_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q1_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q1_act_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q1_act_cr_'.$loop->iteration, 'Q1 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q1_act_cr_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q1_act_cr_'.$loop->iteration, $model->target_q1_act, ['class'=>'form-control', 'placeholder' => 'Q1 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q1_act_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q1_act_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q1_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q1_cr_'.$loop->iteration, 'Act Date Q1') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q1_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_cr_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q1_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q1_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q1_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q1', 'id' => 'tgl_start_act_q1_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q1_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q1_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q1_cr_'.$loop->iteration, 'Q1 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q1_cr_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q1_cr_'.$loop->iteration, $model->persen_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q1_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q1_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-6 {{ $errors->has('problem_q1_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('problem_q1_cr_'.$loop->iteration, 'Q1 Problem') !!}
                              @if ($hrdtkpi->status === "APPROVE HRD" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('problem_q1_cr_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('problem_q1_cr_'.$loop->iteration, $model->problem_q1, ['class'=>'form-control', 'placeholder' => 'Q1 Problem', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'problem_q1_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('problem_q1_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q2_cr_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q2_cr_'.$loop->iteration, 'Q2 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q2_cr_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_cr_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q2_cr_'.$loop->iteration, $model->target_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q2_cr_'.$loop->iteration, 'Due Date Q2') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q2_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q2_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q2', 'id' => 'tgl_start_q2_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q2_act_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q2_act_cr_'.$loop->iteration, 'Q2 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q2_act_cr_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q2_act_cr_'.$loop->iteration, $model->target_q2_act, ['class'=>'form-control', 'placeholder' => 'Q2 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q2_act_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q2_act_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q2_cr_'.$loop->iteration, 'Act Date Q2') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q2_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_cr_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q2_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q2_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q2_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q2', 'id' => 'tgl_start_act_q2_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q2_cr_'.$loop->iteration, 'Q2 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q1" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q2_cr_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q2_cr_'.$loop->iteration, $model->persen_q2, ['class'=>'form-control', 'placeholder' => 'Q2 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q2_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q3_cr_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q3_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q3_cr_'.$loop->iteration, 'Q3 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q3_cr_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_cr_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q3_cr_'.$loop->iteration, $model->target_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q3_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q3_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q3_cr_'.$loop->iteration, 'Due Date Q3') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q3_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q3_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q3', 'id' => 'tgl_start_q3_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q3_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q3_act_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q3_act_cr_'.$loop->iteration, 'Q3 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q3_act_cr_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q3_act_cr_'.$loop->iteration, $model->target_q3_act, ['class'=>'form-control', 'placeholder' => 'Q3 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q3_act_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q3_act_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q3_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q3_cr_'.$loop->iteration, 'Act Date Q3') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q3_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_cr_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q3_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q3_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q3_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q3', 'id' => 'tgl_start_act_q3_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q3_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q3_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q3_cr_'.$loop->iteration, 'Q3 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q2" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q3_cr_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q3_cr_'.$loop->iteration, $model->persen_q3, ['class'=>'form-control', 'placeholder' => 'Q3 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q3_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q3_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                    <div role="tabpanel" class="tab-pane" id="q4_cr_{{ $loop->iteration }}">
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-9 {{ $errors->has('target_q4_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('target_q4_cr_'.$loop->iteration, 'Q4 Target') !!}
                            @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                              {!! Form::textarea('target_q4_cr_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_cr_'.$loop->iteration]) !!}
                            @else 
                              {!! Form::textarea('target_q4_cr_'.$loop->iteration, $model->target_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Target', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                            @endif
                            {!! $errors->first('target_q4_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                          <div class="col-sm-3 {{ $errors->has('tgl_start_q4_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                            {!! Form::label('tgl_start_q4_cr_'.$loop->iteration, 'Due Date Q4') !!}
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::text('tgl_start_q4_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::text('tgl_start_q4_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Due Date Q4', 'id' => 'tgl_start_q4_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                            </div>
                            <!-- /.input group -->
                            {!! $errors->first('tgl_start_q4_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                        @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                          <div class="row form-group">
                            <div class="col-sm-9 {{ $errors->has('target_q4_act_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('target_q4_act_cr_'.$loop->iteration, 'Q4 Actual') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::textarea('target_q4_act_cr_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::textarea('target_q4_act_cr_'.$loop->iteration, $model->target_q4_act, ['class'=>'form-control', 'placeholder' => 'Q4 Actual', 'rows' => '3', 'maxlength' => 2000, 'style' => 'resize:vertical', 'id' => 'target_q4_act_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('target_q4_act_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-sm-3 {{ $errors->has('tgl_start_act_q4_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('tgl_start_act_q4_cr_'.$loop->iteration, 'Act Date Q4') !!}
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                  {!! Form::text('tgl_start_act_q4_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_cr_'.$loop->iteration]) !!}
                                @else 
                                  {!! Form::text('tgl_start_act_q4_cr_'.$loop->iteration, \Carbon\Carbon::parse($model->tgl_start_q4_act)->format('d/m/Y')." - ".\Carbon\Carbon::parse($model->tgl_finish_q4_act)->format('d/m/Y'), ['class'=>'form-control pull-right', 'placeholder' => 'Act Date Q4', 'id' => 'tgl_start_act_q4_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                                @endif
                              </div>
                              <!-- /.input group -->
                              {!! $errors->first('tgl_start_act_q4_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                          <div class="row form-group">
                            <div class="col-sm-3 {{ $errors->has('persen_q4_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                              {!! Form::label('persen_q4_cr_'.$loop->iteration, 'Q4 Progress (%)') !!}
                              @if ($hrdtkpi->status === "APPROVE REVIEW Q3" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                                {!! Form::number('persen_q4_cr_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_cr_'.$loop->iteration]) !!}
                              @else 
                                {!! Form::number('persen_q4_cr_'.$loop->iteration, $model->persen_q4, ['class'=>'form-control', 'placeholder' => 'Q4 Progress', 'min'=>'0', 'max'=>'100', 'step'=>'any', 'id' => 'persen_q4_cr_'.$loop->iteration, 'readonly'=>'readonly']) !!}
                              @endif
                              {!! $errors->first('persen_q4_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <!-- /.form-group -->
                        @endif
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.tabpanel -->
                  </div>
                  <!-- /.tab-content -->
                  <hr class="box box-primary">
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('weight_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('weight_cr_'.$loop->iteration, 'Weight (%) (*)') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::number('weight_cr_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_cr_'.$loop->iteration, 'required']) !!}
                      @else 
                        {!! Form::number('weight_cr_'.$loop->iteration, $model->weight, ['class'=>'form-control', 'placeholder' => 'Weight', 'onchange' => 'refreshTotalWeight(this)', 'min'=>'0.1', 'max'=>'100', 'step'=>'any', 'id' => 'weight_cr_'.$loop->iteration, 'required', 'readonly'=>'readonly']) !!}
                      @endif
                      {!! $errors->first('weight_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen_cr_'.$loop->iteration, 'Department in Charge') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen_cr_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_cr_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen_cr_'.$loop->iteration.'[]', $departement->pluck('desc_dep','kd_dep')->all(), $model->departemen, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen_cr_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <!-- /.form-group -->
                  <div class="row form-group">
                    <div class="col-sm-3 {{ $errors->has('total_weight_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('total_weight_cr_'.$loop->iteration, 'Summary Weight (%)') !!}
                      {!! Form::number('total_weight_cr_'.$loop->iteration, $model->total_weight, ['class'=>'form-control', 'placeholder' => 'Summary Weight', 'max'=>'100', 'step'=>'any', 'disabled'=>'', 'id' => 'total_weight_cr_'.$loop->iteration]) !!}
                      {!! $errors->first('total_weight_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-6 {{ $errors->has('departemen2_cr_'.$loop->iteration) ? ' has-error' : '' }}">
                      {!! Form::label('departemen2_cr_'.$loop->iteration, 'Need Support Others Department') !!}
                      @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
                        {!! Form::select('departemen2_cr_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_cr_'.$loop->iteration.'[]']) !!}
                      @else 
                        {!! Form::select('departemen2_cr_'.$loop->iteration.'[]', $departement2->pluck('desc_dep','kd_dep')->all(), $model->departemen2, ['class'=>'form-control select2','multiple'=>'multiple','data-placeholder' => 'Pilih Departemen', 'id' => 'departemen2_cr_'.$loop->iteration.'[]', 'disabled'=>'']) !!}
                      @endif
                      {!! $errors->first('departemen2_cr_'.$loop->iteration, '<p class="help-block">:message</p>') !!}
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
        {!! Form::hidden('jml_row_cr', $hrdtkpi->hrdtKpiActByItem("CR")->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_cr']) !!}
      @else
        {!! Form::hidden('jml_row_cr', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row_cr']) !!}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-body">
      <p class="pull-right">
        @if (!empty($hrdtkpi->id))
          @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
            <button id="addRowCr" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Compliance Reporting"><span class="glyphicon glyphicon-plus"></span> Add Activity Compliance Reporting</button>
            &nbsp;&nbsp;
          @endif
        @else
          <button id="addRowCr" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Add Activity Compliance Reporting"><span class="glyphicon glyphicon-plus"></span> Add Activity Compliance Reporting</button>
          &nbsp;&nbsp;
        @endif
        <button id="nextRowCr" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Back to Financial Performance"><span class="glyphicon glyphicon-arrow-right"></span> Back to Financial Performance</button>
      </p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.tabpanel -->
</div>
<!-- /.tab-content -->

<div class="box-footer">
  @if (!empty($hrdtkpi->id))
    @if ($hrdtkpi->status === "DRAFT" && $hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
      {!! Form::submit('Save as Draft', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
    @elseif ($hrdtkpi->kd_div === Auth::user()->masKaryawan()->kode_div)
      {!! Form::submit('Save KPI', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
    @endif
  @else
    {!! Form::submit('Save as Draft', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
  @endif
  @if (!empty($hrdtkpi->id))
    @if (Auth::user()->can('hrd-kpi-submit'))
      &nbsp;&nbsp;
      <button id="btn-submit" type="button" class="btn btn-success">Submit KPI</button>
    @endif
    @if (Auth::user()->can('hrd-kpi-delete') && $hrdtkpi->status === "DRAFT")
      &nbsp;&nbsp;
      <button id="btn-delete" type="button" class="btn btn-danger">Delete KPI</button>
    @endif
  @endif
  &nbsp;&nbsp;
  <a class="btn btn-primary" href="{{ route('hrdtkpis.index') }}">Cancel</a>
  &nbsp;&nbsp;
  <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
</div>

<!-- Modal Line -->
@include('hr.kpi.popup.refModal')

@section('scripts')
<script type="text/javascript">
  $("#cr").addClass("active");
  $("#lg").addClass("active");
  $("#ip").addClass("active");
  $("#cs").addClass("active");

  function initselect() {
    //Initialize Select2 Elements
    $(".select2").select2();
  }
  initselect();

  $(document).ready(function(){
    $("#cr").removeClass("active");
    $("#lg").removeClass("active");
    $("#ip").removeClass("active");
    $("#cs").removeClass("active");
  });

  function daterangepicker() {
    var yyyy = document.getElementById("year").value.trim();
    var minQ1 = "01/01/" + yyyy;
    var maxQ1 = "31/03/" + yyyy;
    //Date range picker
    $("input[name^='tgl_start_q1_']").daterangepicker(
      {
        minDate: minQ1, 
        maxDate: maxQ1,
        locale: {
          format: 'DD/MM/YYYY'
        }
      }
    );

    var minQ2 = "01/04/" + yyyy;
    var maxQ2 = "30/06/" + yyyy;
    $("input[name^='tgl_start_q2_']").daterangepicker(
      {
        minDate: minQ2, 
        maxDate: maxQ2,
        locale: {
          format: 'DD/MM/YYYY'
        }
      }
    );

    var minQ3 = "01/07/" + yyyy;
    var maxQ3 = "30/09/" + yyyy;
    $("input[name^='tgl_start_q3_']").daterangepicker(
      {
        minDate: minQ3, 
        maxDate: maxQ3,
        locale: {
          format: 'DD/MM/YYYY'
        }
      }
    );

    var minQ4 = "01/10/" + yyyy;
    var maxQ4 = "31/12/" + yyyy;
    $("input[name^='tgl_start_q4_']").daterangepicker(
      {
        minDate: minQ4, 
        maxDate: maxQ4,
        locale: {
          format: 'DD/MM/YYYY'
        }
      }
    );

    $("input[name^='tgl_start_act_']").daterangepicker(
      {
        locale: {
          format: 'DD/MM/YYYY'
        }
      }
    );
  }
  daterangepicker();

  var jml_row_fp = document.getElementById("jml_row_fp").value.trim();
  jml_row_fp = Number(jml_row_fp);
  var jml_row_cs = document.getElementById("jml_row_cs").value.trim();
  jml_row_cs = Number(jml_row_cs);
  var jml_row_ip = document.getElementById("jml_row_ip").value.trim();
  jml_row_ip = Number(jml_row_ip);
  var jml_row_lg = document.getElementById("jml_row_lg").value.trim();
  jml_row_lg = Number(jml_row_lg);
  var jml_row_cr = document.getElementById("jml_row_cr").value.trim();
  jml_row_cr = Number(jml_row_cr);
  if(jml_row_fp > 0) {
    document.getElementById('btnpopupkpiref_fp_1').focus();
  } else if(jml_row_cs > 0) {
    $("#fp").removeClass("active");
    $("#cs").addClass("active");
    $("#nav_fp").removeClass("active");
    $("#nav_cs").addClass("active");
    document.getElementById('btnpopupkpiref_cs_1').focus();
  } else if(jml_row_ip > 0) {
    $("#fp").removeClass("active");
    $("#ip").addClass("active");
    $("#nav_fp").removeClass("active");
    $("#nav_ip").addClass("active");
    document.getElementById('btnpopupkpiref_ip_1').focus();
  } else if(jml_row_lg > 0) {
    $("#fp").removeClass("active");
    $("#lg").addClass("active");
    $("#nav_fp").removeClass("active");
    $("#nav_lg").addClass("active");
    document.getElementById('btnpopupkpiref_lg_1').focus();
  } else if(jml_row_cr > 0) {
    $("#fp").removeClass("active");
    $("#cr").addClass("active");
    $("#nav_fp").removeClass("active");
    $("#nav_cr").addClass("active");
    document.getElementById('btnpopupkpiref_cr_1').focus();
  }

  $("#btn-delete").click(function(){
    var id = document.getElementById("id").value.trim();
    var tahun = document.getElementById("year").value.trim();
    var msg = 'Anda yakin menghapus KPI tahun: ' + tahun + '?';
    var txt = 'data yang sudah di-Submit atau di-Approve tidak bisa dihapus.';
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
      var urlRedirect = "{{ route('hrdtkpis.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', id);
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

  $("#btn-submit").click(function(){
    var valid_data = "T";
    var info = "";

    refreshTotalWeight2();

    var jml_row_fp = document.getElementById("jml_row_fp").value.trim();
    jml_row_fp = Number(jml_row_fp);
    var jml_row_cs = document.getElementById("jml_row_cs").value.trim();
    jml_row_cs = Number(jml_row_cs);
    var jml_row_ip = document.getElementById("jml_row_ip").value.trim();
    jml_row_ip = Number(jml_row_ip);
    var jml_row_lg = document.getElementById("jml_row_lg").value.trim();
    jml_row_lg = Number(jml_row_lg);
    var jml_row_cr = document.getElementById("jml_row_cr").value.trim();
    jml_row_cr = Number(jml_row_cr);

    if(jml_row_fp > 0 || jml_row_cs > 0 || jml_row_ip > 0 || jml_row_lg > 0 || jml_row_cr > 0) {
      for($i = 1; $i <= jml_row_fp; $i++) {
        var id = "total_weight_fp_" + $i;
        var total_weight = document.getElementById(id).value.trim();
        total_weight = Number(total_weight);
        if(total_weight != 100) {
          valid_data = "F";
          info = "Summary Weight (%) belum mencapai 100%!";
        }
      }
      for($i = 1; $i <= jml_row_cs; $i++) {
        var id = "total_weight_cs_" + $i;
        var total_weight = document.getElementById(id).value.trim();
        total_weight = Number(total_weight);
        if(total_weight != 100) {
          valid_data = "F";
          info = "Summary Weight (%) belum mencapai 100%!";
        }
      }
      for($i = 1; $i <= jml_row_ip; $i++) {
        var id = "total_weight_ip_" + $i;
        var total_weight = document.getElementById(id).value.trim();
        total_weight = Number(total_weight);
        if(total_weight != 100) {
          valid_data = "F";
          info = "Summary Weight (%) belum mencapai 100%!";
        }
      }
      for($i = 1; $i <= jml_row_lg; $i++) {
        var id = "total_weight_lg_" + $i;
        var total_weight = document.getElementById(id).value.trim();
        total_weight = Number(total_weight);
        if(total_weight != 100) {
          valid_data = "F";
          info = "Summary Weight (%) belum mencapai 100%!";
        }
      }
      for($i = 1; $i <= jml_row_cr; $i++) {
        var id = "total_weight_cr_" + $i;
        var total_weight = document.getElementById(id).value.trim();
        total_weight = Number(total_weight);
        if(total_weight != 100) {
          valid_data = "F";
          info = "Summary Weight (%) belum mencapai 100%!";
        }
      }
    } else {
      valid_data = "F";
      info = "Summary Weight (%) belum mencapai 100%!";
    }

    if(valid_data === "F") {
      swal(info, "Perhatikan inputan anda!", "warning");
    } else {
      var msg = "Anda yakin submit KPI ini?";
      var txt = "Data yang tidak valid (lengkap) tidak akan diproses.";
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
        document.getElementById("st_input").value = "DIV";
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
      var valid_data = "T";
      var info = "";
      if(valid_data === "F") {
        swal(info, "Perhatikan inputan anda!", "warning");
      } else {
        var msg = "Anda yakin menyimpan KPI ini?";
        var txt = "Data yang tidak valid (lengkap) tidak akan diproses.";
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
          document.getElementById("st_submit").value = "F";
          document.getElementById("st_input").value = "DIV";
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

  function keyPressedTglSelesai(param) {
    if(param === "FP") {
      $("#fp").removeClass("active"); // add class to the one we clicked 
      $("#cs").addClass("active");
      $("#nav_fp").removeClass("active"); // add class to the one we clicked 
      $("#nav_cs").addClass("active");
      var key = "cs";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('btnpopupkpiref_cs_'+no).focus();
      }
    } else if(param === "CS") {
      $("#cs").removeClass("active"); // add class to the one we clicked 
      $("#ip").addClass("active");
      $("#nav_cs").removeClass("active"); // add class to the one we clicked 
      $("#nav_ip").addClass("active");
      var key = "ip";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('btnpopupkpiref_ip_'+no).focus();
      }
    } else if(param === "IP") {
      $("#ip").removeClass("active"); // add class to the one we clicked 
      $("#lg").addClass("active");
      $("#nav_ip").removeClass("active"); // add class to the one we clicked 
      $("#nav_lg").addClass("active");
      var key = "lg";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('btnpopupkpiref_lg_'+no).focus();
      }
    } else if(param === "LG") {
      $("#lg").removeClass("active"); // add class to the one we clicked 
      $("#cr").addClass("active");
      $("#nav_lg").removeClass("active"); // add class to the one we clicked 
      $("#nav_cr").addClass("active");
      var key = "cr";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('btnpopupkpiref_cr_'+no).focus();
      }
    } else if(param === "CR") {
      $("#cr").removeClass("active"); // add class to the one we clicked 
      $("#fp").addClass("active");
      $("#nav_cr").removeClass("active"); // add class to the one we clicked 
      $("#nav_fp").addClass("active");
      var key = "fp";
      var jml_row = document.getElementById("jml_row_"+key).value.trim();
      jml_row = Number(jml_row);
      if(jml_row > 0) {
        var no = jml_row-jml_row+1;
        document.getElementById('btnpopupkpiref_fp_'+no).focus();
      }
    }
  }

  function refreshTotalWeight(ths) {
    var total_weight = 0;
    var jml_row_fp = document.getElementById("jml_row_fp").value.trim();
    jml_row_fp = Number(jml_row_fp);
    for($i = 1; $i <= jml_row_fp; $i++) {
      var id = "weight_fp_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    var jml_row_cs = document.getElementById("jml_row_cs").value.trim();
    jml_row_cs = Number(jml_row_cs);
    for($i = 1; $i <= jml_row_cs; $i++) {
      var id = "weight_cs_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    var jml_row_ip = document.getElementById("jml_row_ip").value.trim();
    jml_row_ip = Number(jml_row_ip);
    for($i = 1; $i <= jml_row_ip; $i++) {
      var id = "weight_ip_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    var jml_row_lg = document.getElementById("jml_row_lg").value.trim();
    jml_row_lg = Number(jml_row_lg);
    for($i = 1; $i <= jml_row_lg; $i++) {
      var id = "weight_lg_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    var jml_row_cr = document.getElementById("jml_row_cr").value.trim();
    jml_row_cr = Number(jml_row_cr);
    for($i = 1; $i <= jml_row_cr; $i++) {
      var id = "weight_cr_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    if(total_weight > 100) {
      var bobot = document.getElementById(ths.id).value.trim();
      bobot = Number(bobot) - (total_weight-100);
      document.getElementById(ths.id).value = bobot;
      document.getElementById(ths.id).focus();
      swal("Summary Weight (%) tidak boleh > 100!", "Perhatikan inputan anda!", "warning");
      total_weight = 100;
    }
    for($i = 1; $i <= jml_row_fp; $i++) {
      var id = "total_weight_fp_" + $i;
      document.getElementById(id).value = total_weight;
    }
    for($i = 1; $i <= jml_row_cs; $i++) {
      var id = "total_weight_cs_" + $i;
      document.getElementById(id).value = total_weight;
    }
    for($i = 1; $i <= jml_row_ip; $i++) {
      var id = "total_weight_ip_" + $i;
      document.getElementById(id).value = total_weight;
    }
    for($i = 1; $i <= jml_row_lg; $i++) {
      var id = "total_weight_lg_" + $i;
      document.getElementById(id).value = total_weight;
    }
    for($i = 1; $i <= jml_row_cr; $i++) {
      var id = "total_weight_cr_" + $i;
      document.getElementById(id).value = total_weight;
    }
  }

  function refreshTotalWeight2() {
    var total_weight = 0;
    var jml_row_fp = document.getElementById("jml_row_fp").value.trim();
    jml_row_fp = Number(jml_row_fp);
    for($i = 1; $i <= jml_row_fp; $i++) {
      var id = "weight_fp_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    var jml_row_cs = document.getElementById("jml_row_cs").value.trim();
    jml_row_cs = Number(jml_row_cs);
    for($i = 1; $i <= jml_row_cs; $i++) {
      var id = "weight_cs_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    var jml_row_ip = document.getElementById("jml_row_ip").value.trim();
    jml_row_ip = Number(jml_row_ip);
    for($i = 1; $i <= jml_row_ip; $i++) {
      var id = "weight_ip_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    var jml_row_lg = document.getElementById("jml_row_lg").value.trim();
    jml_row_lg = Number(jml_row_lg);
    for($i = 1; $i <= jml_row_lg; $i++) {
      var id = "weight_lg_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    var jml_row_cr = document.getElementById("jml_row_cr").value.trim();
    jml_row_cr = Number(jml_row_cr);
    for($i = 1; $i <= jml_row_cr; $i++) {
      var id = "weight_cr_" + $i;
      var weight = document.getElementById(id).value.trim();
      weight = Number(weight);
      total_weight = total_weight + weight;
    }
    for($i = 1; $i <= jml_row_fp; $i++) {
      var id = "total_weight_fp_" + $i;
      document.getElementById(id).value = total_weight;
    }
    for($i = 1; $i <= jml_row_cs; $i++) {
      var id = "total_weight_cs_" + $i;
      document.getElementById(id).value = total_weight;
    }
    for($i = 1; $i <= jml_row_ip; $i++) {
      var id = "total_weight_ip_" + $i;
      document.getElementById(id).value = total_weight;
    }
    for($i = 1; $i <= jml_row_lg; $i++) {
      var id = "total_weight_lg_" + $i;
      document.getElementById(id).value = total_weight;
    }
    for($i = 1; $i <= jml_row_cr; $i++) {
      var id = "total_weight_cr_" + $i;
      document.getElementById(id).value = total_weight;
    }
  }

  $("#addRowFp").click(function(){
    var key = "fp";
    var key_param = "'fp'";
    var jml_row = document.getElementById("jml_row_"+key).value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row_"+key).value = jml_row;
    var kpi_ref = 'kpi_ref_'+key+'_'+jml_row;
    var kpi_ref_desc = 'kpi_ref_desc_'+key+'_'+jml_row;
    var kpi_ref_btn = 'btnpopupkpiref_'+key+'_'+jml_row;
    var activity = 'activity_'+key+'_'+jml_row;
    var hrdtkpi_id = 'hrdtkpi_'+key+'_id_'+jml_row;
    var target_q1 = 'target_q1_'+key+'_'+jml_row;
    var target_q2 = 'target_q2_'+key+'_'+jml_row;
    var target_q3 = 'target_q3_'+key+'_'+jml_row;
    var target_q4 = 'target_q4_'+key+'_'+jml_row;
    var weight = 'weight_'+key+'_'+jml_row;
    var total_weight = 'total_weight_'+key+'_'+jml_row;
    var departemen = 'departemen_'+key+'_'+jml_row + '[]';
    var departemen2 = 'departemen2_'+key+'_'+jml_row + '[]';
    var btndeleteact = 'btndeleteactivity_'+key+'_'+jml_row;
    var id_field = 'field_'+key+'_'+jml_row;
    var id_box = 'box_'+key+'_'+jml_row;
    var tgl_start_q1 = 'tgl_start_q1_'+key+'_'+jml_row;
    var tgl_start_q2 = 'tgl_start_q2_'+key+'_'+jml_row;
    var tgl_start_q3 = 'tgl_start_q3_'+key+'_'+jml_row;
    var tgl_start_q4 = 'tgl_start_q4_'+key+'_'+jml_row;
    var yyyy = document.getElementById("year").value.trim();
    var tglQ1 = "01/01/" + yyyy + " - " + "31/03/" + yyyy;
    var tglQ2 = "01/04/" + yyyy + " - " + "30/06/" + yyyy;
    var tglQ3 = "01/07/" + yyyy + " - " + "30/09/" + yyyy;
    var tglQ4 = "01/10/" + yyyy + " - " + "31/12/" + yyyy;

    var q1 = 'q1_'+key+'_'+jml_row;
    var q1_ref = '#q1_'+key+'_'+jml_row;
    var q2 = 'q2_'+key+'_'+jml_row;
    var q2_ref = '#q2_'+key+'_'+jml_row;
    var q3 = 'q3_'+key+'_'+jml_row;
    var q3_ref = '#q3_'+key+'_'+jml_row;
    var q4 = 'q4_'+key+'_'+jml_row;
    var q4_ref = '#q4_'+key+'_'+jml_row;

    $("#field-fp").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Financial Performance - Activity ('+ jml_row +') (*)</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndeleteact + '" name="' + btndeleteact + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,' + key_param + ')">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-11">\
                  <label name="' + kpi_ref_desc + '">KPI Reference (Klik tombol Search) (*)</label>\
                  <textarea id="' + kpi_ref_desc + '" name="' + kpi_ref_desc + '" required class="form-control" placeholder="KPI Reference (Klik tombol Search)" rows="5" style="resize:vertical" disabled=""></textarea>\
                  <input type="hidden" id="' + kpi_ref + '" name="' + kpi_ref + '" class="form-control" readonly="readonly" required>\
                </div>\
                <div class="col-sm-1 pull-left">\
                  <button id="' + kpi_ref_btn + '" name="' + kpi_ref_btn + '" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,' + key_param + ')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-12">\
                  <label name="' + activity + '">Activity (*)</label>\
                  <textarea id="' + activity + '" name="' + activity + '" required class="form-control" placeholder="Activity" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                  <input type="hidden" id="' + hrdtkpi_id + '" name="' + hrdtkpi_id + '" class="form-control" readonly="readonly" value="0">\
                </div>\
              </div>\
              <ul class="nav nav-tabs" role="tablist">\
                <li role="presentation" class="active">\
                  <a href="' + q1_ref + '" aria-controls="' + q1 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q1\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q2_ref + '" aria-controls="' + q2 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q2\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q3_ref + '" aria-controls="' + q3 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q3\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q4_ref + '" aria-controls="' + q4 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q4\
                  </a>\
                </li>\
              </ul>\
              <div class="tab-content">\
                <div role="tabpanel" class="tab-pane active" id="' + q1 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q1 + '">Q1 Target</label>\
                        <textarea id="' + target_q1 + '" name="' + target_q1 + '" class="form-control" placeholder="Q1 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q1 + '">Due Date Q1</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q1 + '" name="' + tgl_start_q1 + '" class="form-control pull-right" placeholder="Due Date Q1" value="' + tglQ1 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q2 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q2 + '">Q2 Target</label>\
                        <textarea id="' + target_q2 + '" name="' + target_q2 + '" class="form-control" placeholder="Q2 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q2 + '">Due Date Q2</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q2 + '" name="' + tgl_start_q2 + '" class="form-control pull-right" placeholder="Due Date Q2" value="' + tglQ2 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q3 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q3 + '">Q3 Target</label>\
                        <textarea id="' + target_q3 + '" name="' + target_q3 + '" class="form-control" placeholder="Q3 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q3 + '">Due Date Q3</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q3 + '" name="' + tgl_start_q3 + '" class="form-control pull-right" placeholder="Due Date Q3" value="' + tglQ3 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q4 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q4 + '">Q4 Target</label>\
                        <textarea id="' + target_q4 + '" name="' + target_q4 + '" class="form-control" placeholder="Q4 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q4 + '">Due Date Q4</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q4 + '" name="' + tgl_start_q4 + '" class="form-control pull-right" placeholder="Due Date Q4" value="' + tglQ4 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
              </div>\
              <hr class="box box-primary">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + weight + '">Weight (%) (*)</label>\
                  <input type="number" id="' + weight + '" name="' + weight + '" required class="form-control" placeholder="Weight" onchange="refreshTotalWeight(this)" min="0.1" max="100" step="any">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen + '">Department in Charge</label>\
                  <select id="' + departemen + '" name="' + departemen + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + total_weight + '">Summary Weight (%)</label>\
                  <input type="number" id="' + total_weight + '" name="' + total_weight + '" class="form-control" placeholder="Summary Weight" max="100" disabled="">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen2 + '">Need Support Others Department</label>\
                  <select id="' + departemen2 + '" name="' + departemen2 + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement2->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    refreshTotalWeight2();
    daterangepicker();
    $("#cr").addClass("active");
    $("#lg").addClass("active");
    $("#ip").addClass("active");
    $("#cs").addClass("active");
    initselect();
    $("#cr").removeClass("active");
    $("#lg").removeClass("active");
    $("#ip").removeClass("active");
    $("#cs").removeClass("active");
    document.getElementById(kpi_ref_btn).focus();
  });

  $("#nextRowFp").click(function(){
    keyPressedTglSelesai("FP");
  });

  $("#addRowCs").click(function(){
    var key = "cs";
    var key_param = "'cs'";
    var jml_row = document.getElementById("jml_row_"+key).value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row_"+key).value = jml_row;
    var kpi_ref = 'kpi_ref_'+key+'_'+jml_row;
    var kpi_ref_desc = 'kpi_ref_desc_'+key+'_'+jml_row;
    var kpi_ref_btn = 'btnpopupkpiref_'+key+'_'+jml_row;
    var activity = 'activity_'+key+'_'+jml_row;
    var hrdtkpi_id = 'hrdtkpi_'+key+'_id_'+jml_row;
    var target_q1 = 'target_q1_'+key+'_'+jml_row;
    var target_q2 = 'target_q2_'+key+'_'+jml_row;
    var target_q3 = 'target_q3_'+key+'_'+jml_row;
    var target_q4 = 'target_q4_'+key+'_'+jml_row;
    var weight = 'weight_'+key+'_'+jml_row;
    var total_weight = 'total_weight_'+key+'_'+jml_row;
    var departemen = 'departemen_'+key+'_'+jml_row + '[]';
    var departemen2 = 'departemen2_'+key+'_'+jml_row + '[]';
    var btndeleteact = 'btndeleteactivity_'+key+'_'+jml_row;
    var id_field = 'field_'+key+'_'+jml_row;
    var id_box = 'box_'+key+'_'+jml_row;
    var tgl_start_q1 = 'tgl_start_q1_'+key+'_'+jml_row;
    var tgl_start_q2 = 'tgl_start_q2_'+key+'_'+jml_row;
    var tgl_start_q3 = 'tgl_start_q3_'+key+'_'+jml_row;
    var tgl_start_q4 = 'tgl_start_q4_'+key+'_'+jml_row;
    var yyyy = document.getElementById("year").value.trim();
    var tglQ1 = "01/01/" + yyyy + " - " + "31/03/" + yyyy;
    var tglQ2 = "01/04/" + yyyy + " - " + "30/06/" + yyyy;
    var tglQ3 = "01/07/" + yyyy + " - " + "30/09/" + yyyy;
    var tglQ4 = "01/10/" + yyyy + " - " + "31/12/" + yyyy;

    var q1 = 'q1_'+key+'_'+jml_row;
    var q1_ref = '#q1_'+key+'_'+jml_row;
    var q2 = 'q2_'+key+'_'+jml_row;
    var q2_ref = '#q2_'+key+'_'+jml_row;
    var q3 = 'q3_'+key+'_'+jml_row;
    var q3_ref = '#q3_'+key+'_'+jml_row;
    var q4 = 'q4_'+key+'_'+jml_row;
    var q4_ref = '#q4_'+key+'_'+jml_row;

    $("#field-cs").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Customer - Activity ('+ jml_row +') (*)</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndeleteact + '" name="' + btndeleteact + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,' + key_param + ')">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-11">\
                  <label name="' + kpi_ref_desc + '">KPI Reference (Klik tombol Search) (*)</label>\
                  <textarea id="' + kpi_ref_desc + '" name="' + kpi_ref_desc + '" required class="form-control" placeholder="KPI Reference (Klik tombol Search)" rows="5" style="resize:vertical" disabled=""></textarea>\
                  <input type="hidden" id="' + kpi_ref + '" name="' + kpi_ref + '" class="form-control" readonly="readonly" required>\
                </div>\
                <div class="col-sm-1 pull-left">\
                  <button id="' + kpi_ref_btn + '" name="' + kpi_ref_btn + '" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,' + key_param + ')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-12">\
                  <label name="' + activity + '">Activity (*)</label>\
                  <textarea id="' + activity + '" name="' + activity + '" required class="form-control" placeholder="Activity" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                  <input type="hidden" id="' + hrdtkpi_id + '" name="' + hrdtkpi_id + '" class="form-control" readonly="readonly" value="0">\
                </div>\
              </div>\
              <ul class="nav nav-tabs" role="tablist">\
                <li role="presentation" class="active">\
                  <a href="' + q1_ref + '" aria-controls="' + q1 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q1\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q2_ref + '" aria-controls="' + q2 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q2\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q3_ref + '" aria-controls="' + q3 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q3\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q4_ref + '" aria-controls="' + q4 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q4\
                  </a>\
                </li>\
              </ul>\
              <div class="tab-content">\
                <div role="tabpanel" class="tab-pane active" id="' + q1 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q1 + '">Q1 Target</label>\
                        <textarea id="' + target_q1 + '" name="' + target_q1 + '" class="form-control" placeholder="Q1 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q1 + '">Due Date Q1</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q1 + '" name="' + tgl_start_q1 + '" class="form-control pull-right" placeholder="Due Date Q1" value="' + tglQ1 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q2 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q2 + '">Q2 Target</label>\
                        <textarea id="' + target_q2 + '" name="' + target_q2 + '" class="form-control" placeholder="Q2 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q2 + '">Due Date Q2</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q2 + '" name="' + tgl_start_q2 + '" class="form-control pull-right" placeholder="Due Date Q2" value="' + tglQ2 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q3 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q3 + '">Q3 Target</label>\
                        <textarea id="' + target_q3 + '" name="' + target_q3 + '" class="form-control" placeholder="Q3 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q3 + '">Due Date Q3</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q3 + '" name="' + tgl_start_q3 + '" class="form-control pull-right" placeholder="Due Date Q3" value="' + tglQ3 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q4 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q4 + '">Q4 Target</label>\
                        <textarea id="' + target_q4 + '" name="' + target_q4 + '" class="form-control" placeholder="Q4 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q4 + '">Due Date Q4</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q4 + '" name="' + tgl_start_q4 + '" class="form-control pull-right" placeholder="Due Date Q4" value="' + tglQ4 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
              </div>\
              <hr class="box box-primary">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + weight + '">Weight (%) (*)</label>\
                  <input type="number" id="' + weight + '" name="' + weight + '" required class="form-control" placeholder="Weight" onchange="refreshTotalWeight(this)" min="0.1" max="100" step="any">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen + '">Department in Charge</label>\
                  <select id="' + departemen + '" name="' + departemen + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + total_weight + '">Summary Weight (%)</label>\
                  <input type="number" id="' + total_weight + '" name="' + total_weight + '" class="form-control" placeholder="Summary Weight" max="100" disabled="">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen2 + '">Need Support Others Department</label>\
                  <select id="' + departemen2 + '" name="' + departemen2 + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement2->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    refreshTotalWeight2();
    daterangepicker();
    $("#cr").addClass("active");
    $("#lg").addClass("active");
    $("#ip").addClass("active");
    $("#fp").addClass("active");
    initselect();
    $("#cr").removeClass("active");
    $("#lg").removeClass("active");
    $("#ip").removeClass("active");
    $("#fp").removeClass("active");
    document.getElementById(kpi_ref_btn).focus();
  });

  $("#nextRowCs").click(function(){
    keyPressedTglSelesai("CS");
  });

  $("#addRowIp").click(function(){
    var key = "ip";
    var key_param = "'ip'";
    var jml_row = document.getElementById("jml_row_"+key).value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row_"+key).value = jml_row;
    var kpi_ref = 'kpi_ref_'+key+'_'+jml_row;
    var kpi_ref_desc = 'kpi_ref_desc_'+key+'_'+jml_row;
    var kpi_ref_btn = 'btnpopupkpiref_'+key+'_'+jml_row;
    var activity = 'activity_'+key+'_'+jml_row;
    var hrdtkpi_id = 'hrdtkpi_'+key+'_id_'+jml_row;
    var target_q1 = 'target_q1_'+key+'_'+jml_row;
    var target_q2 = 'target_q2_'+key+'_'+jml_row;
    var target_q3 = 'target_q3_'+key+'_'+jml_row;
    var target_q4 = 'target_q4_'+key+'_'+jml_row;
    var weight = 'weight_'+key+'_'+jml_row;
    var total_weight = 'total_weight_'+key+'_'+jml_row;
    var departemen = 'departemen_'+key+'_'+jml_row + '[]';
    var departemen2 = 'departemen2_'+key+'_'+jml_row + '[]';
    var btndeleteact = 'btndeleteactivity_'+key+'_'+jml_row;
    var id_field = 'field_'+key+'_'+jml_row;
    var id_box = 'box_'+key+'_'+jml_row;
    var tgl_start_q1 = 'tgl_start_q1_'+key+'_'+jml_row;
    var tgl_start_q2 = 'tgl_start_q2_'+key+'_'+jml_row;
    var tgl_start_q3 = 'tgl_start_q3_'+key+'_'+jml_row;
    var tgl_start_q4 = 'tgl_start_q4_'+key+'_'+jml_row;
    var yyyy = document.getElementById("year").value.trim();
    var tglQ1 = "01/01/" + yyyy + " - " + "31/03/" + yyyy;
    var tglQ2 = "01/04/" + yyyy + " - " + "30/06/" + yyyy;
    var tglQ3 = "01/07/" + yyyy + " - " + "30/09/" + yyyy;
    var tglQ4 = "01/10/" + yyyy + " - " + "31/12/" + yyyy;

    var q1 = 'q1_'+key+'_'+jml_row;
    var q1_ref = '#q1_'+key+'_'+jml_row;
    var q2 = 'q2_'+key+'_'+jml_row;
    var q2_ref = '#q2_'+key+'_'+jml_row;
    var q3 = 'q3_'+key+'_'+jml_row;
    var q3_ref = '#q3_'+key+'_'+jml_row;
    var q4 = 'q4_'+key+'_'+jml_row;
    var q4_ref = '#q4_'+key+'_'+jml_row;

    $("#field-ip").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Internal Process - Activity ('+ jml_row +') (*)</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndeleteact + '" name="' + btndeleteact + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,' + key_param + ')">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-11">\
                  <label name="' + kpi_ref_desc + '">KPI Reference (Klik tombol Search) (*)</label>\
                  <textarea id="' + kpi_ref_desc + '" name="' + kpi_ref_desc + '" required class="form-control" placeholder="KPI Reference (Klik tombol Search)" rows="5" style="resize:vertical" disabled=""></textarea>\
                  <input type="hidden" id="' + kpi_ref + '" name="' + kpi_ref + '" class="form-control" readonly="readonly" required>\
                </div>\
                <div class="col-sm-1 pull-left">\
                  <button id="' + kpi_ref_btn + '" name="' + kpi_ref_btn + '" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,' + key_param + ')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-12">\
                  <label name="' + activity + '">Activity (*)</label>\
                  <textarea id="' + activity + '" name="' + activity + '" required class="form-control" placeholder="Activity" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                  <input type="hidden" id="' + hrdtkpi_id + '" name="' + hrdtkpi_id + '" class="form-control" readonly="readonly" value="0">\
                </div>\
              </div>\
              <ul class="nav nav-tabs" role="tablist">\
                <li role="presentation" class="active">\
                  <a href="' + q1_ref + '" aria-controls="' + q1 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q1\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q2_ref + '" aria-controls="' + q2 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q2\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q3_ref + '" aria-controls="' + q3 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q3\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q4_ref + '" aria-controls="' + q4 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q4\
                  </a>\
                </li>\
              </ul>\
              <div class="tab-content">\
                <div role="tabpanel" class="tab-pane active" id="' + q1 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q1 + '">Q1 Target</label>\
                        <textarea id="' + target_q1 + '" name="' + target_q1 + '" class="form-control" placeholder="Q1 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q1 + '">Due Date Q1</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q1 + '" name="' + tgl_start_q1 + '" class="form-control pull-right" placeholder="Due Date Q1" value="' + tglQ1 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q2 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q2 + '">Q2 Target</label>\
                        <textarea id="' + target_q2 + '" name="' + target_q2 + '" class="form-control" placeholder="Q2 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q2 + '">Due Date Q2</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q2 + '" name="' + tgl_start_q2 + '" class="form-control pull-right" placeholder="Due Date Q2" value="' + tglQ2 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q3 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q3 + '">Q3 Target</label>\
                        <textarea id="' + target_q3 + '" name="' + target_q3 + '" class="form-control" placeholder="Q3 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q3 + '">Due Date Q3</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q3 + '" name="' + tgl_start_q3 + '" class="form-control pull-right" placeholder="Due Date Q3" value="' + tglQ3 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q4 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q4 + '">Q4 Target</label>\
                        <textarea id="' + target_q4 + '" name="' + target_q4 + '" class="form-control" placeholder="Q4 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q4 + '">Due Date Q4</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q4 + '" name="' + tgl_start_q4 + '" class="form-control pull-right" placeholder="Due Date Q4" value="' + tglQ4 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
              </div>\
              <hr class="box box-primary">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + weight + '">Weight (%) (*)</label>\
                  <input type="number" id="' + weight + '" name="' + weight + '" required class="form-control" placeholder="Weight" onchange="refreshTotalWeight(this)" min="0.1" max="100" step="any">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen + '">Department in Charge</label>\
                  <select id="' + departemen + '" name="' + departemen + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + total_weight + '">Summary Weight (%)</label>\
                  <input type="number" id="' + total_weight + '" name="' + total_weight + '" class="form-control" placeholder="Summary Weight" max="100" disabled="">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen2 + '">Need Support Others Department</label>\
                  <select id="' + departemen2 + '" name="' + departemen2 + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement2->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    refreshTotalWeight2();
    daterangepicker();
    $("#cr").addClass("active");
    $("#lg").addClass("active");
    $("#cs").addClass("active");
    $("#fp").addClass("active");
    initselect();
    $("#cr").removeClass("active");
    $("#lg").removeClass("active");
    $("#cs").removeClass("active");
    $("#fp").removeClass("active");
    document.getElementById(kpi_ref_btn).focus();
  });

  $("#nextRowIp").click(function(){
    keyPressedTglSelesai("IP");
  });

  $("#addRowLg").click(function(){
    var key = "lg";
    var key_param = "'lg'";
    var jml_row = document.getElementById("jml_row_"+key).value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row_"+key).value = jml_row;
    var kpi_ref = 'kpi_ref_'+key+'_'+jml_row;
    var kpi_ref_desc = 'kpi_ref_desc_'+key+'_'+jml_row;
    var kpi_ref_btn = 'btnpopupkpiref_'+key+'_'+jml_row;
    var activity = 'activity_'+key+'_'+jml_row;
    var hrdtkpi_id = 'hrdtkpi_'+key+'_id_'+jml_row;
    var target_q1 = 'target_q1_'+key+'_'+jml_row;
    var target_q2 = 'target_q2_'+key+'_'+jml_row;
    var target_q3 = 'target_q3_'+key+'_'+jml_row;
    var target_q4 = 'target_q4_'+key+'_'+jml_row;
    var weight = 'weight_'+key+'_'+jml_row;
    var total_weight = 'total_weight_'+key+'_'+jml_row;
    var departemen = 'departemen_'+key+'_'+jml_row + '[]';
    var departemen2 = 'departemen2_'+key+'_'+jml_row + '[]';
    var btndeleteact = 'btndeleteactivity_'+key+'_'+jml_row;
    var id_field = 'field_'+key+'_'+jml_row;
    var id_box = 'box_'+key+'_'+jml_row;
    var tgl_start_q1 = 'tgl_start_q1_'+key+'_'+jml_row;
    var tgl_start_q2 = 'tgl_start_q2_'+key+'_'+jml_row;
    var tgl_start_q3 = 'tgl_start_q3_'+key+'_'+jml_row;
    var tgl_start_q4 = 'tgl_start_q4_'+key+'_'+jml_row;
    var yyyy = document.getElementById("year").value.trim();
    var tglQ1 = "01/01/" + yyyy + " - " + "31/03/" + yyyy;
    var tglQ2 = "01/04/" + yyyy + " - " + "30/06/" + yyyy;
    var tglQ3 = "01/07/" + yyyy + " - " + "30/09/" + yyyy;
    var tglQ4 = "01/10/" + yyyy + " - " + "31/12/" + yyyy;

    var q1 = 'q1_'+key+'_'+jml_row;
    var q1_ref = '#q1_'+key+'_'+jml_row;
    var q2 = 'q2_'+key+'_'+jml_row;
    var q2_ref = '#q2_'+key+'_'+jml_row;
    var q3 = 'q3_'+key+'_'+jml_row;
    var q3_ref = '#q3_'+key+'_'+jml_row;
    var q4 = 'q4_'+key+'_'+jml_row;
    var q4_ref = '#q4_'+key+'_'+jml_row;

    $("#field-lg").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Learning & Growth - Activity ('+ jml_row +') (*)</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndeleteact + '" name="' + btndeleteact + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,' + key_param + ')">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-11">\
                  <label name="' + kpi_ref_desc + '">KPI Reference (Klik tombol Search) (*)</label>\
                  <textarea id="' + kpi_ref_desc + '" name="' + kpi_ref_desc + '" required class="form-control" placeholder="KPI Reference (Klik tombol Search)" rows="5" style="resize:vertical" disabled=""></textarea>\
                  <input type="hidden" id="' + kpi_ref + '" name="' + kpi_ref + '" class="form-control" readonly="readonly" required>\
                </div>\
                <div class="col-sm-1 pull-left">\
                  <button id="' + kpi_ref_btn + '" name="' + kpi_ref_btn + '" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,' + key_param + ')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-12">\
                  <label name="' + activity + '">Activity (*)</label>\
                  <textarea id="' + activity + '" name="' + activity + '" required class="form-control" placeholder="Activity" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                  <input type="hidden" id="' + hrdtkpi_id + '" name="' + hrdtkpi_id + '" class="form-control" readonly="readonly" value="0">\
                </div>\
              </div>\
              <ul class="nav nav-tabs" role="tablist">\
                <li role="presentation" class="active">\
                  <a href="' + q1_ref + '" aria-controls="' + q1 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q1\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q2_ref + '" aria-controls="' + q2 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q2\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q3_ref + '" aria-controls="' + q3 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q3\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q4_ref + '" aria-controls="' + q4 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q4\
                  </a>\
                </li>\
              </ul>\
              <div class="tab-content">\
                <div role="tabpanel" class="tab-pane active" id="' + q1 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q1 + '">Q1 Target</label>\
                        <textarea id="' + target_q1 + '" name="' + target_q1 + '" class="form-control" placeholder="Q1 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q1 + '">Due Date Q1</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q1 + '" name="' + tgl_start_q1 + '" class="form-control pull-right" placeholder="Due Date Q1" value="' + tglQ1 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q2 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q2 + '">Q2 Target</label>\
                        <textarea id="' + target_q2 + '" name="' + target_q2 + '" class="form-control" placeholder="Q2 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q2 + '">Due Date Q2</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q2 + '" name="' + tgl_start_q2 + '" class="form-control pull-right" placeholder="Due Date Q2" value="' + tglQ2 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q3 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q3 + '">Q3 Target</label>\
                        <textarea id="' + target_q3 + '" name="' + target_q3 + '" class="form-control" placeholder="Q3 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q3 + '">Due Date Q3</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q3 + '" name="' + tgl_start_q3 + '" class="form-control pull-right" placeholder="Due Date Q3" value="' + tglQ3 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q4 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q4 + '">Q4 Target</label>\
                        <textarea id="' + target_q4 + '" name="' + target_q4 + '" class="form-control" placeholder="Q4 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q4 + '">Due Date Q4</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q4 + '" name="' + tgl_start_q4 + '" class="form-control pull-right" placeholder="Due Date Q4" value="' + tglQ4 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
              </div>\
              <hr class="box box-primary">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + weight + '">Weight (%) (*)</label>\
                  <input type="number" id="' + weight + '" name="' + weight + '" required class="form-control" placeholder="Weight" onchange="refreshTotalWeight(this)" min="0.1" max="100" step="any">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen + '">Department in Charge</label>\
                  <select id="' + departemen + '" name="' + departemen + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + total_weight + '">Summary Weight (%)</label>\
                  <input type="number" id="' + total_weight + '" name="' + total_weight + '" class="form-control" placeholder="Summary Weight" max="100" disabled="">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen2 + '">Need Support Others Department</label>\
                  <select id="' + departemen2 + '" name="' + departemen2 + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement2->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    refreshTotalWeight2();
    daterangepicker();
    $("#cr").addClass("active");
    $("#ip").addClass("active");
    $("#cs").addClass("active");
    $("#fp").addClass("active");
    initselect();
    $("#cr").removeClass("active");
    $("#ip").removeClass("active");
    $("#cs").removeClass("active");
    $("#fp").removeClass("active");
    document.getElementById(kpi_ref_btn).focus();
  });

  $("#nextRowLg").click(function(){
    keyPressedTglSelesai("LG");
  });

  $("#addRowCr").click(function(){
    var key = "cr";
    var key_param = "'cr'";
    var jml_row = document.getElementById("jml_row_"+key).value.trim();
    jml_row = Number(jml_row) + 1;
    document.getElementById("jml_row_"+key).value = jml_row;
    var kpi_ref = 'kpi_ref_'+key+'_'+jml_row;
    var kpi_ref_desc = 'kpi_ref_desc_'+key+'_'+jml_row;
    var kpi_ref_btn = 'btnpopupkpiref_'+key+'_'+jml_row;
    var activity = 'activity_'+key+'_'+jml_row;
    var hrdtkpi_id = 'hrdtkpi_'+key+'_id_'+jml_row;
    var target_q1 = 'target_q1_'+key+'_'+jml_row;
    var target_q2 = 'target_q2_'+key+'_'+jml_row;
    var target_q3 = 'target_q3_'+key+'_'+jml_row;
    var target_q4 = 'target_q4_'+key+'_'+jml_row;
    var weight = 'weight_'+key+'_'+jml_row;
    var total_weight = 'total_weight_'+key+'_'+jml_row;
    var departemen = 'departemen_'+key+'_'+jml_row + '[]';
    var departemen2 = 'departemen2_'+key+'_'+jml_row + '[]';
    var btndeleteact = 'btndeleteactivity_'+key+'_'+jml_row;
    var id_field = 'field_'+key+'_'+jml_row;
    var id_box = 'box_'+key+'_'+jml_row;
    var tgl_start_q1 = 'tgl_start_q1_'+key+'_'+jml_row;
    var tgl_start_q2 = 'tgl_start_q2_'+key+'_'+jml_row;
    var tgl_start_q3 = 'tgl_start_q3_'+key+'_'+jml_row;
    var tgl_start_q4 = 'tgl_start_q4_'+key+'_'+jml_row;
    var yyyy = document.getElementById("year").value.trim();
    var tglQ1 = "01/01/" + yyyy + " - " + "31/03/" + yyyy;
    var tglQ2 = "01/04/" + yyyy + " - " + "30/06/" + yyyy;
    var tglQ3 = "01/07/" + yyyy + " - " + "30/09/" + yyyy;
    var tglQ4 = "01/10/" + yyyy + " - " + "31/12/" + yyyy;

    var q1 = 'q1_'+key+'_'+jml_row;
    var q1_ref = '#q1_'+key+'_'+jml_row;
    var q2 = 'q2_'+key+'_'+jml_row;
    var q2_ref = '#q2_'+key+'_'+jml_row;
    var q3 = 'q3_'+key+'_'+jml_row;
    var q3_ref = '#q3_'+key+'_'+jml_row;
    var q4 = 'q4_'+key+'_'+jml_row;
    var q4_ref = '#q4_'+key+'_'+jml_row;

    $("#field-cr").append(
      '<div class="row" id="'+id_field+'">\
        <div class="col-md-12">\
          <div class="box box-primary">\
            <div class="box-header with-border">\
              <h3 class="box-title" id="'+id_box+'">Compliance Reporting - Activity ('+ jml_row +') (*)</h3>\
              <div class="box-tools pull-right">\
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">\
                  <i class="fa fa-minus"></i>\
                </button>\
                <button id="' + btndeleteact + '" name="' + btndeleteact + '" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Activity" onclick="deleteActivity(this,' + key_param + ')">\
                  <i class="fa fa-times"></i>\
                </button>\
              </div>\
            </div>\
            <div class="box-body">\
              <div class="row form-group">\
                <div class="col-sm-11">\
                  <label name="' + kpi_ref_desc + '">KPI Reference (Klik tombol Search) (*)</label>\
                  <textarea id="' + kpi_ref_desc + '" name="' + kpi_ref_desc + '" required class="form-control" placeholder="KPI Reference (Klik tombol Search)" rows="5" style="resize:vertical" disabled=""></textarea>\
                  <input type="hidden" id="' + kpi_ref + '" name="' + kpi_ref + '" class="form-control" readonly="readonly" required>\
                </div>\
                <div class="col-sm-1 pull-left">\
                  <button id="' + kpi_ref_btn + '" name="' + kpi_ref_btn + '" type="button" class="btn btn-info" title="Pilih KPI Reference" onclick="popupKpiRef(this,' + key_param + ')" data-toggle="modal" data-target="#refModal"><span class="glyphicon glyphicon-search"></span></button>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-12">\
                  <label name="' + activity + '">Activity (*)</label>\
                  <textarea id="' + activity + '" name="' + activity + '" required class="form-control" placeholder="Activity" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                  <input type="hidden" id="' + hrdtkpi_id + '" name="' + hrdtkpi_id + '" class="form-control" readonly="readonly" value="0">\
                </div>\
              </div>\
              <ul class="nav nav-tabs" role="tablist">\
                <li role="presentation" class="active">\
                  <a href="' + q1_ref + '" aria-controls="' + q1 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q1\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q2_ref + '" aria-controls="' + q2 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q2\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q3_ref + '" aria-controls="' + q3 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q3\
                  </a>\
                </li>\
                <li role="presentation">\
                  <a href="' + q4_ref + '" aria-controls="' + q4 + '" role="tab" data-toggle="tab">\
                    <i class="fa fa-pencil-square-o"></i> Q4\
                  </a>\
                </li>\
              </ul>\
              <div class="tab-content">\
                <div role="tabpanel" class="tab-pane active" id="' + q1 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q1 + '">Q1 Target</label>\
                        <textarea id="' + target_q1 + '" name="' + target_q1 + '" class="form-control" placeholder="Q1 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q1 + '">Due Date Q1</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q1 + '" name="' + tgl_start_q1 + '" class="form-control pull-right" placeholder="Due Date Q1" value="' + tglQ1 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q2 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q2 + '">Q2 Target</label>\
                        <textarea id="' + target_q2 + '" name="' + target_q2 + '" class="form-control" placeholder="Q2 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q2 + '">Due Date Q2</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q2 + '" name="' + tgl_start_q2 + '" class="form-control pull-right" placeholder="Due Date Q2" value="' + tglQ2 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q3 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q3 + '">Q3 Target</label>\
                        <textarea id="' + target_q3 + '" name="' + target_q3 + '" class="form-control" placeholder="Q3 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q3 + '">Due Date Q3</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q3 + '" name="' + tgl_start_q3 + '" class="form-control pull-right" placeholder="Due Date Q3" value="' + tglQ3 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
                <div role="tabpanel" class="tab-pane" id="' + q4 + '">\
                  <div class="box-body">\
                    <div class="row form-group">\
                      <div class="col-sm-9">\
                        <label name="' + target_q4 + '">Q4 Target</label>\
                        <textarea id="' + target_q4 + '" name="' + target_q4 + '" class="form-control" placeholder="Q4 Target" rows="3" maxlength="2000" style="resize:vertical"></textarea>\
                      </div>\
                      <div class="col-sm-3">\
                        <label name="' + tgl_start_q4 + '">Due Date Q4</label>\
                        <div class="input-group">\
                          <div class="input-group-addon">\
                            <i class="fa fa-calendar"></i>\
                          </div>\
                          <input type="text" id="' + tgl_start_q4 + '" name="' + tgl_start_q4 + '" class="form-control pull-right" placeholder="Due Date Q4" value="' + tglQ4 + '">\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
              </div>\
              <hr class="box box-primary">\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + weight + '">Weight (%) (*)</label>\
                  <input type="number" id="' + weight + '" name="' + weight + '" required class="form-control" placeholder="Weight" onchange="refreshTotalWeight(this)" min="0.1" max="100" step="any">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen + '">Department in Charge</label>\
                  <select id="' + departemen + '" name="' + departemen + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
              <div class="row form-group">\
                <div class="col-sm-3">\
                  <label name="' + total_weight + '">Summary Weight (%)</label>\
                  <input type="number" id="' + total_weight + '" name="' + total_weight + '" class="form-control" placeholder="Summary Weight" max="100" disabled="">\
                </div>\
                <div class="col-sm-6">\
                  <label name="' + departemen2 + '">Need Support Others Department</label>\
                  <select id="' + departemen2 + '" name="' + departemen2 + '" class="form-control select2" multiple="multiple" data-placeholder="Pilih Departemen">\
                    @foreach($departement2->get() as $dep)\
                      <option value="{{$dep->kd_dep}}">{{$dep->desc_dep}}</option>\
                    @endforeach\
                  </select>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );

    refreshTotalWeight2();
    daterangepicker();
    $("#lg").addClass("active");
    $("#ip").addClass("active");
    $("#cs").addClass("active");
    $("#fp").addClass("active");
    initselect();
    $("#lg").removeClass("active");
    $("#ip").removeClass("active");
    $("#cs").removeClass("active");
    $("#fp").removeClass("active");
    document.getElementById(kpi_ref_btn).focus();
  });

  $("#nextRowCr").click(function(){
    keyPressedTglSelesai("CR");
  });

  function deleteActivity(ths, param) {
    if(param === "fp" || param === "cs" || param === "ip" || param === "lg" || param === "cr") {
      var msg = 'Anda yakin menghapus Activity ini?';
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
        var row = ths.id.replace('btndeleteactivity_' + param + '_', '');
        var info = "";
        var info2 = "";
        var info3 = "warning";
        var id_hrdtkpi = "hrdtkpi_" + param + "_id_" + row;
        var id_hrdtkpi_value = document.getElementById(id_hrdtkpi).value.trim();

        if(id_hrdtkpi_value === "0" || id_hrdtkpi_value === "") {
          changeId(param, row);
        } else {
          //DELETE DI DATABASE
          // remove these events;
          window.onkeydown = null;
          window.onfocus = null;
          var token = document.getElementsByName('_token')[0].value.trim();
          // delete via ajax
          // hapus data detail dengan ajax
          var url = "{{ route('hrdtkpiacts.destroy', 'param') }}";
          url = url.replace('param', id_hrdtkpi_value);
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
                changeId(param, row);
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
  }

  function changeId(param, row) {
    var id_div = "#field_" + param + "_" + row;
    $(id_div).remove();
    var jml_row = document.getElementById("jml_row_"+param).value.trim();
    jml_row = Number(jml_row);
    nextRow = Number(row) + 1;
    for($i = nextRow; $i <= jml_row; $i++) {
      var kpi_ref = "#kpi_ref_" + param + "_" + $i;
      var kpi_ref_new = "kpi_ref_" + param + "_" + ($i-1);
      $(kpi_ref).attr({"id":kpi_ref_new, "name":kpi_ref_new});
      var kpi_ref_desc = "#kpi_ref_desc_" + param + "_" + $i;
      var kpi_ref_desc_new = "kpi_ref_desc_" + param + "_" + ($i-1);
      $(kpi_ref_desc).attr({"id":kpi_ref_desc_new, "name":kpi_ref_desc_new});
      var kpi_ref_btn = "#btnpopupkpiref_" + param + "_" + $i;
      var kpi_ref_btn_new = "btnpopupkpiref_" + param + "_" + ($i-1);
      $(kpi_ref_btn).attr({"id":kpi_ref_btn_new, "name":kpi_ref_btn_new});
      var activity = "#activity_" + param + "_" + $i;
      var activity_new = "activity_" + param + "_" + ($i-1);
      $(activity).attr({"id":activity_new, "name":activity_new});
      var hrdtkpi_id = "#hrdtkpi_" + param + "_id_" + $i;
      var hrdtkpi_id_new = "hrdtkpi_" + param + "_id_" + ($i-1);
      $(hrdtkpi_id).attr({"id":hrdtkpi_id_new, "name":hrdtkpi_id_new});
      var target_q1 = "#target_q1_" + param + "_" + $i;
      var target_q1_new = "target_q1_" + param + "_" + ($i-1);
      $(target_q1).attr({"id":target_q1_new, "name":target_q1_new});
      var target_q2 = "#target_q2_" + param + "_" + $i;
      var target_q2_new = "target_q2_" + param + "_" + ($i-1);
      $(target_q2).attr({"id":target_q2_new, "name":target_q2_new});
      var target_q3 = "#target_q3_" + param + "_" + $i;
      var target_q3_new = "target_q3_" + param + "_" + ($i-1);
      $(target_q3).attr({"id":target_q3_new, "name":target_q3_new});
      var target_q4 = "#target_q4_" + param + "_" + $i;
      var target_q4_new = "target_q4_" + param + "_" + ($i-1);
      $(target_q4).attr({"id":target_q4_new, "name":target_q4_new});
      var weight = "#weight_" + param + "_" + $i;
      var weight_new = "weight_" + param + "_" + ($i-1);
      $(weight).attr({"id":weight_new, "name":weight_new});
      var total_weight = "#total_weight_" + param + "_" + $i;
      var total_weight_new = "total_weight_" + param + "_" + ($i-1);
      $(total_weight).attr({"id":total_weight_new, "name":total_weight_new});
      var departemen = document.getElementById("departemen_" + param + "_" + $i + "[]");
      var departemen_new = "departemen_" + param + "_" + ($i-1) + "[]";
      departemen.id = departemen_new;
      departemen.name = departemen_new;
      var departemen2 = document.getElementById("departemen2_" + param + "_" + $i + "[]");
      var departemen2_new = "departemen2_" + param + "_" + ($i-1) + "[]";
      departemen2.id = departemen2_new;
      departemen2.name = departemen2_new;
      var btndeleteact = "#btndeleteactivity_" + param + "_" + $i;
      var btndeleteact_new = "btndeleteactivity_" + param + "_" + ($i-1);
      $(btndeleteact).attr({"id":btndeleteact_new, "name":btndeleteact_new});
      var id_field = "#field_" + param + "_" + $i;
      var id_field_new = "field_" + param + "_" + ($i-1);
      $(id_field).attr({"id":id_field_new, "name":id_field_new});
      var id_box = "#box_" + param + "_" + $i;
      var id_box_new = "box_" + param + "_" + ($i-1);
      $(id_box).attr({"id":id_box_new, "name":id_box_new});
      var text = document.getElementById(id_box_new).innerHTML;
      text = text.replace($i, ($i-1));
      document.getElementById(id_box_new).innerHTML = text;
      //$(id).attr('id', 'dvDemoNew'); //change id
      //$(id).attr('name', 'dvDemoNew'); //change name
      var tgl_start_q1 = "#tgl_start_q1_" + param + "_" + $i;
      var tgl_start_q1_new = "tgl_start_q1_" + param + "_" + ($i-1);
      $(tgl_start_q1).attr({"id":tgl_start_q1_new, "name":tgl_start_q1_new});
      var tgl_start_q2 = "#tgl_start_q2_" + param + "_" + $i;
      var tgl_start_q2_new = "tgl_start_q2_" + param + "_" + ($i-1);
      $(tgl_start_q2).attr({"id":tgl_start_q2_new, "name":tgl_start_q2_new});
      var tgl_start_q3 = "#tgl_start_q3_" + param + "_" + $i;
      var tgl_start_q3_new = "tgl_start_q3_" + param + "_" + ($i-1);
      $(tgl_start_q3).attr({"id":tgl_start_q3_new, "name":tgl_start_q3_new});
      var tgl_start_q4 = "#tgl_start_q4_" + param + "_" + $i;
      var tgl_start_q4_new = "tgl_start_q4_" + param + "_" + ($i-1);
      $(tgl_start_q4).attr({"id":tgl_start_q4_new, "name":tgl_start_q4_new});


      var q1 = "q1_" + param + "_" + $i;
      var q1_ref = "#q1_" + param + "_" + $i;
      var q1_new = "q1_" + param + "_" + ($i-1);
      var q1_ref_new = "#q1_" + param + "_" + ($i-1);
      $(q1_ref).attr({"href":q1_ref_new, "aria-controls":q1_new});

      var q2 = "q2_" + param + "_" + $i;
      var q2_ref = "#q2_" + param + "_" + $i;
      var q2_new = "q2_" + param + "_" + ($i-1);
      var q2_ref_new = "#q2_" + param + "_" + ($i-1);
      $(q2_ref).attr({"href":q2_ref_new, "aria-controls":q2_new});

      var q3 = "q3_" + param + "_" + $i;
      var q3_ref = "#q3_" + param + "_" + $i;
      var q3_new = "q3_" + param + "_" + ($i-1);
      var q3_ref_new = "#q3_" + param + "_" + ($i-1);
      $(q3_ref).attr({"href":q3_ref_new, "aria-controls":q3_new});

      var q4 = "q4_" + param + "_" + $i;
      var q4_ref = "#q4_" + param + "_" + $i;
      var q4_new = "q4_" + param + "_" + ($i-1);
      var q4_ref_new = "#q4_" + param + "_" + ($i-1);
      $(q4_ref).attr({"href":q4_ref_new, "aria-controls":q4_new});
    
      daterangepicker();
      initselect();
    }
    jml_row = jml_row - 1;
    document.getElementById("jml_row_"+param).value = jml_row;
  }

  function popupKpiRef(ths, param) {
    var myHeading = "<p>Popup KPI Reference</p>";
    $("#refModalLabel").html(myHeading);

    var year = document.getElementById("year").value.trim();
    var kd_pt = "{{ config('app.kd_pt', 'XXX') }}";

    var url = '{{ route('datatables.popupKpiRefs', ['param', 'param2']) }}';
    url = url.replace('param2', window.btoa(kd_pt));
    url = url.replace('param', window.btoa(year));
    var lookupRef = $('#lookupRef').DataTable({
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
      "order": [[7, 'asc']],
      columns: [
        { data: 'strategy_priority', name: 'strategy_priority'},
        { data: 'strategy', name: 'strategy'},
        { data: 'coy_kpi', name: 'coy_kpi'},
        { data: 'target', name: 'target'},
        { data: 'initiatives', name: 'initiatives'},
        { data: 'div', name: 'div'},
        { data: 'due_date', name: 'due_date'},
        { data: 'id', name: 'id', className: "none"}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupRef tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupRef.rows(rows).data();
          $.each($(rowData),function(key,value){
            var row = ths.id.replace('btnpopupkpiref_' + param + '_', '');
            var id_kpi_ref = "kpi_ref_" + param + "_" + row;
            var id_kpi_ref_desc = "kpi_ref_desc_" + param + "_" + row;
            document.getElementById(id_kpi_ref).value = window.btoa(value["id"]);
            document.getElementById(id_kpi_ref_desc).value = "Strategy Priority: " + value["strategy_priority"] + "\nStrategy: " + value["strategy"] + "\nCOY KPI: " + value["coy_kpi"] + "\nTarget: " + value["target"] + "\nInitiatives: " + value["initiatives"] + "\nDIV: " + value["div"] + "\nDue Date: " + value["due_date"];
            $('#refModal').modal('hide');
          });
        });
        $('#refModal').on('hidden.bs.modal', function () {
          var row = ths.id.replace('btnpopupkpiref_' + param + '_', '');
          var id_kpi_ref = "kpi_ref_" + param + "_" + row;
          var id_kpi_ref_desc = "kpi_ref_desc_" + param + "_" + row;
          var id_activity = "activity_" + param + "_" + row;
          var kpi_ref = document.getElementById(id_kpi_ref).value.trim();
          if(kpi_ref === '') {
            document.getElementById(id_kpi_ref).value = "";
            document.getElementById(id_kpi_ref_desc).value = "";
            document.getElementById(ths).focus();
          } else {
            document.getElementById(id_activity).focus();
          }
        });
      },
    });
  }
</script>
@endsection